<?php
/*
Author : Yvan Cochet
Date : 10.06.2016
Summary : Page to copy planning car of one day to the next day
*/

session_start();

//If we're logged as admin, connect db and use function to delete a car
if(isset($_SESSION['login']) AND $_SESSION['login'] == 'admin')
{

	include('dbAcces.php');
	$function = new dbAcces();

	//Method to connect to the db
	$function->dbConnect();

	$function->copyCarPlanning($_GET['date']);
    
  	header('Location: calender-car.php');      
}