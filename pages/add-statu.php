<?php
/*
Author : Yvan Cochet
Date : 06.06.2016
Summary : Page to add a statu
*/

session_start();

//If we're logged as admin, connect db and use function to add a car
if(isset($_SESSION['login']) AND $_SESSION['login'] == 'admin')
{

	include('dbAcces.php');
	$function = new dbAcces();

	//Method to connect to the db
	$function->dbConnect();

	//Add the car only if there's at least the registration and the class
	if(isset($_POST['staName']) AND $_POST['staName'] !== '' AND isset($_POST['staBackColor']) AND isset($_POST['staForeColor']))
	{

		$function->addStatu($_POST['staName'], $_POST['staBackColor'], $_POST['staForeColor']);
	}
    
  	header('Location: calender-car.php');      
}