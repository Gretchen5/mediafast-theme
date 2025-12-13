<?php

$wysiwyg = get_field('wysiwyg') ? get_field('wysiwyg') : '';
$vertical_padding = get_field('vertical_padding') ? get_field('vertical_padding') : '';

?>

<section class="cta_button-block <?php echo esc_attr($vertical_padding); ?>">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if ($wysiwyg) : ?>
                    <div class="wysiwyg-content">
                        <?php echo $wysiwyg; ?>
                    </div>
                <?php endif; ?>
                <?php if (have_rows('cta_button_repeater')) : ?>
                    <div class="button-cta-container d-flex flex-wrap justify-content-center">
                        <?php while (have_rows('cta_button_repeater')) : the_row();
                            $cta_button = get_sub_field('cta_button') ? get_sub_field('cta_button') : '';
                        ?>
                            <a class="btn btn-primary m-2" href="<?php echo esc_url($cta_button['url']); ?>" target="<?php echo esc_attr($cta_button['target']); ?>">
                                <?php echo $cta_button['title']; ?>
                            </a>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>