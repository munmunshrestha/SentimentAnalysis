<?php

	session_start();
	
	function message() {
		if (isset($_SESSION["message"])) {
			
			
			$output = "<script type='text/javascript'>alert('";
			$output .= htmlentities($_SESSION["message"]);
			$output .= "')</script>";
			
			// clear message after use
			$_SESSION["message"] = null;
			
			return $output;
		}
		else {
			return null;
		}
	}

	function errors() {
		if (isset($_SESSION["errors"])) {
			$errors = $_SESSION["errors"];
			
			// clear message after use
			$_SESSION["errors"] = null;
			
			return $errors;
		}
	}

?>