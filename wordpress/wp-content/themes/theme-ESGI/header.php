<!doctype html>
	<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
		<header id="site-header" class="<?php if(is_404()): ?>
			active--404
			<?php endif ?>
			">
			<div class="d-flex justify-content-between relative offset-md-1">
				<div class="relative">
					<?= getIcon('esgiDark') ?>
					<span class="absolute left-0 brand-icon"><?= getIcon('dotColored') ?></span>
				</div>

				<div class="menu-toggle mx-3">
					<div class="burger 
							<?php if(is_404()): ?>
								burger--404
							<?php endif; ?>
					">
						<span></span>
						<span></span>
					</div>
				</div>
			</div>

			<div class="offset-md-1 main-menu-container">
				<div class="d-flex justify-content-between relative p-0 flex-wrap">
					<div class="py-3">
						Or try Search
					</div>
					<?php if (has_nav_menu('primary_menu')){ 

					wp_nav_menu([
						'theme_location' => 'primary_menu',
						'container' => 'nav',
						'container_class' => 'main-menu'
					]);
					}
					?>
				</div>
			</div>
		</header>