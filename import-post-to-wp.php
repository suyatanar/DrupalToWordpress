<?php
$action  = admin_url('admin-post.php');
// Post Type 
echo "<h2> Import posts </h2>";
$post_types = get_post_types('', 'names');
$sql = "SELECT type, name FROM node_type";
$result = mysqli_query($conn, $sql);
?>
<div class="post-list">
	<form class="post-form" method="post" action="my_action_import_data" id="form-import-post-to-wp">
		<input type="hidden" name="drupal-to-wp-import" value="1">	

		<select name="drupal_post_type">
			<?php
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<option value=" . $row['type'] . ">" . $row['name'] . "</option>";
				}
			}
			?>
		</select>

		<select name="wp_post_type">
			<?php foreach ($post_types as $post_type) {
				echo "<option value=" . $post_type . ">" . $post_type . "</option>";
			} ?>
		</select>
		<input type="submit" name="import-post-to-wp" value="Import" id="import-post-to-wp">

	</form>

	<form class="post-form" method="post" action="my_action_import_data" id="form-delete-post-to-wp">
		<input type="hidden" name="delete-post" value="delete">
		<input type="submit" name="delete-all-post" value="Delete Posts" id="delete-post-to-wp">
	</form>

	<div style="margin-top:25px">
		<div id="import-loader">
			<div class="progress">
				<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
					0%
				</div>
			</div>
		</div>
	</div>
</div>