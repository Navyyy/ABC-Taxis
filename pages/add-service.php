<?php
/*
Author : Yvan Cochet
Date : 01.06.2016
Summary : Page to add a service
*/

session_start();

//If we're logged as admin, connect db and use function to add a service
if(isset($_SESSION['login']) AND $_SESSION['login'] == 'admin')
{

	include('dbAcces.php');
	$function = new dbAcces();

	//Method to connect to the db
	$function->dbConnect();

	//Add the service only if there's at least the service and the name
	if(isset($_POST['service']) AND $_POST['service'] !== '' AND isset($_POST['name']) AND $_POST['name'] !== '')
	{
		$function->addService($_POST['idCar'], $_POST['service'], $_POST['name']);
	}
    
  	header('Location: detail-car.php?idCar='.$_POST['idCar']);      
}