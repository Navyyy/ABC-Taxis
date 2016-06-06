<?php
/*
Author : Yvan Cochet
Date : 06.06.2016
Summary : Page to delete a statu
*/

session_start();

//If we're logged as admin, connect db and use function to add a car
if(isset($_SESSION['login']) AND $_SESSION['login'] == 'admin')
{

	include('dbAcces.php');
	$function = new dbAcces();

	//Method to connect to the db
	$function->dbConnect();

	$function->deleteStatu($_GET['idStatu']);

  	header('Location: calender-car.php');      
}