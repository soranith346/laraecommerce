<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;


class AdminController extends Controller
{
    public function admin_test(){
        return view('admin.test_admin');
    }
    // Add Category =================== //
    public function addCategory(){
        return view('admin.addcategory');
    }
    // Store Category =================== //
    public function storeCategory(Request $request){
        $category = new Category();
        $category-> category = $request -> category_name;
        $category-> description = $request -> description;
        $category-> status = $request -> status;
        if($request->hasFile('image')){
            $file = $request->file('image');
            //extension
            $ext = $file->clientExtension();

            // dd($file);
            //Set Image Name
            $datetime = Carbon::now()->format('Ymd_His');

            //Set Name Image to time កុំអោយជាន់
            $imageName = $datetime. '.'. $ext;

            //Move to directory uploads in public folder
            $file->move(public_path('uploads'), $imageName);

            //Move image name to field
            $category->image = $imageName;
            }

        $category->save();
        return redirect()->back()->with('success' , 'Add Category Successfully'); 
    }
    // View Category ======================//
    public function viewCategory(){
        $category = Category::orderBy('id', 'desc')->paginate(5);;
        return view('admin.viewcategory' , compact('category'));
    }
    // Delete Category ===================//
    public function deleteCategory(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }

        $category->delete();

        return redirect()->back()->with('delete_success', 'Category deleted successfully');
    }
    //Show Edit Category ===================//
    public function editCategory(string $id){
        $category = Category::find($id);
        return view('admin.editcategory' , compact('category'));
    }
    // Update Category
    public function updateCategory(Request $request , $id){
        $category = Category::find($id);
        $category->category = $request->category_name;
        $category->status = $request->status;
        $category->description = $request->description;
        $category->image = $request->image;
        $category->save();
        return redirect()->route('admin.viewcategory')->with('update_success' , 'Update Successfully');
    }
    // Add Product
    public function addProduct(){
        $categories = Category::all();
        return view('admin.addProduct', compact('categories'));
    }
    // Store Product
    public function storeProduct(Request $request){
        $product = new Product();
        $product->product_name = $request ->product_name;
        $product->category = $request->category;
        $product->description = $request ->description;
        $product->price = $request ->price;
        $product->quantity = $request ->quantity;
        $product->brand = $request ->brand;
        $product->status = $request ->status;
        if($request->hasFile('image')){
            $file = $request->file('image');
            //extension
            $ext = $file->clientExtension();

            // dd($file);
            //Set Image Name
            $datetime = Carbon::now()->format('Ymd_His');

            //Set Name Image to time កុំអោយជាន់
            $imageName = $datetime. '.'. $ext;

            //Move to directory uploads in public folder
            $file->move(public_path('uploads'), $imageName);

            //Move image name to field
            $product->image = $imageName;
            }

            $product->save();
            return redirect()->back()->with("success", "Product created successfully");
        }

        public function viewProduct(){
            $product = Product::orderBy('id', 'desc')->paginate(5);;
            return view('admin.viewproduct' , compact('product'));
        }

        public function deleteProduct(string $id){
            $product = Product::find($id);
            if (!$product) {
            return redirect()->back()->with('error', 'Category not found');
        }
        $image_path = public_path('uploads/' . $product->image);
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
        $product->delete();
        return redirect()->back()->with('delete_success', 'Category deleted successfully');
        }

        public function editProduct($id){
            $product = Product::find($id);
            $categories = Category::all();
            return view('admin.editproduct', compact('product','categories'));
        }

    public function updateProduct($id, Request $request)
    {
        // Find product
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }

        // Validate input
        $request->validate([
            'product_name' => 'required|string|max:255',
            'category'     => 'required|string|max:255',
            'quantity'     => 'required|numeric',
            'price'        => 'required|numeric',
            'brand'        => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'status'       => 'required|in:0,1',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Update basic fields
        $product->product_name = $request->product_name;
        $product->category     = $request->category;
        $product->description  = $request->description;
        $product->quantity     = $request->quantity;
        $product->price        = $request->price;
        $product->brand        = $request->brand;
        $product->status       = $request->status;

        // Check if new image uploaded
        if ($request->hasFile('image')) {
            // Delete old image if exists
            $oldImagePath = public_path('uploads/' . $product->image);
            if (File::exists($oldImagePath) && $product->image !== null) {
                File::delete($oldImagePath);
            }

            // Upload new image
            $image      = $request->file('image');
            $imageName  = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);

            // Save new image name to database
            $product->image = $imageName;
        }

        // Save all changes
        $product->save();

        return redirect()->route('admin.view_product')->with('update_success' , 'Update Successfully');
    }

    // Search
   public function searchProduct(Request $request){
    $product = Product::where('product_name', 'LIKE', '%' . $request->search . '%')
        ->orWhere('description', 'LIKE', '%' . $request->search . '%')
        ->orWhere('category', 'LIKE', '%' . $request->search . '%')
        ->paginate(5);

            return view('admin.viewproduct', compact('product'));
        }
    public function searchCategory(Request $request){
    $category = Category::where('category', 'LIKE', '%' . $request->search . '%')
        ->orWhere('description', 'LIKE', '%' . $request->search . '%')
        ->paginate(5);

            return view('admin.viewcategory', compact('category'));
        }
    public function viewOrder() {
    $orders = Order::with(['user', 'items.product'])->orderBy('created_at', 'desc')->get();
    
    return view('admin.vieworder' , compact('orders'));
}
    public function changeStatus(Request $request , $id){
        $order = Order::find($id);
        $order->status = $request->status;
        $order->save();
        return redirect()->back();
    }

    public function downloadPdf($id){
        $data = Order::with(['user', 'items.product'])->findOrFail($id);
        $pdf = Pdf::loadView('admin.invoice', compact('data'));
        return $pdf->download('invoice.pdf');

    }
    }
    