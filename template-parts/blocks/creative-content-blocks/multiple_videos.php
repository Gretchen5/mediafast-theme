<?php

$heading = get_field('heading');
$description = get_field('description');
$background_color = get_field('background_color');
$heading_color = get_field('heading_color');
$padding = get_field('padding');

?>

<section class="component--multiple-videos background-position-center background-repeat <?php echo esc_attr($background_color . ' ' . $padding); ?>" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/vertical-center-line-bg.svg')">
    <div class="container">
        <div class="heading-container pb-4">
            <h2 class="<?php echo esc_attr($heading_color); ?> text-center pb-3"><?php echo $heading; ?></h2>
            <?php if ($description) { ?>
                <div class="description-container">
                    <?php echo $description; ?>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-12">
                <?php if (have_rows('video_repeater')) { ?>
                    <div class="video-container row g-4 justify-content-center align-items-center">
                        <?php while (have_rows('video_repeater')) {
                            the_row();
                            $video_url = get_sub_field('video_url');
                            $video_title = get_sub_field('video_title')
                        ?>
                            <div class="each-video-multiple-videos col-10 col-md-5 d-flex flex-column align-items-start justify-content-end">
                                <div class="video-wrapper">
                                    <iframe src="<?php echo esc_url($video_url); ?>" width="100%" height="100%" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen loading="lazy" class="shadow rounded bg-white"></iframe>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>