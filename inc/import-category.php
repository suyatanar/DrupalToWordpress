<?php

add_action( 'wp_loaded', 'import_category', 10, 2 );
function import_category(){
	if (isset($_POST['import-cats'])) {
		$taxonomy_id = $_POST['cats'];

		if ($taxonomy_id == true) {
		// import parent categories
			include ( plugin_dir_path( __FILE__ ).'db.php');
			$sql = "SELECT DISTINCT
			d.tid,
			d.name,
			a.alias
			FROM taxonomy_term_data d
			LEFT JOIN url_alias a ON (REPLACE(a.source,'taxonomy/term/','') = d.tid)
			WHERE a.source LIKE 'taxonomy%'
			AND a.alias NOT LIKE 'tags/%'
			AND a.alias NOT LIKE '%/%'
			AND d.vid = '$taxonomy_id'
			ORDER BY d.tid ASC";
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) { 

				while($row = mysqli_fetch_assoc($result)) {
					$cat_id = $row['tid'];
					$cat_name = $row['name'];
					$cat_url = $row['alias'];

			// Create the category
					$my_cat = array('cat_name' => $cat_name, 'category_nicename' => $cat_url);
					$my_cat_id = wp_insert_category($my_cat);
				}

			if ($my_cat_id == true) { // if completly install paraent category
				// import child categories
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
				AND d.vid = '$taxonomy_id'
				ORDER BY d.tid ASC";
				$result = mysqli_query($conn, $sql);

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
						wp_redirect('options-general.php?page=import_data&status=Complete');
					}
					else{
						var_dump($my_cat_id);
					}

				} // end import child category
				else {
					wp_redirect('options-general.php?page=import_data&status=No child category');
				}

			} // end if ($my_cat_id == true)
			else{
				wp_redirect('options-general.php?page=import_data&status=Error to import parent category');
			}

		} // end result
		else {
			wp_redirect('options-general.php?page=import_data&status=0 result');
		}

	} // end ($taxonomy_id == true)	
} 
} // end import_category()

// delete taxonomy
add_action( 'wp_loaded', 'delete_taxonomy', 10, 2);
function delete_taxonomy(){
	if (isset($_POST['empty-cats'])) {
		global $wpdb;
		$delete_terms = $wpdb->query('TRUNCATE TABLE wp_terms');
		$delete_terms_taxonomy = $wpdb->query('TRUNCATE TABLE wp_term_taxonomy');

		if ($delete_terms == true && $delete_terms_taxonomy == true) {
			wp_redirect( 'options-general.php?page=import_data&status=Deleted' );
		}
	}
}