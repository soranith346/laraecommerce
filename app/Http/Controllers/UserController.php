<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductCart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
            $client = Order::with('user')->get();
            if(Auth::check() && Auth::user()->user_type == 'user'){
                return view('dashboard');
            }   
            else if(Auth::check() && Auth::user()->user_type == 'admin'){
                $totalClients = User::where('user_type', 'user')->count();
                $totalInvoices = Order::count();
                $clientTarget = 500;
                $invoiceTarget = 1000;
                $clientProgress = ($totalClients / $clientTarget) * 100;
                $invoiceProgress = ($totalInvoices / $invoiceTarget) * 100;
                return view('admin.dashboard', compact('totalClients', 'totalInvoices', 'clientProgress', 'invoiceProgress'));
                
            }
    }
    public function allProducts(Request $request)
{
    // Fetches 4 products and returns paginated JSON
    $products = Product::latest()->paginate(4);
    return response()->json($products);
}
    public function home(){
        if(Auth::check()){
            $count = ProductCart::where('user_id', Auth::id())->sum('quantity');
        }
        else{
            $count = "";
        }
        // dd($count);
        $latest_products = Product::orderBy('created_at', 'desc')->take(8)->get();
        return view('index', compact('latest_products', 'count'));
}
    public function show($id){
    // Find the product by ID or return a 404 error if not found
    if(Auth::check()){
            $count = ProductCart::where('user_id', Auth::id())->sum('quantity');
        }
        else{
            $count = "";
        }
        $product = Product::findOrFail($id);
        return view('product_details', compact('product' , 'count'));
    }
    public function addToCart(Request $request)
    {
        // ពិនិត្យថា តើ user បាន login ឬនៅ?
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'សូមចូលប្រើប្រាស់ (Login) ជាមុនសិន!'], 401);
        }

        $userId = Auth::id();
        $productId = $request->product_id;
        $quantity = $request->quantity;

        $cartItem = ProductCart::where('user_id', $userId)
                               ->where('product_id', $productId)
                               ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            ProductCart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Add to cart successfully']);
    }

    // Show Card Product
    public function cartProduct(){
        if(Auth::check()){
            $count = ProductCart::where('user_id', Auth::id())->sum('quantity');
            $productCart = Productcart::all();
            $totalPrice = 0;
            foreach($productCart as $cart){
                $totalPrice += $cart->product->price * $cart-> quantity;
            }
        }
        else{
            $count = "";
        }

        return view('cartproduct', compact( 'count','productCart' , 'totalPrice'));
    }
    
    // remove Cart
    public function removeCart($id) {
    // ១. ស្វែងរកទិន្នន័យ Cart
    $cart = ProductCart::find($id);

    if ($cart) {
        $userId = $cart->user_id; 
        $cart->delete();

        // គណនាតម្លៃសរុបថ្មី (ប្រើ $userId ដែលយើងចាប់បានអម្បាញ់មិញ)
        $newTotal = ProductCart::where('user_id', $userId)->with('product')->get()->sum(function($item) {
        // គុណបរិមាណ នឹងតម្លៃផលិតផលចេញពី Relationship
                return $item->quantity * $item->product->price;
            });

        return response()->json([
            'success' => true,
            'tr'      => 'tr_' . $id,
            'message' => 'Product removed successfully!',
            'newTotal' => number_format($newTotal, 2)
        ]);
    }

    return response()->json(['success' => false, 'message' => 'Item not found!'], 404);
}
    public function confirmOrder(Request $request) {
        $userId = Auth::id();

        $cartItems = ProductCart::where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'កន្ត្រកទំនិញរបស់អ្នកទទេ!');
        }

        try {
            return DB::transaction(function () use ($request, $userId, $cartItems) {
                // ២. បង្កើត Order មេ
                $order = Order::create([
                    'user_id' => $userId,
                    'receiver_address' => $request->receiver_address,
                    'receiver_phone' => $request->receiver_phone,
                    'total_amount' => 0, // នឹង Update ក្រោយបញ្ចូល Item រួច
                ]);

                $totalPrice = 0;

                // ៣. រុញទំនិញពី Cart ទៅកាន់ Order Items
                foreach ($cartItems as $item) {
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $item->product_id,
                        'quantity'   => $item->quantity ?? 1,
                        'price'      => $item->product->price, // ត្រូវប្រាកដថា Model Cart មាន relationship ទៅ Product
                    ]);
                    $totalPrice += ($item->product->price * ($item->quantity ?? 1));
                }

                // ៤. Update តម្លៃសរុបក្នុង Order
                $order->update(['total_amount' => $totalPrice]);

                // ៥. លុប Cart ចោល
                ProductCart::where('user_id', $userId)->delete();

                return redirect()->route('order.payment', $order->id)->with('message', 'Order Success!');
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error ' . $e->getMessage());
        }
    }
    
    public function myOrders(){
        $myorder = Order::with(['user' , 'items'])->where('user_id' , Auth::id())->get();
        
        return view('myorders' , compact('myorder') );
    }

    public function allProduct(){
        if(Auth::check()){
            $count = ProductCart::where('user_id', Auth::id())->sum('quantity');
        }
        else{
            $count = "";
        }
    // ទាញយក Category ទាំងអស់ដែលមានផលិតផល (status = 1)
    // យើងប្រើជាមួយ Relationship ឬប្រើ Query ផ្ទាល់លើ Table products
    $categories = Product::where('status', 1)->select('category')->distinct()->get();

    // បង្កើត Array មួយដើម្បីទុកផលិតផលតាម Category
    $productsByCategory = [];
    foreach ($categories as $cat) {
        $productsByCategory[$cat->category] = Product::where('category', $cat->category)->where('status', 1)->get();
    }

    return view('allProduct', compact('productsByCategory' , 'count'));
}

    public function productShow($id){
        $product = Product::findOrFail($id);
        return view('show', compact('product'));
    }

    public function orderPayment($id) {
    $order = Order::findOrFail($id);
    
    if ($order->user_id !== Auth::id()) {
        abort(403);
    }
    $count = ProductCart::where('user_id', Auth::id())->sum('quantity');
    return view('payment', compact('order', 'count'));
}
}
