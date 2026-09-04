<?php
/**
 * Theme fixes & enhancements — Batch 1
 *
 * 1) Editable social links (Customizer > شبکه‌های اجتماعی)
 * 2) Working newsletter subscription (Customizer + AJAX + CPT)
 * 3) Hero slider background image (Customizer > اسلایدر هیرو)
 * 4) Editable landing-page fields (metabox on landing templates)
 * 5) Split merged product spec attributes (قطع / نوع جلد / نوبت چاپ)
 * 6) Reliable blog archive URL helper
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

/* ---------------------------------------------------------------
 * 1) Social links — Customizer first, admin-panel option fallback
 * --------------------------------------------------------------- */
function rashnubook_fix_social_url($key, $default = '') {
    $mod = get_theme_mod('rashnubook_social_' . $key, '');
    if (!empty($mod)) {
        return $mod;
    }
    if (function_exists('rashnubook_get_option')) {
        $opt = rashnubook_get_option('social_' . $key, '');
        if (!empty($opt)) {
            return $opt;
        }
    }
    return $default;
}

function rashnubook_fix_sanitize_opacity($value) {
    $v = (float) $value;
    if ($v < 0) {
        $v = 0;
    }
    if ($v > 1) {
        $v = 1;
    }
    return (string) $v;
}

