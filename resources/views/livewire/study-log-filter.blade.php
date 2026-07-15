<?php

use Livewire\Component;
use App\Models\StudyLog;
use App\Models\Subject;
use App\Models\Code;

new class extends Component {
    //検索ワードを入れるためのプロパティ　ビューのwire:model.live="search"と連携する
    public $search_subject = '';
    public $search_code = '';

    // $study_logs = StudyLog::where('user_id', '=', auth()->id())->with('subject', 'code')->orderBy('study_date_time', 'desc')->get();

    public function render()
    {
        $selected_subjects = Subject::where('user_id', '=', auth()->id())->get();
        //クエリビルダにはあらかじめユーザーで検索するsqlを入れておく
        $query = StudyLog::query()->where('user_id', '=', auth()->id());
        $query_code = Code::query();

        //科目、コードタイトル両方
        if (!empty($this->search_subject) && !empty($this->search_code)) {
            $query->where('subject_id', '=', $this->search_subject);
            $query_code->where('title', 'like', '%' . $this->search_code . '%');
            $selected_codes = $query_code->get();
            $ids = [];
            foreach ($selected_codes as $selected_code) {
                $ids[] = $selected_code->study_log_id;
            }
            //科目で絞る→ユーザーidで絞る
            $study_logs = $query->whereIn('id', $ids)->with('subject', 'code')->orderBy('study_date_time', 'desc')->get();
            // dd($study_logs);
            //科目
        } elseif (!empty($this->search_subject)) {
            $query->where('subject_id', '=', $this->search_subject);
            $study_logs = $query->with('subject', 'code')->orderBy('study_date_time', 'desc')->get();
            //コードタイトル
        } elseif (!empty($this->search_code)) {
            $query_code->where('title', 'like', '%' . $this->search_code . '%');
            $selected_codes = $query_code->get();
            $ids = [];
            foreach ($selected_codes as $selected_code) {
                $ids[] = $selected_code->study_log_id;
            }
            $study_logs = $query->whereIn('id', $ids)->with('subject', 'code')->orderBy('study_date_time', 'desc')->get();
            //初期状態
        } else {
            $study_logs = $query->with('subject', 'code')->orderBy('study_date_time', 'desc')->get();
        }
        return view('study-log-filter', compact('study_logs', 'selected_subjects'));
    }
};
?>

