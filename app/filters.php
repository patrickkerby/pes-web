<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

add_filter('nav_menu_item_id', '__return_empty_string');
add_filter('nav_menu_css_class', fn () => []);
add_filter('nav_menu_item_attributes', function (array $atts) {
    unset($atts['class']);

    return $atts;
});
add_filter('nav_menu_link_attributes', function (array $atts, $item) {
    unset($atts['class']);

    if (! empty($atts['aria-current']) && str_contains((string) $item->url, '#')) {
        unset($atts['aria-current']);
    }

    return $atts;
}, 10, 2);
