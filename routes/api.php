<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authorization;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

$router->group(['prefix' => 'v1'], function () use ($router) {

    $router->post('login', [App\Http\Controllers\AuthController::class, 'login']);
    $router->post('register', [App\Http\Controllers\AuthController::class, 'register']);
    $router->post('validate', [App\Http\Controllers\AuthController::class, 'validatePassword']);
    $router->post('reset-password', [App\Http\Controllers\AuthController::class, 'resetPassword']);
    $router->post('reset-password/verify-code', [App\Http\Controllers\AuthController::class, 'verifyResetPasswordCode']);
    $router->post('change-password', [App\Http\Controllers\AuthController::class, 'changePassword']);
    $router->get('validate-token', [App\Http\Controllers\AuthController::class, 'validateResetPasswordToken']);

    // Route::middleware([Authorization::class])->group(function () use ($router) {
    $router->post('subscribe', [App\Http\Controllers\SubscriptionController::class, 'subscribe']);
    $router->group(['prefix' => 'plans'], function () use ($router) {
        $router->get('/', [App\Http\Controllers\PlanController::class, 'index'])->name('plans.index');
        $router->post('/', [App\Http\Controllers\PlanController::class, 'updateOrCreate'])->name('plans.updateOrCreate');
        $router->delete('/{id}', [App\Http\Controllers\PlanController::class, 'destroy'])->name('plans.destroy');
        $router->get('category', [App\Http\Controllers\PlanCategoryController::class, 'index'])->name('category.index');
        $router->post('category', [App\Http\Controllers\PlanCategoryController::class, 'updateOrCreate'])->name('category.updateOrCreate');
        $router->delete('category/{id}', [App\Http\Controllers\PlanCategoryController::class, 'destroy'])->name('category.destroy');
    })->middleware('auth:sanctum');

    $router->group(['prefix' => 'faqs'], function () use ($router) {
        $router->get('/', [App\Http\Controllers\FaqController::class, 'index'])->name('faq.index');
        $router->post('/', [App\Http\Controllers\FaqController::class, 'updateOrCreate'])->name('faq.updateOrCreate');
        $router->delete('/{id}', [App\Http\Controllers\FaqController::class, 'destroy'])->name('faq.destroy');
    })->middleware('auth:sanctum');

    $router->group(['prefix' => 'subscriptions'], function () use ($router) {
        $router->get('/token/{token}', [App\Http\Controllers\SubscriptionController::class, 'subscriptionByToken'])->name('subscription.byToken');
    })->middleware('auth:sanctum');

    $router->group(['prefix' => 'members'], function () use ($router) {
        $router->get('/', [App\Http\Controllers\MemberController::class, 'index'])->name('members.index');
        $router->post('/', [App\Http\Controllers\PlanController::class, 'updateOrCreate'])->name('plans.updateOrCreate');
        $router->delete('/{id}', [App\Http\Controllers\PlanController::class, 'destroy'])->name('plans.destroy');
    })->middleware('auth:sanctum');
    // });

    $router->get('faqs', [App\Http\Controllers\FaqController::class, 'index'])->name('faq-list');
    $router->get('public/plans/category', [App\Http\Controllers\PlanCategoryController::class, 'publicList'])->name('category.index.public');
    $router->get('testimonials', [App\Http\Controllers\TestimonialController::class, 'index'])->name('testimonial-list');
});
