<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\StudyLog;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::where('user_id', '=', auth()->id())->with('study_log')->get();
        $subject_times = [];
        foreach ($subjects as $subject) {
            $total_time = 0;
            foreach ($subject->study_log as $study_log) {
                $total_time += $study_log->time;
            }
            // まだ学習記録がない科目はここで除外する
            if ($total_time !== 0) {
                $subject_times[$subject->name] = $total_time;
            }
        }
        $todayStudyTime = StudyLog::whereDate('study_date_time', today())->where('user_id', auth()->id())->sum('time');
        $sevenDays = Carbon::today()->subDay(6);    // 今日の日付から6日前の日付を取得
        $weeklyStudyTime = StudyLog::whereDate('study_date_time', '>=', $sevenDays)->where('user_id', auth()->id())->sum('time');
        $totalStudyTime = StudyLog::where('user_id', auth()->id())->sum('time');
        $study_logs = StudyLog::where('user_id', '=', auth()->id())->with('subject', 'code')->orderBy('study_date_time', 'desc')->get();

        return view('index', compact('subject_times', 'todayStudyTime', 'weeklyStudyTime', 'totalStudyTime', 'study_logs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'field_id' => 'required',
                ]);
            $validated['user_id'] = auth()->id();
            $subject = Subject::create($validated);
            session()->flash('record_message', '科目を登録しました');            
            return redirect()->route('record');
        } catch(Exception $e) {
            $request->session()->flash('record_message', '科目を登録できませんでした');
            return redirect()->route('record');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'field_id' => 'required',
                ]);
            $validated['user_id'] = auth()->id();
            $hasSubject = Subject::where('id', '=', $request->subject_id);
            if($hasSubject->exists()) {
                $hasSubject->update($validated);
                session()->flash('record_message', '科目を変更しました');
            }
        } catch(Exception $e) {
            $request->session()->flash('record_message', '科目を変更できませんでした');
            return redirect()->route('record');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Subject $subject)
    {
        $subject->code()->delete();
        $subject->study_log()->delete();
        $subject->delete();
        $request->session()->flash('record_message', '科目を削除しました');

        return redirect()->route('study.record');
    }
}
