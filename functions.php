<?php
/**
 * Master functions and definitions for rashnubook.ir
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

define('RASHNUBOOK_VERSION', '1.0.3');
define('RASHNUBOOK_DIR', get_template_directory());
define('RASHNUBOOK_URI', get_template_directory_uri());

/**
 * Require Inc modules
 */
require_once RASHNUBOOK_DIR . '/inc/setup.php';
require_once RASHNUBOOK_DIR . '/inc/template-tags.php';
require_once RASHNUBOOK_DIR . '/inc/woocommerce.php';
require_once RASHNUBOOK_DIR . '/inc/landing-helpers.php';
require_once RASHNUBOOK_DIR . '/inc/customizer.php';
require_once RASHNUBOOK_DIR . '/inc/admin-panel.php';

/**
 * Enqueue scripts and styles.
 * Super clean, minimal footprint like Bento/Tento.
 */
function rashnubook_scripts() {
    // 1. Vazirmatn Webfont (local woff2)
    wp_enqueue_style(
        'rashnubook-vazirmatn',
        RASHNUBOOK_URI . '/assets/css/vazirmatn.css',
        array(),
        RASHNUBOOK_VERSION
    );

    // 2. Core Theme Stylesheet
    wp_enqueue_style(
        'rashnubook-style',
        get_stylesheet_uri(),
        array('rashnubook-vazirmatn'),
        RASHNUBOOK_VERSION
    );

    // 3. Editorial Layout and Components
    wp_enqueue_style(
        'rashnubook-main',
        RASHNUBOOK_URI . '/assets/css/main.css',
        array('rashnubook-style'),
        RASHNUBOOK_VERSION
    );

    // 4. WooCommerce styling if active
    if (class_exists('WooCommerce')) {
        wp_enqueue_style(
            'rashnubook-woocommerce',
            RASHNUBOOK_URI . '/assets/css/woocommerce.css',
            array('rashnubook-main'),
            RASHNUBOOK_VERSION
        );
    }

        // 5. Lightweight Vanilla JavaScript (deferred)
    wp_enqueue_script(
        'rashnubook-main-js',
        RASHNUBOOK_URI . '/assets/js/main.js',
        array(),
        RASHNUBOOK_VERSION,
        true // in footer
    );

    wp_localize_script('rashnubook-main-js', 'rashnubook_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));

    // Threaded comments script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'rashnubook_scripts');

/**
 * Live Ajax Search for Books and Articles
 */
function rashnubook_ajax_search() {
    $term = isset($_GET['term']) ? sanitize_text_field(wp_unslash($_GET['term'])) : '';
    if (empty($term) || mb_strlen($term) < 2) {
        wp_send_json_success(array('results' => array()));
    }

    $args = array(
        'post_type'      => array('product', 'post'),
        'post_status'    => 'publish',
        'posts_per_page' => 8,
        's'              => $term,
    );

    $query = new WP_Query($args);
    $results = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $is_product = (get_post_type() === 'product');
            $price_str = '';
            $author = '';

            if ($is_product && function_exists('wc_get_product')) {
                $product = wc_get_product($post_id);
                if ($product) {
                    $price_str = $product->get_price_html();
                }
                $author = get_post_meta($post_id, '_rashnubook_author', true);
            }

            $img_url = get_the_post_thumbnail_url($post_id, 'thumbnail');
            if (!$img_url) {
                $img_url = RASHNUBOOK_URI . '/assets/images/rashnu-logo.jpg';
            }

            $results[] = array(
                'id'        => $post_id,
                'title'     => get_the_title(),
                'url'       => get_permalink(),
                'is_book'   => $is_product,
                'type'      => $is_product ? 'کتاب' : 'یادداشت ادبی',
                'author'    => $author ? $author : (get_the_author()),
                'price'     => $price_str,
                'thumbnail' => $img_url,
            );
        }
        wp_reset_postdata();
    }

    wp_send_json_success(array('results' => $results));
}
add_action('wp_ajax_rashnubook_ajax_search', 'rashnubook_ajax_search');
add_action('wp_ajax_nopriv_rashnubook_ajax_search', 'rashnubook_ajax_search');

/**
 * Add defer attribute to theme script for faster loading
 */
function rashnubook_defer_scripts($tag, $handle, $src) {
    if ('rashnubook-main-js' === $handle) {
        return '<script src="' . esc_url($src) . '" id="' . esc_attr($handle) . '-js" defer></script>' . "\n";
    }
    return $tag;
}
add_filter('script_loader_tag', 'rashnubook_defer_scripts', 10, 3);

