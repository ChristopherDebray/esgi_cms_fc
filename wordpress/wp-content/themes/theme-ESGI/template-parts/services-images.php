<section>
    <div class="services-container">
      <?php for ($i = 1; $i <= 4; $i++) : ?>
        <?php if ($service_image = get_theme_mod('services_image_' . $i . '_image')) : ?>
            <img class='services-images-container-image' src="<?php echo esc_url($service_image); ?>">
        <?php endif; ?>
      <?php endfor; ?>
    </div>
</section>