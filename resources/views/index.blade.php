<!DOCTYPE html>
<html lang="ja">

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
        <div class="container mx-auto border border-orange-600 ">
            <div>
                <x-home />
            </div>
        </div>
    </main>

    <footer>

    </footer>
</body>

</html>
