<?php
// Block fields
$title = get_field('cta_title');
$description = get_field('cta_description');
$button = get_field('cta_button');
$bg_color = get_field('cta_background_color');
$padding_top = get_field('padding_top') ?: '';
$padding_bottom = get_field('padding_bottom') ?: '';
$heading_color = get_field('heading_color') ?: 'text-seconary';
$text_color = get_field('text_color') ?: '#text-body';
// Block ID and classes
$block_id = 'cta-' . $block['id'];
$block_class = "cta-block $padding_top $padding_bottom";
if (!empty($block['className'])) {
    $block_class .= ' ' . $block['className'];
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($block_class); ?>" style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 text-center mx-auto">
                <?php if ($title): ?>
                    <h2 class="<?php echo $heading_color; ?> pb-3 text-center"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if ($description): ?>
                    <p class="<?php echo $text_color; ?> pb-3"><?php echo esc_html($description); ?></p>
                <?php endif; ?>

                <?php if ($button): ?>
                    <a class="btn btn-primary" href="<?php echo esc_url($button['url']); ?>" target="<?php echo esc_attr($button['target']); ?>">
                        <?php echo esc_html($button['title']); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>