<?php

/**
 * ACF options page.
 *
 * Field groups live in acf-json/ and are edited in WP Admin → ACF → Field Groups.
 * Values are edited on Site settings (this options page) and on the Home page.
 */

add_action('acf/init', function () {
    if (! function_exists('acf_add_options_page')) {
        return;
    }

    acf_add_options_page([
        'page_title' => __('Site settings', 'sage'),
        'menu_title' => __('Site settings', 'sage'),
        'menu_slug' => 'pes-site',
        'capability' => 'edit_theme_options',
        'redirect' => false,
        'position' => 59,
        'icon_url' => 'dashicons-admin-site-alt3',
        'updated_message' => __('Site settings saved.', 'sage'),
    ]);
});
