<?php

/*
Author : Yvan Cochet
Date : 19.02.2016
Summary : Function to create table and call the database
*/

class dbAcces
{

	/*___________________________Voir algorythme pour les boucles_____________________*/
	

    private $db;

    //FUNCTION HEADER
    /// <summary>
    /// Method to connect to the db
    /// </summary>
    public function dbConnect()
    {
    	//Var to acces db
    	$login = 'root';
    	$password = '';
    	$host = 'localhost';
    	$dnName = 'db_abctaxis';
    	$this->db = new PDO('mysql:host=localhost;dbname=db_abctaxis', $login, $password, array( PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }


	//FUNCTION HEADER
    /// <summary>
    /// Method to get the month
    /// </summary>
    ///<return>last selected month</return>
	public function getSelectedMonth()
	{
		//Search selected month in the db
		$reqMonth = $this->db->query('SELECT month FROM t_date');
		$month = $reqMonth->fetch();
		return $month[0];
		$reqMonth->closeCursor();
	}

	//FUNCTION HEADER
    /// <summary>
    /// Method to set the month
    /// </summary>
    ///<var>Selected month</var>
	public function setSelectedMonth($month)
	{
		$reqMonth = $this->db->prepare('UPDATE t_date SET month = :month');
		$reqMonth->execute(array(
			'month' => $month
			));
		$reqMonth->closeCursor();
	}

	//FUNCTION HEADER
    /// <summary>
    /// Method to get the year
    /// </summary>
    ///<return>last selected year</return>
	public function getSelectedYear()
	{
		$reqYear = $this->db->query('SELECT year FROM t_date');
		$year = $reqYear->fetch();
		return $year[0];
		$reqYear->closeCursor();
	}

	//FUNCTION HEADER
    /// <summary>
    /// Method to set the year
    /// </summary>
    ///<var>Selected year</var>
	public function setSelectedYear($year)
	{
		$reqYear = $this->db->prepare('UPDATE t_date SET year = :year');
		$reqYear->execute(array(
			'year' => $year
			));

		$reqYear->closeCursor();
	}

	//FUNCTION HEADER
    /// <summary>
    /// Method to convert decimal month to alphabetic
    /// </summary>
    ///<var>Month to convert</var>
    ///<return>name of the month</return>
	public function convertMonth($month)
	{
		if($month == 1)
		{
			return 'janvier';
		}
		else if($month == 2)
		{
			return 'février';
		}
		else if($month == 3)
		{
			return 'mars';
		}
		else if($month == 4)
		{
			return 'avril';
		}
		else if($month == 5)
		{
			return 'mai';
		}
		else if($month == 6)
		{
			return 'juin';
		}
		else if($month == 7)
		{
			return 'juillet';
		}
		else if($month == 8)
		{
			return 'août';
		}
		else if($month == 9)
		{
			return 'septembre';
		}
		else if($month == 10)
		{
			return 'octobre';
		}
		else if($month == 11)
		{
			return 'novembre';
		}
		else if($month == 12)
		{
			return 'decembre';
		}
	}

	//FUNCTION HEADER
    /// <summary>
    /// Method to get the nbr of ligne in the table
    /// </summary>
    ///<return>number of lignes</return>
	public function getNbLine($month,$year)
	{
		$reqGetNbLine = $this->db->prepare('SELECT MAX(calLine) FROM t_calender WHERE calMonth = :calMonth AND calYear = :calYear');
		$reqGetNbLine->execute(array(
			'calMonth' => $month,
			'calYear' => $year
			));
		$lines = $reqGetNbLine->fetch();

		//+2 because there is the 2 headers
		return $lines[0]+4;

		$reqGetNbLin->closeCursor();
	}

	//FUNCTION HEADER
    /// <summary>
    /// Method to get the list of drivers
    /// </summary>
    ///<var>Num ligne of the select</var>
	public function listDriver($ligne, $month, $year)
	{
		//Request to get the driver of the line
		$reqGetCurrentDriver = $this->db->prepare('SELECT driName, calDate FROM t_calender INNER JOIN t_driver ON fkDriver = idDriver WHERE calLine = :calLine AND calMonth = :calMonth AND calYear = :calYear');
		$reqGetCurrentDriver->execute(array(
			'calLine' => $ligne,
			'calMonth' => $month,
			'calYear' => $year
			));
		$currentDriver = $reqGetCurrentDriver->fetch();

		echo '<select name="driver'.$ligne.'" class="car-planning-name-list">';

		echo '<option value="'.$currentDriver[0].'">'.$currentDriver[0].'</option>';
		echo '<option></option>';
		$reqListDriver = $this->db->query('SELECT driName FROM t_driver ORDER BY driName');
		while($driver = $reqListDriver->fetch())
		{
			echo '<option value="'.$driver[0].'">'.$driver[0].'</option>';
		}

		echo '</select>';

		$reqListDriver->closeCursor();
	}


	public function getListDriver()
	{
		$reqListDriver = $this->db->query('SELECT driName FROM t_driver ORDER BY driName');
		echo '<select name="driver" class="form-control">';
		while($driver = $reqListDriver->fetch())
		{
			echo '<option value="'.$driver[0].'">'.$driver[0].'</option>';
		}
		echo '</select>';
		$reqListDriver->closeCursor();
	}

	//FUNCTION HEADER
    /// <summary>
    /// Method to get the list of task
    /// </summary>as
    ///<var>Num ligne of the select</var>
    ///<var>Day of the select</var>
    ///<var>Date of the task</var>
	public function listTask($ligne, $day, $date)
	{
		//Request to get the task of this date if there's one
		$reqGetTask = $this->db->prepare('SELECT taskName FROM t_calender INNER JOIN t_task ON fkTask = idTask WHERE calDate = :calDate AND calLine = :calLine');
		$reqGetTask->execute(array(
			'calDate' => $date,
			'calLine' => $ligne
			));
		$task = $reqGetTask->fetch();

		echo '<select class="car-planning-task '.$task[0];

		if(substr($task[0], 2,7) == 'white')
		{
			echo ' transparent" onchange="color(this)" name="'.$ligne.'-'.$day.'">';
		}
		else
		{
			echo '" onchange="color(this)" name="'.$ligne.'-'.$day.'">';
		}

		//Print the current task
		echo '<option value="'.$task[0].'" class="car-planning-task '.$task[0].'">'.strtoupper(substr($task[0],0,1)).'</option>';

		//Print all other tasks
		echo '<option value="empty" class="car-planning-task empty"></option><option value="a-yellow" class="car-planning-task a-yellow" >A</option><option value="a-black" class="car-planning-task a-black" >A</option><option value="a-red" class="car-planning-task a-red" >A</option><option value="b-white" class="car-planning-task b-white" >B</option><option value="b-black" class="car-planning-task b-black">B</option><option value="l-white" class="car-planning-task l-white">L</option><option value="v-white" class="car-planning-task v-white">V</option><option value="m-white" class="car-planning-task m-white">M</option><option value="f-white" class="car-planning-task f-white">F</option><option value="left" class="car-planning-task left">L</option><option value="c-white" class="car-planning-task c-white">C</option><option value="c-black" class="car-planning-task c-black">C</option>';
		echo '</select>';
		$reqGetTask->closeCursor();

	}

	//FUNCTION HEADER
    /// <summary>
    /// Method to get the list of month
    /// </summary>
	public function getListMonth()
	{
		?>
		<select name="month" class="form-control">
            <option value=1>Janvier</option>
			<option value=2>Février</option>
			<option value=3>Mars</option>
			<option value=4>Avril</option>
			<option value=5>Mai</option>
			<option value=6>Juin</option>
			<option value=7>Juillet</option>
			<option value=8>Août</option>
			<option value=9>Septembre</option>
			<option value=10>Octobre</option>
			<option value=11>Novembre</option>
			<option value=12>Decembre</option>
        </select>

        <?php
	}

	//FUNCTION HEADER
    /// <summary>
    /// Method to get the list of year
    /// </summary>
	public function getListYear()
	{
		?>
		<select name="year" class="form-control">
            <option value=2016>2016</option>
			<option value=2017>2017</option>
			<option value=2018>2018</option>
			<option value=2019>2019</option>
			<option value=2020>2020</option>
			<option value=2021>2021</option>
			<option value=2022>2022</option>
			<option value=2023>2023</option>
			<option value=2024>2024</option>
			<option value=2025>2025</option>
        </select>

        <?php
	}

	//FUNCTION HEADER
    /// <summary>
    /// Method to check if the driver exist in the db
    /// </summary>
    ///<var>Name of the driver</var>
    ///<return>Value to know if driver exist or not</return>
	public function checkName($name)
	{
		$reqCheckName = $this->db->prepare('SELECT driName FROM t_driver WHERE driName = :driName');
		$reqCheckName->execute(array(
			'driName' => $name
			));
		$check = $reqCheckName->fetch();
		if($check[0] == '')
		{
			$this->addDriver($name);
		}
		else
		{
			$this->delDriver($name);
		}
		$reqCheckName->closeCursor();
	}

	//FUNCTION HEADER
    // <summary>
    // Method to add a driver in the db
    // </summary>
    //<var name="name">Name of the driver</var>
	private function addDriver($name)
	{
		$reqAddDriver = $this->db->prepare('INSERT INTO t_driver(driName) VALUE (:driName)');
		$reqAddDriver->execute(array(
			'driName' => $name
			));
		$reqAddDriver->closeCursor();
	}

	//FUNCTION HEADER
    // <summary>
    // Method to delete a driver from the db
    // </summary>
    //<var name="name">Name of the driver</var>
	private function delDriver($name)
	{
		$reqDelDriver = $this->db->prepare('DELETE FROM t_driver WHERE driName = :driName');
		$reqDelDriver->execute(array(
			'driName' => $name
			));
		$reqDelDriver->closeCursor();
	}

	//FUNCTION HEADER
    // <summary>
    // Check who is the driver (separation or not)
    // </summary>
    //<var name="i">Num of the line to check</var>
	public function getDriver($i,$month,$year)
	{
		$reqGetDriver = $this->db->prepare('SELECT driName FROM t_calender INNER JOIN t_driver ON fkDriver = idDriver WHERE calLine = :calLine AND calMonth = :calMonth AND calYear = :calYear');
		$reqGetDriver->execute(array(
			'calLine' => $i,
			'calMonth' => $month,
			'calYear' => $year
			)); 
		$driver = $reqGetDriver->fetch();
		return $driver[0];
	}

	//FUNCTION HEADER
    // <summary>
    // Get the colspan for separation and header of the table (number of day + number of week)
    // </summary>
    //<var name="date">Date to use</var>
	public function getColspan($date)
	{
		$nbDay = date('t',$date);

		if(($nbDay/7) < 4.3)
		{
			$nbWeek = floor($nbDay/7);
		}
		else
		{
			$nbWeek = ceil($nbDay/7);
		}

		//$nbWeek = ceil($nbDay/7);
        $result = $nbDay + $nbWeek;
        return $result;
	}

	//FUNCTION HEADER
    // <summary>
    // Add a task in the db (check if it already exist)
    // </summary>
    //<var name="task">Name of the task</var>
    //<var name="line">Line of the task</var>
    //<var name="driver">Driver assigned to the task</var>
    //<var name="date">Date of the task</var>
	public function addTask($task, $line, $driver, $date)
	{
		//Request to check if it's already in the db
		$reqCheckTask = $this->db->prepare('SELECT driName, taskName FROM t_calender INNER JOIN t_driver ON fkDriver = idDriver INNER JOIN t_task ON fkTask = idTask WHERE calLine = :calLine AND calDate = :calDate');
		$reqCheckTask->execute(array(
			'calLine' => $line,
			'calDate' => $date
			));
		$checkInfo = $reqCheckTask->fetch();

		//If task doesn't exist in the db, create one
		if($checkInfo['driName'] !== $driver AND $checkInfo['taskName'] !== $task)
		{
			$reqAddTask = $this->db->prepare('INSERT INTO t_calender(idCalender,calDate,calLine,fkDriver,fkTask,calMonth,calYear) VALUES(NULL,:calDate,:calLine,(SELECT idDriver FROM t_driver WHERE driName = :driName),(SELECT idTask FROM t_task WHERE taskName = :taskName),:calMonth,:calYear)');
			$reqAddTask->execute(array(
				'calDate' => $date,
				'calLine' => $line,
				'driName' => $driver,
				'taskName' => $task,
				'calMonth' => date('m',strtotime($date)),
				'calYear'=> date('Y',strtotime($date))
				));
			$reqAddTask->closeCursor();
		}
		//IF it already exists, update the existing task
		else if($checkInfo['driName'] !== $driver OR $checkInfo['taskName'] !== $task)
		{
			$reqUpdateTask = $this->db->prepare('UPDATE t_calender SET fkTask = (SELECT idTask FROM t_task WHERE taskName = :taskName), fkDriver = (SELECT idDriver FROM t_driver WHERE driName = :driName) WHERE calLine = :calLine AND calDate = :calDate');
			$reqUpdateTask->execute(array(
				'taskName' => $task,
				'driName' => $driver,
				'calLine' => $line,
				'calDate' => $date
				));
			$reqUpdateTask->closeCursor();
		}

		$reqCheckTask->closeCursor();
		
	}

	//FUNCTION HEADER
    // <summary>
    // Add a separation to the calende (put all the task of a line at NULL)
    // </summary>
    //<var name="line">Line of the task</var>
    //<var name="driver">Driver assigned to the task</var>
    //<var name="date">Date of the task</var>
	public function addSeparation($line, $driver, $date)
	{
		$this->delTask($line,date('m',strtotime($date)),date('Y',strtotime($date)));

		$reqAddSeparation = $this->db->prepare('INSERT INTO t_calender(idCalender,calDate,calLine,fkDriver,fkTask,calMonth,calYear) VALUES (NULL,:calDate,:calLine,(SELECT idDriver FROM t_driver WHERE driName = :driName),NULL,:calMonth,:calYear)');
		$reqAddSeparation->execute(array(
			'calDate' => $date,
			'calLine' => $line,
			'driName' => $driver,
			'calMonth' => date('m',strtotime($date)),
			'calYear' => date('Y',strtotime($date))
			));
		$reqAddSeparation->closeCursor();
	}

	//FUNCTION HEADER
    // <summary>
    // Delete all the tasks of a line
    // </summary>
    //<var name="line">Line of the tasks</var>
	public function delTask($line,$month,$year)
	{
		$reqDelTask = $this->db->prepare('DELETE FROM t_calender WHERE calLine = :calLine AND calMonth = :calMonth AND calYear = :calYear');
		$reqDelTask->execute(array(
			'calLine' => $line,
			'calMonth' => $month,
			'calYear' => $year
			));
		$reqDelTask->closeCursor();
	}

	//FUNCTION HEADER
    // <summary>
    // Add a line
    // </summary>
    //<var name="line">Line after which add a line</var>
    //<var name="month">Month where we are</var>
    //<var name="year">Year where we are</var>
	public function addLine($line,$month,$year)
	{
		$nbLine = $this->getNbLine($month,$year);
		for($i = $nbLine ; $i > $line; $i--)
		{
			$reqUpdateLine = $this->db->prepare('UPDATE t_calender SET calLine = calLine+1 WHERE calLine = :calLine AND calMonth = :calMonth AND calYear = :calYear');
			$reqUpdateLine->execute(array(
				'calLine' => $i,
				'calMonth' => $month,
				'calYear' => $year
				));
			$reqUpdateLine->closeCursor();
		}
	}

	//FUNCTION HEADER
    // <summary>
    // Delete one task
    // </summary>
    //<var name="line">Line where the task to delete is</var>
    //<var name="date">Date of the task</var>
	public function delOneTask($line, $date)
	{
		$reqDelTask = $this->db->prepare('DELETE FROM t_calender WHERE calLine = :calLine AND calDate = :calDate');
		$reqDelTask->execute(array(
			'calLine' => $line,
			'calDate' => $date
			));
		$reqDelTask->closeCursor();
	}

	//FUNCTION HEADER
    // <summary>
    // Delete one line
    // </summary>
    //<var name="line">Line to delete</var>
    //<var name="month">Month where the line is</var>
    //<var name="year">Year where the line is</var>
	public function delLine($line,$month,$year)
	{
		$nbLine = $this->getNbLine($month,$year);
		$this->delTask($line,$month,$year);
		for($i = $line ; $i < $nbLine ; $i++)
		{
			$reqDelLine = $this->db->prepare('UPDATE t_calender SET calLine = calLine-1 WHERE calLine = :calLine AND calMonth = :calMonth AND calYear = :calYear');
			$reqDelLine->execute(array(
				'calLine' => $i,
				'calMonth' => $month,
				'calYear' => $year
				));
			$reqDelLine->closeCursor();
		}
	}

	//FUNCTION HEADER
    // <summary>
    // Verify the password entered by the user and return username
    // </summary>
    //<var name="password">Password entered by user</var>
	public function passwordVerify($password)
	{
		$name = 'error';

		$reqVerifyPassword = $this->db->query('SELECT logName, logPassword FROM t_login');
		while($login = $reqVerifyPassword->fetch())
		{
			if(password_verify($password, $login['logPassword']))
			{
				$name = $login['logName'];
			}
		}

		$reqVerifyPassword->closeCursor();

		return $name;

	}

	//FUNCTION HEADER
    // <summary>
    // Get the current task and write it in the table
    // </summary>
    //<var name="ligne">Line of the task</var>
    //<var name="date">Date of the task</var>
	public function getTask($ligne, $date)
	{
		//Request to get the task of this date if there's one
		$reqGetTask = $this->db->prepare('SELECT taskName FROM t_calender INNER JOIN t_task ON fkTask = idTask WHERE calDate = :calDate AND calLine = :calLine');
		$reqGetTask->execute(array(
			'calDate' => $date,
			'calLine' => $ligne
			));
		$task = $reqGetTask->fetch();

		if(substr($task[0], 2,7) == 'white')
		{
			echo '<th class="'.$task[0].' transparent">'.strtoupper(substr($task[0],0,1)).'</th>';
		}
		else
		{
			echo '<th class="'.$task[0].'">'.strtoupper(substr($task[0],0,1)).'</th>';
		}	

		$reqGetTask->closeCursor();

	}

	public function getTaskMobile($date,$driver)
	{
		//Request to get the task of this date if there's one
		$reqGetTask = $this->db->prepare('SELECT taskName FROM t_calender INNER JOIN t_task ON fkTask = idTask INNER JOIN t_driver ON fkDriver = idDriver WHERE calDate = :calDate AND driName = :driName');
		$reqGetTask->execute(array(
			'calDate' => $date,
			'driName' => $driver
			));

		$task = $reqGetTask->fetch();
		return $task[0];
		$reqGetTask->closeCursor();
	}





	/*
	*CAR PLANNING METHOD
	*/

	//FUNCTION HEADER
    // <summary>
    // Get the list of the cars
    // </summary>
    // <return>Return a tab of the cars</return>
	public function getAllCar()
	{
		$reqCar = $this->db->query('SELECT idCar, carRegistration, carBrand, carSeats FROM t_car WHERE carDeleted = "n"');

		$tabCar = $reqCar->fetchAll();

		$reqCar->closeCursor();

		return $tabCar;
		
	}

	//FUNCTION HEADER
    // <summary>
    // Get the car notes
    // </summary>
    //<var name="idCar">id of the car to check</var>
    /// <return>Return the notes</return>
	public function getNotes($idCar)
	{
		$reqCheckNote = $this->db->prepare('SELECT * FROM t_note INNER JOIN t_driver ON fkDriver = idDriver WHERE fkCar = :idCar');
		$reqCheckNote->execute(array(
			'idCar' => $idCar
			));

		$tabCheckNote = $reqCheckNote->fetchAll();
		$reqCheckNote->closeCursor();

		return $tabCheckNote;
	}

	//FUNCTION HEADER
    // <summary>
    // Get the class of the car
    // </summary>
    //<var name="idCar">id of the car to check</var>
    /// <return>Return the class of the vehicule/return>
	public function getClass($idCar)
	{
		$reqClass = $this->db->prepare('SELECT claName FROM t_car INNER JOIN t_class ON fkClass = idClass WHERE idCar = :idCar');
		$reqClass->execute(array(
			'idCar' => $idCar
			));
		$tabClass = $reqClass->fetchAll();

		$reqClass->closeCursor();

		return $tabClass;
	}


	//FUNCTION HEADER
    // <summary>
    // Get the informations about one car
    // </summary>
    //<var name="idCar">id of the car to check</var>
    /// <return>Return the info of the car</return>
	public function getCarInfo($idCar)
	{
		$reqCar = $this->db->prepare('SELECT * FROM t_car INNER JOIN t_class ON fkClass = idClass WHERE idCar = :idCar');
		$reqCar->execute(array(
			'idCar' => $idCar
			));

		$tabCar = $reqCar->fetchAll();

		$reqCar->closeCursor();

		return $tabCar;
	}

	//FUNCTION HEADER
    // <summary>
    // Get tall the classes
    // </summary>
    /// <return>Return a table with all the classes</return>
	public function getAllClass()
	{
		$reqClass = $this->db->query('SELECT * FROM t_class');
		$tabClass = $reqClass->fetchAll();

		$reqClass->closeCursor();

		return $tabClass;
	}

	//FUNCTION HEADER
    // <summary>
    // Get all the services of a car
    // </summary>
    //<var name="idCar">id of the car to check</var>
    /// <return>Return table with all services</return>
	public function getServices($idCar)
	{
		$reqServices = $this->db->prepare('SELECT * FROM t_service INNER JOIN t_driver ON fkDriver = idDriver WHERE fkCar = :idCar');
		$reqServices->execute(array(
			'idCar' => $idCar
			));
		$tabServices = $reqServices->fetchAll();

		$reqServices->closeCursor();
		return $tabServices;
	}

	//FUNCTION HEADER
    // <summary>
    // Get all the drivers
    // </summary>
    /// <return>Return table with all drivers</return>
	public function getAllDriver()
	{
		$reqDriver = $this->db->query('SELECT * FROM t_driver');
		$tabDriver = $reqDriver->fetchAll();

		$reqDriver->closeCursor();

		return $tabDriver;
	}

	//FUNCTION HEADER
    // <summary>
    // Create a new car in the db
    // </summary>
    //<var name="registration">registration of the car</var>
    //<var name="model">model of the car</var>
    //<var name="brand">brand of the car</var>
    //<var name="year"> year of the car</var>
    //<var name="chassis">chassis of the car</var>
    //<var name="seats">seats of the car</var>
    //<var name="class">class of the car</var>
	public function addCar($registration, $model, $brand, $year, $chassis, $seats, $class)
	{
		//Put empty var to NULL
		if($year == '' OR $year == 0)
		{
			$year = 'NULL';
		}

		if($seats == '' OR $seats == 0)
		{
			$seats = 'NULL';
		}

		$registration = addslashes($registration);
		$model = addslashes($model);
		$brand = addslashes($brand);
		$chassis = addslashes($chassis);

		$reqAddCar = $this->db->prepare('INSERT INTO t_car (`idCar`, `carModel`, `carBrand`, `carRegistration`, `carYear`, `carChassis`, `carSeats`, `fkClass`) VALUES(NULL, "'.$model.'", "'.$brand.'", "'.$registration.'", '.$year.', "'.$chassis.'", '.$seats.', '.$class.')');
		$reqAddCar->execute();

		$reqAddCar->closeCursor();
	}

	//FUNCTION HEADER
    // <summary>
    // Delete a car in the db
    // </summary>
    //<var name="idCar">id of the car to delete</var>
	public function deleteCar($idCar)
	{

		$reqDelCar = $this->db->prepare('UPDATE t_car SET carDeleted = "y" WHERE idCar = :idCar');
		$reqDelCar->execute(array(
			'idCar' => $idCar
			));
		$reqDelCar->closeCursor();

	}

	//FUNCTION HEADER
    // <summary>
    // Modify a car in the db
    // </summary>
    //<var name="idCar">id of the car</var>
    //<var name="registration">registration of the car</var>
    //<var name="model">model of the car</var>
    //<var name="brand">brand of the car</var>
    //<var name="year"> year of the car</var>
    //<var name="chassis">chassis of the car</var>
    //<var name="seats">seats of the car</var>
    //<var name="class">class of the car</var>
	public function modifyCar($idCar, $registration, $model, $brand, $year, $chassis, $seats, $class)
	{
		//Put empty var to NULL
		if($year == '' OR $year == 0)
		{
			$year = 'NULL';
		}

		if($seats == '' OR $seats == 0)
		{
			$seats = 'NULL';
		}

		$registration = addslashes($registration);
		$model = addslashes($model);
		$brand = addslashes($brand);
		$chassis = addslashes($chassis);

		$reqModifyCar = $this->db->prepare('UPDATE t_car SET carRegistration = "'.$registration.'", carModel = "'.$model.'", carBrand = "'.$brand.'", carYear = '.$year.', carChassis = "'.$chassis.'", carSeats = '.$seats.', fkClass= '.$class.' WHERE idCar = '.$idCar);
		echo 'UPDATE t_car SET carRegistration = "'.$registration.'", carModel = "'.$model.'", carBrand = "'.$brand.'", carYear = '.$year.', carChassis = "'.$chassis.'", carSeats = '.$seats.', fkClass= '.$class.' WHERE idCar = '.$idCar;
		$reqModifyCar->execute();
		$reqModifyCar->closeCursor();
	}

	//FUNCTION HEADER
    // <summary>
    // Add a service to a car
    // </summary>
    //<var name="idCar">id of the car</var>
    //<var name="service">service made to the the car</var>
    //<var name="driver">Realisator of the service</var>
	public function addService($idCar, $service, $driver)
	{
		$date = date('Y-m-d');
		$service = addslashes($service);

		$reqAddService = $this->db->prepare('INSERT INTO t_service (`idService`, `serDescription`, `serDate`, `fkDriver`, `fkCar`) VALUES(NULL, "'.$service.'", "'.$date.'", '.$driver.', '.$idCar.')');
		$reqAddService->execute();
		$reqAddService->closeCursor();
	}

	//FUNCTION HEADER
    // <summary>
    // Add a note to a car
    // </summary>
    //<var name="idCar">id of the car</var>
    //<var name="note">Description of the note</var>
    //<var name="driver">Note writer</var>
	public function addNote($idCar, $note, $driver)
	{
		$date = date('Y-m-d');
		$note = addslashes($note);

		$reqAddNote = $this->db->prepare('INSERT INTO t_note (`idNote`, `notDescription`, `notDate`, `fkCar`, `fkDriver`) VALUES(NULL, "'.$note.'", "'.$date.'", '.$idCar.', '.$driver.')');
		$reqAddNote->execute();
		$reqAddNote->closeCursor();

	}

	//FUNCTION HEADER
    // <summary>
    // Mark a note as read
    // </summary>
    //<var name="idNote">id of the note to check</var>
	public function validateNote($idNote)
	{
		$reqValidateNote = $this->db->prepare('UPDATE t_note SET notChecked = "y" WHERE idNote = '.$idNote);
		$reqValidateNote->execute();
		$reqValidateNote->closeCursor();
	}

	//FUNCTION HEADER
    // <summary>
    // Delete a note
    // </summary>
    //<var name="idNote">id of the note to delete</var>
	public function deleteNote($idNote)
	{
		$reqDeleteNote = $this->db->prepare('DELETE FROM t_note WHERE idNote ='.$idNote);
		$reqDeleteNote->execute();
		$reqDeleteNote->closeCursor();
	}

	//FUNCTION HEADER
    // <summary>
    // Update the last date used in the db
    // </summary>
    //<var name="date">New date</var>
	public function updateDateCar($date)
	{
		$reqDate = $this->db->prepare('UPDATE t_dateCar SET datDate = "'.$date.'" WHERE idDate = 1');
		$reqDate->execute();
		$reqDate->closeCursor();
	}

	//FUNCTION HEADER
    // <summary>
    // Get the last date used to print the planning
    // </summary>
    //<return>Return the last date used</return>
	public function getDateCar()
	{
		$reqDate = $this->db->query('SELECT datDate FROM t_dateCar');
		$tabDate = $reqDate->fetchAll();
		$reqDate->closeCursor();
		return $tabDate;
	}

}

?>