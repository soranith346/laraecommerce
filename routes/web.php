    <?php

    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\ProductController;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\UserController;
    use Illuminate\Support\Facades\Route;   
    use App\Http\Controllers\Auth\RegisteredUserController;
    use App\Http\Controllers\PaymentController;

    Route::get('verify-otp', [RegisteredUserController::class, 'otpView'])->name('otp.view');
    Route::post('verify-otp', [RegisteredUserController::class, 'verifyOtp'])->name('otp.submit');

    // My Orders Route (រក្សាទុក middleware verified ព្រោះយើងបានដាក់ now() ក្នុង DB រួចហើយ)
    Route::get('/myorders', [UserController::class, 'myOrders'])->middleware(['auth', 'verified'])->name('myorders');
    Route::get("/" , [UserController::class , 'home'])->name('index');
    Route::get('/product/{id}', [UserController::class, 'show'])->name('product.details');
    Route::get('/productShow/{id}', [UserController::class, 'productShow'])->name('product.show');
    Route::get('/allProduct', [UserController::class, 'allProduct'])->name('allProduct');


    Route::get('/dashboard', [UserController::class ,'index'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('all-products', [UserController::class, 'allProducts'])->name('products.ajax');
    Route::post('/addtocart/{id}', [UserController::class, 'addToCart'])->middleware(['auth', 'verified'])->name('add_to_cart');
    Route::get('/showcartproduct' , [UserController::class , 'cartProduct'])->middleware(['auth', 'verified'])->name('cartProduct');
    Route::get('/removecart/{id}' , [UserController::class , 'removeCart'])->middleware(['auth', 'verified'])->name('removeCart');
    Route::post('/confirmorder' , [UserController::class , 'confirmOrder'])->middleware(['auth', 'verified'])->name('confirmOrder');
    Route::get('/myorders' , [UserController::class , 'myOrders'])->middleware(['auth', 'verified'])->name('myorders');
    Route::post('/checkout/{id}', [PaymentController::class, 'checkout'])->middleware(['auth', 'verified'])->name('checkout');
    Route::get('/verify', [PaymentController::class, 'verifyForm'])->middleware(['auth', 'verified'])->name('verify.form');
    Route::post('/verify', [PaymentController::class, 'verifyTransaction'])->middleware(['auth', 'verified'])->name('verify.transaction');
    Route::get('/payments/result', [PaymentController::class, 'verifyTransaction'])->middleware(['auth', 'verified'])->name('payments.result');
    Route::get('/order/payment/{id}', [UserController::class, 'orderPayment'])->name('order.payment');
    Route::get('/admin/check-pay', [PaymentController::class, 'checkAdminNotification'])->name('admin.check.notification');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
    Route::middleware('admin')->group(function () {
        Route::get('/admin_test', [AdminController::class, 'admin_test'])->name('admin.test');
        Route::get('/add_category', [AdminController::class, 'addCategory'])->name('admin.addcategory');
        Route::post('/add_category', [AdminController::class, 'storeCategory'])->name('admin.storeCategory');
        Route::get('/view_category', [AdminController::class, 'viewCategory'])->name('admin.viewcategory');
        Route::get('/delete_category/{id}', [AdminController::class, 'deleteCategory'])->name('admin.deleteCategory');
        Route::get('/edit_category/{id}', [AdminController::class, 'editCategory'])->name('admin.editCategory');
        Route::post('/update-category/{id}', [AdminController::class, 'updateCategory'])->name('admin.updateCategory');
        Route::get('/add_product', [AdminController::class, 'addProduct'])->name('admin.add_product');
        Route::post('add_product', [AdminController::class , 'storeProduct'])->name('admin.storeProduct');
        Route::get('view_product', [AdminController::class , 'viewProduct'])->name('admin.view_product');
        Route::get('delete_product/{id}', [AdminController::class , 'deleteProduct'])->name('admin.deleteProduct');
        Route::get('edit_product/{id}', [AdminController::class , 'editProduct'])->name('admin.editProduct');
        Route::post('update_product/{id}', [AdminController::class , 'updateProduct'])->name('admin.updateProduct');
        Route::any('search', [AdminController::class , 'searchProduct'])->name('admin.searchproduct');
        Route::any('searchCategory', [AdminController::class , 'searchCategory'])->name('admin.searchCategory');
        Route::get('vieworders', [AdminController::class , 'viewOrder'])->name('admin.view_order');
        Route::post('change_status/{id}' , [AdminController::class , 'changeStatus'])->name('admin.change_status');
        Route::get('downloadpdf/{id}' , [AdminController::class , 'downloadPdf'])->name('admin.downloadpdf');
        
        });


    require __DIR__.'/auth.php';
