<?php
/*
Author : Yvan Cochet
Date : 26.02.2016
Summary : Page to query date value
*/

session_start();

if( isset($_SESSION['login']) AND $_SESSION['login'] == 'admin' OR $_SESSION['login'] == 'driver')
{

	include('dbAcces.php');
	$function = new dbAcces();

	//Method to connect to the db
	$function->dbConnect();


	//Get var for selected month and year
	$selectedMonth = $function->getSelectedMonth();
	$selectedYear = $function->getSelectedYear();

	if(isset($_POST['month']) AND isset($_POST['year']))
	{
		if($selectedMonth !== $_POST['month'] OR $selectedYear !== $_POST['year'])
		{
			$function->setSelectedMonth($_POST['month']);
			$function->setSelectedYear($_POST['year']);
		}
	}

	if($_SESSION['login'] == 'admin' AND $_SESSION['version'] == 'computer')
	{
		header('Location: calender.php');
	}
	else if($_SESSION['login'] == 'driver' AND $_SESSION['version'] == 'computer')
	{
		header('Location: calender-driver.php');
	}
	else if($_SESSION['login'] == 'driver' AND $_SESSION['version'] == 'mobile')
	{
		if(isset($_POST['driver']) AND $_POST['driver'] !== '')
		{
			header('Location: calender-driver-mobile.php?driver='.$_POST['driver']);
		}
		else
		{
			header('Location: calender-driver-mobile.php');
		}
	}
	else
	{
		echo '<h1>ERROR</h1>';
	}

}