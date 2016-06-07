<?php
/*
Author : Yvan Cochet
Date : 19.02.2016
Summary : driver planning page for ABCTaxi's site

*/

session_start();

if(isset($_SESSION['login']) AND $_SESSION['login'] == 'admin')
{

    include('dbAcces.php');
    $function = new dbAcces();

    //Method to connect to the db
    $function->dbConnect();


    //Get var for selected month and year
    $selectedMonth = $function->getSelectedMonth();
    $selectedYear = $function->getSelectedYear();

    ?>

    <!DOCTYPE html>
    <html>

        <head lang="fr">
            <!--Links for CSS, javascript, bootstrap-->
            <link href="../css/bootstrap.min.css" rel="stylesheet">
            <link href="../css/css-perso.css" rel="stylesheet">
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>
            <script src="../js/js-perso.js"></script>

            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <!--<script type="text/javascript">
		      google.charts.load("current", {packages:["corechart"]});

		      google.charts.setOnLoadCallback(drawChart);
		      function drawChart() {
		        var data = google.visualization.arrayToDataTable([
		          ['Task', 'Nb tasks in a year'],
		          ['Vacances',     11],
		          ['Voiture B',      2],
		          ['Commute',  2],
		          ['Watch TV', 2],
		          ['Sleep',    7]
		        ]);

		        var options = {
		          title: 'Résumé de ... en ...',
		          pieHole: 0.4,
		        };

		        var chart = new google.visualization.PieChart(document.getElementById('donutWork'));
		        chart.draw(data, options);
		      }
		    </script><-->

            <link rel="icon" href="http://www.abctaxis.ch/favicon.png">

            <title>Planning chauffeurs | ABC Taxis Cochet SA</title>
        </head>

        <body id="body-anim-in">
            <a href="www.abctaxis.ch"><img src="./../pictures/logo-abc.png" alt="logo ABC Taxi"/></a>
            <p></p>

            <!--____________________NAVBAR__________________________-->
            <nav class="navbar navbar-inverse" role="navigation">
                <!--Button for responsive design-->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="./calender.php"><span class="glyphicon glyphicon-th-list">&nbsp;</span>Planning chauffeurs</a></li>
                        <li><a href="./list-car.php"><span class="glyphicon glyphicon-road">&nbsp;</span>Liste véhicules</a></li>
                        <li><a href="./calender-car.php"><span class="glyphicon glyphicon-calendar">&nbsp;</span>Planning véhicules</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="./stat-driver.php"><span class="glyphicon glyphicon-stats">&nbsp;</span>Statistiques</a></li>
                    </ul>
                </div>
            </nav>
            <!--____________________/NAVBAR__________________________-->

            <div class="panel default-panel col-md-4">
                <legend><h2>Informations utilisateur</h2></legend>
                <form>
                    <div class="form-group">
                        <?php
                        //Get all the drivers to put it in a select
                        $tabDriver = $function->getAllDriver();
                        ?>
                        <select id="select-driver" onchange="getDriverStat()" name="driver" class="form-control">
                            <?php
                            foreach($tabDriver as $driver)
                            {
                                echo '<option value="'.$driver['idDriver'].'">'.$driver['driName'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="year" onchange="getDriverStat()" id="select-year" class="form-control">
                            <option value=2016>2016</option>
                            <option value=2017>2017</option>
                            <option value=2018>2018</option>
                            <option value=2019>2019</option>
                            <option value=2020>2020</option>
                            <option value=2021>2021</option>
                            <option value=2022>2022</option>
                            <option value=2023>2023</option>
                            <option value=2024>2024</option>
                            <option value=2025>2025</option>
                        </select>
                    </div>
                </form>
            </div>

		    <div id="driverStat" style="width: 600px; height: 400px; float:right;"></div>


        </body>
    </html> 
    <?php
}
else
{
    ?>
    <h1>Accès refusé !</h1>
    <?php
}