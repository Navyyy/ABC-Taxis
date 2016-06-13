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

    //--------Get all info about the car----------//

    //Get the car informations
    $tabCar = $function->getCarInfo($_GET['idCar']);
    $tabNotes = $function->getNotes($_GET['idCar']);

    //Get all the car classes
    $tabClass = $function->getAllClass();

    //Get all services made to the car
    $tabServices = $function->getServices($_GET['idCar']);

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

            <title>Détail du véhicules | ABC Taxis Cochet SA</title>
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
                            <li><a href="./calender-car-mobile.php"><span class="glyphicon glyphicon-calendar">&nbsp;</span>Planning véhicules</a></li>
                        </ul>
                    </div>
                </nav>
                <!--____________________/NAVBAR__________________________-->

                <!--____________________Car info_________________________-->
                <div class="panel panel-detail align-left">

                    <legend class="align-center"><h3>Information sur le véhicule</h3></legend>

                    <!--______Registration_____-->
                    <div class="form-group">

                        <label for="registration">Immatriculation :</label>
                        <?php
                        echo '<input readOnly name="registration" type="text" class="form-control" placeholder="Immatriculation" value="'.$tabCar[0]['carRegistration'].'">';
                        ?>

                    </div>

                    <!--______Class_____-->
                    <div class="form-group">

                        <label for="class">Classe :</label>
                        <?php
                        echo '<input readOnly name="class" type="text" class="form-control" placeholder="Classe" value="'.$tabCar[0]['claName'].'">';
                        ?>

                    </div>

                    <!--______Chassis_____-->
                    <div class="form-group">

                        <label for="chassis">Numéro de châssis :</label>
                        <?php
                        echo '<input readOnly name="chassis" type="text" class="form-control" placeholder="Numéro de châssis" value="'.$tabCar[0]['carChassis'].'">';
                        ?>

                     </div>

                     <!--______Brand_____-->
                      <div class="form-group">

                        <label for="brand">Marque :</label>
                        <?php
                        echo '<input readOnly name="brand" type="text" class="form-control" placeholder="Marque" value="'.$tabCar[0]['carBrand'].'">';
                        ?>

                    </div>

                    <!--______Model_____-->
                    <div class="form-group">

                        <label for="model">Modèle :</label>
                        <?php
                        echo '<input readOnly name="model" type="text" class="form-control" placeholder="Modèle" value="'.$tabCar[0]['carModel'].'">';
                        ?>

                    </div>

                    <!--______Year_____-->
                    <div class="form-group">

                        <label for="year">Année :</label>
                        <?php
                        echo '<input readOnly name="year" type="number" class="form-control" placeholder="Année" value="'.$tabCar[0]['carYear'].'">';
                        ?>

                    </div>

                    <!--______NbSeats_____-->
                    <div class="form-group">

                        <label for="seats">Nombre de sièges :</label>
                        <?php
                        echo '<input readOnly name="seats" type="number" class="form-control" placeholder="Nombre de sièges" value="'.$tabCar[0]['carSeats'].'">';
                        ?>

                    </div>

                </div>
                <!--____________________/Car info_________________________-->

                <!--__________Services made______________-->

                <div class="panel panel-detail align-left">
                    <legend class="align-center"><h3>Liste des services effectués</h3></legend>

                    <!--Table that print the services made-->
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:100%">Description</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach($tabServices as $service)
                            {
                                echo '<tr>';
                                    echo '<td>'.str_replace("\n","<br/>",$service['serDescription']).'</td>';
                                echo '</tr>';
                            }

                            ?>
                        </tbody>
                    </table>

                </div>
                <!--__________/Services made______________-->

                <!--__________Notes_________-->

                <div class="panel panel-detail align-left">

                    <!--Table that print notes-->
                    <table class="table">

                        <thead>
                            <tr>
                                <th style="width:55%">Description</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach($tabNotes as $note)
                            {
                                echo '<tr>';
                                    echo '<td>'.str_replace("\n","<br/>",$note['notDescription']).'</td>';
                                echo '</tr>';
                            }

                            ?>
                        </tbody>

                    </table>
                    <!--/Table that print notes-->

                    <!--Form to add a note-->

                    <form method="POST" action="add-note.php">

                        <?php
                        //Hidden input with the id of the car
                        echo '<input name="idCar" type="hidden" value="'.$_GET['idCar'].'">';

                        //Hidden input with info if it's mobile version or not
                        echo '<input name="version" type="hidden" value="mobile">';
                        ?>

                        <div class="form-group">

                            <textarea style="resize:none" name="note" placeholder="Ajouter une remarque" class="form-control" rows="3"></textarea>

                        </div>

                        <div class="form-group">

                            <!--Write all the drivers-->
                            <select name="name" class="form-control">
                                <option>-- Sélectionnez le redacteur --</option>
                                <?php
                                    $tabDriver = $function->getAllDriver();

                                    foreach($tabDriver as $driver)
                                    {
                                        echo '<option value="'.$driver['idDriver'].'">'.$driver['driName'].'</option>';
                                    }
                                ?>
                            </select>

                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Ajouter la remarque</button>

                    </form>

                    <!--/Form to add a note-->

                </div>
                <!--__________/Notes_________-->

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