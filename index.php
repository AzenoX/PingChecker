<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Ping Checker</title>


    <!-- MaterializeCSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <link rel="stylesheet" href="style.css">

    <!--Charts CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.css">
</head>

<body>

    <nav>
        <div class="nav-wrapper" style="padding: 0 1em; background: #388e3c;">
            <a href="#" class="brand-logo">Ping Checker</a>
        </div>
    </nav>

    <h1>PING</h1>
    <p>Graph is refreshing every 2 seconds</p>

    <div id="wrapper" class="wrapper z-depth-3">

        <table class="charts-css column multiple datasets-spacing-6 show-labels">

            <thead>
                <tr>
                <th scope="col"> 1 </th>
                <th scope="col"> 2 </th>
                <th scope="col"> 3 </th>
                <th scope="col"> 4 </th>
                <th scope="col"> 5 </th>
                <th scope="col"> 6 </th>
                <th scope="col"> 7 </th>
                <th scope="col"> 8 </th>
                <th scope="col"> 9 </th>
                <th scope="col"> 10 </th>
                <th scope="col"> 11 </th>
                <th scope="col"> 12 </th>
                <th scope="col"> 13 </th>
                <th scope="col"> 14 </th>
                <th scope="col"> 15 </th>
                <th scope="col"> 16 </th>
                <th scope="col"> 17 </th>
                <th scope="col"> 18 </th>
                <th scope="col"> 19 </th>
                <th scope="col"> 20 </th>
            </tr>
            </thead>

            <tbody class="graph_wrapper">
                <tr class="graph">
                    <th scope="row" style="text-align: center; font-weight: bold;">0ms<br>Last</th>
                    <td style="--size: 0; --color: #4caf50;" class="thisclassisnotused"></td>
                </tr>
                <?php
                    for($i = 2 ; $i <= 38 ; $i+=2){
                        echo '
                            <tr class="graph">
                                <th scope="row" style="text-align: center; font-weight: normal;">0ms<br>-' . $i . 's</th>
                                <td style="--size: 0; --color: #388e3c;"></td>
                            </tr>
                        ';
                    }
                ?>
            </tbody>

        </table>
    </div>

    <p class="error" style="display: none;">Network issues</p>

</body>

<script>
    const graphCells = document.querySelectorAll('.graph_wrapper > .graph');
    const error = document.querySelector('.error');

    const ping = [
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
    ];
    function drawChart(){
        const now = Date.now();
        fetch('pong.php')
            .then(data => data.text())
            .then(data => {
                if(error.style.display === 'block') {
                    error.style.display = 'none';
                }

                const now2 = Date.now();
                const actualPing = now2 - now;

                for(let i = 19; i > 0 ; i--){
                    ping[i] = ping[i - 1];
                }
                ping[0] = actualPing;

                ping.forEach((value, index) => {
                    const th = graphCells[index].querySelector('th');
                    const td = graphCells[index].querySelector('td');

                    let timeSince = index * 2;
                    if(timeSince === 0){
                        timeSince = 'Last';
                        td.classList.add('active');
                        setTimeout(() => {
                            td.classList.remove('active');
                        }, 1020);
                    }
                    else{
                        timeSince = '-' + timeSince + 's';
                    }
                    th.innerHTML = value + 'ms' + '<br>' + timeSince;
                    td.style.setProperty('--size', (parseInt(value) / 800));

                    if(value >= 500){
                        td.style.setProperty('--color', '#d32f2f');
                    }
                    else if(value >= 250){
                        td.style.setProperty('--color', '#f57c00');
                    }
                    else{
                        td.style.setProperty('--color', '#388e3c');
                    }
                });
            })
        .catch(() => {
            error.style.display = 'block';
        });
    }


    drawChart();
    setInterval(() => {
        drawChart();
    }, 2000);

</script>

</html>