<?php
/**
 * Dedicated Rashnu Bookstore Admin Settings Panel
 * Modern modular management for Rashnu Bookstore & Publisher
 * Inspired by Bento & Tento architecture
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Admin Menu for RashnuBook Settings
 */
function rashnubook_add_admin_menu() {
    add_menu_page(
        esc_html__('تنظیمات رشنو بوک', 'rashnubook'),
        esc_html__('تنظیمات رشنو بوک', 'rashnubook'),
        'manage_options',
        'rashnubook-settings',
        'rashnubook_render_settings_page',
        'dashicons-book-alt',
        59
    );
}
add_action('admin_menu', 'rashnubook_add_admin_menu');

/**
 * Enqueue scripts and styles for RashnuBook admin panel
 */
function rashnubook_admin_assets($hook) {
    if ('toplevel_page_rashnubook-settings' !== $hook) {
        return;
    }

    wp_enqueue_style(
        'rashnubook-admin-panel',
        get_template_directory_uri() . '/assets/css/admin-panel.css',
        array(),
        RASHNUBOOK_VERSION
    );

    // Enqueue Vazirmatn in admin panel for unified typography
    wp_enqueue_style(
        'rashnubook-vazirmatn',
        get_template_directory_uri() . '/assets/css/vazirmatn.css',
        array(),
        RASHNUBOOK_VERSION
    );
}
add_action('admin_enqueue_scripts', 'rashnubook_admin_assets');

/**
 * Helper function to retrieve options with fallback
 */
function rashnubook_get_option($key, $default = '') {
    $options = get_option('rashnubook_options', array());
    if (is_array($options) && array_key_exists($key, $options)) {
        return $options[$key];
    }
    // Fallback to theme_mods or default
    return get_theme_mod('rashnubook_' . $key, $default);
}

/**
 * Helper to fetch all WooCommerce products for selector dropdown
 */
function rashnubook_get_products_list() {
    $list = array();
    if (class_exists('WooCommerce')) {
        $posts = get_posts(array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => 120,
            'orderby'        => 'title',
            'order'          => 'ASC',
        ));
        foreach ($posts as $p) {
            $list[$p->ID] = $p->post_title . ' (شناسه: ' . $p->ID . ')';
        }
    }
    return $list;
}

/**
 * Helper to fetch all WooCommerce product categories for selector dropdown
 */
function rashnubook_get_product_categories_list() {
    $cats = array();
    if (taxonomy_exists('product_cat')) {
        $terms = get_terms(array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
        ));
        if (!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $t) {
                $cats[$t->slug] = $t->name . ' (' . rashnubook_to_persian_numbers($t->count) . ' کتاب)';
            }
        }
    }
    return $cats;
}

/**
 * Resolves slide configuration merging product data, overrides, and fallbacks
 */
function rashnubook_resolve_slide_data($index, $raw_slide) {
    $product_id = !empty($raw_slide['product_id']) ? (int)$raw_slide['product_id'] : 0;
    $product    = null;
    if ($product_id > 0 && class_exists('WooCommerce')) {
        $product = wc_get_product($product_id);
    }

    $defaults = array(
        1 => array(
            'product_id'  => 812,
            'badge'       => 'مرجع شماره ۱ آزمون وکالت، قضاوت و سردفتری',
            'title'       => 'قانون مدنی در نظم حقوقی کنونی',
            'meta'        => 'تألیف: استاد فرزانه زنده‌یاد دکتر ناصر کاتوزیان | انتشارات میزان',
            'desc'        => 'معتبرترین و جامع‌ترین اثر در شرح تک‌تک مواد قانون مدنی ایران به همراه آخرین آرای وحدت رویه دیوان عالی کشور، نظرات دکترین حقوقی و تطبیق با فقه امامیه؛ منبع طلایی آزمون‌های حقوقی.',
            'old_price'   => '750000',
            'price'       => '680000',
            'discount'    => '10',
            'btn1_text'   => 'خرید با ارسال رایگان پستی',
            'btn1_url'    => '',
            'btn2_text'   => 'مشاهده بسته آزمونی',
            'btn2_url'    => home_url('/landing/'),
            'edition'     => 'چاپ ۶۲ نفیس',
            'pages'       => '۸۲۰ صفحه',
            'publisher'   => 'نشر میزان / رشنو بوک',
            'bg_gradient' => 'linear-gradient(135deg, #1F4D3A 0%, #153628 100%)',
            'spine_color' => '#142c20',
        ),
        2 => array(
            'product_id'  => 817,
            'badge'       => 'شاهکار جاویدان ادبیات جهان • برنده جایزه نوبل',
            'title'       => 'صد سال تنهایی',
            'meta'        => 'گابریل گارسیا مارکز • ترجمه بهمن فرزانه | چاپ نفیس گالینگور',
            'desc'        => 'روایتی شگفت‌انگیز از هفت نسل خاندان بوئندیا در دهکده خیالی ماکوندو؛ حماسه‌ای از عشق، جادو، تاریخ و تنهایی که قله رئالیسم جادویی جهان را فتح کرد.',
            'old_price'   => '450000',
            'price'       => '385000',
            'discount'    => '15',
            'btn1_text'   => 'خرید نسخه جلد سخت',
            'btn1_url'    => '',
            'btn2_text'   => 'کاتالوگ رمان‌های جهان',
            'btn2_url'    => '',
            'edition'     => 'چاپ ۳۸',
            'pages'       => '۵۴۴ صفحه',
            'publisher'   => 'کتابفروشی آنلاین رَشن',
            'bg_gradient' => 'linear-gradient(135deg, #FAF7F2 0%, #EFE7D8 100%)',
            'spine_color' => '#cfbe9f',
        ),
        3 => array(
            'product_id'  => 823,
            'badge'       => 'شاهکار فلسفه، اندیشه و خرد مدرن',
            'title'       => 'چنین گفت زرتشت',
            'meta'        => 'فردریش نیچه • ترجمه داریوش آشوری | نشر آگه / رشنو بوک',
            'desc'        => '«انسان پلی است میان حیوان و ابرانسان؛ پلی بر فراز ورطه‌ای دهشتناک.» متنی فلسفی و شاعرانه در تبیین اراده معطوف به قدرت، نقد ارزش‌های کهن و زایش معنای نو در جهان اندیشه.',
            'old_price'   => '420000',
            'price'       => '380000',
            'discount'    => '10',
            'btn1_text'   => 'خرید کتاب فلسفی',
            'btn1_url'    => '',
            'btn2_text'   => 'کتاب‌های فلسفه و اندیشه',
            'btn2_url'    => '',
            'edition'     => 'چاپ ویژه',
            'pages'       => '۴۲۰ صفحه',
            'publisher'   => 'نشر آگه / رشنو',
            'bg_gradient' => 'linear-gradient(135deg, #3B2F2F 0%, #261e1e 100%)',
            'spine_color' => '#1d1717',
        ),
    );

    $fallback = $defaults[$index] ?? array(
        'product_id'  => 0,
        'badge'       => 'کتاب برگزیده و ویژه انتشارات',
        'title'       => 'عنوان کتاب برگزیده',
        'meta'        => 'نویسنده و مشخصات نشر',
        'desc'        => 'توضیحات معرفی و گزیده‌ای از کتاب جهت نمایش در ویترین اصلی کتاب‌سرای رشنو.',
        'old_price'   => '',
        'price'       => '',
        'discount'    => '',
        'btn1_text'   => 'خرید با ارسال رایگان پستی',
        'btn1_url'    => '',
        'btn2_text'   => 'مشاهده جزییات',
        'btn2_url'    => '',
        'edition'     => 'چاپ نفیس',
        'pages'       => '',
        'publisher'   => 'کتابفروشی آنلاین رَشن',
        'bg_gradient' => 'linear-gradient(135deg, #1b4332 0%, #012d1d 100%)',
        'spine_color' => '#142c20',
    );

    $resolved = array();
    $resolved['product_id'] = $product_id ?: ($fallback['product_id'] ?? 0);
    $resolved['enabled']    = isset($raw_slide['enabled']) ? ($raw_slide['enabled'] === '1' || $raw_slide['enabled'] === true) : ($index <= 3);

    // Title
    if (!empty($raw_slide['title'])) {
        $resolved['title'] = $raw_slide['title'];
    } elseif ($product) {
        $resolved['title'] = $product->get_name();
    } else {
        $resolved['title'] = $fallback['title'];
    }

    // Badge
    $resolved['badge'] = !empty($raw_slide['badge']) ? $raw_slide['badge'] : $fallback['badge'];

    // Meta (Author & Publisher)
    if (!empty($raw_slide['meta'])) {
        $resolved['meta'] = $raw_slide['meta'];
    } elseif ($product) {
        $attrs = function_exists('rashnubook_get_book_attributes') ? rashnubook_get_book_attributes($product_id) : array();
        $meta_parts = array();
        if (!empty($attrs['author'])) {
            $meta_parts[] = 'پدیدآور: ' . $attrs['author'];
        }
        if (!empty($attrs['translator'])) {
            $meta_parts[] = 'ترجمه: ' . $attrs['translator'];
        }
        if (!empty($attrs['publisher'])) {
            $meta_parts[] = 'نشر: ' . $attrs['publisher'];
        }
        $resolved['meta'] = !empty($meta_parts) ? implode(' | ', $meta_parts) : $fallback['meta'];
    } else {
        $resolved['meta'] = $fallback['meta'];
    }

    // Description
    if (!empty($raw_slide['desc'])) {
        $resolved['desc'] = $raw_slide['desc'];
    } elseif ($product) {
        $short = $product->get_short_description();
        $resolved['desc'] = !empty($short) ? wp_strip_all_tags($short) : wp_trim_words(wp_strip_all_tags($product->get_description()), 32);
    } else {
        $resolved['desc'] = $fallback['desc'];
    }

    // Pricing & Discount
    if ($product) {
        $reg  = (float)$product->get_regular_price();
        $sale = (float)$product->get_sale_price();
        if ($sale > 0 && $reg > $sale) {
            $resolved['price']     = (string)$sale;
            $resolved['old_price'] = (string)$reg;
            $resolved['discount']  = (string)round((($reg - $sale) / $reg) * 100);
        } else {
            $resolved['price']     = (string)$product->get_price();
            $resolved['old_price'] = !empty($raw_slide['old_price']) ? $raw_slide['old_price'] : '';
            $resolved['discount']  = !empty($raw_slide['discount']) ? $raw_slide['discount'] : '';
        }
    } else {
        $resolved['price']     = !empty($raw_slide['price']) ? $raw_slide['price'] : $fallback['price'];
        $resolved['old_price'] = !empty($raw_slide['old_price']) ? $raw_slide['old_price'] : $fallback['old_price'];
        $resolved['discount']  = !empty($raw_slide['discount']) ? $raw_slide['discount'] : $fallback['discount'];
    }

    // Buttons
    $resolved['btn1_text'] = !empty($raw_slide['btn1_text']) ? $raw_slide['btn1_text'] : $fallback['btn1_text'];
    if (!empty($raw_slide['btn1_url'])) {
        $resolved['btn1_url'] = $raw_slide['btn1_url'];
    } elseif ($product) {
        $resolved['btn1_url'] = get_permalink($product_id);
    } else {
        $resolved['btn1_url'] = !empty($fallback['btn1_url']) ? $fallback['btn1_url'] : (class_exists('WooCommerce') ? wc_get_page_permalink('shop') : '#');
    }

    $resolved['btn2_text'] = !empty($raw_slide['btn2_text']) ? $raw_slide['btn2_text'] : $fallback['btn2_text'];
    $resolved['btn2_url']  = !empty($raw_slide['btn2_url']) ? $raw_slide['btn2_url'] : $fallback['btn2_url'];

    // 3D visual attributes
    $resolved['custom_image'] = !empty($raw_slide['custom_image']) ? $raw_slide['custom_image'] : '';
    $resolved['cover_id'] = ($product && empty($resolved['custom_image']) && function_exists('rashnubook_get_product_cover_image_id')) ? rashnubook_get_product_cover_image_id($product) : 0;

    $resolved['edition']     = !empty($raw_slide['edition']) ? $raw_slide['edition'] : $fallback['edition'];
    $resolved['pages']       = !empty($raw_slide['pages']) ? $raw_slide['pages'] : $fallback['pages'];
    $resolved['publisher']   = !empty($raw_slide['publisher']) ? $raw_slide['publisher'] : $fallback['publisher'];
    $resolved['bg_gradient'] = !empty($raw_slide['bg_gradient']) ? $raw_slide['bg_gradient'] : $fallback['bg_gradient'];
    $resolved['spine_color'] = !empty($raw_slide['spine_color']) ? $raw_slide['spine_color'] : $fallback['spine_color'];

    return $resolved;
}

