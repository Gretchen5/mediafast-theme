<?php
$image            = get_field('image');
$heading          = get_field('heading');
$vertical_padding = get_field('vertical_padding') ?: '';
$background_color = get_field('background_color') ?: 'bg-secondary';
$background_url   = $image['url'] ?? '';
$accordion_id     = 'accordion-' . uniqid();
?>

<section class="component--content-image-dark <?php echo esc_attr($background_color . ' ' . $vertical_padding); ?>">
    <div class="container-fluid px-0">
        <div class="row g-0 align-items-stretch">
            <div class="content-column col-12 col-lg-6">
                <div class="content-pane h-100 p-4 p-md-5 text-white d-flex flex-column">
                    <?php if ($heading) : ?>
                        <h2 class="fw-600 mb-4 lh-sm"><?php echo wp_kses_post($heading); ?></h2>
                    <?php endif; ?>

                    <?php if (have_rows('accordion_repeater')) : ?>
                        <div class="accordion component-accordion-dark border-0" id="<?php echo esc_attr($accordion_id); ?>">
                            <?php
                            $i = 0;
                            while (have_rows('accordion_repeater')) :
                                the_row();
                                $i++;
                                $accordion_heading = get_sub_field('accordion_heading');
                                $accordion_body    = get_sub_field('accordion_body');
                                $is_first          = ($i === 1);
                                $item_id           = $accordion_id . '-' . $i;
                            ?>
                                <div class="accordion-item bg-transparent">
                                    <h3 class="accordion-header" id="heading-<?php echo esc_attr($item_id); ?>">
                                        <button class="accordion-button text-white fs-20 fw-600bg-transparent <?php echo $is_first ? '' : 'collapsed'; ?>" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse-<?php echo esc_attr($item_id); ?>"
                                            aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>"
                                            aria-controls="collapse-<?php echo esc_attr($item_id); ?>">
                                            <?php echo wp_kses_post($accordion_heading); ?>
                                        </button>
                                    </h3>
                                    <div id="collapse-<?php echo esc_attr($item_id); ?>"
                                         class="accordion-collapse collapse <?php echo $is_first ? 'show' : ''; ?>"
                                         aria-labelledby="heading-<?php echo esc_attr($item_id); ?>"
                                         data-bs-parent="#<?php echo esc_attr($accordion_id); ?>">
                                        <div class="accordion-body text-white">
                                            <?php echo wp_kses_post($accordion_body); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="image-column col-12 col-lg-6">
                <div class="image-pane h-100">
                    <?php if ($background_url) : ?>
                        <div class="image-pane__bg h-100" style="background-image: url(<?php echo esc_url($background_url); ?>)"></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>