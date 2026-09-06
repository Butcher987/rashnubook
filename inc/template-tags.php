<?php
/**
 * Custom template tags and helper functions for rashnubook.ir
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Convert English digits to Persian digits
 */
function rashnubook_to_persian_numbers($number) {
    if (empty($number) && $number !== '0' && $number !== 0) {
        return '';
    }
    $english = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    return str_replace($english, $persian, (string)$number);
}

/**
 * Return inline SVG icons for maximum performance (0 extra HTTP requests)
 */
function rashnubook_get_icon($icon_name) {
    $icons = array(
        'search' => '<svg class="icon" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>',
        'cart' => '<svg class="icon" viewBox="0 0 24 24"><path d="M17.21 9l-4.38-6.56a.993.993 0 0 0-.83-.42c-.32 0-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1h-4.79zM9 9l3-4.4L15 9H9zm3 8c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/></svg>',
        'user' => '<svg class="icon" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>',
        'book' => '<svg class="icon" viewBox="0 0 24 24"><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/></svg>',
        'check' => '<svg class="icon" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>',
        'close' => '<svg class="icon" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>',
        'menu' => '<svg class="icon" viewBox="0 0 24 24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>',
        'shipping' => '<svg class="icon" viewBox="0 0 24 24"><path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg>',
        'shield' => '<svg class="icon" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>',
        'support' => '<svg class="icon" viewBox="0 0 24 24"><path d="M20 15.5c-1.25 0-2.45-.2-3.57-.57a1.02 1.02 0 0 0-1.02.24l-2.2 2.2a15.045 15.045 0 0 1-6.59-6.59l2.2-2.21c.28-.26.36-.65.25-1.01A11.36 11.36 0 0 1 8.5 4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1 0 9.39 7.61 17 17 17 .55 0 1-.45 1-1v-3.5c0-.55-.45-1-1-1zM19 12h2a9 9 0 0 0-9-9v2c3.87 0 7 3.13 7 7zm-4 0h2a5 5 0 0 0-5-5v2a3 3 0 0 1 3 3z"/></svg>',
        'heart' => '<svg class="icon" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>',
        'arrow-left' => '<svg class="icon" viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>',
        'star' => '<svg class="icon" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>',
        'instagram' => '<svg class="icon icon-instagram" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
        'telegram' => '<svg class="icon icon-telegram" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.121l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953l11.57-4.461c.537-.196 1.006.128.832.942z"/></svg>',
        'whatsapp' => '<svg class="icon icon-whatsapp" viewBox="0 0 24 24"><path d="M17.472 14.382c-.301-.15-1.776-.877-2.052-.977-.275-.101-.475-.15-.675.15-.2.3-.775 1-.95 1.2-.175.2-.35.225-.65.075-.3-.15-1.267-.467-2.414-1.488-.894-.796-1.498-1.78-1.674-2.08-.175-.3-.018-.463.132-.613.136-.134.301-.35.451-.525.15-.175.2-.3.3-.5.1-.2.05-.375-.025-.525-.075-.15-.675-1.626-.925-2.226-.243-.585-.49-.505-.675-.515-.175-.01-.375-.01-.575-.01-.2 0-.525.075-.8.375s-1.05 1.025-1.05 2.5 1.075 2.9 1.225 3.1c.15.2 2.115 3.23 5.124 4.53.715.31 1.274.495 1.71.635.72.23 1.375.197 1.892.12.578-.087 1.776-.726 2.026-1.427.25-.7.25-1.301.175-1.427-.075-.125-.275-.2-.575-.35zM12.043 21.65a9.58 9.58 0 0 1-4.887-1.332l-.35-.208-3.634.953.97-3.543-.228-.363a9.587 9.587 0 0 1-1.468-5.08c.005-5.304 4.32-9.617 9.626-9.617a9.58 9.58 0 0 1 6.808 2.822 9.57 9.57 0 0 1 2.817 6.797c-.004 5.307-4.32 9.621-9.654 9.621zm8.214-17.842A11.536 11.536 0 0 0 12.04.5C5.67.5.498 5.674.495 12.048c-.002 2.036.53 4.026 1.542 5.783L0 24.12l6.452-1.692a11.53 11.53 0 0 0 5.588 1.442h.005c6.37 0 11.545-5.176 11.548-11.551a11.49 11.49 0 0 0-3.376-8.161z"/></svg>',
        'x' => '<svg class="icon icon-x" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
        'twitter' => '<svg class="icon icon-x" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
        'bale' => '<svg class="icon icon-bale" viewBox="0 0 32 32"><path d="M16 3C8.82 3 3 8.82 3 16c0 2.53.72 4.9 1.98 6.92L3.1 28.9l6.18-1.83A12.92 12.92 0 0 0 16 29c7.18 0 13-5.82 13-13S23.18 3 16 3zm0 5.5c2.48 0 4.5 2.02 4.5 4.5 0 2.01-1.33 3.72-3.17 4.28l.92 4.22h-4.5l.92-4.22C12.83 16.72 11.5 15.01 11.5 13c0-2.48 2.02-4.5 4.5-4.5z"/></svg>',
        'eitaa' => '<svg class="icon icon-eitaa" viewBox="0 0 32 32"><path d="M16 3C8.82 3 3 8.82 3 16c0 2.53.72 4.9 1.98 6.92L3.1 28.9l6.18-1.83A12.92 12.92 0 0 0 16 29c7.18 0 13-5.82 13-13S23.18 3 16 3zm4.8 14.5c-.8 1.4-2.3 2.3-4 2.3-2.6 0-4.7-2.1-4.7-4.7s2.1-4.7 4.7-4.7c1.7 0 3.2.9 4 2.3l-2.4 1.4c-.4-.7-1-1.1-1.6-1.1-1.2 0-2.1.9-2.1 2.1s.9 2.1 2.1 2.1c.6 0 1.2-.4 1.6-1.1l2.4 1.4z"/></svg>',
        'award' => '<svg class="icon" viewBox="0 0 24 24"><circle cx="12" cy="8" r="6" fill="none" stroke="currentColor" stroke-width="2"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11" fill="none" stroke="currentColor" stroke-width="2"/></svg>',
        'box' => '<svg class="icon" viewBox="0 0 24 24"><path d="M21 16.5l-9 5.2-9-5.2V7.5l9-5.2 9 5.2v9z" fill="none" stroke="currentColor" stroke-width="2"/><polyline points="3.27 6.96 12 12.01 20.73 6.96" fill="none" stroke="currentColor" stroke-width="2"/><line x1="12" y1="22.08" x2="12" y2="12" stroke="currentColor" stroke-width="2"/></svg>',
        'truck' => '<svg class="icon" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" fill="none" stroke="currentColor" stroke-width="2"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>',
        'card' => '<svg class="icon" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2" fill="none" stroke="currentColor" stroke-width="2"/><line x1="1" y1="10" x2="23" y2="10" stroke="currentColor" stroke-width="2"/></svg>',
        'phone' => '<svg class="icon" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" fill="none" stroke="currentColor" stroke-width="2"/></svg>',
        'clock' => '<svg class="icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2"/><polyline points="12 6 12 12 16 14" fill="none" stroke="currentColor" stroke-width="2"/></svg>',
        'return' => '<svg class="icon" viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10" fill="none" stroke="currentColor" stroke-width="2"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10" fill="none" stroke="currentColor" stroke-width="2"/></svg>',
        'lock' => '<svg class="icon" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2" fill="none" stroke="currentColor" stroke-width="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4" fill="none" stroke="currentColor" stroke-width="2"/></svg>',
        'gift' => '<svg class="icon" viewBox="0 0 24 24"><polyline points="20 12 20 22 4 22 4 12" fill="none" stroke="currentColor" stroke-width="2"/><rect x="2" y="7" width="20" height="5" fill="none" stroke="currentColor" stroke-width="2"/><line x1="12" y1="22" x2="12" y2="7" stroke="currentColor" stroke-width="2"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z" fill="none" stroke="currentColor" stroke-width="2"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z" fill="none" stroke="currentColor" stroke-width="2"/></svg>',
        'badge' => '<svg class="icon" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" fill="none" stroke="currentColor" stroke-width="2"/></svg>',
    );

    return isset($icons[$icon_name]) ? $icons[$icon_name] : '';
}

