<?php
/*
Author : Yvan Cochet
Date : 26.02.2016
Summary : Page to add one empty line
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
		$function->addLine($_GET['line'],$selectedMonth,$selectedYear);
	}
	?>
	<meta http-equiv="refresh" content="0; URL=calender.php"/>
	<?php
}