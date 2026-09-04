<?php
/**
 * WooCommerce Custom Hooks, Product Fields, and Integration for rashnubook.ir
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check if WooCommerce is active
 */
if (!function_exists('is_woocommerce_activated')) {
    function is_woocommerce_activated() {
        return class_exists('WooCommerce');
    }
}

if (!is_woocommerce_activated()) {
    return;
}

/**
 * Remove default WooCommerce wrappers and replace with theme container
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

function rashnubook_wc_wrapper_start() {
    echo '<main id="primary" class="site-main section-padding"><div class="container">';
}
add_action('woocommerce_before_main_content', 'rashnubook_wc_wrapper_start', 10);

function rashnubook_wc_wrapper_end() {
    echo '</div></main>';
}
add_action('woocommerce_after_main_content', 'rashnubook_wc_wrapper_end', 10);

/**
 * Change WooCommerce Breadcrumbs separator
 */
add_filter('woocommerce_breadcrumb_defaults', 'rashnubook_breadcrumb_defaults');
function rashnubook_breadcrumb_defaults($defaults) {
    $defaults['delimiter'] = ' <span class="breadcrumb-separator">/</span> ';
    $defaults['wrap_before'] = '<nav class="woocommerce-breadcrumb" aria-label="' . esc_attr__('مسیر راهنما', 'rashnubook') . '">';
    $defaults['wrap_after'] = '</nav>';
    return $defaults;
}

/**
 * AJAX Cart Fragments: update cart count and total in header automatically
 */
add_filter('woocommerce_add_to_cart_fragments', 'rashnubook_cart_count_fragments');
function rashnubook_cart_count_fragments($fragments) {
    ob_start();
    $count = WC()->cart->get_cart_contents_count();
    ?>
    <span class="cart-count js-cart-count"><?php echo esc_html(rashnubook_to_persian_numbers($count)); ?></span>
    <?php
    $fragments['.js-cart-count'] = ob_get_clean();

    ob_start();
    ?>
    <span class="cart-total js-cart-total"><?php echo wp_kses_post(WC()->cart->get_cart_subtotal()); ?></span>
    <?php
    $fragments['.js-cart-total'] = ob_get_clean();

    // Update bottom mobile app bar badge
    ob_start();
    if ($count > 0) {
        echo '<span class="rb-app-cart-badge">' . esc_html(rashnubook_to_persian_numbers($count)) . '</span>';
    } else {
        echo '<span class="rb-app-cart-badge" style="display:none;"></span>';
    }
    $fragments['.rb-app-cart-badge'] = ob_get_clean();

    // Ensure mini-cart drawer content preserves wrapper classes and refreshed items
    ob_start();
    ?>
    <div class="mini-cart-items widget_shopping_cart_content">
        <?php woocommerce_mini_cart(); ?>
    </div>
    <?php
    $fragments['div.widget_shopping_cart_content'] = ob_get_clean();

    return $fragments;
}

/**
 * Add Custom Fields for Books in WooCommerce Product Data
 */
add_action('woocommerce_product_options_general_product_data', 'rashnubook_add_book_fields');
function rashnubook_add_book_fields() {
    echo '<div class="options_group" style="background:#fcfbf9; padding:10px; border-top:1px solid #ddd;">';
    echo '<h4 style="margin:0 0 10px; color:#1b4332;">' . esc_html__('مشخصات اختصاصی کتاب (قالب رشنو بوک)', 'rashnubook') . '</h4>';

    woocommerce_wp_text_input(array(
        'id'          => '_book_author',
        'label'       => esc_html__('نام نویسنده / پدیدآور', 'rashnubook'),
        'placeholder' => 'مثال: گابریل گارسیا مارکز',
        'desc_tip'    => 'true',
        'description' => esc_html__('نام نویسنده کتاب جهت نمایش در کارت و صفحه محصول', 'rashnubook'),
    ));

    woocommerce_wp_text_input(array(
        'id'          => '_book_translator',
        'label'       => esc_html__('نام مترجم', 'rashnubook'),
        'placeholder' => 'مثال: بهمن فرزانه',
    ));

    woocommerce_wp_text_input(array(
        'id'          => '_book_publisher',
        'label'       => esc_html__('ناشر', 'rashnubook'),
        'placeholder' => 'مثال: نشر رشنو / نیلوفر',
    ));

    woocommerce_wp_text_input(array(
        'id'          => '_book_isbn',
        'label'       => esc_html__('شابک (ISBN)', 'rashnubook'),
        'placeholder' => '978-964-448-032-1',
    ));

    woocommerce_wp_text_input(array(
        'id'          => '_book_pages',
        'label'       => esc_html__('تعداد صفحات', 'rashnubook'),
        'placeholder' => '۵۴۴',
    ));

    woocommerce_wp_text_input(array(
        'id'          => '_book_edition',
        'label'       => esc_html__('نوبت چاپ / نوع جلد', 'rashnubook'),
        'placeholder' => 'چاپ ۳۸ - جلد گالینگور نفیس',
    ));

    woocommerce_wp_textarea_input(array(
        'id'          => '_book_quote',
        'label'       => esc_html__('گزیده‌ای از متن یا نقد کتاب (Monograph)', 'rashnubook'),
        'placeholder' => 'متنی کوتاه و تأثیرگذار از کتاب جهت نمایش در باکس برگزیده ادبی',
    ));

    echo '</div>';
}

/**
 * Save Custom Book Fields
 */
