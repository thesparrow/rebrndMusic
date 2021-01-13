<?php

// Get email address
require_once 'config.php';

// Ensures no one loads page and does simple spam check
if(isset($_POST['subscribe_email']) && empty($_POST['subscribe-spam-check'])) {
	
	// Declare our $errors variable we will be using later to store any errors
	$error = '';
	
	// Setup our basic variables

	$input_email = strip_tags($_POST['subscribe_email']);
    
	// We'll check and see if any of the required fields are empty
	if(strlen($input_email) < 2) $error['subscribe_email'] = 'Please enter your email.';

	// Make sure the email is valid
	if(!filter_var($input_email, FILTER_VALIDATE_EMAIL) ) $error['subscribe_email'] = 'Please enter a valid email address.';

	// Set a subject & check if custom subject exist
	$subject = "Subscription for:  $input_email";
	
    $message .= "Please subscribe $input_email to your newsletter.";
	$message .= "\n---\nThis email sent by subscribe form.";

	// Now check to see if there are any errors 
	if(!$error) {

		// No errors, send mail using conditional to ensure it was sent
		if(mail($your_email_address, $subject, $message, "From: $input_email")) {
			echo '<p class="success">You are subscribed!</p>';
		} else {
			echo '<p class="error">There was a problem with your newsletter sign-up!</p>';
		}
		
	} else {
		
		// Errors were found, output all errors to the user
		
		$response .= (isset($error['subscribe_email'])) ? $error['subscribe_email'] . "<br /> \n" : null;
       
		echo "<p class='warning'>$response</p>";
		
	}
	
} else {

	die('Your request was not completed please try again.');

}
