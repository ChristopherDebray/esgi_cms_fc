<?php
/*
Template Name: AboutUs
*/

get_header() ?>

<main id="site-content">
	<div class="container">
		<div class="row">
			<div class="col-md-11">
				<h1 class="title title--page"><?php the_title() ?></h1>
			</div>
		</div>
	</div>
	</div>
	<div>
		<?php if (has_post_thumbnail()): ?>
			<div class="d-flex justify-content-end">
				<?php the_post_thumbnail(); ?>
			</div>
		<?php endif; ?>
		<div class="section--md m-auto margin--section">
			<?php the_content() ?>
		</div>
	</div>

	<?php get_template_part('template-parts/who-are-we'); ?>
	<div class="container">
			<div class="page-content">
				<?php get_template_part('template-parts/our-team'); ?>
			</div>
	</div>
</main>

<?php get_footer() ?>