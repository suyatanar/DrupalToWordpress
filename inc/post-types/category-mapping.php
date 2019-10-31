<?php
global $wpdb;
$exists = NULL;
$words = explode(", ", $keywords);
foreach($words as $word){
	$results = $wpdb->get_results( "SELECT * FROM wp_posts as post2
		LEFT JOIN wp_term_relationships rel ON post2.ID = rel.object_id
		LEFT JOIN wp_term_taxonomy tax ON tax.term_taxonomy_id = rel.term_taxonomy_id
		LEFT JOIN wp_terms term ON term.term_id = tax.term_id
		WHERE post2.post_type = '".$wp_post_type."' 
		AND (term.name = '".$word."' OR rel.term_taxonomy_id = ".$old_category." OR post2.post_title LIKE '%".$word."%')");

	foreach ($results as $get_post) {
		$exists = $wpdb->get_var( "SELECT COUNT(DISTINCT object_id) FROM wp_term_relationships WHERE object_id = ".$get_post->ID." AND term_taxonomy_id = ".$new_category);

		if ( $exists == NULL || $exists == 0  ) {
			// switch category name
			$table = $wpdb->prefix.'term_relationships';
			$data = array('object_id' => $get_post->ID, 'term_taxonomy_id' => $new_category , 'term_order' => 0);
			$format = array('%d','%d','%d');
			$wpdb->insert($table,$data,$format);
			$updated = $wpdb->insert_id;

			if ($updated == true) {
				echo json_encode("done");
			}
		}
	}

}
