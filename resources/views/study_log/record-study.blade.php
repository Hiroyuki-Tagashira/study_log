<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body>
    <header class="w-full">
        <div class="mx-auto px-3 flex items-center border border-blue-600 container justify-between">
            <div>
                <a href="" class="h-15 flex items-center">
                    <x-app-logo-icon />
                    <h1 class="text-4xl ">StudyLog</h1>
                </a>
            </div>
            <div class="space-x-3">
                <x-header />
            </div>
        </div>
    </header>

    <main>
        <div class="mx-auto px-3 border border-orange-600 container justify-between">
            <h2 class="text-center text-2xl">学習時間の記録</h2>
            <div class="mt-3 mx-auto max-w-6xl">
                @if(session('message'))
                    <div class="text-red-600 font-bold">
                        {{ session('message') }}
                    </div>
                @endif
                @foreach ($fields as $field)
                    <div class="mt-3">
                        <h3>{{ $field->field_name }}</h3>
                        <div class="flex space-x-5">
                            @foreach ($field->subject as $subject)
                                <flux:modal.trigger name="{{ $subject->id }}">
                                    <flux:button>{{ $subject->name }}</flux:button>
                                </flux:modal.trigger>
                                <livewire:study-input :subject="$subject" />
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>

        </div>

    </main>
    @fluxScripts
    @livewireScripts
</body>

</html>
