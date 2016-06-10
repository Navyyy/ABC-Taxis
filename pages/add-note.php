<?php
/*
Author : Yvan Cochet
Date : 01.06.2016
Summary : Page to add a note
*/

session_start();

//If we're logged as admin, connect db and use function to add a note
if(isset($_SESSION['login']))
{

	include('dbAcces.php');
	$function = new dbAcces();

	//Method to connect to the db
	$function->dbConnect();

	//Add the note only if there's at least the note and the name
	if(isset($_POST['note']) AND $_POST['note'] !== '' AND isset($_POST['name']) AND $_POST['name'] !== '')
	{
		$function->addNote($_POST['idCar'], $_POST['note'], $_POST['name']);
	}
    
    if($_POST['version'] == 'ordinateur')
    {
  		header('Location: detail-car.php?idCar='.$_POST['idCar']); 
  	}
  	elseif($_POST['version'] == 'mobile')
  	{
  		header('Location: detail-car-mobile.php?idCar='.$_POST['idCar']); 
  	}  
}