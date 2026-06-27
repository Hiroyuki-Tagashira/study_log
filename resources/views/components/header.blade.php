@auth
    <button onclick="location.href='{{ route('record') }}'"
        class="bg-indigo-600 hover:bg-indigo-400 text-white font-semibold py-2 px-5 border border-gray-200 rounded shadow">
        記録する
    </button>
    <button onclick="location.href='{{ route('list') }}'"
        class="bg-indigo-600 hover:bg-indigo-400 text-white font-semibold py-2 px-5 border border-gray-200 rounded shadow">
        学習履歴
    </button>    
    <form method="post" action="{{ route('logout') }}" class="inline">
        @csrf
        <button type="submit"
            class="bg-indigo-600 hover:bg-indigo-400 text-white font-semibold py-2 px-5
            border border-gray-200 rounded shadow">
            ログアウト
        </button>
    </form>
@else
    <form method="get" action="{{ route('login') }}" class="inline">
        @csrf
        <flux:button type="submit" variant="primary"
            class="bg-indigo-600 hover:bg-indigo-400 text-white font-semibold py-2 px-5
            border border-gray-200 rounded shadow">
            ログイン
        </flux:button>
    </form>
    <a href="{{ route('register') }}"
        class="bg-indigo-600 hover:bg-indigo-400 text-white font-semibold py-2 px-6
            border border-gray-200 rounded shadow">登録</a>
@endauth
