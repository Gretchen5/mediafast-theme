<?php
$section_heading = get_field('section_heading');
$subheading      = get_field('subheading');
$tabs            = have_rows('tabs_repeater');
?>

<section class="component--accordion-sidebar bg-lt-gray py-5">
    <div class="container">
        <?php if ($section_heading || $subheading) : ?>
            <div class="row mb-4">
                <div class="col-lg-10">
                    <?php if ($section_heading) : ?>
                        <h2 class="text-secondary fw-600 mb-2"><?php echo wp_kses_post($section_heading); ?></h2>
                    <?php endif; ?>
                    <?php if ($subheading) : ?>
                        <p class="text-body mb-4"><?php echo wp_kses_post($subheading); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($tabs) : ?>
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-tabs component-tabs flex-wrap" id="howToTabs" role="tablist">
                        <?php $tab_count = 0; ?>
                        <?php while (have_rows('tabs_repeater')) : the_row();
                            $tab_count++;
                            $tab_title = get_sub_field('tab_title');
                            $tab_slug  = sanitize_title($tab_title) . '-' . $tab_count; // unique ID
                        ?>
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link <?php echo $tab_count === 1 ? 'active' : ''; ?>"
                                    id="tab-<?php echo esc_attr($tab_slug); ?>"
                                    data-bs-toggle="tab"
                                    data-bs-target="#pane-<?php echo esc_attr($tab_slug); ?>"
                                    type="button"
                                    role="tab"
                                    aria-controls="pane-<?php echo esc_attr($tab_slug); ?>"
                                    aria-selected="<?php echo $tab_count === 1 ? 'true' : 'false'; ?>">
                                    <?php echo wp_kses_post($tab_title); ?>
                                </button>
                            </li>
                        <?php endwhile; ?>
                    </ul>

                    <?php reset_rows(); // reset repeater pointer ?>

                    <div class="tab-content pt-4">
                        <?php $tab_count = 0; ?>
                        <?php while (have_rows('tabs_repeater')) : the_row();
                            $tab_count++;
                            $tab_title = get_sub_field('tab_title');
                            $tab_slug  = sanitize_title($tab_title) . '-' . $tab_count;
                        ?>
                            <div
                                id="pane-<?php echo esc_attr($tab_slug); ?>"
                                class="tab-pane fade <?php echo $tab_count === 1 ? 'show active' : ''; ?> component-pane"
                                role="tabpanel"
                                aria-labelledby="tab-<?php echo esc_attr($tab_slug); ?>">

                                <?php if (have_rows('tab_content_repeater')) : ?>
                                    <?php while (have_rows('tab_content_repeater')) : the_row();
                                        $heading = get_sub_field('heading');
                                        $content = get_sub_field('content');
                                    ?>
                                        <?php if ($heading) : ?>
                                            <h3 class="pane-heading text-dk-gray fw-600 my-3"><?php echo wp_kses_post($heading); ?></h3>
                                        <?php endif; ?>
                                        <?php if ($content) : ?>
                                            <div class="pane-body text-body">
                                                <?php echo wp_kses_post($content); ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                <?php endif; ?>

                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>