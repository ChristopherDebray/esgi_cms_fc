<?php
/*
Template Name: Partners
*/

get_header() ?>

<main id="site-content">
	<div class="container">
		<div class="row">
			<div class="col-md-11">
				<h1 class="title title--page"><?php the_title() ?>.</h1>
			</div>
		</div>
	</div>
	

	<div class="container">
		<?php get_template_part('template-parts/our-partners'); ?>
	</div>
</main>

<?php get_footer() ?>