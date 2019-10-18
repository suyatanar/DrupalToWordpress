<?php
add_action( 'wp_loaded', 'import_post', 10, 2 );
function import_post(){
	if (isset($_POST['import-post'])) {
		$drupal_post_type = $_POST['drupal_post_type'];
		$wp_post_type = $_POST['wp_post_type'];

		if ($drupal_post_type == true && $wp_post_type == true) {
			include ( plugin_dir_path( __FILE__ ).'db.php');
			// $sql = "SELECT DISTINCT n.nid AS id,
			// n.uid AS post_author,
			// FROM_UNIXTIME(n.created) AS post_date,
			// FROM_UNIXTIME(sc.publish_on) AS publish_on,
			// CONVERT (bb.body_value USING utf8) AS post_content,
			// n.title AS post_title,
			// bb.body_summary AS post_excerpt,
			// n.type AS post_type,
			// IF(n.status = 1, 'publish', 'draft') AS post_status,
			// a.alias AS alias,
			// IF(f.entity_id IS NULL or f.entity_id = '', 0, f.entity_id) AS post_parent,
			// td.name AS category,
			// (REPLACE(fileURL.uri,'public://','https://media.herworld.com/public/')) AS featuredImage
			// FROM node n
			// LEFT JOIN url_alias a ON (REPLACE(a.source,'node/','') = n.nid)
			// LEFT JOIN field_data_body bb ON bb.entity_id = n.nid
			// LEFT JOIN field_data_field_gallery_media f ON f.field_gallery_media_nid = n.nid
			// LEFT JOIN scheduler sc ON sc.nid = n.nid
			// LEFT JOIN taxonomy_index t ON t.nid = n.nid
			// LEFT JOIN taxonomy_term_data td ON td.tid = t.tid
			// LEFT JOIN field_data_field_media_main_image mainImg ON mainImg.entity_id = n.nid
			// LEFT JOIN field_data_field_img_file imgFile ON imgFile.entity_id = mainImg.field_media_main_image_nid
			// LEFT JOIN file_managed fileURL ON fileURL.fid = imgFile.field_img_file_fid
			// WHERE IF(n.status = 1, 'publish', 'draft') = 'publish'
			// AND a.source LIKE 'node%' AND n.type = 'story' AND n.nid = 324076";

			$sql = "SELECT DISTINCT n.nid AS id,
			n.uid AS post_author,
			FROM_UNIXTIME(n.created) AS post_date,
			FROM_UNIXTIME(sc.publish_on) AS publish_on,
			CONVERT (bb.body_value USING utf8) AS post_content,
			n.title AS post_title,
			bb.body_summary AS post_excerpt,
			n.type AS post_type,
			IF(n.status = 1, 'publish', 'draft') AS post_status,
			
			IF(td.vid = 2, td.name, '') AS category,
			GROUP_CONCAT(IF(td.vid != 4, NUll, td.name)) AS tag,
			a.alias AS alias,
			IF(f.entity_id IS NULL or f.entity_id = '', 0, f.entity_id) AS post_parent,
			(REPLACE(fileURL.uri,'public://','https://media.herworld.com/public/')) AS featuredImage
			FROM node n
			LEFT JOIN url_alias a ON (REPLACE(a.source,'node/','') = n.nid)
			LEFT JOIN field_data_body bb ON bb.entity_id = n.nid
			LEFT JOIN field_data_field_gallery_media f ON f.field_gallery_media_nid = n.nid
			LEFT JOIN scheduler sc ON sc.nid = n.nid

			LEFT JOIN field_data_field_sections sec ON sec.entity_id = n.nid
			LEFT JOIN field_data_field_tags tag ON tag.entity_id = n.nid

			LEFT JOIN taxonomy_term_data td ON 
			td.tid = sec.field_sections_tid
			OR td.tid = tag.field_tags_tid 

			LEFT JOIN field_data_field_media_main_image mainImg ON mainImg.entity_id = n.nid
			LEFT JOIN field_data_field_img_file imgFile ON imgFile.entity_id = mainImg.field_media_main_image_nid
			LEFT JOIN file_managed fileURL ON fileURL.fid = imgFile.field_img_file_fid
			WHERE IF(n.status = 1, 'publish', 'draft') = 'publish'
			AND a.source LIKE 'node%' AND n.type = 'story' AND n.nid = 319501		
			LIMIT 100";

			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) { 
				while($row = mysqli_fetch_assoc($result)) {
					//kses_remove_filters();
					$post_id = $row['id'];
					$post_author = $row['post_author'];
					$post_date = $row['post_date'];
					$post_content = $row['post_content'];
					$post_title = $row['post_title'];
					$post_excerpt = $row['post_excerpt'];
					$post_type = $wp_post_type;
					$post_status = $row['post_status'];
					$post_name = $row['alias'];
					$split_url = explode('/', $post_name);
					$count = sizeof($split_url);
					$post_name = $split_url[$count-1];
					$post_cat = $row['category'];
					$post_tag = $row['tag'];
					$post_cat = get_cat_ID ('Ideas & Advice');
					$post_parent = $row['post_parent'];						
					$post_content = html_entity_decode($row['post_content']);
					$post_content = str_replace("'", "\'", $post_content);
					$featured_image_url = $row['featuredImage'];
					$filetype = wp_check_filetype( basename( $featured_image_url ), null );

					// import post
					$my_post = array(
						'import_id'		=> $post_id,
						'post_title'    => $post_title,
						'post_content'  => $post_content,
						'post_type'		=> $post_type,
						'post_status'   => $post_status,
						'post_author'   => $post_author,
						'post_category' => $post_cat,
						'tags_input'	=> $post_tag,
						'post_date'		=> $post_date,
						'post_excerpt'	=> $post_excerpt,
						'post_name'		=> $post_name,
						'post_parent'	=> $post_parent						
					);


					$impot_post = wp_insert_post( $my_post, true );					

				}

				if ($impot_post == true) {
					// Insert the attachment.
					// Get the path to the upload directory.
					$wp_upload_dir = wp_upload_dir();

					// Prepare an array of post data for the attachment.
					$attachment = array(
						'guid'           => $wp_upload_dir['url'] . '/' . basename( $featured_image_url ), 
						'post_mime_type' => $filetype['type'],
						'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $featured_image_url ) ),
						'post_content'   => '',
						'post_status'    => 'inherit'
					);

					$attach_id = wp_insert_attachment( $attachment, $featured_image_url, $post_id );

					// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
					require_once( ABSPATH . 'wp-admin/includes/image.php' );

					// Generate the metadata for the attachment, and update the database record.
					$attach_data = wp_generate_attachment_metadata( $attach_id, $featured_image_url );
					wp_update_attachment_metadata( $attach_id, $attach_data );

					set_post_thumbnail( $post_id, $attach_id );

					wp_redirect('options-general.php?page=import_data&status=Complete');
				}
				else{
					var_dump($impot_post);
				}
			}
			else{ // no data
				wp_redirect('options-general.php?page=import_data&status=0 result');
			}
		}
	}
}



/**
 * Deletes all posts from "products" custom post type.
 */
function delete_all_post() {
	if (isset($_POST['empty-post'])) {
		$all_post = get_posts( array( 
			'post_type' => 'post',
			'posts_per_page' => -1
		) );	
		//var_dump($all_post);
		foreach ( $all_post as $post ) {
	        // Delete all products.
	       $deleted_post = wp_delete_post( $post->ID, true); // Set to False if you want to send them to Trash.
	    }

	    if ($deleted_post == true) {
	     	wp_redirect('options-general.php?page=import_data&status=Deleted');
	    } 
	}

}
add_action( 'wp_loaded', 'delete_all_post', 10, 2 );