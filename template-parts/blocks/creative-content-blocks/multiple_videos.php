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
                    <div class="video-container row g-5 justify-content-center align-items-center">
                        <?php while (have_rows('video_repeater')) {
                            the_row();
                            $video_url = get_sub_field('video_url');
                            $video_title = get_sub_field('video_title');
                        ?>
                            <div class="each-video-multiple-videos col-10 col-md-5 d-flex flex-column align-items-start justify-content-end">
                                <div class="video-wrapper">
                                    <?php
                                    // Extract YouTube video ID from URL
                                    $video_id = null;
                                    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube-nocookie\.com\/embed\/)([^"&?\/\s]{11})/', $video_url, $matches)) {
                                        $video_id = $matches[1];
                                    } elseif (preg_match('/^([a-zA-Z0-9_-]{11})$/', $video_url)) {
                                        $video_id = $video_url;
                                    }
                                    
                                    if ($video_id) :
                                        // Use lite YouTube embed placeholder
                                    ?>
                                        <div class="js-lite-youtube shadow rounded bg-white" 
                                             data-video-url="<?php echo esc_url($video_url); ?>"
                                             data-video-title="<?php echo esc_attr($video_title ?: 'Video content'); ?>"
                                             style="position: relative; width: 100%; padding-bottom: 56.25%;">
                                        </div>
                                    <?php else : ?>
                                        <?php
                                        // Fallback for non-YouTube videos
                                        ?>
                                        <iframe src="<?php echo esc_url($video_url); ?>" width="100%" height="100%" title="<?php echo esc_attr($video_title ?: 'Video content'); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen loading="lazy" class="shadow rounded bg-white"></iframe>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>