/**
 * Returns all configured hero slides
 */
function rashnubook_get_hero_slides() {
    $slides = array();
    for ($i = 1; $i <= 5; $i++) {
        $raw = array(
            'enabled'      => rashnubook_get_option("hero_slide_{$i}_enable", $i <= 3 ? '1' : '0'),
            'product_id'   => (int)rashnubook_get_option("hero_slide_{$i}_product_id", $i === 1 ? 812 : ($i === 2 ? 817 : ($i === 3 ? 823 : 0))),
            'badge'        => rashnubook_get_option("hero_slide_{$i}_badge", ''),
            'title'        => rashnubook_get_option("hero_slide_{$i}_title", ''),
            'meta'         => rashnubook_get_option("hero_slide_{$i}_meta", ''),
            'desc'         => rashnubook_get_option("hero_slide_{$i}_desc", ''),
            'price'        => rashnubook_get_option("hero_slide_{$i}_price", ''),
            'old_price'    => rashnubook_get_option("hero_slide_{$i}_old_price", ''),
            'discount'     => rashnubook_get_option("hero_slide_{$i}_discount", ''),
            'btn1_text'    => rashnubook_get_option("hero_slide_{$i}_btn1_text", ''),
            'btn1_url'     => rashnubook_get_option("hero_slide_{$i}_btn1_url", ''),
            'btn2_text'    => rashnubook_get_option("hero_slide_{$i}_btn2_text", ''),
            'btn2_url'     => rashnubook_get_option("hero_slide_{$i}_btn2_url", ''),
            'custom_image' => rashnubook_get_option("hero_slide_{$i}_image", ''),
            'edition'      => rashnubook_get_option("hero_slide_{$i}_edition", ''),
            'pages'        => rashnubook_get_option("hero_slide_{$i}_pages", ''),
            'publisher'    => rashnubook_get_option("hero_slide_{$i}_publisher", ''),
            'bg_gradient'  => rashnubook_get_option("hero_slide_{$i}_bg_gradient", ''),
            'spine_color'  => rashnubook_get_option("hero_slide_{$i}_spine_color", ''),
        );
        $slides[$i] = rashnubook_resolve_slide_data($i, $raw);
    }
    return $slides;
}

/**
 * Returns configured product rails (Bento/Tento rails)
 */
function rashnubook_get_homepage_rails() {
    $default_rails = array(
        1 => array(
            'cat'       => 'law-books',
            'eyebrow'   => 'تمرکز اصلی رشنو بوک (@rashno_book)',
            'title'     => 'کتب تخصصی حقوقی و منابع آزمون وکالت و قضاوت',
            'count'     => 10,
            'orderby'   => 'date',
            'link_text' => 'مشاهده همه کتاب‌های حقوقی',
        ),
        2 => array(
            'cat'       => 'fiction',
            'eyebrow'   => 'ویراست نفیس ادبی',
            'title'     => 'شاهکارهای ادبیات داستانی و رمان‌های جهان و ایران',
            'count'     => 10,
            'orderby'   => 'date',
            'link_text' => 'مشاهده تمام رمان‌ها',
        ),
        3 => array(
            'cat'       => 'philosophy',
            'eyebrow'   => 'خرد و اندیشه‌ورزی',
            'title'     => 'فلسفه، منطق و متون بنیادین حکمت',
            'count'     => 10,
            'orderby'   => 'date',
            'link_text' => 'مشاهده آثار فلسفه',
        ),
        4 => array(
            'cat'       => 'poetry',
            'eyebrow'   => 'کلام منظوم و ادبیات ناب',
            'title'     => 'شعر کهن و دیوان شاعران نامدار',
            'count'     => 10,
            'orderby'   => 'date',
            'link_text' => 'مشاهده دیوان‌ها',
        ),
        5 => array(
            'cat'       => 'psychology',
            'eyebrow'   => 'آگاهی و شناخت خویشتن',
            'title'     => 'روان‌شناسی تحلیلی، خودکاوی و توسعه فردی',
            'count'     => 10,
            'orderby'   => 'date',
            'link_text' => 'مشاهده کتب روان‌شناسی',
        ),
    );

    $rails = array();
    for ($i = 1; $i <= 5; $i++) {
        $def = $default_rails[$i];
        $enabled = rashnubook_get_option("home_rail_{$i}_enable", '1');
        $rails[$i] = array(
            'enabled'   => ($enabled === '1' || $enabled === true || $enabled === 1),
            'cat'       => rashnubook_get_option("home_rail_{$i}_cat", $def['cat']),
            'eyebrow'   => rashnubook_get_option("home_rail_{$i}_eyebrow", $def['eyebrow']),
            'title'     => rashnubook_get_option("home_rail_{$i}_title", $def['title']),
            'count'     => (int)rashnubook_get_option("home_rail_{$i}_count", $def['count']),
            'orderby'   => rashnubook_get_option("home_rail_{$i}_orderby", $def['orderby']),
            'link_text' => rashnubook_get_option("home_rail_{$i}_link_text", $def['link_text']),
            'link_url'  => rashnubook_get_option("home_rail_{$i}_link_url", ''),
        );
    }
    return $rails;
}

/**
 * Returns configured homepage category cards
 */
function rashnubook_get_homepage_category_cards() {
    $default_cards = array(
        1 => array('slug' => 'law-books',  'icon' => 'book',    'title' => 'کتب تخصصی حقوقی',     'count' => '5 عنوان کتاب آزمونی'),
        2 => array('slug' => 'fiction',    'icon' => 'feather', 'title' => 'ادبیات داستانی و رمان', 'count' => '5 عنوان اثر شاخص'),
        3 => array('slug' => 'philosophy', 'icon' => 'star',    'title' => 'فلسفه، منطق و حکمت',   'count' => '2 عنوان متن بنیادین'),
        4 => array('slug' => 'poetry',     'icon' => 'heart',   'title' => 'شعر کهن و معاصر',     'count' => '1 دیوان نفیس'),
        5 => array('slug' => 'psychology', 'icon' => 'user',    'title' => 'روان‌شناسی و خودکاوی', 'count' => '1 عنوان برگزیده'),
    );

    $cards = array();
    for ($i = 1; $i <= 5; $i++) {
        $def = $default_cards[$i];
        $enabled = rashnubook_get_option("home_cat_{$i}_enable", '1');
        $cards[$i] = array(
            'enabled' => ($enabled === '1' || $enabled === true || $enabled === 1),
            'slug'    => rashnubook_get_option("home_cat_{$i}_slug", $def['slug']),
            'icon'    => rashnubook_get_option("home_cat_{$i}_icon", $def['icon']),
            'title'   => rashnubook_get_option("home_cat_{$i}_title", $def['title']),
            'count'   => rashnubook_get_option("home_cat_{$i}_count", $def['count']),
        );
    }
    return $cards;
}

