<div class="w-[1300px] mx-auto py-2 flex items-center container justify-between ">
    <div class="flex space-x-5">
        <a href="{{ route('home') }}" class="h-15 flex items-center">
            <x-icons.app-logo-icon />
            <h1 class="text-4xl">StudyLog</h1>
        </a>
        @auth
            <div>
                <p>ようこそ、{{ Auth::user()->name }}さん</p>
                <div class="flex space-x-3">
                    <p class="text-blue-700 font-bold text-2xl">Lv.{{ $level }}</p>
                    <div class="levelarea w-64 h-7 flex items-center bg-gray-700 px-1 rounded">
                        <p class="me-1 text-sky-400 font-semibold">EXP</p>
                        <div class="exp-bar h-5 w-full bg-white rounded shadow">
                            <div class="exp-fill h-full w-0 bg-gradient-to-br from-blue-600 via-blue-400 to-blue-100 rounded"
                                id="exp-fill" style="transition:width 1.5s ease;"></div>
                        </div>
                    </div>
                    <p>次のレベルまであと{{ $nextLevelExp }}分です</p>
                </div>
            </div>
            <script>
                // const nextLevelExp = @json($nextLevelExp);
                const percent = @json($percent);
                window.addEventListener('load', () => {
                    document.getElementById('exp-fill').style.width = percent + '%';
                });
            </script>
        @endauth
    </div>
    <div class="space-x-5">
        @auth
            <flux:button variant="primary" onclick="location.href='{{ route('record') }}'"
                class="bg-white hover:bg-gray-200 text-black border border-gray-200 rounded shadow">
                記録する
            </flux:button>
            <flux:button variant="primary" onclick="location.href='{{ route('list') }}'"
                class="bg-white hover:bg-gray-200 text-black border border-gray-200 rounded shadow">
                学習履歴
            </flux:button>
            <form method="post" action="{{ route('logout') }}" class="inline">
                @csrf
                <flux:button type="submit" variant="primary"
                    class="bg-blue-500 hover:bg-blue-400 text-white font-semibold py-2 px-5
            border border-gray-200 rounded shadow">
                    ログアウト
                </flux:button>

            </form>
        @else
            <flux:button type="submit" variant="primary" href="{{ route('login') }}"
                class="bg-white hover:bg-gray-200 text-black border border-gray-200 rounded shadow">
                ログイン
            </flux:button>

            <flux:button type="submit" variant="primary" href="{{ route('register') }}"
                class="bg-blue-500 hover:bg-blue-400 text-white font-semibold py-2 px-5
        border border-gray-200 rounded shadow">
                新規登録
            </flux:button>
            {{-- <a href="{{ route('') }}"
        class="bg-blue-500 hover:bg-blue-400 text-white font-semibold py-2 px-6
        border border-gray-200 rounded shadow">登録</a> --}}
        @endauth
    </div>
</div>
<hr>
