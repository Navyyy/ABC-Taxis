<?php
/*
Author : Yvan Cochet
Date : 30.50.2016
Summary : Page that print the list of cars
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
                        <li class="active"><a href=""><span class="glyphicon glyphicon-road">&nbsp;</span>Liste véhicules</a></li>
                        <li><a href="./calender-car.php"><span class="glyphicon glyphicon-calendar">&nbsp;</span>Planning véhicules</a></li>
                    </ul>
                </div>
            </nav>
            <!--____________________/NAVBAR__________________________-->


            <!--____________________Car list_________________________-->
            <div class="panel panel-default">

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Immatriculation</th>
                            <th>Marque</th>
                            <th>Sièges</th>
                            <th>Classe</th>
                            <th>Info</th>
                            <th>Actions</td>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        //Function to write all the cars
                        $carTab = $function->getAllCar();

                        //Loop that run all carTab table and write all cars
                        foreach($carTab as $car)
                        {
                            echo '<tr>';
                                echo '<td>'.$car['idCar'].'</td>';
                                echo '<td>'.$car['carRegistration'].'</td>';
                                echo '<td>'.$car['carBrand'].'</td>';
                                echo '<td>'.$car['carSeats'].'</td>';

                                //Get the class of the car
                                $class = $function->getClass($car['idCar']);
                                echo '<td>'.$class[0]['claName'].'</td>';

                                echo '<td>';

                                    //Chekc if there's a note and write something if there's one
                                    $note = $function->getNotes($car['idCar']);
                                    if(count($note) !== 0)
                                    {
                                        echo '<span class="color-red">Remarque à lire</span>';
                                    }
                                    else
                                    {
                                        echo '-';
                                    }

                                echo '</td>';

                                //Write the action buttons
                                echo '<td><a href="./detail-car.php?idCar='.$car['idCar'].'"><button type="button" class="btn btn-info btn-xs btn-round"><span class="glyphicon glyphicon-info-sign"></span></button></a> ';

                                    //Write delete button only if we are logged as admin
                                    if($_SESSION['login'] == 'admin')
                                    {
                                        echo ' <a><button type="button" class="btn btn-danger btn-xs btn-round"><span class="glyphicon glyphicon-trash"></span></button></a>';
                                    }

                            echo '</td></tr>';
                        }
                        ?>

                    </tbody>
                </table>
            </div>

            <!--____________________/Car list_________________________-->

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