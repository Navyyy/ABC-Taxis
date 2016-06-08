/*
Author: Yvan Cochet
Date : 09.02.2016
Summary : JS for abctaxis website
*/

function color(select)
{
	//Var with string to test
	var chaineWhite = "white"
	var chaineBlack = "black"
	var chaineRed = "red"
	var chaineYellow = "yellow"
	var chaineGreenFont = "v-white"
	var chaineRedFont = "m-white"
	var chaineBlueFont2 = "c-white"
	var chaineBlueFont3 = "c-black"
	var chaineBlueFont = "f-white"
	var chaineLeft = "left"
	var chaineEmpty = "empty"

	//Var with the className to test
	var className = select.options[select.selectedIndex].className

	//Var for test
	var resultWhite = className.indexOf(chaineWhite)
	var resultBlack = className.indexOf(chaineBlack)
	var resultRed = className.indexOf(chaineRed)
	var resultYellow = className.indexOf(chaineYellow)
	var resultGreenFont = className.indexOf(chaineGreenFont)
	var resultRedFont = className.indexOf(chaineRedFont)
	var resultBlueFont2 = className.indexOf(chaineBlueFont2)
	var resultBlueFont3 = className.indexOf(chaineBlueFont3)
	var resultBlueFont = className.indexOf(chaineBlueFont)
	var resultLeft = className.indexOf(chaineLeft)
	var resultEmpty = className.indexOf(chaineEmpty)

	//If to determined which color to use
	if(resultWhite > 0 || resultEmpty > 0)
	{
		select.style['background-color'] = 'transparent'

		if(resultGreenFont > 0)
		{
			select.style['color'] = '#00FF00'
		}
		else if(resultRedFont > 0)
		{
			select.style['color'] = 'red'
		}
		else if(resultBlueFont > 0 || resultBlueFont2 > 0)
		{
			select.style['color'] = 'blue'
		}
		else
		{
			select.style['color'] = 'black'
		}
	}
	else if(resultBlack > 0)
	{
		if(resultBlueFont3 > 0)
		{
			select.style['background-color'] = 'black'
			select.style['color'] = '#00A0E0'
		}
		else
		{
			select.style['background-color'] = '#333'
			select.style['color'] = 'white'
		}
	}
	else if(resultRed > 0)
	{
		select.style['background-color'] = 'red'
		select.style['color'] = 'black'
	}
	else if(resultYellow > 0)
	{
		select.style['background-color'] = 'yellow'
		select.style['color'] = 'black'
	}
	else if(resultGreenFont > 0)
	{
		select.style['background-color'] = 'white'
		select.style['color'] = '#00FF00'
	}
	else if(resultRedFont > 0)
	{
		select.style['background-color'] = 'white'
		select.style['color'] = 'red'
	}
	else if(resultBlueFont > 0 || resultBlueFont2 > 0)
	{
		select.style['background-color'] = 'white'
		select.style['color'] = 'blue'
	}
	else if(resultLeft > 0)
	{
		select.style['background-color'] = 'purple'
	}
}

function colorCar(select)
{
	//If the color is white, select color = transparent. Else select color = selected option color
	if(select.options[select.selectedIndex].style['background-color'] == 'white')
	{
		select.style['background-color'] = 'transparent'
	}
	else
	{
		select.style['background-color'] = select.options[select.selectedIndex].style['background-color']
	}

}

//Function to confirm the suppression of a member
function checkDelete()
{
    return confirm('Voulez-vous vraiment supprimer cet élément ?')
}


function addStatu(select)
{
	var xmlhttp

	if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
        }
    };

    var date = document.getElementById("selectedDate").value
    var selectName = select.name
    var value = select.options[select.selectedIndex].value

    xmlhttp.open("GET", "add-statu-calender.php?date=" + date + "&selectName=" + selectName + "&value=" + value, true)
    xmlhttp.send()
}

function getDriverStat()
{
	var xmlhttp

	if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && (xmlhttp.status == 200 || xmlhttp.status == 0)) {
            printDriverStat(xmlhttp.responseText);
        }
    };

    var idDriver = document.getElementById("select-driver").value
    var year = document.getElementById("select-year").value

    xmlhttp.open("GET", "tab-driver-stat.php?idDriver=" + idDriver + "&year=" + year, true)
    xmlhttp.send()
}

function printDriverStat(table)
{
	//Convert string to table
	var tableStat = $.parseJSON(table)

	//Convert data to int and put it in var
	var aYellow = parseInt(tableStat["a-yellow"])
	var aBlack = parseInt(tableStat["a-black"])
	var aRed = parseInt(tableStat["a-red"])
	var bWhite = parseInt(tableStat["b-white"])
	var bBlack = parseInt(tableStat["b-black"])
	var lWhite = parseInt(tableStat["l-white"])
	var vWhite = parseInt(tableStat["v-white"])
	var mWhite = parseInt(tableStat["m-white"])
	var fWhite = parseInt(tableStat["f-white"])
	var left = parseInt(tableStat["left"])
	var cWhite = parseInt(tableStat["c-white"])
	var cBlack = parseInt(tableStat["c-black"])


	google.charts.load("current", {packages:["corechart"]});

	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
		    ['Task', 'Nb tasks in a year'],
		    ['Voiture A ouverture',aYellow],
		    ['Voiture A fermeture',aBlack],
		    ['Voiture A', aRed],
		    ['Voiture B', bWhite],
		    ['Voiture B fermeture', bBlack],
		    ['Limousine', lWhite],
		    ['Vacances', vWhite],
		    ['Maladie', mWhite],
		    ['Formation', fWhite],
		    ['Congé', left],
		    ['Call despatch jour', cWhite],
		    ['Call despatch nuit', cBlack]
		]);

		var options = {
		    title: 'Résumé de ... en ...',
		    pieHole: 0.4,
		    };

		var chart = new google.visualization.PieChart(document.getElementById('driverStat'));
		chart.draw(data, options);
		}

}


/*Global var
var matchRegistration = false
var matchClass = false


//Function that check registration input
function checkRegistration(registration)
{
	//Check registration
	if(registration.value !== '')
	{
		matchRegistration = true
	}
	else
	{
		matchRegistration = false
	}
}

//Function that check class list
function checkClass(classe)
{
	if(classe.vlaue !== '')
	{
		matchClass = true
	}
	else
	{
		matchClass = false
	}
}

function checkAddCar()
{
	if(matchRegistration == false || matchClass == false)
	{
		return false
		alert("Veuillez remplir au moins les champs Immatriculation et Classe !")
	}
	else
	{
		return true
	}

}*/