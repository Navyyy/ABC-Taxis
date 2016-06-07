<?php
/*
Author : Yvan Cochet
Date : 06.06.2016
Summary : Page to process the adding or deleting of status
*/

session_start();

//If we're logged as admin, connect db and use function to add a car
if(isset($_SESSION['login']) AND $_SESSION['login'] == 'admin')
{

	include('dbAcces.php');
	$function = new dbAcces();

	//Method to connect to the db
	$function->dbConnect();

	$idDriver = $_GET['idDriver'];

	$tabStat = $function->getDriverStat($idDriver, 2016);

	echo json_encode($tabStat);
}
?>