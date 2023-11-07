<?php
// Déclaration des emplacements de menu

add_action('init', 'esgi_init');
function esgi_init(){
	register_nav_menus([
				'primary_menu' => __('Menu principal', 'ESGI') // chaine traduite dans le domaine 'ESGI'
			]);
}

// Ajout des supports de theme
add_action('after_setup_theme','esgi_after_setup_theme');
function esgi_after_setup_theme(){
	add_theme_support('custom-logo');
	add_theme_support('post-thumbnails');
	add_theme_support('widgets');
}

// chargement de la feuille de style et du js

add_action('wp_enqueue_scripts', 'esgi_enqueue_assets');
function esgi_enqueue_assets(){
	wp_enqueue_style('main', get_stylesheet_uri());
	wp_enqueue_script('myJquery', get_template_directory_uri() . '/assets/js/vendor/jquery-3.7.0.min.js');
	wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/main.js');

	$big = 999999999; // need an unlikely integer
	$base = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) );
	
	// Injection d'une variable dans le js
	$variables = [
		'ajaxURL' => admin_url('admin-ajax.php'),
		'baseURL' => $base
	];
	wp_localize_script('main', 'esgi', $variables);

}

// Enregistrement des zones de widgets
add_action('widgets_init', 'esgi_widgets_init');
function esgi_widgets_init(){
	register_sidebar( array(
		'name'          => __( 'Zone de widget de la barre latérale', 'ESGI' ),
		'id'            => 'sidebar_widget_zone',
		'description'   => __( 'Bla bla...', 'ESGI' ),
		'before_widget' => '',
		'after_widget' => ''
	) );
}

// Déclaration des routes AJAX
add_action( 'wp_ajax_load_posts', 'esgi_ajax_load_posts' );
add_action( 'wp_ajax_nopriv_load_posts', 'esgi_ajax_load_posts' );

function esgi_ajax_load_posts(){
	$paged = $_POST['page'];
	$base = $_POST['base'];
	// ouverture du cache php
	ob_start();
	// ecriture du contenu
	include('template-parts/post-list.php');
	// Fermeture du cache et renvoi de son contenu
	echo ob_get_clean();
	die();
}




// CUSTOMIZER DE THEME
add_action('customize_register', 'esgi_customize_register');
function esgi_customize_register($wp_customize) {
	// ajouter une section ESGI
	$wp_customize->add_section( 'esgi', array(
	  'title' => __( 'Paramètres ESGI', 'ESGI' ),
	  'description' => __( 'Faites-vous plaisir !!', 'ESGI' ),
	  //'panel' => '', // Not typically needed.
	  'priority' => 1,
	  'capability' => 'edit_theme_options',
	  //'theme_supports' => '', // Rarely needed.
	) );

	// Ajouter des settings
	$wp_customize->add_setting( 'is_dark', array(
	  'type' => 'theme_mod', // or 'option'
	  'transport' => 'refresh', // or postMessage
	  'sanitize_callback' => 'esgi_sanitize_bool',
	) );

	$wp_customize->add_setting( 'has_sidebar', array(
	  'type' => 'theme_mod', // or 'option'
	  'transport' => 'refresh', // or postMessage
	  'sanitize_callback' => 'esgi_sanitize_bool',
	) );

	$wp_customize->add_setting( 'main-color', array(
	  'type' => 'theme_mod', // or 'option'
	  'transport' => 'refresh', // or postMessage
	  'sanitize_callback' => 'sanitize_hex_color',
	) );

	// Ajouter des controls
	$wp_customize->add_control( 'is_dark', array(
	  'type' => 'checkbox',
	  'priority' => 1, // Within the section.
	  'section' => 'esgi', // Required, core or custom.
	  'label' => __( 'Dark theme', 'ESGI' ),
	  'description' => __( 'Black is beautiful :)' ),
	  //'active_callback' => 'is_front_page',
	) );

	$wp_customize->add_control( 'has_sidebar', array(
	  'type' => 'checkbox',
	  'priority' => 2, // Within the section.
	  'section' => 'esgi', // Required, core or custom.
	  'label' => __( 'Afficher une barre latérale', 'ESGI' ),
	  'description' => __( 'Toujours utile pour afficher des widgets...' ),
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main-color', array(
		  'label' => __( 'Couleur principale', 'ESGI' ),
		  'section' => 'esgi',
		) )
	);

	// PARTNERS

	$wp_customize->add_section('partner_section', array(
    'title' => __('Our partners', 'ESGI'),
    'priority' => 31,
	));

	for ($i = 1; $i <= 6; $i++) {
		$wp_customize->add_setting('partner_' . $i . '_image', array(
			'default' => '',
			'sanitize_callback' => 'esc_url_raw',
		));

		$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'partner_' . $i . '_image', array(
			'label' => __('Partner ' . $i . ' Image', 'ESGI'),
			'section' => 'partner_section',
			'settings' => 'partner_' . $i . '_image',
		)));
	}

	// MEMBERS

	$wp_customize->add_section('member_section', array(
    'title' => __('Members', 'ESGI'),
    'priority' => 30,
	));