/**
 * Echo SVG Icon
 */
function rashnubook_icon($icon_name) {
    echo rashnubook_get_icon($icon_name); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Get customizable trust & feature badges
 */
function rashnubook_get_trust_badges() {
    $defaults = array(
        1 => array(
            'icon'  => 'shipping',
            'title' => 'ارسال سریع پستی',
            'desc'  => 'ارسال با پست پیشتاز و سفارشی به تمام نقاط ایران برای سفارش‌های کتاب',
            'color' => 'var(--primary)',
            'bg'    => 'rgba(27,67,50,0.08)',
        ),
        2 => array(
            'icon'  => 'shield',
            'title' => 'ضمانت اصالت و سلامت نسخه',
            'desc'  => 'تضمین ۱۰۰٪ ویرایش رسمی، چاپ قانونی و کاغذ باکیفیت',
            'color' => 'var(--terracotta)',
            'bg'    => 'rgba(162,79,59,0.08)',
        ),
        3 => array(
            'icon'  => 'book',
            'title' => 'بسته‌بندی نفیس و نشانک هدیه',
            'desc'  => 'همراه با بوک‌مارک و بسته‌بندی ایمن مقاوم در برابر آسیب پستی',
            'color' => 'var(--secondary)',
            'bg'    => 'rgba(74,90,79,0.08)',
        ),
        4 => array(
            'icon'  => 'support',
            'title' => 'مشاوره تخصصی منابع آزمونی',
            'desc'  => 'راهنمایی داوطلبان آزمون‌های وکالت و قضاوت توسط مشاوران حقوقی',
            'color' => 'var(--mocha)',
            'bg'    => 'rgba(59,47,47,0.08)',
        ),
    );

    $badges = array();
    for ($i = 1; $i <= 4; $i++) {
        $enabled     = function_exists('rashnubook_get_option') ? rashnubook_get_option("trust_{$i}_enable", '1') : '1';
        $icon        = function_exists('rashnubook_get_option') ? rashnubook_get_option("trust_{$i}_icon", $defaults[$i]['icon']) : $defaults[$i]['icon'];
        $custom_icon = function_exists('rashnubook_get_option') ? rashnubook_get_option("trust_{$i}_custom_icon", '') : '';
        $title       = function_exists('rashnubook_get_option') ? rashnubook_get_option("trust_{$i}_title", $defaults[$i]['title']) : $defaults[$i]['title'];
        $desc        = function_exists('rashnubook_get_option') ? rashnubook_get_option("trust_{$i}_desc", $defaults[$i]['desc']) : $defaults[$i]['desc'];

        $badges[$i] = array(
            'enabled'     => $enabled !== '0',
            'icon'        => !empty($icon) ? $icon : $defaults[$i]['icon'],
            'custom_icon' => $custom_icon,
            'title'       => !empty($title) ? $title : $defaults[$i]['title'],
            'desc'        => !empty($desc) ? $desc : $defaults[$i]['desc'],
            'color'       => $defaults[$i]['color'],
            'bg'          => $defaults[$i]['bg'],
        );
    }

    return $badges;
}

/**
 * Get electronic trust seals (Enamad, Samandehi, etc.)
 */
function rashnubook_get_trust_seals() {
    return array(
        'enamad'      => function_exists('rashnubook_get_option') ? rashnubook_get_option('trust_seal_enamad', '') : '',
        'samandehi'   => function_exists('rashnubook_get_option') ? rashnubook_get_option('trust_seal_samandehi', '') : '',
        'custom'      => function_exists('rashnubook_get_option') ? rashnubook_get_option('trust_seal_custom', '') : '',
    );
}

/**
 * Retrieve Book Attributes for a WooCommerce Product
 * Compatible with custom meta or WooCommerce product attributes
 */
function rashnubook_get_book_attributes($product_id) {
    $product = wc_get_product($product_id);
    if (!$product) {
        return array();
    }

    $attributes = array(
        'author'      => get_post_meta($product_id, '_book_author', true),
        'translator'  => get_post_meta($product_id, '_book_translator', true),
        'publisher'   => get_post_meta($product_id, '_book_publisher', true),
        'isbn'        => get_post_meta($product_id, '_book_isbn', true),
        'pages'       => get_post_meta($product_id, '_book_pages', true),
        'format'      => get_post_meta($product_id, '_book_format', true),
        'cover'       => get_post_meta($product_id, '_book_cover', true),
        'edition'     => get_post_meta($product_id, '_book_edition', true),
        'excerpt'     => get_post_meta($product_id, '_book_quote', true),
    );

    // Fallback to standard product attributes if custom meta not set
    if (empty($attributes['author'])) {
        $attributes['author'] = $product->get_attribute('author') ?: ($product->get_attribute('نویسنده') ?: $product->get_attribute('پدیدآور'));
    }
    if (empty($attributes['translator'])) {
        $attributes['translator'] = $product->get_attribute('translator') ?: $product->get_attribute('مترجم');
    }
    if (empty($attributes['publisher'])) {
        $attributes['publisher'] = $product->get_attribute('publisher') ?: $product->get_attribute('ناشر');
    }
    if (empty($attributes['isbn'])) {
        $attributes['isbn'] = $product->get_attribute('isbn') ?: ($product->get_attribute('شابک') ?: $product->get_attribute('شابك'));
    }
    if (empty($attributes['pages'])) {
        $attributes['pages'] = $product->get_attribute('pages') ?: ($product->get_attribute('تعداد صفحات') ?: ($product->get_attribute('صفحات') ?: $product->get_attribute('صفحه')));
    }
    if (empty($attributes['format'])) {
        $attributes['format'] = $product->get_attribute('format') ?: ($product->get_attribute('قطع') ?: $product->get_attribute('قطع کتاب'));
    }
    if (empty($attributes['cover'])) {
        $attributes['cover'] = $product->get_attribute('cover') ?: ($product->get_attribute('نوع جلد') ?: $product->get_attribute('جلد'));
    }
    if (empty($attributes['edition'])) {
        $attributes['edition'] = $product->get_attribute('edition') ?: ($product->get_attribute('نوبت چاپ') ?: ($product->get_attribute('چاپ') ?: $product->get_attribute('سال چاپ')));
    }

    return $attributes;
}

/**
 * Render 3D Book Spine Mockup for Hero Slider and Showcases
 */
function rashnubook_render_3d_book_mockup($args = array()) {
    $cover_id    = !empty($args['cover_id']) ? (int)$args['cover_id'] : 0;
    $custom_url  = !empty($args['custom_url']) ? esc_url($args['custom_url']) : '';
    $title       = !empty($args['title']) ? $args['title'] : 'کتاب رشنو';
    $author      = !empty($args['author']) ? $args['author'] : '';
    $bg_grad     = !empty($args['bg_gradient']) ? $args['bg_gradient'] : 'linear-gradient(135deg, #1F4D3A 0%, #153628 100%)';
    $spine_color = !empty($args['spine_color']) ? $args['spine_color'] : '#142c20';
    $edition     = !empty($args['edition']) ? $args['edition'] : 'چاپ نفیس';
    $pages       = !empty($args['pages']) ? $args['pages'] : '';
    $publisher   = !empty($args['publisher']) ? $args['publisher'] : 'کتابفروشی آنلاین رَشن';
    $link        = !empty($args['link']) ? $args['link'] : '';

    $has_image = !empty($custom_url) || ($cover_id > 0 && wp_attachment_is_image($cover_id));
    $img_html = '';
    if (!empty($custom_url)) {
        $img_html = '<img src="' . esc_url($custom_url) . '" alt="' . esc_attr($title) . '" class="rb-3d-book-img" />';
    } elseif ($cover_id > 0) {
        $img_html = wp_get_attachment_image($cover_id, 'large', false, array(
            'class'   => 'rb-3d-book-img',
            'alt'     => esc_attr($title),
            'loading' => 'eager',
        ));
    }
    ?>
    <div class="rb-3d-book-stage">
        <?php if (!empty($link)) : ?><a href="<?php echo esc_url($link); ?>" class="rb-3d-book-link" style="text-decoration:none; display:block;"><?php endif; ?>
        <div class="rb-3d-book-item <?php echo $has_image ? 'has-cover-image' : 'is-tactile-mockup'; ?>">
            <div class="rb-3d-book-front">
                <?php if ($has_image) : ?>
                    <div class="rb-3d-book-img-wrapper">
                        <?php echo $img_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </div>
                <?php else : ?>
                    <!-- Tactile Editorial Book Jacket -->
                    <div class="tento-book-spine-mockup" style="background: <?php echo esc_attr($bg_grad); ?>; color: #ffffff;">
                        <div class="tento-spine-ridge" style="background: <?php echo esc_attr($spine_color); ?>;"></div>
                        <div class="tento-mockup-inner">
                            <div style="display:flex; justify-content:space-between; font-size:11px;">
                                <span style="background:rgba(255,255,255,0.2); color:#fff; padding:2px 8px; border-radius:4px; font-weight:700;"><?php echo esc_html($edition); ?></span>
                                <?php if ($pages) : ?><span style="color:#FFE5B4;"><?php echo esc_html($pages); ?></span><?php endif; ?>
                            </div>
                            <div style="text-align:center; padding: 24px 0;">
                                <h3 style="font-size:20px; font-weight:900; line-height:1.3; color:#FFE5B4; margin-bottom:8px;"><?php echo esc_html($title); ?></h3>
                                <div style="font-size:13px; color:#dff0e7;"><?php echo esc_html($author); ?></div>
                            </div>
                            <div style="border-top:1px solid rgba(255,255,255,0.15); padding-top:8px; display:flex; justify-content:space-between; font-size:11px; opacity:0.85;">
                                <span><?php echo esc_html($publisher); ?></span>
                                <span>ارسال پستی</span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- 3D Realistic Spine Shadow & Specular Gloss (RTL: right side spine fold) -->
                <span class="rb-3d-spine-shadow"></span>
                <span class="rb-3d-cover-glare"></span>
            </div>

            <!-- 3D Book Pages Thickness (Left Edge in RTL) -->
            <div class="rb-3d-book-pages"></div>
        </div>
        <?php if (!empty($link)) : ?></a><?php endif; ?>
        <!-- Realistic 3D Drop Shadow on Floor -->
        <div class="rb-3d-book-ground-shadow"></div>
    </div>
    <?php
}

/**
 * Render dynamic footer link columns (پیوندهای مهم و موضوعات برگزیده)
 */
function rashnubook_render_footer_column($col_key, $default_title, $default_links = array()) {
    $enable = rashnubook_get_option("footer_{$col_key}_enable", '1') !== '0';
    if (!$enable) {
        return;
    }

    $title = rashnubook_get_option("footer_{$col_key}_title", $default_title);
    $menu_loc = ($col_key === 'col2') ? 'footer_links' : (($col_key === 'col3') ? 'footer_categories' : '');

    echo '<div class="footer-col">';
    echo '<h4>' . esc_html($title) . '</h4>';

    if ($menu_loc && has_nav_menu($menu_loc)) {
        wp_nav_menu(array(
            'theme_location' => $menu_loc,
            'container'      => false,
            'menu_class'     => 'footer-links',
            'fallback_cb'    => false,
        ));
    } else {
        $custom_text = rashnubook_get_option("footer_{$col_key}_links", '');
        $links = array();
        if (!empty(trim($custom_text))) {
            $lines = explode("\n", $custom_text);
            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) continue;
                $parts = explode('|', $line, 2);
                $link_title = trim($parts[0] ?? '');
                $link_url   = trim($parts[1] ?? '#');
                if ($link_title) {
                    $links[] = array('title' => $link_title, 'url' => $link_url);
                }
            }
        } else {
            $links = $default_links;
        }

        if (!empty($links)) {
            echo '<ul class="footer-links">';
            foreach ($links as $lnk) {
                $url = $lnk['url'];
                if (strpos($url, 'http') !== 0 && strpos($url, '/') === 0) {
                    $url = home_url($url);
                }
                echo '<li><a href="' . esc_url($url) . '">' . esc_html($lnk['title']) . '</a></li>';
            }
            echo '</ul>';
        }
    }

    echo '</div>';
}

