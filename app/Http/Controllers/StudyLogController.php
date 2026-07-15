<?php

namespace App\Http\Controllers;

use App\Service\LevelService;
use App\Models\Field;
use App\Models\StudyLog;
use App\Models\Subject;
use App\Models\Code;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;

class StudyLogController extends Controller
{
    public function create()
    {
        $fields = Field::with('subject')->get();
        $subjects = Subject::where('user_id', '=', auth()->id())->get();
        return view('study_log.record-study', compact('fields', 'subjects'));
    }

    public function index()
    {
        $study_logs = StudyLog::where('user_id', '=', auth()->id())->with('subject', 'code')->orderBy('study_date_time', 'desc')->get();
        // dd($study_logs);
        if($study_logs->isEmpty()) {
            session()->flash('none_study_log', 'まだ学習記録がありません。「記録する」ボタンをクリックして学習時間を記録しましょう。');
            return view('study_log.show-study-log');
        }
        // dd(session());

        return view('study_log.show-study-log', compact('study_logs'));
    }

    public function store(Request $request)
    {
        try{
            $validatedStudy = $request->validate([
                'study_date_time' => 'required',
                'hour' => 'required|integer|max:23|min:0',
                'minute' => 'required|integer|max:59|min:0',
                'memo' => 'max:255',
                'subject_id' => 'required|integer',
                ]);
            $validatedStudy['time'] = ($validatedStudy['hour'] * 60) + ($validatedStudy['minute']);
            if($validatedStudy['time'] === 0) {
                $request->session()->flash('store_error_message', '学習記録を保存できませんでした');
                $request->session()->flash('time_error_message', '学習時間は最低1分以上入力してください');
                $request->session()->flash('error_subject_id', $request['subject_id']);
                return redirect()->route('record');
            }
            $validatedStudy['user_id'] = auth()->id();
            unset($validatedStudy['hour'],$validatedStudy['minute']);
            $study_log = StudyLog::create($validatedStudy);

            if(!empty($request->title[0]) || !empty($request->code_body[0])) {

                //すべてのCodeのバリデーションチェックをする
                $validatedCode = $request->validate([
                    'title.*' => 'required|max:255',
                    'code_body.*' => 'required',
                ]);
                // dd($validatedCode);
                for($i = 0; $i < $request['code_count']; $i++){
                    $code = Code::create([
                        'subject_id' => $request['subject_id'],
                        'study_log_id' => $study_log->id,
                        'body' => $request->code_body[$i],
                        'title' => $request->title[$i],
                    ]);
                }
            }
            $totalStudyTime = StudyLog::where('user_id', auth()->id())->sum('time');
            $levelService = new LevelService();
            $level = $levelService->getLevel($totalStudyTime);
            $isLevelUp = $levelService->isLevelUp($level);
            $request->session()->flash('isLevelUp', $isLevelUp);
            $request->session()->flash('record_message', '学習記録を保存しました');
        } catch(Exception $e) {
            $study_log->where('id', '=', $study_log->id)->delete();
            $request->session()->flash('error_subject_id', $request['subject_id']);
            $request->session()->flash('record_message', '学習記録を保存できませんでした');
            return redirect()->route('record');
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
        $totalStudyTime = StudyLog::where('user_id', auth()->id())->sum('time');
        $levelService = new LevelService();
        $level = $levelService->getLevel($totalStudyTime);
        $isLevelUp = $levelService->isLevelUp($level);
        $request->session()->flash('isLevelUp', $isLevelUp);
        $request->session()->flash('edit_message', '学習記録を編集しました');
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
        $request->session()->flash('delete_message', '学習記録を削除しました');
        return redirect()->route('list');
    }
}
