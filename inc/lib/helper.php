<?php
function get_user_id_by_email($email = null){
    $email = trim($email);
    $user = get_user_by( 'email', $email );
    
    if($user !== false){
        return $user->ID;
    }
}

function imp_data_get_category_id_by_name($cat_name = "", $term_type = "category"){
    global  $wpdb;

    $cat_name = trim($cat_name);

    if($cat_name !== ""){
        $cat = get_term_by( 'name', $cat_name, $term_type );
        if ( $cat ) {
            return $cat->term_id;
        }

        /*
        $result = $wpdb->get_row( 
            "SELECT t.term_id FROM $wpdb->terms AS t
            INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id
            WHERE tt.taxonomy = 'category' AND t.name = '". $cat_name ."'"
        );

        if ( null !== $result ) {
            return $result->term_id;
        }
        */
    }

    return 0;
}

function imp_data_get_post_name($post_name = ""){
    $post_name = trim($post_name);

    if( $post_name !== "" ){
        if( stripos("\/", $post_name) !== false ){
            $split_url = explode('/', $post_name);
            $count = sizeof($split_url);
            $post_name = $split_url[$count-1];
        }
    }

    return $post_name;
}

function imp_data_image_attachment_featured($post_id, $featured_image_url, $post_mime_type, $post_attachment_name){
    // Get the path to the upload directory.
    $wp_upload_dir = wp_upload_dir();

    // Prepare an array of post data for the attachment.
    $attachment = array(
        'guid'           => $wp_upload_dir['baseurl'] . '/' . $featured_image_url, 
        'post_mime_type' => $post_mime_type,
        'post_title'     => preg_replace( '/\.[^.]+$/', '', $post_attachment_name ),
        'post_content'   => '',
        'post_status'    => 'inherit'
	);

    $attach_id = wp_insert_attachment( $attachment, $featured_image_url, $post_id );

    // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
    require_once( ABSPATH . 'wp-admin/includes/image.php' );

    // Generate the metadata for the attachment, and update the database record.
    $attach_data = wp_generate_attachment_metadata( $attach_id, $featured_image_url );
    wp_update_attachment_metadata( $attach_id, $attach_data );

    set_post_thumbnail( $post_id, $attach_id );

    return $attach_id;
}

function imp_data_image_attachment_via_s3($attach_id = 0, $file_path = "", $file_size = ""){
    $attach_id = (int) $attach_id;
    if ($attach_id <= 0){
        return false;
    }

    $offload_s3_settings = imp_data_s3_settings();

    if (empty($offload_s3_settings)){
        return false;
    }

    $s3_info = array(
        'provider' => $offload_s3_settings['provider'],
        'region' => $offload_s3_settings['region'],
        'bucket' => $offload_s3_settings['cloudfront'],
        'key' => sprintf("%s%s", $offload_s3_settings['object-prefix'], $file_path)
    );

    $attachment_metadata = array(
        'filesize' => $file_size
    );
    
    update_post_meta( $attach_id, 'amazonS3_info', $s3_info );
    update_post_meta( $attach_id, 'as3cf_filesize_total', $file_size );
    update_post_meta( $attach_id, '_wp_attachment_metadata', $attachment_metadata );
}

function imp_data_pre_data($arr){
    echo '<xmp>';
    print_r($arr);
    echo '</xmp>';
}

function imp_data_s3_settings(){
    return get_option(OFFLOAD_S3_OPTONS);
}
?>