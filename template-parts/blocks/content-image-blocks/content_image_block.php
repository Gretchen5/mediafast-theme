<?php
// Optimized: Fetch all fields at once instead of multiple get_field() calls
$fields = get_fields();
$heading = $fields['heading'] ?? '';
$description = $fields['description'] ?? '';
$image = $fields['image'] ?? [];
$cta_button = $fields['cta_button'] ?? '';
$alignment = $fields['alignment'] ?? '';
$vertical_padding = $fields['vertical_padding'] ?? '';
$background_color = $fields['background_color'] ?? '';
?>

<section class="component--content-image-block <?php echo esc_attr($vertical_padding . ' ' . $background_color); ?>">
    <div class="container">
        <div class="row d-flex <?php echo esc_attr($alignment); ?> gap-3 justify-content-center align-items-center">
            <div class="col-12 col-lg-5">
                <h2 class="text-primary lh-1 pb-3"><?php echo $heading; ?></h2>
                <?php echo $description; ?>
                <?php if ($cta_button) : ?>
                    <a href="<?php echo esc_url($cta_button['url']); ?>" class="btn btn-primary mt-3"><?php echo $cta_button['title']; ?></a>
                <?php endif; ?>
            </div>
            <div class="col-12 col-lg-6">
                <?php if (!empty($image) && isset($image['url'])) : ?>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?? ''); ?>" class="img-fluid" loading="lazy" />
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>