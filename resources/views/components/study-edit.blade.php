{{-- <form action="{{ route('study.update') }}" method="post">
    @method('put')
    <input type="hidden" name="study_log_id" value="{{ $study_log->id }}">
    <input type="hidden" name="subject_id" value="{{ $study_log->subject->id }}">

    <flux:modal name="{{ $code->id }}" class="w-[90vw] max-w-5xl!">
        <div class="space-y-10">
            <div>
                <flux:heading size="lg">学習記録の編集</flux:heading>
            </div>
            <flux:input label="日時(必須)" type="datetime-local" name="study_date_time"
                value="{{ $study_log->formatted_study_date_time_iso }}" />
            <flux:text variant="strong" class="mt-2">学習時間(必須)</flux:text>
            <div class="flex gap-4">
                <flux:input label="時間" type="number" placeholder="1" value="0"
                    max="23" min="0" name="hour"
                    value="{{ $study_log->get_hours }}" />
                <flux:input label="分" type="number" placeholder="30" value="0"
                    max="59" min="0" name="minute"
                    value="{{ $study_log->get_minutes }}" />
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
    </flux:modal>

</form> --}}