add_action('woocommerce_process_product_meta', 'rashnubook_save_book_fields');
function rashnubook_save_book_fields($post_id) {
    $fields = array('_book_author', '_book_translator', '_book_publisher', '_book_isbn', '_book_pages', '_book_edition', '_book_quote');
    foreach ($fields as $field) {
        if (isset($_POST[$field])) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
            update_post_meta($post_id, $field, sanitize_text_field(wp_unslash($_POST[$field])));
        }
    }
}

/**
 * 100% Persian Digits Formatting across all WooCommerce Prices & Numbers
 */
function rashnubook_wc_persian_price_filter($html) {
    if (is_admin() && !wp_doing_ajax()) {
        return $html;
    }
    return rashnubook_to_persian_numbers($html);
}
add_filter('wc_price', 'rashnubook_wc_persian_price_filter', 999);
add_filter('woocommerce_get_price_html', 'rashnubook_wc_persian_price_filter', 999);
add_filter('woocommerce_format_sale_price', 'rashnubook_wc_persian_price_filter', 999);
add_filter('formatted_woocommerce_price', 'rashnubook_wc_persian_price_filter', 999);
add_filter('woocommerce_cart_item_price', 'rashnubook_wc_persian_price_filter', 999);
add_filter('woocommerce_cart_item_subtotal', 'rashnubook_wc_persian_price_filter', 999);
add_filter('woocommerce_cart_subtotal', 'rashnubook_wc_persian_price_filter', 999);
add_filter('woocommerce_cart_total', 'rashnubook_wc_persian_price_filter', 999);

/**
 * Translate "Showing" to "نمایش" on shop and archive pages
 */
function rashnubook_translate_showing_strings($translated_text, $text, $domain) {
    if ($domain === 'woocommerce' || $domain === 'default' || empty($domain)) {
        if (strpos($text, 'Showing %1$d&ndash;%2$d of %3$d result') !== false) {
            return 'نمایش %1$d تا %2$d از مجموع %3$d نتیجه';
        }
        if (strpos($text, 'Showing all %d results') !== false) {
            return 'نمایش همه %d نتیجه';
        }
        if (strpos($text, 'Showing the single result') !== false) {
            return 'نمایش تک نتیجه';
        }
        if (strpos($translated_text, 'Showing') !== false) {
            return str_replace('Showing', 'نمایش', $translated_text);
        }
        if (strpos($translated_text, 'showing') !== false) {
            return str_replace('showing', 'نمایش', $translated_text);
        }
    }
    return $translated_text;
}
add_filter('gettext', 'rashnubook_translate_showing_strings', 20, 3);
add_filter('ngettext', 'rashnubook_translate_showing_strings', 20, 3);

/**
 * Smart Product Cover Resolver:
 * Finds the image ID from:
 * 1. Product Featured Image (_thumbnail_id)
 * 2. Product Gallery (_product_image_gallery)
 * 3. Any image attached to this product (uploaded by admin while editing the product)
 * Automatically syncs _thumbnail_id if it was missing so WooCommerce core stays healthy.
 */
function rashnubook_get_product_cover_image_id($product) {
    if (!$product instanceof WC_Product) {
        $product = wc_get_product($product);
    }
    if (!$product) {
        return 0;
    }

    $image_id = (int) $product->get_image_id();
    if ($image_id && wp_attachment_is_image($image_id)) {
        return $image_id;
    }

    // Fallback 1: Check gallery image IDs
    $gallery_ids = $product->get_gallery_image_ids();
    if (!empty($gallery_ids)) {
        foreach ($gallery_ids as $gid) {
            $gid = (int) $gid;
            if ($gid && wp_attachment_is_image($gid)) {
                update_post_meta($product->get_id(), '_thumbnail_id', $gid);
                return $gid;
            }
        }
    }

    // Fallback 2: Check any image attached to this post (uploaded in editor)
    $attachments = get_posts(array(
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'post_parent'    => $product->get_id(),
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'orderby'        => 'ID',
        'order'          => 'DESC',
    ));
    if (!empty($attachments)) {
        $attached_id = (int) $attachments[0];
        if ($attached_id && wp_attachment_is_image($attached_id)) {
            update_post_meta($product->get_id(), '_thumbnail_id', $attached_id);
            return $attached_id;
        }
    }

    return 0;
}

/**
 * Auto-assign featured image on product save/update if missing.
 */
function rashnubook_auto_assign_product_image_on_save($post_id) {
    if (get_post_type($post_id) !== 'product' || wp_is_post_revision($post_id)) {
        return;
    }
    $thumb_id = get_post_thumbnail_id($post_id);
    if (!$thumb_id || !wp_attachment_is_image($thumb_id)) {
        $product = wc_get_product($post_id);
        if ($product) {
            rashnubook_get_product_cover_image_id($product);
        }
    }
}
add_action('save_post_product', 'rashnubook_auto_assign_product_image_on_save', 30);
add_action('woocommerce_process_product_meta', 'rashnubook_auto_assign_product_image_on_save', 30);

/**
 * Filter has_post_thumbnail for products to ensure uploaded images are detected.
 */
function rashnubook_filter_has_post_thumbnail($has_thumbnail, $post, $thumbnail_id) {
    if (!$has_thumbnail && $post && get_post_type($post) === 'product') {
        $product = wc_get_product($post);
        if ($product && rashnubook_get_product_cover_image_id($product) > 0) {
            return true;
        }
    }
    return $has_thumbnail;
}
add_filter('has_post_thumbnail', 'rashnubook_filter_has_post_thumbnail', 10, 3);

