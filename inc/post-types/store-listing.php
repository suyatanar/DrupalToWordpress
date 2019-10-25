<?php
$sql = "SELECT 
    distinct a.nid as id, a.title AS post_title, FROM_UNIXTIME(a.created) AS post_date, 
        FROM_UNIXTIME(a.changed) AS post_modified, 
        IF(a.status = 1, 'publish', 'draft') AS post_status,
    b.body_value AS post_content, b.body_summary AS post_excerpt,
    c.alias as post_name,
    e.fid, e.filename as post_attachment_name, FROM_UNIXTIME(e.timestamp) as post_attachment_date, 
        e.filemime as post_mime_type, (REPLACE(e.uri,'public://', '')) AS post_featured_image,
        e.filesize as post_attachment_filesize,
    f.field_directory_contact_value as acf_store_contact_no, 
    g.field_directory_email_email as acf_store_email, 
    h.field_directory_website_url as acf_store_website, 
    i.field_store_fee_value as acf_store_listing_type, 
    j.field_video_url_video_url as acf_store_video_url, 
    l.name as category_name, 
    m.uid, m.mail as post_author,
    m2.mail as post_attachment_author,
    FROM_UNIXTIME(n.publish_on) AS publish_on
FROM `node` a
LEFT JOIN field_data_body b ON a.nid = b.entity_id
LEFT JOIN url_alias c ON c.source = concat('node/', a.nid) 
LEFT JOIN field_data_field_store_logo d ON a.nid = d.entity_id
LEFT JOIN file_managed e ON d.field_store_logo_fid = e.fid
LEFT JOIN field_data_field_directory_contact f ON a.nid = f.entity_id
LEFT JOIN field_data_field_directory_email g ON a.nid = g.entity_id
LEFT JOIN field_data_field_directory_website h ON a.nid = h.entity_id
LEFT JOIN field_data_field_store_fee i ON a.nid = i.entity_id
LEFT JOIN field_data_field_video_url j ON a.nid = j.entity_id
LEFT JOIN field_data_field_sections k ON a.nid = k.entity_id
LEFT JOIN taxonomy_term_data l ON k.field_sections_tid = l.tid
LEFT JOIN users m ON a.uid = m.uid
LEFT JOIN users m2 ON e.uid = m2.uid
LEFT JOIN scheduler n ON a.nid = n.nid
WHERE a.type = '". $drupal_post_type ."'
ORDER BY a.nid DESC
LIMIT 3
";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $listings = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $listings[$post_id] = $row;

        $ref_post_id            = $row['id'];
        $post_title             = $row['post_title'];
        $post_author            = get_user_id_by_email($row['post_author']);
        $post_content           = $row['post_content'];
        $post_excerpt           = $row['post_excerpt'];
        $post_date              = $row['post_date'];
        $post_modified          = $row['post_modified'];
        $post_type              = $wp_post_type;
        $post_status            = $row['post_status'];
        $post_name              = imp_data_get_post_name($row['post_name']);
        $post_cat               = array(imp_data_get_category_id_by_name($row['category_name']));

        //ACF / Custom Field
        $acf_store_contact_no   = $row['acf_store_contact_no'];
        $acf_store_email        = $row['acf_store_email'];
        $acf_store_website      = $row['acf_store_website'];
        $acf_store_listing_type = is_null($row['acf_store_listing_type']) ? "Free" : $row['acf_store_listing_type'];
        $acf_store_video_url    = $row['acf_store_video_url'];
        
        //Featured Image
        $post_attachment_name    = $row['post_attachment_name'];
        $post_attachment_date    = $row['post_attachment_date'];
        $post_featured_image     = $row['post_featured_image'];
        $post_mime_type          = $row['post_mime_type'];
        $post_attachment_filesize = $row['post_attachment_filesize'];
        $featured_image_url      = $post_featured_image;

        // import post
        $my_post = array(
            'import_id'		=> $ref_post_id,
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

        if ((int) $post_id > 0 ) {
            // Insert the attachment. Particularly featured image
            $attach_id = imp_data_image_attachment_featured($post_id, $featured_image_url, $post_mime_type, $post_attachment_name);
            imp_data_image_attachment_via_s3($attach_id, $featured_image_url, $post_attachment_filesize);

            //Custom Fields
            update_field( "field_5dae973c73d20", $acf_store_contact_no, $post_id );
            update_field( "field_5dae97f673d21", $acf_store_email, $post_id );
            update_field( "field_5dae980473d22", $acf_store_website, $post_id );
            update_field( "field_5dae981973d23", $acf_store_listing_type, $post_id );
            update_field( "field_5daea3e3114d7", $acf_store_video_url, $post_id );
        }
    }

    echo json_encode($listings);
}
