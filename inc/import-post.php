<?php
add_action( 'wp_loaded', 'import_post', 10, 2 );
function import_post(){
	if (isset($_POST['import-post'])) {
		$drupal_post_type = $_POST['drupal_post_type'];
		$wp_post_type = $_POST['wp_post_type'];

		if ($drupal_post_type == true && $wp_post_type == true) {
			include ( plugin_dir_path( __FILE__ ).'db.php');
			$sql = "SELECT DISTINCT n.nid AS id,
			n.uid AS post_author,
			FROM_UNIXTIME(n.created) AS post_date,
			FROM_UNIXTIME(sc.publish_on) AS publish_on,
			bb.body_value AS post_content,
			n.title AS post_title,
			bb.body_summary AS post_excerpt,
			n.type AS post_type,
			IF(n.status = 1, 'publish', 'draft') AS post_status,
			a.alias AS alias,
			IF(f.entity_id IS NULL or f.entity_id = '', 0, f.entity_id) AS post_parent
			FROM node n
			LEFT JOIN url_alias a ON (REPLACE(a.source,'node/','') = n.nid)
			LEFT JOIN field_data_body bb ON bb.entity_id = n.nid
			LEFT JOIN field_data_field_gallery_media f ON f.field_gallery_media_nid = n.nid
			LEFT JOIN scheduler sc ON sc.nid = n.nid
			WHERE IF(n.status = 1, 'publish', 'draft') = 'publish'
			AND a.source LIKE 'node%' AND n.type = '".$drupal_post_type."' AND n.nid = 90198
			ORDER BY n.nid DESC";

			$result = mysqli_query($conn, $sql);
			//var_dump($result);

			if (mysqli_num_rows($result) > 0) { 
				while($row = mysqli_fetch_assoc($result)) {
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
					$post_url = $split_url[1];
					$idObj = get_category_by_slug($split_url[0]); 
					$cat_id[] = $idObj->term_id;
					$post_parent = $row['post_parent'];

					// import post
					$my_post = array(
						// 'post_title'    => 'My post',
						// 'post_content'  => 'This is my post.',
						// 'post_status'   => 'publish',
						// 'post_author'   => 1,
						// 'post_category' => array( 1250 ),
						//'import_id'		=> $post_id,
						'post_title'    => $post_title,
						'post_content'  => $post_content,
						'post_type'		=> $post_type,
						'post_status'   => $post_status,
						'post_author'   => 1,
						'post_category' => $cat_id,
						'post_date'		=> $post_date,
						'post_excerpt'	=> $post_excerpt,
						'post_name'		=> $post_name,
						'post_parent'	=> $post_parent,
					);
					$impot_post = wp_insert_post($my_post);
					var_dump($impot_post);
				}

				if ($impot_post == true) {
					//var_dump($impot_post);
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