<div>
    <div class="bg-gray-100 rounded p-3">
        <div class="flex mb-3">
            <x-icons.search-icon />
            <p>学習履歴を探す</p>
        </div>
        <div class="w-full flex mb-3 justify-between">
            {{-- debounce.300ms:入力し終わって150ms後にリクエストを送る --}}
            <div class="!w-md !max-lg:w-xs">
                <flux:select wire:model.live.debounce.150ms="search_subject" name='subject_id' label="科目名">
                    <flux:select.option value="" selected>全科目</flux:select.option>
                    @foreach ($selected_subjects as $selected_subject)
                        <flux:select.option value="{{ $selected_subject->id }}">{{ $selected_subject->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div class="!w-md !max-lg:w-xs">
                <flux:textarea wire:model.live.debounce.150ms="search_code" type="text" label="コードタイトル"
                    name="code_title" rows="1" resize="none"></flux:textarea>
                {{-- <p wire:loading class="text-gray-500">検索中...</p> --}}
            </div>
        </div>
    </div>
    @if (count($study_logs) === 0)
        <p class="mt-3 text-2xl text-red-600 font-bold">学習記録がありません</p>
    @endif
    @foreach ($study_logs as $study_log)
        <div wire:key="study_log-{{ $study_log->id }}" class="my-3">
            <div class="flex justify-between">
                <p class="text-xl">{{ $study_log->subject->name }}</p>
                <p>{{ $study_log->formatted_study_date_time }}</p>
            </div>
            <div class="flex space-x-3">
                <x-icons.study-time-icon />
                <p>{{ $study_log->study_time }}</p>
            </div>
            @if ($study_log->memo)
                <div class="flex space-x-3 mb-3">
                    <x-icons.study-memo-icon />
                    <p>{{ $study_log->memo }}</p>
                </div>
            @endif
            @if ($study_log->code)
                @foreach ($study_log->code as $code)
                    <p>コードタイトル：{{ $code->title }}</p>
                    <details class="w-full">
                        <summary class="cursor-pointer w-30 p-2 rounded bg-gray-100 hover:bg-gray-300 shadow">コードを見る</summary>
                        <pre class="w-full rounded bg-gray-100 my-3 p-3 break-all whitespace-pre-wrap">{{ $code->body }}</pre>
                    </details>
                @endforeach
            @endif
            <div class="flex justify-end mb-1">
                <flux:dropdown position="right" align="end">
                    <flux:tooltip content="メニューを表示" class="!text-xl">
                        <flux:button variant="ghost"><x-icons.three-leader-icon /></flux:button>
                    </flux:tooltip>
                    <flux:menu>
                        <flux:modal.trigger name="edit-{{ $study_log->id }}">
                            <flux:menu.item icon="pencil" class="!text-lg">編集</flux:menu.item>
                        </flux:modal.trigger>

                        <flux:modal.trigger name="delete-{{ $study_log->id }}">
                            <flux:menu.item icon="trash" variant="danger" class="!text-lg">削除</flux:menu.item>
                        </flux:modal.trigger>
                    </flux:menu>
                </flux:dropdown>

                <flux:modal name="edit-{{ $study_log->id }}" class="w-[90vw] max-w-5xl!">
                    <form action="{{ route('study.edit') }}" method="post">
                        @method('put')
                        @csrf
                        <input type="hidden" name="study_log_id" value="{{ $study_log->id }}">
                        <input type="hidden" name="subject_id" value="{{ $study_log->subject->id }}">
                        <div class="space-y-10">
                            <div>
                                <flux:heading size="lg">学習記録の編集</flux:heading>
                            </div>
                            <flux:input label="日時(必須)" type="datetime-local" name="study_date_time"
                                value="{{ $study_log->formatted_study_date_time_iso }}" />
                            <flux:text variant="strong" class="mt-2">学習時間(必須)</flux:text>
                            <div class="flex gap-4">
                                <flux:input label="時間" type="number" placeholder="1" value="0" max="23"
                                    min="0" name="hour" value="{{ $study_log->get_hours }}" />
                                <flux:input label="分" type="number" placeholder="30" value="0" max="59"
                                    min="0" name="minute" value="{{ $study_log->get_minutes }}" />
                            </div>
                            <flux:textarea label="メモ" name="memo" max="255">
                                {{ $study_log->memo }}
                            </flux:textarea>
                            <div class="code-input-area my-3 space-y-3">
                                @foreach ($study_log->code as $code)
                                    <div class="code-input-parts space-y-3 mt-6">
                                        <input type="hidden" name="code_id[]" value="{{ $code->id }}">
                                        <flux:textarea name="title[{{ $code->id }}]" label="コードタイトル"
                                            max="255">
                                            {{ $code->title }}
                                        </flux:textarea>
                                        <flux:textarea name="code_body[{{ $code->id }}]" rows="20"
                                            label="コード" resize="both">
                                            {{ $code->body }}
                                        </flux:textarea>
                                    </div>
                                @endforeach
                            </div>
                            <flux:button type="submit" variant="primary" class="mt-6">記録</flux:button>
                        </div>
                    </form>
                </flux:modal>

                <flux:modal name="delete-{{ $study_log->id }}" class="min-w-[22rem]">
                    <form action="{{ route('study.delete', $study_log) }}" method="post"
                        class="items-center space-x-1">
                        @method('delete')
                        @csrf
                        <flux:heading size="lg">学習記録を削除しますか？</flux:heading>
                        <div class="flex space-x-2">
                            <flux:modal.close class="w-1/2">
                                <flux:button class="mt-6 w-full">キャンセル</flux:button>
                            </flux:modal.close>
                            <flux:button type="submit" variant="danger" class="mt-6 w-1/2">削除</flux:button>
                        </div>
                    </form>
                </flux:modal>

            </div>
            @if (!$loop->last)
                <hr>
            @endif
        </div>
    @endforeach
</div>
