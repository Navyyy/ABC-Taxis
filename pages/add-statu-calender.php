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

	//Put $_GET values in var
	$date = $_GET['date'];
	$value = $_GET['value'];
	$selectName = $_GET['selectName'];

	//Get id of the car
	$idCar = substr($selectName,0,-6);


	//Get hour and replace - by :
	$hour = substr($selectName,-5);
	$hour = str_replace("-", ":", $hour);

	//Convert date to time
	$dateTime = strtotime($date." ".$hour);

	if($dateTime >= strtotime($date." 04:30") AND $dateTime <= strtotime($date." 23:30"))
	{
		echo 'norm';
		$dateTime = strtotime($date." ".$hour);
	}
	else
	{
		$changeDate = strtotime($date);
		$changeDate += 86400;
		$dateTime = strtotime(date('Y-m-d',$changeDate)." ".$hour);
	}

	//If $valu is empty, delete the statu else, use function addCarStatu to know if the statu has to be update or insert
	if($value == "empty")
	{
		$function->deleteCarStatu($idCar, date('Y-m-d H:i',$dateTime));
	}
	else if($value !== "empty")
	{
		$function->addCarStatu($idCar, date('Y-m-d H:i',$dateTime), $value);
	}
}
?>