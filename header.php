<?php
/**
 * The header for rashnubook.ir
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('پرش به محتوای اصلی', 'rashnubook'); ?></a>

    <header id="masthead" class="site-header">
        <!-- Top Announcement Bar -->
        <div class="topbar-ticker">
            <div class="container">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <?php rashnubook_icon('shipping'); ?>
                    <span><?php echo esc_html(rashnubook_get_option('topbar_text', 'ارسال سریع و کاملاً رایگان کتاب به سراسر کشور | اینستاگرام: rashno_book@')); ?></span>
                </div>
                <div class="topbar-info" style="display: flex; align-items: center; gap: 16px;">
                    <a href="https://instagram.com/<?php echo esc_attr(rashnubook_get_option('instagram', 'rashno_book')); ?>" target="_blank" rel="noopener" style="color:#ffe088; display:flex; align-items:center; gap:6px; font-weight:700; text-decoration:none;">
                        <?php rashnubook_icon('instagram'); ?>
                        <span>اینستاگرام:</span>
                        <span><?php echo esc_html(rashnubook_get_option('instagram', 'rashno_book')); ?>@</span>
                    </a>
                    <span style="opacity: 0.4;">|</span>
                    <span><?php esc_html_e('پشتیبانی:', 'rashnubook'); ?> <?php echo esc_html(rashnubook_get_option('phone', '۰۲۱-۸۸۹۹۰۰۱۱')); ?></span>
                    <span style="opacity: 0.4;">|</span>
                    <span><?php echo esc_html(rashnubook_get_option('hours', 'ساعات پاسخگویی: ۹ الی ۱۹')); ?></span>
                </div>
            </div>
        </div>

        <!-- Main Header Bar -->
        <div class="header-main">
            <div class="container header-main-inner">
                <div class="header-brand-wrap">
                    <!-- Mobile Drawer Toggle -->
                    <button type="button" class="mobile-toggle" data-drawer-toggle="mobile-menu" aria-label="<?php esc_attr_e('باز کردن منو و دسته‌بندی‌ها', 'rashnubook'); ?>">
                        <?php rashnubook_icon('menu'); ?>
                    </button>

                    <!-- Brand Logo -->
                    <div class="site-branding">
                        <?php if (has_custom_logo()) : ?>
                            <?php the_custom_logo(); ?>
                        <?php else : ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-brand" rel="home">
                                <img src="<?php echo esc_url(RASHNUBOOK_URI . '/assets/images/rashnu-logo.jpg'); ?>" alt="<?php bloginfo('name'); ?>" class="site-brand-logo">
                                <div class="site-brand-text">
                                    <span class="site-title-text">کتابفروشی آنلاین رَشن</span>
                                    <span class="site-subtitle-text">R A S H N U  B O O K</span>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Header Actions (Account & Cart) -->
                <div class="header-actions">
                    <?php if (class_exists('WooCommerce')) : ?>
                        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="header-action-link header-action-account" title="<?php esc_attr_e('حساب کاربری', 'rashnubook'); ?>">
                            <?php rashnubook_icon('user'); ?>
                            <span><?php is_user_logged_in() ? esc_html_e('حساب کاربری', 'rashnubook') : esc_html_e('ورود', 'rashnubook'); ?></span>
                        </a>

                        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="header-action-link cart-button-badge" data-drawer-toggle="mini-cart" title="<?php esc_attr_e('سبد خرید', 'rashnubook'); ?>">
                            <?php rashnubook_icon('cart'); ?>
                            <span class="cart-count js-cart-count"><?php echo esc_html(rashnubook_to_persian_numbers(WC()->cart->get_cart_contents_count())); ?></span>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url(wp_login_url()); ?>" class="header-action-link">
                            <?php rashnubook_icon('user'); ?>
                            <span><?php esc_html_e('ورود', 'rashnubook'); ?></span>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Live Search Form with Ajax Results -->
                <div class="header-search">
                    <form role="search" method="get" class="search-form-wrap" action="<?php echo esc_url(home_url('/')); ?>">
                        <?php if (class_exists('WooCommerce')) : ?>
                            <input type="hidden" name="post_type" value="product">
                        <?php endif; ?>
                        <input type="search" class="search-input" placeholder="<?php esc_attr_e('جستجوی عنوان کتاب، نویسنده، مترجم، نشر یا شابک...', 'rashnubook'); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" data-ajax-search>
                        <button type="submit" class="search-btn" aria-label="<?php esc_attr_e('جستجو', 'rashnubook'); ?>">
                            <?php rashnubook_icon('search'); ?>
                            <span class="search-btn-text"><?php esc_html_e('جستجو', 'rashnubook'); ?></span>
                        </button>
                    </form>
                    <div class="search-results-dropdown" data-search-dropdown style="display:none;" aria-live="polite"></div>
                </div>
            </div>
        </div>

        <!-- Navigation Bar -->
        <div class="nav-bar">
            <div class="container">
                <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e('منوی اصلی', 'rashnubook'); ?>">
                    <?php
                    if (has_nav_menu('primary')) {
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'container'      => false,
                            'menu_class'     => 'main-nav-list',
                            'fallback_cb'    => false,
                            'items_wrap'     => '%3$s',
                        ));
                    } else {
                        // Default Fallback Menu
                        ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="<?php echo is_front_page() ? 'active' : ''; ?>"><?php esc_html_e('خانه', 'rashnubook'); ?></a>
                        <?php if (class_exists('WooCommerce')) : ?>
                            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="<?php echo is_shop() ? 'active' : ''; ?>"><?php esc_html_e('کتاب‌ها و کاتالوگ', 'rashnubook'); ?></a>
                        <?php endif; ?>
                        <a href="<?php echo esc_url(home_url('/aftabgardan/')); ?>"><?php esc_html_e('صفحه فرود ویژه', 'rashnubook'); ?></a>
                        <a href="<?php echo esc_url(home_url('/blog/')); ?>"><?php esc_html_e('یادداشت‌ها و نقد کتاب', 'rashnubook'); ?></a>
                        <?php
                    }
                    ?>
                </nav>
            </div>
        </div>
    </header>

    <!-- Overlay backdrop -->
    <div id="site-overlay" class="drawer-overlay"></div>

    <!-- Mobile Drawer -->
    <aside id="mobile-menu-drawer" class="mobile-drawer" aria-label="<?php esc_attr_e('منو و دسته‌بندی‌های سایت', 'rashnubook'); ?>">
        <div class="mobile-drawer-header">
            <div style="display: flex; align-items: center; gap: 8px;">
                <img src="<?php echo esc_url(RASHNUBOOK_URI . '/assets/images/rashnu-logo.jpg'); ?>" alt="لوگو" style="width: 32px; height: 32px; border-radius: 6px; object-fit: cover; border: 1px solid var(--warm-beige);">
                <div>
                    <span style="font-weight: 800; font-size: 15px; color: var(--primary); display: block; line-height: 1.2;"><?php esc_html_e('دسته‌ها و منوی کتاب‌سرا', 'rashnubook'); ?></span>
                    <span style="font-size: 10px; color: var(--terracotta); font-weight: 700;">RASHNUBOOK.IR</span>
                </div>
            </div>
            <button type="button" class="mobile-drawer-close-btn" data-drawer-close="mobile-menu" aria-label="<?php esc_attr_e('بستن منو', 'rashnubook'); ?>"><?php rashnubook_icon('close'); ?></button>
        </div>
        <div class="mobile-drawer-body">
            <!-- Book Categories Section -->
            <div class="drawer-section">
                <div class="drawer-section-title">
                    <?php rashnubook_icon('book'); ?>
                    <span><?php esc_html_e('دسته‌بندی‌های موضوعی کتاب', 'rashnubook'); ?></span>
                </div>
                <div class="drawer-cat-list">
                    <a href="<?php echo esc_url(add_query_arg('product_cat', 'law-books', home_url('/shop/'))); ?>" class="drawer-cat-item">
                        <span class="drawer-cat-dot" style="background:#1F4D3A;"></span>
                        <span class="drawer-cat-name">کتب تخصصی حقوقی و آزمونی</span>
                        <span class="drawer-cat-badge">وکالت و قضاوت</span>
                    </a>
                    <a href="<?php echo esc_url(add_query_arg('product_cat', 'fiction', home_url('/shop/'))); ?>" class="drawer-cat-item">
                        <span class="drawer-cat-dot" style="background:#A56A4A;"></span>
                        <span class="drawer-cat-name">ادبیات داستانی و رمان</span>
                        <span class="drawer-cat-badge">شاهکارها</span>
                    </a>
                    <a href="<?php echo esc_url(add_query_arg('product_cat', 'philosophy', home_url('/shop/'))); ?>" class="drawer-cat-item">
                        <span class="drawer-cat-dot" style="background:#3B2F2F;"></span>
                        <span class="drawer-cat-name">فلسفه، منطق و حکمت</span>
                    </a>
                    <a href="<?php echo esc_url(add_query_arg('product_cat', 'poetry', home_url('/shop/'))); ?>" class="drawer-cat-item">
                        <span class="drawer-cat-dot" style="background:#7C8B6A;"></span>
                        <span class="drawer-cat-name">شعر کهن و دیوان معاصر</span>
                    </a>
                    <a href="<?php echo esc_url(add_query_arg('product_cat', 'psychology', home_url('/shop/'))); ?>" class="drawer-cat-item">
                        <span class="drawer-cat-dot" style="background:#854f34;"></span>
                        <span class="drawer-cat-name">روان‌شناسی و خودکاوی</span>
                    </a>
                </div>
            </div>

            <!-- Main Navigation Links -->
            <div class="drawer-section">
                <div class="drawer-section-title">
                    <span><?php esc_html_e('پیوندها و صفحات اصلی', 'rashnubook'); ?></span>
                </div>
                <?php
                if (has_nav_menu('mobile') || has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'theme_location' => has_nav_menu('mobile') ? 'mobile' : 'primary',
                        'container'      => false,
                        'menu_class'     => 'mobile-nav-list',
                    ));
                } else {
                    ?>
                    <ul class="mobile-nav-list">
                        <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('صفحه اصلی', 'rashnubook'); ?></a></li>
                        <?php if (class_exists('WooCommerce')) : ?>
                            <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"><?php esc_html_e('ویترین و کاتالوگ کتاب‌ها', 'rashnubook'); ?></a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo esc_url(home_url('/aftabgardan/')); ?>"><?php esc_html_e('ماهنامه ادبی آفتابگردان (صفحه ویژه)', 'rashnubook'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/blog/')); ?>"><?php esc_html_e('یادداشت‌ها و نقد کتاب', 'rashnubook'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/about-us/')); ?>"><?php esc_html_e('درباره کتابفروشی آنلاین رَشن', 'rashnubook'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/contact-us/')); ?>"><?php esc_html_e('تماس با ما و ساعات کاری', 'rashnubook'); ?></a></li>
                    </ul>
                    <?php
                }
                ?>
            </div>

            <!-- Drawer Bottom Quick Actions -->
            <div class="drawer-footer-actions">
                <?php if (class_exists('WooCommerce')) : ?>
                    <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="drawer-action-btn">
                        <?php rashnubook_icon('user'); ?>
                        <span><?php is_user_logged_in() ? esc_html_e('ورود به حساب کاربری', 'rashnubook') : esc_html_e('ورود / عضویت سریع', 'rashnubook'); ?></span>
                    </a>
                <?php endif; ?>
                <a href="https://instagram.com/<?php echo esc_attr(rashnubook_get_option('instagram', 'rashno_book')); ?>" target="_blank" rel="noopener" class="drawer-action-btn drawer-instagram-btn">
                    <?php rashnubook_icon('instagram'); ?>
                    <span>اینستاگرام: rashno_book@</span>
                </a>
            </div>
        </div>
    </aside>

    <!-- Mini Cart Drawer -->
    <?php if (class_exists('WooCommerce')) : ?>
        <aside id="mini-cart-drawer" class="mini-cart-drawer" aria-label="<?php esc_attr_e('سبد خرید کتاب', 'rashnubook'); ?>">
            <div class="mini-cart-header">
                <div class="mini-cart-header-title">
                    <?php rashnubook_icon('cart'); ?>
                    <span><?php esc_html_e('سبد خرید شما', 'rashnubook'); ?></span>
                </div>
                <button type="button" class="mini-cart-close-btn" data-drawer-close="mini-cart" aria-label="<?php esc_attr_e('بستن سبد خرید', 'rashnubook'); ?>">
                    <?php rashnubook_icon('close'); ?>
                </button>
            </div>
            <div class="mini-cart-items widget_shopping_cart_content">
                <?php woocommerce_mini_cart(); ?>
            </div>
        </aside>
    <?php endif; ?>
