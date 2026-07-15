function studyLogChart() {

    const $chart = document.getElementById('chart');

    if(!$chart) {
        return;
    }
    const ctx = $chart.getContext('2d');

    const likes = $chart.dataset.likes;
    const dislikes = $chart.dataset.dislikes;

    if(likes == 0 && dislikes == 0) {
        data = {
            labels:['まだ投票がありません'],
            datasets: [{
                data:[1],
                backgroundColor: [
                    '#9ca3af'
                ]
            }]
        }
    } else {
        data = {
            labels:['賛成', '反対'],
            datasets: [{
                data:[likes, dislikes],
                backgroundColor: [
                    '#33d499',
                    '#f87171'
                ]
            }]
        }
    }
    new Chart(ctx, {
        type: 'bar',
        data:data,
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font:{
                            size: 18
                        }
                    }
                }
                                
            }
        }
    });
}

studyLogChart();