<?php

// this function formats var_dump with <pre> tags, useful for testing in browser
// also vd($todump,true) kills the process at the dump

function vd($var,$die = false)
{
	echo '<pre>';
	var_dump($var);
	echo '</pre>';	
	
	if($die)die(); // :)
}
