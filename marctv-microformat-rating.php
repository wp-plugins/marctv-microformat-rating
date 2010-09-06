<?php

/*
  Plugin Name: MarcTV Microformat Rating
  Plugin URI: http://www.marctv.de/blog/2010/08/25/marctv-wordpress-plugins/
  Description: Adds a microformat rating markup under the article.
  Version: 1.0
  Author: Marc Tönsing
  Author URI: http://www.marctv.de
  License: GPL2
 */


/*
 * custom fields:
 *
 * rating
 *
 * rating_summary
 * 
 */

function marctv_post_add_rating_style() {
    global $wp_query;
    $this_post = $wp_query->get_queried_object();
    if (is_single($this_post)) {
        $id = $this_post->ID;
        if (function_exists('get_post_meta') && get_post_meta($id, 'rating', true) != '') {

            wp_enqueue_style(
                    "marctv-microformat-rating", WP_PLUGIN_URL . "/marctv-microformat-rating/style.css",
                    false, "1.0");
        }
    }
}

function marctv_post_add_rating($content = '') {
    global $wp_query;
    $this_post = $wp_query->get_queried_object();
    if (is_single($this_post)) {
        $id = $this_post->ID;
        if (function_exists('get_post_meta') && get_post_meta($id, 'rating', true) != '') {
            $rating_summary = get_post_meta($id, "rating_summary", true);
            $rating = get_post_meta($id, 'rating', true);
            $content .= '<div class="hreview">';
            $content .= '<span class="reviewer vcard">';
            $content .= '<span class="fn">' . get_the_author() . ' </span>';
            $content .= '</span>';
            $content .= '<span class="item">';
            $content .= '<span class="fn"><?php the_title(); ?></span> - ';
            $content .= '</span>';
            $content .= '<span class="summary">' . $rating_summary . '</span> ';
            $content .= '<div class="rating">Rating: ';
            $content .= '<span class="value">' . $rating . '</span>/';
            $content .= '<span class="best">10</span>';
            $content .= '</div> ';
            $content .= '<div class="dtreviewed">' . get_post($id)->post_date . '</div>';
            $content .= '</div>';
        }
    }
    return $content;
}

add_action('wp_print_styles', 'marctv_post_add_rating_style');
add_filter('the_content', 'marctv_post_add_rating');
?>