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
            <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
            <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>
            <script src="../js/js-perso.js"></script>

            <link rel="icon" href="http://www.abctaxis.ch/favicon.png">

            <title>Planning chauffeurs | ABC Taxis Cochet SA</title>
        </head>

        <body id="body-anim-in">
            <a href="www.abctaxis.ch"><img src="./../pictures/logo-abc.png" alt="logo ABC Taxi"/></a>
            <div class="date-select">
                <form action="date.php" method="post">
                    <?php
                        $function->getListMonth();
                        $function->getListYear();
                    ?>
                    <input type="submit" class="btn btn-primary btn-block">
                </form>
            </div>
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
                        <li class="active"><a href="#"><span class="glyphicon glyphicon-calendar">&nbsp;</span>Planning véhicules</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                             <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ajouter un chauffeur &nbsp;<span class="glyphicon glyphicon-plus"></span></a>
                            <div class="dropdown-menu" id="add-driver-dropdown">
                                <form class="form" role="form" method="post" action="add-driver.php" accept-charset="UTF-8" id="login-nav">
                                    <div class="form-group">
                                        <label class="sr-only" for="exampleInputEmail2">Nom</label>
                                        <input type="text" name="surname" class="form-control" placeholder="Nom">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="exampleInputEmail2">Prénom</label>
                                        <input type="text" name="firstname" class="form-control" placeholder="Prénom">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">Valider</button>
                                    </div>
                                </form>
                                <div class="bottom text-center" id="div-join-us">
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!--____________________/NAVBAR__________________________-->

            <!--________________Calender________________________-->

            <div class="panel">


                <?php

                /*$date = strtotime($selectedYear.'-'.$selectedMonth.'-01');

                //Loop that browse all day of the selected month
                while(date('m',$date) <= $selectedMonth AND date('Y',$date) <= $selectedYear)
                {
                    //Replace day from 0-6 to 1-7
                    $w = str_replace('0','7',date('w',$date));

                    //Number of the day
                    $d = date('j',$date);

                    $tabDay = array("Lu", "Ma", "Me", "Je", "Ve", "Sa", "Di");

                    echo '<span class="numDaySpan">';
                    echo '<a class="numDay">'.$tabDay[date('w',$date)].'.'.$d.'</a>';
                    echo '</span>';


                    //If it's the last sunday of october + 25h else + 24h
                    if($selectedMonth == 10 AND $d == 7 AND date('m',$date+7*25*2600)!==10)
                    {
                        $date = $date + 25*3600;
                    }
                    else
                    {
                        $date = $date + 24*3600;
                    }
                }*/

                ?>

            </div>

            <!--________________/Calender________________________-->

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