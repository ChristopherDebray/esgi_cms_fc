<!doctype html>
	<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
		<header id="site-header">
			<div class="d-flex justify-content-between relative offset-md-1">
				<div>
					<?= getIcon('esgiDark') ?>
					<span class="absolute left-0"><?= getIcon('dotColored') ?></span>
	
					<?= getIcon('esgiLight') ?>
					<span class="absolute left-0"><?= getIcon('dotColored') ?></span>
				</div>

				<div class="menu-toggle">
					<div class="burger">
						<span></span>
						<span></span>
					</div>
				</div>

				<div class="col-1"></div>
			</div>

			<div class="offset-md-1 main-menu-container">
				<div class="container d-flex justify-content-between relative ">
					<div>	
						<?= getIcon('esgiLight') ?>
						<span class="absolute left-0"><?= getIcon('dotColored') ?></span>
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