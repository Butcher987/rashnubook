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
                    <span><?php echo esc_html(rashnubook_get_option('topbar_text', 'ارسال سریع پستی کتاب به سراسر کشور | اینستاگرام: rashno_book@')); ?></span>
                </div>
                <div class="topbar-info" style="display: flex; align-items: center; gap: 16px;">
                    <?php
                    $top_insta_url = rashnubook_get_option('social_instagram', '');
                    if (empty($top_insta_url)) {
                        $top_insta_url = 'https://instagram.com/' . rashnubook_get_option('instagram', 'rashno_book');
                    }
                    $top_insta_user = rashnubook_get_option('instagram', 'rashno_book');
                    ?>
                    <a href="<?php echo esc_url($top_insta_url); ?>" target="_blank" rel="noopener" style="color: rgba(255,255,255,0.92); display: flex; align-items: center; gap: 6px; font-weight: 700; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#ffffff';" onmouseout="this.style.color='rgba(255,255,255,0.92)';">
                        <?php rashnubook_icon('instagram'); ?>
                        <span>اینستاگرام:</span>
                        <span dir="ltr">@<?php echo esc_html($top_insta_user); ?></span>
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
            </div>
        </div>

        <!-- Navigation Bar -->
        <div class="nav-bar">
            <div class="container">
                <div class="nav-bar-inner">
                    <!-- Category Dropdown Button (Editable via WordPress Menus -> Category Menu) -->
                    <div class="nav-category-dropdown" id="nav-cat-dropdown">
                        <button type="button" class="nav-category-btn" id="nav-cat-btn" aria-expanded="false" aria-haspopup="true">
                            <span class="nav-cat-icon"><?php rashnubook_icon('menu'); ?></span>
                            <span class="nav-cat-label"><?php esc_html_e('دسته‌بندی‌های کتاب', 'rashnubook'); ?></span>
                            <svg class="nav-cat-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div class="nav-category-menu" id="nav-cat-menu">
                            <?php rashnubook_render_header_category_dropdown(); ?>
                        </div>
                    </div>

                    <!-- Main Navigation Links (Primary Menu with Sub-menu Dropdowns) -->
                    <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e('منوی اصلی', 'rashnubook'); ?>">
                        <?php
                        if (has_nav_menu('primary')) {
                            wp_nav_menu(array(
                                'theme_location' => 'primary',
                                'container'      => false,
                                'menu_class'     => 'main-nav-list',
                                'fallback_cb'    => false,
                            ));
                        } else {
                            // Default Fallback Menu
                            ?>
                            <ul class="main-nav-list">
                                <li><a href="<?php echo esc_url(home_url('/')); ?>" class="<?php echo is_front_page() ? 'active' : ''; ?>"><?php esc_html_e('خانه', 'rashnubook'); ?></a></li>
                                <?php if (class_exists('WooCommerce')) : ?>
                                    <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="<?php echo (is_shop() || is_product_taxonomy()) ? 'active' : ''; ?>"><?php esc_html_e('کتاب‌ها و دیگر محصولات', 'rashnubook'); ?></a></li>
                                <?php endif; ?>
                                <li><a href="<?php echo esc_url(home_url('/categories/')); ?>" class="<?php echo (is_page('categories') || (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/categories') !== false)) ? 'active' : ''; ?>"><?php esc_html_e('راهنمای موضوعی کتاب‌ها', 'rashnubook'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/aftabgardan/')); ?>" class="<?php echo is_page('aftabgardan') ? 'active' : ''; ?>"><?php esc_html_e('صفحه رویدادهای ویژه', 'rashnubook'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/blog/')); ?>" class="<?php echo (is_home() || (is_archive() && !is_shop() && !is_product_taxonomy()) || is_singular('post')) ? 'active' : ''; ?>"><?php esc_html_e('یادداشت‌ها و نقد کتاب', 'rashnubook'); ?></a></li>
                            </ul>
                            <?php
                        }
                        ?>
                    </nav>
                </div>
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
            <!-- Book Categories Section (Dynamic & Synchronized with WordPress Menus / WooCommerce) -->
            <?php
            $drawer_cats_enable = rashnubook_get_option('drawer_cats_enable', '1') !== '0';
            if ($drawer_cats_enable) :
            ?>
                <div class="drawer-section">
                    <div class="drawer-section-title">
                        <?php rashnubook_icon('book'); ?>
                        <span><?php esc_html_e('دسته‌بندی‌های موضوعی کتاب', 'rashnubook'); ?></span>
                    </div>
                    <?php rashnubook_render_drawer_category_menu(); ?>
                </div>
            <?php endif; ?>

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
                            <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"><?php esc_html_e('کتاب‌ها و دیگر محصولات', 'rashnubook'); ?></a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo esc_url(home_url('/categories/')); ?>"><?php esc_html_e('دسته‌بندی‌های کتاب (فهرست کامل)', 'rashnubook'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/aftabgardan/')); ?>"><?php esc_html_e('صفحه رویدادهای ویژه (آفتابگردان)', 'rashnubook'); ?></a></li>
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
