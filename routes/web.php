<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;



// Rutas de autenticación básicas
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Ruta personalizada para login de administrador
Route::prefix('admin')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('admin.login.submit');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.home')->middleware('auth');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', function() {
    return redirect()->route('catalogo.index');
});

// Rutas del carrito
Route::prefix('carrito')->name('cart.')->group(function () {
    Route::get('/', [App\Http\Controllers\CartController::class, 'index'])->name('index');
    Route::post('/agregar', [App\Http\Controllers\CartController::class, 'addToCart'])->name('add');
    Route::post('/actualizar', [App\Http\Controllers\CartController::class, 'updateCart'])->name('update');
    Route::get('/eliminar/{product}', [App\Http\Controllers\CartController::class, 'removeFromCart'])->name('remove');
    Route::get('/vaciar', [App\Http\Controllers\CartController::class, 'clearCart'])->name('clear');
    Route::get('/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('checkout');
    Route::post('/procesar-orden', [App\Http\Controllers\CartController::class, 'processOrder'])->name('process');
    Route::get('/confirmacion', [App\Http\Controllers\CartController::class, 'confirmation'])->name('confirmation');
});

// Rutas de administrador
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Rutas de órdenes
    Route::prefix('orders')->name('orders.')->controller(App\Http\Controllers\Admin\OrderController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{order}', 'show')->name('show');
        Route::put('/{order}/status', 'updateStatus')->name('update-status');
        Route::put('/{order}/payment-status', 'updatePaymentStatus')->name('update-payment-status');
        Route::put('/{order}/invoice-status', 'updateInvoiceStatus')->name('update-invoice-status');
        Route::post('/{order}/notes', 'saveNotes')->name('save-notes');
    });

    Route::prefix('categories')->name('categories.')->controller(App\Http\Controllers\CategoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'getCategoriesData')->name('data');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    Route::prefix('subcategories')->name('subcategories.')->controller(App\Http\Controllers\SubcategoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'getSubcategoriesData')->name('data');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    Route::prefix('brands')->name('brands.')->controller(App\Http\Controllers\BrandController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'getBrandsData')->name('data');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    Route::prefix('supplier-categories')->name('supplier_categories.')->controller(App\Http\Controllers\SupplierCategoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'getSupplierCategoriesData')->name('data');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    Route::resource('suppliers', SupplierController::class)->names('suppliers');
    Route::get('products/{product}/summernote-standalone', [ProductController::class, 'editDescription'])->name('products.summernote-standalone');
    Route::put('products/{product}/summernote-standalone', [ProductController::class, 'updateDescription'])->name('products.summernote.update');
    Route::resource('products', ProductController::class)->names('products');
    Route::delete('products/{product}/images/{image}', [ProductController::class, 'destroyImage'])->name('products.images.destroy');
});

// Rutas públicas para clientes (catálogo)
Route::prefix('catalogo')->name('catalogo.')->group(function () {
    Route::get('/', [ProductController::class, 'catalog'])->name('index'); // Listado de productos
    Route::get('/producto/{product}', [ProductController::class, 'show'])->name('producto'); // Detalle de producto
});

// Ruta para registro de socios (proveedores y repartidores)
Route::post('/partner-register', [App\Http\Controllers\PartnerController::class, 'register'])->name('partner.register');
