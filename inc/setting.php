<!-- Plugin Setting -->
<?php 
$localhost = $database = $username = $password = NULL;
include ( plugin_dir_path( __FILE__ ).'db.php');

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

	header('Location: http://localhost/d-w/wp-admin/options-general.php?page=import_data&status=Complete');
}

if (isset($_POST['import-cats'])) {
	//var_dump($_POST['taxonomy']);
	$taxonomy_id = $_POST['cats'];

	if ($taxonomy_id == 'parent') {
		$sql = "SELECT DISTINCT
		d.tid,
		d.name,
		a.alias
		FROM taxonomy_term_data d
		LEFT JOIN url_alias a ON (REPLACE(a.source,'taxonomy/term/','') = d.tid)
		WHERE a.source LIKE 'taxonomy%'
		AND a.alias NOT LIKE 'tags/%'
		AND a.alias NOT LIKE '%/%'
		ORDER BY d.tid ASC";
		$result = mysqli_query($conn, $sql);
		//var_dump($result);

		if (mysqli_num_rows($result) > 0) {

			while($row = mysqli_fetch_assoc($result)) {
				$cat_id = $row['tid'];
				$cat_name = $row['name'];
				$cat_url = $row['alias'];

			// Create the category
				$my_cat = array('cat_name' => $cat_name, 'category_nicename' => $cat_url);
				$my_cat_id = wp_insert_category($my_cat);

			}

			if ($my_cat_id == true) {
				header('Location: http://localhost/d-w/wp-admin/options-general.php?page=import_data&status=Complete');
			}
			else{
				var_dump($my_cat_id);
			}

		} 
		else {
			echo "<h3>0 results</h3>";
		}
	}
	elseif ($taxonomy_id == 'child') {
		$sql = "SELECT DISTINCT
		d.tid,
		d.name,
		a.alias
		FROM taxonomy_term_data d
		LEFT JOIN url_alias a ON (REPLACE(a.source,'taxonomy/term/','') = d.tid)
		WHERE a.source LIKE 'taxonomy%'
		AND a.alias NOT LIKE 'tags/%'
		-- AND a.alias NOT LIKE '%/%'
		AND a.alias LIKE '%/%'
		ORDER BY d.tid ASC";
		$result = mysqli_query($conn, $sql);
		//var_dump($result);

		if (mysqli_num_rows($result) > 0) {

			while($row = mysqli_fetch_assoc($result)) {
				$cat_id = $row['tid'];
				$cat_name = $row['name'];
				$cat_url = $row['alias'];
				$split_url = explode('/', $cat_url); // for install sub cat
				$parent_cat = term_exists($split_url[0]); // for install sub cat

			// Create the category
				$my_cat = array('cat_name' => $cat_name, 'category_nicename' => $split_url[1], 'category_parent' => $parent_cat);
				$my_cat_id = wp_insert_category($my_cat);


			}

			if ($my_cat_id == true) {
				header('Location: http://localhost/d-w/wp-admin/options-general.php?page=import_data&status=Complete');
			}
			else{
				var_dump($my_cat_id);
			}

		} 
		else {
			echo "<h3>0 results</h3>";
		}
	}

	
} // end isset($_POST['cats'])

if (isset($_POST['empty-cats'])) {
	global $wpdb;
	$delete_terms = $wpdb->query('TRUNCATE TABLE wp_terms');
	$delete_terms_taxonomy = $wpdb->query('TRUNCATE TABLE wp_term_taxonomy');

	if ($delete_terms == true && $delete_terms_taxonomy == true) {
		header('Location: http://localhost/d-w/wp-admin/options-general.php?page=import_data&status=Complete');
	}
}

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