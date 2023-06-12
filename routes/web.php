<?php

use Mpdf\Mpdf;
use App\Models\User;
use App\Models\Certificate;
use App\Mail\CertificateEmail;
use Mpdf\Config\FontVariables;
use Mpdf\Config\ConfigVariables;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Certificate\DomesticElectrical\Eicr;
use App\Certificate\DomesticGas\WarningNoticeGas;
use App\Certificate\DomesticElectrical\PortableApplianceTesting;
use App\Certificate\DomesticGas\LandlordHomeownerGasSafetyRecord;
use App\Certificate\DomesticElectrical\ElectricalDangerNotification;
use App\Certificate\DomesticElectrical\DomesticElectricalInstallationCertificate;
use App\Http\Controllers\Web\CertificateController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/get-pdf', function () {

    $data = Certificate::find(7);
    return $form = WarningNoticeGas::openPdf($data);

});

Route::get('/test-mail', function () {
    $user = User::find(3);
    $certificate = Certificate::where('user_id', $user->id)->find(8);
    Mail::to($user->email)->send(new CertificateEmail($user, $certificate));

    // return $form = Eicr::openPdf($data);
});

Route::get('certificate/{customer_id}/{certificate_id}/{created_at}/view', [CertificateController::class,'view'])->name('view.certificate');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';