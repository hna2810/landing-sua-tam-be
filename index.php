<?php
/**
 * Main Template File
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

get_template_part('template-parts/hero');
get_template_part('template-parts/marquee');
get_template_part('template-parts/wish');
get_template_part('template-parts/compare');
get_template_part('template-parts/ingredients');
get_template_part('template-parts/uses');
get_template_part('template-parts/benefits');
get_template_part('template-parts/howto');
get_template_part('template-parts/ugc');
get_template_part('template-parts/moms');
get_template_part('template-parts/stores');
get_template_part('template-parts/product-info');
get_template_part('template-parts/calculator');
get_template_part('template-parts/wheel');
get_template_part('template-parts/form');
get_template_part('template-parts/reviews');
get_template_part('template-parts/faq');
get_template_part('template-parts/story');

get_footer();
