<?php
/**
 * Master functions and definitions for rashnubook.ir
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

define('RASHNUBOOK_VERSION', '1.3.0');
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
        'nonce'    => wp_create_nonce('rashnubook_ajax_nonce'),
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
                    $author = get_post_meta($post_id, '_book_author', true);
                    if (empty($author)) {
                        $author = get_post_meta($post_id, '_rashnubook_author', true);
                    }
                    if (empty($author) && method_exists($product, 'get_attribute')) {
                        $author = $product->get_attribute('author') ?: $product->get_attribute('نویسنده');
                    }
                    if (empty($author)) {
                        $pub = get_post_meta($post_id, '_book_publisher', true);
                        if (!empty($pub)) {
                            $author = 'نشر: ' . $pub;
                        }
                    }
                }
                // Never fallback to get_the_author() (WordPress user) for books
            } else {
                $author = get_the_author();
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
                'author'    => $author,
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
 * Ajax Newsletter Subscription Handler
 */
function rashnubook_ajax_newsletter_signup() {
    check_ajax_referer('rashnubook_ajax_nonce', 'nonce');

    $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';

    if (empty($email) || !is_email($email)) {
        wp_send_json_error(array('message' => 'لطفاً یک نشانی ایمیل معتبر وارد فرمایید.'));
    }

    $subscribers = get_option('rashnubook_newsletter_subscribers', array());
    if (!is_array($subscribers)) {
        $subscribers = array();
    }

    // Check if already subscribed
    foreach ($subscribers as $sub) {
        if (isset($sub['email']) && strtolower($sub['email']) === strtolower($email)) {
            wp_send_json_success(array('message' => 'نشانی ایمیل شما قبلاً در خبرنامه ثبت شده است. سپاس از همراهی شما!'));
        }
    }

    $subscribers[] = array(
        'email' => $email,
        'date'  => current_time('mysql'),
        'ip'    => sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? ''),
    );

    update_option('rashnubook_newsletter_subscribers', $subscribers);

    wp_send_json_success(array('message' => 'عضویت شما در خبرنامه با موفقیت ثبت شد. از همراهی شما متشکریم!'));
}
add_action('wp_ajax_rashnubook_newsletter_signup', 'rashnubook_ajax_newsletter_signup');
add_action('wp_ajax_nopriv_rashnubook_newsletter_signup', 'rashnubook_ajax_newsletter_signup');

/**
 * Virtual route / template loader for /categories/ and /blog/
 */
function rashnubook_template_virtual_routes() {
    $req = trim($_SERVER['REQUEST_URI'] ?? '', '/');
    $req_path = parse_url($req, PHP_URL_PATH);
    $req_path = trim((string)$req_path, '/');

    // Categories page
    if ($req_path === 'categories' || preg_match('/(^|\/)categories$/', $req_path) || get_query_var('pagename') === 'categories') {
        $template = locate_template('page-categories.php');
        if ($template) {
            status_header(200);
            include $template;
            exit;
        }
    }

    // Blog / Articles archive
    if ($req_path === 'blog' || preg_match('/(^|\/)blog$/', $req_path) || get_query_var('pagename') === 'blog' || (isset($_GET['post_type']) && $_GET['post_type'] === 'post')) {
        $template = locate_template('home.php');
        if ($template) {
            status_header(200);
            include $template;
            exit;
        }
    }
}
add_action('template_redirect', 'rashnubook_template_virtual_routes', 5);


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

