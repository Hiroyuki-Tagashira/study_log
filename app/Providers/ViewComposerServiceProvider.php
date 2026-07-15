<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\StudyLog;
use App\Service\LevelService;
use Illuminate\Support\Facades\Auth;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function($view) {
            
            if(Auth::user() !== null) {
                //show-study-logのトータル学習時間用
                $totalStudyTime = StudyLog::where('user_id', auth()->id())->sum('time');

                //headerのレベル表示用
                $levelService = new LevelService();
                $level = $levelService->getLevel($totalStudyTime);
                $nextLevelExp = $levelService->getNextLevelExp($level, $totalStudyTime);
                $percent = $levelService->getPercent($level, $totalStudyTime, $nextLevelExp);
                $view->with('level', $level);
                $view->with('nextLevelExp', $nextLevelExp);
                $view->with('percent', $percent);

                //study-inputの日付入力欄のデフォルト値用
                $now = Carbon::now()->format('Y-m-d\TH:i');
                $view->with('now', $now);
            }
        });
    }
}
