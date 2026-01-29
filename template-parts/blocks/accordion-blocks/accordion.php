<?php
$heading          = get_field('heading');
$background_color = get_field('background_color');
$padding          = get_field('padding');
$searchbar        = get_field('searchbar');

// Generate a unique ID for this accordion block
$accordion_id = uniqid('accordion_');
?>

<section id="<?php echo esc_attr($accordion_id); ?>" class="component--accordion <?php echo esc_attr($background_color . ' ' . $padding); ?>">
    <div class="accordion-container d-flex flex-column flex-md-row justify-content-center">
        <div class="accordion-wrapper col-12 col-md-10 bg-transparent px-md-5 rounded">
            <div class="accordion-container">
                <?php if ($heading) : ?>
                    <h2 class="text-center pb-4"><?php echo $heading; ?></h2>
                <?php endif; ?>

                <?php if ($searchbar == 'true') : ?>
                    <div id="<?php echo esc_attr($accordion_id . '_search_bar_container'); ?>">
                        <input class="px-4" type="search" id="<?php echo esc_attr($accordion_id . '_search_bar'); ?>" placeholder="Search" />
                    </div>
                <?php endif; ?>

                <div class="accordion" id="<?php echo esc_attr($accordion_id); ?>" role="group" aria-label="<?php echo esc_attr($heading ?: 'Accordion'); ?>">
                    <?php if (have_rows('accordion_repeater')) : $i = 1;
                        while (have_rows('accordion_repeater')) :
                            the_row();

                            $accordion_heading = get_sub_field('accordion_heading');
                            $accordion_body    = get_sub_field('accordion_body');

                            // Create unique IDs for each item
                            $item_id     = $accordion_id . '_item' . $i;
                            $heading_id  = $accordion_id . '_heading' . $i;
                            $collapse_id = $accordion_id . '_collapse' . $i;

                            // Add "show" only to the first item
                            $show_class  = $i === 1 ? 'show' : '';
                            $collapsed   = $i === 1 ? '' : 'collapsed';
                            $expanded    = $i === 1 ? 'true' : 'false';
                    ?>
                            <div id="<?php echo esc_attr($item_id); ?>" class="accordion-item bg-transparent">
                                <h3 class="accordion-header" id="<?php echo esc_attr($heading_id); ?>">
                                    <button class="accordion-button collapsed bg-transparent h3 text-primary" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#<?php echo esc_attr($collapse_id); ?>"
                                        aria-expanded="<?php echo $expanded; ?>"
                                        aria-controls="<?php echo esc_attr($collapse_id); ?>">
                                        <?php echo $accordion_heading; ?>
                                    </button>
                                </h3>
                                <div id="<?php echo esc_attr($collapse_id); ?>" class="accordion-collapse collapse <?php echo $show_class; ?>"
                                    aria-labelledby="<?php echo esc_attr($heading_id); ?>">
                                    <div class="accordion-body">
                                        <?php echo $accordion_body; ?>
                                    </div>
                                </div>
                            </div>
                    <?php $i++;
                        endwhile;
                    endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>