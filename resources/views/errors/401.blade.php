<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body>
    <main>
        <div class="flex flex-col space-y-3 justify-center items-center h-screen">
            <h1 class="font-bold">401 | Unauthorized</h1>
            <p>ログインが必要です。認証後に再度お試しください。</p>
            <a href="{{ route('login') }}" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition text-lg">トップページはこちら</a>
        </div>
    </main>

</body>

</html>
