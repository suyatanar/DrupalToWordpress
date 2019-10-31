<?php
$action  = admin_url('admin-post.php');
// Post Type 
echo "<h2> Mapping </h2>";
$post_types = get_post_types('', 'names');

$wcat = get_categories( array(
    'orderby' => 'name',
    'order'   => 'ASC',
    'hide_empty'  => false,
    'hierarchical'       => 1,
    'depth'              => -1,
) );
?>
<div class="post-list">
	<form class="mapping-form" method="post" action="my_action_import_data" id="form-mapping">
		<input type="hidden" name="mapping" value="1">	

		<span>WordPress Post Type</span>
		<select name="wp_post_type">
			
			<?php foreach ($post_types as $post_type) {
				echo "<option value=" . $post_type . ">" . $post_type . "</option>";
			} ?>
		</select>
		<br><br>
		<span>Old Category</span>
		<select name="old-category">			
			<?php foreach ($wcat as $category) {
				echo "<option value=" . $category->term_id . ">" . $category->name . "</option>";
			} ?>
		</select>

		<span>New Category</span>
		<select name="new-category">			
			<?php foreach ($wcat as $category) {
				echo "<option value=" . $category->term_id . ">" . $category->name . "</option>";
			} ?>
		</select>

		<br><br>
		<p>Tags / Keywords</p>
		<textarea name="keywords" id="keywords" rows="5" cols="30"></textarea>
		<br>
		<input type="submit" name="mapping-cat-key" value="Submit" id="mapping-cat-key">

	</form>

	<form class="mapping-form" method="post" action="my_action_import_data" id="form-delete-post-to-wp">
		<input type="hidden" name="delete-post" value="delete">
		<input type="submit" name="delete-all-post" value="Delete Posts" id="delete-post-to-wp">
	</form>

	<!-- <div style="margin-top:25px">
		<div id="import-loader">
			<div class="progress">
				<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
					0%
				</div>
			</div>
		</div>
	</div> -->
</div>