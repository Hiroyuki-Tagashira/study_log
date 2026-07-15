<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body>
    <main>
        <div class="flex flex-col space-y-3 justify-center items-center h-screen">
            <h1 class="font-bold">500 | Internal Server Error</h1>
            <p>サーバーでエラーが発生しております。ご迷惑をおかけしております。</p>
            <p>お急ぎの場合は、お手数ですがシステム管理者へご連絡をお願いいたします。</p>
            <a href="{{ route('home') }}" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition text-lg">トップページはこちら</a>
        </div>
    </main>

</body>

</html>
