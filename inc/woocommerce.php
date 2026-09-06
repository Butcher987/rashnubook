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
    global $post;
    $product_id = $post ? $post->ID : 0;

    $current_format  = $product_id ? get_post_meta($product_id, '_book_format', true) : '';
    $current_cover   = $product_id ? get_post_meta($product_id, '_book_cover', true) : '';
    $current_edition = $product_id ? get_post_meta($product_id, '_book_edition', true) : '';

    // Fallback to WooCommerce attributes if meta empty
    if (empty($current_format) && $product_id) {
        $p = wc_get_product($product_id);
        if ($p) {
            $current_format = $p->get_attribute('قطع') ?: ($p->get_attribute('قطع کتاب') ?: $p->get_attribute('format'));
        }
    }
    if (empty($current_cover) && $product_id) {
        $p = wc_get_product($product_id);
        if ($p) {
            $current_cover = $p->get_attribute('نوع جلد') ?: ($p->get_attribute('جلد') ?: $p->get_attribute('cover'));
        }
    }
    if (empty($current_edition) && $product_id) {
        $p = wc_get_product($product_id);
        if ($p) {
            $current_edition = $p->get_attribute('نوبت چاپ') ?: ($p->get_attribute('چاپ') ?: $p->get_attribute('edition'));
        }
    }

    echo '<div class="options_group" style="background:#fcfbf9; padding:16px 14px; border-top:2px solid #1f4d3a; margin-top:16px;">';
    echo '<div style="display:flex; align-items:center; gap:8px; margin-bottom:14px;">';
    echo '<span style="font-size:18px;">📖</span>';
    echo '<h4 style="margin:0; font-size:14.5px; color:#1f4d3a; font-weight:800;">' . esc_html__('مشخصات اختصاصی کتاب (قالب رشنو بوک)', 'rashnubook') . '</h4>';
    echo '</div>';

    // 1. Author
    woocommerce_wp_text_input(array(
        'id'          => '_book_author',
        'label'       => esc_html__('نام نویسنده / پدیدآور', 'rashnubook'),
        'placeholder' => 'مثال: دکتر ناصر کاتوزیان / گابریل گارسیا مارکز',
        'desc_tip'    => 'true',
        'description' => esc_html__('نام نویسنده یا پدیدآورنده اصلی اثر', 'rashnubook'),
    ));

    // 2. Translator
    woocommerce_wp_text_input(array(
        'id'          => '_book_translator',
        'label'       => esc_html__('نام مترجم', 'rashnubook'),
        'placeholder' => 'مثال: داریوش آشوری / بهمن فرزانه',
    ));

    // 3. Publisher
    woocommerce_wp_text_input(array(
        'id'          => '_book_publisher',
        'label'       => esc_html__('ناشر', 'rashnubook'),
        'placeholder' => 'مثال: نشر میزان / نشر آگه',
    ));

    // 4. ISBN
    woocommerce_wp_text_input(array(
        'id'          => '_book_isbn',
        'label'       => esc_html__('شابک (ISBN)', 'rashnubook'),
        'placeholder' => '978-964-448-032-1',
    ));

    // 5. Pages
    woocommerce_wp_text_input(array(
        'id'          => '_book_pages',
        'label'       => esc_html__('تعداد صفحات', 'rashnubook'),
        'placeholder' => '۵۴۴',
    ));

    // 6. BOOK FORMAT (قطع کتاب) with Quick-Select Pills & Datalist
    $formats_list = array(
        'رقعی'      => 'رقعی (۱۴.۵ × ۲۱.۵ - متداول ادبیات، رمان و عمومی)',
        'وزیری'     => 'وزیری (۱۷ × ۲۴ - متداول کتب حقوقی، دانشگاهی و مرجع)',
        'رحلی'      => 'رحلی (۲۱ × ۲۸ - مجلات، کتب آزمونی و قطع بزرگ)',
        'جیبی'      => 'جیبی (۱۱ × ۱۵ - کوچک و همراه)',
        'پالتویی'   => 'پالتویی (۱۲ × ۲۰ - بلند و باریک)',
        'خشتی'      => 'خشتی (۲۰ × ۲۰ - مربعی نفیس)',
        'سلطانی'    => 'سلطانی (۳۰ × ۴۰ - بسیار بزرگ و نفیس)',
        'رحلی بزرگ' => 'رحلی بزرگ (۲۴ × ۳۴)',
    );
    ?>
    <p class="form-field _book_format_field" style="background:#f4f7f5; padding:12px 14px; border-radius:8px; border:1px solid #d8e5df; margin:10px 0;">
        <label for="_book_format" style="font-weight:800; color:#1f4d3a;"><?php esc_html_e('قطع کتاب:', 'rashnubook'); ?></label>
        <span class="wrap" style="display:inline-block; vertical-align:top; max-width:650px;">
            <input type="text" class="short" style="min-width:280px; font-weight:700; font-size:13.5px;" name="_book_format" id="_book_format" value="<?php echo esc_attr($current_format); ?>" placeholder="انتخاب قطع از دکمه‌های زیر یا تایپ دستی..." list="rb_format_datalist">
            <datalist id="rb_format_datalist">
                <?php foreach ($formats_list as $f_val => $f_desc) : ?>
                    <option value="<?php echo esc_attr($f_val); ?>"><?php echo esc_html($f_desc); ?></option>
                <?php endforeach; ?>
            </datalist>
            <span class="description" style="display:block; margin:6px 0 6px; color:#4a5568; font-size:12px;">
                💡 <strong>انتخاب سریع قطع کتاب:</strong> روی هر یک از گزینه‌های زیر کلیک کنید تا سریعاً درج شود:
            </span>
            <span class="rb-preset-pills" style="display:inline-flex; gap:6px; flex-wrap:wrap; margin-top:2px;">
                <?php foreach ($formats_list as $f_val => $f_desc) :
                    $is_selected = ($current_format === $f_val);
                ?>
                    <button type="button" class="button button-small rb-set-format-btn" data-val="<?php echo esc_attr($f_val); ?>" style="<?php echo $is_selected ? 'background:#1f4d3a !important; color:#fff !important; border-color:#1f4d3a !important; font-weight:bold;' : 'background:#fff; color:#1f4d3a; border-color:#b5cec3; font-weight:600;'; ?>">
                        <?php echo esc_html($f_val); ?>
                    </button>
                <?php endforeach; ?>
            </span>
        </span>
    </p>
    <?php

    // 7. BOOK COVER (نوع جلد) with Quick-Select Pills & Datalist
    $covers_list = array(
        'شومیز'           => 'شومیز (جلد نرم / معمولی)',
        'گالینگور'         => 'گالینگور (جلد سخت مقوایی)',
        'گالینگور زرکوب'  => 'گالینگور زرکوب نفیس',
        'جلد سخت (سلفون)' => 'جلد سخت سلفونی',
        'شومیز مات'       => 'شومیز مات اعلا',
        'چرمی'            => 'چرمی لوکس و نفیس',
        'سیمی'            => 'سیمی / فنری',
    );
    ?>
    <p class="form-field _book_cover_field" style="background:#faf6f2; padding:12px 14px; border-radius:8px; border:1px solid #ebdcd0; margin:10px 0;">
        <label for="_book_cover" style="font-weight:800; color:#844a27;"><?php esc_html_e('نوع جلد:', 'rashnubook'); ?></label>
        <span class="wrap" style="display:inline-block; vertical-align:top; max-width:650px;">
            <input type="text" class="short" style="min-width:280px; font-weight:700; font-size:13.5px;" name="_book_cover" id="_book_cover" value="<?php echo esc_attr($current_cover); ?>" placeholder="مثال: شومیز / گالینگور نفیس" list="rb_cover_datalist">
            <datalist id="rb_cover_datalist">
                <?php foreach ($covers_list as $c_val => $c_desc) : ?>
                    <option value="<?php echo esc_attr($c_val); ?>"><?php echo esc_html($c_desc); ?></option>
                <?php endforeach; ?>
            </datalist>
            <span class="description" style="display:block; margin:6px 0 6px; color:#4a5568; font-size:12px;">
                💡 <strong>انتخاب سریع نوع جلد:</strong>
            </span>
            <span class="rb-preset-pills" style="display:inline-flex; gap:6px; flex-wrap:wrap; margin-top:2px;">
                <?php foreach ($covers_list as $c_val => $c_desc) :
                    $is_selected = ($current_cover === $c_val);
                ?>
                    <button type="button" class="button button-small rb-set-cover-btn" data-val="<?php echo esc_attr($c_val); ?>" style="<?php echo $is_selected ? 'background:#844a27 !important; color:#fff !important; border-color:#844a27 !important; font-weight:bold;' : 'background:#fff; color:#844a27; border-color:#dfc0aa; font-weight:600;'; ?>">
                        <?php echo esc_html($c_val); ?>
                    </button>
                <?php endforeach; ?>
            </span>
        </span>
    </p>
    <?php

    // 8. BOOK EDITION (نوبت چاپ) with Quick-Select Pills & Datalist
    $editions_list = array(
        'چاپ اول',
        'چاپ دوم',
        'چاپ سوم',
        'چاپ چهارم',
        'چاپ پنجم',
        'چاپ دهم',
        'چاپ جدید (۱۴۰۳)',
        'چاپ جدید (۱۴۰۴)',
        'چاپ نفیس با قاب',
    );
    ?>
    <p class="form-field _book_edition_field" style="background:#f8f9fa; padding:12px 14px; border-radius:8px; border:1px solid #dee2e6; margin:10px 0;">
        <label for="_book_edition" style="font-weight:800; color:#495057;"><?php esc_html_e('نوبت چاپ:', 'rashnubook'); ?></label>
        <span class="wrap" style="display:inline-block; vertical-align:top; max-width:650px;">
            <input type="text" class="short" style="min-width:280px; font-weight:700; font-size:13.5px;" name="_book_edition" id="_book_edition" value="<?php echo esc_attr($current_edition); ?>" placeholder="مثال: چاپ اول / چاپ ۳۸" list="rb_edition_datalist">
            <datalist id="rb_edition_datalist">
                <?php foreach ($editions_list as $ed_val) : ?>
                    <option value="<?php echo esc_attr($ed_val); ?>"><?php echo esc_html($ed_val); ?></option>
                <?php endforeach; ?>
            </datalist>
            <span class="description" style="display:block; margin:6px 0 6px; color:#4a5568; font-size:12px;">
                💡 <strong>انتخاب سریع نوبت چاپ:</strong>
            </span>
            <span class="rb-preset-pills" style="display:inline-flex; gap:6px; flex-wrap:wrap; margin-top:2px;">
                <?php foreach ($editions_list as $ed_val) :
                    $is_selected = ($current_edition === $ed_val);
                ?>
                    <button type="button" class="button button-small rb-set-edition-btn" data-val="<?php echo esc_attr($ed_val); ?>" style="<?php echo $is_selected ? 'background:#343a40 !important; color:#fff !important; border-color:#343a40 !important; font-weight:bold;' : 'background:#fff; color:#495057; border-color:#ced4da; font-weight:600;'; ?>">
                        <?php echo esc_html($ed_val); ?>
                    </button>
                <?php endforeach; ?>
            </span>
        </span>
    </p>
    <?php

    // 9. Monograph Quote
    woocommerce_wp_textarea_input(array(
        'id'          => '_book_quote',
        'label'       => esc_html__('گزیده‌ای از متن یا نقد اثر', 'rashnubook'),
        'placeholder' => 'متنی کوتاه و تأثیرگذار از کتاب جهت نمایش در کادر اختصاصی صفحه اثر',
    ));

    // Inline JS for instant 1-click presets
    ?>
    <script>
    (function() {
        document.addEventListener('click', function(e) {
            if (e.target.matches('.rb-set-format-btn')) {
                e.preventDefault();
                var val = e.target.getAttribute('data-val');
                var input = document.getElementById('_book_format');
                if (input) {
                    input.value = val;
                    document.querySelectorAll('.rb-set-format-btn').forEach(function(b) {
                        b.style.setProperty('background', '#fff', 'important');
                        b.style.setProperty('color', '#1f4d3a', 'important');
                        b.style.setProperty('border-color', '#b5cec3', 'important');
                        b.style.setProperty('font-weight', '600', 'important');
                    });
                    e.target.style.setProperty('background', '#1f4d3a', 'important');
                    e.target.style.setProperty('color', '#fff', 'important');
                    e.target.style.setProperty('border-color', '#1f4d3a', 'important');
                    e.target.style.setProperty('font-weight', 'bold', 'important');
                }
            }
            if (e.target.matches('.rb-set-cover-btn')) {
                e.preventDefault();
                var val = e.target.getAttribute('data-val');
                var input = document.getElementById('_book_cover');
                if (input) {
                    input.value = val;
                    document.querySelectorAll('.rb-set-cover-btn').forEach(function(b) {
                        b.style.setProperty('background', '#fff', 'important');
                        b.style.setProperty('color', '#844a27', 'important');
                        b.style.setProperty('border-color', '#dfc0aa', 'important');
                        b.style.setProperty('font-weight', '600', 'important');
                    });
                    e.target.style.setProperty('background', '#844a27', 'important');
                    e.target.style.setProperty('color', '#fff', 'important');
                    e.target.style.setProperty('border-color', '#844a27', 'important');
                    e.target.style.setProperty('font-weight', 'bold', 'important');
                }
            }
            if (e.target.matches('.rb-set-edition-btn')) {
                e.preventDefault();
                var val = e.target.getAttribute('data-val');
                var input = document.getElementById('_book_edition');
                if (input) {
                    input.value = val;
                    document.querySelectorAll('.rb-set-edition-btn').forEach(function(b) {
                        b.style.setProperty('background', '#fff', 'important');
                        b.style.setProperty('color', '#495057', 'important');
                        b.style.setProperty('border-color', '#ced4da', 'important');
                        b.style.setProperty('font-weight', '600', 'important');
                    });
                    e.target.style.setProperty('background', '#343a40', 'important');
                    e.target.style.setProperty('color', '#fff', 'important');
                    e.target.style.setProperty('border-color', '#343a40', 'important');
                    e.target.style.setProperty('font-weight', 'bold', 'important');
                }
            }
        });
    })();
    </script>
    <?php
    echo '</div>';
}

