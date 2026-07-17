<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudyLogController;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\SubjectController;
use App\Models\Subject;

//ビューを呼ぶ
Route::get('/', [SubjectController::class, 'index'])
->name('home');

//ユーザー登録
Route::get('/register', function() {
    return view('auth.register');
})->name('register');

//クレジットページ
Route::get('/credit', function() {
    return view('credit');
})->name('credit');

Route::middleware(['auth'])->group(function()
{
    //学習記録画面
    Route::get('/record', [StudyLogController::class, 'create'])
    ->name('record');
    
    //学習記録保存
    Route::post('/studylog/record', [StudyLogController::class, 'store'])
    ->name('study.record');
    
    //学習記録一覧
    Route::get('/studylog/list', [StudyLogController::class, 'index'])
    ->name('list');
    
    //学習記録編集
    Route::put('/studylog/edit', [StudyLogController::class, 'update'])
    ->name('study.edit');
    
    //学習記録削除
    Route::delete('/studylog/delete/{study_log}', [StudyLogController::class, 'destroy'])
    ->name('study.delete');
    
    //科目追加
    Route::post('/subject/add', [SubjectController::class, 'store'])
    ->name('subject.store');

    //科目編集
    Route::put('/subject/edit', [SubjectController::class, 'update'])
    ->name('subject.edit');

    //科目削除
    Route::delete('/subject/delete/{subject}', [SubjectController::class, 'destroy'])
    ->name('subject.delete');
});

require __DIR__.'/settings.php';

