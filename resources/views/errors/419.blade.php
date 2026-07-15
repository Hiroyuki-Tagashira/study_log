<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body>
    <main>
        <div class="flex flex-col space-y-3 justify-center items-center h-screen">
            <h1 class="font-bold">419 | Page Expired</h1>
            <p>セッションの有効期限が切れました。ページを再読み込みするか、最初からやり直してください。</p>
            <a href="{{ route('home') }}" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition text-lg">トップページはこちら</a>
        </div>
    </main>

</body>

</html>
