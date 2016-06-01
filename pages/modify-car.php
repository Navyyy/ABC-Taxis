<?php
/*
Author : Yvan Cochet
Date : 01.06.2016
Summary : Page to modify a car
*/

session_start();

//If we're logged as admin, connect db and use function to modify a car
if(isset($_SESSION['login']) AND $_SESSION['login'] == 'admin')
{

	include('dbAcces.php');
	$function = new dbAcces();

	//Method to connect to the db
	$function->dbConnect();

	//Modify the car only if there's at least the registration and the class
	if(isset($_POST['registration']) AND $_POST['registration'] !== '' AND isset($_POST['class']) AND $_POST['class'] !== '')
	{
		$function->modifyCar($_POST['idCar'], $_POST['registration'], $_POST['model'], $_POST['brand'], $_POST['year'], $_POST['chassis'], $_POST['seats'], $_POST['class']);

	}
    
  	header('Location: detail-car.php?idCar='.$_POST['idCar']);      
}