function rashnubook_fix_register_customizer($wp_customize) {

    // --- Social links ---
    $wp_customize->add_section('rashnubook_socials', array(
        'title'    => __('شبکه‌های اجتماعی رشنو بوک', 'rashnubook'),
        'priority' => 35,
    ));

    $socials = array(
        'instagram' => __('نشانی کامل اینستاگرام', 'rashnubook'),
        'telegram'  => __('نشانی کانال تلگرام', 'rashnubook'),
        'whatsapp'  => __('نشانی واتساپ', 'rashnubook'),
        'bale'      => __('نشانی پیام‌رسان بله', 'rashnubook'),
        'eitaa'     => __('نشانی پیام‌رسان ایتا', 'rashnubook'),
        'x'         => __('نشانی شبکه X', 'rashnubook'),
    );
    foreach ($socials as $key => $label) {
        $wp_customize->add_setting('rashnubook_social_' . $key, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('rashnubook_social_' . $key, array(
            'label'   => $label,
            'section' => 'rashnubook_socials',
            'type'    => 'url',
        ));
    }

    // --- Newsletter ---
    $wp_customize->add_section('rashnubook_newsletter', array(
        'title'    => __('خبرنامه فوتر رشنو بوک', 'rashnubook'),
        'priority' => 36,
    ));

    $wp_customize->add_setting('rashnubook_newsletter_enable', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('rashnubook_newsletter_enable', array(
        'label'   => __('نمایش باکس خبرنامه در فوتر', 'rashnubook'),
        'section' => 'rashnubook_newsletter',
        'type'    => 'checkbox',
    ));

    $wp_customize->add_setting('rashnubook_newsletter_title', array(
        'default'           => 'عضویت در خبرنامه یادداشت‌های ادبی و حقوقی:',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('rashnubook_newsletter_title', array(
        'label'   => __('عنوان خبرنامه', 'rashnubook'),
        'section' => 'rashnubook_newsletter',
        'type'    => 'text',
    ));

    // --- Hero slider background image ---
    $wp_customize->add_section('rashnubook_hero', array(
        'title'    => __('اسلایدر هیرو (صفحه اصلی)', 'rashnubook'),
        'priority' => 34,
    ));

    $wp_customize->add_setting('rashnubook_hero_bg_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'rashnubook_hero_bg_image', array(
        'label'       => __('تصویر پس‌زمینه اسلایدر هیرو', 'rashnubook'),
        'description' => __('در صورت انتخاب تصویر، پس‌زمینه اسلایدر اول صفحه اصلی به آن تغییر می‌کند (لایه تیره برای خوانایی متن اضافه می‌شود).', 'rashnubook'),
        'section'     => 'rashnubook_hero',
    )));

    $wp_customize->add_setting('rashnubook_hero_overlay', array(
        'default'           => '0.55',
        'sanitize_callback' => 'rashnubook_fix_sanitize_opacity',
    ));
    $wp_customize->add_control('rashnubook_hero_overlay', array(
        'label'       => __('میزان تیرگی لایه روی تصویر (۰ تا ۱)', 'rashnubook'),
        'section'     => 'rashnubook_hero',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 1,
            'step' => 0.05,
        ),
    ));
}
add_action('customize_register', 'rashnubook_fix_register_customizer');

/* ---------------------------------------------------------------
 * 2) Newsletter — subscriber CPT + AJAX handler
 * --------------------------------------------------------------- */
function rashnubook_fix_register_subscriber_cpt() {
    register_post_type('rb_subscriber', array(
        'labels' => array(
            'name'          => 'مشترکان خبرنامه',
            'singular_name' => 'مشترک خبرنامه',
            'menu_name'     => 'خبرنامه',
            'all_items'     => 'همه مشترکان',
            'search_items'  => 'جستجوی مشترک',
            'not_found'     => 'هنوز مشترکی ثبت نشده است.',
        ),
        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'menu_icon'       => 'dashicons-email-alt',
        'menu_position'   => 26,
        'supports'        => array('title'),
        'capability_type' => 'post',
    ));
}
add_action('init', 'rashnubook_fix_register_subscriber_cpt');

function rashnubook_fix_newsletter_ajax() {
    check_ajax_referer('rashnubook_newsletter', 'nonce');

    $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';

    if (empty($email) || !is_email($email)) {
        wp_send_json_error(array('message' => 'نشانی ایمیل وارد شده معتبر نیست.'));
    }

    $existing = get_posts(array(
        'post_type'      => 'rb_subscriber',
        'title'          => $email,
        'posts_per_page' => 1,
        'fields'         => 'ids',
    ));

    if (!empty($existing)) {
        wp_send_json_success(array('message' => 'این ایمیل قبلاً در خبرنامه ثبت شده است. سپاس از همراهی شما!'));
    }

    $inserted = wp_insert_post(array(
        'post_type'   => 'rb_subscriber',
        'post_title'  => $email,
        'post_status' => 'publish',
    ));

    if (is_wp_error($inserted) || !$inserted) {
        wp_send_json_error(array('message' => 'ثبت ایمیل با خطا مواجه شد. لطفاً بعداً تلاش کنید.'));
    }

    update_post_meta($inserted, '_rb_subscribed_at', current_time('mysql'));

    wp_mail(
        get_option('admin_email'),
        'مشترک جدید خبرنامه ' . get_bloginfo('name'),
        'ایمیل جدیدی در خبرنامه ثبت شد: ' . $email
    );

    wp_send_json_success(array('message' => 'عضویت شما در خبرنامه با موفقیت ثبت شد.'));
}
add_action('wp_ajax_rashnubook_newsletter', 'rashnubook_fix_newsletter_ajax');
add_action('wp_ajax_nopriv_rashnubook_newsletter', 'rashnubook_fix_newsletter_ajax');

/* ---------------------------------------------------------------
 * 3) Landing pages — editable fields (metaboxes)
 * --------------------------------------------------------------- */
function rashnubook_fix_meta($post_id, $key, $default = '') {
    $value = get_post_meta($post_id, $key, true);
    return ('' !== $value) ? $value : $default;
}

function rashnubook_fix_parse_faq($raw) {
    $items = array();
    $lines = preg_split('/\r\n|\r|\n/', (string) $raw);
    foreach ($lines as $line) {
        $line = trim($line);
        if ('' === $line) {
            continue;
        }
        $parts = array_map('trim', explode('|', $line, 2));
        if (2 === count($parts) && '' !== $parts[0] && '' !== $parts[1]) {
            $items[] = array('q' => $parts[0], 'a' => $parts[1]);
        }
    }
    return $items;
}

function rashnubook_fix_landing_metabox() {
    global $post;
    if (!$post) {
        return;
    }
    $template = get_page_template_slug($post->ID);
    if ('template-landing.php' === $template) {
        add_meta_box('rashnubook_landing_fields', 'تنظیمات برگه فرود کتاب', 'rashnubook_fix_landing_metabox_html', 'page', 'normal', 'high');
    } elseif ('template-landing-aftabgardan.php' === $template) {
        add_meta_box('rashnubook_aftab_fields', 'تنظیمات لندینگ ماهنامه آفتابگردان', 'rashnubook_fix_aftab_metabox_html', 'page', 'normal', 'high');
    }
}
add_action('add_meta_boxes', 'rashnubook_fix_landing_metabox');

function rashnubook_fix_landing_metabox_html($post) {
    wp_nonce_field('rashnubook_landing_meta', 'rashnubook_landing_nonce');
    $fields = array(
        'rb_hero_sub'    => array('label' => 'زیرعنوان هیرو (خالی = پیش‌فرض)', 'type' => 'textarea'),
        'rb_old_price'   => array('label' => 'قیمت قبل از تخفیف (تومان)', 'type' => 'text'),
        'rb_price'       => array('label' => 'قیمت نهایی (تومان)', 'type' => 'text'),
        'rb_buy_url'     => array('label' => 'لینک دکمه خرید (خالی = فروشگاه)', 'type' => 'text'),
        'rb_landing_faq' => array('label' => 'پرسش‌های متداول — هر خط: سوال | پاسخ', 'type' => 'textarea'),
    );
    echo '<table class="form-table">';
    foreach ($fields as $key => $field) {
        $value = get_post_meta($post->ID, $key, true);
        echo '<tr><th style="width:300px"><label for="' . esc_attr($key) . '">' . esc_html($field['label']) . '</label></th><td>';
        if ('textarea' === $field['type']) {
            echo '<textarea style="width:100%;min-height:80px" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '">' . esc_textarea($value) . '</textarea>';
        } else {
            echo '<input type="text" style="width:100%" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '">';
        }
        echo '</td></tr>';
    }
    echo '</table>';
}

function rashnubook_fix_aftab_metabox_html($post) {
    wp_nonce_field('rashnubook_landing_meta', 'rashnubook_landing_nonce');
    $fields = array(
        'rb_aftab_single_id'    => 'شناسه (ID) محصول تک‌شماره در ووکامرس',
        'rb_aftab_single_price' => 'قیمت تک‌شماره (تومان)',
        'rb_aftab_annual_id'    => 'شناسه (ID) محصول اشتراک سالانه در ووکامرس',
        'rb_aftab_annual_price' => 'قیمت اشتراک سالانه (تومان)',
    );
    echo '<table class="form-table">';
    foreach ($fields as $key => $label) {
        $value = get_post_meta($post->ID, $key, true);
        echo '<tr><th style="width:300px"><label for="' . esc_attr($key) . '">' . esc_html($label) . '</label></th><td>';
        echo '<input type="text" style="width:100%" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '">';
        echo '</td></tr>';
    }
    echo '</table>';
}

function rashnubook_fix_save_landing_meta($post_id) {
    if (!isset($_POST['rashnubook_landing_nonce'])) {
        return;
    }
    $nonce = sanitize_key(wp_unslash($_POST['rashnubook_landing_nonce']));
    if (!wp_verify_nonce($nonce, 'rashnubook_landing_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $keys = array(
        'rb_hero_sub',
        'rb_old_price',
        'rb_price',
        'rb_buy_url',
        'rb_landing_faq',
        'rb_aftab_single_id',
        'rb_aftab_single_price',
        'rb_aftab_annual_id',
        'rb_aftab_annual_price',
    );
    foreach ($keys as $key) {
        if (!isset($_POST[$key])) {
            continue;
        }
        $raw   = wp_unslash($_POST[$key]);
        $clean = ('rb_buy_url' === $key) ? esc_url_raw($raw) : sanitize_textarea_field($raw);
        if ('' === $clean) {
            delete_post_meta($post_id, $key);
        } else {
            update_post_meta($post_id, $key, $clean);
        }
    }
}
add_action('save_post', 'rashnubook_fix_save_landing_meta');

/* ---------------------------------------------------------------
 * 4) Blog archive URL (page_for_posts aware)
 * --------------------------------------------------------------- */
function rashnubook_fix_blog_url() {
    $page_for_posts = (int) get_option('page_for_posts');
    if ($page_for_posts > 0) {
        $url = get_permalink($page_for_posts);
        if (!empty($url)) {
            return $url;
        }
    }
    return home_url('/');
}

/* ---------------------------------------------------------------
 * 5) Split merged product attributes (قطع / نوع جلد / نوبت چاپ)
 * --------------------------------------------------------------- */
function rashnubook_fix_split_merged_attributes($attributes, $product = null, $deprecated = null) {
    if (!is_array($attributes) || empty($attributes)) {
        return $attributes;
    }

    $out = array();
    foreach ($attributes as $key => $attr) {
        $label = isset($attr['label']) ? (string) $attr['label'] : '';
        $value = isset($attr['value']) ? (string) $attr['value'] : '';

        $has_ghata = (false !== mb_strpos($label, 'قطع'));
        $has_jeld  = (false !== mb_strpos($label, 'جلد'));
        $has_chap  = (false !== mb_strpos($label, 'نوبت چاپ'));

        $merged = ($has_jeld && ($has_ghata || $has_chap)) || ($has_ghata && $has_chap);

        if ($merged) {
            $parts = array_values(array_filter(array_map('trim', preg_split('/\s*[-–—]\s*/u', wp_strip_all_tags($value)))));
            if (count($parts) >= 2) {
                if ($has_ghata && $has_jeld) {
                    $out[$key . '_ghata'] = array('label' => 'قطع', 'value' => $parts[0]);
                    $out[$key . '_jeld']  = array('label' => 'نوع جلد', 'value' => $parts[1]);
                } elseif ($has_jeld && $has_chap) {
                    $out[$key . '_jeld'] = array('label' => 'نوع جلد', 'value' => $parts[0]);
                    $out[$key . '_chap'] = array('label' => 'نوبت چاپ', 'value' => $parts[1]);
                } else {
                    $out[$key . '_ghata'] = array('label' => 'قطع', 'value' => $parts[0]);
                    $out[$key . '_chap']  = array('label' => 'نوبت چاپ', 'value' => $parts[1]);
                }
                continue;
            }
        }

        $out[$key] = $attr;
    }

    return $out;
}
add_filter('woocommerce_display_product_attributes', 'rashnubook_fix_split_merged_attributes', 20, 3);
