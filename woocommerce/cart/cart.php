<?php
/**
 * Cart Page
 *
 * @package RashnuBook
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>

<!-- Stepper Header -->
<div style="background: var(--card-sand); border: 1px solid var(--border-editorial); border-radius: var(--radius-md); padding: 16px 24px; margin-bottom: 32px;">
    <div style="display: flex; align-items: center; justify-content: center; gap: 24px; font-size: 14px; font-weight: 700;">
        <span style="color: var(--primary); display: flex; align-items: center; gap: 6px;">
            <span style="width: 24px; height: 24px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">۱</span>
            <span>سبد خرید</span>
        </span>
        <span style="color: var(--outline-variant);">&larr;</span>
        <span style="color: var(--charcoal-muted); display: flex; align-items: center; gap: 6px;">
            <span style="width: 24px; height: 24px; background: var(--card-sand-alt); color: var(--charcoal-muted); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">۲</span>
            <span>مشخصات تحویل و نشانی</span>
        </span>
        <span style="color: var(--outline-variant);">&larr;</span>
        <span style="color: var(--charcoal-muted); display: flex; align-items: center; gap: 6px;">
            <span style="width: 24px; height: 24px; background: var(--card-sand-alt); color: var(--charcoal-muted); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">۳</span>
            <span>درگاه و پرداخت امن</span>
        </span>
    </div>
</div>

<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
    <?php do_action('woocommerce_before_cart_table'); ?>

    <table class="cart-table shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
        <thead>
            <tr>
                <th class="product-remove"><span class="screen-reader-text"><?php esc_html_e('حذف مورد', 'rashnubook'); ?></span></th>
                <th class="product-thumbnail"><span class="screen-reader-text"><?php esc_html_e('تصویر کتاب', 'rashnubook'); ?></span></th>
                <th class="product-name"><?php esc_html_e('عنوان کتاب', 'rashnubook'); ?></th>
                <th class="product-price"><?php esc_html_e('قیمت واحد', 'rashnubook'); ?></th>
                <th class="product-quantity"><?php esc_html_e('تعداد', 'rashnubook'); ?></th>
                <th class="product-subtotal"><?php esc_html_e('جمع کل', 'rashnubook'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php do_action('woocommerce_before_cart_contents'); ?>

            <?php
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                    ?>
                    <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

                        <td class="product-remove">
                            <?php
                                echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                    'woocommerce_cart_item_remove_link',
                                    sprintf(
                                        '<a href="%s" class="cart-remove-btn remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                        esc_url(wc_get_cart_remove_url($cart_item_key)),
                                        esc_html__('حذف این مورد', 'rashnubook'),
                                        esc_attr($product_id),
                                        esc_attr($_product->get_sku())
                                    ),
                                    $cart_item_key
                                );
                            ?>
                        </td>

                        <td class="product-thumbnail cart-item-thumbnail">
                        <?php
                        $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                        if (!$product_permalink) {
                            echo $thumbnail; // PHPCS: XSS ok.
                        } else {
                            printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
                        }
                        ?>
                        </td>

                        <td class="product-name cart-item-title" data-title="<?php esc_attr_e('کتاب', 'rashnubook'); ?>">
                        <?php
                        if (!$product_permalink) {
                            echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                        } else {
                            echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                        }

                        do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                        // Meta data.
                        echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.
                        ?>
                        </td>

                        <td class="product-price" data-title="<?php esc_attr_e('قیمت', 'rashnubook'); ?>">
                            <?php
                                echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                            ?>
                        </td>

                        <td class="product-quantity" data-title="<?php esc_attr_e('تعداد', 'rashnubook'); ?>">
                        <?php
                        if ($_product->is_sold_individually()) {
                            $min_quantity = 1;
                            $max_quantity = 1;
                        } else {
                            $min_quantity = 0;
                            $max_quantity = $_product->get_max_purchase_quantity();
                        }

                        $product_quantity = woocommerce_quantity_input(
                            array(
                                'input_name'   => "cart[{$cart_item_key}][qty]",
                                'input_value'  => $cart_item['quantity'],
                                'max_value'    => $max_quantity,
                                'min_value'    => $min_quantity,
                                'product_name' => $_product->get_name(),
                            ),
                            $_product,
                            false
                        );

                        echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
                        ?>
                        </td>

                        <td class="product-subtotal" data-title="<?php esc_attr_e('جمع کل', 'rashnubook'); ?>">
                            <?php
                                echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                            ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>

            <?php do_action('woocommerce_cart_contents'); ?>

            <tr>
                <td colspan="6" class="actions" style="padding: 0;">
                    <div class="cart-actions-row">
                        <?php if (wc_coupons_enabled()) { ?>
                            <div class="coupon coupon-box">
                                <label for="coupon_code" class="screen-reader-text"><?php esc_html_e('کد تخفیف:', 'rashnubook'); ?></label>
                                <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e('کد تخفیف کتاب...', 'rashnubook'); ?>" />
                                <button type="submit" class="btn btn-secondary" name="apply_coupon" value="<?php esc_attr_e('اعمال کد', 'rashnubook'); ?>"><?php esc_html_e('اعمال کد', 'rashnubook'); ?></button>
                                <?php do_action('woocommerce_cart_coupon'); ?>
                            </div>
                        <?php } ?>

                        <button type="submit" class="btn btn-secondary" name="update_cart" value="<?php esc_attr_e('به‌روزرسانی سبد خرید', 'rashnubook'); ?>"><?php esc_html_e('به‌روزرسانی سبد', 'rashnubook'); ?></button>

                        <?php do_action('woocommerce_cart_actions'); ?>

                        <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                    </div>
                </td>
            </tr>

            <?php do_action('woocommerce_after_cart_contents'); ?>
        </tbody>
    </table>
    <?php do_action('woocommerce_after_cart_table'); ?>
</form>

<?php do_action('woocommerce_before_cart_collaterals'); ?>

<div class="cart-collaterals-grid">
    <div>
        <div style="background: var(--card-sand); border: 1px solid var(--border-editorial); border-radius: var(--radius-md); padding: 20px;">
            <h4 style="color: var(--primary); margin-bottom: 10px;">ارسال مطمئن و ضدضربه کتاب‌ها</h4>
            <p style="font-size: 13.5px; color: var(--charcoal-muted); line-height: 1.8;">
                تمامی کتاب‌های خریداری شده از رشنو بوک با محافظ حباب‌دار بسته‌بندی شده و به همراه نشانک کتاب ویژه به دست شما می‌رسد.
            </p>
        </div>
    </div>
    <div class="cart-collaterals">
        <?php
            /**
             * Cart collaterals hook.
             * @hooked woocommerce_cart_totals - 10
             */
            woocommerce_cart_totals();
        ?>
    </div>
</div>

<?php do_action('woocommerce_after_cart'); ?>
