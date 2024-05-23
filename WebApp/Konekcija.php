

<?php 

$mysqli="";

	$mysqli = new mysqli("localhost","root","","digitalnaprodavnica");

	if ($mysqli->error) 
	{
		echo "Dogodila se greska pri konektovanju na bazu!";
	}
 ?>