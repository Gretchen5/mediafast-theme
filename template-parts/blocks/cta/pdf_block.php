<?php
// ACF Fields
$pdif_intro = get_field('pdf_intro');
$pdf_link   = get_field('pdf_link');
$pdf_link_2 = get_field('pdf_link_2');
?>

<?php if (!empty($pdf_link) && is_array($pdf_link)): ?>
    <section class="pdf-block py-5">
        <div class="container text-center">
            <?php if (!empty($pdif_intro)) : ?> 
                <div class="content-container">
                    <?php echo $pdif_intro; ?>
                </div>
            <?php endif; ?>
            <a href="<?php echo esc_url($pdf_link['url']); ?>"
            target="<?php echo esc_attr($pdf_link['target']); ?>"
            class="pdf-cta-link text-primary text-decoration-underline fw-semibold d-block">
                <?php echo esc_html($pdf_link['title']); ?>
            </a>
            <?php if (!empty($pdf_link_2) && is_array($pdf_link_2)) : ?>
                <a href="<?php echo esc_url($pdf_link_2['url']); ?>"
                target="<?php echo esc_attr($pdf_link_2['target']); ?>"
                class="pdf-cta-link text-primary text-decoration-underline fw-semibold d-block mt-2">
                    <?php echo esc_html($pdf_link_2['title']); ?>
                </a>
            <?php endif; ?>
        </div>
   </section>     

<?php endif; ?>
