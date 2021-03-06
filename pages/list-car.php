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

    //Get all the car classes (for add car form)
    $tabClass = $function->getAllClass();

    ?>  

    <!DOCTYPE html>
    <html>

        <head lang="fr">
            <!--Links for CSS, javascript, bootstrap-->
            <link href="../css/bootstrap.min.css" rel="stylesheet">
            <link href="../css/css-perso.css" rel="stylesheet">
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <script src="../jquery-1.11.3.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>
            <script src="../js/js-perso.js"></script>
            <script src="../js/jquery.tablesorter.min.js"></script>

            <link rel="icon" href="http://www.abctaxis.ch/favicon.png">

            <title>Liste des véhicules | ABC Taxis Cochet SA</title>
        </head>

        <body>
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
                        <li class="active"><a href=""><span class="glyphicon glyphicon-road">&nbsp;</span>Liste véhicules</a></li>
                        <li><a href="./calender-car.php"><span class="glyphicon glyphicon-calendar">&nbsp;</span>Planning véhicules</a></li>
                    </ul>
                    <?php

                    //Print dropdown form only if admin
                    if(isset($_SESSION['login']) AND $_SESSION['login'] =='admin')
                    {
                    ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ajouter un véhicule &nbsp;<span class="glyphicon glyphicon-plus"></span></a>
                                <div class="dropdown-menu" id="add-car-dropdown">

                                    <!--FORM TO ADD A CAR-->
                                    <form class="form" role="form" method="post" action="add-car.php" accept-charset="UTF-8">

                                        <!--Immatriculation-->
                                        <div class="form-group">
                                            <input name="registrationAdd" type="text" class="form-control" placeholder="Immatriculation (Ex. : VD150598) *" >
                                        </div>

                                        <!--______Class_____-->
                                        <div class="form-group">

                                            <select name="classAdd" class="form-control">
                                                <option>-- Classe* --</option>
                                                <?php

                                                    foreach($tabClass as $class)
                                                    {
                                                        echo '<option value="'.$class['idClass'].'">'.$class['claName'].'</option>';
                                                    }

                                                ?>
                                            </select>
                                        </div>

                                        <!--Chassis-->
                                        <div class="form-group">
                                            <input name="chassisAdd" type="text" class="form-control" placeholder="Numéro de châssis" >
                                        </div>

                                        <!--Brand-->
                                        <div class="form-group">
                                            <input name="brandAdd" type="text" class="form-control" placeholder="Marque" >
                                        </div>

                                        <!--Model-->
                                        <div class="form-group">
                                            <input name="modelAdd" type="text" class="form-control" placeholder="Modèle" >
                                        </div>

                                        <!--Year-->
                                        <div class="form-group">
                                            <input name="yearAdd" type="number" class="form-control" placeholder="Année" >
                                        </div>

                                        <!--Seats-->
                                        <div class="form-group">
                                            <input name="seatsAdd" type="number" class="form-control" placeholder="Nombre de sièges" >
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-block">Ajouter le véhicule</button>

                                    </form>
                                    <!--/FORM TO ADD A CAR-->

                                </div>
                            </li>
                        </ul>
                    <?php
                    }
                    ?>
                </div>
            </nav>
            <!--____________________/NAVBAR__________________________-->


            <!--____________________Car list_________________________-->
            <div class="panel panel-default">

                <table id="keywords" class="table table-hover table-condensed">
                    <thead class="floating-header">
                        <tr>
                            <th class="th-head-list-car">Immatriculation &nbsp;<span class="glyphicon glyphicon-chevron-up"></span></th>
                            <th class="th-head-list-car">Marque <span class="glyphicon glyphicon-chevron-up"></span></th>
                            <th class="th-head-list-car">Sièges <span class="glyphicon glyphicon-chevron-up"></span></th>
                            <th class="th-head-list-car">Classe <span class="glyphicon glyphicon-chevron-up"></span></th>
                            <th class="th-head-list-car">Info <span class="glyphicon glyphicon-chevron-up"></span></th>
                            <th class="th-head-list-car">Actions <span class="glyphicon glyphicon-chevron-up"></span></td>
                        </tr>
                    </thead>
                    <tbody class="floating-body">

                        <?php
                        //Function to write all the cars
                        $carTab = $function->getAllCar();

                        //Loop that run all carTab table and write all cars
                        foreach($carTab as $car)
                        {
                            echo '<tr>';
                                echo '<td class="td-registration">'.$car['carRegistration'].'</td>';

                                //Write carbrand only if it's not empty
                                if($car['carBrand'] == '')
                                {
                                    echo '<td> - </td>';
                                }
                                else
                                {
                                    echo '<td>'.$car['carBrand'].'</td>';
                                }

                                //Write nb seats only if it's not empty
                                if($car['carSeats']== '')
                                {
                                    echo '<td> - </td>';
                                }
                                else
                                {
                                    echo '<td>'.$car['carSeats'].'</td>';
                                }

                                //Get the class of the car
                                $class = $function->getClass($car['idCar']);

                                if(count($class) !== 0)
                                {
                                    echo '<td>'.$class[0]['claName'].'</td>';
                                }
                                else
                                {
                                    echo '<td> - </td>';
                                }

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

                                        /*$notDate = strtotime($n['notDate']);
                                        $notDate2 = date('Y-m-d',($notDate + 8*24*3600));


                                        if($notDate2 == date('Y-m-d'))
                                        {
                                            $to = 'cochetyv@etml.educanet2.ch';
                                            $message = 'Vous avez une remarque non lue sur le véhicule '.$car['carRegistration'];
                                            $subject = 'Remarque non lue';
                                            $headers = 'From: yvancochet@hotmail.com' . "\r\n" .
                                            'Reply-To: yvancochet@hotmail.com' . "\r\n" .
                                            'X-Mailer: PHP/' . phpversion();

                                            mail($to, $subject, $message);
                                        }*/
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

                                //Write the action buttons
                                echo '<td><a href="./detail-car.php?idCar='.$car['idCar'].'"><button type="button" class="btn btn-info btn-xs btn-round"><span class="glyphicon glyphicon-info-sign"></span></button></a> ';

                                    //Write delete button only if we are logged as admin
                                    if($_SESSION['login'] == 'admin')
                                    {
                                        echo ' <a onclick="return checkDelete()" href="./delete-car.php?idCar='.$car['idCar'].'" ><button type="submit" class="btn btn-danger btn-xs btn-round"><span class="glyphicon glyphicon-trash"></span></button></a>';
                                    }

                            echo '</td></tr>';
                        }
                        ?>

                    </tbody>
                </table>
            </div>

            <!--Script to sort the table-->
            <script type="text/javascript">
                $(function(){
                  $('#keywords').tablesorter(); 
                });
            </script>

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