<?php

use App\Http\Controllers\BloodRequestController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationRequestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
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


Route::group(['middleware' => 'auth'], function () {

	Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
	Route::get('/api/hospital-data', [DashboardController::class, 'hospitalData']);

	Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	Route::get('rtl', function () {
		return view('rtl');
	})->name('rtl');

	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

	Route::get('virtual-reality', function () {
		return view('virtual-reality');
	})->name('virtual-reality');

	Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

	Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

	Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
	Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');

	Route::middleware(['role:admin'])->group(function () {
		Route::post('/hospitals/store', [HospitalController::class, 'store'])->name('hospitals.store');
		Route::get('/hospitals', [HospitalController::class, 'index'])->name('hospitals.index');
		Route::get('/hospitals', [HospitalController::class, 'index'])->name('hospitals.index');
		Route::patch('/hospitals', [HospitalController::class, 'update'])->name('hospitals.update');
		Route::get('/hospitals/{id}', [HospitalController::class, 'show'])->name('hospitals.byId');
		Route::patch('/hospitals/{id}', [HospitalController::class, 'update'])->name('hospitals.update');
		Route::delete('/hospitals/{id}', [HospitalController::class, 'delete'])->name('hospitals.delete');

		Route::get('export/donation-requests', [DashboardController::class, 'exportDonationRequests'])->name('export.donation-requests');
		Route::get('/export/donation-requests/pdf', [DashboardController::class, 'exportDonationRequestsPdf'])->name('export.donation.pdf');
		Route::get('export/blood-requests', [DashboardController::class, 'exportBloodRequests'])->name('export.blood-requests');
		Route::get('/export/blood-requests/pdf', [DashboardController::class, 'exportBloodRequestsPdf'])->name('export.blood.pdf');
		Route::get('export/hospitals', [DashboardController::class, 'exportHospitals'])->name('export.hospitals');
		Route::get('/export/hospitals/pdf', [DashboardController::class, 'exportHospitalsPdf'])->name('export.hospitals.pdf');
		Route::get('export/users', [DashboardController::class, 'exportUsers'])->name('export.users');
		Route::get('/export/users/pdf', [DashboardController::class, 'exportUsersPdf'])->name('export.users.pdf');
		Route::get('/export/filter/pdf', [App\Http\Controllers\DashboardController::class, 'exportFilteredPdf'])->name('export.filtered.pdf');
	});

	Route::middleware(['role:hospital'])->group(function () {});


	Route::get('/donation-requests', [DonationRequestController::class, 'index'])->name('donation-requests.index');
	Route::get('/donation-requests/donor', [DonationRequestController::class, 'donor'])->name('donation-requests.donor');
	Route::get('/donation-requests/hospital', [DonationRequestController::class, 'hospital'])->name('donation-requests.hospital');
	Route::get('/donation-requests/reschedule', [DonationRequestController::class, 'showReschedule'])->name('donation-requests.reschedule.show');
	Route::get('/donation-requests/{id}', [DonationRequestController::class, 'show'])->name('donation-requests.show');
	Route::post('/donation-requests', [DonationRequestController::class, 'store'])->name('donation-requests.store');
	Route::patch('/donation-requests/{id}', [DonationRequestController::class, 'update'])->name('donation-requests.update');
	Route::patch('/donation-requests/approve/{id}', [DonationRequestController::class, 'approve'])->name('donation-requests.approve');
	Route::patch('/donation-requests/reschedule/{id}', [DonationRequestController::class, 'reschedule'])->name('donation-requests.reschedule');
	Route::patch('/donation-requests/reschedule/approve/{id}', [DonationRequestController::class, 'approveReschedule'])->name('donation-requests.reschedule.approve');
	Route::patch('/donation-requests/reschedule/decline/{id}', [DonationRequestController::class, 'declineReschedule'])->name('donation-requests.reschedule.decline');
	Route::patch('/donation-requests/cancel/{id}', [DonationRequestController::class, 'cancel'])->name('donation-requests.cancel');
	Route::delete('/donation-requests/{id}', [DonationRequestController::class, 'destroy'])->name('donation-requests.destroy');

	Route::get('/blood-requests', [BloodRequestController::class, 'index'])->name('blood-requests.index');
	Route::post('/blood-requests', [BloodRequestController::class, 'store'])->name('blood-requests.store');
	Route::patch('/blood-requests/fulfill/{id}', [BloodRequestController::class, 'fulfill'])->name('blood-requests.fulfill');
});



Route::group(['middleware' => 'guest'], function () {
	Route::get('/', [LandingController::class, 'index']);
	Route::get('/hospital-list', [LandingController::class, 'hospital']);
	Route::get('/register', [UserController::class, 'create']);
	Route::post('/register', [UserController::class, 'store']);
	Route::get('/otp', [UserController::class, 'otp'])->name('otp');
	Route::post('/verify-otp', [UserController::class, 'verifyOtp'])->name('otp.verify');
	Route::get('/login', [SessionsController::class, 'create']);
	Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});

use Stevebauman\Location\Facades\Location;

Route::get('/login', function () {
	return view('session/login-session');
})->name('login');

use App\Mail\TestMail;
use App\Mail\DonationRequestMail;
use Illuminate\Support\Facades\Mail;

Route::get('/send-test-email', function () {
	// Mail::to('charlesthommatidios@gmail.com')->send(new DonationRequestMail());
	// return 'Email sent successfully!';
	return view('emails.donation-request-admin-mail');
});