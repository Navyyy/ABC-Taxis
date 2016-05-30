<?php
/*
Author : Yvan Cochet
Date : 26.02.2016
Summary : Page to add a driver
*/

session_start();

if(isset($_SESSION['login']) AND $_SESSION['login'] == 'admin')
{

	include('dbAcces.php');
	$function = new dbAcces();

	//Method to connect to the db
	$function->dbConnect();

	if(isset($_POST['firstname']) AND isset($_POST['surname']))
	{
		$name = $_POST['surname'].' '.$_POST['firstname'];

		//Check if the driver exist in the db and add or delete
		$check = $function->checkName($name);

	}

	?>

	<meta http-equiv="refresh" content="0; URL=calender.php"/>
	<?php
}