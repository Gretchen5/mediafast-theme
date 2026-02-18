<?php
// Optimized: Fetch all fields at once instead of multiple get_field() calls
$fields = get_fields();
$heading = $fields['heading'] ?? '';
$subheading = $fields['subheading'] ?? '';
$description = $fields['description'] ?? '';
$video_link = $fields['video_link'] ?? '';
$background_color = $fields['background_color'] ?? '';
$video_position = $fields['video_position'] ?? '';
$cta_button = $fields['cta_button'] ?? '';
$vertical_padding = $fields['vertical_padding'] ?? '';
?>

<section class="component--content-video-block <?php echo $background_color; ?>">
    <div class="content-video-block-container container <?php echo $vertical_padding; ?>">
        <div class="content-video-block-flex-container d-flex flex-column-reverse gap-4 justify-content-center align-items-center">
            <div class="video-container col-12 col-md-6">
                <div class="video-player cvb-video-player">
                    <?php
                    // Extract YouTube video ID from URL
                    $video_id = null;
                    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube-nocookie\.com\/embed\/)([^"&?\/\s]{11})/', $video_link, $matches)) {
                        $video_id = $matches[1];
                    } elseif (preg_match('/^([a-zA-Z0-9_-]{11})$/', $video_link)) {
                        $video_id = $video_link;
                    }
                    
                    if ($video_id) :
                        // Use lite YouTube embed placeholder
                    ?>
                        <div class="js-lite-youtube cvb-video-player" 
                             data-video-url="<?php echo esc_url($video_link); ?>"
                             data-video-title="<?php echo esc_attr($heading ?: 'Video'); ?>"
                             style="position: relative; width: 100%; padding-bottom: 56.25%;">
                        </div>
                    <?php else : ?>
                        <?php
                        // Fallback for non-YouTube videos
                        ?>
                        <iframe
                            width="100%"
                            src="<?php echo esc_url($video_link); ?>"
                            title="Video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                            loading="lazy">
                        </iframe>
                    <?php endif; ?>
                </div>
            </div>
            <div class="content-container col-12">
                <?php if ($heading) { ?>
                    <h2 class="text-secondary text-center"><?php echo $heading; ?></h2>
                <?php } ?>
                <?php if ($subheading) { ?>
                    <h3 class="text-dk-gray text-center pb-3"><?php echo $subheading; ?></h3>
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