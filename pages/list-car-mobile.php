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

            <title>Liste des véhicules | ABC Taxis Cochet SA</title>
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
                            <li class="active"><a href="./list-car-mobile.php"><span class="glyphicon glyphicon-road">&nbsp;</span>Liste véhicules</a></li>
                            <li><a href="./calender-car-mobile.php"><span class="glyphicon glyphicon-calendar">&nbsp;</span>Planning véhicules</a></li>
                        </ul>
                    </div>
                </nav>
                <!--____________________/NAVBAR__________________________-->

                <!--____________________Car list_________________________-->
                <div class="panel panel-default">

                    <table class="table table-hover align-left">
                        <thead class="floating-header">
                            <tr>
                                <th class="th-head-list-car">Immatriculation</th>
                                <th class="th-head-list-car">Info</th>
                            </tr>
                        </thead>
                        <tbody class="floating-body">

                            <?php
                            //Function to write all the cars
                            $carTab = $function->getAllCar();

                            //Loop that run all carTab table and write all cars
                            foreach($carTab as $car)
                            {
                                echo '<tr class="pointer-hover" onclick="listCarRedirection('.$car['idCar'].')">';
                                    echo '<td class="td-registration">'.$car['carRegistration'].'</td>';

                                    echo '<td>';

                                        //Chekc if there's a note and write something if there's one
                                        $note = $function->getNotes($car['idCar']);

                                        //Loop to check if there's an unread note
                                        $checkNote = 'y';
                                        foreach($note as $n)
                                        {
                                            if($n['notChecked'] == 'n')
                                            {
                                                $checkNote = 'n';
                                            }
                                        }

                                        if(count($note) !== 0 AND $checkNote == 'n')
                                        {
                                            echo '<span class="color-red">Remarque à lire</span>';
                                        }
                                        else
                                        {
                                            echo '-';
                                        }

                                    echo '</td>';

                                echo '</td></tr>';
                            }
                            ?>

                        </tbody>
                    </table>
                </div>

                <!--____________________/Car list_________________________-->

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