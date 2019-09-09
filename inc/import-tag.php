<?php

if (isset($_POST['import-tags'])) {

	$taxonomy_id = $_POST['tags'];

	if ($taxonomy_id == true) {
		// import parent categories
		$sql = "SELECT DISTINCT
		d.tid,
		d.name,
		a.alias
		FROM taxonomy_term_data d
		LEFT JOIN url_alias a ON (REPLACE(a.source,'taxonomy/term/','') = d.tid)
		WHERE a.source LIKE 'taxonomy%'
		AND a.alias LIKE 'tags/%'
		AND d.vid = '$taxonomy_id'
		ORDER BY d.tid ASC";
		$result = mysqli_query($conn, $sql);
		//var_dump($result);

		if (mysqli_num_rows($result) > 0) { 

			while($row = mysqli_fetch_assoc($result)) {
				$cat_id = $row['tid'];
				$tag_name = $row['name'];
				$tag_url = $row['alias'];
				$split_url = explode('/', $tag_url); 
				$tag_url = $split_url[1]; // get tag url from drupal tag/tag_url			

			// Create the tag
				$insert_tag = wp_insert_term(
					$tag_name, // insert tag name
					'post_tag', 
					array(
						'description'=> '',
						'slug' => $tag_url // tag url
					)
				);
			}

			if ($insert_tag == true) { // if completly install tags

				header('Location: options-general.php?page=import_data&status=Complete');

			} // end if ($my_cat_id == true)
			else{
				header('Location: options-general.php?page=import_data&status=Error to import tags');
			}

		} // end result
		else {
			header('Location: options-general.php?page=import_data&status=0 result');
		}
	} // end ($taxonomy_id == true)
	
} // end isset($_POST['tags'])

if (isset($_POST['empty-tags'])) {
	global $wpdb;
	$delete_tags = $wpdb->query(
		"DELETE t, tr, tt
		FROM wp_terms t  
		INNER JOIN wp_term_taxonomy tt ON t.term_id = tt.term_id
		INNER JOIN wp_term_relationships tr ON tt.term_taxonomy_id = tr.term_taxonomy_id
		WHERE tt.taxonomy = 'post_tag'");
	
	if ($delete_tags == true) {
		header('Location: options-general.php?page=import_data&status=Deleted');
	}
}