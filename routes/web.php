<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistersController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckingAdmin;
use App\Http\Middleware\CheckingUser;
use App\Http\Middleware\PublicFeature;
use App\Events\NotificationNewDocument;

Route::get('login_admin', [RegistersController::class, 'login_admin'])->name('login_admin');
Route::post('logins_admin', [RegistersController::class, 'logins_admin'])->name('logins_admin');
Route::group([
    'middleware' => CheckingAdmin::class],function(){
        Route::get('logout_admin', [RegistersController::class, 'logout_admin'])->name('logout_admin');
        Route::get('admin_page', [RegistersController::class, 'admin_page'])->name('admin_page');
        Route::get('add_user', [AdminController::class, 'add_user'])->name('add_user');
        Route::POST('adds_user', [AdminController::class, 'adds_user'])->name('adds_user');
        Route::get('list_staff', [AdminController::class, 'list_staff'])->name('list_staff');
        Route::get('list_staff_block', [AdminController::class, 'list_staff_block'])->name('list_staff_block');
        Route::POST('lock_user', [AdminController::class, 'lock_user'])->name('lock_user');
        Route::POST('unlock_user', [AdminController::class, 'unlock_user'])->name('unlock_user');
        Route::get('edit_user/{user_id}', [AdminController::class, 'edit_user'])->name('edit_user');
        Route::POST('edits_user', [AdminController::class, 'edits_user'])->name('edits_user');
        Route::get('filter_document_admin', [AdminController::class, 'filter_document_admin'])->name('filter_document_admin');
        Route::POST('view_filter_document_admin', [AdminController::class, 'view_filter_document_admin'])->name('view_filter_document_admin');
        Route::POST('delete_document_admin', [AdminController::class, 'delete_document_admin'])->name('delete_document_admin');
        Route::POST('delete_detaildocument_admin', [AdminController::class, 'delete_detaildocument_admin'])->name('delete_detaildocument_admin');
        Route::get('edit_document_admin/{id}', [AdminController::class, 'edit_document_admin'])->name('edit_document_admin');
        Route::post('edits_document_admin', [AdminController::class, 'edits_mydocument_admin'])->name('edits_mydocument_admin');
        Route::get('view_detail_document_admin', [AdminController::class, 'view_detail_document_admin'])->name('view_detail_document_admin');
        Route::get('detail_document_admin/{document_id}', [AdminController::class, 'detail_document_admin'])->name('detail_document_admin');
        Route::get('history_post', [AdminController::class, 'history_post'])->name('history_post');
        Route::POST('view_history_post', [AdminController::class, 'view_history_post'])->name('view_history_post');
        Route::POST('delete_notifi_admin', [AdminController::class, 'delete_notifi_admin'])->name('delete_notifi_admin');
        Route::GET('search_admin', [AdminController::class, 'search_admin'])->name('search_admin');

        // Route::get('download_document/{id}', [UserController::class, 'download_document'])->name('download_document');
        // Route::get('word_export/{id}', [UserController::class, 'word_export'])->name('word_export');
}); 

Route::get('login_user', [RegistersController::class, 'login_user'])->name('login_user');
Route::post('logins_user', [RegistersController::class, 'logins_user'])->name('logins_user');
Route::group([
    'middleware' => CheckingUser::class],function(){
        Route::get('logout_user', [RegistersController::class, 'logout_user'])->name('logout_user');
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('post_document', [UserController::class, 'post_document'])->name('post_document');

        // Route::POST('posts_document', function(Illuminate\Http\Request $request) {
        //     event(new App\Events\NotificationNewDocument($request));
        //     return redirect('post_document');
        // });
        Route::post('posts_document', [UserController::class, 'posts_document'])->name('posts_document');
        
        Route::get('manage_mydocument', [UserController::class, 'manage_mydocument'])->name('manage_mydocument');
        Route::get('edit_mydocument/{id}', [UserController::class, 'edit_mydocument'])->name('edit_mydocument');
        Route::post('edits_mydocument', [UserController::class, 'edits_mydocument'])->name('edits_mydocument');
        Route::post('delete_mydocument', [UserController::class, 'delete_mydocument'])->name('delete_mydocument');
        Route::post('delete_detaildocument_user', [UserController::class, 'delete_detaildocument_user'])->name('delete_detaildocument_user');
        Route::get('filter_document', [UserController::class, 'filter_document'])->name('filter_document');
        Route::POST('view_filter_document', [UserController::class, 'view_filter_document'])->name('view_filter_document');
        Route::get('detail_document/{document_id}', [UserController::class, 'detail_document'])->name('detail_document');
        Route::get('view_detail_document', [UserController::class, 'view_detail_document'])->name('view_detail_document');
        Route::get('history_post_user', [UserController::class, 'history_post_user'])->name('history_post_user');
        Route::POST('view_history_post_user', [UserController::class, 'view_history_post_user'])->name('view_history_post_user');
        Route::GET('search', [UserController::class, 'search'])->name('search');

}); 
Route::group([
    'middleware' => PublicFeature::class],function(){
        Route::get('download_document/{id}', [UserController::class, 'download_document'])->name('download_document');
        Route::get('word_export/{id}', [UserController::class, 'word_export'])->name('word_export');
            
}); 
