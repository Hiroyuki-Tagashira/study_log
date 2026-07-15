<?php

use Livewire\Component;
use App\Models\Code;
use Carbon\Carbon;

new class extends Component {
    public $count = 1;
    public $subject;
    // public $defaultDateTime = Carbon::now()->isoFormat('YYYY-MM-DDTHH:mm');

    public function addInput()
    {
        $this->count++;
    }
};

?>
<div>
    <form action="{{ route('study.record') }}" method="post">
        @csrf
        <input type="hidden" name="subject_id" value="{{ $subject->id }}">

        <flux:modal name="{{ $subject->id }}" class="w-[90vw] max-w-5xl!">
            <div class="space-y-5">
                <div>
                    <flux:heading size="lg">学習記録の入力</flux:heading>
                </div>
                <div>
                    <flux:heading size="lg">{{ $subject->name }}</flux:heading>
                </div>
                @if (session('store_error_message') && $subject->id === (int) session('error_subject_id'))
                    <div class="text-red-600 font-bold">
                        {{ session('store_error_message') }}
                    </div>
                @endif
                @if ($errors->has('date'))
                    <span class="text-red-600 bold">{{ $errors->first('date') }}</span>
                @endif
                <flux:input label="日時(必須)" type="datetime-local" name="study_date_time" value="{{ $now }}"
                    max="{{ $now }}" />
                <div class="space-y-4">
                    @if (session('time_error_message') && $subject->id === (int) session('error_subject_id'))
                        <div class="text-red-600 font-bold">
                            {{ session('time_error_message') }}
                        </div>
                    @endif
                    <flux:text variant="strong" class="mt-2 font-bold">学習時間(必須)</flux:text>
                    <div class="flex space-x-4">
                        <flux:input label="時間" type="number" placeholder="0" value="{{ old('hour', 0) }}"
                            max="23" min="0" name="hour" />
                        <flux:input label="分" type="number" placeholder="0" value="{{ old('minute', 0) }}"
                            max="59" min="0" name="minute" />
                    </div>
                </div>
                <flux:textarea label="メモ" rows="3" placeholder="" name="memo" max="255"></flux:textarea>
                <div class="code-input-area my-3 space-y-3">
                    @for ($i = 0; $i < $count; $i++)
                    <div wire:key="code-{{ $i }}" class="code-input-parts space-y-3 mt-6">
                            {{-- @if ($errors->has('code_title'))
                                <span class="text-red-600 bold">{{ $errors->first('code_title') }}</span>
                            @endif --}}
                            <flux:textarea name="title[{{ $i }}]" label="コードタイトル(コードを記録する場合は必須)"
                            rows="1" placeholder="文字列の出力方法" max="255" />
                            {{-- @if ($errors->has('code_'))
                                <span class="text-red-600 bold">{{ $errors->first('code_title') }}</span>
                            @endif --}}
                            <flux:textarea name="code_body[{{ $i }}]" label="コード" rows="20" columns="120"
                                resize="both" placeholder="console.log('Hello,world!');" />
                        </div>
                    @endfor
                    <flux:button wire:click="addInput" variant="primary" tabindex="-1">
                        コード入力欄を追加
                    </flux:button>
                </div>
                <input type="hidden" name="code_count" value="{{ $count }}">
                <flux:button type="submit" variant="primary" class="mt-6">記録</flux:button>
            </div>
        </flux:modal>

    </form>
    @if (session('error_subject_id'))
        @php
            $error_subject_id = session('error_subject_id');
        @endphp
        <script>
            const error_subject_id = @json($error_subject_id);
            window.addEventListener('load', () => {
                Flux.modal(error_subject_id).show();
            });
        </script>
    @endif
</div>
