<?php
/* 
   I used this in a private database with way too many columns and it was much faster this way. 
   At first I just wanted to generate the correct issiis... types parameter value, for bind_param.
   Then I realised I could make it into a function.
   Also, I did not think much about it, it worked in my case, please test it properly.
*/

function fillBindParam($params = array(),&$statement)
{
	$types = '';
	foreach($params as $para)
	{
    
	   switch(gettype($para))
	   {
		  case 'integer':
                       $types .= 'i';
			break;
		  case 'double':
		  case 'float':
			$types .= 'd';
			break;
                  case 'string':
			$types .= 's';
			break;
		  default:
		        $types .= 'b';
	   }
	}

	$statement->bind_param($types,...$params);

}
/*
  Example usage:
  $mysqli		= mysqli_connect(HOST, USER, PASS, DB);

  $sql = 'INSERT INTO `test` (`name`,`number`) VALUES (?,?)';
  
  $stmt = $mysqli -> prepare($sql);
  
  $params = array(
  	$name = 'Joe3',
  	$number = 1
  );
  
  fillBindParam($params,$stmt);
  
  $stmt -> execute();

*/
?>
