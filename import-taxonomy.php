<?php
$action  = admin_url( 'admin-post.php');

// Category 
echo "<h2> Category Lists </h2>";
$sql = "SELECT * FROM taxonomy_vocabulary WHERE name='Sections'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	?>
	<div class="taxonomy-list">
		<form method="post" action="<?=$action?>">
			<?php // output data of each row
			while($row = mysqli_fetch_assoc($result)) {
			?>
				<input type="checkbox" name="cats" id="taxonomy" value="<?=$row['vid'];?>">Parent Categories
				&nbsp;&nbsp;&nbsp;&nbsp;
				<?php
			}
			?>
			<input type="submit" name="import-cats" value="Import">
			<input type="submit" name="empty-cats" value="Delete Data">
		</form>
	</div>
	<?php
} 
else {
	echo "<h3>0 results</h3>";
}


// tags
echo "<h2> Tags Lists </h2>";
$sql = "SELECT * FROM taxonomy_vocabulary WHERE name='Tags'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	?>
	<div class="taxonomy-list">
		<form method="post" action="<?=$action?>">
			<?php // output data of each row
			while($row = mysqli_fetch_assoc($result)) {
			?>
				<input type="checkbox" name="tags" id="taxonomy" value="<?=$row['vid'];?>"><?=$row['name'];?>&nbsp;&nbsp;&nbsp;&nbsp;
				<?php
			}
			?>
			<input type="submit" name="import-tags" value="Import">
		</form>
	</div>
	<?php
} 
else {
	echo "<h3>0 results</h3>";
}

?>

