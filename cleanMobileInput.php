<?php
/*
* I use this to clean input for Hungarian mobile phone numbers
* The logic is that I get rid of anything that is not a number
* or + sign, then format it to be valid phone number.
*/ 

function cleanMobile($dirty)
{

	$clean = preg_replace('/[^\d]/', '', $dirty); // only numbers: +36/30_444-5555 => 36304445555
	
	if(strlen($clean) > 11 || strlen($clean) < 8) return false; // if only numbers are more than 11 chars its not a phone number
	
	if(strlen($clean) < 10 && (substr($clean,0,2) == '20' || substr($clean,0,2) == '30' || substr($clean,0,2) == '70' || substr($clean,0,2) == '21' || substr($clean,0,2) == '31' || substr($clean,0,2) == '50' || substr($clean,0,2) == '60')) 
	{//	304445555 => +3630444555
		$clean = '+36'.$clean;
	}
	
	if(substr($clean,0,2) == '06')
	{// 06 => +36
		$clean = '+36'.substr($clean,2);	
	}
	
	if(strlen($clean) == 11 && substr($clean,0,2) == '36')
	{// 36304445555 => +36304445555
		$clean = '+'.$clean;
	}
	
	return $clean;
}

echo cleanMobile("3630/555-6666");