// Loop to create up to four member fields.
for ($i = 1; $i <= 4; $i++) {
    $wp_customize->add_setting('member_' . $i . '_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'member_' . $i . '_image', array(
        'label' => __('Member ' . $i . ' Image', 'ESGI'),
        'section' => 'member_section',
        'settings' => 'member_' . $i . '_image',
    )));

    $wp_customize->add_setting('member_' . $i . '_title', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('member_' . $i . '_title', array(
        'label' => __('Member ' . $i . ' Title', 'ESGI'),
        'section' => 'member_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('member_' . $i . '_phone', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('member_' . $i . '_phone', array(
        'label' => __('Member ' . $i . ' Phone Number', 'ESGI'),
        'section' => 'member_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('member_' . $i . '_email', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('member_' . $i . '_email', array(
        'label' => __('Member ' . $i . ' Email', 'ESGI'),
        'section' => 'member_section',
        'type' => 'email',
    ));
	}

	// WHO ARE WE

	$wp_customize->add_section('who_section', array(
    'title' => __('Who are we', 'ESGI'),
    'priority' => 30,
	));

	$wp_customize->add_setting('who_section_main_picture', [
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	]);

	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'who_section_main_picture', array(
		'label' => __('Who section picture'),
		'section' => 'who_section',
		'settings' => 'who_section_main_picture',
	)));
}


function esgi_sanitize_bool($value){
	return is_bool($value) ? $value : false;
}


// Hack des classes du body
add_filter('body_class', 'esgi_body_class', 100, 1);
function esgi_body_class($classes){
	if(get_theme_mod('is_dark', false)){
		$classes[] = 'dark';
	}
	return $classes;
}


add_action('wp_head', 'esgi_wp_head', 100);
function esgi_wp_head(){
	$mainColor = get_theme_mod('main-color', '#3F51B5');
	echo '<style>
	:root{
		--main-color : ' . $mainColor . '
	}
	</style>';
}



