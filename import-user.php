<?php
$action  = admin_url( 'admin-post.php');
// Post Type 
echo "<h2> Import Users </h2>";
?>
<div class="user-list">
	<form class="user-form" method="post" action="<?=$action?>">
		<input type="submit" name="import-user" value="Import">
		<input type="submit" name="empty-user" value="Delete Users">
	</form>
</div>