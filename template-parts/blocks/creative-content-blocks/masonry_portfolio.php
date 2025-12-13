<?php

$heading = get_field('heading');
$subheading = get_field('subheading');
$cta_button = get_field('cta_button') ? get_field('cta_button') : '';
$background_color = get_field('background_color');

?>

<!-- Portfolio Section Start -->
<div id="portfolio" class="section section-padding ag-masonary-wrapper py-75 bg-lt-gray <?php echo esc_attr($background_color); ?> background-position-center background-repeat" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/vertical-center-line-bg.svg')">
    <div class="container">
        <div class="row flex-column align-items-center">

            <div class="col-12">

                <div class="heading-container text-center pb-5">
                    <h2><?php echo $heading; ?></h2>
                    <p class="subheading col-md-8 mx-auto"><?php echo $subheading; ?></p>
                </div>
            </div>
            <div class="col-12">
                <!-- Portfolio Menu Start -->

                <?php
                $used_categories = [];

                if (have_rows('portfolio_display')) {
                    while (have_rows('portfolio_display')) {
                        the_row();
                        $category = get_sub_field('portfolio_category'); // returns array if "Both" format is set
                        if ($category && !in_array($category['value'], array_column($used_categories, 'value'))) {
                            $used_categories[] = $category;
                        }
                    }
                    reset_rows();
                }
                ?>

                <div class="messonry-button text-center mb-4 mb-md-5">
                    <button data-filter="*" class="h3-portfolio-button is-checked mb-4 mb-md-0">
                        <span class="filter-text">All</span>
                    </button>

                    <?php foreach ($used_categories as $cat): ?>
                        <button data-filter=".<?php echo esc_attr($cat['value']); ?>">
                            <span class="filter-text h3-portfolio-button"><?php echo esc_html($cat['label']); ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>



        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1 g-0 masonry-list">
            <div class="resizer col"></div>
            <!-- Single Portfolio Start -->
            <?php if (have_rows('portfolio_display')) {
                while (have_rows('portfolio_display')) {
                    the_row();
                    $portfolio_category = get_sub_field('portfolio_category');
                    $background_image_url = get_sub_field('image') ? get_sub_field('image') : '';
                    $background_image = 'background-image: url(' . $background_image_url  . ');';
                    $card_title = get_sub_field('card_title');
                    $card_content = get_sub_field('card_content');

            ?>
                    <div class="col <?php echo esc_attr($portfolio_category['value']); ?>">
                        <div class="single-portfolio">
                            <div class="thumbnail d-flex justify-content-center align-items-center portfolio-bg" style="<?php echo esc_attr($background_image); ?>;">

                                <h3 class="portfolio-card-title title text-white">
                                    <?php echo $card_title; ?>
                                </h3>
                            </div>
                            <div class="content">
                                <p class="text-white"><?php echo $card_content; ?></p>
                            </div>
                        </div>
                    </div>
                    <!-- Single Portfolio End -->
            <?php }
            } ?>

        </div>
    </div>
    <?php if ($cta_button) { ?>
        <div class="cta-button-container d-flex justify-content-center pt-5 pb-90 bg-gray">

            <a class="btn btn-primary" align-items-center href="<?php echo $cta_button['url']; ?>" target="<?php echo $cta_button['target']; ?>"><?php echo $cta_button['title']; ?></a>

        </div>
    <?php } ?>
</div>

<!-- Portfolio Section End -->