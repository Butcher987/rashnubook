<?php
/**
 * My Account dashboard
 * Bento / Tento inspired layout with quick-action cards for rashnubook.ir
 *
 * @package RashnuBook
 */

defined('ABSPATH') || exit;

$current_user = wp_get_current_user();
?>

<div class="rb-dashboard-wrap">
    <div class="rb-dashboard-welcome">
        <div class="rb-welcome-title-row">
            <h2>سلام <?php echo esc_html($current_user->display_name); ?> عزیز، خوش آمدید!</h2>
            <a href="<?php echo esc_url(wc_logout_url()); ?>" class="rb-welcome-logout">
                خروج از حساب کاربری
            </a>
        </div>
        <p class="rb-welcome-desc">
            از طریق پیشخوان حساب کاربری خود می‌توانید وضعیت سفارش‌های اخیر را بررسی و رهگیری کنید، آدرس‌های پستی جهت ارسال بسته‌های کتاب را مدیریت نمایید و مشخصات فردی و رمز عبور خود را ویرایش کنید.
        </p>
    </div>

    <!-- Quick Action Cards (Tento Style Grid) -->
    <div class="rb-dashboard-grid">
        <a href="<?php echo esc_url(wc_get_endpoint_url('orders')); ?>" class="rb-dash-card">
            <div class="rb-dash-card-icon" style="color:var(--primary); background:rgba(31,77,58,0.12);">
                <span class="dashicons dashicons-cart"></span>
            </div>
            <strong class="rb-dash-card-title">سفارش‌های من</strong>
            <span class="rb-dash-card-sub">پیگیری خریدهای ثبت‌شده و فاکتورها</span>
        </a>

        <a href="<?php echo esc_url(wc_get_endpoint_url('edit-address')); ?>" class="rb-dash-card">
            <div class="rb-dash-card-icon" style="color:var(--terracotta); background:rgba(165,106,74,0.12);">
                <span class="dashicons dashicons-location-alt"></span>
            </div>
            <strong class="rb-dash-card-title">آدرس‌های تحویل</strong>
            <span class="rb-dash-card-sub">مدیریت آدرس پستی جهت ارسال سفارش‌ها</span>
        </a>

        <a href="<?php echo esc_url(wc_get_endpoint_url('edit-account')); ?>" class="rb-dash-card">
            <div class="rb-dash-card-icon" style="color:var(--secondary); background:rgba(124,139,106,0.15);">
                <span class="dashicons dashicons-admin-users"></span>
            </div>
            <strong class="rb-dash-card-title">اطلاعات حساب</strong>
            <span class="rb-dash-card-sub">ویرایش نام، ایمیل و تغییر رمز عبور</span>
        </a>

        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="rb-dash-card">
            <div class="rb-dash-card-icon" style="color:var(--mocha); background:rgba(59,47,47,0.1);">
                <span class="dashicons dashicons-book-alt"></span>
            </div>
            <strong class="rb-dash-card-title">ویترین کتاب‌ها</strong>
            <span class="rb-dash-card-sub">مشاهده کاتالوگ و خرید کتاب جدید</span>
        </a>
    </div>

    <?php
    /**
     * My Account dashboard.
     * @since 2.6.0
     */
    do_action('woocommerce_account_dashboard');
    ?>
</div>
