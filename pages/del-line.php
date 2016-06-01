<?php
/*
Author : Yvan Cochet
Date : 26.02.2016
Summary : Page to delete a line
*/

session_start();

if(isset($_SESSION['login']) AND $_SESSION['login'] == 'admin')
{

	include('dbAcces.php');
	$function = new dbAcces();

	//Method to connect to the db
	$function->dbConnect();


	//Get var for selected month and year
	$selectedMonth = $_GET['month'];
	$selectedYear = $_GET['year'];

	if(isset($_GET['line']) AND $_GET['line'] !== '')
	{
		$function->delLine($_GET['line'],$selectedMonth,$selectedYear);
	}
	header('Location: calender.php');
}