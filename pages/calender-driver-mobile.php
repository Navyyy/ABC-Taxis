<?php
/*
Author : Yvan Cochet
Date : 19.02.2016
Summary : driver planning page for ABCTaxi's site (driver version)

*/

session_start();

if(isset($_SESSION['login']) AND $_SESSION['login'] == 'driver')
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
            <link href="../css/css-perso-mobile.css" rel="stylesheet">
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>
            <script src="../js/js-perso.js"></script>

            <link rel="icon" href="http://www.abctaxis.ch/favicon.png">

            <title>Planning chauffeurs | ABC Taxis Cochet SA</title>
        </head>

        <body>
            <div id="body-mobile">
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
                            <li class="active"><a href="./calender-driver-mobile.php"><span class="glyphicon glyphicon-th-list">&nbsp;</span>Planning chauffeurs</a></li>
                            <li><a href="./list-car-mobile.php"><span class="glyphicon glyphicon-road">&nbsp;</span>Liste véhicules</a></li>
                            <li><a href="./calender-car-mobile.php"><span class="glyphicon glyphicon-calendar">&nbsp;</span>Planning véhicules</a></li>
                        </ul>
                    </div>
                </nav>
            <!--____________________/NAVBAR__________________________-->

                <div class="date-select">
                    <form action="date.php" method="post">
                        <?php
                            $function->getListMonth();
                            $function->getListYear();
                            $function->getListDriver();
                        ?>
                        <input type="submit" class="btn btn-primary btn-block">
                    </form>
                </div>
                <?php
                    if(isset($_GET['driver']) AND $_GET['driver'] !== '')
                    {
                        echo '<h1>'.$_GET['driver'].'</h1>';
                    
                        echo '<h4>'.$function->convertMonth($selectedMonth).' '.$selectedYear.'</h4>';
                        ?>
                        <table class="tab-list-driver">
                            <?php

                            echo '<tr><th>Jour</th><th>Tâche</th></tr>';

                            //Set the date to use in the function
                            $date = strtotime($selectedYear.'-'.$selectedMonth.'-01');

                            //Loop that browse all day of the selected month
                            while(date('m',$date) <= $selectedMonth AND date('Y',$date) <= $selectedYear)
                             {
                                 //Replace day from 0-6 to 1-7
                                 $w = str_replace('0','7',date('w',$date));

                                //Number of the day
                                $d = date('j',$date);

                                $task = $function->getTaskMobile(date('Y-m-d',$date),$_GET['driver']);

                                if($w == 7)
                                {
                                    echo '<tr><th>'.$d.'</th><th class="'.$task.'">'.strtoupper(substr($task,0,1)).'</th></tr>';
                                    echo '<tr><th colspan="2" class="separator"></th></tr>';
                                }
                                else
                                {
                                    echo '<tr><th>'.$d.'</th><th class="'.$task.'">'.strtoupper(substr($task,0,1)).'</th></tr>';
                                }


                                //If it's the last sunday of october + 25h else + 24h
                                if($selectedMonth == 10 AND $d == 7 AND date('m',$date+7*25*2600)!==10)
                                {
                                      $date = $date + 25*3600;
                                 }
                                 else
                                 {
                                    $date = $date + 24*3600;
                                 }
                            }

                            ?>
                        </table>
                        <?php
                    }
                    ?>
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