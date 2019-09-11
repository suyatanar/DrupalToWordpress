<?php
add_action( 'wp_loaded', 'import_post', 10, 2 );
function import_post(){
	if (isset($_POST['import-post'])) {
		$drupal_post_type = $_POST['drupal_post_type'];
		$wp_post_type = $_POST['wp_post_type'];

$content = '<p style="text-align: left;">Ever notice how some colleagues resemble certain animals in terms of personality and behaviour? It\'s not just about the survival of the fittest  �  doing everything and anything to win&nbsp; that project! – or territorial behaviour.</p>

<p style="text-align: left;">Recognise and handle these different types of behaviour at the office with expert advice from Singapore coach and mentor Denise Pang.</p>

<p style="text-align: left;">Learn to coexist peacefully with your colleagues and improve your teamwork capabilities. You can thrive in your work environment – without resorting to beastly behaviour.</p>

<p style="text-align: center;"><img alt="" class="ci-secondary-image" height="439" src="http://www.herworldplus.com/sites/default/files/imagecache/node-story-main-image/SOL_Jungle_0.jpg" style="vertical-align: middle; margin: 10px;" width="330" /></p>

<p style="text-align: center;"><strong>Stressed out by a clash of personalities at work? Handle your<br />
working relationships better with these tips. Image: Corbis.</strong></p>

<p style="text-align: justify;"><strong>YOUR PEERS</strong></p>

<p style="text-align: justify;"><strong>1. THE SLOW LORIS</strong><br />
<span style="direction: ltr;">She slows everyone else down and</span><span style="direction: ltr;"> has no sense of urgency and often needs help to get the job done on time.</span></p>

<ul>
</ul>

<ul>
	<li><strong style="direction: ltr;">Give her some time.</strong><span style="direction: ltr;"> The loris may be slow because she first needs to grasp the situation.</span></li>
	<li><strong style="direction: ltr;">Provide her the right incentive; </strong><span style="direction: ltr;">this will encourage her to reach her goal. The loris\'s perceptiveness and adaptability are essential to high-performing teams.</span></li>
</ul>

<p style="text-align: justify;"><strong style="direction: ltr;">2. THE VENOMOUS SNAKE</strong><br />
<span style="direction: ltr;">She doesn’t think twice about sabotaging anyone to get into the boss’s good books.</span> <span style="direction: ltr;">She’s toxic, spiteful, and she enjoys spreading malice.</span><br />
<br />
<span style="direction: ltr;">It is hard to work with her because of the mistrust that her behaviour encourages; you feel like you need to constantly watch your back.</span></p>

<ul>
</ul>

<ul>
	<li><strong style="direction: ltr;">Understand her intent</strong><span style="direction: ltr;"> – to get promoted. Her venom is only harmful if you let it get under your skin.</span></li>
	<li><strong style="direction: ltr;">Stay calm.</strong><span style="direction: ltr;"> When handled with respect and understanding, venomous snakes can help with treating life-threatening illnesses.</span></li>
</ul>

<p style="text-align: justify;"><strong style="direction: ltr;">3. THE INQUISITIVE MEERKAT</strong><br />
She\'s <span style="direction: ltr;">intrusive and annoying;</span><span style="direction: ltr;"> she’s always asking you questions about everything. If you look sad, she wants to know why.</span></p>

<ul>
</ul>

<ul>
	<li><span style="direction: ltr;"><strong>Learn to appreciate her concern. </strong>Meerkats are very social. They have strong maternal instincts, often endangering their own lives to provide for the young. Would you find her annoying if you knew she was just watching your back?</span></li>
</ul>

<p><strong style="direction: ltr;">YOUR SUBORDINATES</strong></p>

<p style="text-align: justify;"><strong>4. THE TIMID MOUSE</strong><br />
<span style="direction: ltr;">She is meek and often looks frightened. She tiptoes gingerly into your office to ask a question. If you raise your voice even a little, she cowers in fear and clams up.</span> <span style="direction: ltr;">She lacks confidence and rarely voices her opinions.</span></p>

<ul>
</ul>

<ul>
	<li><strong style="direction: ltr;">Try to be more understanding.</strong><span style="direction: ltr;"> Imagine being preyed on by most species (bosses, friends, family), with little means of defence. With the right handling, mice can be playful, productive and adaptive.</span></li>
</ul>

<p style="text-align: justify;"><strong style="direction: ltr; text-align: justify;">5. THE LAZY SLOTH</strong><br />
<span style="direction: ltr;">She doesn’t do what she’s supposed to do.</span> <span style="direction: ltr;">She misses deadlines, arrives late and leaves early, and wastes time during the day. You don’t want to treat her like a child, but you’ve had it with her work attitude.</span></p>

<ul>
</ul>

<ul>
	<li><strong style="direction: ltr;">Provide her more motivation to work well.</strong><span style="direction: ltr;"> Sloths are sluggish because their main food source (the work assignment) provides minimal nutrition (the motivation), resulting in a slow metabolic rate. Her attitude can improve with more interesting work.</span></li>
</ul>

<p style="text-align: justify;"><strong style="direction: ltr;">6. THE NERVOUS RABBIT</strong><br />
<span style="direction: ltr;">She’s always jittery. When you talk to her, she finds it hard to focus.</span> <span style="direction: ltr;">She panics when her workload gets stressful.</span></p>

<ul>
</ul>

<ul>
	<li><strong style="direction: ltr;">Be patient.</strong><span style="direction: ltr;"> Being picked up is not natural to a rabbit. Your actions can be similar to a bad experience (with a hawk of a boss). With patience, they can realise you mean them no harm.</span></li>
</ul>

<p><strong style="direction: ltr;">YOUR BOSS</strong></p>

<p style="text-align: justify;"><strong>7. THE FIERCE LION</strong><br />
<span style="direction: ltr;">She instills terror with her menacing looks. She doesn’t talk; she growls.</span> <span style="direction: ltr;">You’re afraid to approach her because of her volatile mood.</span></p>

<ul>
</ul>

<ul>
	<li><strong style="direction: ltr;">Be alert and resourceful.</strong><span style="direction: ltr;"> Lions are known to be king of the jungle. Having a lion in the office sharpens your instincts and increases your creativity – helpful skills for when you are a leader yourself.</span></li>
</ul>

<p style="text-align: justify;"><strong style="direction: ltr; text-align: justify;">8. THE HYPERACTIVE HAMSTER</strong><br />
<span style="direction: ltr;">She moves at a frantic pace, and expects the same from you. It\'s never dull when she’s around, but her constant interruptions throw you off.</span></p>

<ul>
</ul>

<ul>
	<li><strong style="direction: ltr;">Be responsive to her hyperactivity, without overworking yourself out.</strong><span style="direction: ltr;"> Hamsters require a lot of activity to keep them occupied. They also stockpile large amounts of food (or in this case, work). Help her burn off excess energy by inviting her to join your yoga class or gym.</span></li>
</ul>

<p style="text-align: justify;"><strong style="direction: ltr; text-align: justify;">9. THE WATCHFUL CAT</strong><br />
<span style="direction: ltr;">She is the silent, observant type.</span> <span style="direction: ltr;">She watches you and knows your every move; she even </span><span style="direction: ltr;">sneaks up on people without warning.</span></p>

<ul>
</ul>

<ul>
	<li><strong style="direction: ltr;">Become more astute and alert to your surroundings.</strong><span style="direction: ltr;"> Cats are perceptive, curious and highly intelligent. Develop your own senses by following her eyes around the room – what does she see that you have not noticed yourself?</span></li>
</ul>

<p><strong style="direction: ltr; text-align: justify;">Denise Pang is a mentor and a ICF (International Coach Federation) professionally certified coach from Terrific Mentors. Terrific Mentors offers mentorship programmes for individuals and groups on business strategies, leadership skills and career-related relationships. Go to <a href="http://www.terrificmentors.com/" target="_blank" title="Terrific Mentors">www.terrificmentors.com</a> for more information on the coaching group.</strong></p>

<p style="text-align: justify;"><em><strong>This article was originally published in Simply Her magazine, December 2010.</strong></em></p>
';

//var_dump($content);

// $save_post = array(
//         'post_author'  => 1,
//         'post_content' => $content,
//         'post_title'   => 'HTML TAG',
//         'post_status'  => 'publish',
// );

/*
 * The CRON doesn't have the capability to save unfiltered HTML content
 * Consequences: It removes the data-original needed for lazy load in my case and some other tags
 * We disable it as it happens for administrator
 */
 // kses_remove_filters();
 // $id = wp_insert_post( $save_post, true );
 /*
 * Then we enable it back on :)
 */
 // kses_init_filters();
					 
	// 				if ( ! is_wp_error( $id ) ) {
	// 				        echo "imported";
	// 				}else{
	// 				 	echo "error";
	// 				}
	// 				die();

		if ($drupal_post_type == true && $wp_post_type == true) {
			include ( plugin_dir_path( __FILE__ ).'db.php');
			$sql = "SELECT DISTINCT n.nid AS id,
			n.uid AS post_author,
			FROM_UNIXTIME(n.created) AS post_date,
			FROM_UNIXTIME(sc.publish_on) AS publish_on,
			CONVERT (bb.body_value USING utf8) AS post_content,
			n.title AS post_title,
			bb.body_summary AS post_excerpt,
			n.type AS post_type,
			IF(n.status = 1, 'publish', 'draft') AS post_status,
			a.alias AS alias,
			IF(f.entity_id IS NULL or f.entity_id = '', 0, f.entity_id) AS post_parent,
			td.name AS category
			FROM node n
			LEFT JOIN url_alias a ON (REPLACE(a.source,'node/','') = n.nid)
			LEFT JOIN field_data_body bb ON bb.entity_id = n.nid
			LEFT JOIN field_data_field_gallery_media f ON f.field_gallery_media_nid = n.nid
			LEFT JOIN scheduler sc ON sc.nid = n.nid
			LEFT JOIN taxonomy_index t ON t.nid = n.nid
			LEFT JOIN taxonomy_term_data td ON td.tid = t.tid
			WHERE IF(n.status = 1, 'publish', 'draft') = 'publish'
			AND a.source LIKE 'node%' AND n.type = 'story' AND n.nid = 7 AND td.vid = 2
			ORDER BY n.nid DESC";

			$result = mysqli_query($conn, $sql);
			//var_dump($result);

			if (mysqli_num_rows($result) > 0) { 
				while($row = mysqli_fetch_assoc($result)) {
					//kses_remove_filters();
					$post_id = $row['id'];
					$post_author = $row['post_author'];
					$post_date = $row['post_date'];
					$post_content = $row['post_content'];
					//$post_content2 = html_entity_decode(str_replace("'", "\'", $post_content));
					//$post_content2 = str_replace(array("'", "\"", "&quot;"), "", htmlspecialchars($row['post_content'] ) );

					// /var_dump(html_entity_decode($post_content2));

					//die();


					$post_title = $row['post_title'];
					$post_excerpt = $row['post_excerpt'];
					$post_type = $wp_post_type;
					$post_status = $row['post_status'];
					$post_name = $row['alias'];
					$split_url = explode('/', $post_name);
					$count = sizeof($split_url);
					$post_name = $split_url[$count-1];
					$category = $row['category'];
					$post_cat = get_cat_ID ('Ideas & Advice');
					$post_parent = $row['post_parent'];	

					//var_dump(htmlspecialchars_decode($row['post_content']));				
					kses_remove_filters();
					// import post
					$my_post = array(
						// 'import_id'		=> $post_id,
						// 'post_title'    => 'My post',
						// 'post_content'  => 'This is my post.',
						// 'post_status'   => 'publish',
						// 'post_author'   => $post_author,
						// 'post_category' => array( $post_cat ),
						//'import_id'		=> $post_id,
						//'import_id'		=> $post_id,
						'post_title'    => $post_title,
						'post_content'  => $row['post_content'],
						'post_type'		=> $post_type,
						'post_status'   => $post_status,
						'post_author'   => $post_author,
						'post_category' => array($post_cat),
						//'post_date'		=> $post_date,
						//'post_excerpt'	=> $post_excerpt,
						//'post_name'		=> $post_name,
						//'post_parent'	=> $post_parent,
					);

					
					$impot_post = wp_insert_post( $my_post, true );
					kses_init_filters();
					 
					if ( ! is_wp_error( $impot_post ) ) {
					        echo "imported";
					}else{
					 	echo "error";
					 	var_dump($impot_post);
					}
					die();

				}

				if ($impot_post == true) {
					//var_dump($impot_post);
					wp_redirect('options-general.php?page=import_data&status=Complete');
				}
				else{
					var_dump($impot_post);
				}
			}
			else{ // no data
				wp_redirect('options-general.php?page=import_data&status=0 result');
			}
		}
	}
}

function wpse_kses_allowed_html( $allowed, $context )
{
	if( 'post' !== $context )
		return $allowed;

	$allowed['img']['data-original'] = true;

	return $allowed;
}

// Remove custom filter
remove_filter( 'wp_kses_allowed_html', 'wpse_kses_allowed_html', 10 );

// delete post data
add_action('wp_loaded', 'delete_post', 10, 2);
function delete_post(){
	if (isset($_POST['empty-post'])) {
		global $wpdb;
		$delete_post = $wpdb->query("TRUNCATE TABLE wp_posts");
		$delete_postmeta = $wpdb->query('TRUNCATE TABLE wp_postmeta');

		if ($delete_post == true && $delete_postmeta == true) {
			wp_redirect( 'options-general.php?page=import_data&status=Deleted' );
		}
	}
}