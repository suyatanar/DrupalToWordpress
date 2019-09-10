<?php
add_action( 'wp_loaded', 'import_user', 10, 2 );
function import_user(){
	if (isset($_POST['import-user'])) {
		include ( plugin_dir_path( __FILE__ ).'db.php');
			// import parent categories
		$sql = "SELECT
		u.uid,
		u.name,
		u.pass,
		u.mail,
		FROM_UNIXTIME(u.created) AS created,
		u.status,
		r.name AS role                
		FROM users u
		LEFT JOIN users_roles ur ON ur.uid = u.uid
		LEFT JOIN role r ON r.rid = ur.rid
		WHERE u.uid > 1
		ORDER BY u.uid";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) { 

			while($row = mysqli_fetch_assoc($result)) {
				$user_id = $row['uid'];
				$name = $row['name'];
				$mail = $row['mail'];
				$created = $row['created'];
				$status = $row['status'];
				$role = $row['role'];					

				// Create the tag
				$userdata = array(
					'import_id'		=> $user_id,
					'user_login'	=> $name,
					'user_nicename'	=> $name,
					'nickname'		=> $name,
					'role'			=> $role,
					'user_email'	=> $mail
				);
				$user_id = wp_insert_user( $userdata ) ;

				if ($user_id == true) { // if completly install tags
					wp_redirect('options-general.php?page=import_data&status=Complete');

				} // end if ($my_cat_id == true)
				else{
					wp_redirect('options-general.php?page=import_data&status=Error to import tags');
				}

			} // end result

		} // end isset($_POST['tags'])
		else {
			wp_redirect('options-general.php?page=import_data&status=0 result');
		}
	}
}

// Delete user data except administrator
add_action( 'wp_loaded', 'delete_user', 10, 2 );
function delete_user(){
	if (isset($_POST['empty-user'])) {
		global $wpdb;
		$delete_user = $wpdb->query("DELETE FROM wp_users WHERE ID > 1");
		$delete_usermeta = $wpdb->query("DELETE FROM wp_usermeta WHERE user_id > 1");

		if ($delete_user == true && $delete_usermeta == true) {
			wp_redirect( 'options-general.php?page=import_data&status=Deleted' );
		}
	}
}