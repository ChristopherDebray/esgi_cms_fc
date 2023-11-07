<?php
$members = array();

// Loop through the settings to retrieve member data
for ($i = 1; $i <= 4; $i++) {
    $member_image = get_theme_mod('member_' . $i . '_image');
    if (!$member_image) continue;
    $member_title = get_theme_mod('member_' . $i . '_title');
    $member_phone = get_theme_mod('member_' . $i . '_phone');
    $member_email = get_theme_mod('member_' . $i . '_email');

    // Check if any of the settings are not empty before adding to the $members array
    if ($member_image || $member_title || $member_phone || $member_email) {
        $members[] = array(
            'image' => $member_image,
            'title' => $member_title,
            'phone' => $member_phone,
            'email' => $member_email,
        );
    }
}
?>

<section class="margin--section">
  <h1 class="title title--section">Our Team</h1>
    <div class="members-container">
      <?php foreach ($members as $member) : ?>
          <div class="member">
              <div class="member-image">
                  <img src="<?php echo esc_url($member['image']); ?>" alt="<?php echo esc_attr($member['title']); ?>">
              </div>
              <div class="member-details">
                  <h2 class="mb-4 mt-4"><?php echo esc_html($member['title']); ?></h2>
                  <p class="mb-2"><?php echo esc_html($member['phone']); ?></p>
                  <p><?php echo sanitize_email($member['email']); ?></p>
              </div>
          </div>
      <?php endforeach; ?>
    </div>
</section>