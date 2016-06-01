<?php
/*
Author : Yvan Cochet
Date : 01.06.2016
Summary : Page to add a car
*/

session_start();

//If we're logged as admin, connect db and use function to add a car
if(isset($_SESSION['login']) AND $_SESSION['login'] == 'admin')
{

	include('dbAcces.php');
	$function = new dbAcces();

	//Method to connect to the db
	$function->dbConnect();

	//Add the car only if there's at least the registration
	if(isset($_POST['registrationAdd']) AND $_POST['registrationAdd'] !== '' AND isset($_POST['classAdd']) AND $_POST['classAdd'] !== '')
	{

		$function->addCar($_POST['registrationAdd'], $_POST['modelAdd'], $_POST['brandAdd'], $_POST['yearAdd'], $_POST['chassisAdd'], $_POST['seatsAdd'], $_POST['classAdd']);
	}
    
  	header('Location: list-car.php');      
}