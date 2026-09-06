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

    wp_enqueue_media();

    // Enqueue Google Fonts: DM Sans (Body) & JetBrains Mono (Code)
    wp_enqueue_style(
        'rashnubook-google-fonts',
        'https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=JetBrains+Mono:wght@400;500;600&display=swap',
        array(),
        null
    );

    // Enqueue Fontshare: General Sans (Display / Headings)
    wp_enqueue_style(
        'rashnubook-general-sans',
        'https://api.fontshare.com/v2/css?f[]=general-sans@500,600,700&display=swap',
        array(),
        null
    );

    // Enqueue Vazirmatn in admin panel for unified Persian typography
    wp_enqueue_style(
        'rashnubook-vazirmatn',
        get_template_directory_uri() . '/assets/css/vazirmatn.css',
        array(),
        RASHNUBOOK_VERSION
    );

    // Main Admin Panel Genesis CSS
    wp_enqueue_style(
        'rashnubook-admin-panel',
        get_template_directory_uri() . '/assets/css/admin-panel.css',
        array('rashnubook-vazirmatn', 'rashnubook-general-sans', 'rashnubook-google-fonts'),
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
                $slug_decoded = urldecode($t->slug);
                $cats[$t->slug] = array(
                    'slug'         => $t->slug,
                    'slug_decoded' => $slug_decoded,
                    'name'         => $t->name,
                    'count'        => $t->count,
                    'label'        => $t->name . ' (' . rashnubook_to_persian_numbers($t->count) . ' کتاب)',
                );
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
            'btn1_text'   => 'خرید با ارسال پستی',
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
        'btn1_text'   => 'خرید با ارسال پستی',
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
    $resolved['slide_type']   = !empty($raw_slide['slide_type']) ? $raw_slide['slide_type'] : 'content';
    $resolved['banner_image'] = !empty($raw_slide['banner_image']) ? $raw_slide['banner_image'] : '';
    $resolved['banner_link']  = !empty($raw_slide['banner_link']) ? $raw_slide['banner_link'] : '';
    $resolved['bg_image']     = !empty($raw_slide['bg_image']) ? $raw_slide['bg_image'] : '';

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
            'slide_type'   => rashnubook_get_option("hero_slide_{$i}_type", 'content'),
            'banner_image' => rashnubook_get_option("hero_slide_{$i}_banner_image", ''),
            'banner_link'  => rashnubook_get_option("hero_slide_{$i}_banner_link", ''),
            'bg_image'     => rashnubook_get_option("hero_slide_{$i}_bg_image", ''),
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
            'count'     => 8,
            'orderby'   => 'date',
            'link_text' => 'مشاهده همه کتاب‌های حقوقی',
        ),
        2 => array(
            'cat'       => 'fiction',
            'eyebrow'   => 'ویراست نفیس ادبی',
            'title'     => 'شاهکارهای ادبیات داستانی و رمان‌های جهان و ایران',
            'count'     => 8,
            'orderby'   => 'date',
            'link_text' => 'مشاهده تمام رمان‌ها',
        ),
        3 => array(
            'cat'       => 'philosophy',
            'eyebrow'   => 'خرد و اندیشه‌ورزی',
            'title'     => 'فلسفه، منطق و متون بنیادین حکمت',
            'count'     => 8,
            'orderby'   => 'date',
            'link_text' => 'مشاهده آثار فلسفه',
        ),
        4 => array(
            'cat'       => 'poetry',
            'eyebrow'   => 'کلام منظوم و ادبیات ناب',
            'title'     => 'شعر کهن و دیوان شاعران نامدار',
            'count'     => 8,
            'orderby'   => 'date',
            'link_text' => 'مشاهده دیوان‌ها',
        ),
        5 => array(
            'cat'       => 'psychology',
            'eyebrow'   => 'آگاهی و شناخت خویشتن',
            'title'     => 'روان‌شناسی تحلیلی، خودکاوی و توسعه فردی',
            'count'     => 8,
            'orderby'   => 'date',
            'link_text' => 'مشاهده کتب روان‌شناسی',
        ),
    );

    $rails = array();
    $existing_options = get_option('rashnubook_options', array());
    $has_saved_opts   = !empty($existing_options) && is_array($existing_options);

    for ($i = 1; $i <= 5; $i++) {
        $def = $default_rails[$i];
        if ($has_saved_opts) {
            $enabled = rashnubook_get_option("home_rail_{$i}_enable", 0);
            $cat_val = rashnubook_get_option("home_rail_{$i}_cat", '');
        } else {
            $enabled = ($i <= 3) ? 1 : 0;
            $cat_val = $def['cat'];
        }

        $raw_count = (int)rashnubook_get_option("home_rail_{$i}_count", $def['count']);
        if ($raw_count <= 0 || $raw_count > 8) {
            $raw_count = 8;
        }

        $rails[$i] = array(
            'enabled'   => ($enabled === '1' || $enabled === true || $enabled === 1),
            'cat'       => $cat_val,
            'eyebrow'   => rashnubook_get_option("home_rail_{$i}_eyebrow", $def['eyebrow']),
            'title'     => rashnubook_get_option("home_rail_{$i}_title", $def['title']),
            'count'     => $raw_count,
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

    // Handle newsletter subscriber delete
    if (isset($_GET['delete_subscriber']) && isset($_GET['_sub_nonce']) && wp_verify_nonce($_GET['_sub_nonce'], 'rashnu_delete_sub_action')) {
        $del_email = sanitize_email($_GET['delete_subscriber']);
        $subscribers = get_option('rashnubook_newsletter_subscribers', array());
        $new_subscribers = array();
        foreach ($subscribers as $sub) {
            if (($sub['email'] ?? '') !== $del_email) {
                $new_subscribers[] = $sub;
            }
        }
        update_option('rashnubook_newsletter_subscribers', $new_subscribers);
        echo '<div class="rb-alert rb-alert-success" style="margin-bottom:20px;"><span class="dashicons dashicons-yes-alt"></span><strong>مشترک خبرنامه (' . esc_html($del_email) . ') با موفقیت حذف شد.</strong></div>';
    }

    $saved = false;

    // Handle Form Save
    if (isset($_POST['rashnubook_save_settings'])) {
        check_admin_referer('rashnubook_settings_nonce', 'rashnubook_nonce');

        $input = isset($_POST['rb_opt']) ? (array)$_POST['rb_opt'] : array();
        $sanitized = array();

        $raw_html_keys = array('trust_seal_enamad', 'trust_seal_samandehi', 'trust_seal_custom', 'aftabgardan_editorial_text', 'about_story_p1', 'about_story_p2', 'contact_hours_val');
        $textarea_keys = array(
            'aftabgardan_plan1_features', 'aftabgardan_plan2_features', 'aftabgardan_hero_desc', 'aftabgardan_mockup_desc', 'landing_hero_sub', 'footer_about_text',
            'about_hero_desc', 'about_pillar1_desc', 'about_pillar2_desc', 'about_feat1_desc', 'about_feat2_desc', 'about_feat3_desc',
            'contact_subtitle', 'contact_address_val', 'contact_notice_text', 'contact_form_success_msg', 'contact_form_subjects',
            'footer_col2_links', 'footer_col3_links', 'blog_archive_desc',
        );

        foreach ($input as $k => $v) {
            if (is_array($v)) {
                $sanitized[$k] = array_map('sanitize_text_field', $v);
            } elseif (in_array($k, $raw_html_keys, true)) {
                $sanitized[$k] = wp_kses_post(wp_unslash($v));
            } elseif (in_array($k, $textarea_keys, true)) {
                $sanitized[$k] = sanitize_textarea_field(wp_unslash($v));
            } else {
                $sanitized[$k] = sanitize_text_field(wp_unslash($v));
            }
        }

        // Checkbox toggles (all must be cleanly stored as '1' or '0')
        $switches = array(
            'enable_spine_effect',
            'enable_landing_countdown',
            'enable_persian_digits',
            'drawer_cats_enable',
            'footer_col2_enable',
            'footer_col3_enable',
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
            'footer_newsletter_enable',
            // About Us Master Toggles
            'about_hero_enable',
            'about_stats_enable',
            'about_story_enable',
            'about_pillars_enable',
            'about_features_enable',
            'about_manager_enable',
            // Aftabgardan Modular Page Builder Switches
            'aftabgardan_hero_enable',
            'aftabgardan_mockup_enable',
            'aftabgardan_highlights_enable',
            'aftabgardan_editorial_enable',
            'aftabgardan_toc_enable',
            'aftabgardan_plans_enable',
            'aftabgardan_plan2_ribbon_enable',
        );

        // Slide switches & rail switches & category switches
        for ($i = 1; $i <= 5; $i++) {
            $switches[] = "hero_slide_{$i}_enable";
            $switches[] = "home_rail_{$i}_enable";
            $switches[] = "home_cat_{$i}_enable";
        }

        // Aftabgardan TOC rows switches
        for ($r = 1; $r <= 8; $r++) {
            $switches[] = "aftabgardan_toc_row_{$r}_enable";
        }

        foreach ($switches as $sw) {
            $sanitized[$sw] = isset($input[$sw]) ? '1' : '0';
        }

        $existing_opts = get_option('rashnubook_options', array());
        $final_opts = array_merge($existing_opts, $sanitized);
        update_option('rashnubook_options', $final_opts);
        $saved = true;
    }

    $opts = get_option('rashnubook_options', array());

    // Basic Defaults
    $topbar_text       = $opts['topbar_text'] ?? 'ارسال سریع پستی کتاب به سراسر کشور | اینستاگرام: rashno_book@';
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

    $blog_archive_eyebrow = $opts['blog_archive_eyebrow'] ?? 'اندیشه‌ورزی و نگاه به جهان کتاب';
    $blog_archive_title   = $opts['blog_archive_title'] ?? 'یادداشت‌ها و نقد کتاب';
    $blog_archive_desc    = $opts['blog_archive_desc'] ?? 'مجموعه‌ای از جستارهای تحلیلی، معرفی تازه‌های نشر، نقد و بررسی شاهکارهای حقوقی و ادبی به قلم نویسندگان و منتقدان کتابفروشی آنلاین رَشن.';

    $footer_col2_enable   = $opts['footer_col2_enable'] ?? '1';
    $footer_col2_title    = $opts['footer_col2_title'] ?? 'پیوندهای مهم';
    $footer_col2_links    = $opts['footer_col2_links'] ?? '';
    $footer_col3_enable   = $opts['footer_col3_enable'] ?? '1';
    $footer_col3_title    = $opts['footer_col3_title'] ?? 'موضوعات برگزیده';
    $footer_col3_links    = $opts['footer_col3_links'] ?? '';

    $drawer_cats_enable   = $opts['drawer_cats_enable'] ?? '1';
    $checkout_telegram_field_rule = $opts['checkout_telegram_field_rule'] ?? 'magazine';

    $home_trust_enable = $opts['home_trust_enable'] ?? '1';

    // Products & Categories for Dropdowns
    $wc_products   = rashnubook_get_products_list();
    $wc_categories = rashnubook_get_product_categories_list();
    ?>
    <div class="rb-panel-wrap">
        <!-- Hero Header (Editorial Precision Interface) -->
        <div class="rb-panel-hero">
            <div class="rb-panel-hero-content">
                <div class="rb-panel-hero-tag">
                    <span class="rb-panel-hero-tag-dot"></span>
                    <span>RASHNUBOOK DESIGN.MD • GENESIS STANDARD</span>
                </div>
                <h1><?php esc_html_e('تنظیمات اختصاصی کتابفروشی آنلاین رَشن', 'rashnubook'); ?></h1>
                <p><?php esc_html_e('سیستم مدیریت یکپارچه المان‌های ادیتوریال، ویترین کتاب‌ها، اسلایدر هیرو، نشریه آفتابگردان و تنظیمات برند', 'rashnubook'); ?></p>
            </div>
            <div class="rb-status-stack">
                <span class="rb-status-pill is-good">
                    <span class="dashicons dashicons-yes-alt"></span>
                    <span>سیستم فعال • Genesis Standard</span>
                </span>
                <span class="rb-status-pill">نسخه ۱.۲.۱ • اختصاصی رشنو</span>
                <a href="<?php echo esc_url($social_instagram); ?>" target="_blank" class="rb-status-pill is-brand">
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

        <!-- Quick Search & Filter Bar (⌘K / Ctrl+K) -->
        <div class="rb-search-container">
            <div class="rb-search-bar">
                <span class="dashicons dashicons-search rb-search-icon"></span>
                <input type="text" id="rb-settings-search" class="rb-search-input" placeholder="جستجوی سریع بین تمام گزینه‌ها و تنظیمات رشنو بوک..." autocomplete="off">
                <span class="rb-kbd-badge">Ctrl + K</span>
            </div>
        </div>

        <form method="post" action="" id="rb-settings-form">
            <?php wp_nonce_field('rashnubook_settings_nonce', 'rashnubook_nonce'); ?>

            <!-- Genesis 2-Column Sidebar Layout -->
            <div class="rb-panel-body-layout">
                <!-- Vertical Sidebar Navigation (Right in RTL) -->
                <aside class="rb-sidebar-nav">
                    <div class="rb-nav-tabs" role="tablist">
                        <div class="rb-sidebar-nav-header">
                            <span class="dashicons dashicons-menu-alt3"></span>
                            <span>بخش‌های تنظیمات</span>
                        </div>
                        <button type="button" class="rb-nav-tab active" data-tab="tab-home-slider">
                            <span class="dashicons dashicons-slides"></span>
                            <span>اسلایدر هیرو</span>
                        </button>
                        <button type="button" class="rb-nav-tab" data-tab="tab-home-elements">
                            <span class="dashicons dashicons-layout"></span>
                            <span>ماژول‌های صفحه اصلی</span>
                        </button>
                        <button type="button" class="rb-nav-tab" data-tab="tab-product-rails">
                            <span class="dashicons dashicons-grid-view"></span>
                            <span>ویترین‌ها و دسته‌ها</span>
                        </button>
                        <button type="button" class="rb-nav-tab" data-tab="tab-general">
                            <span class="dashicons dashicons-admin-generic"></span>
                            <span>عمومی و برندینگ</span>
                        </button>
                        <button type="button" class="rb-nav-tab" data-tab="tab-trust">
                            <span class="dashicons dashicons-shield"></span>
                            <span>نمادهای اعتماد</span>
                        </button>
                        <button type="button" class="rb-nav-tab" data-tab="tab-shop">
                            <span class="dashicons dashicons-cart"></span>
                            <span>فروشگاه و ووکامرس</span>
                        </button>
                        <button type="button" class="rb-nav-tab" data-tab="tab-social">
                            <span class="dashicons dashicons-share"></span>
                            <span>فوتر و شبکه‌ها</span>
                        </button>
                        <button type="button" class="rb-nav-tab" data-tab="tab-about">
                            <span class="dashicons dashicons-id-alt"></span>
                            <span>برگه درباره ما</span>
                        </button>
                        <button type="button" class="rb-nav-tab" data-tab="tab-contact">
                            <span class="dashicons dashicons-phone"></span>
                            <span>برگه تماس با ما</span>
                        </button>
                        <button type="button" class="rb-nav-tab" data-tab="tab-landing">
                            <span class="dashicons dashicons-megaphone"></span>
                            <span>نشریه آفتابگردان و فرود</span>
                        </button>
                    </div>
                </aside>

                <!-- Main Settings Content Column (Left in RTL) -->
                <main class="rb-main-content">

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
                        <div class="rb-field-group" style="margin-top:16px; padding-top:16px; border-top:1px solid #e2e8f0;">
                            <label class="rb-label">تصویر پس‌زمینه سراسری اسلایدر هیرو (اختیاری):</label>
                            <input type="url" name="rb_opt[hero_slider_bg]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('hero_slider_bg', '')); ?>" placeholder="https://site.com/slider-bg.jpg" style="direction:ltr;">
                            <p class="rb-help-text">در صورت وارد کردن لینک، این تصویر به عنوان بافت یا پس‌زمینه کل بخش اسلایدر هیرو با لایه تیره سبز قرار می‌گیرد.</p>
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
                            <div class="rb-card-header">
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <span class="rb-slide-number">اسلاید <?php echo esc_html(rashnubook_to_persian_numbers($s)); ?></span>
                                    <h3 style="margin:0; font-size:15px; color:var(--rb-text-primary);">
                                        <?php echo esc_html($slide['title'] ?: "اسلاید شماره {$s}"); ?>
                                    </h3>
                                </div>
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <span style="font-size:12px; color:var(--rb-text-secondary);">نمایش اسلاید:</span>
                                    <label class="rb-switch">
                                        <input type="checkbox" name="rb_opt[hero_slide_<?php echo $s; ?>_enable]" value="1" <?php checked($slide_active, '1'); ?>>
                                        <span class="rb-slider"></span>
                                    </label>
                                </div>
                            </div>

                            <!-- Slide Display Mode & Background -->
                            <div class="rb-callout">
                                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:16px;">
                                    <div class="rb-field-group" style="margin-bottom:0;">
                                        <label class="rb-label">حالت نمایش این اسلاید:</label>
                                        <select name="rb_opt[hero_slide_<?php echo $s; ?>_type]" class="rb-select" style="font-weight:700;">
                                            <option value="content" <?php selected(rashnubook_get_option("hero_slide_{$s}_type", 'content'), 'content'); ?>>حالت ۱: محتوایی (متن + موکاپ کتاب + دکمه خرید)</option>
                                            <option value="banner" <?php selected(rashnubook_get_option("hero_slide_{$s}_type", 'content'), 'banner'); ?>>حالت ۲: بنر گرافیکی تمام‌عرض (پوستر تبلیغاتی مثل عکس کتاب روی پارچه)</option>
                                        </select>
                                    </div>
                                    <div class="rb-field-group" style="margin-bottom:0;">
                                        <label class="rb-label">تصویر پس‌زمینه اختصاصی این اسلاید (اختیاری):</label>
                                        <div style="display:flex; gap:8px; align-items:center;">
                                            <input type="url" id="hero_bg_<?php echo $s; ?>" name="rb_opt[hero_slide_<?php echo $s; ?>_bg_image]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option("hero_slide_{$s}_bg_image", '')); ?>" placeholder="https://..." style="direction:ltr; flex:1;">
                                            <button type="button" class="button button-secondary rb-btn-upload" data-target="hero_bg_<?php echo $s; ?>" data-preview="hero_bg_prev_<?php echo $s; ?>" title="انتخاب تصویر از رسانه وردپرس">
                                                <span class="dashicons dashicons-upload" style="vertical-align:middle;"></span> رسانه
                                            </button>
                                            <button type="button" class="button rb-btn-remove-media" data-target="hero_bg_<?php echo $s; ?>" data-preview="hero_bg_prev_<?php echo $s; ?>">حذف</button>
                                        </div>
                                        <div id="hero_bg_prev_<?php echo $s; ?>" style="margin-top:6px; max-width:160px; max-height:80px; overflow:hidden; border-radius:4px;">
                                            <?php $bg_val = rashnubook_get_option("hero_slide_{$s}_bg_image", ''); if ($bg_val) : ?>
                                                <img src="<?php echo esc_url($bg_val); ?>" alt="پیش‌نمایش" style="max-width:100%; height:auto; display:block; border-radius:4px;">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Banner Mode Settings (Full-width Promotional Graphic) -->
                            <div class="rb-callout" style="border-right: 4px solid var(--rb-primary); background: #f0fdf4;">
                                <label class="rb-label" style="font-weight:800; color:#166534;">
                                    <span class="dashicons dashicons-format-image" style="vertical-align:middle;"></span>
                                    تنظیمات پوستر تبلیغاتی تمام‌عرض (حالت ۲ - بنر تصویری):
                                </label>
                                <p class="rb-help-text" style="color:#15803d; margin-bottom:10px;">
                                    برای نمایش بنر تبلیغاتی آماده (مانند عکس کتاب بسته‌بندی شده روی پارچه سبز، طرح جشنواره و...)، حالت بالا را روی «بنر گرافیکی تمام‌عرض» بگذارید و تصویر بنر را بارگذاری کنید.
                                </p>
                                <div style="display:grid; grid-template-columns: 1.3fr 0.7fr; gap:12px; margin-top:8px;">
                                    <div class="rb-field-group" style="margin-bottom:0;">
                                        <label class="rb-label" style="font-size:12px;">تصویر بنر پوستر (ابعاد پیشنهادی: ۱۹۲۰×۶۰۰ یا ۱۲۰۰×۵۰۰):</label>
                                        <div style="display:flex; gap:8px; align-items:center;">
                                            <input type="url" id="hero_banner_<?php echo $s; ?>" name="rb_opt[hero_slide_<?php echo $s; ?>_banner_image]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option("hero_slide_{$s}_banner_image", '')); ?>" placeholder="آدرس تصویر بنر" style="direction:ltr; flex:1;">
                                            <button type="button" class="button button-primary rb-btn-upload" data-target="hero_banner_<?php echo $s; ?>" data-preview="hero_banner_prev_<?php echo $s; ?>">
                                                <span class="dashicons dashicons-upload" style="vertical-align:middle;"></span> انتخاب تصویر بنر
                                            </button>
                                            <button type="button" class="button rb-btn-remove-media" data-target="hero_banner_<?php echo $s; ?>" data-preview="hero_banner_prev_<?php echo $s; ?>">حذف</button>
                                        </div>
                                        <div id="hero_banner_prev_<?php echo $s; ?>" style="margin-top:8px; max-width:260px; max-height:100px; overflow:hidden; border-radius:6px; border:1px solid #cbd5e1;">
                                            <?php $ban_val = rashnubook_get_option("hero_slide_{$s}_banner_image", ''); if ($ban_val) : ?>
                                                <img src="<?php echo esc_url($ban_val); ?>" alt="پیش‌نمایش بنر" style="width:100%; height:auto; display:block;">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="rb-field-group" style="margin-bottom:0;">
                                        <label class="rb-label" style="font-size:12px;">لینک کلیک روی بنر (اختیاری):</label>
                                        <input type="url" name="rb_opt[hero_slide_<?php echo $s; ?>_banner_link]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option("hero_slide_{$s}_banner_link", '')); ?>" placeholder="مثال: /shop/ یا لینک خرید" style="direction:ltr;">
                                    </div>
                                </div>
                            </div>

                            <!-- Live Product Selection -->
                            <div class="rb-callout" style="border-color: rgba(99, 102, 241, 0.25); background: rgba(99, 102, 241, 0.02);">
                                <label class="rb-label" style="font-size:13.5px;">
                                    <span class="dashicons dashicons-book" style="color:var(--rb-primary);"></span>
                                    انتخاب کتاب از محصولات ووکامرس برای این اسلاید:
                                </label>
                                <select name="rb_opt[hero_slide_<?php echo $s; ?>_product_id]" class="rb-select" style="font-weight:600;">
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
                                <p class="rb-help-text">
                                    💡 <strong>قابلیت هوشمند:</strong> با انتخاب هر کتاب، عنوان، نویسنده، قیمت روز، درصد تخفیف، لینک خرید و تصویر جلد (با افکت ۳بعدی عطف کتاب) به صورت خودکار واکشی می‌شود.
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
                                    <label class="rb-label">تصویر جلد یا عکس سفارشی کتاب (اختیاری):</label>
                                    <div style="display:flex; gap:8px; align-items:center;">
                                        <input type="url" id="hero_custom_img_<?php echo $s; ?>" name="rb_opt[hero_slide_<?php echo $s; ?>_image]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option("hero_slide_{$s}_image", '')); ?>" placeholder="https://..." style="direction:ltr; flex:1;">
                                        <button type="button" class="button button-secondary rb-btn-upload" data-target="hero_custom_img_<?php echo $s; ?>" data-preview="hero_custom_img_prev_<?php echo $s; ?>" title="انتخاب تصویر از رسانه وردپرس">
                                            <span class="dashicons dashicons-upload" style="vertical-align:middle;"></span> رسانه
                                        </button>
                                        <button type="button" class="button rb-btn-remove-media" data-target="hero_custom_img_<?php echo $s; ?>" data-preview="hero_custom_img_prev_<?php echo $s; ?>">حذف</button>
                                    </div>
                                    <div id="hero_custom_img_prev_<?php echo $s; ?>" style="margin-top:6px; max-width:120px; max-height:80px; overflow:hidden; border-radius:4px;">
                                        <?php $cimg_val = rashnubook_get_option("hero_slide_{$s}_image", ''); if ($cimg_val) : ?>
                                            <img src="<?php echo esc_url($cimg_val); ?>" alt="پیش‌نمایش" style="max-width:100%; height:auto; display:block; border-radius:4px;">
                                        <?php endif; ?>
                                    </div>
                                    <p class="rb-help-text">در صورت خالی بودن، تصویر محصول ووکامرس به صورت خودکار با افکت ۳بعدی نمایش می‌یابد.</p>
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
                                    <input type="text" name="rb_opt[hero_slide_<?php echo $s; ?>_btn1_text]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option("hero_slide_{$s}_btn1_text", $slide['btn1_text'])); ?>" placeholder="خرید با ارسال پستی">
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
                            <div class="rb-callout" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:14px; margin-top:12px;">
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

                    <!-- Section: Blog Reviews Config & Quick Article Manager -->
                    <div class="rb-card rb-card-full">
                        <div class="rb-card-header">
                            <div>
                                <h3 style="margin:0 0 4px; font-size:16px;">
                                    <span class="dashicons dashicons-welcome-write-blog" style="color:var(--rb-primary);"></span>
                                    بخش یادداشت‌ها و نقد کتاب (/blog/ و صفحه اصلی)
                                </h3>
                                <p style="margin:0; font-size:12px; color:#64748b;">تنظیمات سربرگ و ظاهر برگه یادداشت‌ها به همراه مدیریت سریع مقالات و نقدها</p>
                            </div>
                            <label class="rb-switch">
                                <input type="checkbox" name="rb_opt[home_blog_enable]" value="1" <?php checked($home_blog_enable, '1'); ?>>
                                <span class="rb-slider"></span>
                            </label>
                        </div>

                        <!-- Archive Page Header Texts -->
                        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:18px; margin-bottom:20px;">
                            <h4 style="margin:0 0 14px; font-size:14px; color:#1e293b; font-weight:800;">
                                <span class="dashicons dashicons-editor-textcolor"></span>
                                متون سربرگ صفحه یادداشت‌ها و نقد کتاب (قابل ویرایش):
                            </h4>
                            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:14px; margin-bottom:14px;">
                                <div class="rb-field-group" style="margin-bottom:0;">
                                    <label class="rb-label">ابرتایتل بالای عنوان (Eyebrow):</label>
                                    <input type="text" name="rb_opt[blog_archive_eyebrow]" class="rb-input-text" value="<?php echo esc_attr($blog_archive_eyebrow); ?>" placeholder="اندیشه‌ورزی و نگاه به جهان کتاب">
                                </div>
                                <div class="rb-field-group" style="margin-bottom:0;">
                                    <label class="rb-label">عنوان اصلی صفحه یادداشت‌ها و نقد کتاب:</label>
                                    <input type="text" name="rb_opt[blog_archive_title]" class="rb-input-text" value="<?php echo esc_attr($blog_archive_title); ?>" placeholder="یادداشت‌ها و نقد کتاب">
                                </div>
                            </div>
                            <div class="rb-field-group" style="margin-bottom:14px;">
                                <label class="rb-label">متن توضیحات و سرلوحه صفحه یادداشت‌ها:</label>
                                <textarea name="rb_opt[blog_archive_desc]" class="rb-textarea" rows="2" placeholder="مجموعه‌ای از جستارهای تحلیلی، معرفی تازه‌های نشر، نقد و بررسی شاهکارهای حقوقی و ادبی..."><?php echo esc_textarea($blog_archive_desc); ?></textarea>
                            </div>
                            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:14px;">
                                <div class="rb-field-group" style="margin-bottom:0;">
                                    <label class="rb-label">تعداد مقالات نمایشی در صفحه اصلی:</label>
                                    <input type="number" name="rb_opt[home_blog_count]" class="rb-input-text" value="<?php echo esc_attr($home_blog_count); ?>" min="1" max="12">
                                </div>
                                <div class="rb-field-group" style="margin-bottom:0;">
                                    <label class="rb-label">متن لینک مشاهده آرشیو در صفحه اصلی:</label>
                                    <input type="text" name="rb_opt[home_blog_link_text]" class="rb-input-text" value="<?php echo esc_attr($home_blog_link_text); ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Quick Post Management Table -->
                        <div style="background:#ffffff; border:1.5px solid #e2e8f0; border-radius:10px; padding:18px;">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; flex-wrap:wrap; gap:10px;">
                                <div>
                                    <h4 style="margin:0 0 4px; font-size:14px; color:#1e293b; font-weight:800;">
                                        <span class="dashicons dashicons-list-view"></span>
                                        فهرست آخرین یادداشت‌ها و مقالات منتشرشده در سایت
                                    </h4>
                                    <span style="font-size:12px; color:#64748b;">تمامی مقالات ثبت‌شده در بخش نوشته‌های وردپرس به صورت خودکار در صفحه آرشیو و صفحه اصلی قرار می‌گیرند.</span>
                                </div>
                                <div style="display:flex; gap:8px;">
                                    <a href="<?php echo esc_url(admin_url('post-new.php')); ?>" class="button button-primary" target="_blank">
                                        <span class="dashicons dashicons-plus-alt" style="vertical-align:middle;"></span> افزودن یادداشت جدید
                                    </a>
                                    <a href="<?php echo esc_url(admin_url('edit.php')); ?>" class="button button-secondary" target="_blank">
                                        <span class="dashicons dashicons-admin-post" style="vertical-align:middle;"></span> مدیریت کامل نوشته‌ها
                                    </a>
                                    <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="button button-secondary" target="_blank">
                                        <span class="dashicons dashicons-external" style="vertical-align:middle;"></span> مشاهده صفحه یادداشت‌ها
                                    </a>
                                </div>
                            </div>

                            <?php
                            $recent_articles = get_posts(array(
                                'post_type'      => 'post',
                                'posts_per_page' => 6,
                                'post_status'    => array('publish', 'draft'),
                            ));
                            ?>
                            <?php if (!empty($recent_articles)) : ?>
                                <table class="widefat striped" style="border:1px solid #e2e8f0; border-radius:6px; overflow:hidden;">
                                    <thead>
                                        <tr style="background:#f8fafc;">
                                            <th style="width:60px; text-align:center;">تصویر</th>
                                            <th>عنوان یادداشت / مقاله</th>
                                            <th style="width:140px;">دسته‌بندی</th>
                                            <th style="width:110px;">تاریخ</th>
                                            <th style="width:90px; text-align:center;">وضعیت</th>
                                            <th style="width:140px; text-align:center;">عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recent_articles as $art) :
                                            $art_thumb = get_the_post_thumbnail_url($art->ID, 'thumbnail');
                                            $art_cats  = get_the_category($art->ID);
                                            $art_cat   = !empty($art_cats) ? $art_cats[0]->name : 'نقد و بررسی';
                                            $art_status = ($art->post_status === 'publish') ? '<span style="color:#16a34a; font-weight:700;">منتشر شده</span>' : '<span style="color:#d97706; font-weight:700;">پیش‌نویس</span>';
                                        ?>
                                            <tr>
                                                <td style="text-align:center; padding:6px;">
                                                    <?php if ($art_thumb) : ?>
                                                        <img src="<?php echo esc_url($art_thumb); ?>" alt="" style="width:40px; height:40px; object-fit:cover; border-radius:4px;">
                                                    <?php else : ?>
                                                        <span style="display:inline-block; width:40px; height:40px; background:#e2e8f0; border-radius:4px; line-height:40px; font-size:18px;">📖</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <strong><a href="<?php echo esc_url(get_edit_post_link($art->ID)); ?>" target="_blank" style="color:#0f172a; text-decoration:none;"><?php echo esc_html($art->post_title); ?></a></strong>
                                                </td>
                                                <td style="color:#64748b; font-size:12.5px;"><?php echo esc_html($art_cat); ?></td>
                                                <td style="color:#64748b; font-size:12px;"><?php echo esc_html(rashnubook_to_persian_numbers(get_the_date('j F Y', $art->ID))); ?></td>
                                                <td style="text-align:center; font-size:12px;"><?php echo $art_status; // phpcs:ignore ?></td>
                                                <td style="text-align:center;">
                                                    <a href="<?php echo esc_url(get_edit_post_link($art->ID)); ?>" class="button button-small" target="_blank" title="ویرایش">ویرایش</a>
                                                    <a href="<?php echo esc_url(get_permalink($art->ID)); ?>" class="button button-small" target="_blank" title="مشاهده">مشاهده</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else : ?>
                                <div style="text-align:center; padding:24px; background:#f8fafc; border-radius:6px; color:#64748b;">
                                    هنوز مقاله‌ای ثبت نشده است. با کلیک بر روی دکمه «افزودن یادداشت جدید» می‌توانید اولین نقد یا مقاله خود را منتشر نمایید.
                                </div>
                            <?php endif; ?>
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
                        <h4 style="margin:16px 0 10px; color:var(--rb-text-primary); font-family:var(--rb-font-display); font-size:14.5px;">تنظیم کارت‌های ۵گانه دسته‌بندی موضوعی:</h4>
                        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:12px;">
                            <?php
                            $cat_cards = rashnubook_get_homepage_category_cards();
                            for ($c = 1; $c <= 5; $c++) :
                                $cc = $cat_cards[$c];
                            ?>
                                <div style="background:var(--rb-surface); border:1px solid var(--rb-border); border-radius:var(--rb-radius-md); padding:12px; transition: border-color 180ms ease;">
                                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                        <strong style="font-size:12px; color:var(--rb-text-primary);">کارت <?php echo esc_html(rashnubook_to_persian_numbers($c)); ?></strong>
                                        <label class="rb-switch" style="transform:scale(0.85); transform-origin:left center;">
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
                        <p class="rb-card-desc" style="margin-bottom:18px;">
                            در این بخش می‌توانید مشخص کنید کدام دسته‌بندی‌های کتاب در قالب ریل‌های چرخشی بی‌نهایت در صفحه اول ظاهر شوند:
                        </p>

                        <?php
                        $rails = rashnubook_get_homepage_rails();
                        for ($r = 1; $r <= 5; $r++) :
                            $rail = $rails[$r];
                        ?>
                            <div class="rb-callout" style="padding:18px; margin-bottom:16px;">
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; border-bottom:1px solid var(--rb-border); padding-bottom:10px;">
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <span class="rb-slide-number">ریل شماره <?php echo esc_html(rashnubook_to_persian_numbers($r)); ?></span>
                                        <h4 style="margin:0; font-size:14.5px; color:var(--rb-text-primary);"><?php echo esc_html($rail['title']); ?></h4>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <span style="font-size:12px; color:var(--rb-text-secondary);">فعال‌سازی این ریل:</span>
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
                                                 <?php foreach ($wc_categories as $cslug => $cinfo) :
                                                     $c_label     = is_array($cinfo) ? $cinfo['label'] : $cinfo;
                                                     $c_slug_val  = is_array($cinfo) ? $cinfo['slug'] : $cslug;
                                                     $c_decoded   = is_array($cinfo) ? $cinfo['slug_decoded'] : urldecode($cslug);
                                                     $rail_cat_dec = urldecode($rail['cat']);
                                                     $is_selected = (!empty($rail['cat']) && ($rail['cat'] === $c_slug_val || $rail_cat_dec === $c_decoded || $rail_cat_dec === urldecode($c_slug_val)));
                                                 ?>
                                                     <option value="<?php echo esc_attr($c_slug_val); ?>" <?php selected($is_selected, true); ?>>
                                                         📚 <?php echo esc_html($c_label); ?>
                                                     </option>
                                                 <?php endforeach; ?>
                                             <?php else : ?>
                                                 <?php if (!empty($rail['cat'])) : ?>
                                                     <option value="<?php echo esc_attr($rail['cat']); ?>" selected><?php echo esc_html($rail['cat']); ?></option>
                                                 <?php endif; ?>
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

                                     <div class="rb-field-group" style="grid-column: span 1;">
                                         <label class="rb-label">تعداد محصولات ریل چرخشی (حداکثر ۸):</label>
                                         <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                                             <input type="number" id="home_rail_<?php echo $r; ?>_count_input" name="rb_opt[home_rail_<?php echo $r; ?>_count]" class="rb-input-text" value="<?php echo esc_attr(min(8, max(1, (int)($rail['count'] ?: 8)))); ?>" min="1" max="8" style="max-width:90px; font-weight:700; text-align:center;">
                                             <div style="display:flex; gap:4px; flex-wrap:wrap; align-items:center;">
                                                 <button type="button" class="button button-small rb-count-preset-btn" data-target="home_rail_<?php echo $r; ?>_count_input" data-count="4">۴ محصول</button>
                                                 <button type="button" class="button button-small rb-count-preset-btn" data-target="home_rail_<?php echo $r; ?>_count_input" data-count="6">۶ محصول</button>
                                                 <button type="button" class="button button-small rb-count-preset-btn" data-target="home_rail_<?php echo $r; ?>_count_input" data-count="8">۸ محصول</button>
                                             </div>
                                         </div>
                                         <p class="rb-help-text" style="margin-top:4px; color:#b83b26; font-weight:600;">فقط ۸ محصول قابلیت نمایش ریلی دارند.</p>
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

                    <div class="rb-card">
                        <div class="rb-card-header">
                            <h3>منوی کشویی موبایل (Drawer)</h3>
                            <label class="rb-switch">
                                <input type="checkbox" name="rb_opt[drawer_cats_enable]" value="1" <?php checked($drawer_cats_enable, '1'); ?>>
                                <span class="rb-slider"></span>
                            </label>
                        </div>
                        <div class="rb-field-group">
                            <label class="rb-label">نمایش دسته‌بندی‌های موضوعی در منوی موبایل:</label>
                            <p class="rb-help-text">با فعال بودن این گزینه، دسته‌بندی‌های زنده کتاب‌ها و تعداد عناوین موجود در منوی کشویی گوشی به زیبایی نمایش داده می‌شوند. در صورت عدم تمایل می‌توانید آن را خاموش کنید.</p>
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
                        'shipping' => 'ارسال سریع پستی (Shipping)',
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
                            <label class="rb-label">سقف سفارش برای ارسال پستی (تومان):</label>
                            <input type="text" name="rb_opt[free_shipping]" class="rb-input-text" value="<?php echo esc_attr($free_shipping); ?>">
                            <p class="rb-help-text">مبلغ خریدی که پس از آن ارسال پستی به سراسر کشور فعال یا تخفیف‌دار محاسبه می‌شود (در صورت تمایل به تعیین سقف).</p>
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

                    <div class="rb-card rb-card-full">
                        <div class="rb-card-header">
                            <h3>
                                <span class="dashicons dashicons-id-alt"></span>
                                فیلد شناسه / آیدی تلگرام در صفحه تسویه‌حساب (Checkout)
                            </h3>
                        </div>
                        <div class="rb-field-group">
                            <label class="rb-label">شرط نمایش و الزامی بودن شناسه تلگرام خریدار:</label>
                            <select name="rb_opt[checkout_telegram_field_rule]" class="rb-input-text" style="max-width:450px;">
                                <option value="magazine" <?php selected($checkout_telegram_field_rule, 'magazine'); ?>>فقط هنگام سفارش نشریه / مجله آفتابگردان (اجباری) - توصیه‌شده</option>
                                <option value="always" <?php selected($checkout_telegram_field_rule, 'always'); ?>>در تمامی سفارش‌های فروشگاه نمایش داده شود و اجباری باشد</option>
                                <option value="0" <?php selected($checkout_telegram_field_rule, '0'); ?>>غیرفعال و مخفی‌سازی کامل فیلد شناسه تلگرام</option>
                            </select>
                            <p class="rb-help-text">اگر گزینه اول فعال باشد، زمانی که کاربر نشریه (آفتابگردان) را در سبد خرید داشته باشد، فیلد آیدی تلگرام در مرحله پرداخت به عنوان فیلد ضروری نشان داده می‌شود تا فایل‌ها و ویژه‌نامه‌های صوتی و دیجیتال برای وی ارسال گردد.</p>
                        </div>
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

                    <!-- Footer Navigation Columns (Cols 2 & 3: Important Links & Selected Topics) -->
                    <div class="rb-card rb-card-full">
                        <div class="rb-card-header">
                            <h3>
                                <span class="dashicons dashicons-admin-links"></span>
                                مدیریت ستون‌های پیوند و دسته‌ها در پاورقی (فوتر)
                            </h3>
                        </div>
                        <p class="rb-card-desc" style="margin-bottom:16px;">
                            در این بخش می‌توانید ستون‌های ۲ (پیوندهای مهم) و ۳ (موضوعات برگزیده) در فوتر را ویرایش، فعال/غیرفعال کرده یا پیوندهای جدیدی به آن‌ها اضافه کنید. همچنین می‌توانید از بخش <strong>نمایش &gt; فهرست‌ها</strong> در پیشخوان وردپرس، منوهای اختصاصی برای هر ستون («ستون ۲: پیوندهای مهم» و «ستون ۳: موضوعات برگزیده») تعریف نمایید.
                        </p>
                        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:20px;">
                            <!-- Column 2: Important Links -->
                            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:16px;">
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                                    <h4 style="margin:0; font-size:14px; color:#1e293b; font-weight:700;">ستون ۲: پیوندهای مهم</h4>
                                    <label class="rb-switch">
                                        <input type="checkbox" name="rb_opt[footer_col2_enable]" value="1" <?php checked($footer_col2_enable, '1'); ?>>
                                        <span class="rb-slider"></span>
                                    </label>
                                </div>
                                <div class="rb-field-group">
                                    <label class="rb-label">عنوان ستون:</label>
                                    <input type="text" name="rb_opt[footer_col2_title]" class="rb-input-text" value="<?php echo esc_attr($footer_col2_title); ?>" placeholder="پیوندهای مهم">
                                </div>
                                <div class="rb-field-group" style="margin-bottom:0;">
                                    <label class="rb-label">پیوندهای سفارشی (هر سطر یک پیوند با فرمت: عنوان | نشانی):</label>
                                    <textarea name="rb_opt[footer_col2_links]" class="rb-textarea" rows="6" placeholder="صفحه اصلی | /
ویترین کتاب‌ها | /shop/
درباره ما | /about-us/
تماس با ما | /contact-us/"><?php echo esc_textarea($footer_col2_links); ?></textarea>
                                    <p class="rb-help-text">در صورت خالی بودن این فیلد، گزینه‌های پیش‌فرض قالب یا منوی ثبت‌شده در وردپرس نمایش داده می‌شود.</p>
                                </div>
                            </div>

                            <!-- Column 3: Selected Topics -->
                            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:16px;">
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                                    <h4 style="margin:0; font-size:14px; color:#1e293b; font-weight:700;">ستون ۳: موضوعات برگزیده</h4>
                                    <label class="rb-switch">
                                        <input type="checkbox" name="rb_opt[footer_col3_enable]" value="1" <?php checked($footer_col3_enable, '1'); ?>>
                                        <span class="rb-slider"></span>
                                    </label>
                                </div>
                                <div class="rb-field-group">
                                    <label class="rb-label">عنوان ستون:</label>
                                    <input type="text" name="rb_opt[footer_col3_title]" class="rb-input-text" value="<?php echo esc_attr($footer_col3_title); ?>" placeholder="موضوعات برگزیده">
                                </div>
                                <div class="rb-field-group" style="margin-bottom:0;">
                                    <label class="rb-label">پیوندهای سفارشی (هر سطر یک پیوند با فرمت: عنوان | نشانی):</label>
                                    <textarea name="rb_opt[footer_col3_links]" class="rb-textarea" rows="6" placeholder="کتب تخصصی حقوقی | /shop/?product_cat=law-books
ادبیات داستانی و رمان | /shop/?product_cat=fiction
فلسفه و منطق | /shop/?product_cat=philosophy"><?php echo esc_textarea($footer_col3_links); ?></textarea>
                                    <p class="rb-help-text">در صورت خالی بودن این فیلد، گزینه‌های پیش‌فرض قالب یا منوی ثبت‌شده در وردپرس نمایش داده می‌شود.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Newsletter Configuration & Subscribers -->
                    <div class="rb-card rb-card-full">
                        <div class="rb-card-header">
                            <h3>
                                <span class="dashicons dashicons-email-alt"></span>
                                خبرنامه ایمیلی فوتر و فهرست مشترکین (Newsletter)
                            </h3>
                            <div style="display:flex; align-items:center; gap:12px;">
                                <span style="font-size:12px; color:#64748b;">فعال‌سازی جعبه خبرنامه در فوتر:</span>
                                <label class="rb-switch">
                                    <input type="checkbox" name="rb_opt[footer_newsletter_enable]" value="1" <?php checked(rashnubook_get_option('footer_newsletter_enable', '1') !== '0'); ?>>
                                    <span class="rb-slider"></span>
                                </label>
                            </div>
                        </div>
                        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:16px; margin-bottom:20px;">
                            <div class="rb-field-group" style="margin-bottom:0;">
                                <label class="rb-label">عنوان بالای فیلد خبرنامه در فوتر:</label>
                                <input type="text" name="rb_opt[footer_newsletter_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('footer_newsletter_title', 'عضویت در خبرنامه یادداشت‌های ادبی و حقوقی:')); ?>">
                            </div>
                            <div class="rb-field-group" style="margin-bottom:0;">
                                <label class="rb-label">نام کاربری اینستاگرام فوتر (@handle):</label>
                                <input type="text" name="rb_opt[instagram]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('instagram', 'rashno_book')); ?>" placeholder="rashno_book" style="direction:ltr;">
                            </div>
                        </div>

                        <!-- Registered Subscribers List -->
                        <?php
                        $subscribers = get_option('rashnubook_newsletter_subscribers', array());
                        $sub_count = count($subscribers);
                        ?>
                        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:16px;">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                                <h4 style="margin:0; font-size:14px; color:#1e293b;">
                                    فهرست ایمیل‌های ثبت‌شده در خبرنامه (<?php echo esc_html(rashnubook_to_persian_numbers($sub_count)); ?> نفر)
                                </h4>
                            </div>
                            <?php if (!empty($subscribers)) : ?>
                                <table class="widefat striped" style="border:1px solid #cbd5e1; border-radius:6px; overflow:hidden;">
                                    <thead>
                                        <tr style="background:#f1f5f9;">
                                            <th style="width:50px; text-align:center;">#</th>
                                            <th>نشانی ایمیل</th>
                                            <th style="width:180px;">تاریخ عضویت</th>
                                            <th style="width:130px;">نشانی IP</th>
                                            <th style="width:90px; text-align:center;">عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (array_reverse($subscribers) as $idx => $sub) :
                                            $del_nonce = wp_create_nonce('rashnu_delete_sub_action');
                                            $del_url = add_query_arg(array(
                                                'page' => 'rashnubook-settings',
                                                'delete_subscriber' => urlencode($sub['email'] ?? ''),
                                                '_sub_nonce' => $del_nonce,
                                            ), admin_url('admin.php'));
                                        ?>
                                            <tr>
                                                <td style="text-align:center;"><?php echo esc_html(rashnubook_to_persian_numbers($idx + 1)); ?></td>
                                                <td><strong style="direction:ltr; display:inline-block;"><?php echo esc_html($sub['email'] ?? '-'); ?></strong></td>
                                                <td><?php echo esc_html(rashnubook_to_persian_numbers($sub['date'] ?? '-')); ?></td>
                                                <td style="direction:ltr;"><?php echo esc_html($sub['ip'] ?? '-'); ?></td>
                                                <td style="text-align:center;">
                                                    <a href="<?php echo esc_url($del_url); ?>" onclick="return confirm('آیا از حذف این مشترک خبرنامه مطمئن هستید؟');" class="button button-small" style="color:#b91c1c; border-color:#fca5a5;">
                                                        حذف
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else : ?>
                                <p style="margin:0; font-size:13px; color:#64748b;">تاکنون مشترکی در خبرنامه ثبت‌نام نکرده است. به محض ارسال فرم توسط کاربران در فوتر، اطلاعات در این جدول درج می‌شود.</p>
                            <?php endif; ?>
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

            <!-- TAB: ABOUT US PAGE BUILDER -->
            <div id="tab-about" class="rb-tab-content">
                <div class="rb-grid">
                    <div class="rb-card rb-card-full">
                        <div class="rb-card-header">
                            <div>
                                <h3>
                                    <span class="dashicons dashicons-id-alt"></span>
                                    تنظیمات اختصاصی و صفحه‌ساز برگه «درباره ما» (/about-us/)
                                </h3>
                                <p class="rb-card-desc">
                                    امکان ویرایش کامل متون، بنر هیرو، نوار آمار و ارقام، ارکان دوگانه، مزایای متمایز و اطلاعات مدیریت
                                </p>
                            </div>
                            <div>
                                <a href="<?php echo esc_url(home_url('/about-us/')); ?>" target="_blank" class="rb-btn-secondary">
                                    <span class="dashicons dashicons-external"></span>
                                    مشاهده برگه درباره ما
                                </a>
                            </div>
                        </div>

                        <!-- 1. HERO BANNER -->
                        <div class="rb-builder-section">
                            <div class="rb-builder-header">
                                <h4 class="rb-builder-title">
                                    <span class="dashicons dashicons-format-image"></span>
                                    بخش ۱: بنر سربرگ (Hero Banner)
                                </h4>
                                <label class="rb-switch">
                                    <input type="checkbox" name="rb_opt[about_hero_enable]" value="1" <?php checked(rashnubook_get_option('about_hero_enable', '1'), '1'); ?>>
                                    <span class="rb-slider"></span>
                                </label>
                            </div>
                            <div class="rb-builder-body">
                                <div style="display:grid; grid-template-columns: 1fr 2fr; gap:16px;">
                                    <div class="rb-field-group">
                                        <label class="rb-label">نشان بالای تیتر (Badge):</label>
                                        <input type="text" name="rb_opt[about_hero_badge]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_hero_badge', 'کتابفروشی آنلاین رَشن • راسته کتابفروشان دانشگاه تهران')); ?>">
                                    </div>
                                    <div class="rb-field-group">
                                        <label class="rb-label">عنوان اصلی صفحه درباره ما:</label>
                                        <input type="text" name="rb_opt[about_hero_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_hero_title', 'روایت کتابفروشی آنلاین رَشن')); ?>">
                                    </div>
                                </div>
                                <div class="rb-field-group" style="margin-top:10px;">
                                    <label class="rb-label">متن لید / پاراگراف معرفی بالای صفحه:</label>
                                    <textarea name="rb_opt[about_hero_desc]" class="rb-textarea" rows="3"><?php echo esc_textarea(rashnubook_get_option('about_hero_desc', 'پایگاهی برای شیفتگان اندیشه، ادبیات فاخر و منابع تخصصی حقوقی. ما متعهد به گزینش و عرضه معتبرترین آثار مکتوب، ویرایش دقیق، کاغذ مرغوب و ارسال پستی کتاب به سراسر ایران هستیم.')); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- 2. STATS BAR -->
                        <div class="rb-builder-section">
                            <div class="rb-builder-header">
                                <h4 class="rb-builder-title">
                                    <span class="dashicons dashicons-chart-area"></span>
                                    بخش ۲: نوار آمار و ارقام کلیدی (Stats Counter)
                                </h4>
                                <label class="rb-switch">
                                    <input type="checkbox" name="rb_opt[about_stats_enable]" value="1" <?php checked(rashnubook_get_option('about_stats_enable', '1'), '1'); ?>>
                                    <span class="rb-slider"></span>
                                </label>
                            </div>
                            <div class="rb-builder-body">
                                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">
                                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:12px;">
                                        <label class="rb-label">آمار ۱ (سبز): عدد و عنوان</label>
                                        <input type="text" name="rb_opt[about_stat_1_num]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_stat_1_num', '۱۵,۰۰۰+')); ?>" style="margin-bottom:8px; font-weight:800;">
                                        <input type="text" name="rb_opt[about_stat_1_text]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_stat_1_text', 'عنوان کتاب حقوقی و ادبی برگزیده')); ?>" style="font-size:12px;">
                                    </div>
                                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:12px;">
                                        <label class="rb-label">آمار ۲ (آجری): عدد و عنوان</label>
                                        <input type="text" name="rb_opt[about_stat_2_num]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_stat_2_num', '۱۰۰٪')); ?>" style="margin-bottom:8px; font-weight:800;">
                                        <input type="text" name="rb_opt[about_stat_2_text]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_stat_2_text', 'ضمانت اصالت نسخه و چاپ قانونی')); ?>" style="font-size:12px;">
                                    </div>
                                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:12px;">
                                        <label class="rb-label">آمار ۳ (خاکستری/سرمه‌ای): عدد و عنوان</label>
                                        <input type="text" name="rb_opt[about_stat_3_num]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_stat_3_num', 'پستی')); ?>" style="margin-bottom:8px; font-weight:800;">
                                        <input type="text" name="rb_opt[about_stat_3_text]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_stat_3_text', 'ارسال با پست پیشتاز به تمام نقاط کشور')); ?>" style="font-size:12px;">
                                    </div>
                                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:12px;">
                                        <label class="rb-label">آمار ۴ (موکا): عدد و عنوان</label>
                                        <input type="text" name="rb_opt[about_stat_4_num]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_stat_4_num', 'ماهنامه')); ?>" style="margin-bottom:8px; font-weight:800;">
                                        <input type="text" name="rb_opt[about_stat_4_text]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_stat_4_text', 'انتشار نشریه تخصصی آفتابگردان')); ?>" style="font-size:12px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. STORY & PHILOSOPHY -->
                        <div class="rb-builder-section">
                            <div class="rb-builder-header">
                                <h4 class="rb-builder-title">
                                    <span class="dashicons dashicons-book"></span>
                                    بخش ۳: فلسفه و رسالت رَشن (Story & Philosophy)
                                </h4>
                                <label class="rb-switch">
                                    <input type="checkbox" name="rb_opt[about_story_enable]" value="1" <?php checked(rashnubook_get_option('about_story_enable', '1'), '1'); ?>>
                                    <span class="rb-slider"></span>
                                </label>
                            </div>
                            <div class="rb-builder-body">
                                <div style="display:grid; grid-template-columns: 1fr 2fr; gap:16px;">
                                    <div class="rb-field-group">
                                        <label class="rb-label">ابرتایتل (Eyebrow):</label>
                                        <input type="text" name="rb_opt[about_story_eyebrow]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_story_eyebrow', 'فلسفه و نام رَشن')); ?>">
                                    </div>
                                    <div class="rb-field-group">
                                        <label class="rb-label">تیتر بخش داستان:</label>
                                        <input type="text" name="rb_opt[about_story_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_story_title', 'رسالت و آرمان کتابفروشی آنلاین رَشن')); ?>">
                                    </div>
                                </div>
                                <div class="rb-field-group" style="margin-top:10px;">
                                    <label class="rb-label">پاراگراف اول داستان و وجه تسمیه رشن:</label>
                                    <textarea name="rb_opt[about_story_p1]" class="rb-textarea" rows="3"><?php echo esc_textarea(rashnubook_get_option('about_story_p1', 'کتابفروشی آنلاین رَشن با تکیه بر اصالت فرهنگی و تعهد به ژرفای اندیشه، در قلب راسته کتابفروشان خیابان انقلاب و دانشگاه تهران پایه‌گذاری شد. نام «رَشن» در فرهنگ و اساطیر کهن ایرانی، ایزد دادگری، عدالت و داوری راستین است؛ ایزدی که ترازوی سنجش حقیقت را در دست دارد و از هرگونه ناراستی به دور است.')); ?></textarea>
                                </div>
                                <div class="rb-field-group" style="margin-top:10px;">
                                    <label class="rb-label">پاراگراف دوم رسالت بنیادین کتاب‌سرا:</label>
                                    <textarea name="rb_opt[about_story_p2]" class="rb-textarea" rows="3"><?php echo esc_textarea(rashnubook_get_option('about_story_p2', 'از همین رو، بنیادین‌ترین رسالت کتابفروشی آنلاین رَشن بر دو محور اصیل استوار گشته است: نشر و عرضه معتبرترین منابع دانشگاهی و آزمونی حقوق و بازخوانی فاخرترین شاهکارهای ادبیات داستانی، فلسفه و شعر معاصر.')); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- 4. TWO PILLARS -->
                        <div class="rb-builder-section">
                            <div class="rb-builder-header">
                                <h4 class="rb-builder-title">
                                    <span class="dashicons dashicons-columns"></span>
                                    بخش ۴: دو رکن و ستون اصلی کتاب‌سرا (کتب حقوقی و ادبی)
                                </h4>
                                <label class="rb-switch">
                                    <input type="checkbox" name="rb_opt[about_pillars_enable]" value="1" <?php checked(rashnubook_get_option('about_pillars_enable', '1'), '1'); ?>>
                                    <span class="rb-slider"></span>
                                </label>
                            </div>
                            <div class="rb-builder-body">
                                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
                                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:16px;">
                                        <div style="display:flex; gap:10px; margin-bottom:10px;">
                                            <div style="width:60px;">
                                                <label class="rb-label">آیکون:</label>
                                                <input type="text" name="rb_opt[about_pillar1_icon]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_pillar1_icon', '⚖️')); ?>" style="text-align:center; font-size:18px;">
                                            </div>
                                            <div style="flex:1;">
                                                <label class="rb-label">عنوان رکن اول:</label>
                                                <input type="text" name="rb_opt[about_pillar1_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_pillar1_title', 'بخش کتب تخصصی حقوقی')); ?>">
                                            </div>
                                        </div>
                                        <div class="rb-field-group">
                                            <label class="rb-label">توضیحات رکن اول:</label>
                                            <textarea name="rb_opt[about_pillar1_desc]" class="rb-textarea" rows="3"><?php echo esc_textarea(rashnubook_get_option('about_pillar1_desc', 'مرجع جامع منابع دست‌اول آزمون‌های وکالت، قضاوت، سردفتری و ارشد حقوق با آخرین اصلاحات و تحریرهای قانونی. ارائه آثاری از استادان بنام حقوق ایران چون دکتر کاتوزیان، دکتر لنگرودی و دکتر شمس.')); ?></textarea>
                                        </div>
                                    </div>

                                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:16px;">
                                        <div style="display:flex; gap:10px; margin-bottom:10px;">
                                            <div style="width:60px;">
                                                <label class="rb-label">آیکون:</label>
                                                <input type="text" name="rb_opt[about_pillar2_icon]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_pillar2_icon', '📖')); ?>" style="text-align:center; font-size:18px;">
                                            </div>
                                            <div style="flex:1;">
                                                <label class="rb-label">عنوان رکن دوم:</label>
                                                <input type="text" name="rb_opt[about_pillar2_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_pillar2_title', 'شاهکارهای ادبی و فلسفه')); ?>">
                                            </div>
                                        </div>
                                        <div class="rb-field-group">
                                            <label class="rb-label">توضیحات رکن دوم:</label>
                                            <textarea name="rb_opt[about_pillar2_desc]" class="rb-textarea" rows="3"><?php echo esc_textarea(rashnubook_get_option('about_pillar2_desc', 'گزینش فاخرترین رمان‌های کلاسیک و معاصر با بهترین ترجمه‌ها و معتبرترین ویراست‌ها، کتب فلسفی تألیفی و ترجمه، و دیوان‌های نفیس شاعران بزرگ با کاغذ باکیفیت و صحافی مقاوم.')); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 5. WHY CHOOSE US -->
                        <div class="rb-builder-section">
                            <div class="rb-builder-header">
                                <h4 class="rb-builder-title">
                                    <span class="dashicons dashicons-yes-alt"></span>
                                    بخش ۵: چرا کتابفروشی آنلاین رَشن انتخابی متمایز است؟
                                </h4>
                                <label class="rb-switch">
                                    <input type="checkbox" name="rb_opt[about_features_enable]" value="1" <?php checked(rashnubook_get_option('about_features_enable', '1'), '1'); ?>>
                                    <span class="rb-slider"></span>
                                </label>
                            </div>
                            <div class="rb-builder-body">
                                <div class="rb-field-group" style="margin-bottom:16px;">
                                    <label class="rb-label">تیتر این بخش:</label>
                                    <input type="text" name="rb_opt[about_features_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_features_title', 'چرا کتابفروشی آنلاین رَشن انتخابی متمایز است؟')); ?>">
                                </div>
                                <div style="display:flex; flex-direction:column; gap:12px;">
                                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:12px;">
                                        <label class="rb-label">ویژگی ۱: عنوان و توضیحات</label>
                                        <input type="text" name="rb_opt[about_feat1_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_feat1_title', 'گزینش علمی و بی‌طرفانه آثار:')); ?>" style="margin-bottom:6px; font-weight:700;">
                                        <textarea name="rb_opt[about_feat1_desc]" class="rb-textarea" rows="2"><?php echo esc_textarea(rashnubook_get_option('about_feat1_desc', 'تمامی کتاب‌های موجود در کتابفروشی از میان بهترین چاپ‌ها، باکیفیت‌ترین ترجمه‌ها و معتبرترین ویراست‌ها گلچین شده‌اند.')); ?></textarea>
                                    </div>
                                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:12px;">
                                        <label class="rb-label">ویژگی ۲: عنوان و توضیحات</label>
                                        <input type="text" name="rb_opt[about_feat2_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_feat2_title', 'ارسال پستی به تمام نقاط کشور:')); ?>" style="margin-bottom:6px; font-weight:700;">
                                        <textarea name="rb_opt[about_feat2_desc]" class="rb-textarea" rows="2"><?php echo esc_textarea(rashnubook_get_option('about_feat2_desc', 'ما معتقدیم فاصله جغرافیایی نباید مانع دسترسی آزاد به کتاب‌های مرجع باشد؛ از این رو، تمامی بسته‌ها با بسته‌بندی نفیس، مقاوم و نشانک هدیه از طریق پست پیشتاز به سراسر ایران ارسال می‌شوند.')); ?></textarea>
                                    </div>
                                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:12px;">
                                        <label class="rb-label">ویژگی ۳: عنوان و توضیحات</label>
                                        <input type="text" name="rb_opt[about_feat3_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_feat3_title', 'انتشار ماهنامه تخصصی آفتابگردان:')); ?>" style="margin-bottom:6px; font-weight:700;">
                                        <textarea name="rb_opt[about_feat3_desc]" class="rb-textarea" rows="2"><?php echo esc_textarea(rashnubook_get_option('about_feat3_desc', 'نشریه ماهانه نقد ادبی و حقوقی رَشن، بستری برای گفتگو و ارتباط مستمر میان خوانندگان، دانشجویان و استادان است.')); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 6. MANAGEMENT & ACTION BUTTONS -->
                        <div class="rb-builder-section">
                            <div class="rb-builder-header">
                                <h4 class="rb-builder-title">
                                    <span class="dashicons dashicons-businessman"></span>
                                    بخش ۶: اطلاعات مدیریت و دکمه‌های اقدام پایین صفحه
                                </h4>
                                <label class="rb-switch">
                                    <input type="checkbox" name="rb_opt[about_manager_enable]" value="1" <?php checked(rashnubook_get_option('about_manager_enable', '1'), '1'); ?>>
                                    <span class="rb-slider"></span>
                                </label>
                            </div>
                            <div class="rb-builder-body">
                                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px; margin-bottom:16px;">
                                    <div class="rb-field-group">
                                        <label class="rb-label">نام و عنوان مدیریت:</label>
                                        <input type="text" name="rb_opt[about_manager_name]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_manager_name', 'مدیریت کتابفروشی آنلاین رَشن: رادین')); ?>">
                                    </div>
                                    <div class="rb-field-group">
                                        <label class="rb-label">سمت و زیرعنوان پاسخگویی:</label>
                                        <input type="text" name="rb_opt[about_manager_role]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_manager_role', 'پاسخگوی اهالی کتاب و جامعه حقوقی ایران')); ?>">
                                    </div>
                                </div>
                                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
                                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:12px;">
                                        <label class="rb-label">دکمه اول (مشاهده ویترین): متن و لینک</label>
                                        <input type="text" name="rb_opt[about_btn1_text]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_btn1_text', 'مشاهده ویترین کتاب‌ها')); ?>" style="margin-bottom:8px;">
                                        <input type="text" name="rb_opt[about_btn1_url]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_btn1_url', '')); ?>" placeholder="پیش‌فرض: فروشگاه" style="direction:ltr; font-size:12px;">
                                    </div>
                                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:12px;">
                                        <label class="rb-label">دکمه دوم (تماس با ما): متن و لینک</label>
                                        <input type="text" name="rb_opt[about_btn2_text]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_btn2_text', 'تماس با کتابفروشی')); ?>" style="margin-bottom:8px;">
                                        <input type="text" name="rb_opt[about_btn2_url]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('about_btn2_url', '')); ?>" placeholder="پیش‌فرض: برگه تماس با ما" style="direction:ltr; font-size:12px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- TAB: CONTACT US PAGE BUILDER -->
            <div id="tab-contact" class="rb-tab-content">
                <div class="rb-grid">
                    <div class="rb-card rb-card-full">
                        <div class="rb-card-header">
                            <div>
                                <h3>
                                    <span class="dashicons dashicons-phone"></span>
                                    تنظیمات اختصاصی و صفحه‌ساز برگه «تماس با ما» (/contact-us/)
                                </h3>
                                <p class="rb-card-desc">
                                    مدیریت تمامی اطلاعات نشانی، تلفن‌ها، ساعات کاری، اینستاگرام، گزینه‌های فرم پیام مستقیم و شورت‌کد
                                </p>
                            </div>
                            <div>
                                <a href="<?php echo esc_url(home_url('/contact-us/')); ?>" target="_blank" class="rb-btn-secondary">
                                    <span class="dashicons dashicons-external"></span>
                                    مشاهده برگه تماس با ما
                                </a>
                            </div>
                        </div>

                        <!-- 1. PAGE HEADER -->
                        <div class="rb-builder-section">
                            <div class="rb-builder-header">
                                <h4 class="rb-builder-title">
                                    <span class="dashicons dashicons-heading"></span>
                                    بخش ۱: سربرگ صفحه تماس (Page Header)
                                </h4>
                            </div>
                            <div class="rb-builder-body">
                                <div class="rb-field-group" style="margin-bottom:12px;">
                                    <label class="rb-label">عنوان اصلی صفحه تماس با ما:</label>
                                    <input type="text" name="rb_opt[contact_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('contact_title', 'تماس با کتابفروشی آنلاین رَشن')); ?>">
                                </div>
                                <div class="rb-field-group">
                                    <label class="rb-label">توضیحات زیر عنوان:</label>
                                    <textarea name="rb_opt[contact_subtitle]" class="rb-textarea" rows="2"><?php echo esc_textarea(rashnubook_get_option('contact_subtitle', 'مشاوران و همکاران ما در بخش پشتیبانی، فروش و مشاوره‌های حقوقی آماده پاسخگویی به پرسش‌ها و سفارش‌های شما هستند.')); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- 2. CONTACT INFO CARD -->
                        <div class="rb-builder-section">
                            <div class="rb-builder-header">
                                <h4 class="rb-builder-title">
                                    <span class="dashicons dashicons-location-alt"></span>
                                    بخش ۲: کارت اطلاعات تماس و نشانی فروشگاه (ستون راست)
                                </h4>
                            </div>
                            <div class="rb-builder-body">
                                <div style="display:grid; grid-template-columns: 1fr 2fr; gap:16px; margin-bottom:16px;">
                                    <div class="rb-field-group">
                                        <label class="rb-label">ابرتایتل کارت:</label>
                                        <input type="text" name="rb_opt[contact_info_eyebrow]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('contact_info_eyebrow', 'ارتباط با ما')); ?>">
                                    </div>
                                    <div class="rb-field-group">
                                        <label class="rb-label">تیتر کارت اطلاعات تماس:</label>
                                        <input type="text" name="rb_opt[contact_info_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('contact_info_title', 'اطلاعات تماس و نشانی فروشگاه')); ?>">
                                    </div>
                                </div>

                                <!-- Address -->
                                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:14px; margin-bottom:14px;">
                                    <div class="rb-field-group" style="margin-bottom:8px;">
                                        <label class="rb-label">برچسب نشانی فیزیکی:</label>
                                        <input type="text" name="rb_opt[contact_address_label]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('contact_address_label', 'نشانی دفتر مرکزی و کتابفروشی:')); ?>">
                                    </div>
                                    <div class="rb-field-group" style="margin-bottom:0;">
                                        <label class="rb-label">متن دقیق نشانی فروشگاه:</label>
                                        <textarea name="rb_opt[contact_address_val]" class="rb-textarea" rows="2"><?php echo esc_textarea(rashnubook_get_option('contact_address_val', 'تهران، میدان انقلاب اسلامی، روبروی دانشگاه تهران، راسته ناشران و کتابفروشان، کتابفروشی آنلاین رَشن')); ?></textarea>
                                    </div>
                                </div>

                                <!-- Phone & Email -->
                                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px; margin-bottom:14px;">
                                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:14px;">
                                        <label class="rb-label">برچسب و شماره تلفن:</label>
                                        <input type="text" name="rb_opt[contact_phone_label]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('contact_phone_label', 'شماره تلفن تماس و سفارش تلفنی:')); ?>" style="margin-bottom:8px;">
                                        <input type="text" name="rb_opt[contact_phone_val]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('contact_phone_val', '۰۲۱-۸۸۹۹۰۰۱۱')); ?>" style="margin-bottom:8px; font-weight:800; direction:ltr;">
                                        <input type="text" name="rb_opt[contact_phone_note]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('contact_phone_note', '(۱۰ خط ویژه پاسخگویی)')); ?>" placeholder="توضیح خطوط..." style="font-size:12px;">
                                    </div>

                                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:14px;">
                                        <label class="rb-label">برچسب و رایانامه (ایمیل):</label>
                                        <input type="text" name="rb_opt[contact_email_label]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('contact_email_label', 'رایانامه (ایمیل) اداری و سازمانی:')); ?>" style="margin-bottom:8px;">
                                        <input type="email" name="rb_opt[contact_email_val]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('contact_email_val', 'info@rashnubook.ir')); ?>" style="direction:ltr; font-weight:700;">
                                    </div>
                                </div>

                                <!-- Instagram & Hours -->
                                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px; margin-bottom:14px;">
                                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:14px;">
                                        <label class="rb-label">اینستاگرام: برچسب، آیدی و لینک:</label>
                                        <input type="text" name="rb_opt[contact_instagram_label]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('contact_instagram_label', 'صفحه رسمی اینستاگرام:')); ?>" style="margin-bottom:8px;">
                                        <input type="text" name="rb_opt[contact_instagram_val]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('contact_instagram_val', '@rashno_book')); ?>" style="margin-bottom:8px; direction:ltr; font-weight:700;">
                                        <input type="url" name="rb_opt[contact_instagram_url]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('contact_instagram_url', 'https://instagram.com/rashno_book')); ?>" placeholder="https://..." style="direction:ltr; font-size:12px;">
                                    </div>

                                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:14px;">
                                        <label class="rb-label">برچسب و متن ساعات کاری و پاسخگویی:</label>
                                        <input type="text" name="rb_opt[contact_hours_label]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('contact_hours_label', 'ساعات کاری و پاسخگویی:')); ?>" style="margin-bottom:8px;">
                                        <textarea name="rb_opt[contact_hours_val]" class="rb-textarea" rows="3"><?php echo esc_textarea(rashnubook_get_option('contact_hours_val', "شنبه تا چهارشنبه: ساعت ۹:۰۰ صبح الی ۲۰:۰۰ شب یکسره\nپنج‌شنبه‌ها: ساعت ۹:۰۰ صبح الی ۱۸:۰۰ عصر")); ?></textarea>
                                    </div>
                                </div>

                                <!-- Notice Box -->
                                <div class="rb-field-group">
                                    <label class="rb-label">متن کادر اطلاعیه پایین کارت تماس (Notice):</label>
                                    <textarea name="rb_opt[contact_notice_text]" class="rb-textarea" rows="2"><?php echo esc_textarea(rashnubook_get_option('contact_notice_text', '💡 سفارش‌های ثبت‌شده در سایت در تمام روزهای هفته به صورت خودکار پردازش و با پست پیشتاز ارسال می‌شوند.')); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- 3. INQUIRY FORM CARD -->
                        <div class="rb-builder-section">
                            <div class="rb-builder-header">
                                <h4 class="rb-builder-title">
                                    <span class="dashicons dashicons-email-alt"></span>
                                    بخش ۳: کارت فرم ارتباط مستقیم و استعلام کتاب (ستون چپ)
                                </h4>
                            </div>
                            <div class="rb-builder-body">
                                <div style="display:grid; grid-template-columns: 1fr 2fr; gap:16px; margin-bottom:16px;">
                                    <div class="rb-field-group">
                                        <label class="rb-label">ابرتایتل فرم:</label>
                                        <input type="text" name="rb_opt[contact_form_eyebrow]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('contact_form_eyebrow', 'فرم پیام مستقیم')); ?>">
                                    </div>
                                    <div class="rb-field-group">
                                        <label class="rb-label">تیتر فرم پیام:</label>
                                        <input type="text" name="rb_opt[contact_form_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('contact_form_title', 'ارسال پیام و استعلام عناوین کتاب')); ?>">
                                    </div>
                                </div>

                                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px; margin-bottom:16px;">
                                    <div class="rb-field-group">
                                        <label class="rb-label">متن دکمه ارسال فرم:</label>
                                        <input type="text" name="rb_opt[contact_form_btn_text]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('contact_form_btn_text', 'ارسال پیام به کارشناسان رشنو')); ?>">
                                    </div>
                                    <div class="rb-field-group">
                                        <label class="rb-label">پیام تایید پس از ارسال موفقیت‌آمیز:</label>
                                        <input type="text" name="rb_opt[contact_form_success_msg]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('contact_form_success_msg', 'پیام شما با موفقیت به کتابفروشی آنلاین رَشن ارسال شد. همکاران ما به زودی با شما تماس خواهند گرفت.')); ?>">
                                    </div>
                                </div>

                                <div class="rb-field-group" style="margin-bottom:16px;">
                                    <label class="rb-label">گزینه‌های انتخاب موضوع پیام (هر سطر یک گزینه):</label>
                                    <textarea name="rb_opt[contact_form_subjects]" class="rb-textarea" rows="4"><?php echo esc_textarea(rashnubook_get_option('contact_form_subjects', "استعلام موجودی و سفارش کتاب‌های ناموجود\nمشاوره تخصصی منابع آزمون وکالت و قضاوت\nپیگیری وضعیت ارسال مرسوله پستی\nسایر پیشنهادها و پیام‌های عمومی")); ?></textarea>
                                    <p class="rb-help-text">هر خط به صورت یک گزینه در منوی کشویی انتخاب موضوع نمایش داده می‌شود.</p>
                                </div>

                                <div class="rb-field-group" style="background:#f1f5f9; padding:14px; border-radius:10px; border:1px dashed #cbd5e1;">
                                    <label class="rb-label">کد کوتاه فرم اختصاصی (اختیاری):</label>
                                    <input type="text" name="rb_opt[contact_form_shortcode]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('contact_form_shortcode', '')); ?>" placeholder="مثال: [contact-form-7 id=&quot;123&quot; title=&quot;Contact form&quot;]" style="direction:ltr; font-family:monospace;">
                                    <p class="rb-help-text">در صورت تمایل به استفاده از افزونه‌هایی مانند Contact Form 7 یا Gravity Forms، شورت‌کد آن را در این قسمت قرار دهید. در غیر این صورت، فرم استاندارد و زیبای قالب رشنو فعال خواهد بود.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- TAB 8: LANDING PAGES (AFTABGARDAN & SPECIAL BOOK) -->
            <div id="tab-landing" class="rb-tab-content">
                <div class="rb-grid">

                    <!-- Section 1: Aftabgardan Monthly Modular Page Builder -->
                    <?php
                    $aftab_col_start     = rashnubook_get_option('aftabgardan_color_hero_start', '#2D231E');
                    $aftab_col_mid       = rashnubook_get_option('aftabgardan_color_hero_mid', '#3B2F2F');
                    $aftab_col_end       = rashnubook_get_option('aftabgardan_color_hero_end', '#1F4D3A');
                    $aftab_col_accent    = rashnubook_get_option('aftabgardan_color_accent', '#FFE5B4');
                    $aftab_col_primary   = rashnubook_get_option('aftabgardan_color_primary', '#1F4D3A');
                    $aftab_col_special   = rashnubook_get_option('aftabgardan_color_special', '#b83b26');
                    $aftab_col_card_text = rashnubook_get_option('aftabgardan_color_card_text', '#1e293b');

                    $aftab_cover_img     = rashnubook_get_option('aftabgardan_cover_image', '');
                    $aftab_logo_img      = rashnubook_get_option('aftabgardan_logo_image', '');
                    $aftab_avatar_img    = rashnubook_get_option('aftabgardan_editorial_avatar', '');

                    $aftab_hero_enable   = rashnubook_get_option('aftabgardan_hero_enable', '1');
                    $aftab_mockup_enable = rashnubook_get_option('aftabgardan_mockup_enable', '1');
                    $aftab_hl_enable     = rashnubook_get_option('aftabgardan_highlights_enable', '1');
                    $aftab_edit_enable   = rashnubook_get_option('aftabgardan_editorial_enable', '1');
                    $aftab_toc_enable    = rashnubook_get_option('aftabgardan_toc_enable', '1');
                    $aftab_plans_enable  = rashnubook_get_option('aftabgardan_plans_enable', '1');
                    $aftab_plan2_ribbon_enable = rashnubook_get_option('aftabgardan_plan2_ribbon_enable', '1');

                    $default_toc_rows = array(
                        1 => array('section' => 'پرونده حقوق', 'title' => 'میراث جاودان دکتر ناصر کاتوزیان؛ از قواعد عمومی قراردادها تا فلسفه حقوق', 'author' => 'دکتر فریبرز صمصامی', 'page' => '۱۲'),
                        2 => array('section' => 'نقد رمان', 'title' => 'روان‌کاوی شخصیت ماکان و استاد نقاش در رمان چشم‌هایش بزرگ علوی', 'author' => 'استاد مهرداد فرهنگ', 'page' => '۴۸'),
                        3 => array('section' => 'شعر معاصر', 'title' => 'شهریار و زبان عاطفه؛ بررسی سوز و ساز غزل‌های معاصر آذربایجان', 'author' => 'ثریا کریمی', 'page' => '۸۲'),
                        4 => array('section' => 'متون فلسفی', 'title' => 'دروازه ورود به حکمت غرب؛ چگونه چنین گفت زرتشت نیچه را بخوانیم؟', 'author' => 'کیوان اخوان', 'page' => '۱۱۴'),
                        5 => array('section' => 'تازه‌های نشر', 'title' => 'بررسی تحلیلی کتب حقوق تجارت و آیین دادرسی مدنی چاپ پاییز', 'author' => 'شورای تحریریه رشنو', 'page' => '۱۵۶'),
                        6 => array('section' => 'جستار آزاد', 'title' => 'بوطیقای مدرنیسم و سنت داستان‌نویسی ایران', 'author' => 'دکتر شیوا فرهمند', 'page' => '۱۸۲'),
                        7 => array('section' => '', 'title' => '', 'author' => '', 'page' => ''),
                        8 => array('section' => '', 'title' => '', 'author' => '', 'page' => ''),
                    );

                    $plan1_features_default = "۱۸۰ صفحه کاغذ بالکی اعلا\nارسال پستی به سراسر ایران\nدسترسی به پادکست و ضمیمه صوتی";
                    $plan2_features_default = "دریافت ماهانه ۱۲ شماره مجله با ارسال پستی\nهدیه یک جلد کتاب نفیس ادبی یا حقوقی به انتخاب مشترک\nکارت عضویت طلایی باشگاه کتابفروشی آنلاین رَشن\n۲۰٪ تخفیف دائمی بر روی تمامی کتاب‌های سایت";
                    ?>

                    <div class="rb-card rb-card-full">
                        <div class="rb-card-header">
                            <div>
                                <h3>
                                    <span class="dashicons dashicons-layout"></span>
                                    صفحه‌ساز بخش‌به‌بخش ماهنامه ادبی و فرهنگی «آفتابگردان» (/aftabgardan/)
                                </h3>
                                <p class="rb-card-desc">
                                    شخصی‌سازی کامل تمام اجزای صفحه ماهنامه شامل پالت رنگی، آپلود جلد و لوگو، هیرو، نوار مزایا، سرمقاله، جدول فهرست مقالات و کارت‌های اشتراک
                                </p>
                            </div>
                            <div>
                                <a href="<?php echo esc_url(home_url('/aftabgardan/')); ?>" target="_blank" class="rb-btn-secondary">
                                    <span class="dashicons dashicons-external"></span>
                                    مشاهده صفحه ماهنامه
                                </a>
                            </div>
                        </div>

                        <!-- 1. COLOR PALETTE BUILDER -->
                        <div class="rb-builder-section">
                            <div class="rb-builder-header">
                                <h4 class="rb-builder-title">
                                    <span class="dashicons dashicons-art"></span>
                                    بخش ۱: پالت رنگی اختصاصی و تم بصری لندینگ پیج ماهنامه
                                </h4>
                                <span style="font-size:12px; color:#64748b;">تغییر رنگ‌ها فوراً روی کل لندینگ پیج اعمال می‌شود</span>
                            </div>
                            <div class="rb-builder-body">
                                <div class="rb-palette-presets">
                                    <span style="font-size:12px; font-weight:700; color:#334155;">پالت‌های رنگی آماده رشنو (یک‌کلیک برای اعمال):</span>
                                    <button type="button" class="rb-palette-btn" data-start="#2D231E" data-mid="#3B2F2F" data-end="#1F4D3A" data-accent="#FFE5B4" data-primary="#1F4D3A" data-special="#b83b26" data-text="#1e293b">
                                        <span class="rb-palette-dot" style="background:#1F4D3A;"></span>
                                        <span>رشنو جنگلی و کهربایی (پیش‌فرض)</span>
                                    </button>
                                    <button type="button" class="rb-palette-btn" data-start="#0f172a" data-mid="#1e293b" data-end="#0369a1" data-accent="#fde047" data-primary="#0284c7" data-special="#e11d48" data-text="#0f172a">
                                        <span class="rb-palette-dot" style="background:#0284c7;"></span>
                                        <span>سرمه‌ای شبانه و طلایی</span>
                                    </button>
                                    <button type="button" class="rb-palette-btn" data-start="#261a12" data-mid="#3d281d" data-end="#78350f" data-accent="#fef08a" data-primary="#b45309" data-special="#c2410c" data-text="#1c1917">
                                        <span class="rb-palette-dot" style="background:#b45309;"></span>
                                        <span>قهوه‌ای موکا و عسلی</span>
                                    </button>
                                    <button type="button" class="rb-palette-btn" data-start="#2a0808" data-mid="#4c0519" data-end="#881337" data-accent="#fecdd3" data-primary="#be123c" data-special="#dc2626" data-text="#1e1b1b">
                                        <span class="rb-palette-dot" style="background:#881337;"></span>
                                        <span>زرشکی و رزگلد نفیس</span>
                                    </button>
                                </div>

                                <div class="rb-color-input-grid">
                                    <div class="rb-color-field">
                                        <input type="color" id="aftab_col_start" name="rb_opt[aftabgardan_color_hero_start]" value="<?php echo esc_attr($aftab_col_start); ?>">
                                        <div class="rb-color-field-info">
                                            <span>رنگ ۱ گرادیان هیرو (شروع)</span>
                                            <small>رنگ آغازین پس‌زمینه هیرو</small>
                                        </div>
                                    </div>
                                    <div class="rb-color-field">
                                        <input type="color" id="aftab_col_mid" name="rb_opt[aftabgardan_color_hero_mid]" value="<?php echo esc_attr($aftab_col_mid); ?>">
                                        <div class="rb-color-field-info">
                                            <span>رنگ ۲ گرادیان هیرو (میانی)</span>
                                            <small>عمق گرادیان بخش میانی</small>
                                        </div>
                                    </div>
                                    <div class="rb-color-field">
                                        <input type="color" id="aftab_col_end" name="rb_opt[aftabgardan_color_hero_end]" value="<?php echo esc_attr($aftab_col_end); ?>">
                                        <div class="rb-color-field-info">
                                            <span>رنگ ۳ گرادیان هیرو (پایان)</span>
                                            <small>رنگ بخش پایینی گرادیان</small>
                                        </div>
                                    </div>
                                    <div class="rb-color-field">
                                        <input type="color" id="aftab_col_accent" name="rb_opt[aftabgardan_color_accent]" value="<?php echo esc_attr($aftab_col_accent); ?>">
                                        <div class="rb-color-field-info">
                                            <span>رنگ تاکیدی طلایی و نشان‌ها</span>
                                            <small>نشان هیرو و ستاره‌ها</small>
                                        </div>
                                    </div>
                                    <div class="rb-color-field">
                                        <input type="color" id="aftab_col_primary" name="rb_opt[aftabgardan_color_primary]" value="<?php echo esc_attr($aftab_col_primary); ?>">
                                        <div class="rb-color-field-info">
                                            <span>رنگ اصلی تم و دکمه‌ها</span>
                                            <small>دکمه‌های خرید و کادر کارت ویژه</small>
                                        </div>
                                    </div>
                                    <div class="rb-color-field">
                                        <input type="color" id="aftab_col_special" name="rb_opt[aftabgardan_color_special]" value="<?php echo esc_attr($aftab_col_special); ?>">
                                        <div class="rb-color-field-info">
                                            <span>رنگ روبان پیشنهاد ویژه</span>
                                            <small>روبان بالای کارت اشتراک ۱۲ ماهه</small>
                                        </div>
                                    </div>
                                    <div class="rb-color-field">
                                        <input type="color" id="aftab_col_text" name="rb_opt[aftabgardan_color_card_text]" value="<?php echo esc_attr($aftab_col_card_text); ?>">
                                        <div class="rb-color-field-info">
                                            <span>رنگ متون کارت و خوانایی بالا</span>
                                            <small>تضمین خوانایی عالی مشخصات کارت</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. HERO SECTION -->
                        <div class="rb-builder-section">
                            <div class="rb-builder-header">
                                <h4 class="rb-builder-title">
                                    <span class="dashicons dashicons-cover-image"></span>
                                    بخش ۲: سکشن هیرو، نشان‌ها و دکمه‌های فراخوان
                                </h4>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="font-size:12px; color:#64748b;">فعال‌سازی این بخش:</span>
                                    <label class="rb-switch">
                                        <input type="checkbox" name="rb_opt[aftabgardan_hero_enable]" value="1" <?php checked($aftab_hero_enable, '1'); ?>>
                                        <span class="rb-slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="rb-builder-body">
                                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:16px;">
                                    <div class="rb-field-group">
                                        <label class="rb-label">متن نشان بالای عنوان هیرو (Badge):</label>
                                        <input type="text" name="rb_opt[aftabgardan_hero_badge]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_hero_badge', 'نشریه تخصصی فرهنگ، نقد ادبی و اندیشه حقوقی • کتابفروشی آنلاین رَشن')); ?>">
                                    </div>
                                    <div class="rb-field-group">
                                        <label class="rb-label">عنوان اصلی هیرو:</label>
                                        <input type="text" name="rb_opt[aftabgardan_hero_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_hero_title', 'ماهنامه ادبی و فرهنگی «آفتابگردان»')); ?>">
                                    </div>
                                </div>
                                <div class="rb-field-group">
                                    <label class="rb-label">توضیحات و خلاصه پرونده ویژه در هیرو:</label>
                                    <textarea name="rb_opt[aftabgardan_hero_desc]" class="rb-textarea" rows="2"><?php echo esc_textarea(rashnubook_get_option('aftabgardan_hero_desc', 'شماره دوازدهم (ویژه‌نامه تحلیلی پاییز و زمستان) | پرونده ویژه: «نسبت قانون و عدالت در آینه ادبیات داستانی معاصر ایران». ۱۸۰ صفحه نقد بی‌طرفانه، جستارهای تطبیقی و معرفی تازه‌های نشر با کاغذ بالکی و قطع رحلی نفیس.')); ?></textarea>
                                </div>
                                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:16px;">
                                    <div class="rb-field-group">
                                        <label class="rb-label">متن دکمه اول (سفارش و اشتراک):</label>
                                        <input type="text" name="rb_opt[aftabgardan_hero_btn1_text]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_hero_btn1_text', 'سفارش و اشتراک سالانه ماهنامه')); ?>">
                                    </div>
                                    <div class="rb-field-group">
                                        <label class="rb-label">لینک دکمه اول:</label>
                                        <input type="text" name="rb_opt[aftabgardan_hero_btn1_url]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_hero_btn1_url', '#subscribe-plans')); ?>" style="direction:ltr;">
                                    </div>
                                    <div class="rb-field-group">
                                        <label class="rb-label">متن دکمه دوم (مشاهده فهرست):</label>
                                        <input type="text" name="rb_opt[aftabgardan_hero_btn2_text]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_hero_btn2_text', 'مشاهده فهرست مقالات شماره ۱۲')); ?>">
                                    </div>
                                    <div class="rb-field-group">
                                        <label class="rb-label">لینک دکمه دوم:</label>
                                        <input type="text" name="rb_opt[aftabgardan_hero_btn2_url]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_hero_btn2_url', '#toc')); ?>" style="direction:ltr;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. MAGAZINE COVER CARD & 3D MOCKUP -->
                        <div class="rb-builder-section">
                            <div class="rb-builder-header">
                                <h4 class="rb-builder-title">
                                    <span class="dashicons dashicons-book-alt"></span>
                                    بخش ۳: کارت جلد مجله، موکاپ ۳بعدی، عکس جلد و لوگوی نشریه
                                </h4>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="font-size:12px; color:#64748b;">فعال‌سازی این بخش:</span>
                                    <label class="rb-switch">
                                        <input type="checkbox" name="rb_opt[aftabgardan_mockup_enable]" value="1" <?php checked($aftab_mockup_enable, '1'); ?>>
                                        <span class="rb-slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="rb-builder-body">
                                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap:20px; margin-bottom:18px;">
                                    <!-- Cover Photo Upload -->
                                    <div class="rb-callout">
                                        <label class="rb-label" style="font-weight:600;">
                                            <span class="dashicons dashicons-format-image"></span>
                                            تصویر واقعی روی جلد ماهنامه (Cover Artwork):
                                        </label>
                                        <div class="rb-media-uploader-box">
                                            <div class="rb-media-preview" id="aftab_cover_prev">
                                                <?php if (!empty($aftab_cover_img)) : ?>
                                                    <img src="<?php echo esc_url($aftab_cover_img); ?>" alt="پیش‌نمایش جلد">
                                                <?php else : ?>
                                                    <span>بدون تصویر جلد</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="rb-media-controls">
                                                <input type="text" id="aftab_cover_img" name="rb_opt[aftabgardan_cover_image]" class="rb-input-text" value="<?php echo esc_attr($aftab_cover_img); ?>" placeholder="آدرس تصویر جلد یا آپلود مستقیم..." style="direction:ltr;">
                                                <div class="rb-media-btns">
                                                    <button type="button" class="rb-btn-upload" data-target="aftab_cover_img" data-preview="aftab_cover_prev">
                                                        <span class="dashicons dashicons-upload"></span>
                                                        <span>انتخاب از رسانه / آپلود عکس جلد</span>
                                                    </button>
                                                    <button type="button" class="rb-btn-remove-media" data-target="aftab_cover_img" data-preview="aftab_cover_prev">
                                                        حذف
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="rb-help-text" style="margin-top:8px;">
                                            💡 <strong>قابلیت اختصاصی:</strong> اگر تصویر جلد مجله را وارد کنید، موکاپ ۳بعدی کارت جلد با افکت عطف و سایه رندر می‌شود.
                                        </p>
                                    </div>

                                    <!-- Logo Upload -->
                                    <div class="rb-callout">
                                        <label class="rb-label" style="font-weight:600;">
                                            <span class="dashicons dashicons-shield-alt"></span>
                                            لوگوی اختصاصی مجله یا انتشارات:
                                        </label>
                                        <div class="rb-media-uploader-box">
                                            <div class="rb-media-preview" id="aftab_logo_prev" style="height:70px;">
                                                <?php if (!empty($aftab_logo_img)) : ?>
                                                    <img src="<?php echo esc_url($aftab_logo_img); ?>" alt="پیش‌نمایش لوگو">
                                                <?php else : ?>
                                                    <span>بدون لوگو</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="rb-media-controls">
                                                <input type="text" id="aftab_logo_img" name="rb_opt[aftabgardan_logo_image]" class="rb-input-text" value="<?php echo esc_attr($aftab_logo_img); ?>" placeholder="آدرس لوگو یا انتخاب از رسانه..." style="direction:ltr;">
                                                <div class="rb-media-btns">
                                                    <button type="button" class="rb-btn-upload" data-target="aftab_logo_img" data-preview="aftab_logo_prev">
                                                        <span class="dashicons dashicons-upload"></span>
                                                        <span>انتخاب از رسانه / آپلود لوگو</span>
                                                    </button>
                                                    <button type="button" class="rb-btn-remove-media" data-target="aftab_logo_img" data-preview="aftab_logo_prev">
                                                        حذف
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="rb-help-text" style="margin-top:8px;">لوگو بر روی موکاپ مجله و بالای عناوین قرار خواهد گرفت.</p>
                                    </div>
                                </div>

                                <!-- Text content of Mockup with high contrast -->
                                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:14px; background:#ffffff; border:1px solid #e2e8f0; border-radius:10px; padding:16px; margin-bottom:14px;">
                                    <div class="rb-field-group" style="margin-bottom:0;">
                                        <label class="rb-label">نشان شماره روی موکاپ:</label>
                                        <input type="text" name="rb_opt[aftabgardan_mockup_issue]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_mockup_issue', 'شماره ۱۲')); ?>">
                                    </div>
                                    <div class="rb-field-group" style="margin-bottom:0;">
                                        <label class="rb-label">سال و فصل انتشار:</label>
                                        <input type="text" name="rb_opt[aftabgardan_mockup_season]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_mockup_season', 'سال دوم • زمستان')); ?>">
                                    </div>
                                    <div class="rb-field-group" style="margin-bottom:0;">
                                        <label class="rb-label">نام انتشارات / برند روی جلد:</label>
                                        <input type="text" name="rb_opt[aftabgardan_mockup_brand]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_mockup_brand', 'کتابفروشی آنلاین رَشن')); ?>">
                                    </div>
                                    <div class="rb-field-group" style="margin-bottom:0;">
                                        <label class="rb-label">عنوان اصلی روی جلد:</label>
                                        <input type="text" name="rb_opt[aftabgardan_mockup_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_mockup_title', 'آفتابگردان')); ?>">
                                    </div>
                                </div>

                                <div style="display:grid; grid-template-columns: 1.5fr 1fr 1fr; gap:14px;">
                                    <div class="rb-field-group">
                                        <label class="rb-label">توضیحات و موضوع نشریه روی جلد (با کنتراست تیره و کاملاً خوانا):</label>
                                        <input type="text" name="rb_opt[aftabgardan_mockup_desc]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_mockup_desc', 'فصلنامه تخصصی بازخوانی رمان‌های بزرگ و متون حقوقی')); ?>">
                                    </div>
                                    <div class="rb-field-group">
                                        <label class="rb-label">نام مدیر مسئول / سردبیر روی جلد:</label>
                                        <input type="text" name="rb_opt[aftabgardan_editor_name]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_editor_name', 'شورای سردبیری رَشن بوک')); ?>">
                                    </div>
                                    <div class="rb-field-group">
                                        <label class="rb-label">مشخصات صفحات و کاغذ روی جلد:</label>
                                        <input type="text" name="rb_opt[aftabgardan_mockup_pages]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_mockup_pages', '۱۸۰ صفحه بالکی')); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. HIGHLIGHTS STRIP -->
                        <div class="rb-builder-section">
                            <div class="rb-builder-header">
                                <h4 class="rb-builder-title">
                                    <span class="dashicons dashicons-star-filled"></span>
                                    بخش ۴: نوار ویژگی‌های کلیدی و مزایای مجله (۴ آیتم زیر هیرو)
                                </h4>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="font-size:12px; color:#64748b;">فعال‌سازی این بخش:</span>
                                    <label class="rb-switch">
                                        <input type="checkbox" name="rb_opt[aftabgardan_highlights_enable]" value="1" <?php checked($aftab_hl_enable, '1'); ?>>
                                        <span class="rb-slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="rb-builder-body">
                                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:14px;">
                                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:12px;">
                                        <label class="rb-label">ویژگی ۱: عنوان و توضیح</label>
                                        <input type="text" name="rb_opt[aftabgardan_hl1_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_hl1_title', 'کاغذ بالکی سوئدی')); ?>" style="margin-bottom:8px;">
                                        <input type="text" name="rb_opt[aftabgardan_hl1_desc]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_hl1_desc', 'بسیار سبک و دوستدار چشم حین مطالعه')); ?>" style="font-size:12px;">
                                    </div>
                                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:12px;">
                                        <label class="rb-label">ویژگی ۲: عنوان و توضیح</label>
                                        <input type="text" name="rb_opt[aftabgardan_hl2_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_hl2_title', 'ارسال پستی کتاب')); ?>" style="margin-bottom:8px;">
                                        <input type="text" name="rb_opt[aftabgardan_hl2_desc]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_hl2_desc', 'تحویل بسته‌بندی نفیس در سراسر کشور')); ?>" style="font-size:12px;">
                                    </div>
                                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:12px;">
                                        <label class="rb-label">ویژگی ۳: عنوان و توضیح</label>
                                        <input type="text" name="rb_opt[aftabgardan_hl3_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_hl3_title', 'ضمیمه صوتی و پادکست')); ?>" style="margin-bottom:8px;">
                                        <input type="text" name="rb_opt[aftabgardan_hl3_desc]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_hl3_desc', 'روایت صوتی گزیده مقالات و شعرها')); ?>" style="font-size:12px;">
                                    </div>
                                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:12px;">
                                        <label class="rb-label">ویژگی ۴: عنوان و توضیح</label>
                                        <input type="text" name="rb_opt[aftabgardan_hl4_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_hl4_title', 'تخفیف ویژه مشترکین')); ?>" style="margin-bottom:8px;">
                                        <input type="text" name="rb_opt[aftabgardan_hl4_desc]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_hl4_desc', '۲۰٪ تخفیف دائمی خرید کتاب از رشنو بوک')); ?>" style="font-size:12px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 5. EDITORIAL NOTE -->
                        <div class="rb-builder-section">
                            <div class="rb-builder-header">
                                <h4 class="rb-builder-title">
                                    <span class="dashicons dashicons-welcome-write-blog"></span>
                                    بخش ۵: سرمقاله، نویسنده و یادداشت تحریریه
                                </h4>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="font-size:12px; color:#64748b;">فعال‌سازی این بخش:</span>
                                    <label class="rb-switch">
                                        <input type="checkbox" name="rb_opt[aftabgardan_editorial_enable]" value="1" <?php checked($aftab_edit_enable, '1'); ?>>
                                        <span class="rb-slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="rb-builder-body">
                                <div style="display:grid; grid-template-columns: 1fr 1fr 1fr; gap:16px; margin-bottom:14px;">
                                    <div class="rb-field-group">
                                        <label class="rb-label">عنوان سرمقاله:</label>
                                        <input type="text" name="rb_opt[aftabgardan_editorial_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_editorial_title', 'سرمقاله شورای سردبیری: در ستایش خواندنِ بی‌شتاب')); ?>">
                                    </div>
                                    <div class="rb-field-group">
                                        <label class="rb-label">نام نگارنده یا پدیدآور سرمقاله:</label>
                                        <input type="text" name="rb_opt[aftabgardan_editorial_author]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_editorial_author', 'شورای سردبیری کتابفروشی آنلاین رَشن')); ?>">
                                    </div>
                                    <div class="rb-field-group">
                                        <label class="rb-label">تصویر / آواتار نویسنده (اختیاری):</label>
                                        <div style="display:flex; gap:8px; align-items:center;">
                                            <input type="text" id="aftab_avatar_img" name="rb_opt[aftabgardan_editorial_avatar]" class="rb-input-text" value="<?php echo esc_attr($aftab_avatar_img); ?>" placeholder="آدرس تصویر..." style="direction:ltr;">
                                            <button type="button" class="button rb-btn-upload" data-target="aftab_avatar_img" data-preview="">
                                                آپلود
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="rb-field-group" style="margin-bottom:0;">
                                    <label class="rb-label">متن کامل سرمقاله (پشتیبانی از تگ‌های استاندارد HTML مانند p):</label>
                                    <textarea name="rb_opt[aftabgardan_editorial_text]" class="rb-textarea" rows="4"><?php echo esc_textarea(rashnubook_get_option('aftabgardan_editorial_text', '<p>در روزگاری که سرعت سرسام‌آور داده‌ها و روایت‌های کپسولی، مجالی برای تامل عمیق باقی نگذاشته است، «ماهنامه آفتابگردان» تلاشی است آگاهانه برای بازگشت به فضیلت تامل و غور در کلمات مکتوب. ما در رشنو بوک بر این باوریم که متون فاخر ادبی و آموزه‌های بنیادین حقوقی، دو بال پرواز جامعه به سوی دادگری، زیبایی و فرزانگی هستند.</p><p style="margin-top:12px;">در این شماره، اساتید برجسته حقوق و منتقدان چیره‌دست ادبیات، پیرامون مسئله «عدالت» و جلوه‌های آن در شاهکارهای داستانی ایران به گفتگو نشسته‌اند تا پیوند ناگسستنی ادب و قانون را به رخ کشند...</p>')); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- 6. TABLE OF CONTENTS BUILDER -->
                        <div class="rb-builder-section">
                            <div class="rb-builder-header">
                                <h4 class="rb-builder-title">
                                    <span class="dashicons dashicons-editor-table"></span>
                                    بخش ۶: صفحه ساز فهرست مقالات، جستارها و عناوین پرونده ویژه
                                </h4>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="font-size:12px; color:#64748b;">فعال‌سازی این بخش:</span>
                                    <label class="rb-switch">
                                        <input type="checkbox" name="rb_opt[aftabgardan_toc_enable]" value="1" <?php checked($aftab_toc_enable, '1'); ?>>
                                        <span class="rb-slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="rb-builder-body">
                                <div style="display:grid; grid-template-columns: 1fr 1.5fr; gap:16px; margin-bottom:18px;">
                                    <div class="rb-field-group" style="margin-bottom:0;">
                                        <label class="rb-label">نشان بالای عنوان فهرست:</label>
                                        <input type="text" name="rb_opt[aftabgardan_toc_eyebrow]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_toc_eyebrow', 'گزیده‌ای از محتوای این شماره')); ?>">
                                    </div>
                                    <div class="rb-field-group" style="margin-bottom:0;">
                                        <label class="rb-label">عنوان اصلی جدول فهرست:</label>
                                        <input type="text" name="rb_opt[aftabgardan_toc_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_toc_title', 'فهرست مقالات و عناوین پرونده ویژه')); ?>">
                                    </div>
                                </div>

                                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:14px;">
                                    <div style="display:grid; grid-template-columns: 45px 160px 1.5fr 1fr 75px; gap:10px; font-weight:800; font-size:12.5px; color:#475569; margin-bottom:10px; padding:0 8px;">
                                        <span style="text-align:center;">فعال</span>
                                        <span>بخش / دسته‌بندی</span>
                                        <span>عنوان مقاله یا جستار تحلیلی</span>
                                        <span>نویسنده / مترجم</span>
                                        <span style="text-align:center;">صفحه</span>
                                    </div>

                                    <?php for ($r = 1; $r <= 8; $r++) :
                                        $r_def = $default_toc_rows[$r] ?? array('section' => '', 'title' => '', 'author' => '', 'page' => '');
                                        $r_enable = rashnubook_get_option("aftabgardan_toc_row_{$r}_enable", $r <= 5 ? '1' : '0');
                                        $r_sec = rashnubook_get_option("aftabgardan_toc_row_{$r}_section", $r_def['section']);
                                        $r_tit = rashnubook_get_option("aftabgardan_toc_row_{$r}_title", $r_def['title']);
                                        $r_aut = rashnubook_get_option("aftabgardan_toc_row_{$r}_author", $r_def['author']);
                                        $r_pag = rashnubook_get_option("aftabgardan_toc_row_{$r}_page", $r_def['page']);
                                    ?>
                                        <div class="rb-toc-row">
                                            <div style="text-align:center;">
                                                <input type="checkbox" name="rb_opt[aftabgardan_toc_row_<?php echo $r; ?>_enable]" value="1" <?php checked($r_enable, '1'); ?>>
                                            </div>
                                            <div>
                                                <input type="text" name="rb_opt[aftabgardan_toc_row_<?php echo $r; ?>_section]" class="rb-input-text" value="<?php echo esc_attr($r_sec); ?>" placeholder="مثلاً: پرونده حقوق">
                                            </div>
                                            <div>
                                                <input type="text" name="rb_opt[aftabgardan_toc_row_<?php echo $r; ?>_title]" class="rb-input-text" value="<?php echo esc_attr($r_tit); ?>" placeholder="عنوان کامل مقاله...">
                                            </div>
                                            <div>
                                                <input type="text" name="rb_opt[aftabgardan_toc_row_<?php echo $r; ?>_author]" class="rb-input-text" value="<?php echo esc_attr($r_aut); ?>" placeholder="نام نویسنده / مترجم">
                                            </div>
                                            <div>
                                                <input type="text" name="rb_opt[aftabgardan_toc_row_<?php echo $r; ?>_page]" class="rb-input-text" value="<?php echo esc_attr($r_pag); ?>" placeholder="۱۲" style="text-align:center;">
                                            </div>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>

                        <!-- 7. PRODUCT CARDS & 12-MONTH SUBSCRIPTION -->
                        <div class="rb-builder-section">
                            <div class="rb-builder-header">
                                <h4 class="rb-builder-title">
                                    <span class="dashicons dashicons-cart"></span>
                                    بخش ۷: کارت‌های محصول، اشتراک ۱۲ ماهه و پیشنهاد ویژه
                                </h4>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="font-size:12px; color:#64748b;">فعال‌سازی این بخش:</span>
                                    <label class="rb-switch">
                                        <input type="checkbox" name="rb_opt[aftabgardan_plans_enable]" value="1" <?php checked($aftab_plans_enable, '1'); ?>>
                                        <span class="rb-slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="rb-builder-body">
                                <div style="display:grid; grid-template-columns: 1fr 1.5fr; gap:16px; margin-bottom:18px;">
                                    <div class="rb-field-group" style="margin-bottom:0;">
                                        <label class="rb-label">نشان بالای عنوان پلن‌ها:</label>
                                        <input type="text" name="rb_opt[aftabgardan_plans_eyebrow]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_plans_eyebrow', 'پیوستن به حلقه خوانندگان آفتابگردان')); ?>">
                                    </div>
                                    <div class="rb-field-group" style="margin-bottom:0;">
                                        <label class="rb-label">عنوان اصلی بخش تعرفه‌ها:</label>
                                        <input type="text" name="rb_opt[aftabgardan_plans_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_plans_title', 'تعرفه‌ها و پلن‌های اشتراک ماهنامه')); ?>">
                                    </div>
                                </div>

                                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                                    <!-- Card 1: Single Issue -->
                                    <div style="background:#ffffff; border:1.5px solid #cbd5e1; border-radius:14px; padding:20px; box-shadow:0 4px 14px rgba(0,0,0,0.03);">
                                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; padding-bottom:10px; border-bottom:1px solid #e2e8f0;">
                                            <h4 style="margin:0; color:#334155; font-size:15px; font-weight:800;">
                                                کارت محصول ۱: خرید تک‌شماره
                                            </h4>
                                            <span style="font-size:11px; background:#e2e8f0; color:#475569; padding:2px 8px; border-radius:6px; font-weight:700;">نسخه چاپی</span>
                                        </div>

                                        <div class="rb-field-group">
                                            <label class="rb-label">نشان بالای کارت (Badge):</label>
                                            <input type="text" name="rb_opt[aftabgardan_plan1_badge]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_plan1_badge', 'خرید تک‌شماره')); ?>">
                                        </div>
                                        <div class="rb-field-group">
                                            <label class="rb-label">عنوان محصول / پلن:</label>
                                            <input type="text" name="rb_opt[aftabgardan_plan1_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_plan1_title', 'شماره ۱۲ ماهنامه (چاپی)')); ?>">
                                        </div>

                                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                                            <div class="rb-field-group">
                                                <label class="rb-label">قیمت نهایی (تومان):</label>
                                                <input type="text" name="rb_opt[aftabgardan_plan1_price]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_plan1_price', '145000')); ?>">
                                            </div>
                                            <div class="rb-field-group">
                                                <label class="rb-label">قیمت قبل از تخفیف (اختیاری):</label>
                                                <input type="text" name="rb_opt[aftabgardan_plan1_old_price]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_plan1_old_price', '')); ?>" placeholder="مثلاً: 165000">
                                            </div>
                                        </div>

                                        <div class="rb-field-group">
                                            <label class="rb-label">توضیحات و ویژگی‌های کارت (هر سطر یک ویژگی):</label>
                                            <textarea name="rb_opt[aftabgardan_plan1_features]" class="rb-textarea" rows="4"><?php echo esc_textarea(rashnubook_get_option('aftabgardan_plan1_features', $plan1_features_default)); ?></textarea>
                                            <p class="rb-help-text">هر خط به صورت یک سطر با تیک در کارت محصول نمایش داده خواهد شد.</p>
                                        </div>

                                        <div class="rb-field-group">
                                            <label class="rb-label">محصول ووکامرس مرتبط با پلن ۱ (افزودن به سبد خرید):</label>
                                            <select name="rb_opt[aftabgardan_plan1_product_id]" class="rb-select">
                                                <option value="">-- انتخاب مستقیم محصول ووکامرس --</option>
                                                <?php
                                                $selected_p1 = rashnubook_get_option('aftabgardan_plan1_product_id', '');
                                                $prod_list = function_exists('rashnubook_get_products_list') ? rashnubook_get_products_list() : array();
                                                foreach ($prod_list as $pid => $pname) : ?>
                                                    <option value="<?php echo esc_attr($pid); ?>" <?php selected($selected_p1, $pid); ?>><?php echo esc_html($pname); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <p class="rb-help-text">با انتخاب محصول ووکامرس، فرآیند افزودن به سبد خرید به صورت استاندارد، هوشمند و خودکار انجام خواهد شد.</p>
                                        </div>

                                        <div style="display:grid; grid-template-columns: 1fr 1.2fr; gap:12px;">
                                            <div class="rb-field-group" style="margin-bottom:0;">
                                                <label class="rb-label">متن دکمه خرید:</label>
                                                <input type="text" name="rb_opt[aftabgardan_plan1_btn_text]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_plan1_btn_text', 'سفارش نسخه چاپی شماره ۱۲')); ?>">
                                            </div>
                                            <div class="rb-field-group" style="margin-bottom:0;">
                                                <label class="rb-label">لینک سفارشی اختیاری (در صورت خالی بودن محصول بالا):</label>
                                                <input type="url" name="rb_opt[aftabgardan_plan1_url]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_plan1_url', '')); ?>" placeholder="<?php echo esc_attr(home_url('/cart/?add-to-cart=862')); ?>" style="direction:ltr;">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card 2: Annual VIP Subscription & Special Offer -->
                                    <div class="rb-callout" style="padding:20px; position:relative;">
                                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; padding-bottom:10px; border-bottom:1px solid var(--rb-border);">
                                            <h4 style="margin:0; color:var(--rb-text-primary); font-size:15px; font-weight:600; font-family:var(--rb-font-display);">
                                                کارت محصول ۲: اشتراک ۱۲ ماهه (سالانه طلایی)
                                            </h4>
                                            <div style="display:flex; align-items:center; gap:6px;">
                                                <span style="font-size:11px; color:var(--rb-text-secondary);">روبان پیشنهاد ویژه:</span>
                                                <label class="rb-switch" style="transform:scale(0.85); transform-origin:left center;">
                                                    <input type="checkbox" name="rb_opt[aftabgardan_plan2_ribbon_enable]" value="1" <?php checked($aftab_plan2_ribbon_enable, '1'); ?>>
                                                    <span class="rb-slider"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                                            <div class="rb-field-group">
                                                <label class="rb-label">متن روبان پیشنهاد ویژه:</label>
                                                <input type="text" name="rb_opt[aftabgardan_plan2_ribbon]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_plan2_ribbon', 'پیشنهاد ویژه مشترکین')); ?>">
                                            </div>
                                            <div class="rb-field-group">
                                                <label class="rb-label">نشان بالای کارت (Badge):</label>
                                                <input type="text" name="rb_opt[aftabgardan_plan2_badge]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_plan2_badge', 'اشتراک ۱۲ ماهه (سالانه)')); ?>">
                                            </div>
                                        </div>

                                        <div class="rb-field-group">
                                            <label class="rb-label">عنوان محصول / پلن اشتراک:</label>
                                            <input type="text" name="rb_opt[aftabgardan_plan2_title]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_plan2_title', 'اشتراک کامل چاپی + هدیه کتاب')); ?>">
                                        </div>

                                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                                            <div class="rb-field-group">
                                                <label class="rb-label">قیمت اشتراک (تومان):</label>
                                                <input type="text" name="rb_opt[aftabgardan_plan2_price]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_plan2_price', '1450000')); ?>">
                                            </div>
                                            <div class="rb-field-group">
                                                <label class="rb-label">قیمت بدون تخفیف (اختیاری):</label>
                                                <input type="text" name="rb_opt[aftabgardan_plan2_old_price]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_plan2_old_price', '1750000')); ?>" placeholder="مثلاً: 1750000">
                                            </div>
                                        </div>

                                        <div class="rb-field-group">
                                            <label class="rb-label">توضیحات و هدایای اشتراک ۱۲ ماهه (هر سطر یک ویژگی):</label>
                                            <textarea name="rb_opt[aftabgardan_plan2_features]" class="rb-textarea" rows="4"><?php echo esc_textarea(rashnubook_get_option('aftabgardan_plan2_features', $plan2_features_default)); ?></textarea>
                                            <p class="rb-help-text">امکان استفاده از تگ strong برای بولد کردن هدیه کتاب وجود دارد.</p>
                                        </div>

                                        <div class="rb-field-group">
                                            <label class="rb-label">محصول ووکامرس مرتبط با پلن ۲ (اشتراک سالانه):</label>
                                            <select name="rb_opt[aftabgardan_plan2_product_id]" class="rb-select">
                                                <option value="">-- انتخاب مستقیم محصول ووکامرس --</option>
                                                <?php
                                                $selected_p2 = rashnubook_get_option('aftabgardan_plan2_product_id', '');
                                                foreach ($prod_list as $pid => $pname) : ?>
                                                    <option value="<?php echo esc_attr($pid); ?>" <?php selected($selected_p2, $pid); ?>><?php echo esc_html($pname); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <p class="rb-help-text">محصول ووکامرس اشتراک سالانه یا محصول مربوط به این پکیج را انتخاب کنید.</p>
                                        </div>

                                        <div style="display:grid; grid-template-columns: 1fr 1.2fr; gap:12px;">
                                            <div class="rb-field-group" style="margin-bottom:0;">
                                                <label class="rb-label">متن دکمه ثبت اشتراک:</label>
                                                <input type="text" name="rb_opt[aftabgardan_plan2_btn_text]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_plan2_btn_text', 'ثبت اشتراک سالانه طلایی')); ?>">
                                            </div>
                                            <div class="rb-field-group" style="margin-bottom:0;">
                                                <label class="rb-label">لینک سفارشی اختیاری (در صورت خالی بودن محصول بالا):</label>
                                                <input type="url" name="rb_opt[aftabgardan_plan2_url]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('aftabgardan_plan2_url', '')); ?>" placeholder="<?php echo esc_attr(home_url('/cart/?add-to-cart=863')); ?>" style="direction:ltr;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Section 2: Special Book / Katouzian Landing Page Settings -->
                    <div class="rb-card rb-card-full" style="border: 2px solid #b83b26;">
                        <div class="rb-card-header" style="background:#fef2f2; margin:-24px -24px 20px -24px; padding:16px 24px; border-top-left-radius:14px; border-top-right-radius:14px;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <span class="dashicons dashicons-megaphone" style="color:#b83b26; font-size:22px;"></span>
                                <h3 style="margin:0; color:#b83b26; font-size:16px;">
                                    مدیریت برگه فرود اختصاصی کتاب / لندینگ پیج کاتوزیان (/landing/)
                                </h3>
                            </div>
                            <div style="display:flex; align-items:center; gap:12px;">
                                <span style="font-size:12px; color:#64748b;">تایمر معکوس:</span>
                                <label class="rb-switch">
                                    <input type="checkbox" name="rb_opt[enable_landing_countdown]" value="1" <?php checked($landing_countdown, '1'); ?>>
                                    <span class="rb-slider"></span>
                                </label>
                            </div>
                        </div>

                        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:16px;">
                            <div class="rb-field-group">
                                <label class="rb-label">نشان بالای عنوان (Badge):</label>
                                <input type="text" name="rb_opt[landing_hero_badge]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('landing_hero_badge', 'پروموشن ویژه کتابفروشی آنلاین رَشن')); ?>">
                            </div>
                            <div class="rb-field-group">
                                <label class="rb-label">مدت زمان پیش‌فرض تایمر تخفیف (ساعت):</label>
                                <input type="number" name="rb_opt[countdown_hours]" class="rb-input-text" value="<?php echo esc_attr($countdown_hours); ?>">
                            </div>
                        </div>

                        <div class="rb-field-group">
                            <label class="rb-label">متن زیرعنوان هیرو:</label>
                            <textarea name="rb_opt[landing_hero_sub]" class="rb-textarea" rows="2"><?php echo esc_textarea(rashnubook_get_option('landing_hero_sub', 'روایتی کم‌نظیر از ادبیات داستانی معاصر، چاپ ویژه همراه با صحافی نفیس و ارسال پستی به سراسر کشور')); ?></textarea>
                        </div>

                        <!-- Quote -->
                        <div style="display:grid; grid-template-columns: 1.2fr 0.8fr; gap:16px; background:#f8fafc; padding:14px; border-radius:10px; margin-bottom:16px; border:1px solid #e2e8f0;">
                            <div class="rb-field-group" style="margin-bottom:0;">
                                <label class="rb-label">متن نقل‌قول تحلیلی صفحه فرود:</label>
                                <input type="text" name="rb_opt[landing_quote_text]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('landing_quote_text', 'اثری که نگرش شما را نسبت به ادبیات و هستی دگرگون خواهد کرد.')); ?>">
                            </div>
                            <div class="rb-field-group" style="margin-bottom:0;">
                                <label class="rb-label">گوینده یا مرجع نقل‌قول:</label>
                                <input type="text" name="rb_opt[landing_quote_author]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('landing_quote_author', 'نقد ضمیمه فرهنگی رشنو')); ?>">
                            </div>
                        </div>

                        <!-- Specs Table Fields -->
                        <div style="background:#fafafa; border:1px solid #e5e5e5; border-radius:10px; padding:16px; margin-bottom:16px;">
                            <h4 style="margin:0 0 12px; font-size:13.5px; color:#171717;">مشخصات شناسنامه کتاب در برگه فرود:</h4>
                            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:14px;">
                                <div class="rb-field-group" style="margin-bottom:0;">
                                    <label class="rb-label">قطع و نوع جلد:</label>
                                    <input type="text" name="rb_opt[landing_spec_format]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('landing_spec_format', 'وزیری - گالینگور زرکوب نفیس')); ?>">
                                </div>
                                <div class="rb-field-group" style="margin-bottom:0;">
                                    <label class="rb-label">نوع کاغذ:</label>
                                    <input type="text" name="rb_opt[landing_spec_paper]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('landing_spec_paper', 'بالکی کرم سوئدی (سبک و ضد خستگی چشم)')); ?>">
                                </div>
                                <div class="rb-field-group" style="margin-bottom:0;">
                                    <label class="rb-label">نوبت چاپ:</label>
                                    <input type="text" name="rb_opt[landing_spec_edition]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('landing_spec_edition', 'ویرایش نو - بهار ۱۴۰۳')); ?>">
                                </div>
                                <div class="rb-field-group" style="margin-bottom:0;">
                                    <label class="rb-label">شرایط ارسال:</label>
                                    <input type="text" name="rb_opt[landing_spec_shipping]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('landing_spec_shipping', 'پست پیشتاز اختصاصی در بسته‌بندی حباب‌دار ایمن')); ?>">
                                </div>
                            </div>
                        </div>

                        <!-- CTA Box Product, Pricing & Link -->
                        <div class="rb-field-group" style="background:#fff; border:1.5px solid #cbd5e1; border-radius:10px; padding:16px; margin-bottom:16px;">
                            <label class="rb-label" style="font-weight:700; color:#0f172a;">محصول ووکامرس مرتبط با برگه فرود (اتصال مستقیم به سبد خرید و پرداخت):</label>
                            <select name="rb_opt[landing_cta_product_id]" class="rb-select">
                                <option value="">-- انتخاب محصول ووکامرس (پیش‌فرض: بسته طلایی کتب حقوقی و آزمون) --</option>
                                <?php
                                $selected_landing_pid = rashnubook_get_option('landing_cta_product_id', '867');
                                $landing_prod_list = function_exists('rashnubook_get_products_list') ? rashnubook_get_products_list() : array();
                                foreach ($landing_prod_list as $pid => $pname) : ?>
                                    <option value="<?php echo esc_attr($pid); ?>" <?php selected($selected_landing_pid, $pid); ?>><?php echo esc_html($pname); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p class="rb-help-text">با انتخاب محصول ووکامرس، مشتری با کلیک بر روی دکمه خرید مستقیماً همراه با محصول انتخاب‌شده به سبد خرید هدایت خواهد شد.</p>
                        </div>

                        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:14px;">
                            <div class="rb-field-group">
                                <label class="rb-label">قیمت قبل از تخفیف (نمایشی):</label>
                                <input type="text" name="rb_opt[landing_cta_old_price]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('landing_cta_old_price', '۴۵۰,۰۰۰ تومان')); ?>">
                            </div>
                            <div class="rb-field-group">
                                <label class="rb-label">قیمت پس از تخفیف (نمایشی):</label>
                                <input type="text" name="rb_opt[landing_cta_price]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('landing_cta_price', '۳۸۵,۰۰۰ تومان')); ?>">
                            </div>
                            <div class="rb-field-group">
                                <label class="rb-label">لینک سفارشی دکمه خرید (در صورت تمایل به لینک دلخواه):</label>
                                <input type="url" name="rb_opt[landing_cta_link]" class="rb-input-text" value="<?php echo esc_attr(rashnubook_get_option('landing_cta_link', '')); ?>" placeholder="<?php echo esc_attr(home_url('/cart/?add-to-cart=867')); ?>" style="direction:ltr;">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

                </main>
            </div><!-- /.rb-panel-body-layout -->

            <!-- Sticky Actions Bar (Genesis Elevated Bar) -->
            <div class="rb-actions-bar">
                <div style="display:flex; align-items:center; gap:8px;">
                    <span class="dashicons dashicons-info" style="color:var(--rb-primary); font-size:18px;"></span>
                    <span style="font-size:13px; color:var(--rb-text-secondary);">تغییرات بلافاصله پس از ذخیره، بدون تاخیر در تمام بخش‌های سایت اعمال خواهند شد.</span>
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

    <!-- Genesis Tab switching & Media uploader & Palette script & Ctrl+K Search -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.rb-nav-tab');
        const contents = document.querySelectorAll('.rb-tab-content');
        const searchInput = document.getElementById('rb-settings-search');

        function activateTab(tabId) {
            tabs.forEach(t => {
                if (t.getAttribute('data-tab') === tabId) {
                    t.classList.add('active');
                } else {
                    t.classList.remove('active');
                }
            });
            contents.forEach(c => {
                if (c.id === tabId) {
                    c.classList.add('active');
                } else {
                    c.classList.remove('active');
                }
            });
            try {
                localStorage.setItem('rb_active_tab', tabId);
            } catch (e) {}
        }

        // Restore active tab from localStorage or hash
        const hash = window.location.hash.replace('#', '');
        const storedTab = (function() {
            try { return localStorage.getItem('rb_active_tab'); } catch (e) { return null; }
        })();
        const initialTab = hash || storedTab;
        if (initialTab && document.getElementById(initialTab)) {
            activateTab(initialTab);
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const target = this.getAttribute('data-tab');
                activateTab(target);
                if (history.replaceState) {
                    history.replaceState(null, null, '#' + target);
                }
            });
        });

        // ⌘K / Ctrl+K keyboard shortcut
        window.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && (e.key === 'k' || e.key === 'K')) {
                e.preventDefault();
                if (searchInput) {
                    searchInput.focus();
                    searchInput.select();
                }
            }
        });

        // Quick Live Search across Settings
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();
                if (!query) {
                    // Reset all visibility
                    document.querySelectorAll('.rb-card, .rb-builder-section').forEach(el => {
                        el.style.display = '';
                    });
                    tabs.forEach(t => t.style.opacity = '1');
                    return;
                }

                // Check matches in all tabs
                let activeTabMatched = false;
                let firstMatchingTab = null;

                contents.forEach(panel => {
                    let panelHasMatch = false;
                    const items = panel.querySelectorAll('.rb-card, .rb-builder-section');
                    items.forEach(card => {
                        const text = card.textContent.toLowerCase();
                        if (text.includes(query)) {
                            card.style.display = '';
                            panelHasMatch = true;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    const tabBtn = document.querySelector(`.rb-nav-tab[data-tab="${panel.id}"]`);
                    if (tabBtn) {
                        if (panelHasMatch) {
                            tabBtn.style.opacity = '1';
                            if (!firstMatchingTab) firstMatchingTab = panel.id;
                            if (panel.classList.contains('active')) activeTabMatched = true;
                        } else {
                            tabBtn.style.opacity = '0.4';
                        }
                    }
                });

                // If currently active tab has no match, switch to first tab that has match
                if (!activeTabMatched && firstMatchingTab) {
                    activateTab(firstMatchingTab);
                }
            });
        }
    });

    jQuery(document).ready(function($) {
        // Media Library Uploader
        $(document).on('click', '.rb-btn-upload', function(e) {
            e.preventDefault();
            var btn = $(this);
            var targetInputId = btn.data('target');
            var previewId = btn.data('preview');

            var customUploader = wp.media({
                title: 'انتخاب یا بارگذاری تصویر',
                button: { text: 'استفاده از این تصویر' },
                multiple: false
            }).on('select', function() {
                var attachment = customUploader.state().get('selection').first().toJSON();
                $('#' + targetInputId).val(attachment.url);
                if (previewId && $('#' + previewId).length) {
                    $('#' + previewId).html('<img src="' + attachment.url + '" alt="پیش‌نمایش">');
                }
            }).open();
        });

        // Remove Media
        $(document).on('click', '.rb-btn-remove-media', function(e) {
            e.preventDefault();
            var btn = $(this);
            var targetInputId = btn.data('target');
            var previewId = btn.data('preview');
            $('#' + targetInputId).val('');
            if (previewId && $('#' + previewId).length) {
                $('#' + previewId).html('<span>بدون تصویر</span>');
            }
        });

        // Palette Preset Buttons
        $(document).on('click', '.rb-palette-btn', function(e) {
            e.preventDefault();
            var btn = $(this);
            var start = btn.data('start');
            var mid = btn.data('mid');
            var end = btn.data('end');
            var accent = btn.data('accent');
            var primary = btn.data('primary');
            var special = btn.data('special');
            var text = btn.data('text');

            if (start) $('#aftab_col_start').val(start).trigger('change');
            if (mid) $('#aftab_col_mid').val(mid).trigger('change');
            if (end) $('#aftab_col_end').val(end).trigger('change');
            if (accent) $('#aftab_col_accent').val(accent).trigger('change');
            if (primary) $('#aftab_col_primary').val(primary).trigger('change');
            if (special) $('#aftab_col_special').val(special).trigger('change');
            if (text) $('#aftab_col_text').val(text).trigger('change');
        });

        // Sync duplicate switch checkboxes across tabs/cards
        $(document).on('change', 'input[type="checkbox"][name^="rb_opt["]', function() {
            var inputName = $(this).attr('name');
            if (inputName) {
                $('input[type="checkbox"][name="' + $.escapeSelector(inputName) + '"]').prop('checked', this.checked);
            }
        });

        // Count preset buttons for product rails (7, 8, 10, etc.)
        $(document).on('click', '.rb-count-preset-btn', function(e) {
            e.preventDefault();
            var targetId = $(this).data('target');
            var countVal = $(this).data('count');
            if (targetId && $('#' + targetId).length) {
                $('#' + targetId).val(countVal);
            }
        });
    });
    </script>
    <?php
}
