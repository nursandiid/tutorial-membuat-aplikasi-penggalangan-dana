<?php

use App\Http\Controllers\{
    CampaignController,
    CashoutController,
    CategoryController,
    ContactController,
    DashboardController,
    DonationController,
    DonaturController,
    ReportController,
    SettingController,
    SubscriberController,
    UserProfileInformationController
};
use App\Http\Controllers\Front\{
    AboutController,
    ContactController as FrontContactController,
    CampaignController as FrontCampaignController,
    DonationController as FrontDonationController,
    FrontController,
    PaymentController,
    SubcriberController as FrontSubcriberController
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [FrontController::class, 'index']);
Route::get('/contact', [FrontContactController::class, 'index']);
Route::post('/contact', [FrontContactController::class, 'store']);
Route::get('/about', [AboutController::class, 'index']);
Route::post('/subscriber', [FrontSubcriberController::class, 'store']);
Route::resource('/campaign', FrontCampaignController::class)
    ->only('index', 'create', 'edit')
    ->middleware(['auth', 'role:admin,donatur']);
Route::get('/donation', [FrontDonationController::class, 'index']);
Route::get('/donation/{id}', [FrontDonationController::class, 'show']);
Route::group([
    'middleware' => ['auth', 'role:admin,donatur'],
    'prefix' => '/donation/{id}'
], function () {
    Route::get('/create', [FrontDonationController::class, 'create']);
    Route::post('/', [FrontDonationController::class, 'store']);
    Route::get('/payment/{order_number}', [PaymentController::class, 'index']);
    Route::get('/payment-confirmation/{order_number}', [PaymentController::class, 'paymentConfirmation']);
    Route::post('/payment-confirmation/{order_number}', [PaymentController::class, 'store']);
});

Route::group([
    'middleware' => ['auth', 'role:admin,donatur'],
    'prefix' => 'admin'
], function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/user/profile', [UserProfileInformationController::class, 'show'])
        ->name('profile.show');
    Route::delete('/user/bank/{id}', [UserProfileInformationController::class, 'bankDestroy'])
        ->name('profile.bank.destroy');

    Route::group([
        'middleware' => 'role:admin'
    ], function () {
        Route::resource('/category', CategoryController::class);

        Route::get('/setting', [SettingController::class, 'index'])
            ->name('setting.index');
        Route::put('/setting/{setting}', [SettingController::class, 'update'])
            ->name('setting.update');
        Route::delete('/setting/{setting}/bank/{id}', [SettingController::class, 'bankDestroy'])
            ->name('setting.bank.destroy');
    });

    Route::get('/campaign/data', [CampaignController::class, 'data'])
        ->name('campaign.data');
    Route::resource('/campaign', CampaignController::class);
    Route::put('/campaign/{id}/update_status', [CampaignController::class, 'updateStatus'])
        ->name('campaign.update_status');

    Route::get('/campaign/{id}/cashout', [CampaignController::class, 'cashout'])
        ->name('campaign.cashout');
    Route::post('/campaign/{id}/cashout', [CampaignController::class, 'cashoutStore'])
        ->name('campaign.cashout.store');

    Route::get('/donation/data', [DonationController::class, 'data'])
        ->name('donation.data');
    Route::resource('/donation', DonationController::class);

    Route::get('/cashout/data', [CashoutController::class, 'data'])
        ->name('cashout.data');
    Route::resource('/cashout', CashoutController::class);

    Route::group([
        'middleware' => 'role:admin'
    ], function () {
        Route::get('/donatur/data', [DonaturController::class, 'data'])
            ->name('donatur.data');
        Route::resource('/donatur', DonaturController::class);

        Route::get('/contact/data', [ContactController::class, 'data'])
            ->name('contact.data');
        Route::resource('/contact', ContactController::class)->only('index', 'destroy');

        Route::get('/subscriber/data', [SubscriberController::class, 'data'])
            ->name('subscriber.data');
        Route::resource('/subscriber', SubscriberController::class)->only('index', 'destroy');

        Route::get('/report', [ReportController::class, 'index'])->name('report.index');
        Route::get('/report/data/{start}/{end}', [ReportController::class, 'data'])->name('report.data');
        Route::get('/report/pdf/{start}/{end}', [ReportController::class, 'exportPDF'])->name('report.export_pdf');
        Route::get('/report/excel/{start}/{end}', [ReportController::class, 'exportExcel'])->name('report.export_excel');
    });
});

Route::get('payment_confirmed', function () {
    $donation = \App\Models\Donation::find(13);
    
    return view('mail.payment_confirmed', compact('donation'));
});

Route::get('/user/{id}/{token}', [UserProfileInformationController::class, 'email_verification']);