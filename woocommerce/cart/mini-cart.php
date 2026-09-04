<?php
/**
 * Mini-cart template for Rashnu Bookstore
 * Displays complete book identification (cover, title, author/translator, quantity, price, remove action).
 *
 * @package RashnuBook
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_mini_cart'); ?>

<div class="rb-mini-cart-wrapper">
    <?php if (!WC()->cart->is_empty()) : ?>

        <div class="rb-mini-cart-scroll-area">
            <ul class="woocommerce-mini-cart cart_list product_list_widget">
                <?php
                do_action('woocommerce_before_mini_cart_contents');

                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                    $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
                        $product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                        $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('thumbnail'), $cart_item, $cart_item_key);
                        $product_price     = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);

                        // Book custom fields
                        $author     = get_post_meta($product_id, '_book_author', true);
                        $translator = get_post_meta($product_id, '_book_translator', true);
                        $publisher  = get_post_meta($product_id, '_book_publisher', true);
                        ?>
                        <li class="woocommerce-mini-cart-item rb-mini-cart-item">
                            <!-- Book Cover Thumbnail -->
                            <div class="rb-mini-cart-thumb">
                                <?php if (!empty($product_permalink)) : ?>
                                    <a href="<?php echo esc_url($product_permalink); ?>">
                                        <?php echo $thumbnail; // PHPCS: XSS ok. ?>
                                    </a>
                                <?php else : ?>
                                    <?php echo $thumbnail; // PHPCS: XSS ok. ?>
                                <?php endif; ?>
                            </div>

                            <!-- Book Details & Meta -->
                            <div class="rb-mini-cart-info">
                                <h4 class="rb-mini-cart-title">
                                    <?php if (!empty($product_permalink)) : ?>
                                        <a href="<?php echo esc_url($product_permalink); ?>">
                                            <?php echo wp_kses_post($product_name); ?>
                                        </a>
                                    <?php else : ?>
                                        <?php echo wp_kses_post($product_name); ?>
                                    <?php endif; ?>
                                </h4>

                                <?php if (!empty($author)) : ?>
                                    <div class="rb-mini-cart-author">
                                        <span>نویسنده:</span>
                                        <strong><?php echo esc_html($author); ?></strong>
                                    </div>
                                <?php elseif (!empty($translator)) : ?>
                                    <div class="rb-mini-cart-author">
                                        <span>مترجم:</span>
                                        <strong><?php echo esc_html($translator); ?></strong>
                                    </div>
                                <?php elseif (!empty($publisher)) : ?>
                                    <div class="rb-mini-cart-author">
                                        <span>نشر:</span>
                                        <span><?php echo esc_html($publisher); ?></span>
                                    </div>
                                <?php endif; ?>

                                <!-- Variations / Attributes if any -->
                                <?php echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok. ?>

                                <!-- Price & Quantity -->
                                <div class="rb-mini-cart-pricing">
                                    <span class="rb-mini-cart-qty">تعداد: <strong><?php echo esc_html(rashnubook_to_persian_numbers($cart_item['quantity'])); ?></strong></span>
                                    <span class="rb-mini-cart-times">&times;</span>
                                    <span class="rb-mini-cart-price"><?php echo $product_price; // PHPCS: XSS ok. ?></span>
                                </div>
                            </div>

                            <!-- Remove Action -->
                            <div class="rb-mini-cart-remove">
                                <?php
                                echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                    'woocommerce_cart_item_remove_link',
                                    sprintf(
                                        '<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s" title="%s">&times;</a>',
                                        esc_url(wc_get_cart_remove_url($cart_item_key)),
                                        esc_attr__('حذف این کتاب از سبد خرید', 'rashnubook'),
                                        esc_attr($product_id),
                                        esc_attr($cart_item_key),
                                        esc_attr($_product->get_sku()),
                                        esc_attr__('حذف این کتاب', 'rashnubook')
                                    ),
                                    $cart_item_key
                                );
                                ?>
                            </div>
                        </li>
                        <?php
                    }
                }

                do_action('woocommerce_mini_cart_contents');
                ?>
            </ul>
        </div>

        <!-- Sticky Drawer Footer -->
        <div class="mini-cart-footer rb-mini-cart-footer">
            <div class="rb-mini-cart-subtotal-row">
                <span class="rb-mini-cart-subtotal-label"><?php esc_html_e('جمع کل خرید:', 'rashnubook'); ?></span>
                <span class="rb-mini-cart-subtotal-val"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
            </div>

            <div class="rb-mini-cart-actions">
                <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="btn-checkout-direct">
                    <?php rashnubook_icon('check'); ?>
                    <span><?php esc_html_e('تسویه‌حساب و ثبت نهایی سفارش', 'rashnubook'); ?></span>
                </a>
                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="btn-view-cart-full">
                    <span><?php esc_html_e('مشاهده و ویرایش سبد خرید', 'rashnubook'); ?></span>
                </a>
            </div>
        </div>

    <?php else : ?>

        <div class="rb-mini-cart-empty">
            <div class="rb-empty-cart-icon">
                <?php rashnubook_icon('cart'); ?>
            </div>
            <h4 class="rb-empty-cart-title"><?php esc_html_e('سبد خرید شما در حال حاضر خالی است', 'rashnubook'); ?></h4>
            <p class="rb-empty-cart-text"><?php esc_html_e('می‌توانید با بررسی کتاب‌ها و ویترین آثار ادبی، کتاب‌های مورد علاقه خود را انتخاب فرمایید.', 'rashnubook'); ?></p>
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn-shop-browse">
                <?php rashnubook_icon('book'); ?>
                <span><?php esc_html_e('مشاهده ویترین و کاتالوگ کتاب‌ها', 'rashnubook'); ?></span>
            </a>
        </div>

    <?php endif; ?>
</div>

<?php do_action('woocommerce_after_mini_cart'); ?>
