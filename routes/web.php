<?php

use App\Livewire\BrandPage;
use App\Livewire\CancelPage;
use App\Livewire\CartPage;
use App\Livewire\CategoriesPage;
use App\Livewire\CheckoutPage;
use App\Livewire\ForgotPasswordPage;
use App\Livewire\HomePage;
use App\Livewire\LoginPage;
use App\Livewire\MyOrderDetailPage;
use App\Livewire\MyOrdersPage;
use App\Livewire\ProductDetailPage;
use App\Livewire\ProductsPage;
use App\Livewire\RegisterPage;
use App\Livewire\ResetPasswordPage;
use App\Livewire\SuccessPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/brands', BrandPage::class)->name('brands');
Route::get('/categories', CategoriesPage::class)->name('categories');

Route::get('/products', ProductsPage::class)->name('products');
Route::get('/products/{product:slug}', ProductDetailPage::class)->name('products.show');

Route::get('/cart', CartPage::class)->name('cart');

Route::get('/checkout', CheckoutPage::class)->name('checkout');
Route::get('/orders', MyOrdersPage::class)->name('orders');
Route::get('/orders/{order}', MyOrderDetailPage::class)->name('orders.show');

Route::get('/login', LoginPage::class)->name('login');
Route::get('/register', RegisterPage::class)->name('register');
Route::get('/forgot-password', ForgotPasswordPage::class)->name('password.request');
Route::get('/reset-password', ResetPasswordPage::class)->name('password.reset');

Route::get('/success', SuccessPage::class)->name('success');
Route::get('/cancel', CancelPage::class)->name('cancel');
