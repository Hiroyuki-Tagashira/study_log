<!DOCTYPE html>
<html lang="ja">

<head>
    @include('partials.head')

</head>

<body>
    <header class="w-full">
        <x-header />
    </header>

    <main>

        <div class="w-[1300px] mx-auto py-2 space-y-5">
            <h2 class="text-3xl">Credits</h2>
            <p>Images</p>
            <x-icons.app-logo-large-icon />
            <a class="block" href="https://www.magnific.com/jp/free-vector/tiny-cute-children-learning-coding_12291302.htm#fromView=search&page=1&position=10&uuid=e16fb00e-3252-48a4-bfdb-d783258d16b4&query=%E3%83%97%E3%83%AD%E3%82%B0%E3%83%A9%E3%83%9F%E3%83%B3%E3%82%B0%E3%80%80%E3%82%A4%E3%83%A9%E3%82%B9%E3%83%88">
                著作者：pch.vector/出典：Magnific
            </a>
            <x-icons.levelup-icon />
            <a class="block" href="https://www.magnific.com/jp/free-photo/corporate-culture-composition-with-computer-windows-arrows-gear-icons-trophy-cup-doodle-characters-coworkers-vector-illustration_43868808.htm#fromView=search&page=1&position=11&uuid=8abca356-00ef-465a-8160-b51cfd3ab265&query=%E3%82%B9%E3%82%AD%E3%83%AB%E3%82%A2%E3%83%83%E3%83%97+%E3%82%A4%E3%83%A9%E3%82%B9%E3%83%88?log-in=google">
                著作者：macrovector/出典：Magnific
            </a>
            <div class="flex justify-center">
                <a href="{{ route('home') }}" class="w-1/3  bg-blue-500 text-center text-white py-2 px-4 rounded-md hover:bg-blue-600 transition text-lg">トップページはこちら</a>
            </div>
        </div>
    </main>

    <footer>
        <x-footer />
    </footer>
    {{-- @vite('resources/js/subjectBarChart.js'); --}}
</body>

</html>
