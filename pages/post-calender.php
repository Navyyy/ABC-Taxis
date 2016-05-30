<?php
/*
Author : Yvan Cochet
Date : 26.02.2016
Summary : Page to query date value
*/

session_start();

if(isset($_SESSION['login']) AND $_SESSION['login'] == 'admin')
{

    include('dbAcces.php');
    $function = new dbAcces();

    //Method to connect to the db
    $function->dbConnect();


    //Get var for selected month and year
    $selectedMonth = $_POST['selectedMonthByUser'];
    $selectedYear = $_POST['selectedYearByUser'];
    $nbLine = $function->getNbLine($selectedMonth,$selectedYear);

    for($i = 2 ; $i < $nbLine ; $i++)
    {
        //convert to date selected month and year
        $date = strtotime($selectedYear.'-'.$selectedMonth.'-01');

    	while(date('m',$date) <= $selectedMonth AND date('Y',$date) <= $selectedYear)
    	{
    		//Replace day from 0-6 to 1-7
            $w = str_replace('0','7',date('w',$date));

            //Number of the day
            $d = date('j',$date);


            //If driver = separation
            if(isset($_POST['driver'.$i]) AND $_POST['driver'.$i] == 'Séparation')
            {
                $driver = $_POST['driver'.$i];
                $currentDate = date('Y-m-d',$date);

                $function->addSeparation($i, $driver, $currentDate);
            }
            else if(isset($_POST['driver'.$i]) AND $_POST['driver'.$i] !== '' AND isset($_POST[$i.'-'.$d]) AND $_POST[$i.'-'.$d] == 'empty')
            {
                $line = $i;

                $function->delOneTask($line, date('Y-m-d',$date));
            }
            //If all the selects are full
            else if(isset($_POST['driver'.$i]) AND $_POST['driver'.$i] !== '' AND isset($_POST[$i.'-'.$d]) AND $_POST[$i.'-'.$d] !== '')
            {
                //Set var to use method to add task
                $task = $_POST[$i.'-'.$d];
                $line = $i;
                $driver = $_POST['driver'.$i];
                $currentDate = date('Y-m-d',$date);


                $function->addTask($task, $line, $driver, $currentDate);
            }
            else if($_POST['driver'.$i] == '')
            {
                $line = $i;

                $function->delTask($line,$selectedMonth,$selectedYear);
            }

            //If it's the last sunday of october + 25h else + 24h
            if($selectedMonth == 10 AND $d == 7 AND date('m',$date+7*25*2600)!==10)
            {
                $date = $date + 25*3600;
            }
            else
            {
                $date = $date + 24*3600;
            }
            
    	}
    }


    ?>

    <meta http-equiv="refresh" content="0; URL=calender.php"/>
    <?php
}