function getIcon($icon){

	$twitter = '<svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M18 1.6875C17.325 2.025 16.65 2.1375 15.8625 2.25C16.65 1.8 17.2125 1.125 17.4375 0.225C16.7625 0.675 15.975 0.9 15.075 1.125C14.4 0.45 13.3875 0 12.375 0C10.4625 0 8.775 1.6875 8.775 3.7125C8.775 4.05 8.775 4.275 8.8875 4.5C5.85 4.3875 3.0375 2.925 1.2375 0.675C0.9 1.2375 0.7875 1.8 0.7875 2.5875C0.7875 3.825 1.4625 4.95 2.475 5.625C1.9125 5.625 1.35 5.4 0.7875 5.175C0.7875 6.975 2.025 8.4375 3.7125 8.775C3.375 8.8875 3.0375 8.8875 2.7 8.8875C2.475 8.8875 2.25 8.8875 2.025 8.775C2.475 10.2375 3.825 11.3625 5.5125 11.3625C4.275 12.375 2.7 12.9375 0.9 12.9375C0.5625 12.9375 0.3375 12.9375 0 12.9375C1.6875 13.95 3.6 14.625 5.625 14.625C12.375 14.625 16.0875 9 16.0875 4.1625C16.0875 4.05 16.0875 3.825 16.0875 3.7125C16.875 3.15 17.55 2.475 18 1.6875Z" fill="#1A1A1A"/>
</svg>';	

	$facebook = '<svg width="12" height="18" viewBox="0 0 12 18" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M3.4008 18L3.375 10.125H0V6.75H3.375V4.5C3.375 1.4634 5.25545 0 7.9643 0C9.26187 0 10.3771 0.0966038 10.7021 0.139781V3.3132L8.82333 3.31406C7.35011 3.31406 7.06485 4.01411 7.06485 5.04139V6.75H11.25L10.125 10.125H7.06484V18H3.4008Z" fill="#1A1A1A"/>
</svg>';
	
	$google = '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
<path id="Vector" d="M9.12143 7.71429V10.8H14.3929C14.1357 12.0857 12.85 14.6571 9.25 14.6571C6.16429 14.6571 3.72143 12.0857 3.72143 9C3.72143 5.91429 6.29286 3.34286 9.25 3.34286C11.05 3.34286 12.2071 4.11429 12.85 4.75714L15.2929 2.44286C13.75 0.9 11.6929 0 9.25 0C4.23572 0 0.25 3.98571 0.25 9C0.25 14.0143 4.23572 18 9.25 18C14.3929 18 17.8643 14.4 17.8643 9.25714C17.8643 8.61428 17.8643 8.22857 17.7357 7.71429H9.12143Z" fill="#1A1A1A"/>
</svg>';

	$linkedin = '<svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M17.9698 0H1.64687C1.19966 0 0.864258 0.335404 0.864258 0.782609V17.2174C0.864258 17.5528 1.19966 17.8882 1.64687 17.8882H18.0816C18.5289 17.8882 18.8643 17.5528 18.8643 17.1056V0.782609C18.7525 0.335404 18.4171 0 17.9698 0ZM3.54749 15.205V6.70807H6.23072V15.205H3.54749ZM4.8891 5.59006C3.99469 5.59006 3.32389 4.80745 3.32389 4.02484C3.32389 3.13043 3.99469 2.45963 4.8891 2.45963C5.78351 2.45963 6.45432 3.13043 6.45432 4.02484C6.34252 4.80745 5.67171 5.59006 4.8891 5.59006ZM16.0692 15.205H13.386V11.0683C13.386 10.0621 13.386 8.8323 12.0444 8.8323C10.7028 8.8323 10.4792 9.95031 10.4792 11.0683V15.3168H7.79593V6.70807H10.3674V7.82609C10.7028 7.15528 11.5972 6.48447 12.827 6.48447C15.5102 6.48447 15.9574 8.27329 15.9574 10.5093V15.205H16.0692Z" fill="#1A1A1A"/>
</svg>';

	$esgi = '<svg width="196" height="61" viewBox="0 0 196 61" fill="none" xmlns="http://www.w3.org/2000/svg">
	<path d="M40.4105 59.3333H0.412109V0.983683H40.4105V12.6617H12.0902V24.3398H31.2552V36.0179H12.0902V47.6552H40.4105V59.3333Z" fill="white"/>
	<path d="M54.5202 18.4804C54.5202 16.0662 54.9813 13.8011 55.9037 11.6852C56.826 9.5693 58.0738 7.72468 59.6471 6.15133C61.2476 4.55085 63.1058 3.28946 65.2217 2.36715C67.3376 1.44484 69.6027 0.983683 72.0169 0.983683H98.791V12.6617H72.0169C71.2031 12.6617 70.4436 12.8109 69.7383 13.1093C69.033 13.4077 68.4091 13.8282 67.8665 14.3707C67.3511 14.8861 66.9442 15.4965 66.6458 16.2018C66.3475 16.9071 66.1983 17.6666 66.1983 18.4804C66.1983 19.2942 66.3475 20.0673 66.6458 20.7998C66.9442 21.5051 67.3511 22.129 67.8665 22.6715C68.4091 23.1869 69.033 23.5938 69.7383 23.8922C70.4436 24.1906 71.2031 24.3398 72.0169 24.3398H83.695C86.1093 24.3398 88.3744 24.801 90.4902 25.7233C92.6333 26.6185 94.4914 27.8663 96.0648 29.4668C97.6653 31.0401 98.9131 32.8983 99.8083 35.0413C100.731 37.1572 101.192 39.4223 101.192 41.8366C101.192 44.2508 100.731 46.5159 99.8083 48.6318C98.9131 50.7477 97.6653 52.6059 96.0648 54.2063C94.4914 55.7797 92.6333 57.0275 90.4902 57.9498C88.3744 58.8722 86.1093 59.3333 83.695 59.3333H57.7754V47.6552H83.695C84.5088 47.6552 85.2684 47.506 85.9736 47.2076C86.6789 46.9093 87.2893 46.5024 87.8047 45.9869C88.3472 45.4444 88.7677 44.8205 89.0661 44.1152C89.3645 43.4099 89.5137 42.6504 89.5137 41.8366C89.5137 41.0228 89.3645 40.2632 89.0661 39.5579C88.7677 38.8526 88.3472 38.2423 87.8047 37.7269C87.2893 37.1843 86.6789 36.7639 85.9736 36.4655C85.2684 36.1671 84.5088 36.0179 83.695 36.0179H72.0169C69.6027 36.0179 67.3376 35.5567 65.2217 34.6344C63.1058 33.7121 61.2476 32.4643 59.6471 30.8909C58.0738 29.2904 56.826 27.4323 55.9037 25.3164C54.9813 23.1734 54.5202 20.8947 54.5202 18.4804Z" fill="white"/>
	<path d="M165.31 53.4332C162.597 55.739 159.572 57.5158 156.236 58.7636C152.899 59.9843 149.427 60.5947 145.819 60.5947C143.052 60.5947 140.38 60.2285 137.803 59.4961C135.253 58.7908 132.866 57.7871 130.642 56.485C128.417 55.1558 126.383 53.5824 124.538 51.7649C122.693 49.9203 121.12 47.8858 119.818 45.6614C118.516 43.4099 117.499 40.9956 116.766 38.4186C116.061 35.8415 115.708 33.1696 115.708 30.4026C115.708 27.6357 116.061 24.9773 116.766 22.4274C117.499 19.8775 118.516 17.4903 119.818 15.2659C121.12 13.0144 122.693 10.9799 124.538 9.1624C126.383 7.31778 128.417 5.74443 130.642 4.44234C132.866 3.14026 135.253 2.13657 137.803 1.43127C140.38 0.698853 143.052 0.332642 145.819 0.332642C149.427 0.332642 152.899 0.956557 156.236 2.20439C159.572 3.42509 162.597 5.18833 165.31 7.4941L159.206 17.6666C157.443 15.8763 155.408 14.4792 153.103 13.4755C150.797 12.4447 148.369 11.9293 145.819 11.9293C143.269 11.9293 140.868 12.4176 138.617 13.3942C136.393 14.3707 134.439 15.6999 132.758 17.3818C131.076 19.0365 129.746 20.9897 128.77 23.2412C127.793 25.4656 127.305 27.8527 127.305 30.4026C127.305 32.9797 127.793 35.394 128.77 37.6455C129.746 39.897 131.076 41.8637 132.758 43.5455C134.439 45.2274 136.393 46.5566 138.617 47.5332C140.868 48.5097 143.269 48.998 145.819 48.998C147.284 48.998 148.708 48.8217 150.092 48.469C151.475 48.1164 152.791 47.6281 154.038 47.0042V30.4026H165.31V53.4332Z" fill="white"/>
	<path d="M195.98 59.3333H184.302V0.983683H195.98V59.3333Z" fill="white"/>
	</svg>
	';

	$esgiDark = '<svg width="118" height="37" viewBox="0 0 118 37" fill="none" xmlns="http://www.w3.org/2000/svg">
	<g id="ESGI">
	<path d="M24.2461 36H0.24707V0.990234H24.2461V7.99707H7.25391V15.0039H18.7529V22.0107H7.25391V28.9932H24.2461V36Z" fill="black"/>
	<path d="M32.7119 11.4883C32.7119 10.0397 32.9886 8.68066 33.542 7.41113C34.0954 6.1416 34.8441 5.03483 35.7881 4.09082C36.7484 3.13053 37.8633 2.3737 39.1328 1.82031C40.4023 1.26693 41.7614 0.990234 43.21 0.990234H59.2744V7.99707H43.21C42.7217 7.99707 42.2659 8.08659 41.8428 8.26562C41.4196 8.44466 41.0452 8.69694 40.7197 9.02246C40.4105 9.33171 40.1663 9.69792 39.9873 10.1211C39.8083 10.5443 39.7188 11 39.7188 11.4883C39.7188 11.9766 39.8083 12.4404 39.9873 12.8799C40.1663 13.3031 40.4105 13.6774 40.7197 14.0029C41.0452 14.3122 41.4196 14.5563 41.8428 14.7354C42.2659 14.9144 42.7217 15.0039 43.21 15.0039H50.2168C51.6654 15.0039 53.0244 15.2806 54.2939 15.834C55.5798 16.3711 56.6947 17.1198 57.6387 18.0801C58.599 19.0241 59.3477 20.139 59.8848 21.4248C60.4382 22.6943 60.7148 24.0534 60.7148 25.502C60.7148 26.9505 60.4382 28.3096 59.8848 29.5791C59.3477 30.8486 58.599 31.9635 57.6387 32.9238C56.6947 33.8678 55.5798 34.6165 54.2939 35.1699C53.0244 35.7233 51.6654 36 50.2168 36H34.665V28.9932H50.2168C50.7051 28.9932 51.1608 28.9036 51.584 28.7246C52.0072 28.5456 52.3734 28.3014 52.6826 27.9922C53.0081 27.6667 53.2604 27.2923 53.4395 26.8691C53.6185 26.446 53.708 25.9902 53.708 25.502C53.708 25.0137 53.6185 24.5579 53.4395 24.1348C53.2604 23.7116 53.0081 23.3454 52.6826 23.0361C52.3734 22.7106 52.0072 22.4583 51.584 22.2793C51.1608 22.1003 50.7051 22.0107 50.2168 22.0107H43.21C41.7614 22.0107 40.4023 21.734 39.1328 21.1807C37.8633 20.6273 36.7484 19.8786 35.7881 18.9346C34.8441 17.9743 34.0954 16.8594 33.542 15.5898C32.9886 14.304 32.7119 12.9368 32.7119 11.4883Z" fill="black"/>
	<path d="M99.1855 32.46C97.5579 33.8434 95.7432 34.9095 93.7412 35.6582C91.7393 36.3906 89.6559 36.7568 87.4912 36.7568C85.8311 36.7568 84.2279 36.5371 82.6816 36.0977C81.1517 35.6745 79.7194 35.0723 78.3848 34.291C77.0501 33.4935 75.8294 32.5495 74.7227 31.459C73.6159 30.3522 72.6719 29.1315 71.8906 27.7969C71.1094 26.446 70.499 24.9974 70.0596 23.4512C69.6364 21.9049 69.4248 20.3018 69.4248 18.6416C69.4248 16.9814 69.6364 15.3864 70.0596 13.8564C70.499 12.3265 71.1094 10.8942 71.8906 9.55957C72.6719 8.20866 73.6159 6.98796 74.7227 5.89746C75.8294 4.79069 77.0501 3.84668 78.3848 3.06543C79.7194 2.28418 81.1517 1.68197 82.6816 1.25879C84.2279 0.819336 85.8311 0.599609 87.4912 0.599609C89.6559 0.599609 91.7393 0.973958 93.7412 1.72266C95.7432 2.45508 97.5579 3.51302 99.1855 4.89648L95.5234 11C94.4655 9.92578 93.2448 9.08757 91.8613 8.48535C90.4779 7.86686 89.0212 7.55762 87.4912 7.55762C85.9613 7.55762 84.5208 7.85059 83.1699 8.43652C81.8353 9.02246 80.6634 9.81999 79.6543 10.8291C78.6452 11.8219 77.8477 12.9938 77.2617 14.3447C76.6758 15.6794 76.3828 17.1117 76.3828 18.6416C76.3828 20.1878 76.6758 21.6364 77.2617 22.9873C77.8477 24.3382 78.6452 25.5182 79.6543 26.5273C80.6634 27.5365 81.8353 28.334 83.1699 28.9199C84.5208 29.5059 85.9613 29.7988 87.4912 29.7988C88.3701 29.7988 89.2246 29.693 90.0547 29.4814C90.8848 29.2699 91.6742 28.9769 92.4229 28.6025V18.6416H99.1855V32.46Z" fill="black"/>
	<path d="M117.588 36H110.581V0.990234H117.588V36Z" fill="black"/>
	</g>
	</svg>
	';

	$esgiLight = '<svg width="118" height="37" viewBox="0 0 118 37" fill="none" xmlns="http://www.w3.org/2000/svg">
	<g id="ESGI">
	<path d="M24.2461 36H0.24707V0.990234H24.2461V7.99707H7.25391V15.0039H18.7529V22.0107H7.25391V28.9932H24.2461V36Z" fill="white"/>
	<path d="M32.7119 11.4883C32.7119 10.0397 32.9886 8.68066 33.542 7.41113C34.0954 6.1416 34.8441 5.03483 35.7881 4.09082C36.7484 3.13053 37.8633 2.3737 39.1328 1.82031C40.4023 1.26693 41.7614 0.990234 43.21 0.990234H59.2744V7.99707H43.21C42.7217 7.99707 42.2659 8.08659 41.8428 8.26562C41.4196 8.44466 41.0452 8.69694 40.7197 9.02246C40.4105 9.33171 40.1663 9.69792 39.9873 10.1211C39.8083 10.5443 39.7188 11 39.7188 11.4883C39.7188 11.9766 39.8083 12.4404 39.9873 12.8799C40.1663 13.3031 40.4105 13.6774 40.7197 14.0029C41.0452 14.3122 41.4196 14.5563 41.8428 14.7354C42.2659 14.9144 42.7217 15.0039 43.21 15.0039H50.2168C51.6654 15.0039 53.0244 15.2806 54.2939 15.834C55.5798 16.3711 56.6947 17.1198 57.6387 18.0801C58.599 19.0241 59.3477 20.139 59.8848 21.4248C60.4382 22.6943 60.7148 24.0534 60.7148 25.502C60.7148 26.9505 60.4382 28.3096 59.8848 29.5791C59.3477 30.8486 58.599 31.9635 57.6387 32.9238C56.6947 33.8678 55.5798 34.6165 54.2939 35.1699C53.0244 35.7233 51.6654 36 50.2168 36H34.665V28.9932H50.2168C50.7051 28.9932 51.1608 28.9036 51.584 28.7246C52.0072 28.5456 52.3734 28.3014 52.6826 27.9922C53.0081 27.6667 53.2604 27.2923 53.4395 26.8691C53.6185 26.446 53.708 25.9902 53.708 25.502C53.708 25.0137 53.6185 24.5579 53.4395 24.1348C53.2604 23.7116 53.0081 23.3454 52.6826 23.0361C52.3734 22.7106 52.0072 22.4583 51.584 22.2793C51.1608 22.1003 50.7051 22.0107 50.2168 22.0107H43.21C41.7614 22.0107 40.4023 21.734 39.1328 21.1807C37.8633 20.6273 36.7484 19.8786 35.7881 18.9346C34.8441 17.9743 34.0954 16.8594 33.542 15.5898C32.9886 14.304 32.7119 12.9368 32.7119 11.4883Z" fill="white"/>
	<path d="M99.1855 32.46C97.5579 33.8434 95.7432 34.9095 93.7412 35.6582C91.7393 36.3906 89.6559 36.7568 87.4912 36.7568C85.8311 36.7568 84.2279 36.5371 82.6816 36.0977C81.1517 35.6745 79.7194 35.0723 78.3848 34.291C77.0501 33.4935 75.8294 32.5495 74.7227 31.459C73.6159 30.3522 72.6719 29.1315 71.8906 27.7969C71.1094 26.446 70.499 24.9974 70.0596 23.4512C69.6364 21.9049 69.4248 20.3018 69.4248 18.6416C69.4248 16.9814 69.6364 15.3864 70.0596 13.8564C70.499 12.3265 71.1094 10.8942 71.8906 9.55957C72.6719 8.20866 73.6159 6.98796 74.7227 5.89746C75.8294 4.79069 77.0501 3.84668 78.3848 3.06543C79.7194 2.28418 81.1517 1.68197 82.6816 1.25879C84.2279 0.819336 85.8311 0.599609 87.4912 0.599609C89.6559 0.599609 91.7393 0.973958 93.7412 1.72266C95.7432 2.45508 97.5579 3.51302 99.1855 4.89648L95.5234 11C94.4655 9.92578 93.2448 9.08757 91.8613 8.48535C90.4779 7.86686 89.0212 7.55762 87.4912 7.55762C85.9613 7.55762 84.5208 7.85059 83.1699 8.43652C81.8353 9.02246 80.6634 9.81999 79.6543 10.8291C78.6452 11.8219 77.8477 12.9938 77.2617 14.3447C76.6758 15.6794 76.3828 17.1117 76.3828 18.6416C76.3828 20.1878 76.6758 21.6364 77.2617 22.9873C77.8477 24.3382 78.6452 25.5182 79.6543 26.5273C80.6634 27.5365 81.8353 28.334 83.1699 28.9199C84.5208 29.5059 85.9613 29.7988 87.4912 29.7988C88.3701 29.7988 89.2246 29.693 90.0547 29.4814C90.8848 29.2699 91.6742 28.9769 92.4229 28.6025V18.6416H99.1855V32.46Z" fill="white"/>
	<path d="M117.588 36H110.581V0.990234H117.588V36Z" fill="white"/>
	</g>
	</svg>
	';

	$linkedinAndFacebook = '<svg width="71" height="20" viewBox="0 0 71 20" fill="none" xmlns="http://www.w3.org/2000/svg">
	<rect width="71" height="20" fill="#F2F2F2"/><g id="07_Blog_single_page" clip-path="url(#clip0_0_1)"><rect width="1920" height="3364" transform="translate(-1690 -3264)" fill="white"/><g id="Footer">
	<rect id="Rectangle Copy" x="-1690" y="-297" width="1920" height="397" fill="#050A3A"/><g id="Social_icons">
	<path id="Shape" fill-rule="evenodd" clip-rule="evenodd" d="M2.40179 4.82589C1.07589 4.82589 0 3.72768 0 2.40179C0 1.07589 1.07589 0 2.40179 0C3.72768 0 4.80357 1.07589 4.80357 2.40179C4.80357 3.72768 3.72768 4.82589 2.40179 4.82589ZM4.47768 20H0.330357V6.64732H4.47768V20ZM15.8616 20H20H20.0045V12.6652C20.0045 9.07589 19.2321 6.3125 15.0357 6.3125C13.0179 6.3125 11.6652 7.41964 11.1116 8.46875H11.0536V6.64732H7.07589V20H11.2188V13.3884C11.2188 11.6473 11.5491 9.96429 13.7054 9.96429C15.8304 9.96429 15.8616 11.9509 15.8616 13.5V20Z" fill="white"/>
	<path id="Shape_2" d="M62.9961 20V11.0547H60V7.5H62.9961V4.69922C62.9961 1.65625 64.8555 0 67.5703 0C68.8711 0 69.9883 0.0976562 70.3125 0.140625V3.32031H68.4297C66.9531 3.32031 66.668 4.02344 66.668 5.05078V7.5H70L69.543 11.0547H66.668V20" fill="white"/>
	</g></g></g><defs><clipPath id="clip0_0_1">
	<rect width="1920" height="3364" fill="white" transform="translate(-1690 -3264)"/></clipPath></defs></svg>
	';

	$dot = '<svg width="234" height="70" viewBox="0 0 234 70" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="logo 1" clip-path="url(#clip0_4354_144)">
	<path id="Path_3_" d="M215 48.3334H233.333V63.3334H215V48.3334Z" fill="white"/></g><defs><clipPath id="clip0_4354_144">
	<rect width="233.333" height="70" fill="white"/></clipPath></defs></svg>
	';

	$dotColored = '<svg width="140" height="42" viewBox="0 0 140 42" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="logo 1">
	<path id="Path_3_" d="M129 29H140V38H129V29Z" fill="url(#paint0_linear_4354_98)"/></g><defs>
	<linearGradient id="paint0_linear_4354_98" x1="130.875" y1="25.898" x2="139.959" y2="26.8701" gradientUnits="userSpaceOnUse">
	<stop stop-color="#FFD0A8"/><stop offset="0.9995" stop-color="#FF4FC0"/></linearGradient></defs></svg>
	';

	$search = '<svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
	<path fill-rule="evenodd" clip-rule="evenodd" d="M12.6656 10.7188L15.7812 13.8344C16.0719 14.1281 16.0719 14.6031 15.7781 14.8969L14.8938 15.7812C14.6031 16.075 14.1281 16.075 13.8344 15.7812L10.7188 12.6656C10.5781 12.525 10.5 12.3344 10.5 12.1344V11.625C9.39688 12.4875 8.00937 13 6.5 13C2.90937 13 0 10.0906 0 6.5C0 2.90937 2.90937 0 6.5 0C10.0906 0 13 2.90937 13 6.5C13 8.00937 12.4875 9.39688 11.625 10.5H12.1344C12.3344 10.5 12.525 10.5781 12.6656 10.7188ZM2.5 6.5C2.5 8.7125 4.29063 10.5 6.5 10.5C8.7125 10.5 10.5 8.70938 10.5 6.5C10.5 4.2875 8.70938 2.5 6.5 2.5C4.2875 2.5 2.5 4.29063 2.5 6.5Z" fill="white"/>
	</svg>
	';

	return $$icon;

}

function wpc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'wpc_mime_types');

/*
function getPartnerIcon() {
	baks
	bernieBanks
	swiger
	mandalaCommunity
	balkan
	airball
}
*/

?>