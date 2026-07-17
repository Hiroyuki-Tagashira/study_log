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
        @auth
            <div class="w-300 mx-auto mt-3">
                @if (count($subject_times) === 0)
                    <p class="mt-3 text-2xl font-bold">はじめまして、{{ Auth::user()->name }}さん。まずは「記録する」ボタンをクリックして、学習を記録しましょう</p>
                @else
                <h2 class="text-lg mb-3">これまでの学習時間</h2>
                <div class="w-full mb-5 flex py-1 justify-around text-center bg-gray-100 rounded-xl">
                    <div>
                        <p>今日</p>
                        <p class="text-lg"> {{ $study_logs->first()->todayStudyTime($todayStudyTime) }}</p>
                    </div>
                    <div>
                        <p>1週間</p>
                        <p class="text-lg">{{ $study_logs->first()->todayStudyTime($weeklyStudyTime) }}</p>
                    </div>
                    <div>
                        <p>トータル</p>
                        <p class="text-lg">{{ $study_logs->first()->todayStudyTime($totalStudyTime) }}</p>
                    </div>
                </div>

                {{-- <h3 class="text-2xl">学習時間の推移</h3>
                <div>
                    <canvas id="chart"></canvas>

                </div> --}}
                    <h2 class="text-lg">あなたの累計学習時間</h2>
                    <x-charts.subjects-chart :subject_times="$subject_times" />
                @endif
            </div>
        @else
            <div class="flex justify-center space-x-10 mt-5">
                <div class="w-2/5 flex flex-col items-center">
                    <x-icons.app-logo-large-icon />
                    <p class="text-3xl">プログラミング学習をもっとやりやすく</p>
                    <div class="text-xl my-3">
                        <p>本サイトはプログラミングに特化した学習管理サイトです。</p>
                        <p>プログラミング学習をしていて、こう思うことはありませんか？</p>
                        <p>「今どの分野の、どの科目をどれくらい勉強してたっけ?」</p>
                        <p>「コードをあとで見返したい」</p>
                        <p>StudyLogなら、こんな悩みを解決できます。</p>
                    </div>
                </div>
                <div>
                    <x-icons.sample-icon />
                </div>
            </div>
        @endauth


    </main>

    <footer>
        <x-footer />
    </footer>
    {{-- @vite('resources/js/subjectBarChart.js'); --}}
</body>

</html>
