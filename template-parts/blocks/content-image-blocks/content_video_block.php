<?php


$heading = get_field('heading');
$subheading = get_field('subheading');
$description = get_field('description');
$video_link = get_field('video_link');
$background_color = get_field('background_color') ? get_field('background_color') : '';
$video_position = get_field('video_position');
$cta_button = get_field('cta_button') ? get_field('cta_button') : '';
$vertical_padding = get_field('vertical_padding');
?>

<section class="component--content-video-block <?php echo $background_color; ?>">
    <div class="content-video-block-container container <?php echo $vertical_padding; ?> px-0">
        <div class="content-video-block-flex-container d-flex flex-column-reverse gap-3 <?php echo $video_position; ?> justify-content-center align-items-center">
            <div class="video-container col-12 col-xl-5">
                <div class="video-player cvb-video-player">
                    <iframe
                        width="100%"

                        src="<?php echo esc_url($video_link); ?>"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
            <div class="content-container col-12 col-xl-5">
                <?php if ($heading) { ?>
                    <h2 class="text-secondary pb-3"><?php echo $heading; ?></h2>
                <?php } ?>
                <?php if ($subheading) { ?>
                    <h3><?php echo $subheading; ?></h3>
                <?php } ?>
                <?php if ($description) { ?>
                    <?php echo $description; ?>
                <?php } ?>
                <?php if ($cta_button) { ?>
                    <div class="cta-button-container py-4">
                        <a class="btn btn-primary" href="<?php echo $cta_button['url']; ?>" target="<?php echo $cta_button['target']; ?>"><?php echo $cta_button['title']; ?></a>
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>
</section>