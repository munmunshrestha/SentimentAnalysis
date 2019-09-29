
<?php
function redirect($new_location)
{
	header("Location: " . $new_location);
	exit;
}

function new_header($title)
{
	echo "<!DOCTYPE html>
        <html>
        <head>
        	<title>$title</title>
			<script src='https://www.google.com/recaptcha/api.js'></script>
			<meta charset='utf-8'>
  			<meta name='viewport' content='width=device-width, initial-scale=1'>
  			<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css'>
  			<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
			  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js'></script>   
			  
        </head>
        <body>";
}
	
function new_footer()
{
	echo "</body>";
	echo "</html>";
}


?>
