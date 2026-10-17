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
get_template_part('template-parts/pain');
get_template_part('template-parts/compare');
get_template_part('template-parts/ingredients');
get_template_part('template-parts/benefits');
get_template_part('template-parts/quiz');
get_template_part('template-parts/howto');
get_template_part('template-parts/wheel');
get_template_part('template-parts/product-info');
get_template_part('template-parts/faq');
get_template_part('template-parts/form');

get_footer();
