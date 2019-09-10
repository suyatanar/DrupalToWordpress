<?php
$host = $db_name = $db_username = $db_password = NULL;
global $wpdb;
$table = $wpdb->prefix . "import_data";
$db_config = $wpdb->get_results( "SELECT * FROM $table ORDER BY `t_id` DESC LIMIT 1" );

foreach ($db_config as $db_config) {
	$host = $db_config->host_name;
	$db_name = $db_config->db_name;
	$db_username = $db_config->db_username;
	$db_password = $db_config->db_password;
}

// Create connection
$conn = mysqli_connect($host, $db_username, $db_password, $db_name);

// Check connection
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}