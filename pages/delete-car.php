<?php
/*
Author : Yvan Cochet
Date : 01.06.2016
Summary : Page to delete a car
*/

session_start();

//If we're logged as admin, connect db and use function to delete a car
if(isset($_SESSION['login']) AND $_SESSION['login'] == 'admin')
{

	include('dbAcces.php');
	$function = new dbAcces();

	//Method to connect to the db
	$function->dbConnect();

	$function->deleteCar($_GET['idCar']);
    
  	header('Location: list-car.php');      
}