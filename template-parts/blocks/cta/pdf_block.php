<?php
$pdf_intro = get_field('pdf_intro') ? get_field('pdf_intro') : '';
$pdf_link = get_field('pdf_link') ? get_field('pdf_link') : '';
$pdf_link_2 = get_field('pdf_link_2') ? get_field('pdf_link_2') : '';
$pdf_overlay = get_field('pdf_overlay') ? get_field('pdf_overlay') : '';
?>

<?php if (!empty($pdf_link) && is_array($pdf_link)): ?>
    <div class="container pdf-section <?php echo $pdf_overlay; ?>">
        <div class="row bg-white box-shadow-extra-large border-radius-6px ps-lg-5 pe-lg-5 pt-3 pb-3 g-0 sm-p-6 sm-ps-19 align-items-center mb-8 overflow-hidden position-relative">
            <div class="col-lg-2 col-md-3 text-center sm-mb-25px p-3">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/rocket-icon.svg" alt="rocket icon">
            </div>
            <div class="col-md-6 text-center text-md-start sm-mb-25px">
                <div class="fs-26 alt-font fw-500 text-dark-gray ls-minus-05px"><?php echo $pdf_intro; ?></div>
            </div>
            <div class="col-lg-4 col-md-3 text-center pb-4 pb-lg-0">

                <a class="btn btn-primary" href="<?php echo esc_url($pdf_link['url']); ?>" target="<?php echo esc_attr($pdf_link['target']); ?>">
                    <?php echo esc_html($pdf_link['title']); ?>
                </a>
                <?php if ($pdf_link_2) : ?>
                    <a class="btn btn-primary mt-3" href="<?php echo esc_url($pdf_link_2['url']); ?>" target="<?php echo esc_attr($pdf_link_2['target']); ?>">
                        <?php echo esc_html($pdf_link_2['title']); ?>
                    </a>
                <?php endif; ?>

            </div>
            <div class="vertical-title-center align-items-center position-absolute top-0px left-0px bg-base-color p-10px w-50px h-100 w-10px z-index-9">
                <div class="title fs-15 ls-1px text-white fw-600 text-uppercase">PDF GUIDE</div>
            </div>
        </div>
    </div>
<?php endif; ?>