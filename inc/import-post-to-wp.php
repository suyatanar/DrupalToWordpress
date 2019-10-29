<?php

use function DeliciousBrains\WP_Offload_Media\Aws3\GuzzleHttp\json_encode;

function import_post_to_wp(){

	if (isset($_POST['drupal-to-wp-import'])) {
		$drupal_post_type = $_POST['drupal_post_type'];
		$wp_post_type = $_POST['wp_post_type'];

		if ($drupal_post_type == true && $wp_post_type == true) {
			include ( plugin_dir_path( __FILE__ ).'db.php');

			switch($drupal_post_type){
                case "store_listing":
                    include_once ( plugin_dir_path( __FILE__ ).'/post-types/store-listing.php');
                break;
                case "story":
                	include_once ( plugin_dir_path( __FILE__ ).'/post-types/story.php');

                default:
                break;
            }
		}
	}
	elseif(isset($_POST['delete-post'])){
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
}

import_post_to_wp();