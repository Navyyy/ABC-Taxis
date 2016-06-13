<?php
/*
Author : Yvan Cochet
Date : 19.02.2016
Summary : Show the list of the cars

*/

session_start();

if(isset($_SESSION['login']) AND $_SESSION['login'] == 'driver')
{

    include('dbAcces.php');
    $function = new dbAcces();

    //Method to connect to the db
    $function->dbConnect();

    //Get all the cars
    $tabCar = $function->getAllCar();

    ?>

    <!DOCTYPE html>
    <html>

        <head lang="fr">
            <!--Links for CSS, javascript, bootstrap-->
            <link href="../css/bootstrap.min.css" rel="stylesheet">
            <link href="../css/css-perso-mobile.css" rel="stylesheet">
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>
            <script src="../js/js-perso.js"></script>

            <!--______Link fo datePicker_____-->
            <!--  jQuery -->
            <script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>

            <!-- Isolated Version of Bootstrap, not needed if your site already uses Bootstrap -->
            <link rel="stylesheet" href="../css/bootstrap-iso.css" />

            <!-- Bootstrap Date-Picker Plugin -->
            <script type="text/javascript" src="../js/bootstrap-datepicker.min.js"></script>
            <link rel="stylesheet" href="../css/bootstrap-datepicker3.css"/>
            <!--______/Link fo datePicker_____-->

            <link rel="icon" href="http://www.abctaxis.ch/favicon.png">

            <title>Planning véhicules | ABC Taxis Cochet SA</title>
        </head>

        <body class="body-mobile">
            <div id="body-mobile">
                <a href="http://www.abctaxis.ch"><img src="./../pictures/logo-abc.png" alt="logo ABC Taxi"/></a>

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
                            <li><a href="./calender-driver-mobile.php"><span class="glyphicon glyphicon-th-list">&nbsp;</span>Planning chauffeurs</a></li>
                            <li><a href="./list-car-mobile.php"><span class="glyphicon glyphicon-road">&nbsp;</span>Liste véhicules</a></li>
                            <li class="active"><a href="./calender-car-mobile.php"><span class="glyphicon glyphicon-calendar">&nbsp;</span>Planning véhicules</a></li>
                        </ul>
                    </div>
                </nav>
                <!--____________________/NAVBAR__________________________-->

                <!--_______________Datepicker and driver select____________-->

                <form action="calender-car-mobile.php" method="POST">
                    <div class="form-group">
                        <!--Select with all cars-->
                        <select class="form-control" name="car">
                            <option value="empty">-- Véhicule --</option>

                            <?php
                            foreach($tabCar as $car)
                            {
                                echo '<option value="'.$car['idCar'].'">'.$car['carRegistration'].'</option>';
                            }
                            ?>
                        </select>
                        <!--/Select with all cars-->
                    </div>

                    <div class="form-group"> <!-- Date input -->
                        <input readOnly class="form-control" id="date" name="date" placeholder="Date AAAA-MM-JJ" type="text"/>
                    </div>
                    <!-- Submit button -->
                    <button class="btn btn-primary btn-block" name="submit" type="submit">Valider</button>

                    <!--Script to print the datePicker-->
                    <script>
                        $(document).ready(function(){
                          var date_input=$('input[name="date"]'); //our date input has the name "date"
                          var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
                          var options={
                            format: 'yyyy-mm-dd',
                            container: container,
                            todayHighlight: true,
                            autoclose: true,
                          };
                          date_input.datepicker(options);
                        })
                    </script>
                    <!--/Script to print the datePicker-->

                </form>

                <!--______________/Datepicker and driver select____________-->

                <!--____________________Car-planning_________________________-->
                <?php
                if(isset($_POST['date']) AND $_POST['date']!== '' AND isset($_POST['car']) AND $_POST['car']!== '')
                {

                    $carName = $function->getCarFromId($_POST['car']);

                    echo '<h1>'.$carName[0]['carRegistration'].'</h1>';

                    echo '<h3>'.$_POST['date'].'</h3>';

                    //Get all the statu
                    $tabStatu = $function->getAllStatu();
                ?>

                <a class="show-legend" id="showLegend" onclick="showLegend()">Afficher la légende</a>
                <br/><br/>
                <div class="div-legend" id="div-legend">
                    <?php
                    foreach($tabStatu as $statu)
                    {
                        echo '<span class="span-statu" style="background-color:'.$statu['staBackColor'].'; color:'.$statu['staForeColor'].';">'.$statu['staName'].'</span>';
                        echo '<br/><br/>';
                    }

                    ?>

                </div>

                    <table class="tab-list-driver">

                        <tbody>

                            <?php

                            //Date var and stat for the loop
                            $dateVar = strtotime($_POST['date'].' 04:30:00');
                            $dateStat = strtotime($_POST['date'].' 04:30:00');

                            //While dateVar < dateVar + 24h write the table <tr>
                            while($dateVar <= ($dateStat + ((23*3600) + 1800)))
                            {

                                //echo date('H:i',$dateVar).'<br/>';
                                echo '<tr>';
                                    echo '<th style="width:30%" class="hour-head">'.date('H:i',$dateVar).'</th>';

                                    //Get the statu of the car at the current date
                                    $tabCurrentStatu = $function->getCarStatu($_POST['car'], date('Y-m-d H:i',$dateVar));

                                    if(count($tabCurrentStatu) !== 0)
                                    {
                                        echo '<th style="background-color:'.$tabCurrentStatu[0]['staBackColor'].'" class="plan-car-list-th">&nbsp; &nbsp;</th>';
                                    }
                                    else
                                    {
                                        echo '<th class="plan-car-list-th"></th>';
                                    }

                                echo '</tr>';

                                //Increment datVar value (+ 1/2 hour)
                                $dateVar += 1800;                                
                            }

                            ?>

                        </tbody>


                    </table>

                <?php
                }
                ?>

                <!--____________________/Car-planning_________________________-->

            </div>
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