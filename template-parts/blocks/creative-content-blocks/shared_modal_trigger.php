<?php
$modal_type        = get_field('modal_type');
$button_text       = get_field('button_text') ?: 'View Image & Video';
$heading             = get_field('heading') ?: get_the_title();
$description       = get_field('description');
$image             = get_field('image') ?: ['url' => get_the_post_thumbnail_url(null, 'full')];
$video             = get_field('video');
$form              = get_field('form');
$calendly_url  = 'https://calendly.com/mediafast-team/30min?embed_domain=mediafast.com&embed_type=PopupText';

$unique_id = uniqid('sharedModalBlock_');

if ($modal_type === 'image_video' && $image && !$video) {
    $modal_type = 'image';
}
// (Optional) Convert 'image_video' to 'video' if image is missing but video is present
if ($modal_type === 'image_video' && !$image && $video) {
    $modal_type = 'video';
}

// Detect current post type
$post_type = get_post_type();

// Default button class
$button_class = 'btn-primary';

// Change class if on Gallery CPT
if ($post_type === 'gallery') {
    $button_class = 'btn-primary btn-primary-gallery';
}
?>
<p class="pb-3"><?php echo $description; ?></p>
<?php if (
    ($modal_type === 'image' && $image) ||
    ($modal_type === 'video' && $video) ||
    ($modal_type === 'form' && $form) ||
    ($modal_type === 'image_video' && ($image && $video)) ||
    ($modal_type === 'calendly')
) : ?>
    <button type="button"
        class="btn <?php echo esc_attr($button_class); ?>"
        data-bs-toggle="modal"
        data-bs-target="#mediaModal"
        data-type="<?php echo esc_attr($modal_type); ?>"
        <?php if ($image) : ?>
        data-image="<?php echo esc_url($image['url']); ?>"
        <?php endif; ?>
        <?php if ($video) : ?>
        data-video="<?php echo esc_url($video); ?>"
        <?php endif; ?>
        data-title="<?php echo esc_attr($heading); ?>"
        data-description="<?php echo esc_attr(wp_strip_all_tags($description)); ?>">
        <?php echo esc_html($button_text); ?>
    </button>
<?php endif; ?>

<?php if ($modal_type === 'form' && $form) : ?>
    <div id="<?php echo esc_attr($unique_id); ?>" class="d-none">
        <?php echo $form; ?>
    </div>
<?php endif; ?>