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
        <div class="mx-auto px-3 mt-3 items-center max-w-6xl container justify-between">
            @if (session('none_study_log'))
                <div class="text-2xl text-red-600 font-bold">
                    {{ session('none_study_log') }}
                </div>
            @else
                @if (session('edit_message'))
                    <div class="text-2xl text-red-600 font-bold">
                        {{ session('edit_message') }}
                    </div>
                @endif
                @if (session('delete_message'))
                    <div class="text-2xl text-red-600 font-bold">
                        {{ session('delete_message') }}
                    </div>
                @endif


                {{-- 学習履歴一覧を表示 --}}
                <livewire:study-log-filter />
                {{-- @foreach ($study_logs as $study_log)
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
                                <div class="flex space-x-3">
                                    <div>
                                        <p>コードタイトル：{{ $code->title }}</p>
                                        <div>
                                            <flux:button size="xs" variant="primary"
                                                class="accordion-header bg-gray-500 hover:bg-gray-700"
                                                aria-expanded="false">コードを見る</flux:button>
                                            <pre class="accordion-content hidden rounded bg-gray-100 my-3 p-3" aria-hidden="true">{{ $code->body }}</pre>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <div class="flex justify-end space-x-5">
                            <flux:modal.trigger name="{{ $code->id }}">
                                <flux:button><x-icons.study-edit-icon />編集</flux:button>
                            </flux:modal.trigger>
                            <form action="{{ route('study.update') }}" method="post">
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

                            </form>
                            <flux:modal.trigger name="delete{{ $study_log->id }}">
                                <flux:button><x-icons.study-delete-icon />削除</flux:button>
                            </flux:modal.trigger>
                            <form action="{{ route('study.delete', $study_log) }}" method="post" class="flex items-center space-x-1">
                                @method('delete')
                                <flux:modal name="delete{{ $study_log->id }}" class="min-w-[22rem]">
                                    <flux:heading size="lg">学習記録を削除しますか？</flux:heading>
                                    <div class="flex space-x-2">
                                        <flux:modal.close class="w-1/2">
                                            <flux:button class="mt-6 w-full">キャンセル</flux:button>
                                        </flux:modal.close>
                                        <flux:button type="submit" variant="danger" class="mt-6 w-1/2" >削除</flux:button>
                                    </div>
                                </flux:modal>
                            </form>
                        </div>
                        {{-- <p class="text-xl">学習時間:{{ $study_log->created_at}}</p> --}}
                {{-- @endforeach --}}
        </div>
        @endif
        
    </main>

    <footer>
        <x-footer />
    </footer>

    @fluxScripts
    @livewireScripts
    {{-- @vite('resources/js/accordion.js') --}}
</body>

</html>
