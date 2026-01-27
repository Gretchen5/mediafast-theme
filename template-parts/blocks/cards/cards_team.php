<?php
$heading = get_field('heading') ?: '';
?>

<section class="component--cards-team py-5">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <span class="fs-17 d-inline-block fw-500 text-uppercase text-base-color ls-1px">We help our clients market smarter</span>
                <?php if ($heading) : ?>
                    <h1 class="text-secondary fw-600 mt-2"><?php echo wp_kses_post($heading); ?></h1>
                <?php endif; ?>
            </div>
        </div>

        <?php if (have_rows('card_repeater')) : ?>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-3 justify-content-center">
                <?php while (have_rows('card_repeater')) : the_row();
                    $bio_image        = get_sub_field('bio_image');
                    $team_member_name = get_sub_field('team_member_name');
                    $position         = get_sub_field('position');

                    // Normalize name (text or link array)
                    $name_text = '';
                    if (is_array($team_member_name)) {
                        $name_text = $team_member_name['title'] ?? ($team_member_name['url'] ?? '');
                    } else {
                        $name_text = $team_member_name;
                    }
                ?>
                    <div class="col d-flex">
                        <article class="team-card text-center w-100 pt-3" data-animate>
                            <?php if ($bio_image) : ?>
                                <div class="team-card__image">
                                    <img src="<?php echo esc_url($bio_image['url']); ?>"
                                         alt="<?php echo esc_attr($bio_image['alt'] ?: $name_text); ?>"
                                         class="img-fluid"
                                         loading="lazy" />
                                </div>
                            <?php endif; ?>
                            <div class="team-card__content pt-2">
                                <?php if (!empty($name_text)) : ?>
                                    <h3 class="team-card__name h5 fw-600 mb-1"><?php echo esc_html($name_text); ?></h3>
                                <?php endif; ?>
                                <?php if ($position) : ?>
                                    <p class="team-card__role mb-0 text-secondary"><?php echo wp_kses_post($position); ?></p>
                                <?php endif; ?>
                            </div>
                        </article>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</section>