<?php
/**
 * Plugin Name: Import Data
 * Plugin URI: #
 * Description: Import user data and content data.
 * Version: 1.0
 * Author: Su Yatanar
 * Author URI: #
 */
require_once(ABSPATH . 'wp-config.php'); 
require_once(ABSPATH . 'wp-includes/wp-db.php'); 
require_once(ABSPATH . 'wp-admin/includes/taxonomy.php'); 
include 'inc/setting.php';

function import_data_register_settings() {
	add_option( 'import_data_option_name', 'This is my option value.');
	register_setting( 'myplugin_options_group', 'import_data_option_name', 'myplugin_callback' );
}
add_action( 'admin_init', 'import_data_register_settings' );


function import_data_register_options_page() {
	add_options_page('Page Title', 'Import Data Setting', 'manage_options', 'import_data', 'import_data_options_page');
}
add_action('admin_menu', 'import_data_register_options_page');
?>

<?php 
//function import_data_options_page(){
	?>
	<!-- <div class="import-setting">
		<form action="<?php #echo plugin_dir_url( __FILE__ ); ?>upload.php" method="post" enctype="multipart/form-data">
			Select image to upload:
			<input type="file" name="fileToUpload" id="fileToUpload">
			<input type="submit" value="Upload Image" name="submit">
		</form>
	</div> -->
<?php
//} // end import_data_options_page
?>

<?php
// Import User Data
// function import_user_data(){
// 	$userdata = array(
//     'import_id'             => 22,    //(int) User ID. If supplied, the user will be updated.
//     'user_pass'             => '',   //(string) The plain-text user password.
//     'user_login'            => 'kayceteo',   //(string) The user's login username.
//     'user_nicename'         => 'kayceteo',   //(string) The URL-friendly user name.
//     'user_url'              => 'kayceteo',   //(string) The user URL.
//     'user_email'            => 'kayceteo@sph.com.sg',   //(string) The user email address.
//     'display_name'          => 'kayceteo',   //(string) The user's display name. Default is the user's username.
//     'nickname'              => 'kayceteo',   //(string) The user's nickname. Default is the user's username.
//     'first_name'            => '',   //(string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
//     'last_name'             => '',   //(string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
//     'description'           => '',   //(string) The user's biographical description.
//     'rich_editing'          => '',   //(string|bool) Whether to enable the rich-editor for the user. False if not empty.
//     'syntax_highlighting'   => '',   //(string|bool) Whether to enable the rich code editor for the user. False if not empty.
//     'comment_shortcuts'     => '',   //(string|bool) Whether to enable comment moderation keyboard shortcuts for the user. Default false.
//     'admin_color'           => '',   //(string) Admin color scheme for the user. Default 'fresh'.
//     'use_ssl'               => '',   //(bool) Whether the user should always access the admin over https. Default false.
//     'user_registered'       => '2017-06-08 4:30',   //(string) Date the user registered. Format is 'Y-m-d H:i:s'.
//     'show_admin_bar_front'  => '',   //(string|bool) Whether to display the Admin Bar for the user on the site's front end. Default true.
//     'role'                  => 'editor',   //(string) User's role.
//     'locale'                => '',   //(string) User's locale. Default empty.

// );
// 	$user_id = wp_insert_user( $userdata ) ;

// 	var_dump($user_id);
// 	if(!is_wp_error($user_id)){
// 		echo "the post is valid";
// 	}else{
//   //there was an error in the post insertion, 
// 		echo $user_id->get_error_message();
// 	}
//}

// Import Content Data
// function import_content_data(){
// 	$my_post = array(
// 		'import_id'		=> 336275,
// 		'post_type'		=> 'video',
// 		'post_title'    => 'test test',
// 		'post_content'  => 'This is my post.',
// 		'post_name'		=> 'test',
// 		'post_status'   => 'publish',
// 		'post_author'   => 3
// 	);

// // Insert the post into the database.
// 	$post_id = wp_insert_post($my_post);
// 	var_dump($post_id);
// 	if(!is_wp_error($post_id)){
// 		echo "the post is valid";
// 	}else{
//   //there was an error in the post insertion, 
// 		echo $post_id->get_error_message();
// 	}
// }