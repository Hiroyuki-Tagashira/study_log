<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body>
    <header class="w-full">
        <x-header />
    </header>

    <main>
        <div class="mx-auto container justify-between">
            <h2 class="mt-3 text-center text-2xl">学習時間の記録</h2>
            <div class="mt-3 mx-auto max-w-6xl">
                @if (session('record_message'))
                    <div class="text-red-600 font-bold mb-3">
                        {{ session('record_message') }}
                    </div>
                @endif
                @if (count($subjects) !== 0)
                    @foreach ($fields as $field)
                        <div>
                            <h3>{{ $field->field_name }}</h3>
                            <hr class="w-full">
                            <div class="flex flex-row flex-wrap space-x-5 my-3">
                                @foreach ($subjects as $subject)
                                    @if ($subject->field_id === $field->id)
                                        <div
                                            class="mb-3 !h-[125px] !w-[150px] bg-gray-100 hover:bg-gray-200 text-black rounded shadow relative">
                                            <flux:dropdown position="right" align="end"
                                                class="absolute z-10 right-0">
                                                <flux:tooltip content="メニューを表示" class="!text-xl">
                                                    <flux:button variant="ghost"><x-icons.three-leader-icon />
                                                    </flux:button>
                                                </flux:tooltip>
                                                <flux:menu>
                                                    <flux:modal.trigger name="edit-{{ $subject->id }}">
                                                        <flux:menu.item icon="pencil" class="!text-lg">変更
                                                        </flux:menu.item>
                                                    </flux:modal.trigger>

                                                    <flux:modal.trigger name="delete-{{ $subject->id }}">
                                                        <flux:menu.item icon="trash" variant="danger"
                                                            class="!text-lg">削除</flux:menu.item>
                                                    </flux:modal.trigger>
                                                </flux:menu>
                                            </flux:dropdown>

                                            <flux:modal class="w-[90vw] max-w-5xl!" name="edit-{{ $subject->id }}">
                                                <form action="{{ route('subject.edit') }}" method="post">
                                                    @method('put')
                                                    @csrf
                                                    <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                                    <div class="space-y-10">
                                                        <div>
                                                            <flux:heading size="lg">科目の変更</flux:heading>
                                                        </div>
                                                        <flux:textarea label="科目名" rows="1" placeholder="PHP" name="name">
                                                            {{ $subject->name }}
                                                        </flux:textarea>
                                                        <flux:select name='field_id' placeholder="分野を選択してください">
                                                            <flux:select.option value="1" :selected="$subject->field_id === 1">
                                                                バックエンド
                                                            </flux:select.option>
                                                            <flux:select.option value="2" :selected="$subject->field_id === 2">
                                                                フロントエンド
                                                            </flux:select.option>
                                                            <flux:select.option value="3" :selected="$subject->field_id === 3">
                                                                その他
                                                            </flux:select.option>
                                                        </flux:select>
                                                        <flux:button type="submit" variant="primary" class="mt-6">変更
                                                        </flux:button>
                                                    </div>
                                                </form>
                                            </flux:modal>

                                            <flux:modal name="delete-{{ $subject->id }}" class="min-w-[25rem]">
                                                <form action="{{ route('subject.delete', $subject) }}" method="post"
                                                    class="items-center space-x-1">
                                                    @method('delete')
                                                    @csrf
                                                    <flux:heading size="lg">科目を削除するとその科目のすべての学習記録、</flux:heading>
                                                    <flux:heading size="lg">コードも削除されます。科目を削除しますか？</flux:heading>
                                                    <div class="flex space-x-2">
                                                        <flux:modal.close class="w-1/2">
                                                            <flux:button class="mt-6 w-full">キャンセル</flux:button>
                                                        </flux:modal.close>
                                                        <flux:button type="submit" variant="danger" class="mt-6 w-1/2">
                                                            削除</flux:button>
                                                    </div>
                                                </form>
                                            </flux:modal>


                                            <flux:modal.trigger name="{{ $subject->id }}" class="absolute z-0">
                                                <flux:button variant="ghost"
                                                    class="!h-[125px] !w-[150px] text-center !break-words !whitespace-normal ">
                                                    {{ $subject->name }}</flux:button>
                                            </flux:modal.trigger>
                                            <livewire:study-input :subject="$subject" />
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="my-5 text-2xl font-bold">「科目を追加する」ボタンをクリックして、科目を追加しましょう。</p>
                @endif
                <flux:modal.trigger name="add-subject">
                    <flux:button variant="primary"
                        class="!h-[50px] !w-full text-xl bg-blue-500 hover:bg-blue-400 text-white">
                        <x-icons.add-subject-icon />
                        科目を追加する
                    </flux:button>
                </flux:modal.trigger>
                <form action="{{ route('subject.store') }}" method="post">
                    @csrf
                    <flux:modal class="w-[90vw] max-w-5xl!" name="add-subject">
                        <div class="space-y-10">
                            <div>
                                <flux:heading size="lg">科目の追加</flux:heading>
                            </div>
                            <flux:textarea label="科目名" rows="1" placeholder="PHP" name="name" />
                            <flux:select name='field_id' placeholder="分野を選択してください">
                                <flux:select.option value="1">バックエンド</flux:select.option>
                                <flux:select.option value="2">フロントエンド</flux:select.option>
                                <flux:select.option value="3">その他</flux:select.option>
                            </flux:select>
                            <flux:button type="submit" variant="primary" class="mt-6">追加</flux:button>
                        </div>
                    </flux:modal>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <x-footer />
    </footer>

    @fluxScripts
    @livewireScripts
</body>

</html>
