<?php

namespace App\Http\Controllers;
use App\Models\Field;
use App\Models\StudyLog;
use App\Models\Subject;
use App\Models\Code;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StudyLogController extends Controller
{
    public function create()
    {
        $fields = Field::with('subject')->get();
        return view('study_log.record-study', compact('fields'));
    }

    public function index()
    {
        $study_logs = StudyLog::with('subject', 'code')->orderBy('study_date_time', 'desc')->get();
        // dd($study_logs);
        if($study_logs->isEmpty()) {
            session()->flash('nothing', '学習時間を記録しましょう');
            return view('study_log.show-study-log');
        }

        $todayStudyTime = StudyLog::whereDate('study_date_time', today())->sum('time');
        $sevenDays = Carbon::today()->subDay(7);    //今日の日付から７日前の日付を取得
        $weeklyStudyTime = StudyLog::whereDate('study_date_time', '>=', $sevenDays)->sum('time');
        $totalStudyTime = StudyLog::all()->sum('time');
        return view('study_log.show-study-log', compact('study_logs', 'todayStudyTime', 'weeklyStudyTime', 'totalStudyTime'));
    }

    public function store(Request $request)
    {
        $validatedStudy = $request->validate([
            'study_date_time' => 'required',
            'hour' => 'required|integer|max:23|min:0',
            'minute' => 'required|integer|max:59|min:0',
            'memo' => 'max:255',
            'subject_id' => 'required|integer',
        ]);
        $validatedStudy['time'] = ($validatedStudy['hour'] * 60) + ($validatedStudy['minute']);
        unset($validatedStudy['hour'],$validatedStudy['minute']);
        $validatedStudy['user_id'] = auth()->id();

        $study_log = StudyLog::create($validatedStudy);
        // dd($request);
        // codeはbodyが入力されていれば保存する。
        if(!empty($request->code_body[0])) {
            //すべてCodeのバリデーションチェックをする
            $validatedCode = $request->validate([
                'title.*' => 'required|max:255',
                'code_body.*' => 'required',
            ]);
            for($i = 0; $i < $request['code_count']; $i++){
                $code = Code::create([
                    'subject_id' => $request['subject_id'],
                    'study_log_id' => $study_log->id,
                    'body' => $request->code_body[$i],
                    'title' => $request->title[$i],
                ]);
            }
        }
        if(!empty($study_log)) {
            $request->session()->flash('message', '学習記録を保存しました');
        } else {
            $request->session()->flash('message', '学習記録を保存できませんでした');
        }
        return redirect()->route('record');
    }

    public function edit(string $id)
    {
        
    }

    public function update(Request $request)
    {
        // dd($request);
        $validatedStudy = $request->validate([
            'study_date_time' => 'required',
            'hour' => 'required|integer|max:23|min:0',
            'minute' => 'required|integer|max:59|min:0',
            'memo' => 'max:255',
            'subject_id' => 'required|integer',
        ]);

        $validatedStudy['time'] = ($validatedStudy['hour'] * 60) + ($validatedStudy['minute']);
        unset($validatedStudy['hour'],$validatedStudy['minute']);
        $validatedStudy['user_id'] = auth()->id();

        $hasStudyLog = StudyLog::where('id', '=', $request->study_log_id);
        if($hasStudyLog->exists()) {
            $hasStudyLog->update($validatedStudy);
        }
        if(!empty($request->code_id)){
            
            $validatedCode = $request->validate([
                'title.*' => 'required|max:255',
                'code_body.*' => 'required',
                ]);
                // dd($request);
            forEach($request->code_id as $id){
                // dd($request->title[$id]);
                $hasCode = Code::where('id', '=', $id);
                if($hasCode->exists()){
                    $hasCode->update([
                        'subject_id' => $request['subject_id'],
                        'study_log_id' => $request->study_log_id,
                        'title' => $request->title[$id],
                        'body' => $request->code_body[$id],
                    ]);
                }
            }
            }
            
        $request->session()->flash('message', '学習記録を編集しました');
        // if(!empty($study_log)) {
            
        // } else {
        //     $request->session()->flash('message', '学習記録を編集できませんでした');
        // }
        return redirect()->route('list');

    }

    public function destroy(Request $request, StudyLog $study_log)
    {
        $study_log->code()->delete();
        $study_log->delete();
        $request->session()->flash('message', '学習記録を削除しました');
        return redirect()->route('list');
    }
}
