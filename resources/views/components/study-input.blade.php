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

<form action="{{ route('study.record') }}" method="post">
    <input type="hidden" name="subject_id" value="{{ $subject->id }}">

    <flux:modal name="{{ $subject->id }}" class="w-[90vw] max-w-5xl!">
        <div class="space-y-10">
            <div>
                <flux:heading size="lg">学習記録の入力</flux:heading>
            </div>

            <flux:input label="日時(必須)" type="datetime-local" name="study_date_time"  />
            <div class="space-y-4">
                <flux:text variant="strong" class="mt-2 font-bold">学習時間(必須)</flux:text>
                <div class="flex space-x-4">
                    <flux:input label="時間" type="number" placeholder="1" value="0" max="23" min="0"
                    name="hour" />
                    <flux:input label="分" type="number" placeholder="30" value="0" max="59" min="0"
                    name="minute" />
                </div>
            </div>
            <flux:textarea label="メモ" rows="3" placeholder="" name="memo" max="255" />
            <div class="code-input-area my-3 space-y-3">
                @for ($i = 0; $i < $count; $i++)
                    <div wire:key="code-{{ $i }}" class="code-input-parts space-y-3 mt-6">
                        <flux:textarea name="title[{{ $i }}]" label="コードタイトル(コードを記録する場合は必須)" rows="1"
                            placeholder="文字列の出力方法" max="255" />
                        <flux:textarea name="code_body[{{ $i }}]" label="コード" rows="20"
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
