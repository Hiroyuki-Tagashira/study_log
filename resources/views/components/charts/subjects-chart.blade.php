{{-- indexから受け取った変数を使えるようにする --}}
@props(['subject_times'])

{{-- 1279px以下では親のサイズに合わせる --}}
<div class="w-[1300px] h-125 max-xl:w-full px-5 mx-auto">
    <canvas id="subject-chart" class="h-full"></canvas>
    <script>
        // const $chart = document.getElementById('subject-chart');
        let subject_times = @json($subject_times);
        console.log(subject_times);
        let ctx = document.getElementById('subject-chart').getContext('2d');
        let maxTime = Math.max(...Object.values(subject_times));
        //stepは300分以下は60分、600分以下は120分というように5時間増える毎に調整する
        let step = (Math.floor(maxTime / 300) + 1) * 60;
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(subject_times),
                datasets: [{
                    label: '科目別学習時間',
                    data: Object.values(subject_times),
                    //バーの最大幅　科目数が少ない時にはこのサイズになる
                    maxBarThickness: 50,
                    color: 'rgba(255, 255, 255)',
                    font: {
                        weight: 'bold'
                    },
                    // barThickness: 50,
                    anchor: 'end', // データラベルの位置（'end' は上端）
                    align: 'end', // データラベルの位置（'end' は上側）
                    padding: {
                        bottom: 60
                    },
                    backgroundColor: [
                        'rgba(255, 60, 132)',
                        'rgba(80, 100, 255)',
                        'rgba(255, 220, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255',
                        'rgba(255, 159, 64)',
                        'rgba(180, 180, 180)',
                        'rgba(200, 60, 60)',
                        'rgba(60, 180, 60)',
                        'rgba(54, 162, 255)',

                    ]
                }]
            },
            plugins: [ChartDataLabels],
            options: {
                //グラフの右端に余白を持たせる
                layout: {
                    padding: {
                        right: 100
                    }
                },
                indexAxis: 'y',
                responsive: true,
                //アスペクト比を維持するか
                maintainAspectRatio: false,
                scales: {
                    y: {
                        ticks: {
                            color: '#222',
                            font: {
                                size: 16
                            },
                        },
                        grid: {
                            display: false,
                        }
                    },
                    x: {
                        // max: 180,
                        // x軸のラベルの設定
                        ticks: {
                            color: '#222',
                            font: {
                                size: 16
                            },
                            stepSize: step,
                            callback: function(value) {
                                // let max = this.chart.scales.x.max;
                                // if(value === max) {
                                //     if(value % 60 !== 0) {
                                //         value += 60 - (value % 60);
                                //     }
                                //     return `${value / 60}時間`
                                // }
                                if (value % 60 !== 0) {
                                    return '';
                                }
                                return `${value / 60}時間`;
                            }
                        }
                    }
                },
                plugins: {
                    //グラフホバー時のポップアップの設定
                    tooltip: {
                        enabled: false
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'end',
                        offset: 5,
                        color: '#222',
                        font: {
                            size: 16
                        },
                        formatter: function(value) {
                            let hours = Math.floor(value / 60);
                            let minutes = value % 60;
                            if (hours === 0) {
                                return `${minutes}分`;
                            } else if (minutes === 0) {
                                return `${hours}時間`;
                            } else {
                                return `${hours}時間${minutes}分`;
                            }
                        }
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 0
                            }
                        }
                    }

                }
            }
        });
    </script>
</div>
