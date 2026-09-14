<?php
/**
 * Theme bootstrap for IT Cube Enrollment.
 *
 * @package IT_Cube_Enrollment
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Registers theme basics.
 */
function it_cube_enrollment_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'it_cube_enrollment_setup');

/**
 * Enqueues theme assets.
 */
function it_cube_enrollment_enqueue_assets()
{
    wp_enqueue_style(
        'it-cube-enrollment-style',
        get_stylesheet_uri(),
        array(),
        '1.0.0'
    );

    wp_enqueue_script(
        'it-cube-enrollment-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'it_cube_enrollment_enqueue_assets');

/**
 * Returns sanitized option value with fallback.
 */
function it_cube_enrollment_get_option($key, $fallback)
{
    $value = get_option($key);
    if (!is_string($value) || $value === '') {
        return $fallback;
    }

    return $value;
}
