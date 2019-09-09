<!-- Plugin Setting -->
<?php 
$localhost = $database = $username = $password = NULL;
include ( plugin_dir_path( __FILE__ ).'db.php');
$website_url = $_SERVER['SERVER_NAME'];

if (isset($_POST['save'])) {
	$localhost = $_POST['localhost'];
	$database = $_POST['database'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	global $wpdb;
	$table = $wpdb->prefix.'import_data';
	$data = array('t_id' => '', 'host_name' => $localhost, 'db_name' => $database, 'db_username' => $username, 'db_password' => $password);
	$format = array('%d','%s','%s','%s','%s');
	$wpdb->insert($table,$data,$format);
	$my_id = $wpdb->insert_id;

	header('Location: options-general.php?page=import_data&status=Complete');
}

// include import category file
include ( plugin_dir_path( __FILE__ ).'import-category.php');

function import_data_options_page(){
	$localhost = $database = $username = $password = NULL;
	$action  = admin_url( 'admin-post.php');

	include ( plugin_dir_path( __FILE__ ).'db.php');
	if(isset($_GET['status'])){
		echo "<h1>".$_GET['status']."</h1>";
	}
	?>
	<form action="<?=$action;?>" method="post" class="form-fields" name="dbSetting">
		<div class="field">
			Host Name <input type="text" name="localhost" id="localhost" value="<?=($host != NULL) ? $host : '';?>">
		</div>
		<div class="field">
			Database Name <input type="text" name="database" id="database" value="<?=($db_name != NULL) ? $db_name : '';?>">
		</div>
		<div class="field">
			User Name <input type="text" name="username" id="username" value="<?=($db_username != NULL) ? $db_username : '';;?>">
		</div>
		<div class="field">
			Password <input type="text" name="password" id="password" value="<?=($db_password != NULL) ? $db_password : '';;?>">
		</div>
		<input type="submit" name="save" value="Save">
	</form>
	<?php

	// Taxonomy Lists
	include ( plugin_dir_path( __DIR__ ).'import-taxonomy.php');

} // end import_data_options_page


?>