 <?php

    $heading = get_field('heading') ? get_field('heading') : '';


    ?>

 <!-- start section -->
 <section class="component--cards-team">
     <div class="container pb-5">
         <div class="row justify-content-center mb-3 md-mb-8">
             <div class="col-lg-7 text-center" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 200, "easing": "easeOutQuad" }'>
                 <span class="fs-17 d-inline-block fw-500 text-uppercase text-base-color ls-1px">We help our clients market smarter</span>
                 <h1 class="alt-font text-dark-gray fw-600 ls-minus-1px"><?php echo $heading; ?></h1>
             </div>
         </div>
         <div class="row row-cols-1 row-cols-xl-4 row-cols-lg-3 row-cols-sm-2 justify-content-center" data-anime='{ "el": "childs", "translateY": [0, 0], "perspective": [800,800], "scale": [1.1, 1], "rotateX": [30, 0], "opacity": [0,1], "duration": 800, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>
             <?php
                if (have_rows('card_repeater')) :

                    while (have_rows('card_repeater')) : the_row();
                        $bio_image = get_sub_field('bio_image') ? get_sub_field('bio_image') : '';
                        $team_member_name = get_sub_field('team_member_name') ? get_sub_field('team_member_name') : '';
                        $position = get_sub_field('position');

                ?>

                     <!-- start team member item -->
                     <div class="col text-center team-style-05 mb-40px sm-mb-35px">
                         <div class="position-relative mb-25px last-paragraph-no-margin">
                             <?php if ($bio_image) : ?>
                                 <img src="<?php echo esc_url($bio_image['url']); ?>" alt="<?php echo esc_attr($bio_image['alt']); ?>" />
                             <?php endif; ?>

                             <!-- <div class="w-100 h-100 d-flex flex-column justify-content-end align-items-center p-40px lg-p-30px team-content bg-gradient-light-brown-transparent">
                                 <p class="text-white lh-32 w-70 xl-w-80 md-w-65 xs-w-60 absolute-middle-center opacity-7">Started working for MediaFast in 1999 and purchased the company in 2013</p>

                             </div> -->
                         </div>
                         <div class="alt-font fw-500 text-dark-gray lh-28 fs-20"><?php echo $team_member_name['title']; ?></div>
                         <span><?php echo $position; ?></span>
                     </div>
                     <!-- end team member item -->
             <?php
                    endwhile;
                endif;
                ?>
         </div>
 </section>
 <!-- end section -->