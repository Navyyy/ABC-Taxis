<?php
/*
Author : Yvan Cochet
Date : 06.06.2016
Summary : Page to fast add status
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

    //Set start and end hour var for the loop
    $dateStart = strtotime($date." ".$_POST['startHour']);
    $dateEnd = strtotime($date." ".$_POST['endHour']);

    //Check if we have to add one day to the date or not
    if($dateStart >= strtotime($date." 04:30") AND $dateStart <= strtotime($date." 23:30"))
    {
        echo 'norm';
        $dateStart = strtotime($date." ".$_POST['startHour']);
    }
    else
    {
        $changeDate = strtotime($date);
        $changeDate += 86400;
        $dateStart = strtotime(date('Y-m-d',$changeDate)." ".$_POST['startHour']);
    }

    if($dateEnd >= strtotime($date." 04:30") AND $dateEnd <= strtotime($date." 23:30"))
    {
        echo 'norm';
        $dateEnd = strtotime($date." ".$_POST['endHour']);
    }
    else
    {
        $changeDate = strtotime($date);
        $changeDate += 86400;
        $dateEnd = strtotime(date('Y-m-d',$changeDate)." ".$_POST['endHour']);
    }

    //Loop to run all hours
    while($dateStart <= $dateEnd)
    {
    	$currentHour = date('H-i',$dateStart);

        //If value == empty, delete the statu
    	if(isset($_POST['statu']) AND $_POST['statu'] == 'empty' AND isset($_POST['car']) AND $_POST['car'] !== 'empty')
    	{
    		$function->deleteCarStatu($_POST['car'], date('Y-m-d H:i',$dateStart));
    	}
    	elseif(isset($_POST['statu']) AND isset($_POST['car']) AND $_POST['car'] !== 'empty' AND $_POST['statu'] !== 'empty')
    	{
    		$function->addCarStatu($_POST['car'], date('Y-m-d H:i',$dateStart), $_POST['statu']);
    	}

    	//Increment datVar value (+ 1/2 hour)
        $dateStart += 1800;
    }

    
  	header('Location: calender-car.php');      
}