<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\BlockedUserMiddleware;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');
// 🌍 Accueil et boutique (ouvert à tous)
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/produit/{id}', [ProductController::class, 'show'])->name('product.show');



// 🔐 Authentification (Login / Register / Logout)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 👤 Espace Client (Protégé par "auth")


// Middleware pour s'assurer que l'utilisateur est authentifié et non bloqué
Route::middleware(['auth', BlockedUserMiddleware::class])->group(function () {

    // 🏠 Page du compte utilisateur
    Route::get('/mon-compte', [AuthController::class, 'profile'])->name('profile');
    Route::get('/dashboard', [ProductController::class, 'showShop'])->name('dashboard');


    // 🛒 Gestion du panier
    Route::get('/panier', [CartController::class, 'index'])->name('cart'); // Voir le panier
    Route::post('/panier/ajouter/{id}', [CartController::class, 'add'])->name('cart.add'); // Ajouter un produit
    Route::post('/panier/supprimer/{id}', [CartController::class, 'destroy'])->name('cart.destroy'); // Supprimer un produit
    Route::post('/panier/mettre-a-jour/{id}', [CartController::class, 'update'])->name('cart.update'); // Modifier quantité
    Route::post('/panier/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // 💳 Paiement & Commandes
Route::get('/commandes', [OrderController::class, 'index'])->name('orders'); // Liste des commandes
Route::post('/commandes', [OrderController::class, 'store'])->name('orders.store'); // Valider une commande

// 📦 Détails d'une commande
Route::get('/commandes/{id}', [OrderController::class, 'show'])->name('orders.show'); // Afficher détails d'une commande

// 🛒 Checkout (Passage en caisse)
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
});


// 🔑 Espace Admin (Protégé par "auth" + "AdminMiddleware")
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 🛒 Gestion des produits
    Route::resource('/products', AdminProductController::class)->except(['show']);
    Route::get('/admin/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::get('/stock-management', [AdminProductController::class, 'manageStock'])->name('stock.manage');
    Route::post('/admin/products/{id}/update-stock', [AdminProductController::class, 'updateStock'])->name('updateStock');


    
    // 👥 Gestion des utilisateurs
    Route::resource('/users', UserController::class)->only(['index', 'destroy']);
    Route::post('/users/{user}/toggle-block', [UserController::class, 'toggleBlock'])->name('users.toggleBlock');

    // 📦 Gestion des commandes
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');


});
