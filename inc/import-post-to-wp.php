<?php

use function DeliciousBrains\WP_Offload_Media\Aws3\GuzzleHttp\json_encode;

function import_post_to_wp(){

	if (isset($_POST['drupal-to-wp-import'])) {
		$drupal_post_type = $_POST['drupal_post_type'];
		$wp_post_type = $_POST['wp_post_type'];
		$drupal_section = $_POST['drupal_section'];

		if ($drupal_post_type == true && $wp_post_type == true) {
			include ( plugin_dir_path( __FILE__ ).'db.php');

			switch($drupal_post_type){
                case "store_listing":
                    include_once ( plugin_dir_path( __FILE__ ).'/post-types/store-listing.php');
                	break;
                case "story":
                	include_once ( plugin_dir_path( __FILE__ ).'/post-types/story.php');
                	break;
                case "video":
                	include_once ( plugin_dir_path( __FILE__ ).'/post-types/video.php');
                	break;

                default:
                break;
            }
		}
	}
	elseif(isset($_POST['delete-post'])){
		$wp_post_type = $_POST['wp_post_type'];
		$all_post = get_posts( array( 
			'post_type' => 'post',
			'posts_per_page' => -1,
			'post_status'	=> array('publish','draft','sticky')
		) );
		foreach ( $all_post as $post ) {
	        // Delete all products.
	       $deleted_post = wp_delete_post( $post->ID, true); // Set to False if you want to send them to Trash.
	    }

	}
	elseif(isset($_POST['mapping'])){
		$wp_post_type = $_POST['wp_post_type'];
		$old_category = $_POST['old-category'];
		$new_category = $_POST['new-category'];
		$keywords = $_POST['keywords'];

		if ($old_category == true && $new_category == true && $wp_post_type == true) {
			include ( plugin_dir_path( __FILE__ ).'db.php');

			include_once ( plugin_dir_path( __FILE__ ).'/post-types/category-mapping.php');
		}

		// if ($keywords == true){
		// 	include_once ( plugin_dir_path( __FILE__ ).'/post-types/keywords-tag-mapping.php');
		// }
	}
}

import_post_to_wp();