/**
 * Render Header Category Dropdown Menu
 * Powered by 'category' navigation menu location or live WooCommerce product categories
 */
function rashnubook_render_header_category_dropdown() {
    if (has_nav_menu('category')) {
        wp_nav_menu(array(
            'theme_location' => 'category',
            'container'      => false,
            'menu_class'     => 'category-dropdown-list',
            'fallback_cb'    => false,
            'depth'          => 3,
        ));
    } else {
        $cats = array();
        if (class_exists('WooCommerce')) {
            $cats = get_terms(array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
                'parent'     => 0,
                'number'     => 8,
                'exclude'    => array((int)get_option('default_product_cat', 0)),
            ));
        }

        echo '<ul class="category-dropdown-list">';
        if (!empty($cats) && !is_wp_error($cats)) {
            foreach ($cats as $cat) {
                echo '<li class="cat-dropdown-item">';
                echo '<a href="' . esc_url(get_term_link($cat)) . '">';
                echo '<span>' . esc_html($cat->name) . '</span>';
                if ($cat->count > 0) {
                    echo '<span class="cat-count-badge">' . esc_html(rashnubook_to_persian_numbers($cat->count)) . '</span>';
                }
                echo '</a>';
                echo '</li>';
            }
        } else {
            echo '<li class="cat-dropdown-empty"><span style="padding:10px 16px; display:block; color:#777; font-size:12.5px;">' . esc_html__('فهرست دسته‌ها را از نمایش > فهرست‌ها تنظیم کنید.', 'rashnubook') . '</span></li>';
        }
        echo '<li class="cat-dropdown-all"><a href="' . esc_url(home_url('/categories/')) . '"><span>' . esc_html__('مشاهده تمامی موضوعات و دسته‌ها', 'rashnubook') . '</span><span class="cat-arrow">‹</span></a></li>';
        echo '</ul>';
    }
}

