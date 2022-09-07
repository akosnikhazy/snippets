<?php
/*
* for this to work you need a whitelist file called "rights" with list of ip addresses you want to let in.
* You should make the file forbidden in htaccess too. 
*
* this is just a very fast solution for a very small thing internally, but its a one line line of defence that works.
*/
if(!in_array($_SERVER['REMOTE_ADDR'],explode(',',file_get_contents('rights')))) die('nope');
