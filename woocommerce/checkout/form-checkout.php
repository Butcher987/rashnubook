<?php
/**
 * Checkout Form
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('برای تکمیل خرید، لطفاً وارد حساب کاربری خود شوید.', 'rashnubook')));
    return;
}
?>

<!-- Stepper Header -->
<div style="background: var(--card-sand); border: 1px solid var(--border-editorial); border-radius: var(--radius-md); padding: 16px 24px; margin-bottom: 32px;">
    <div style="display: flex; align-items: center; justify-content: center; gap: 24px; font-size: 14px; font-weight: 700;">
        <span style="color: var(--secondary); display: flex; align-items: center; gap: 6px;">
            <span style="width: 24px; height: 24px; background: var(--secondary-container); color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">✓</span>
            <span>سبد خرید</span>
        </span>
        <span style="color: var(--outline-variant);">&larr;</span>
        <span style="color: var(--primary); display: flex; align-items: center; gap: 6px;">
            <span style="width: 24px; height: 24px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">۲</span>
            <span>مشخصات تحویل و نشانی</span>
        </span>
        <span style="color: var(--outline-variant);">&larr;</span>
        <span style="color: var(--charcoal-muted); display: flex; align-items: center; gap: 6px;">
            <span style="width: 24px; height: 24px; background: var(--card-sand-alt); color: var(--charcoal-muted); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">۳</span>
            <span>درگاه و پرداخت امن</span>
        </span>
    </div>
</div>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

    <div class="checkout-grid">
        <!-- Customer Details & Shipping Address -->
        <div class="checkout-details-column">
            <?php if ($checkout->get_checkout_fields()) : ?>

                <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                <div class="checkout-section-box" id="customer_details">
                    <h3 class="checkout-section-title">
                        <?php rashnubook_icon('user'); ?>
                        <span><?php esc_html_e('مشخصات تحویل‌گیرنده و نشانی پستی', 'rashnubook'); ?></span>
                    </h3>

                    <?php do_action('woocommerce_checkout_billing'); ?>

                    <?php do_action('woocommerce_checkout_shipping'); ?>
                </div>

                <?php do_action('woocommerce_checkout_after_customer_details'); ?>

            <?php endif; ?>
        </div>

        <!-- Order Review & Payment Section -->
        <div class="checkout-review-column">
            <div class="checkout-section-box">
                <h3 id="order_review_heading" class="checkout-section-title">
                    <?php rashnubook_icon('book'); ?>
                    <span><?php esc_html_e('خلاصه سفارش و درگاه پرداخت', 'rashnubook'); ?></span>
                </h3>

                <?php do_action('woocommerce_checkout_before_order_review'); ?>

                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action('woocommerce_checkout_order_review'); ?>
                </div>

                <?php do_action('woocommerce_checkout_after_order_review'); ?>
            </div>

            <div style="background: var(--card-sand); border: 1px solid var(--border-editorial); border-radius: var(--radius-sm); padding: 14px; font-size: 12.5px; color: var(--charcoal-muted); line-height: 1.7;">
                <strong><?php esc_html_e('خرید امن کتاب:', 'rashnubook'); ?></strong> اطلاعات پستی شما صرفاً برای ارسال مرسوله استفاده شده و تراکنش از طریق شبکه شاپرک و درگاه رمزگذاری‌شده بانکی انجام می‌پذیرد.
            </div>
        </div>
    </div>

</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
