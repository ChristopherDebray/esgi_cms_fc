<?php get_header() ?>

<main id="site-content">
	<div class="container">
		<div class="row">
			<div class="col-md-11">
				<h1 class="title title--page title--page--homepage">
					A really professional structure for all your events!
				</h1>
			</div>
		</div>
	</div>
	<div>
		<h2 class="title title--section">About Us</h2>
		<p class="base-text-content">
		Specializing in the creation of exceptional events for private and corporate clients, we design,
		plan and manage every project from conception to execution. 
		</p>
	</div>

	<?php get_template_part('template-parts/who-are-we'); ?>
	<div class="container">
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