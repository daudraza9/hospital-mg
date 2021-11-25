<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PdfGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\RoleController;
use Laravel\Socialite\Facades\Socialite;

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

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/index', [DashboardController::class, 'index'])->name('index');

    Route::group(['prefix' => 'doctor', 'as' => 'doctor.'], function () {
        Route::get('/', [DoctorController::class, 'index'])->name('index');
        Route::get('/create', [DoctorController::class, 'create'])->name('create');
        Route::post('/store', [DoctorController::class, 'store'])->name('store');
        Route::get('/datatable', [DoctorController::class, 'datatable'])->name('datatable');
        Route::get('/edit/{id}', [DoctorController::class, 'edit'])->name('edit');
        Route::post('/update', [DoctorController::class, 'update'])->name('update');
        Route::post('/delete', [DoctorController::class, 'delete'])->name('delete');
        Route::get('/viewAppointment',[DoctorController::class,'viewAppointment'])->name('viewAppointment');

        //---Doctor Patient Routes---//
        Route::group(['prefix' => 'patient', 'as' => 'patient.'], function () {
            Route::get('/', [DoctorController::class, 'indexDoctorPatient'])->name('index');
            Route::get('/select', [DoctorController::class, 'select'])->name('select');
            Route::get('/add/{id}', [DoctorController::class, 'addPatient'])->name('addPatient');
            Route::get('/patientdatatable', [DoctorController::class, 'patientdatatable'])->name('patientdatatable');
            Route::post('/store', [DoctorController::class, 'storePatient'])->name('storePatient');
            Route::post('/delete', [DoctorController::class, 'deletePatient'])->name('deletePatient');

        });
    });

    //--Nurses Route--//
    Route::group(['prefix' => 'nurse', 'as' => 'nurse.'], function () {
        Route::get('/', [NurseController::class, 'index'])->name('index');
        Route::get('/create', [NurseController::class, 'create'])->name('create');
        Route::post('/store', [NurseController::class, 'store'])->name('store');
        Route::get('/datatable', [NurseController::class, 'datatable'])->name('datatable');
        Route::post('/delete', [NurseController::class, 'delete'])->name('delete');
        Route::get('/edit/{id}', [NurseController::class, 'edit'])->name('edit');
        Route::post('/update', [NurseController::class, 'update'])->name('update');
        Route::get('/selectDepartment', [NurseController::class, 'selectDepartment'])->name('selectDepartment');
    });

    //--Staff Route--//
    Route::group(['prefix' => 'staff', 'as' => 'staff.'], function () {
        Route::get('/', [StaffController::class, 'index'])->name('index');
        Route::get('/create', [StaffController::class, 'create'])->name('create');
        Route::post('/store', [StaffController::class, 'store'])->name('store');
        Route::get('/datatable', [StaffController::class, 'datatable'])->name('datatable');
        Route::post('/delete', [StaffController::class, 'delete'])->name('delete');
        Route::get('/edit/{id}', [StaffController::class, 'edit'])->name('edit');
        Route::post('/update', [StaffController::class, 'update'])->name('update');
    });

    //--Department--//
    Route::group(['prefix' => 'department', 'as' => 'department.'], function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('index');
        Route::get('/create', [DepartmentController::class, 'create'])->name('create');
        Route::post('/store', [DepartmentController::class, 'store'])->name('store');
        Route::get('/datatable', [DepartmentController::class, 'datatable'])->name('datatable');
        Route::post('/delete', [DepartmentController::class, 'delete'])->name('delete');
        Route::get('/edit/{id}', [DepartmentController::class, 'edit'])->name('edit');
        Route::post('/update', [DepartmentController::class, 'update'])->name('update');
    });

    //--Patient--//
    Route::group(['prefix' => 'patient', 'as' => 'patient.'], function () {
        Route::get('/', [PatientController::class, 'index'])->name('index');
        Route::get('/create', [PatientController::class, 'create'])->name('create');
        Route::post('/store', [PatientController::class, 'store'])->name('store');
        Route::get('/datatable', [PatientController::class, 'datatable'])->name('datatable');
        Route::post('/delete', [PatientController::class, 'delete'])->name('delete');
        Route::get('/edit/{id}', [PatientController::class, 'edit'])->name('edit');
        Route::post('/update', [PatientController::class, 'update'])->name('update');
        Route::get('/viewAppointment',[PatientController::class,'viewAppointment'])->name('viewAppointment');
    });

    //---User Routes---//
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/add',[UserController::class,'add'])->name('add');
        Route::get('/view',[UserController::class,'view'])->name('view');
        Route::post('/create',[UserController::class,'create'])->name('create');
        Route::get('/edit/{id}', [UserController::class, 'index'])->name('edit');
        Route::post('/update', [UserController::class, 'update'])->name('update');
        Route::get('/datatable',[UserController::class,'usersList'])->name('datatable');
        Route::post('/delete',[UserController::class,'delete'])->name('delete');
    });

