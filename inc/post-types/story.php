<?php
$byline = NULL;
$sql = "SELECT DISTINCT nn.nid AS id,
FROM_UNIXTIME(nn.created) AS post_date,
nn.type AS post_type,

nn.title AS post_title,
sub.field_sub_head_value AS post_excerpt,
bld.name AS byline,
CONVERT (bb.body_value USING utf8) AS post_content,
IF(c.vid = 2, c.name, '') AS category,
GROUP_CONCAT(IF(d.vid != 4, NUll, d.name)) AS tag, 

fileURL.fid AS img_id, 
fileURL.filename as post_attachment_name, 
FROM_UNIXTIME(fileURL.timestamp) as post_attachment_date, 
fileURL.filemime as post_mime_type, 
fileURL.filesize as post_attachment_filesize,
(REPLACE(fileURL.uri,'public://', '')) AS post_featured_image,

IF(nn.status = 1, 'publish', 'draft') AS post_status,

u.uid AS user_id, 
u.mail as post_author,
u2.mail as post_attachment_author
FROM
(SELECT * FROM node WHERE type = '".$drupal_post_type."' ORDER BY nid DESC limit 100)
AS nn
LEFT JOIN url_alias a ON a.source = concat('node/', nn.nid)
LEFT JOIN field_data_body bb ON bb.entity_id = nn.nid
LEFT JOIN field_data_field_sub_head sub ON sub.entity_id = nn.nid

LEFT JOIN field_data_field_story_byline byline ON byline.entity_id = nn.nid
LEFT JOIN taxonomy_term_data bld ON bld.tid = byline.field_story_byline_tid

LEFT JOIN field_data_field_gallery_media f ON f.field_gallery_media_nid = nn.nid
LEFT JOIN scheduler sc ON sc.nid = nn.nid
left join field_data_field_sections s on s.entity_id = nn.nid
LEFT JOIN field_data_field_article_tag t on t.entity_id = nn.nid
LEFT JOIN taxonomy_term_data d on d.tid = t.field_article_tag_tid  
LEFT JOIN taxonomy_term_data c ON c.tid = s.field_sections_tid
LEFT JOIN field_data_field_media_main_image mainImg ON mainImg.entity_id = nn.nid
LEFT JOIN field_data_field_img_file imgFile ON imgFile.entity_id = mainImg.field_media_main_image_nid
LEFT JOIN file_managed fileURL ON fileURL.fid = imgFile.field_img_file_fid

LEFT JOIN users u ON u.uid = nn.uid
LEFT JOIN users u2 ON u2.uid = fileURL.uid
GROUP BY nn.nid";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) { 
	while($row = mysqli_fetch_assoc($result)) {
		// post data			
		$post_id = $row['id'];
		$post_author = $row['post_author'];
		$post_date = $row['post_date'];
		$post_content = $row['post_content'];
		$post_title = $row['post_title'];
		$byline = $row['byline'];
		$post_excerpt = $row['post_excerpt'];
		$post_type = $wp_post_type;
		$post_status = $row['post_status'];
		$post_name = $row['alias'];
		$split_url = explode('/', $post_name);
		$count = sizeof($split_url);
		$post_name = $split_url[$count-1];
		$post_cat = $row['category'];
		$post_tag = $row['tag'];
		$post_cat = get_cat_ID ('Ideas & Advice');
		$post_parent = $row['post_parent'];						
		$post_content = html_entity_decode($row['post_content']);
		$post_content = str_replace("'", "\'", $post_content);
		
		// Featured Image
		$post_attachment_name    = $row['post_attachment_name'];
		$post_attachment_date    = $row['post_attachment_date'];
		$post_featured_image     = $row['post_featured_image'];
		$post_mime_type          = $row['post_mime_type'];
		$post_attachment_filesize = $row['post_attachment_filesize'];
		$featured_image_url      = $post_featured_image;


		// import post
		$my_post = array(
			'import_id'		=> $post_id,
			'post_title'    => $post_title,
			'post_content'  => $post_content,
			'post_type'		=> $post_type,
			'post_status'   => $post_status,
			'post_author'   => $post_author,
			'post_category' => $post_cat,
			'tags_input'	=> $post_tag,
			'post_date'		=> $post_date,
			'post_excerpt'	=> $post_excerpt,
			'post_name'		=> $post_name,
			'post_parent'	=> $post_parent						
		);


		$post_id = wp_insert_post( $my_post, true );	

		if ((int) $post_id > 0) {
		// Insert the attachment.
			$attach_id = imp_data_image_attachment_featured($post_id, $featured_image_url, $post_mime_type, $post_attachment_name);
			imp_data_image_attachment_via_s3($attach_id, $featured_image_url, $post_attachment_filesize);

			//Custom Fields
			if ($byline != NULL) {
				update_field( "field_58b3ebba98180", $byline, $post_id );
				update_field( "field_58bd28130a596", 0, $post_id );
			}
            
		}
		else{
			wp_die("Error importing the posts");
		}				

	}

//	echo json_encode($listings);
	
}
else{ // no data
	wp_redirect('options-general.php?page=import_data&status=0 result');
}
