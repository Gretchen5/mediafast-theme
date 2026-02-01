<?php
$heading      = get_field('heading');
$description  = get_field('description');
$bottom_description  = get_field('bottom_description');
$accordion_id = 'accordion-2-' . uniqid();

// Collect stats from repeater once
$stats = [];
if (have_rows('stats_list')) {
    while (have_rows('stats_list')) {
        the_row();
        $stat = get_sub_field('stats');
        if (!empty($stat)) {
            $stats[] = $stat;
        }
    }
}
?>

<!-- Accordion Section -->
<section class="component--accordion-2 py-5">
    <div class="container">
        <!-- Heading and Description at Top -->
        <div class="row mb-4">
            <div class="col-12">
                <?php if ($heading) : ?>
                    <h2 class="text-secondary mb-2 fw-700 text-center"><?php echo wp_kses_post($heading); ?></h2>
                <?php endif; ?>
                <?php if ($description) : ?>
                    <p class="text-body text-center mb-4"><?php echo $description; ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Accordion - Full Width -->
        <div class="row">
            <div class="col-12 col-md-10 mx-auto">
                <?php if (have_rows('accordion_repeater')) : ?>
                    <div class="accordion component-accordion" id="<?php echo esc_attr($accordion_id); ?>">
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
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-<?php echo esc_attr($item_id); ?>">
                                    <button class="accordion-button <?php echo $is_first ? '' : 'collapsed'; ?>" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse-<?php echo esc_attr($item_id); ?>"
                                        aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>"
                                        aria-controls="collapse-<?php echo esc_attr($item_id); ?>">
                                        <?php echo wp_kses_post($accordion_heading); ?>
                                    </button>
                                </h2>
                                <div id="collapse-<?php echo esc_attr($item_id); ?>"
                                     class="accordion-collapse collapse <?php echo $is_first ? 'show' : ''; ?>"
                                     aria-labelledby="heading-<?php echo esc_attr($item_id); ?>"
                                     data-bs-parent="#<?php echo esc_attr($accordion_id); ?>">
                                    <div class="accordion-body">
                                        <?php echo wp_kses_post($accordion_body); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Bottom CTA -->
        <div class="row justify-content-start justify-content-md-center mt-5">
            <div class="col-auto">
                <div class="text-start">
                    <span class="accordion-2-below-text text-secondary fw-500">
                        <?php echo wp_kses_post($bottom_description); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>