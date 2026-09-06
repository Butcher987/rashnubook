<?php
/**
 * Theme Customizer Settings for rashnubook.ir
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

function rashnubook_customize_register($wp_customize) {
    // Panel: RashnuBook Settings
    $wp_customize->add_section('rashnubook_theme_options', array(
        'title'    => esc_html__('تنظیمات کتابفروشی آنلاین رَشن', 'rashnubook'),
        'priority' => 30,
    ));

    // Topbar announcement
    $wp_customize->add_setting('rashnubook_topbar_text', array(
        'default'           => 'ارسال سریع پستی کتاب به سراسر کشور | اینستاگرام: rashno_book@',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('rashnubook_topbar_text', array(
        'label'   => esc_html__('متن نوار بالای سایت', 'rashnubook'),
        'section' => 'rashnubook_theme_options',
        'type'    => 'text',
    ));

    // Support Phone
    $wp_customize->add_setting('rashnubook_phone', array(
        'default'           => '۰۲۱-۸۸۹۹۰۰۱۱',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('rashnubook_phone', array(
        'label'   => esc_html__('شماره تلفن پشتیبانی', 'rashnubook'),
        'section' => 'rashnubook_theme_options',
        'type'    => 'text',
    ));

    // Working hours
    $wp_customize->add_setting('rashnubook_hours', array(
        'default'           => 'شنبه تا چهارشنبه ۹ الی ۱۸',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('rashnubook_hours', array(
        'label'   => esc_html__('ساعات کاری و پاسخگویی', 'rashnubook'),
        'section' => 'rashnubook_theme_options',
        'type'    => 'text',
    ));
}
add_action('customize_register', 'rashnubook_customize_register');
