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