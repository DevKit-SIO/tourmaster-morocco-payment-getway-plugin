<?php
	/*
	Plugin Name: Tour Master CMI
	Plugin URI: 
	Description: Tour Master CIM payment system plugin
	Version: 1.0.0
	Author: DevKit SIO
	Author URI: http://www.devkit-sio.com
	License: 
	*/

// TODO: goodlayers_credit_card_payment_gateway_options
	// define necessary variable for the site.
	define('TOURMASTER_CMI_URL', plugins_url('', __FILE__));
	define('TOURMASTER_CMI_LOCAL', dirname(__FILE__));

	include_once(TOURMASTER_CMI_LOCAL . '/include/cmi/cmi.php');