//---Room Routes---//
    Route::group(['prefix' => 'room', 'as' => 'room.'], function () {
        Route::get('/', [RoomController::class, 'index'])->name('index');
        Route::get('/create', [RoomController::class, 'create'])->name('create');
        Route::post('/store', [RoomController::class, 'store'])->name('store');
        Route::get('/datatable',[RoomController::class,'datatable'])->name('datatable');
        Route::post('/delete',[RoomController::class,'delete'])->name('delete');
        Route::get('/edit/{id}',[RoomController::class,'edit'])->name('edit');
        Route::post('update',[RoomController::class,'update'])->name('update');

        Route::group(['prefix' => 'patient', 'as' => 'patient.'], function () {
            Route::get('/', [RoomController::class, 'indexpatient'])->name('index');
            Route::get('/create',[RoomController::class,'createPatient'])->name('create');
            Route::post('/store',[RoomController::class,'storePatient'])->name('store');
            Route::get('/select',[RoomController::class,'select'])->name('select');
            Route::get('/patientDatatable',[RoomController::class,'patientDatatable'])->name('patientDatatable');
            Route::post('/delete',[RoomController::class,'deletePatient'])->name('delete');
        });
    });

    //---Appointment Routes---//
    Route::group(['prefix' => 'appointment', 'as' => 'appointment.'], function () {
        Route::get('/', [AppointmentController::class, 'index'])->name('index');
        Route::get('/create',[AppointmentController::class,'create'])->name('create');
        Route::get('/datatable',[AppointmentController::class,'datatable'])->name('datatable');
        Route::get('/selectPatient',[AppointmentController::class,'selectPatient'])->name('selectPatient');
        Route::get('/selectDoctor',[AppointmentController::class,'selectDoctor'])->name('selectDoctor');
        Route::post('/add',[AppointmentController::class,'add'])->name('add');
        Route::post('/delete',[AppointmentController::class,'delete'])->name('delete');
        Route::get('/edit/{id}',[AppointmentController::class,'edit'])->name('edit');
        Route::post('/update',[AppointmentController::class,'update'])->name('update');
        Route::get('/pdf/{id}',[AppointmentController::class,'pdf'])->name('pdf');
    });

    //--File--//
    Route::group(['prefix'=>'file','as'=>'file.'],function (){
       Route::get('/',[FileController::class,'index'])->name('index');
       Route::get('/view',[FileController::class,'view'])->name('view');
       Route::post('/store',[FileController::class,'store'])->name('store');
        Route::post('/storeMedia',[FileController::class,'storeMedia'])->name('storeMedia');
       Route::get('/datatable',[FileController::class,'datatable'])->name('datatable');
       Route::get('/datatableMedia',[FileController::class,'datatableMedia'])->name('datatableMedia');
       Route::post('/delete',[FileController::class,'delete'])->name('delete');
       Route::post('/display',[FileController::class,'display'])->name('display');
       Route::get('/mediaView',[FileController::class,'mediaView'])->name('mediaView');
    });

    //--Role--//
    Route::group(['prefix'=>'role','as'=>'role.'],function (){
       Route::get('/',[RoleController::class,'index'])->name('index');
       Route::get('/create',[RoleController::class,'create'])->name('create');
       Route::post('/store',[RoleController::class,'store'])->name('store');
       Route::get('/datatable',[RoleController::class,'datatable'])->name('datatable');
       Route::post('/delete',[RoleController::class,'delete'])->name('delete');
       Route::get('/edit/{id}',[RoleController::class,'edit'])->name('edit');
       Route::post('/update',[RoleController::class,'update'])->name('update');
       Route::get('/permission/edit/{id}',[RoleController::class,'permissionEdit'])->name('permissionEdit');
       Route::post('/permission/updata/{id}',[RoleController::class,'permissionUpdate'])->name('permissionUpdate');
       Route::get('/roleSelect',[RoleController::class,'roleSelect'])->name('roleSelect');
    });

    Route::group(['prefix'=>'pdf','as'=>'pdf.'],function () {
        Route::get('/',[PdfGenerator::class,'index'])->name('index');
        Route::get('/generate',[PdfGenerator::class,'generate'])->name('generate');
    });

    Route::group(['prefix'=>'payment','as'=>'payment.'],function () {
        Route::get('/',[PaymentController::class,'index'])->name('index');
        Route::post('/create',[PaymentController::class,'create'])->name('create');
        Route::get('/subscribe',[PaymentController::class,'subscribe'])->name('subscribe');
        Route::post('/Addsubscription',[PaymentController::class,'Addsubscription'])->name('Addsubscription');
        Route::get('/ecommerce',[PaymentController::class,'ecommerceIndex'])->name('ecommerceIndex');
    });

    Route::group(['prefix'=>'product','as'=>'product.'],function () {
        Route::get('/',[PaymentController::class,'indexs'])->name('indexs');
        Route::get('/addProduct',[PaymentController::class,'addProduct'])->name('addProduct');
        Route::post('/storeProduct',[PaymentController::class,'storeProduct'])->name('storeProduct');
        Route::get('/datatable',[PaymentController::class,'datatable'])->name('datatable');
        Route::post('/delete',[PaymentController::class,'delete'])->name('delete');
        Route::get('/cart', [PaymentController::class, 'cart'])->name('cart');
        Route::get('/add-to-cart/{id}', [PaymentController::class, 'addToCart'])->name('add.to.cart');
        Route::patch('/update-cart', [PaymentController::class, 'update'])->name('update.cart');
        Route::post('/remove-from-cart', [PaymentController::class, 'remove'])->name('remove.from.cart');
        Route::post('/madePayment', [PaymentController::class, 'madePayment'])->name('madePayment');

    });

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('login/google',[App\Http\Controllers\Auth\LoginController::class,'redirectToProvider']);
Route::get('/login/google/callback',[App\Http\Controllers\Auth\LoginController::class,'handleProviderCallBack']);

Route::get('login/github',[App\Http\Controllers\Auth\LoginController::class,'githubLogin']);
Route::get('/login/github/callback',[App\Http\Controllers\Auth\LoginController::class,'githubLoginCallBack']);

Route::get('/', function () {
    return view('/home');
})->name('home');
