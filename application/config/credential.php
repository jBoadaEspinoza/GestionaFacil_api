<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$credential_types=array(
	'production'  => array(
		"id"=>"live",
		"types"=>["private"=>"pk","public"=>"sk"]
	),
	'integration' => array(
		"id"=>"test",
		"types"=>["private"=>"pk","public"=>"sk"]
	)
);
