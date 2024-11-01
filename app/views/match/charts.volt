<?php
    // print_r ($stats);
    // die();
    // //

    foreach ($stats as $min => $val) {
        $attack = explode ('|',$val['A']);
        $Dattack = explode ('|',$val['D']);
        $chart['min'][] = $min;
        $chart['HomeAttack'][] = $attack[0];
        $chart['AwayAttack'][] = $attack[1];

        $chart['HomeDAttack'][] = $Dattack[0];
        $chart['AwayDAttack'][] = $Dattack[1];
    }

?>




    <ul class="nav  nav-tabs mb-3" id="pills-tab" role="tablist">

        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Attacks</button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Dangerous attacks</button>
        </li>

    </ul>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <canvas id="ChartAttack" height="200"></canvas>
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <canvas id="ChartDAttack" height="200"></canvas>
        </div>
    </div>


    <!-- attacks -->
    <script>
        var ctx = document.getElementById('ChartAttack').getContext('2d');
        var data = {
            "labels": ["<?php echo implode('’ min", "',$chart['min'])?>’ min"],

            "datasets": [{
                "label": "Home",
                "backgroundColor": "#006496",

                "data": [<?php echo implode(',',$chart['HomeAttack'])?>],
                "borderColor": "#006496",
                "pointRadius": 3,
                "pointBackgroundColor": "#00649620",
                "pointBorderColor": "#00649620",
                "lineTension": 0.5,
                "pointBorderWidth": 5,

            }, {
                "label": "Away",
                "backgroundColor": "#009669",

                "data": [<?php echo implode(',',$chart['AwayAttack'])?>],
                "borderColor": "#009669",
                "pointRadius": 3,
                "lineTension": 0.5,
                "pointBackgroundColor": "#00966920",
                "pointBorderColor": "#00966920",
                "pointBorderWidth": 5
            }]
        };

        var options = {
            "title": {
                "display": false
            },
            "legend": {
                "display": false
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false
                    }
                }],
                yAxes: [{
                    gridLines: {
                        display: false
                    }
                }]
            },

            "animation": {
                "duration": "200"
            }
        };

        var ChartAttack = new Chart(ctx, {
            type: 'line',
            data: data,
            options: options
        });
    </script>



    <!-- d attacks -->
    <script>
        var ctx = document.getElementById('ChartDAttack').getContext('2d');
        var data = {
            "labels": ["<?php echo implode('’ min", "',$chart['min'])?>’ min"],

            "datasets": [{
                "label": "Home",
                "backgroundColor": "#006496",

                "data": [<?php echo implode(',',$chart['HomeDAttack'])?>],
                "borderColor": "#006496",
                "pointRadius": 3,
                "pointBackgroundColor": "#00649620",
                "pointBorderColor": "#00649620",
                "lineTension": 0.5,
                "pointBorderWidth": 5,

            }, {
                "label": "Away",
                "backgroundColor": "#009669",

                "data": [<?php echo implode(',',$chart['AwayDAttack'])?>],
                "borderColor": "#009669",
                "pointRadius": 3,
                "lineTension": 0.5,
                "pointBackgroundColor": "#00966920",
                "pointBorderColor": "#00966920",
                "pointBorderWidth": 5
            }]
        };

        var options = {
            "title": {
                "display": false
            },
            "legend": {
                "display": false
            },
            "animation": {
                "duration": "200"
            }
        };

        var ChartDAttack = new Chart(ctx, {
            type: 'line',
            data: data,
            options: options
        });
    </script>