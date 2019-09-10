<?php
$action  = admin_url( 'admin-post.php');

// Post Type 
echo "<h2> Import posts </h2>";
$post_types = get_post_types('', 'names');
$sql = "SELECT type, name FROM node_type";
$result = mysqli_query($conn, $sql);
?>

<div class="post-list">
	<form class="post-form" method="post" action="<?=$action?>">
		<select name="drupal_post_type">
			<?php 
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) { 
					echo "<option value=".$row['type'].">".$row['name']."</option>";			
				} 
			}
			?>
		</select>

		<select name="wp_post_type">
			<?php foreach ($post_types as $post_type) { 
				echo "<option value=".$post_type.">".$post_type."</option>";			
			} ?>
		</select>
		<input type="submit" name="import-post" value="Import">
		<input type="submit" name="empty-post" value="Delete Data">
	</form>
</div>


