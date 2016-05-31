<?php
/*
Author : Yvan Cochet
Date : 30.50.2016
Summary : Detail of the car page
*/

session_start();

if(isset($_SESSION['login']))
{

    include('dbAcces.php');
    $function = new dbAcces();

    //Method to connect to the db
    $function->dbConnect();

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

            <link rel="icon" href="http://www.abctaxis.ch/favicon.png">

            <title>Planning chauffeurs | ABC Taxis Cochet SA</title>
        </head>

        <body>
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
                </div>
            </nav>
            <!--____________________/NAVBAR__________________________-->

            <!--__________________Detail of the car_________________-->

            <?php

            //Get the car informations
            $tabCar = $function->getCarInfo($_GET['idCar']);
            $tabNote = $function->getNotes($_GET['idCar']);

            //Get all the car classes
            $tabClass = $function->getAllClass();

            //Get all services made to the car
            $tabServices = $function->getServices($_GET['idCar']);

            //Check if the user is allowed to modify the car or not
            $allowed = '';
            if(isset($_SESSION['login']) AND $_SESSION['login'] == 'driver')
            {
                $allowed = 'readOnly';
            }

            ?>

            <!--__________Form with car info_____________-->

            <div class="panel col-sm-offset col-sm-6">

                <legend><h2>Information sur le véhicule</h2></legend>

                <div class="panel-body">

                    <form class="" method="POST" action="#">

                        <!--______Registration_____-->
                        <div class="form-group">

                            <label for="registration">Immatriculation :</label>
                            <?php
                            echo '<input '.$allowed.' name="registration" type="text" class="form-control" placeholder="Immatriculation" value="'.$tabCar[0]['carRegistration'].'">';
                            ?>

                        </div>

                        <!--______Class_____-->
                        <div class="form-group">

                            <label for="class">Classe :</label>
                            <?php
                            echo '<select'.$allowed.' class="form-control">';
                            ?>
                                <?php
                                    echo '<option value"'.$tabCar[0]['idClass'].'">'.$tabCar[0]['claName'].'</option>';

                                    foreach($tabClass as $class)
                                    {
                                        echo '<option value"'.$class['idClass'].'">'.$class['claName'].'</option>';
                                    }

                                ?>
                            </select>

                        </div>

                        <!--______Brand_____-->
                        <div class="form-group">

                            <label for="brand">Marque :</label>
                            <?php
                            echo '<input '.$allowed.' name="brand" type="text" class="form-control" placeholder="Marque" value="'.$tabCar[0]['carBrand'].'">';
                            ?>

                        </div>

                        <!--______Model_____-->
                        <div class="form-group">

                            <label for="model">Modèle :</label>
                            <?php
                            echo '<input '.$allowed.' name="model" type="text" class="form-control" placeholder="Modèle" value="'.$tabCar[0]['carModel'].'">';
                            ?>

                        </div>

                        <!--______Year_____-->
                        <div class="form-group">

                            <label for="year">Année :</label>
                            <?php
                            echo '<input '.$allowed.' name="year" type="number" class="form-control" placeholder="Année" value="'.$tabCar[0]['carYear'].'">';
                            ?>

                        </div>

                        <!--______NbSeats_____-->
                        <div class="form-group">

                            <label for="seats">Nombre de sièges :</label>
                            <?php
                            echo '<input '.$allowed.' name="seats" type="number" class="form-control" placeholder="Nombre de sièges" value="'.$tabCar[0]['carSeats'].'">';
                            ?>

                        </div>

                        <!--Display done button only if logged as admin-->
                        <?php
                        if(isset($_SESSION['login']) AND $_SESSION['login'] == 'admin')
                        {
                            echo '<button type="submit" class="btn btn-primary btn-block">Appliquer les modifications</button>';
                        }

                        ?>

                    </form>

                </div>
            </div>

            <!--__________/Form with car info_____________-->

            <!--__________Services made_____________-->
            <div class="panel col-sm-offset-1 col-sm-5">

                <legend><h2>Liste des services effectués</h2></legend>

                <div class="panel-body">
                    
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    
                </div>
            </div>
            <!--__________/Services made_____________-->


            <!--_________________/Detail of the car_________________-->

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