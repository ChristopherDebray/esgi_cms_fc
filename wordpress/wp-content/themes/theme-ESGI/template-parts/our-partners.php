<section>
    <div class="partners-container">
      <?php for ($i = 1; $i <= 6; $i++) : ?>
        <?php if ($partner_image = get_theme_mod('partner_' . $i . '_image')) : ?>
            <img src="<?php echo esc_url($partner_image); ?>">
        <?php endif; ?>
      <?php endfor; ?>
    </div>
</section>