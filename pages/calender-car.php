<?php
/*
Author : Yvan Cochet
Date : 19.02.2016
Summary : driver planning page for ABCTaxi's site

*/

session_start();

if(isset($_SESSION['login']))
{

    include('dbAcces.php');
    $function = new dbAcces();

    //Method to connect to the db
    $function->dbConnect();


    //Get var for selected month and year
    $selectedMonth = $function->getSelectedMonth();
    $selectedYear = $function->getSelectedYear();

    //Get the laste date used
    $tabDate = $function->getDateCar();

    //Get all the statu
    $tabStatu = $function->getAllStatu();

    //Get all the cars
    $tabCar = $function->getAllCar();

    //Store date + hour in a var to keep the start hour
    $dateStat = strtotime($tabDate[0]['datDate'].' 04:30:00');

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

            <title>Planning chauffeurs | ABC Taxis Cochet SA</title>
        </head>

        <body id="body-anim-in">
            <a href="www.abctaxis.ch"><img src="./../pictures/logo-abc.png" alt="logo ABC Taxi"/></a>

            <!--______Div with datePicker_____-->
            <div class="panel panel-car-planning">
                <!--Form where write the date-->
                <form method="post" action="car-date.php">
                    <div class="form-group"> <!-- Date input -->
                        <input readOnly class="form-control" id="date" name="date" placeholder="Date AAAA-MM-JJ" type="text"/>
                    </div>
                    <!-- Submit button -->
                    <button class="btn btn-primary btn-block" name="submit" type="submit">Valider</button>
                </form>
                <!--/Form where write the date-->

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
            </div>
            <!--______/Div with datePicker_____-->

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
                        <?php
                        if($_SESSION['login'] == 'admin')
                        {
                        ?>
                            <li><a href="./calender.php"><span class="glyphicon glyphicon-th-list">&nbsp;</span>Planning chauffeurs</a></li>
                        <?php
                        }
                        else
                        {
                            ?>
                            <li><a href="./calender-driver.php"><span class="glyphicon glyphicon-th-list">&nbsp;</span>Planning chauffeurs</a></li>
                            <?php
                        }
                        ?>
                        <li><a href="./list-car.php"><span class="glyphicon glyphicon-road">&nbsp;</span>Liste véhicules</a></li>
                        <li class="active"><a href="#"><span class="glyphicon glyphicon-calendar">&nbsp;</span>Planning véhicules</a></li>
                    </ul>

                    <?php
                    //Print the form only if we're logged as admin
                    if(isset($_SESSION['login']) AND $_SESSION['login'] == 'admin')
                    {
                    ?>
                        <ul class="nav navbar-nav navbar-right">
                            <!--Copie planning sur next day-->
                            <?php
                            echo '<li><a href="./calender-car-copy.php?date='.$tabDate[0]['datDate'].'"><span class="glyphicon glyphicon-copy">&nbsp;</span>Copier planning sur jour suivant</a></li>'
                            ?>

                            <li class="dropdown">
                                 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ajouter un statut &nbsp;<span class="glyphicon glyphicon-plus"></span></a>
                                <div class="dropdown-menu add-driver-dropdown">

                                    <form class="form" method="post" action="add-statu.php">

                                        <div class="form-group">
                                            <input type="text" name="staName" placeholder="Nom du statut" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            Couleur de fond :
                                            <input type="color" name="staBackColor" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            Couleur de texte :
                                            <input type="color" name="staForeColor" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Valider</button>
                                        </div>

                                    </form>
                                       
                                </div>
                            </li>
                            <li class="dropdown">
                                 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ajout rapide &nbsp;<span class="glyphicon glyphicon-plus"></span></a>
                                <div class="dropdown-menu add-driver-dropdown">
                                    <form class="form" role="form" method="post" action="fast-add-statu.php" accept-charset="UTF-8">
                                        <?php
                                        echo '<input type="hidden" id="selectedDate" name="selectedDate" value="'.$tabDate[0]['datDate'].'">';
                                        ?>

                                        <div class="form-group">
                                            <label class="sr-only" for="exampleInputEmail2">From</label>

                                            <!--Select with start hour-->
                                            <select class="form-control" name="startHour">
                                                <option value="empty">-- De --</option>

                                                <?php
                                                //Reset datevar
                                                $dateVar = strtotime($tabDate[0]['datDate'].' 04:30:00');

                                                //While dateVar < dateVar + 24h write an option
                                                 while($dateVar <= ($dateStat + ((23*3600) + 1800)))
                                                 {
                                                    echo '<option value="'.date('H:i',$dateVar).'">'.date('H:i',$dateVar).'</option>';

                                                    //Increment datVar value (+ 1/2 hour)
                                                    $dateVar += 1800;
                                                 }
                                                ?>
                                            </select>
                                            <!--/Select with start hour-->

                                        </div>
                                        <div class="form-group">
                                            
                                            <!--Select with end hour-->

                                            <select class="form-control" name="endHour">
                                                <option value="empty">-- À --</option>

                                                <?php
                                                //Reset datevar
                                                $dateVar = strtotime($tabDate[0]['datDate'].' 04:30:00');

                                                //While dateVar < dateVar + 24h write an option
                                                 while($dateVar <= ($dateStat + ((23*3600) + 1800)))
                                                 {
                                                    echo '<option value="'.date('H:i',$dateVar).'">'.date('H:i',$dateVar).'</option>';

                                                    //Increment datVar value (+ 1/2 hour)
                                                    $dateVar += 1800;
                                                 }
                                                ?>
                                            </select>

                                            <!--/Select with end hour-->

                                        </div>

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

                                        <div class="form-group">

                                            <!--Select with all status-->
                                            <select onchange="colorCar(this)" class="form-control" name="statu">
                                                <option value="empty" style="background-color:white">-- Statut --</option>
                                                <option value="empty" style="background-color:white">DELETE</option>

                                                <?php
                                                foreach($tabStatu as $statu)
                                                {
                                                    echo '<option value="'.$statu['idStatu'].'" style="background-color:'.$statu['staBackColor'].';">&nbsp;</option>';
                                                }
                                                ?>

                                            </select>

                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Valider</button>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    <?php
                    }
                    ?>
                </div>
            </nav>
            <!--____________________/NAVBAR__________________________-->

            <!--________________Calender________________________-->

                <table id="plan-car-tab">
                    <form method="post" action="post-car-calender.php">

                        <?php
                            echo '<input type="hidden" id="selectedDate" name="selectedDate" value="'.$tabDate[0]['datDate'].'">';
                        ?>

                        <!--Header of the table-->
                        <thead>
                            <tr>
                                <?php
                                //Print the date at the top of the table
                                echo '<th class="plan-car-date-head" colspan="'.(count($tabCar)+1).'">'.$tabDate[0]['datDate'].'</th>';
                                ?>
                            </tr>
                            <tr>
                                <?php
                                echo '<th class="plan-car-head date-head th-span" colspan="'.(count($tabCar)+1).'">';

                                echo '| &nbsp<span class="span-statu" style="background-color:white">supprimer</span>&nbsp; | &nbsp;';

                                foreach($tabStatu as $statu)
                                {
                                    echo '<span class="span-statu" style="background-color:'.$statu['staBackColor'].'; color:'.$statu['staForeColor'].';">'.$statu['staName'].'</span>';

                                    if(isset($_SESSION['login']) AND $_SESSION['login'] == 'admin')
                                    {
                                        echo ' <a onclick="return checkDelete()" href="./delete-statu.php?idStatu='.$statu['idStatu'].'" ><button type="button" class="btn btn-danger btn-xs btn-round"><span class="glyphicon glyphicon-trash"></span></button></a>';
                                    }

                                    echo '&nbsp; | &nbsp;';
                                }

                                echo '</th>';
                                ?>
                            </tr>
                            <tr>
                                <th class="plan-car-head date-head">Heure</th>
                                <?php

                                //Loop to write all registration in the header
                                foreach($tabCar as $car)
                                {
                                    echo '<th class="plan-car-head">'.wordwrap ($car['carRegistration'], 1, '<br/>', 1).'</th>';
                                }

                                ?>
                            </tr>
                        </thead>
                        <!--/Header of the table-->

                        <!--Body of the table-->
                        <tbody>
                            <?php
                            //Reset dateVar
                            $dateVar = strtotime($tabDate[0]['datDate'].' 04:30:00');


                            //While dateVar < dateVar + 24h write the table <tr>
                            while($dateVar <= ($dateStat + ((23*3600) + 1800)))
                            {
                                //echo date('H:i',$dateVar).'<br/>';
                                echo '<tr>';
                                    echo '<th class="hour-head">'.date('H:i',$dateVar).'</th>';

                                    foreach($tabCar as $car)
                                    {

                                        //Get the statu of the car at the current date
                                        $tabCurrentStatu = $function->getCarStatu($car['idCar'], date('Y-m-d H:i',$dateVar));

                                        //Print the lists only if we're logged as admin
                                        if(isset($_SESSION['login']) AND $_SESSION['login'] == 'admin')
                                        {
                                            echo '<th class="plan-car-list-th">';

                                                //If the tab isn't empty, write the select with back color and the selected option. else write select without back color and without option
                                                if(count($tabCurrentStatu) !== 0)
                                                {
                                                    echo '<select style="background-color:'.$tabCurrentStatu[0]['staBackColor'].'" onchange="colorCar(this); addStatu(this);" class="plan-car-list" name="'.$car['idCar'].'-'.date('H-i',$dateVar).'">';

                                                        echo '<option value="'.$tabCurrentStatu[0]['idStatu'].'" style="background-color:'.$tabCurrentStatu[0]['staBackColor'].'">&nbsp;</option>';
                                                }
                                                else
                                                {
                                                    echo '<select onchange="colorCar(this); addStatu(this);" class="plan-car-list" name="'.$car['idCar'].'-'.date('H-i',$dateVar).'">';
                                                }

                                                    echo '<option value="empty" style="background-color:white;">&nbsp;</option>';
                                                    foreach($tabStatu as $statu)
                                                    {
                                                        echo '<option value="'.$statu['idStatu'].'" style="background-color:'.$statu['staBackColor'].';">&nbsp;</option>';
                                                    }
                                                echo '</select>';

                                            echo '</th>';
                                        }
                                        else
                                        {
                                            if(count($tabCurrentStatu) !== 0)
                                            {
                                                echo '<th style="background-color:'.$tabCurrentStatu[0]['staBackColor'].'" class="plan-car-list-th"></th>';
                                            }
                                            else
                                            {
                                                echo '<th class="plan-car-list-th"></th>';
                                            }
                                        }
                                    }

                                echo '</tr>';

                                //Increment datVar value (+ 1/2 hour)
                                $dateVar += 1800;
                            }
                            //END while
                            
                            ?>

                        </tbody>
                        <!--/Body of the table-->

                    </form>
                </table>

                <br/><br/><br/>

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