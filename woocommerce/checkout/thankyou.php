<?php
/**
 * Thankyou page
 *
 * @package RashnuBook
 */

defined('ABSPATH') || exit;
?>

<div class="woocommerce-order">

    <?php
    if ($order) :

        do_action('woocommerce_before_thankyou', $order->get_id());
        ?>

        <?php if ($order->has_status('failed')) : ?>

            <div class="thankyou-box" style="border-color: #ffdad6;">
                <div class="thankyou-icon" style="background-color: #ffdad6; color: var(--error);">
                    &times;
                </div>
                <h2 style="font-size: 22px; color: var(--error); margin-bottom: 12px;">
                    <?php esc_html_e('متأسفانه پرداخت انجام نشد.', 'rashnubook'); ?>
                </h2>
                <p style="font-size: 14px; color: var(--charcoal-muted); margin-bottom: 24px;">
                    <?php esc_html_e('تراکنش شما توسط بانک لغو شد یا مشکلی در پرداخت رخ داد. لطفاً مجدداً تلاش فرمایید.', 'rashnubook'); ?>
                </p>
                <div style="display: flex; justify-content: center; gap: 12px;">
                    <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="btn btn-primary">
                        <?php esc_html_e('تلاش دوباره برای پرداخت', 'rashnubook'); ?>
                    </a>
                </div>
            </div>

        <?php else : ?>

            <div class="thankyou-box">
                <div class="thankyou-icon">
                    <?php rashnubook_icon('check'); ?>
                </div>

                <h1 style="font-size: 24px; color: var(--primary); margin-bottom: 8px;">
                    <?php esc_html_e('سفارش شما با موفقیت ثبت و پرداخت شد', 'rashnubook'); ?>
                </h1>

                <p style="font-size: 14px; color: var(--charcoal-muted);">
                    <?php esc_html_e('از حسن اعتماد و خرید شما از کتابفروشی آنلاین رَشن سپاسگزاریم. بسته کتاب شما با دقت آماده‌سازی و به آدرس ثبت‌شده ارسال خواهد شد.', 'rashnubook'); ?>
                </p>

                <div class="order-meta-grid">
                    <div class="order-meta-item">
                        <span><?php esc_html_e('شماره سفارش:', 'rashnubook'); ?></span>
                        <strong><?php echo esc_html(rashnubook_to_persian_numbers($order->get_order_number())); ?></strong>
                    </div>
                    <div class="order-meta-item">
                        <span><?php esc_html_e('تاریخ ثبت سفارش:', 'rashnubook'); ?></span>
                        <strong><?php echo esc_html(rashnubook_to_persian_numbers(wc_format_datetime($order->get_date_created()))); ?></strong>
                    </div>
                    <div class="order-meta-item">
                        <span><?php esc_html_e('مبلغ پرداخت شده:', 'rashnubook'); ?></span>
                        <strong><?php echo wp_kses_post($order->get_formatted_order_total()); ?></strong>
                    </div>
                    <div class="order-meta-item">
                        <span><?php esc_html_e('شیوه پرداخت:', 'rashnubook'); ?></span>
                        <strong><?php echo wp_kses_post($order->get_payment_method_title()); ?></strong>
                    </div>
                </div>

                <div style="display: flex; justify-content: center; gap: 12px; margin-top: 24px;">
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn-primary">
                        <?php esc_html_e('بازگشت به پیشخوان کتاب‌سرا', 'rashnubook'); ?>
                    </a>
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>" class="btn btn-secondary">
                            <?php esc_html_e('مشاهده سفارش‌ها در پنل', 'rashnubook'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div style="max-width: 760px; margin: 0 auto;">
                <?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
                <?php do_action('woocommerce_thankyou', $order->get_id()); ?>
            </div>

        <?php endif; ?>

    <?php else : ?>

        <div class="thankyou-box">
            <h2><?php esc_html_e('سفارش ثبت شد.', 'rashnubook'); ?></h2>
            <p><?php esc_html_e('از سفارش شما سپاسگزاریم.', 'rashnubook'); ?></p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary"><?php esc_html_e('صفحه اصلی', 'rashnubook'); ?></a>
        </div>

    <?php endif; ?>

</div>
