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

            <!--______Link fo datePicker_____-->
            <!--  jQuery -->
            <script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>

            <!-- Isolated Version of Bootstrap, not needed if your site already uses Bootstrap -->
            <link rel="stylesheet" href="../css/bootstrap-iso.css" />

            <!-- Bootstrap Date-Picker Plugin -->
            <script type="text/javascript" src="../js/bootstrap-datepicker.min.js"></script>
            <link rel="stylesheet" href="../css/bootstrap-datepicker3.css"/>
            <!--______7Link fo datePicker_____-->


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


                <?php
                //Get the laste date used
                $tabDate = $function->getDateCar();

                //Get all the cars
                $tabCar = $function->getAllCar();

                //Get all the statu
                $tabStatu = $function->getAllStatu();

                ?>

                <table id="plan-car-tab">
                    <form method="post" action="post-car-calender.php">

                        <?php
                            echo '<input type="hidden" name="selectedDate" value="'.$tabDate[0]['datDate'].'">';
                        ?>

                        <!--Header of the table-->
                        <thead>
                            <tr>
                                <?php

                                echo '<th colspan="4" class="plan-car-date-head"><button type="submit" onclick="annim()" id="button-save"><span class="glyphicon glyphicon-save"></span>Save</button></th>';

                                //Print the date at the top of the table
                                echo '<th class="plan-car-date-head" colspan="'.(count($tabCar)-3).'">'.$tabDate[0]['datDate'].'</th>';
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
                            //Store date + hour in a var (one stat to keep start hour and one var for the loop)
                            $dateStat = strtotime($tabDate[0]['datDate'].' 04:30:00');
                            $dateVar = strtotime($tabDate[0]['datDate'].' 04:30:00');


                            //While dateVar < dateVar + 24h write the table <tr>
                            while($dateVar <= ($dateStat + ((23*3600) + 1800)))
                            {
                                //echo date('H:i',$dateVar).'<br/>';
                                echo '<tr>';
                                    echo '<th class="hour-head">'.date('H:i',$dateVar).'</th>';

                                    foreach($tabCar as $car)
                                    {
                                        echo '<th class="plan-car-list-th">';

                                            //Get the statu of the car at the current date
                                            $tabCurrentStatu = $function->getCarStatu($car['idCar'], date('Y-m-d H:i',$dateVar));

                                            //If the tab isn't empty, write the select with back color and the selected option. else write select without back color and without option
                                            if(count($tabCurrentStatu) !== 0)
                                            {
                                                echo '<select style="background-color:'.$tabCurrentStatu[0]['staBackColor'].'" onchange="colorCar(this)" class="plan-car-list" name="'.$car['idCar'].'-'.date('H-i',$dateVar).'">';

                                                    echo '<option value="'.$tabCurrentStatu[0]['idStatu'].'" style="background-color:'.$tabCurrentStatu[0]['staBackColor'].'">&nbsp;</option>';
                                            }
                                            else
                                            {
                                                echo '<select onchange="colorCar(this)" class="plan-car-list" name="'.$car['idCar'].'-'.date('H-i',$dateVar).'">';
                                            }

                                                echo '<option value="empty" style="background-color:white;">&nbsp;</option>';
                                                foreach($tabStatu as $statu)
                                                {
                                                    echo '<option value="'.$statu['idStatu'].'" style="background-color:'.$statu['staBackColor'].';">&nbsp;</option>';
                                                }
                                            echo '</select>';

                                        echo '</th>';
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