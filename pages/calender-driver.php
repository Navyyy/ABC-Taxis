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
            <a href="http://www.abctaxis.ch"><img src="./../pictures/logo-abc.png" alt="logo ABC Taxi"/></a>
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
                        <li class="active"><a href="#"><span class="glyphicon glyphicon-th-list">&nbsp;</span>Planning chauffeurs</a></li>
                        <li><a href="./list-car.php"><span class="glyphicon glyphicon-road">&nbsp;</span>Liste véhicules</a></li>
                        <li><a href="./calender-car.php"><span class="glyphicon glyphicon-calendar">&nbsp;</span>Planning véhicules</a></li>
                    </ul>
                </div>
            </nav>
            <!--____________________/NAVBAR__________________________-->

            <!--___________________CALENDER__________________________-->

            <table id="car-planning-table" class="perso-table">
                <form action="post-calender.php" method="post">

                    <tr>
                        <th colspan="40" id="car-planning-legend">
                            <span class="span a-yellow">A</span> = Voiture 'A' ouverture | &nbsp;
                            <span class="span a-black">A</span> = Voiture 'A' fermeture  | &nbsp;
                            <span class="span a-red">A</span> = Voiture 'A'  | &nbsp;
                            <span class="span b-white">B</span> = Voiture 'B'  | &nbsp;
                            <span class="span a-black">B</span> = Voiture 'B' fermeture  | &nbsp;
                            <span class="span l-white">L</span> = Limousine  | &nbsp;
                            <span class="span v-white">V</span> = Vacances  | &nbsp;
                            <span class="span m-white">M</span> = Maladie  | &nbsp;
                            <span class="span f-white">F</span> = Formation  | &nbsp;
                            <span class="span left">L</span> = Congé <br/><br/>
                            <span class="span c-white">C</span> = Call despatch jour  | &nbsp;
                            <span class="span c-black">C</span> = Call despatch nuit
                        </th>
                    </tr>
                    <tr>
                        <th colspan="3" rowspan="2" class="car-planning-header"><?php echo $selectedYear ?></th>
                        <?php
                        //Set the date to use in the function
                        $date = strtotime($selectedYear.'-'.$selectedMonth.'-01');

                        //Write the name of the month in the header
                        echo '<th colspan="40" class="car-planning-header">'.$function->convertMonth($selectedMonth).'</th>';
                        ?>
                    </tr>
                    <?php
                    /*________________Loop to display header of te table (name of the days and number of the days)___________________________*/

                    //Get the nb of lignes
                    $nbLigne = $function->getNbLine($selectedMonth,$selectedYear);

                        //i = 2 (1 time for the name of the day 1 other time for the number of the days)
                        for($i = 0 ; $i < $nbLigne ; $i++)
                        {
                            //Check if the driver name isn't separation
                            $driver = $function->getDriver($i,$selectedMonth,$selectedYear);

                            //convert to date selected month and year
                            $date = strtotime($selectedYear.'-'.$selectedMonth.'-01');
                            echo '<tr>';


                            if($i == 1)
                            {
                                echo '<th colspan="3" id="car-planning-header-name" class="car-planning-header">Nom, prénom</th>';
                            }
                            else if($i > 1)
                            {
                                echo '<th class="driName-driver" colspan="3">'.$function->getDriver($i, $selectedMonth, $selectedYear).'</th>';
                            }

                            //Loop that browse all day of the selected month
                            while(date('m',$date) <= $selectedMonth AND date('Y',$date) <= $selectedYear)
                            {
                                //Replace day from 0-6 to 1-7
                                $w = str_replace('0','7',date('w',$date));

                                //Number of the day
                                $d = date('j',$date);

                                if($i == 0)
                                {
                                    //Display the name of the days
                                    if($w == 1)
                                    {
                                        echo '<th class="car-planning-day-name">l<br/>u<br/>n</th>';
                                    }
                                    else if($w == 2)
                                    {
                                        echo '<th class="car-planning-day-name">m<br/>a<br/>r</th>';
                                    }
                                    else if($w == 3)
                                    {
                                        echo '<th class="car-planning-day-name">m<br/>e<br/>r</th>';
                                    }
                                    else if($w == 4)
                                    {
                                        echo '<th class="car-planning-day-name">j<br/>e<br/>u</th>';
                                    }
                                    else if($w == 5)
                                    {
                                        echo '<th class="car-planning-day-name">v<br/>e<br/>n</th>';
                                    }
                                    else if($w == 6)
                                    {
                                        echo '<th class="car-planning-day-name">s<br/>a<br/>m</th>';
                                    }
                                    else if($w == 7)
                                    {
                                        echo '<th class="car-planning-day-name">d<br/>i<br/>m</th>';

                                        //Put a separator if it's not the last sunday
                                        if(date('m', $date + 24*3600) == $selectedMonth)
                                        {
                                            echo '<th class="car-planning-week-separator"></th>';
                                        }
                                    }
                                    
                                }
                                else if($i == 1)
                                {
                                    //Display the number of the days
                                    if($w == 7)
                                    {
                                        echo '<th class="car-planning-day-number">'.$d.'</th>';

                                        //Put a separator if it's not the last sunday
                                        if(date('m', $date + 24*3600) == $selectedMonth)
                                        {
                                            echo '<th class="car-planning-week-separator"></th>';
                                        }
                                    }
                                    else
                                    {
                                        echo '<th class="car-planning-day-number">'.$d.'</th>';
                                    }
                                }
                                else
                                {
                                    //If driver is 'separation' write a separation line
                                    if($driver =='Séparation')
                                    {
                                        echo '<th colspan="'.$function->getColspan($date).'" class="separation"></th>';
                                        break;
                                    }
                                    else
                                    {
                                        //Use functions to display list of task
                                        if($w == 7)
                                        {
                                            $function->getTask($i, date('Y-m-d',$date));

                                            //Put a separator if it's not the last sunday
                                            if(date('m', $date + 24*3600) == $selectedMonth)
                                            {
                                                echo '<th class="car-planning-week-separator"></th>';
                                            }
                                        }
                                        else
                                        {
                                            $function->getTask($i, date('Y-m-d',$date));
                                        }
                                    }
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

                            }//END WHILE

                            echo '</tr>';

                        } //END FOR LOOP

                        
                    ?>

                </form>
            </table>

            <!--___________________/CALENDER__________________________-->

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