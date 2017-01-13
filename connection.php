<?php
function connectDB($db){
		return mysqli_connect("localhost","root","",$db); 
	}

?>