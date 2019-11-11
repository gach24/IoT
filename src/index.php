<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="refresh" content="60">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <title>Graphics</title>
</head>

<body>
    <?php 
        require_once( "data.php" ); 
        $db = new Data(); 
    ?>
    <main class="container">
        <div class="row">
            <nav class="col offset-2">
                <div class="nav nav-tabs row" id="nav-tab" role="tablist">
                    <a  class="nav-item nav-link active col-2" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                        role="tab" aria-controls="nav-home" aria-selected="true" numero="0">10minutos</a>
                    <a  class="nav-item nav-link col-2" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                        role="tab" aria-controls="nav-profile" aria-selected="false" numero="1">1hora</a>
                    <a class="nav-item nav-link col-2" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                        role="tab" aria-controls="nav-contact" aria-selected="false" numero="2">12horas</a>
                    <a class="nav-item nav-link col-2" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                        role="tab" aria-controls="nav-contact" aria-selected="false" numero="3">diaria</a>
                    <a class="nav-item nav-link col-2" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                        role="tab" aria-controls="nav-contact" aria-selected="false" numero="4">mensual</a>
                    <a class="nav-item nav-link col-2" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                        role="tab" aria-controls="nav-contact" aria-selected="false" numero="5">anual</a>
                </div>
            </nav>
        </div>
        <div class="row">
            <div class="col-sm-8 col-8 offset-2 ">
                <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel" data-interval="false">
                    <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div id="lastTenMinutesValues"><!-- Plotly chart will be drawn inside this DIV --></div>
                    </div>
                    <div class="carousel-item">
                        <div id="lastHourValues" class="img"><!-- Plotly chart will be drawn inside this DIV --></div>
                    </div>
                    <div class="carousel-item">
                        <div id="twelveHours" class="img"><!-- Plotly chart will be drawn inside this DIV --></div>
                    </div>
                    <div class="carousel-item">
                        <div id="daily" class="img"><!-- Plotly chart will be drawn inside this DIV --></div>
                    </div>
                    <div class="carousel-item">
                        <div id="mounthly" class="img"><!-- Plotly chart will be drawn inside this DIV --></div>
                    </div>
                    <div class="carousel-item">
                        <div id="annual" class="img"><!-- Plotly chart will be drawn inside this DIV --></div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script>

        function lastTenMinutesValues() {
            var yValue = JSON.parse('<?php echo  $db->getAll()['data'] ?>');
            var fecha = '(<?php echo  $db->getAll()['fecha'] ?>)';
  
            var xValue = ['Temperatura', 'Humedad'];

            console.log(fecha);

            var trace1 = {
                x: xValue,
                y: yValue,
                type: 'bar',
                text: yValue.map(String),
                textposition: 'auto',
                hoverinfo: 'none',
                marker: {
                    color: 'rgb(158,202,225)',
                    opacity: 0.6,
                    line: {
                    color: 'rgb(8,48,107)',
                    width: 1.5
                    }
                }
            };

            var data = [trace1];
            var t = 'Temperatura y humedad\t' + fecha;
            var layout = {
                title: t
            };

            Plotly.newPlot('lastTenMinutesValues', data, layout);
            


 
            /*
            var update = {
                width: 400,  // or any new width
                height: 400  // " "
            };

            Plotly.relayout('tenMinutes', update);
            */
        }

        function lastHourValues() {
	    /*
            var temperatures = JSON.parse('<?php echo  $db->lastHourValues()['temperatures'] ?>');
            var dates = JSON.parse('<?php echo $db->lastHourValues()['dates'] ?>');
            console.log(dates[0]);
            
            

            var data = [{ x: dates, y: temperatures, type: 'scatter' }];
            var layout = {
                xaxis: {
                    tickmode: "linear", //  If "linear", the placement of the ticks is determined by a starting position `tick0` and a tick step `dtick`
                    nticks: 10,
                    // tick0: 'dates[0]',
                    // dtick: 5 * 60 * 1000 // milliseconds
                }
            }
            Plotly.newPlot('lastHourValues', data, layout);
	    */
        }



        $(function () {
            var items = $('.nav-item');
            $.each(items, function (index, value) {
                value.onclick = function () {
                    $('.carousel').carousel(index);
                }
            });

	    lastTenMinutesValues();
            console.log('Actualizado en fecha: ' + new Date());

        });
    </script>

</body>

</html>