/**
 * Save Custom Book Fields
 */
add_action('woocommerce_process_product_meta', 'rashnubook_save_book_fields');
function rashnubook_save_book_fields($post_id) {
    $fields = array(
        '_book_author',
        '_book_translator',
        '_book_publisher',
        '_book_isbn',
        '_book_pages',
        '_book_format',
        '_book_cover',
        '_book_edition',
        '_book_quote',
    );
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

/**
 * Helper to check if WooCommerce cart contains any magazine/journal product
 */
function rashnubook_cart_has_magazine() {
    if (!function_exists('WC') || !WC()->cart) {
        return false;
    }
    foreach (WC()->cart->get_cart() as $cart_item) {
        $product = $cart_item['data'] ?? null;
        if (!$product) {
            continue;
        }
        $title = mb_strtolower($product->get_name(), 'UTF-8');
        if (strpos($title, 'ماهنامه') !== false || strpos($title, 'مجله') !== false || strpos($title, 'آفتابگردان') !== false || strpos($title, 'اشتراک') !== false) {
            return true;
        }
        $term_ids = $product->get_category_ids();
        foreach ($term_ids as $tid) {
            $term = get_term($tid, 'product_cat');
            if ($term && !is_wp_error($term)) {
                $tslug = strtolower($term->slug);
                $tname = mb_strtolower($term->name, 'UTF-8');
                if (strpos($tslug, 'magazine') !== false || strpos($tslug, 'journal') !== false || strpos($tname, 'مجله') !== false || strpos($tname, 'ماهنامه') !== false) {
                    return true;
                }
            }
        }
    }
    return false;
}

/**
 * Add Telegram ID field to WooCommerce Checkout
 */
function rashnubook_add_telegram_checkout_field($fields) {
    $rule = rashnubook_get_option('checkout_telegram_field_rule', 'magazine');
    if ($rule === '0') {
        return $fields;
    }

    $is_required = ($rule === 'always') || ($rule === 'magazine' && rashnubook_cart_has_magazine());

    $fields['billing']['billing_telegram_id'] = array(
        'type'        => 'text',
        'label'       => __('آیدی یا شماره تلگرام', 'rashnubook'),
        'placeholder' => __('@username یا ۰۹۱۲...', 'rashnubook'),
        'required'    => $is_required,
        'class'       => array('form-row-wide'),
        'clear'       => true,
        'priority'    => 25,
        'description' => __('جهت عضویت در کانال اختصاصی مشترکین و هماهنگی ارسال ضمائم ماهنامه', 'rashnubook'),
    );

    return $fields;
}
add_filter('woocommerce_checkout_fields', 'rashnubook_add_telegram_checkout_field', 20);

/**
 * Validate Telegram ID field on checkout submission
 */
function rashnubook_validate_telegram_checkout_field() {
    $rule = rashnubook_get_option('checkout_telegram_field_rule', 'magazine');
    if ($rule === '0') {
        return;
    }
    $is_required = ($rule === 'always') || ($rule === 'magazine' && rashnubook_cart_has_magazine());
    if ($is_required && empty($_POST['billing_telegram_id'])) {
        wc_add_notice(__('<strong>آیدی تلگرام</strong> برای سفارش ماهنامه الزامی است. لطفاً آیدی یا شماره تلگرام خود را وارد نمایید.', 'rashnubook'), 'error');
    }
}
add_action('woocommerce_checkout_process', 'rashnubook_validate_telegram_checkout_field');

/**
 * Save Telegram ID in WooCommerce Order Meta
 */
function rashnubook_save_telegram_checkout_field($order_id) {
    if (!empty($_POST['billing_telegram_id'])) {
        update_post_meta($order_id, '_billing_telegram_id', sanitize_text_field($_POST['billing_telegram_id']));
    }
}
add_action('woocommerce_checkout_update_order_meta', 'rashnubook_save_telegram_checkout_field');

/**
 * Display Telegram ID in Admin Order View
 */
function rashnubook_display_telegram_in_admin_order($order) {
    $telegram = $order->get_meta('_billing_telegram_id');
    if (!empty($telegram)) {
        echo '<p><strong>' . esc_html__('آیدی تلگرام مشتری:', 'rashnubook') . '</strong> <span dir="ltr" style="background:#f1f5f9; padding:2px 8px; border-radius:4px; font-weight:700;">' . esc_html($telegram) . '</span></p>';
    }
}
add_action('woocommerce_admin_order_data_after_billing_address', 'rashnubook_display_telegram_in_admin_order');

/**
 * Display Telegram ID in Thank You / Order Received page
 */
function rashnubook_display_telegram_in_order_received($order) {
    $telegram = $order->get_meta('_billing_telegram_id');
    if (!empty($telegram)) {
        echo '<p style="margin-top:10px;"><strong>' . esc_html__('آیدی تلگرام ثبت‌شده:', 'rashnubook') . '</strong> <span dir="ltr">' . esc_html($telegram) . '</span></p>';
    }
}
add_action('woocommerce_order_details_after_customer_details', 'rashnubook_display_telegram_in_order_received');

/**
 * Display Telegram ID in Customer & Admin Emails
 */
function rashnubook_display_telegram_in_emails($order, $sent_to_admin, $plain_text, $email) {
    $telegram = $order->get_meta('_billing_telegram_id');
    if (!empty($telegram)) {
        echo '<p><strong>' . esc_html__('آیدی تلگرام خریدار', 'rashnubook') . ':</strong> ' . esc_html($telegram) . '</p>';
    }
}
add_action('woocommerce_email_customer_details', 'rashnubook_display_telegram_in_emails', 30, 4);

/**
 * Force classic shortcodes for Cart & Checkout to ensure theme templates
 * (woocommerce/cart/cart.php and woocommerce/checkout/form-checkout.php)
 * are always utilized, and prevent Gutenberg Block static English fallbacks.
 */
function rashnubook_force_classic_cart_checkout($content) {
    if (is_admin() || wp_doing_ajax()) {
        return $content;
    }

    if (function_exists('is_cart') && is_cart() && !is_checkout()) {
        if (has_block('woocommerce/cart') || strpos($content, 'wp:woocommerce/cart') !== false || strpos($content, 'wp-block-woocommerce-cart') !== false) {
            return do_shortcode('[woocommerce_cart]');
        }
    }

    if (function_exists('is_checkout') && is_checkout() && !is_order_received_page()) {
        if (has_block('woocommerce/checkout') || strpos($content, 'wp:woocommerce/checkout') !== false || strpos($content, 'wp-block-woocommerce-checkout') !== false) {
            return do_shortcode('[woocommerce_checkout]');
        }
    }

    return $content;
}
add_filter('the_content', 'rashnubook_force_classic_cart_checkout', 5);

/**
 * Ensure empty cart notice is always localized in Persian
 */
add_filter('wc_empty_cart_message', function($message) {
    return __('سبد خرید شما در حال حاضر خالی است.', 'rashnubook');
});



