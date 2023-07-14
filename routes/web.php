<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\RequestsController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\ChildrenController;

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

Route::get('/', [HomeController::class, 'index'])->name('/');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');

Auth::routes();

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::middleware(['user.authorized'])->group(function () {
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/delete/{id}', [UsersController::class , 'delete'])->name('users.delete');
    Route::get('/users/{id}', [UsersController::class , 'view'])->name('users.view');
    Route::post('/users/{id}', [UsersController::class , 'update'])->name('users.update');
    Route::get('/users/add/user', [UsersController::class , 'addUser'])->name('users.add');
    Route::post('/users/add/user', [UsersController::class , 'addUser']);
    Route::post('/users/notes/add-note', [UsersController::class, 'addNote'])->name('users.notes.add.note');
    Route::post('/users/documents/request-new-document', [UsersController::class, 'requestNewDocument'])->name('users.request.new.document');
});

Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
Route::post('/settings', [SettingsController::class, 'index'])->name('settings.save');

Route::get('/requests', [RequestsController::class, 'index'])->name('requests.index');
Route::get('/requests/view/{id}', [RequestsController::class, 'view'])->name('requests.view');
Route::get('/requests/create', [RequestsController::class, 'create'])->name('requests.create');
Route::post('/requests/create', [RequestsController::class, 'create']);
Route::get('/requests/get-services-fields', [RequestsController::class, 'getServicesFields'])->name('requests.get.services.fields');
Route::post('/requests/request-new-document', [RequestsController::class, 'requestNewDocument'])->name('requests.request.new.document');
Route::post('/requests/upload-new-document', [RequestsController::class, 'uploadNewDocument'])->name('requests.upload.new.document');
Route::get('/requests/want-to-help/{id}', [RequestsController::class, 'requestToHelp'])->name('requests.want.to.help');
Route::post('/requests/notes/add-note', [RequestsController::class, 'addNote'])->name('requests.notes.add.note');

Route::get('/requests/approve/{id}', [RequestsController::class, 'approve'])->name('requests.approve');
Route::get('/requests/reject/{id}', [RequestsController::class, 'reject'])->name('requests.reject');
Route::get('/requests/complete/{id}', [RequestsController::class, 'complete'])->name('requests.complete');

Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
Route::get('/history/adoption', [HistoryController::class, 'adoption'])->name('history.adoption');

Route::get('/contact', [ContactUsController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactUsController::class, 'index']);

Route::get('/services/{type}', [ServicesController::class, 'index'])->name('services.view');
Route::get('/services/status/{id}', [ServicesController::class, 'toggleStatus'])->name('services.status.toggle');
Route::get('/services/fields/{type}', [ServicesController::class, 'create'])->name('services.fields.create');
Route::post('/services/fields/create/{type}', [ServicesController::class, 'create'])->name('services.fields.save');
Route::get('/services/fields/view/{id}', [ServicesController::class, 'view'])->name('services.fields.view');
Route::post('/services/fields/view/{id}', [ServicesController::class, 'view']);
Route::get('/services/fields/delete/{id}', [ServicesController::class, 'deleteField'])->name('services.fields.delete');

Route::get('/giving-tree', [ServicesController::class, 'givingTree'])->name('giving-tree.index');
Route::get('/edit-giving-tree/{id}', [ServicesController::class, 'givingTreeEdit'])->name('giving-tree.edit');
Route::post('/edit-giving-tree/{id}', [ServicesController::class, 'givingTreeEdit']);
Route::post('/giving-tree', [ServicesController::class, 'givingTree']);
Route::get('/giving-tree/add-child/{family_id}', [ServicesController::class, 'givingTreeAddChild'])->name('giving-tree.add-child');
Route::post('/giving-tree/add-child/{family_id}', [ServicesController::class, 'givingTreeAddChild']);
Route::get('/services/get/get-province-cities', [ServicesController::class, 'getProvinceCities'])->name('services.get.province.cities');

Route::get('/notifications', [NotificationsController::class, 'index'])->name('notifications.index');
Route::get('/notifications/archive', [NotificationsController::class, 'archive'])->name('notifications.archive');
Route::get('/notifications/view/{id}', [NotificationsController::class, 'view'])->name('notifications.view');
Route::get('/notifications/download-giving-tree-signups', [NotificationsController::class, 'downloadGivingTreeSignups'])->name('notifications.download.giving.tree.signups');

Route::get('/families', [FamilyController::class, 'index'])->name('families.index');
Route::get('/families/view/{id}', [FamilyController::class, 'view'])->name('families.view');
Route::post('/families/want-to-help/{id}', [FamilyController::class, 'wantToHelp'])->name('families.want.to.help');
Route::get('/families/delete/{id}', [FamilyController::class, 'deleteFamily'])->name('families.delete');

Route::get('/childrens', [ChildrenController::class, 'index'])->name('childrens.index');
Route::post('/childrens/help', [ChildrenController::class, 'help'])->name('families.help');
Route::get('/childrens/help/view/{id}', [ChildrenController::class, 'helpView'])->name('families.help.view');
Route::get('/childrens/help/delete/{id}', [ChildrenController::class, 'helpDelete'])->name('families.help.delete');
Route::get('/childrens/help/archive/{id}', [ChildrenController::class, 'helpArchive'])->name('families.help.archive');
Route::get('/childrens/help/unarchive/{id}', [ChildrenController::class, 'helpUnArchive'])->name('families.help.unarchive');

Route::get('/requested-to-help', [FamilyController::class, 'requestedToHelp'])->name('families.requested.to.help');
Route::get('/requested-to-help/view/{id}/{notification_id}', [FamilyController::class, 'requestedToHelpView'])->name('families.requested.to.help.view');