/**
 * Render Mobile Drawer Category Menu
 * Powered by 'category' navigation menu location or live WooCommerce product categories
 */
function rashnubook_render_drawer_category_menu() {
    if (has_nav_menu('category')) {
        wp_nav_menu(array(
            'theme_location' => 'category',
            'container'      => false,
            'menu_class'     => 'drawer-cat-menu-list',
            'fallback_cb'    => false,
            'depth'          => 2,
        ));
    } else {
        $live_cats = array();
        if (class_exists('WooCommerce')) {
            $live_cats = get_terms(array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
                'parent'     => 0,
                'number'     => 8,
                'exclude'    => array((int)get_option('default_product_cat', 0)),
            ));
        }

        if (!empty($live_cats) && !is_wp_error($live_cats)) {
            $palette = array('#1F4D3A', '#A56A4A', '#3B2F2F', '#7C8B6A', '#854f34', '#b83b26', '#2D231E');
            $ci = 0;
            echo '<div class="drawer-cat-list">';
            foreach ($live_cats as $lcat) {
                if ($lcat->slug === 'uncategorized' || $lcat->slug === 'dast-bandy-nshdh') {
                    continue;
                }
                $dot_col = $palette[$ci % count($palette)];
                $ci++;
                echo '<a href="' . esc_url(get_term_link($lcat)) . '" class="drawer-cat-item">';
                echo '<span class="drawer-cat-dot" style="background:' . esc_attr($dot_col) . ';"></span>';
                echo '<span class="drawer-cat-name">' . esc_html($lcat->name) . '</span>';
                if ($lcat->count > 0) {
                    echo '<span class="drawer-cat-badge">' . esc_html(rashnubook_to_persian_numbers($lcat->count)) . '</span>';
                }
                echo '</a>';
            }
            echo '</div>';
        }
    }
}

