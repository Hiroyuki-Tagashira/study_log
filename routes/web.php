<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudyLogController;
use App\Http\Controllers\ModalController;

//ビューを呼ぶ
Route::view('/', 'index')->name('home');

//ユーザー登録
Route::get('/register', function() {
    return view('auth.register');
})->name('register');

//学習記録画面
Route::get('/record', [StudyLogController::class, 'create'])
->name('record');

//学習記録保存
Route::post('/record', [StudyLogController::class, 'store'])
->name('study.record');

//学習記録一覧
Route::get('/list', [StudyLogController::class, 'index'])
->name('list');

//学習記録編集
Route::put('/list', [StudyLogController::class, 'update'])
->name('study.update');

//学習記録削除
Route::delete('/list/{study_log}', [StudyLogController::class, 'destroy'])
->name('study.delete');

//モーダルを呼ぶ
// Route::get('/modal', [ModalController::class, 'modal']);

require __DIR__.'/settings.php';

