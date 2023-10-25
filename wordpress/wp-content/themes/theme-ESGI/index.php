<?php get_header() ?>

<main id="site-content">
	<div class="container">
		<?php get_template_part('template-parts/identity-card'); // pas besoin de l'extension ?>
		<?php get_template_part('template-parts/our-team'); ?>
		<?php get_template_part('template-parts/our-partners'); ?>
		<?php if(!is_front_page()){ ?>
			<div class="row">
				<div class="col-md-6 offset-md-3"> 
					<div id="list-wrapper">
						<?php get_template_part('template-parts/post-list'); ?>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</main>

<?php get_footer() ?>