/**
 * Get active homepage category cards
 * Synchronized with WordPress Menus ('category' location) or fallback to real WooCommerce categories
 */
function rashnubook_get_active_category_cards() {
    $cards = array();

    // 1. Check if user configured a 'category' menu in Appearance > Menus
    if (has_nav_menu('category')) {
        $locations = get_nav_menu_locations();
        $menu_id   = $locations['category'] ?? 0;
        if ($menu_id) {
            $menu_items = wp_get_nav_menu_items($menu_id);
            if (!empty($menu_items)) {
                $icon_palette = array('book', 'feather', 'star', 'heart', 'user', 'bookmark');
                $card_idx = 0;
                foreach ($menu_items as $item) {
                    if ((int)$item->menu_item_parent !== 0) {
                        continue; // Top level items only
                    }
                    $count_str = '';
                    if ($item->object === 'product_cat') {
                        $term = get_term($item->object_id, 'product_cat');
                        if ($term && !is_wp_error($term) && $term->count > 0) {
                            $count_str = rashnubook_to_persian_numbers($term->count) . ' عنوان کتاب';
                        }
                    }
                    $cards[] = array(
                        'enabled' => true,
                        'slug'    => '',
                        'title'   => $item->title,
                        'url'     => $item->url,
                        'icon'    => $icon_palette[$card_idx % count($icon_palette)],
                        'count'   => $count_str,
                    );
                    $card_idx++;
                    if ($card_idx >= 5) {
                        break;
                    }
                }
            }
        }
    }

    // 2. If no menu items, check configured admin panel cards or live WooCommerce categories
    if (empty($cards) && function_exists('rashnubook_get_homepage_category_cards')) {
        $admin_cards = rashnubook_get_homepage_category_cards();
        $filtered    = array_filter($admin_cards, static fn($c) => !empty($c['enabled']));

        $has_real_term = false;
        if (class_exists('WooCommerce')) {
            foreach ($filtered as $fc) {
                if (!empty($fc['slug']) && term_exists($fc['slug'], 'product_cat')) {
                    $has_real_term = true;
                    break;
                }
            }
        }

        if ($has_real_term || !class_exists('WooCommerce')) {
            $cards = $filtered;
        } else {
            // Automatically populate from real WooCommerce product categories
            $live_terms = get_terms(array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
                'parent'     => 0,
                'number'     => 5,
                'exclude'    => array((int)get_option('default_product_cat', 0)),
            ));

            if (!empty($live_terms) && !is_wp_error($live_terms)) {
                $icon_palette = array('book', 'feather', 'star', 'heart', 'user');
                $i = 0;
                foreach ($live_terms as $lt) {
                    $cards[] = array(
                        'enabled' => true,
                        'slug'    => $lt->slug,
                        'title'   => $lt->name,
                        'url'     => get_term_link($lt),
                        'icon'    => $icon_palette[$i % count($icon_palette)],
                        'count'   => ($lt->count > 0) ? rashnubook_to_persian_numbers($lt->count) . ' عنوان کتاب' : '',
                    );
                    $i++;
                }
            } else {
                $cards = $filtered;
            }
        }
    }

    return $cards;
}



