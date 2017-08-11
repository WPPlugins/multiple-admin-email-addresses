<?php
/*
 Plugin Name: Multiple Admin Email Addresses
 Plugin URI: http://???
 Description: Allows setting comma separated list of admin emails in general options.
 Version: 1.0
 Author: Nimrod Cohen
 Author URI: https://www.linkedin.com/in/nimrodcohen/
 License: GPL2
 */

class MultiAdminEmails
{
	public function __construct()
	{
		add_filter('pre_update_option_admin_email',[$this,'sanitize_multiple_emails'],10,2);
	}

	public function sanitize_multiple_emails($value,$oldValue)
	{
		if(!isset($_POST["admin_email"]))
			return $value;

		$result = "";
		$emails = explode(",",$_POST["admin_email"]);
		foreach($emails as $email)
		{
			$email = trim($email);
			$email = sanitize_email( $email );
			if(!is_email($email))
				return $value;
			$result .= $email.",";

		}

		if(strlen($result == ""))
			return $value;
		$result = substr($result,0,-1);

		return $result;
	}
}

$multiAdminEmails = new MultiAdminEmails();
