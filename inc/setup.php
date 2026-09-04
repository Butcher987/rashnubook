<?php
/**
 * Theme setup and basic configuration
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('rashnubook_setup')) {
    function rashnubook_setup() {
        // Make theme available for translation
        load_theme_textdomain('rashnubook', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head
        add_theme_support('automatic-feed-links');

        // Let WordPress manage the document title
        add_theme_support('title-tag');

        // Enable support for Post Thumbnails on posts and pages
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(600, 800, true); // 3:4 book cover aspect ratio
        add_image_size('rashnubook-book-card', 360, 480, true);
        add_image_size('rashnubook-book-single', 500, 667, true);

        // Register navigation menus
        register_nav_menus(array(
            'primary'   => esc_html__('منوی اصلی سربرگ', 'rashnubook'),
            'category'  => esc_html__('منوی موضوعات و دسته‌بندی‌ها', 'rashnubook'),
            'mobile'    => esc_html__('منوی موبایل', 'rashnubook'),
            'footer'    => esc_html__('منوی فوتر', 'rashnubook'),
        ));

        // Switch default core markup for search form, comment form, and comments to output valid HTML5
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ));

        // Custom logo support
        add_theme_support('custom-logo', array(
            'height'      => 60,
            'width'       => 240,
            'flex-width'  => true,
            'flex-height' => true,
        ));

        // WooCommerce theme support
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');

        // Add support for responsive embeds & editor styles
        add_theme_support('responsive-embeds');
        add_theme_support('align-wide');
    }
}
add_action('after_setup_theme', 'rashnubook_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function rashnubook_content_width() {
    $GLOBALS['content_width'] = apply_filters('rashnubook_content_width', 1216);
}
add_action('after_setup_theme', 'rashnubook_content_width', 0);

/**
 * Register widget area / sidebars
 */
function rashnubook_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('سایدبار فروشگاه و کتاب‌ها', 'rashnubook'),
        'id'            => 'shop-sidebar',
        'description'   => esc_html__('ابزارک‌های این بخش در صفحه فروشگاه نمایش داده می‌شوند.', 'rashnubook'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('سایدبار وبلاگ و نقد کتاب', 'rashnubook'),
        'id'            => 'blog-sidebar',
        'description'   => esc_html__('ابزارک‌های این بخش در وبلاگ نمایش داده می‌شوند.', 'rashnubook'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'rashnubook_widgets_init');
