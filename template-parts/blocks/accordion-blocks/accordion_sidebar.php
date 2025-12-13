<?php
$section_heading = get_field('section_heading');
$subheading      = get_field('subheading');
?>

<section class="component--accordion-sidebar pt-75 pb-4 bg-lt-gray">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if ($section_heading || $subheading) : ?>
                    <div class="heading-container pb-4">
                        <h2 class="text-secondary"><?php echo $section_heading; ?></h2>
                        <p class="text-dk-gray"><?php echo $subheading; ?></p>
                    </div>
                <?php endif; ?>
                <?php if (have_rows('tabs_repeater')) : ?>
                    <ul class="nav nav-tabs flex-nowrap text-nowrap" id="howToTabs" role="tablist">
                        <?php $tab_count = 0; ?>
                        <?php while (have_rows('tabs_repeater')) : the_row();
                            $tab_count++;
                            $tab_title = get_sub_field('tab_title');
                            $tab_slug  = sanitize_title($tab_title) . '-' . $tab_count; // unique ID
                        ?>
                            <li class="nav-item">
                                <button
                                    class="nav-link <?php echo $tab_count === 1 ? 'active' : ''; ?>"
                                    id="tab-<?php echo $tab_slug; ?>"
                                    data-bs-toggle="tab"
                                    data-bs-target="#pane-<?php echo $tab_slug; ?>"
                                    type="button"
                                    role="tab"
                                    aria-controls="pane-<?php echo $tab_slug; ?>"
                                    aria-selected="<?php echo $tab_count === 1 ? 'true' : 'false'; ?>">
                                    <?php echo $tab_title; ?>
                                </button>
                            </li>
                        <?php endwhile; ?>
                    </ul>

                    <?php reset_rows(); // reset repeater pointer 
                    ?>


                    <div class="tab-content py-5">
                        <?php $tab_count = 0; ?>
                        <?php while (have_rows('tabs_repeater')) : the_row();
                            $tab_count++;
                            $tab_title = get_sub_field('tab_title');
                            $tab_slug  = sanitize_title($tab_title) . '-' . $tab_count;
                        ?>
                            <div
                                id="pane-<?php echo $tab_slug; ?>"
                                class="tab-pane fade <?php echo $tab_count === 1 ? 'show active' : ''; ?>"
                                role="tabpanel"
                                aria-labelledby="tab-<?php echo $tab_slug; ?>">

                                <?php if (have_rows('tab_content_repeater')) : ?>
                                    <?php while (have_rows('tab_content_repeater')) : the_row();
                                        $heading = get_sub_field('heading');
                                        $content = get_sub_field('content');
                                    ?>
                                        <?php if ($heading) : ?>
                                            <h3 class="py-3 text-dk-gold"><?php echo $heading; ?></h3>
                                        <?php endif; ?>
                                        <div class="wysiwyg"><?php echo $content; ?></div>
                                    <?php endwhile; ?>
                                <?php endif; ?>

                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>


            </div>
        </div>
    </div>
</section>