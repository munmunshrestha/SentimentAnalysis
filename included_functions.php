
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

function add_textField(){
	?>
	<script type='text/javascript'>
			  $(document).ready(function(){
				  var maxField = 10; //Input fields increment limitation
				  var addButton = $('.add_button'); //Add button selector
				  var wrapper = $('.field_wrapper'); //Input field wrapper
				  var fieldHTML = "<div><textarea class='form-control' rows='5' id='comment' name='feedback[]'></textarea><a href='javascript:void(0);' class='remove_button pull-right'>Delete</a></div>"; //New input field html 
				  var x = 1; //Initial field counter is 1
				  
				  //Once add button is clicked
				  $(addButton).click(function(){
					  //Check maximum number of input fields
					  if(x < maxField){ 
						  x++; //Increment field counter
						  $(wrapper).append(fieldHTML); //Add field html
					  }
				  });
				  
				  //Once remove button is clicked
				  $(wrapper).on('click', '.remove_button', function(e){
					  e.preventDefault();
					  $(this).parent('div').remove(); //Remove field html
					  x--; //Decrement field counter
				  });
			  });
			  </script>
			  <?php
			}
		
function new_footer()
{
	echo "</body>";
	echo "</html>";
}


?>
