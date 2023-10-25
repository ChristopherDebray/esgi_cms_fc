<?php
/*
Template Name: AboutUs
*/

get_header() ?>

<main id="site-content">
	<div class="container single-page">
		<div class="row">
			<div class="col-md-6 offset-md-3">
        <h1 class="page-title"><?php the_title() ?></h1>
        <div class="page-content">
					<?php the_content() ?>
					<?php get_template_part('template-parts/who-are-we'); ?>
          <?php get_template_part('template-parts/our-team'); ?>
        </div>
			</div>
		</div>
	</div>
</main>

<?php get_footer() ?>