<?php

if(!isset($paged)){
	$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
}

if(!isset($base)){
	$big = 999999999; // need an unlikely integer
	$base = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) );
}


$args = [
	'posts_per_page' => 6,
	'post_type' => 'post',
	'paged' => $paged
];

// $posts = get_posts($args);


$the_query = new WP_Query( $args );

?>

<ul class="post-list margin--section">
	<?php 
	if($the_query->have_posts()){

		while($the_query->have_posts()){
			$the_query->the_post(); // itération et déclaration d'une variable $post
			$p = get_post();
		?>
			<li>
				<a href="<?= get_permalink($p->ID) ?>">
					<h3><?= $p->post_title ?></h3>
					<?= $p->post_ ?>
					<?php if ($categories = get_the_category($p->ID)): ?>
						<span class="post-category"><?= $categories[0]->name ?>,</span>
					<?php endif; ?>
					<time><?= wp_date('F j, Y', strtotime($p->post_date))  ?></time>
					<p><?= $p->post_content ?></p>
				</a>
			</li>
		<?php } ?>
	<?php } ?>
</ul>

<nav class="post-list-pagination">
<?php


/*
echo paginate_links( array(
		'base' => $base,
		'format' => '?paged=%#%',
		'current' => max( 1, $paged ),
		'total' => $the_query->max_num_pages,
	) );
	*/
?>
</nav>
