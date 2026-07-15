{{-- <form action="" method="post">

    <flux:modal class="w-[90vw] max-w-5xl!">
        <div class="space-y-10">
            <div>
                <flux:heading size="lg">科目の追加</flux:heading>
            </div>

            <flux:textarea label="科目名" rows="1" placeholder="PHP" name="subject_name" />
            <flux:select placeholder="分野を選択してください">
                <flux:select.option>バックエンド</flux:select.option>
                <flux:select.option>フロントエンド</flux:select.option>
                <flux:select.option>その他</flux:select.option>
            </flux:select>
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
            {{-- <div class="code-input-area my-3 space-y-3">
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
            </div> --}}
            <flux:button type="submit" variant="primary" class="mt-6">記録</flux:button>
        </div>
    </flux:modal>

</form> --}}