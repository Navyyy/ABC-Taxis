<?php
/*
Author : Yvan Cochet
Date : 01.06.2016
Summary : Page to update the date of the car planning
*/

session_start();

//If we're logged , connect db and use function to update the date
if(isset($_SESSION['login']))
{

	include('dbAcces.php');
	$function = new dbAcces();

	//Method to connect to the db
	$function->dbConnect();

	if(isset($_POST['date']) AND $_POST['date'] !== '')
	{
		$function->updateDateCar($_POST['date']);
	}
    
    //Redirection
  	header('Location: calender-car.php');        
}