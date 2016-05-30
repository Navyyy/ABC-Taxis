<?php
/*
Author : Yvan Cochet
Date : 26.02.2016
Summary : Page to connect the user
*/

include('dbAcces.php');
$function = new dbAcces();

//Method to connect to the db
$function->dbConnect();

//If all the from is full
if(isset($_POST['version']) AND isset($_POST['password']) AND $_POST['password'] !== '' AND $_POST['version'] !== '')
{
	
	$password = $_POST['password'];

	//Verify password and get the name using method
	$name = $function->passwordVerify($password);
	
	//If name = error return to index page
	if($name !== 'error')
	{
		//If name is not error start session and put the name in S_SESSION
		session_start();
		$_SESSION['login'] = $name;
		$_SESSION['version'] = $_POST['version'];

		if($_POST['version'] == 'computer' AND $_SESSION['login'] == 'admin' OR $_POST['version'] == 'mobile' AND $_SESSION['login'] == 'admin' )
		{
			?>
			<meta http-equiv="refresh" content="0; URL=./calender.php"/>
			<?php
		}
		else if($_POST['version'] == 'computer' AND $_SESSION['login'] == 'driver')
		{
			?>
			<meta http-equiv="refresh" content="0; URL=./calender-driver.php"/>
			<?php
		}
		else if($_POST['version'] == 'mobile' AND $_SESSION['login'] == 'driver')
		{
			?>
			<meta http-equiv="refresh" content="0; URL=./calender-driver-mobile.php"/>
			<?php
		}
		else
		{
			echo 'Site pas terminé, pages demandées en maintenance !';
		}

	}
	else if($name == 'error')
	{
		?>
		<meta http-equiv="refresh" content="0; URL=./../index.html"/>
		<?php
	}
}
else
{
	?>
	<meta http-equiv="refresh" content="0; URL=./../index.html"/>
	<?php
}


?>