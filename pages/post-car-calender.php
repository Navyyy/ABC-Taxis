<?php
/*
Author : Yvan Cochet
Date : 01.06.2016
Summary : Page to process the adding or deleting of the status
*/

session_start();

//If we're logged as admin, connect db and use function to add a car
if(isset($_SESSION['login']) AND $_SESSION['login'] == 'admin')
{

	include('dbAcces.php');
	$function = new dbAcces();

	//Method to connect to the db
	$function->dbConnect();

	//Get the date
	$date = $_POST['selectedDate'];

	//Get all the cars
    $tabCar = $function->getAllCar();

    //Store date + hour in a var (one stat to keep start hour and one var for the loop)
    $dateStat = strtotime($date.' 04:30:00');
    $dateVar = strtotime($date.' 04:30:00');

    //Loop to run all hours
    while($dateVar <= ($dateStat + ((23*3600) + 1800)))
    {
    	$currentHour = date('H-i',$dateVar);

    	//Loop to run all cars
    	foreach($tabCar as $car)
    	{
    		//Var to check
    		$currentCar = $car['idCar'];

    		//If value == empty, delete the statu
    		if(isset($_POST[$currentCar.'-'.$currentHour]) AND $_POST[$currentCar.'-'.$currentHour] == 'empty')
    		{
    			$function->deleteCarStatu($currentCar, date('Y-m-d H:i',$dateVar));
    		}
    		elseif(isset($_POST[$currentCar.'-'.$currentHour]))
    		{
    			$function->addCarStatu($currentCar, date('Y-m-d H:i',$dateVar), $_POST[$currentCar.'-'.$currentHour]);
    		}
    	}

    	//Increment datVar value (+ 1/2 hour)
        $dateVar += 1800;
    }

    
  	header('Location: calender-car.php');      
}