/**
 * Render the Admin Settings Page
 */
function rashnubook_render_settings_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $saved = false;

    // Handle Form Save
    if (isset($_POST['rashnubook_save_settings'])) {
        check_admin_referer('rashnubook_settings_nonce', 'rashnubook_nonce');

        $input = isset($_POST['rb_opt']) ? (array)$_POST['rb_opt'] : array();
        $sanitized = array();

        $raw_html_keys = array('trust_seal_enamad', 'trust_seal_samandehi', 'trust_seal_custom');

        foreach ($input as $k => $v) {
            if (is_array($v)) {
                $sanitized[$k] = array_map('sanitize_text_field', $v);
            } elseif (in_array($k, $raw_html_keys, true)) {
                $sanitized[$k] = wp_kses_post(wp_unslash($v));
            } else {
                $sanitized[$k] = sanitize_text_field(wp_unslash($v));
            }
        }

        // Checkbox toggles (all must be cleanly stored as '1' or '0')
        $switches = array(
            'enable_spine_effect',
            'enable_landing_countdown',
            'enable_persian_digits',
            'trust_1_enable',
            'trust_2_enable',
            'trust_3_enable',
            'trust_4_enable',
            // Homepage Elements Master Toggles
            'hero_enable',
            'hero_autoplay',
            'home_cats_enable',
            'home_rails_enable',
            'home_quote_enable',
            'home_banner_enable',
            'home_blog_enable',
            'home_trust_enable',
        );

        // Slide switches & rail switches & category switches
        for ($i = 1; $i <= 5; $i++) {
            $switches[] = "hero_slide_{$i}_enable";
            $switches[] = "home_rail_{$i}_enable";
            $switches[] = "home_cat_{$i}_enable";
        }

        foreach ($switches as $sw) {
            $sanitized[$sw] = isset($input[$sw]) ? '1' : '0';
        }

        update_option('rashnubook_options', $sanitized);
        $saved = true;
    }

    $opts = get_option('rashnubook_options', array());

    // Basic Defaults
    $topbar_text       = $opts['topbar_text'] ?? 'ارسال سریع و کاملاً رایگان کتاب به سراسر کشور | اینستاگرام: rashno_book@';
    $phone             = $opts['phone'] ?? '۰۲۱-۸۸۹۹۰۰۱۱';
    $hours             = $opts['hours'] ?? 'شنبه تا پنجشنبه ۹ الی ۱۹';
    $instagram         = $opts['instagram'] ?? 'rashno_book';
    $telegram          = $opts['telegram'] ?? 'rashno_book';
    $address           = $opts['address'] ?? 'تهران، میدان انقلاب، روبروی دانشگاه تهران، راسته ناشران و کتابفروشان، کتابفروشی آنلاین رَشن';
    $email             = $opts['email'] ?? 'info@rashnubook.ir';
    $footer_about_text = $opts['footer_about_text'] ?? 'کتابفروشی آنلاین رَشن، پایگاهی برای دوستداران ادبیات، اندیشه و فرهنگ اصیل. ما متعهد به گزینش و عرضه فاخرترین آثار مکتوب حقوقی و ادبی، ویرایش دقیق و ارائه باکیفیت‌ترین نسخه‌های چاپی در سراسر ایران هستیم.';
    $copyright_text    = $opts['copyright_text'] ?? 'تمامی حقوق برای کتابفروشی آنلاین رَشن (rashnubook.ir) محفوظ است.';
    $social_instagram  = $opts['social_instagram'] ?? 'https://instagram.com/rashno_book';
    $social_telegram   = $opts['social_telegram'] ?? 'https://t.me/rashno_book';
    $social_whatsapp   = $opts['social_whatsapp'] ?? 'https://wa.me/989120000000';
    $social_bale       = $opts['social_bale'] ?? '';
    $social_eitaa      = $opts['social_eitaa'] ?? '';
    $social_x          = $opts['social_x'] ?? '';
    $free_shipping     = $opts['free_shipping'] ?? '۵۰۰,۰۰۰';
    $spine_effect      = $opts['enable_spine_effect'] ?? '1';
    $landing_countdown = $opts['enable_landing_countdown'] ?? '1';
    $countdown_hours   = $opts['countdown_hours'] ?? '36';

    // Homepage Elements Configuration
    $hero_enable       = $opts['hero_enable'] ?? '1';
    $hero_autoplay     = $opts['hero_autoplay'] ?? '1';
    $hero_interval     = $opts['hero_interval'] ?? '6000';
    $home_cats_enable  = $opts['home_cats_enable'] ?? '1';
    $home_cats_eyebrow = $opts['home_cats_eyebrow'] ?? 'ویترین موضوعی رشنو';
    $home_cats_title   = $opts['home_cats_title'] ?? 'دسته‌بندی‌های تخصصی کتاب‌سرا';
    $home_cats_link_text = $opts['home_cats_link_text'] ?? 'مشاهده همه دسته‌ها';
    $home_cats_link_url  = $opts['home_cats_link_url'] ?? '';

    $home_rails_enable = $opts['home_rails_enable'] ?? '1';

    $home_quote_enable = $opts['home_quote_enable'] ?? '1';
    $quote_text        = $opts['quote_text'] ?? 'کتاب، پناهگاهی امن در برابر هیاهوی جهان و دریچه‌ای گشوده رو به جاودانگی اندیشه بشری است.';
    $quote_author      = $opts['quote_author'] ?? 'شورای سردبیری و هیئت علمی رَشن';

    $home_banner_enable      = $opts['home_banner_enable'] ?? '1';
    $home_banner_badge       = $opts['home_banner_badge'] ?? 'نشریه اختصاصی کتابفروشی آنلاین رَشن • شماره دوازدهم';
    $home_banner_title       = $opts['home_banner_title'] ?? 'ماهنامه ادبی و فرهنگی «آفتابگردان»';
    $home_banner_desc        = $opts['home_banner_desc'] ?? 'پرونده ویژه شماره جدید: «نسبت قانون، اخلاق و عدالت در ادبیات داستانی معاصر». با مقالاتی از برجسته‌ترین استادان حقوق و منتقدان ادبی، کاغذ بالکی سوئدی و ضمیمه صوتی اختصاصی.';
    $home_banner_btn1_text   = $opts['home_banner_btn1_text'] ?? 'ورود به صفحه ماهنامه و سفارش نسخه چاپی';
    $home_banner_btn1_url    = $opts['home_banner_btn1_url'] ?? home_url('/aftabgardan/');
    $home_banner_btn2_text   = $opts['home_banner_btn2_text'] ?? 'پلن‌های اشتراک سالانه';
    $home_banner_btn2_url    = $opts['home_banner_btn2_url'] ?? home_url('/aftabgardan/#subscribe-plans');
    $home_banner_card_badge  = $opts['home_banner_card_badge'] ?? 'شماره ۱۲ • بهار ۱۴۰۵';
    $home_banner_card_title  = $opts['home_banner_card_title'] ?? 'آفتابگردان';
    $home_banner_card_desc   = $opts['home_banner_card_desc'] ?? 'ویژه‌نامه «تحلیل حقوقی و فلسفی آثار هدایت، ساعدی و دانشور» با همکاری استادان دانشگاه تهران.';
    $home_banner_card_footer = $opts['home_banner_card_footer'] ?? 'قطع رقعی • ۹۶ صفحه • کاغذ نخودی ۷۰ گرم';

    $home_blog_enable    = $opts['home_blog_enable'] ?? '1';
    $home_blog_eyebrow   = $opts['home_blog_eyebrow'] ?? 'اندیشه‌ورزی و نقد کتاب';
    $home_blog_title     = $opts['home_blog_title'] ?? 'یادداشت‌های تحلیلی و معرفی کتاب‌ها';
    $home_blog_count     = $opts['home_blog_count'] ?? '3';
    $home_blog_link_text = $opts['home_blog_link_text'] ?? 'آرشیو همه یادداشت‌ها';
    $home_blog_link_url  = $opts['home_blog_link_url'] ?? '';

    $home_trust_enable = $opts['home_trust_enable'] ?? '1';

    // Products & Categories for Dropdowns
    $wc_products   = rashnubook_get_products_list();
    $wc_categories = rashnubook_get_product_categories_list();
    ?>
    <div class="rb-panel-wrap">
        <!-- Hero Header -->
        <div class="rb-panel-hero">
            <div class="rb-panel-hero-content">
                <span class="rb-panel-hero-tag">RASHNUBOOK.IR THEME OPTIONS</span>
                <h1><?php esc_html_e('پنل تنظیمات اختصاصی کتابفروشی آنلاین رَشن', 'rashnubook'); ?></h1>
                <p><?php esc_html_e('مدیریت ماژولار المان‌های صفحه اصلی (مشابه تنتو)، انتخاب کتاب‌های اسلایدر هیرو، ویترین‌ها و نمادهای اعتماد', 'rashnubook'); ?></p>
            </div>
            <div class="rb-status-stack">
                <span class="rb-status-pill is-good">
                    <span class="dashicons dashicons-yes-alt" style="font-size:15px;line-height:1;"></span>
                    <span>معماری Bento/Tento فعال</span>
                </span>
                <span class="rb-status-pill">نسخه ۱.۱.۰ • اختصاصی رشنو بوک</span>
                <a href="<?php echo esc_url($social_instagram); ?>" target="_blank" class="rb-status-pill" style="text-decoration:none;">
                    <span class="dashicons dashicons-camera"></span>
                    <span>اینستاگرام: rashno_book@</span>
                </a>
            </div>
        </div>

        <?php if ($saved) : ?>
            <div class="rb-alert rb-alert-success">
                <span class="dashicons dashicons-yes-alt"></span>
                <strong><?php esc_html_e('تنظیمات قالب با موفقیت ذخیره و فوراً در سایت اعمال شد.', 'rashnubook'); ?></strong>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <?php wp_nonce_field('rashnubook_settings_nonce', 'rashnubook_nonce'); ?>

            <!-- Tab Navigation -->
            <div class="rb-nav-tabs">
                <button type="button" class="rb-nav-tab active" data-tab="tab-home-slider">
                    <span class="dashicons dashicons-slides"></span>
                    <span>اسلایدر هیرو و انتخاب کتاب‌ها</span>
                </button>
                <button type="button" class="rb-nav-tab" data-tab="tab-home-elements">
                    <span class="dashicons dashicons-layout"></span>
                    <span>المان‌های صفحه اصلی (تنتو)</span>
                </button>
                <button type="button" class="rb-nav-tab" data-tab="tab-product-rails">
                    <span class="dashicons dashicons-grid-view"></span>
                    <span>ریل‌ها و دسته‌بندی‌ها</span>
                </button>
                <button type="button" class="rb-nav-tab" data-tab="tab-general">
                    <span class="dashicons dashicons-admin-generic"></span>
                    <span>عمومی و برندینگ</span>
                </button>
                <button type="button" class="rb-nav-tab" data-tab="tab-trust">
                    <span class="dashicons dashicons-shield"></span>
                    <span>نمادهای اعتماد و اصالت</span>
                </button>
                <button type="button" class="rb-nav-tab" data-tab="tab-shop">
                    <span class="dashicons dashicons-cart"></span>
                    <span>فروشگاه و ووکامرس</span>
                </button>
                <button type="button" class="rb-nav-tab" data-tab="tab-social">
                    <span class="dashicons dashicons-share"></span>
                    <span>فوتر و شبکه‌های اجتماعی</span>
                </button>
                <button type="button" class="rb-nav-tab" data-tab="tab-landing">
                    <span class="dashicons dashicons-megaphone"></span>
                    <span>ماهنامه آفتابگردان و فرود</span>
                </button>
            </div>

            <!-- TAB 1: HERO SLIDER & BOOK SELECTOR -->
            <div id="tab-home-slider" class="rb-tab-content active">
                <div class="rb-grid">
                    <!-- General Slider Controls -->
                    <div class="rb-card rb-card-full">
                        <div class="rb-card-header">
                            <h3>
                                <span class="dashicons dashicons-controls-play"></span>
                                تنظیمات عمومی اسلایدر هیرو (Hero Slider)
                            </h3>
                            <div style="display:flex; align-items:center; gap:16px;">
                                <label class="rb-switch-label" style="margin:0;">فعال‌سازی اسلایدر هیرو در صفحه نخست:</label>
                                <label class="rb-switch">
                                    <input type="checkbox" name="rb_opt[hero_enable]" value="1" <?php checked($hero_enable, '1'); ?>>
                                    <span class="rb-slider"></span>
                                </label>
                            </div>
                        </div>
                        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:18px;">
                            <div class="rb-switch-wrap" style="margin-bottom:0;">
                                <div class="rb-switch-info">
                                    <span class="rb-switch-label">چرخش خودکار (Autoplay)</span>
                                    <span class="rb-switch-desc">چرخش نرم اسلایدها با امکان توقف هنگام هاور</span>
                                </div>
                                <label class="rb-switch">
                                    <input type="checkbox" name="rb_opt[hero_autoplay]" value="1" <?php checked($hero_autoplay, '1'); ?>>
                                    <span class="rb-slider"></span>
                                </label>
                            </div>
                            <div class="rb-field-group" style="margin-bottom:0;">
                                <label class="rb-label">مدت زمان مکث هر اسلاید (میلی‌ثانیه):</label>
                                <input type="number" name="rb_opt[hero_interval]" class="rb-input-text" value="<?php echo esc_attr($hero_interval); ?>" placeholder="مثال: 5000 یا 6000" step="500" min="2000" max="15000">
                                <p class="rb-help-text">۶۰۰۰ میلی‌ثانیه معادل ۶ ثانیه استاندارد قالب تنتو است.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Slide Cards (Slides 1 to 5) -->
                    <?php
                    $slides_data = rashnubook_get_hero_slides();
                    for ($s = 1; $s <= 5; $s++) :
                        $slide = $slides_data[$s] ?? array();
                        $slide_active = rashnubook_get_option("hero_slide_{$s}_enable", $s <= 3 ? '1' : '0');
                        $selected_pid = (int)rashnubook_get_option("hero_slide_{$s}_product_id", $s === 1 ? 812 : ($s === 2 ? 817 : ($s === 3 ? 823 : 0)));
                    ?>
                        <div class="rb-card rb-card-full rb-slide-box">
                            <div class="rb-card-header" style="background:#f8fafc; margin:-24px -24px 20px -24px; padding:16px 24px; border-top-left-radius:14px; border-top-right-radius:14px;">
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <span class="rb-slide-number">اسلاید <?php echo esc_html(rashnubook_to_persian_numbers($s)); ?></span>
                                    <h3 style="margin:0; font-size:15px; color:#1b4332;">
                                        <?php echo esc_html($slide['title'] ?: "اسلاید شماره {$s}"); ?>
                                    </h3>
                                </div>
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <span style="font-size:12px; color:#64748b;">نمایش اسلاید:</span>
                                    <label class="rb-switch">
                                        <input type="checkbox" name="rb_opt[hero_slide_<?php echo $s; ?>_enable]" value="1" <?php checked($slide_active, '1'); ?>>
                                        <span class="rb-slider"></span>
                                    </label>
                                </div>
                            </div>

                            <!-- Live Product Selection -->
                            <div class="rb-field-group" style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; padding:14px; margin-bottom:20px;">
                                <label class="rb-label" style="color:#166534; font-size:13.5px;">
                                    <span class="dashicons dashicons-book" style="color:#166534;"></span>
                                    انتخاب کتاب از محصولات ووکامرس برای این اسلاید:
                                </label>
                                <select name="rb_opt[hero_slide_<?php echo $s; ?>_product_id]" class="rb-select" style="font-weight:700; border-color:#86efac;">
                                    <option value="0">-- بدون انتخاب محصول (استفاده از مقادیر پیش‌فرض یا دستی) --</option>
                                    <?php if (!empty($wc_products)) : ?>
                                        <?php foreach ($wc_products as $pid => $pname) : ?>
                                            <option value="<?php echo esc_attr($pid); ?>" <?php selected($selected_pid, $pid); ?>>
                                                📖 <?php echo esc_html($pname); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <option value="812" <?php selected($selected_pid, 812); ?>>قانون مدنی در نظم حقوقی کنونی (پیش‌فرض)</option>
                                        <option value="817" <?php selected($selected_pid, 817); ?>>صد سال تنهایی (پیش‌فرض)</option>
                                        <option value="823" <?php selected($selected_pid, 823); ?>>چنین گفت زرتشت (پیش‌فرض)</option>
                                    <?php endif; ?>
                                </select>
                                <p class="rb-help-text" style="color:#15803d;">
                                    💡 <strong>قابلیت هوشمند:</strong> با انتخاب هر کتاب، عنوان، نویسنده، قیمت روز، درصد تخفیف، لینک خرید و تصویر جلد (با افکت ۳بعدی عطف کتاب) به صورت خودکار واکشی می‌شود. در صورت تمایل می‌توانید فیلدهای زیر را برای بازنویسی اختصاصی پر کنید.
                                </p>
                            </div>

                            <!-- Overrides & Details Grid -->
                            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:16px;">
                                <div class="rb-field-group">
                                    <label class="rb-label">بج یا تگ برجسته بالای عنوان (Eyebrow):</label>
                                    <input type="text" name="rb_opt[hero_slide_<?php echo $s; ?>_badge]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option("hero_slide_{$s}_badge", $slide['badge'])); ?>" placeholder="مثال: شاهکار جاویدان ادبیات جهان • برنده نوبل">
                                </div>

                                <div class="rb-field-group">
                                    <label class="rb-label">عنوان نمایشی کتاب (اختیاری جهت بازنویسی):</label>
                                    <input type="text" name="rb_opt[hero_slide_<?php echo $s; ?>_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option("hero_slide_{$s}_title", '')); ?>" placeholder="<?php echo esc_attr($slide['title']); ?>">
                                </div>

                                <div class="rb-field-group">
                                    <label class="rb-label">اطلاعات پدیدآور و نشر (Meta):</label>
                                    <input type="text" name="rb_opt[hero_slide_<?php echo $s; ?>_meta]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option("hero_slide_{$s}_meta", '')); ?>" placeholder="<?php echo esc_attr($slide['meta']); ?>">
                                </div>

                                <div class="rb-field-group">
                                    <label class="rb-label">لینک تصویر جلد سفارشی (اختیاری):</label>
                                    <input type="url" name="rb_opt[hero_slide_<?php echo $s; ?>_image]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option("hero_slide_{$s}_image", '')); ?>" placeholder="https://site.com/book-cover.jpg" style="direction:ltr;">
                                    <p class="rb-help-text">در صورت خالی بودن، تصویر محصول ووکامرس نمایش می‌یابد.</p>
                                </div>
                            </div>

                            <div class="rb-field-group" style="margin-top:10px;">
                                <label class="rb-label">توضیحات معرفی و نقد کوتاه کتاب:</label>
                                <textarea name="rb_opt[hero_slide_<?php echo $s; ?>_desc]" class="rb-textarea" rows="2" placeholder="<?php echo esc_attr($slide['desc']); ?>"><?php echo esc_textarea(rashnubook_get_option("hero_slide_{$s}_desc", '')); ?></textarea>
                            </div>

                            <!-- Buttons & Pricing Overrides -->
                            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:16px; margin-top:12px;">
                                <div class="rb-field-group">
                                    <label class="rb-label">متن دکمه اصلی خرید:</label>
                                    <input type="text" name="rb_opt[hero_slide_<?php echo $s; ?>_btn1_text]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option("hero_slide_{$s}_btn1_text", $slide['btn1_text'])); ?>" placeholder="خرید با ارسال رایگان پستی">
                                </div>
                                <div class="rb-field-group">
                                    <label class="rb-label">لینک دکمه اصلی (اختیاری):</label>
                                    <input type="url" name="rb_opt[hero_slide_<?php echo $s; ?>_btn1_url]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option("hero_slide_{$s}_btn1_url", '')); ?>" placeholder="پیش‌فرض: لینک مستقیم صفحه محصول" style="direction:ltr;">
                                </div>
                                <div class="rb-field-group">
                                    <label class="rb-label">متن دکمه ثانویه (اختیاری):</label>
                                    <input type="text" name="rb_opt[hero_slide_<?php echo $s; ?>_btn2_text]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option("hero_slide_{$s}_btn2_text", $slide['btn2_text'])); ?>" placeholder="مثال: مشاهده بسته آزمونی">
                                </div>
                                <div class="rb-field-group">
                                    <label class="rb-label">لینک دکمه ثانویه:</label>
                                    <input type="url" name="rb_opt[hero_slide_<?php echo $s; ?>_btn2_url]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option("hero_slide_{$s}_btn2_url", $slide['btn2_url'])); ?>" placeholder="https://..." style="direction:ltr;">
                                </div>
                            </div>

                            <!-- Tactile 3D Mockup Styling (Spine & Jacket) -->
                            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:14px; margin-top:12px; background:#fbfaf8; padding:12px; border-radius:8px; border:1px solid #ebe7df;">
                                <div class="rb-field-group" style="margin-bottom:0;">
                                    <label class="rb-label" style="font-size:12px;">نوبت چاپ روی عطف (Edition):</label>
                                    <input type="text" name="rb_opt[hero_slide_<?php echo $s; ?>_edition]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option("hero_slide_{$s}_edition", $slide['edition'])); ?>" placeholder="چاپ ۶۲ نفیس">
                                </div>
                                <div class="rb-field-group" style="margin-bottom:0;">
                                    <label class="rb-label" style="font-size:12px;">تعداد صفحات روی عطف:</label>
                                    <input type="text" name="rb_opt[hero_slide_<?php echo $s; ?>_pages]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option("hero_slide_{$s}_pages", $slide['pages'])); ?>" placeholder="۸۲۰ صفحه">
                                </div>
                                <div class="rb-field-group" style="margin-bottom:0;">
                                    <label class="rb-label" style="font-size:12px;">رنگ لبه عطف کتاب (کد Hex):</label>
                                    <input type="text" name="rb_opt[hero_slide_<?php echo $s; ?>_spine_color]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option("hero_slide_{$s}_spine_color", $slide['spine_color'])); ?>" placeholder="#142c20" style="direction:ltr;">
                                </div>
                                <div class="rb-field-group" style="margin-bottom:0;">
                                    <label class="rb-label" style="font-size:12px;">گرادینت زمینه موکاپ جلد:</label>
                                    <input type="text" name="rb_opt[hero_slide_<?php echo $s; ?>_bg_gradient]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option("hero_slide_{$s}_bg_gradient", $slide['bg_gradient'])); ?>" placeholder="linear-gradient(...)" style="direction:ltr;">
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- TAB 2: HOMEPAGE ELEMENTS (TENTO ARCHITECTURE) -->
            <div id="tab-home-elements" class="rb-tab-content">
                <div class="rb-grid">
                    <!-- Master Visibility Switcher -->
                    <div class="rb-card rb-card-full">
                        <div class="rb-card-header">
                            <h3>
                                <span class="dashicons dashicons-visibility"></span>
                                روشن/خاموش کردن سکشن‌های صفحه نخست (همانند ساختار ماژولار قالب تنتو)
                            </h3>
                        </div>
                        <p style="font-size:13px; color:#64748b; line-height:1.7; margin-bottom:16px;">
                            با استفاده از کلیدهای زیر می‌توانید هر بخش از صفحه اصلی را به‌دلخواه فعال یا غیرفعال کنید.
                        </p>
                        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap:14px;">
                            <div class="rb-switch-wrap">
                                <span class="rb-switch-label">۱. اسلایدر بزرگ هیرو</span>
                                <label class="rb-switch">
                                    <input type="checkbox" name="rb_opt[hero_enable]" value="1" <?php checked($hero_enable, '1'); ?>>
                                    <span class="rb-slider"></span>
                                </label>
                            </div>
                            <div class="rb-switch-wrap">
                                <span class="rb-switch-label">۲. کارت‌های موضوعی دسته‌بندی</span>
                                <label class="rb-switch">
                                    <input type="checkbox" name="rb_opt[home_cats_enable]" value="1" <?php checked($home_cats_enable, '1'); ?>>
                                    <span class="rb-slider"></span>
                                </label>
                            </div>
                            <div class="rb-switch-wrap">
                                <span class="rb-switch-label">۳. ریل‌های چرخشی محصولات ووکامرس</span>
                                <label class="rb-switch">
                                    <input type="checkbox" name="rb_opt[home_rails_enable]" value="1" <?php checked($home_rails_enable, '1'); ?>>
                                    <span class="rb-slider"></span>
                                </label>
                            </div>
                            <div class="rb-switch-wrap">
                                <span class="rb-switch-label">۴. باکس نقل‌قول برگزیده هفته</span>
                                <label class="rb-switch">
                                    <input type="checkbox" name="rb_opt[home_quote_enable]" value="1" <?php checked($home_quote_enable, '1'); ?>>
                                    <span class="rb-slider"></span>
                                </label>
                            </div>
                            <div class="rb-switch-wrap">
                                <span class="rb-switch-label">۵. بنر ماهنامه ادبی «آفتابگردان»</span>
                                <label class="rb-switch">
                                    <input type="checkbox" name="rb_opt[home_banner_enable]" value="1" <?php checked($home_banner_enable, '1'); ?>>
                                    <span class="rb-slider"></span>
                                </label>
                            </div>
                            <div class="rb-switch-wrap">
                                <span class="rb-switch-label">۶. یادداشت‌ها و نقد کتاب (بلاگ)</span>
                                <label class="rb-switch">
                                    <input type="checkbox" name="rb_opt[home_blog_enable]" value="1" <?php checked($home_blog_enable, '1'); ?>>
                                    <span class="rb-slider"></span>
                                </label>
                            </div>
                            <div class="rb-switch-wrap">
                                <span class="rb-switch-label">۷. نوار مزایا و نمادهای اعتماد</span>
                                <label class="rb-switch">
                                    <input type="checkbox" name="rb_opt[home_trust_enable]" value="1" <?php checked($home_trust_enable, '1'); ?>>
                                    <span class="rb-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Quote Config -->
                    <div class="rb-card">
                        <div class="rb-card-header">
                            <h3>نقل‌قول برگزیده هفته (Editorial Quote)</h3>
                            <label class="rb-switch">
                                <input type="checkbox" name="rb_opt[home_quote_enable]" value="1" <?php checked($home_quote_enable, '1'); ?>>
                                <span class="rb-slider"></span>
                            </label>
                        </div>
                        <div class="rb-field-group">
                            <label class="rb-label">متن نقل‌قول ادبی / حقوقی:</label>
                            <textarea name="rb_opt[quote_text]" class="rb-textarea" rows="3"><?php echo esc_textarea($quote_text); ?></textarea>
                        </div>
                        <div class="rb-field-group">
                            <label class="rb-label">نام گوینده یا شورای کتاب‌سرا:</label>
                            <input type="text" name="rb_opt[quote_author]" class="rb-input-text" value="<?php echo esc_attr($quote_author); ?>">
                        </div>
                    </div>

                    <!-- Section: Blog Reviews Config -->
                    <div class="rb-card">
                        <div class="rb-card-header">
                            <h3>سکشن مقالات و نقد کتاب‌ها (Blog Section)</h3>
                            <label class="rb-switch">
                                <input type="checkbox" name="rb_opt[home_blog_enable]" value="1" <?php checked($home_blog_enable, '1'); ?>>
                                <span class="rb-slider"></span>
                            </label>
                        </div>
                        <div class="rb-field-group">
                            <label class="rb-label">ابرتایتل (Eyebrow):</label>
                            <input type="text" name="rb_opt[home_blog_eyebrow]" class="rb-input-text" value="<?php echo esc_attr($home_blog_eyebrow); ?>">
                        </div>
                        <div class="rb-field-group">
                            <label class="rb-label">عنوان اصلی بخش مقالات:</label>
                            <input type="text" name="rb_opt[home_blog_title]" class="rb-input-text" value="<?php echo esc_attr($home_blog_title); ?>">
                        </div>
                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                            <div class="rb-field-group">
                                <label class="rb-label">تعداد مقالات نمایشی:</label>
                                <input type="number" name="rb_opt[home_blog_count]" class="rb-input-text" value="<?php echo esc_attr($home_blog_count); ?>" min="1" max="12">
                            </div>
                            <div class="rb-field-group">
                                <label class="rb-label">متن لینک مشاهده آرشیو:</label>
                                <input type="text" name="rb_opt[home_blog_link_text]" class="rb-input-text" value="<?php echo esc_attr($home_blog_link_text); ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Promotional Aftabgardan Banner -->
                    <div class="rb-card rb-card-full">
                        <div class="rb-card-header">
                            <h3>
                                <span class="dashicons dashicons-megaphone"></span>
                                بنر معرفی ماهنامه اختصاصی «آفتابگردان» (Promotional Banner)
                            </h3>
                            <label class="rb-switch">
                                <input type="checkbox" name="rb_opt[home_banner_enable]" value="1" <?php checked($home_banner_enable, '1'); ?>>
                                <span class="rb-slider"></span>
                            </label>
                        </div>
                        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:18px;">
                            <div>
                                <div class="rb-field-group">
                                    <label class="rb-label">متن نشان ویژه (Badge):</label>
                                    <input type="text" name="rb_opt[home_banner_badge]" class="rb-input-text" value="<?php echo esc_attr($home_banner_badge); ?>">
                                </div>
                                <div class="rb-field-group">
                                    <label class="rb-label">تیتر اصلی بنر:</label>
                                    <input type="text" name="rb_opt[home_banner_title]" class="rb-input-text" value="<?php echo esc_attr($home_banner_title); ?>">
                                </div>
                                <div class="rb-field-group">
                                    <label class="rb-label">متن توضیحات بنر:</label>
                                    <textarea name="rb_opt[home_banner_desc]" class="rb-textarea" rows="3"><?php echo esc_textarea($home_banner_desc); ?></textarea>
                                </div>
                                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                                    <div class="rb-field-group">
                                        <label class="rb-label">متن دکمه اول:</label>
                                        <input type="text" name="rb_opt[home_banner_btn1_text]" class="rb-input-text" value="<?php echo esc_attr($home_banner_btn1_text); ?>">
                                    </div>
                                    <div class="rb-field-group">
                                        <label class="rb-label">لینک دکمه اول:</label>
                                        <input type="text" name="rb_opt[home_banner_btn1_url]" class="rb-input-text" value="<?php echo esc_attr($home_banner_btn1_url); ?>" style="direction:ltr;">
                                    </div>
                                </div>
                                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                                    <div class="rb-field-group">
                                        <label class="rb-label">متن دکمه دوم:</label>
                                        <input type="text" name="rb_opt[home_banner_btn2_text]" class="rb-input-text" value="<?php echo esc_attr($home_banner_btn2_text); ?>">
                                    </div>
                                    <div class="rb-field-group">
                                        <label class="rb-label">لینک دکمه دوم:</label>
                                        <input type="text" name="rb_opt[home_banner_btn2_url]" class="rb-input-text" value="<?php echo esc_attr($home_banner_btn2_url); ?>" style="direction:ltr;">
                                    </div>
                                </div>
                            </div>

                            <div style="background:#f8fafc; padding:16px; border-radius:10px; border:1px solid #e2e8f0;">
                                <h4 style="margin:0 0 12px 0; color:#1e293b;">کارت نمایشی جلد نشریه در سمت چپ بنر</h4>
                                <div class="rb-field-group">
                                    <label class="rb-label">بج بالای کارت جلد:</label>
                                    <input type="text" name="rb_opt[home_banner_card_badge]" class="rb-input-text" value="<?php echo esc_attr($home_banner_card_badge); ?>">
                                </div>
                                <div class="rb-field-group">
                                    <label class="rb-label">عنوان روی جلد:</label>
                                    <input type="text" name="rb_opt[home_banner_card_title]" class="rb-input-text" value="<?php echo esc_attr($home_banner_card_title); ?>">
                                </div>
                                <div class="rb-field-group">
                                    <label class="rb-label">توضیحات روی کارت جلد:</label>
                                    <textarea name="rb_opt[home_banner_card_desc]" class="rb-textarea" rows="2"><?php echo esc_textarea($home_banner_card_desc); ?></textarea>
                                </div>
                                <div class="rb-field-group">
                                    <label class="rb-label">پاورقی مشخصات چاپ روی کارت:</label>
                                    <input type="text" name="rb_opt[home_banner_card_footer]" class="rb-input-text" value="<?php echo esc_attr($home_banner_card_footer); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 3: PRODUCT RAILS & CATEGORY CARDS (TENTO STYLE) -->
            <div id="tab-product-rails" class="rb-tab-content">
                <div class="rb-grid">
                    <!-- Category Cards Settings -->
                    <div class="rb-card rb-card-full">
                        <div class="rb-card-header">
                            <h3>
                                <span class="dashicons dashicons-category"></span>
                                ویترین کارت‌های موضوعی دسته‌بندی‌ها (Category Cards Strip)
                            </h3>
                            <label class="rb-switch">
                                <input type="checkbox" name="rb_opt[home_cats_enable]" value="1" <?php checked($home_cats_enable, '1'); ?>>
                                <span class="rb-slider"></span>
                            </label>
                        </div>
                        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:14px; margin-bottom:18px;">
                            <div class="rb-field-group" style="margin-bottom:0;">
                                <label class="rb-label">ابرتایتل بخش دسته‌ها:</label>
                                <input type="text" name="rb_opt[home_cats_eyebrow]" class="rb-input-text" value="<?php echo esc_attr($home_cats_eyebrow); ?>">
                            </div>
                            <div class="rb-field-group" style="margin-bottom:0;">
                                <label class="rb-label">عنوان بخش دسته‌ها:</label>
                                <input type="text" name="rb_opt[home_cats_title]" class="rb-input-text" value="<?php echo esc_attr($home_cats_title); ?>">
                            </div>
                            <div class="rb-field-group" style="margin-bottom:0;">
                                <label class="rb-label">متن لینک مشاهده همه:</label>
                                <input type="text" name="rb_opt[home_cats_link_text]" class="rb-input-text" value="<?php echo esc_attr($home_cats_link_text); ?>">
                            </div>
                        </div>

                        <!-- 5 Category Cards -->
                        <h4 style="margin:16px 0 10px; color:#1b4332;">تنظیم کارت‌های ۵گانه دسته‌بندی موضوعی:</h4>
                        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:12px;">
                            <?php
                            $cat_cards = rashnubook_get_homepage_category_cards();
                            for ($c = 1; $c <= 5; $c++) :
                                $cc = $cat_cards[$c];
                            ?>
                                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:12px;">
                                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                        <strong style="font-size:12px; color:#0f172a;">کارت <?php echo esc_html(rashnubook_to_persian_numbers($c)); ?></strong>
                                        <label class="rb-switch" style="transform:scale(0.8);">
                                            <input type="checkbox" name="rb_opt[home_cat_<?php echo $c; ?>_enable]" value="1" <?php checked($cc['enabled']); ?>>
                                            <span class="rb-slider"></span>
                                        </label>
                                    </div>
                                    <div class="rb-field-group" style="margin-bottom:8px;">
                                        <label class="rb-label" style="font-size:11px;">نامک دسته‌بندی (Slug):</label>
                                        <input type="text" name="rb_opt[home_cat_<?php echo $c; ?>_slug]" class="rb-input-text" value="<?php echo esc_attr($cc['slug']); ?>" style="font-size:12px; min-height:34px;">
                                    </div>
                                    <div class="rb-field-group" style="margin-bottom:8px;">
                                        <label class="rb-label" style="font-size:11px;">عنوان نمایشی کارت:</label>
                                        <input type="text" name="rb_opt[home_cat_<?php echo $c; ?>_title]" class="rb-input-text" value="<?php echo esc_attr($cc['title']); ?>" style="font-size:12px; min-height:34px;">
                                    </div>
                                    <div class="rb-field-group" style="margin-bottom:0;">
                                        <label class="rb-label" style="font-size:11px;">زیرنویس تعداد/توضیح:</label>
                                        <input type="text" name="rb_opt[home_cat_<?php echo $c; ?>_count]" class="rb-input-text" value="<?php echo esc_attr($cc['count']); ?>" style="font-size:12px; min-height:34px;">
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <!-- Category Product Rails (Tento 3-Second Infinite Rails) -->
                    <div class="rb-card rb-card-full">
                        <div class="rb-card-header">
                            <h3>
                                <span class="dashicons dashicons-columns"></span>
                                ریل‌های چرخشی محصولات بر اساس دسته‌بندی (Product Rails - Bento/Tento)
                            </h3>
                            <label class="rb-switch">
                                <input type="checkbox" name="rb_opt[home_rails_enable]" value="1" <?php checked($home_rails_enable, '1'); ?>>
                                <span class="rb-slider"></span>
                            </label>
                        </div>
                        <p style="font-size:13px; color:#64748b; line-height:1.7; margin-bottom:18px;">
                            در این بخش می‌توانید مشخص کنید کدام دسته‌بندی‌های کتاب در قالب ریل‌های چرخشی بی‌نهایت (با قابلیت اسکرول نرم و اتوپلی ۳ثانیه‌ای تنتو) در صفحه اول ظاهر شوند:
                        </p>

                        <?php
                        $rails = rashnubook_get_homepage_rails();
                        for ($r = 1; $r <= 5; $r++) :
                            $rail = $rails[$r];
                        ?>
                            <div style="background:#ffffff; border:1px solid #dfe5eb; border-radius:12px; padding:18px; margin-bottom:16px; box-shadow:0 2px 6px rgba(0,0,0,0.02);">
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; border-bottom:1px solid #f1f5f9; padding-bottom:10px;">
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <span style="background:#1b4332; color:#fff; font-size:11px; font-weight:800; padding:2px 8px; border-radius:6px;">ریل شماره <?php echo esc_html(rashnubook_to_persian_numbers($r)); ?></span>
                                        <h4 style="margin:0; font-size:14.5px; color:#1e293b;"><?php echo esc_html($rail['title']); ?></h4>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <span style="font-size:12px; color:#64748b;">فعال‌سازی این ریل:</span>
                                        <label class="rb-switch">
                                            <input type="checkbox" name="rb_opt[home_rail_<?php echo $r; ?>_enable]" value="1" <?php checked($rail['enabled']); ?>>
                                            <span class="rb-slider"></span>
                                        </label>
                                    </div>
                                </div>

                                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:14px;">
                                    <div class="rb-field-group">
                                        <label class="rb-label">دسته‌بندی ووکامرس:</label>
                                        <select name="rb_opt[home_rail_<?php echo $r; ?>_cat]" class="rb-select" style="font-weight:700;">
                                            <option value="">-- تمام محصولات فروشگاه --</option>
                                            <?php if (!empty($wc_categories)) : ?>
                                                <?php foreach ($wc_categories as $cslug => $cname) : ?>
                                                    <option value="<?php echo esc_attr($cslug); ?>" <?php selected($rail['cat'], $cslug); ?>>
                                                        📚 <?php echo esc_html($cname); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <option value="<?php echo esc_attr($rail['cat']); ?>" selected><?php echo esc_html($rail['cat']); ?></option>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <div class="rb-field-group">
                                        <label class="rb-label">عنوان اصلی ریل:</label>
                                        <input type="text" name="rb_opt[home_rail_<?php echo $r; ?>_title]" class="rb-input-text" value="<?php echo esc_attr($rail['title']); ?>">
                                    </div>

                                    <div class="rb-field-group">
                                        <label class="rb-label">ابرتایتل بالای ریل (Eyebrow):</label>
                                        <input type="text" name="rb_opt[home_rail_<?php echo $r; ?>_eyebrow]" class="rb-input-text" value="<?php echo esc_attr($rail['eyebrow']); ?>">
                                    </div>

                                    <div class="rb-field-group">
                                        <label class="rb-label">تعداد محصولات ریل:</label>
                                        <input type="number" name="rb_opt[home_rail_<?php echo $r; ?>_count]" class="rb-input-text" value="<?php echo esc_attr($rail['count']); ?>" min="4" max="24">
                                    </div>

                                    <div class="rb-field-group">
                                        <label class="rb-label">متن دکمه مشاهده همه:</label>
                                        <input type="text" name="rb_opt[home_rail_<?php echo $r; ?>_link_text]" class="rb-input-text" value="<?php echo esc_attr($rail['link_text']); ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>

            <!-- TAB 4: GENERAL & BRANDING -->
            <div id="tab-general" class="rb-tab-content">
                <div class="rb-grid">
                    <div class="rb-card">
                        <div class="rb-card-header">
                            <h3>نوار اطلاعیه بالای سایت</h3>
                        </div>
                        <div class="rb-field-group">
                            <label class="rb-label">متن نوار اطلاعیه بالای سربرگ:</label>
                            <input type="text" name="rb_opt[topbar_text]" class="rb-input-text" value="<?php echo esc_attr($topbar_text); ?>">
                            <p class="rb-help-text">این پیام در نوار تیره بالای تمامی صفحات سایت نمایش داده می‌شود.</p>
                        </div>
                    </div>

                    <div class="rb-card">
                        <div class="rb-card-header">
                            <h3>اطلاعات تماس و پشتیبانی</h3>
                        </div>
                        <div class="rb-field-group">
                            <label class="rb-label">شماره تلفن پشتیبانی:</label>
                            <input type="text" name="rb_opt[phone]" class="rb-input-text" value="<?php echo esc_attr($phone); ?>">
                        </div>
                        <div class="rb-field-group">
                            <label class="rb-label">رایانامه (ایمیل) پشتیبانی:</label>
                            <input type="email" name="rb_opt[email]" class="rb-input-text" value="<?php echo esc_attr($email); ?>">
                        </div>
                        <div class="rb-field-group">
                            <label class="rb-label">ساعات کاری و پاسخگویی:</label>
                            <input type="text" name="rb_opt[hours]" class="rb-input-text" value="<?php echo esc_attr($hours); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 5: TRUST BADGES & SEALS -->
            <div id="tab-trust" class="rb-tab-content">
                <div class="rb-grid">
                    <div class="rb-card rb-card-full" style="background:#f8fafc;">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <h3 style="margin:0 0 4px; color:#1e293b;">نمایش نوار نمادهای اعتماد در صفحه اصلی سایت</h3>
                                <p style="margin:0; font-size:12.5px; color:#64748b;">فعال یا مخفی‌سازی کل ردیف ۴گانه مزایای کتاب‌سرا در انتهای صفحه اول</p>
                            </div>
                            <label class="rb-switch">
                                <input type="checkbox" name="rb_opt[home_trust_enable]" value="1" <?php checked($home_trust_enable, '1'); ?>>
                                <span class="rb-slider"></span>
                            </label>
                        </div>
                    </div>

                    <?php
                    $trust_icons_list = array(
                        'shipping' => 'ارسال سریع و رایگان (Shipping)',
                        'truck'    => 'کامیون حمل بار (Truck)',
                        'shield'   => 'سپر و ضمانت اصالت (Shield)',
                        'award'    => 'مدال و نشان کیفیت (Award)',
                        'book'     => 'کتاب و نسخه فیزیکی (Book)',
                        'box'      => 'بسته‌بندی نفیس و ایمن (Box)',
                        'support'  => 'مشاوره و پشتیبانی (Support)',
                        'phone'    => 'تماس تلفنی مستقیم (Phone)',
                        'check'    => 'تیک تأیید و تضمین (Check)',
                        'heart'    => 'قلب و رضایت خوانندگان (Heart)',
                        'card'     => 'پرداخت امن بانکی (Credit Card)',
                        'clock'    => 'ساعت و سرعت پاسخگویی (Clock)',
                        'return'   => 'ضمانت بازگشت و تعویض (Return)',
                        'lock'     => 'قفل و امنیت خرید (Lock)',
                        'gift'     => 'هدیه و بوک‌مارک نشانک (Gift)',
                        'star'     => 'ستاره و امتیاز ویژه (Star)',
                    );

                    $trust_data = function_exists('rashnubook_get_trust_badges') ? rashnubook_get_trust_badges() : array();
                    for ($i = 1; $i <= 4; $i++) :
                        $b = $trust_data[$i] ?? array();
                    ?>
                        <div class="rb-card">
                            <div class="rb-card-header" style="display:flex; justify-content:space-between; align-items:center;">
                                <h3>نماد اعتماد و مزیت <?php echo esc_html(rashnubook_to_persian_numbers($i)); ?></h3>
                                <label class="rb-switch">
                                    <input type="checkbox" name="rb_opt[trust_<?php echo $i; ?>_enable]" value="1" <?php checked(!empty($b['enabled'])); ?>>
                                    <span class="rb-slider"></span>
                                </label>
                            </div>
                            <div class="rb-field-group">
                                <label class="rb-label">انتخاب آیکون نماد:</label>
                                <select name="rb_opt[trust_<?php echo $i; ?>_icon]" class="rb-input-text" style="font-weight:600;">
                                    <?php foreach ($trust_icons_list as $k => $label) : ?>
                                        <option value="<?php echo esc_attr($k); ?>" <?php selected(($b['icon'] ?? ''), $k); ?>><?php echo esc_html($label); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="rb-field-group">
                                <label class="rb-label">یا آدرس آیکون/تصویر سفارشی (اختیاری):</label>
                                <input type="url" name="rb_opt[trust_<?php echo $i; ?>_custom_icon]" class="rb-input-text" value="<?php echo esc_attr($b['custom_icon'] ?? ''); ?>" placeholder="https://site.com/icon.svg" style="direction:ltr;">
                            </div>
                            <div class="rb-field-group">
                                <label class="rb-label">عنوان نماد اعتماد:</label>
                                <input type="text" name="rb_opt[trust_<?php echo $i; ?>_title]" class="rb-input-text" value="<?php echo esc_attr($b['title'] ?? ''); ?>">
                            </div>
                            <div class="rb-field-group">
                                <label class="rb-label">متن توضیحات نماد:</label>
                                <textarea name="rb_opt[trust_<?php echo $i; ?>_desc]" class="rb-input-textarea" rows="2"><?php echo esc_textarea($b['desc'] ?? ''); ?></textarea>
                            </div>
                        </div>
                    <?php endfor; ?>

                    <div class="rb-card" style="grid-column: 1 / -1;">
                        <div class="rb-card-header">
                            <h3>مجوزها و نمادهای الکترونیکی اعتماد (اینماد و ساماندهی در فوتر)</h3>
                        </div>
                        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:16px;">
                            <div class="rb-field-group">
                                <label class="rb-label">کد یا نشان اینماد (نماد اعتماد الکترونیکی):</label>
                                <textarea name="rb_opt[trust_seal_enamad]" class="rb-input-textarea" rows="4" placeholder="کد یا تگ اینماد..." style="direction:ltr; font-family:monospace; font-size:12px;"><?php echo esc_textarea(rashnubook_get_option('trust_seal_enamad', '')); ?></textarea>
                            </div>
                            <div class="rb-field-group">
                                <label class="rb-label">کد یا نشان ساماندهی (وزارت ارشاد):</label>
                                <textarea name="rb_opt[trust_seal_samandehi]" class="rb-input-textarea" rows="4" placeholder="کد یا تگ ساماندهی..." style="direction:ltr; font-family:monospace; font-size:12px;"><?php echo esc_textarea(rashnubook_get_option('trust_seal_samandehi', '')); ?></textarea>
                            </div>
                            <div class="rb-field-group">
                                <label class="rb-label">نماد دلخواه سوم (عضو اتحادیه، درگاه امن و...):</label>
                                <textarea name="rb_opt[trust_seal_custom]" class="rb-input-textarea" rows="4" placeholder="کد یا تصویر نماد سوم..." style="direction:ltr; font-family:monospace; font-size:12px;"><?php echo esc_textarea(rashnubook_get_option('trust_seal_custom', '')); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 6: SHOP & WOOCOMMERCE -->
            <div id="tab-shop" class="rb-tab-content">
                <div class="rb-grid">
                    <div class="rb-card">
                        <div class="rb-card-header">
                            <h3>تنظیمات نمایش کتاب‌ها</h3>
                        </div>
                        <div class="rb-switch-wrap">
                            <div class="rb-switch-info">
                                <span class="rb-switch-label">افکت عطف سه‌بعدی کتاب (3D Spine Effect)</span>
                                <span class="rb-switch-desc">نمایش شیار و سایه ظریف عطف کتاب در سمت راست تصویر برای حالت راست‌به‌چپ</span>
                            </div>
                            <label class="rb-switch">
                                <input type="checkbox" name="rb_opt[enable_spine_effect]" value="1" <?php checked($spine_effect, '1'); ?>>
                                <span class="rb-slider"></span>
                            </label>
                        </div>

                        <div class="rb-field-group" style="margin-top:16px;">
                            <label class="rb-label">سقف ارسال رایگان (تومان):</label>
                            <input type="text" name="rb_opt[free_shipping]" class="rb-input-text" value="<?php echo esc_attr($free_shipping); ?>">
                            <p class="rb-help-text">مبلغ خریدی که پس از آن ارسال به سراسر کشور رایگان محاسبه می‌شود.</p>
                        </div>
                    </div>

                    <div class="rb-card">
                        <div class="rb-card-header">
                            <h3>ویژگی‌های شناسنامه نشر</h3>
                        </div>
                        <p style="font-size:13px; color:#475569; line-height:1.8;">
                            قالب رشنو بوک به صورت خودکار فیلدهای شناسنامه نسخه چاپی را به صفحه ویرایش هر کتاب در ووکامرس اضافه کرده است:
                        </p>
                        <ul style="list-style:disc; margin-right:20px; font-size:13px; color:#1e293b; line-height:1.9;">
                            <li>نام نویسنده و پدیدآورنده اصلی</li>
                            <li>نام مترجم / مصحح</li>
                            <li>ناشر و کد نشر</li>
                            <li>شابک بین‌المللی (ISBN)</li>
                            <li>تعداد صفحه و نوبت چاپ</li>
                            <li>گزیده‌ای از متن اثر (Monograph Quote)</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- TAB 7: FOOTER & SOCIAL -->
            <div id="tab-social" class="rb-tab-content">
                <div class="rb-grid">
                    <div class="rb-card">
                        <div class="rb-card-header">
                            <h3>اطلاعات متنی سکشن فوتر</h3>
                        </div>
                        <div class="rb-field-group">
                            <label class="rb-label">متن معرفی و درباره ما در فوتر:</label>
                            <textarea name="rb_opt[footer_about_text]" class="rb-textarea" rows="4"><?php echo esc_textarea($footer_about_text); ?></textarea>
                        </div>
                        <div class="rb-field-group">
                            <label class="rb-label">نشانی کامل کتاب‌سرا در فوتر:</label>
                            <textarea name="rb_opt[address]" class="rb-textarea" rows="3"><?php echo esc_textarea($address); ?></textarea>
                        </div>
                        <div class="rb-field-group">
                            <label class="rb-label">متن کپی‌رایت پایین فوتر:</label>
                            <input type="text" name="rb_opt[copyright_text]" class="rb-input-text" value="<?php echo esc_attr($copyright_text); ?>">
                        </div>
                    </div>

                    <div class="rb-card">
                        <div class="rb-card-header">
                            <h3>آیکون‌ها و لینک‌های شبکه‌های اجتماعی فوتر</h3>
                        </div>
                        <div class="rb-field-group">
                            <label class="rb-label">لینک صفحه اینستاگرام:</label>
                            <input type="url" name="rb_opt[social_instagram]" class="rb-input-text" value="<?php echo esc_attr($social_instagram); ?>" placeholder="https://instagram.com/rashno_book">
                        </div>
                        <div class="rb-field-group">
                            <label class="rb-label">لینک کانال تلگرام:</label>
                            <input type="url" name="rb_opt[social_telegram]" class="rb-input-text" value="<?php echo esc_attr($social_telegram); ?>" placeholder="https://t.me/rashno_book">
                        </div>
                        <div class="rb-field-group">
                            <label class="rb-label">لینک یا شماره واتساپ:</label>
                            <input type="text" name="rb_opt[social_whatsapp]" class="rb-input-text" value="<?php echo esc_attr($social_whatsapp); ?>" placeholder="https://wa.me/98912...">
                        </div>
                        <div class="rb-field-group">
                            <label class="rb-label">لینک کانال بله:</label>
                            <input type="url" name="rb_opt[social_bale]" class="rb-input-text" value="<?php echo esc_attr($social_bale); ?>" placeholder="https://ble.ir/rashno_book">
                        </div>
                        <div class="rb-field-group">
                            <label class="rb-label">لینک کانال ایتا:</label>
                            <input type="url" name="rb_opt[social_eitaa]" class="rb-input-text" value="<?php echo esc_attr($social_eitaa); ?>" placeholder="https://eitaa.com/rashno_book">
                        </div>
                        <div class="rb-field-group">
                            <label class="rb-label">لینک حساب رسمی در شبکه X (توییتر سابق):</label>
                            <input type="url" name="rb_opt[social_x]" class="rb-input-text" value="<?php echo esc_attr($social_x); ?>" placeholder="https://x.com/rashno_book">
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 8: LANDING PAGE -->
            <div id="tab-landing" class="rb-tab-content">
                <div class="rb-grid">
                    <div class="rb-card">
                        <div class="rb-card-header">
                            <h3>تنظیمات برگه فرود (Landing Page)</h3>
                        </div>
                        <div class="rb-switch-wrap">
                            <div class="rb-switch-info">
                                <span class="rb-switch-label">فعال‌سازی نوار شمارش معکوس تخفیف</span>
                                <span class="rb-switch-desc">نمایش تایمر زنده باقی‌مانده تخفیف ویژه در صفحات فرود</span>
                            </div>
                            <label class="rb-switch">
                                <input type="checkbox" name="rb_opt[enable_landing_countdown]" value="1" <?php checked($landing_countdown, '1'); ?>>
                                <span class="rb-slider"></span>
                            </label>
                        </div>

                        <div class="rb-field-group" style="margin-top:16px;">
                            <label class="rb-label">مدت زمان پیش‌فرض تایمر (ساعت):</label>
                            <input type="number" name="rb_opt[countdown_hours]" class="rb-input-text" value="<?php echo esc_attr($countdown_hours); ?>">
                        </div>
                    </div>

                    <div class="rb-card">
                        <div class="rb-card-header">
                            <h3>ماهنامه فرهنگی و ادبی «آفتابگردان»</h3>
                        </div>
                        <p style="font-size:13px; color:#475569; line-height:1.8;">
                            نشریه اختصاصی کتابفروشی آنلاین رَشن برای معرفی و نقد کتاب‌های حقوقی و ادبی. بنر این ماهنامه در صفحه اول فعال است و به این برگه متصل می‌باشد.
                        </p>
                        <p style="margin-top:14px;">
                            <a href="<?php echo esc_url(home_url('/aftabgardan/')); ?>" target="_blank" class="button button-primary" style="padding:6px 14px; font-weight:800;">
                                 مشاهده لندینگ پیج ماهنامه آفتابگردان
                            </a>
                        </p>
                    </div>

                    <div class="rb-card">
                        <div class="rb-card-header">
                            <h3>برگه‌های درباره ما و تماس با ما</h3>
                        </div>
                        <p style="font-size:13px; color:#475569; line-height:1.8;">
                            صفحات «درباره ما» و «تماس با ما» در بخش <strong>برگه‌ها</strong> ساخته شده‌اند و به راحتی از طریق پیشخوان قابل ویرایش هستند:
                        </p>
                        <div style="display:flex; gap:10px; margin-top:12px;">
                            <a href="<?php echo esc_url(home_url('/about-us/')); ?>" target="_blank" class="button">مشاهده درباره ما</a>
                            <a href="<?php echo esc_url(home_url('/contact-us/')); ?>" target="_blank" class="button">مشاهده تماس با ما</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sticky Actions Bar -->
            <div class="rb-actions-bar">
                <div>
                    <span style="font-size:13px; color:#64748b;">تغییرات بلافاصله پس از ذخیره در تمام بخش‌های سایت اعمال خواهند شد.</span>
                </div>
                <div>
                    <button type="submit" name="rashnubook_save_settings" class="rb-btn-save">
                        <span class="dashicons dashicons-saved"></span>
                        <span><?php esc_html_e('ذخیره تغییرات رشنو بوک', 'rashnubook'); ?></span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tab switching script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.rb-nav-tab');
        const contents = document.querySelectorAll('.rb-tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const target = this.getAttribute('data-tab');
                tabs.forEach(t => t.classList.remove('active'));
                contents.forEach(c => c.classList.remove('active'));

                this.classList.add('active');
                const targetContent = document.getElementById(target);
                if (targetContent) {
                    targetContent.classList.add('active');
                }
            });
        });
    });
    </script>
    <?php
}
