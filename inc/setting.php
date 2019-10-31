<!-- Plugin Setting -->
<?php 
$localhost = $database = $username = $password = NULL;
include ( plugin_dir_path( __FILE__ ).'db.php');
$website_url = $_SERVER['SERVER_NAME'];

// db information to store at database
add_action( 'wp_loaded', 'connect_db', 10, 2 );
function connect_db(){
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

		wp_redirect('options-general.php?page=import_data&status=Complete');
	}
}

//Enque our js files
add_action( 'admin_enqueue_scripts', 'imp_data_my_enqueue' );
function imp_data_my_enqueue($hook) {
	if(is_admin() && $hook == "settings_page_import_data"){
		wp_enqueue_script( 'ajax-script', plugins_url( '/js/import-post-data.js', PLUGIN_MAIN_FILE ), array('jquery') );
		wp_enqueue_style( 'imp_admin_bootstrap', plugins_url( '/css/bootstrap-3-4-1.css', PLUGIN_MAIN_FILE ));

		// in JavaScript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value
		wp_localize_script( 'ajax-script', 'ajax_object',
			array( 
				'ajax_url' => admin_url( 'admin-ajax.php' )
			) 
		);
	}
}

// Same handler function...
add_action( 'wp_ajax_my_action_import_data', 'my_action_import_data' );
function my_action_import_data() {
	global $wpdb;
	
	include ( plugin_dir_path( PLUGIN_MAIN_FILE ).'inc/import-post-to-wp.php');

	wp_die();
}


// include import category file
include ( plugin_dir_path( __FILE__ ).'import-category.php');

// include import tag file
include ( plugin_dir_path( __FILE__ ).'import-tag.php');

// include post query file
include ( plugin_dir_path( __FILE__ ).'import-post.php');

// include user query file
include ( plugin_dir_path( __FILE__ ).'import-user.php');

function import_data_options_page(){
	$localhost = $database = $username = $password = NULL;
	$action  = admin_url( 'admin-post.php');

	include ( plugin_dir_path( __FILE__ ).'db.php');
	if(isset($_GET['status'])){
		echo "<h1>".$_GET['status']."</h1>";
	}

	?>
	<div class="drupal-form">
		<h3>Drupal Database Connection</h3>
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
	</div>
	
	<?php

	// Data list
	if ($db_config == true) {
		include ( plugin_dir_path( __DIR__ ).'import-taxonomy.php');
		include ( plugin_dir_path( __DIR__ ).'import-post.php');
		include ( plugin_dir_path( __DIR__ ).'import-user.php');


		include ( plugin_dir_path( __DIR__ ).'import-post-to-wp.php');
		include ( plugin_dir_path( __DIR__ ).'mapping.php');

	}
	
} // end import_data_options_page