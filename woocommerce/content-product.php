<?php
/**
 * The template for displaying product content within loops
 * Styled specifically for Rashnu Bookstore with tactile book jackets and Persian pricing.
 *
 * @package RashnuBook
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
    return;
}

$product_id = $product->get_id();
$author = get_post_meta($product_id, '_book_author', true);
$publisher = get_post_meta($product_id, '_book_publisher', true);
$edition = get_post_meta($product_id, '_book_edition', true);
$quote = get_post_meta($product_id, '_book_quote', true);

if (empty($author) && method_exists($product, 'get_attribute')) {
    $author = $product->get_attribute('author') ?: $product->get_attribute('نویسنده');
}
if (empty($publisher) && method_exists($product, 'get_attribute')) {
    $publisher = $product->get_attribute('publisher') ?: $product->get_attribute('ناشر');
}

// Get primary category for color coding
$terms = get_the_terms($product_id, 'product_cat');
$cat_slug = !empty($terms) && !is_wp_error($terms) ? $terms[0]->slug : 'fiction';
$cat_name = !empty($terms) && !is_wp_error($terms) ? $terms[0]->name : 'کتاب برگزیده';

// Color themes for jackets based on official palette
$jacket_styles = array(
    'law-books'   => array('bg' => 'linear-gradient(135deg, #1F4D3A 0%, #153628 100%)', 'color' => '#ffffff', 'spine' => '#142c20', 'accent' => '#FFE5B4', 'label' => 'کتب حقوقی و آزمونی'),
    'fiction'     => array('bg' => 'linear-gradient(135deg, #FAF7F2 0%, #EFE7D8 100%)', 'color' => '#3B2F2F', 'spine' => '#cfbe9f', 'accent' => '#A56A4A', 'label' => 'ادبیات داستانی و رمان'),
    'philosophy'  => array('bg' => 'linear-gradient(135deg, #3B2F2F 0%, #261e1e 100%)', 'color' => '#ffffff', 'spine' => '#1d1717', 'accent' => '#DCCCB3', 'label' => 'فلسفه و اندیشه'),
    'poetry'      => array('bg' => 'linear-gradient(135deg, #A56A4A 0%, #854f34 100%)', 'color' => '#ffffff', 'spine' => '#6d3f28', 'accent' => '#FFE5B4', 'label' => 'شعر کهن و معاصر'),
    'psychology'  => array('bg' => 'linear-gradient(135deg, #7C8B6A 0%, #5d6b4d 100%)', 'color' => '#ffffff', 'spine' => '#4c573f', 'accent' => '#ffffff', 'label' => 'روان‌شناسی و خودکاوی'),
);

$current_style = isset($jacket_styles[$cat_slug]) ? $jacket_styles[$cat_slug] : $jacket_styles['fiction'];

// Calculate discount percentage
$discount_pct = 0;
if ($product->is_on_sale() && $product->get_regular_price() && $product->get_sale_price()) {
    $discount_pct = round((($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100);
}
?>

<li <?php wc_product_class('product rb-product-card', $product); ?>>
    <!-- Book Jacket / Cover Container -->
    <div class="rb-card-cover-wrap">
        <?php if ($product->is_on_sale()) : ?>
            <span class="rb-card-discount-badge">
                <?php echo esc_html(rashnubook_to_persian_numbers($discount_pct ? $discount_pct : 15)); ?>٪ تخفیف
            </span>
        <?php endif; ?>

        <a href="<?php the_permalink(); ?>" class="rb-card-cover-link">
            <?php 
            $card_cover_id = function_exists('rashnubook_get_product_cover_image_id') ? rashnubook_get_product_cover_image_id($product) : $product->get_image_id();
            if ($card_cover_id) : ?>
                <?php echo wp_get_attachment_image($card_cover_id, 'medium', false, array('class' => 'rb-card-cover-img', 'loading' => 'lazy')); ?>
            <?php elseif (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium', array('class' => 'rb-card-cover-img', 'loading' => 'lazy')); ?>
            <?php else : ?>
                <!-- Stylized Editorial Book Jacket -->
                <div class="rb-tactile-jacket" style="background: <?php echo esc_attr($current_style['bg']); ?>; color: <?php echo esc_attr($current_style['color']); ?>;">
                    <span class="rb-jacket-spine" style="background: <?php echo esc_attr($current_style['spine']); ?>;"></span>
                    <div class="rb-jacket-header">
                        <span class="rb-jacket-category" style="color: <?php echo esc_attr($current_style['accent']); ?>;">
                            <?php echo esc_html($current_style['label']); ?>
                        </span>
                        <span class="rb-jacket-edition"><?php echo esc_html($edition ? wp_trim_words($edition, 2, '') : 'چاپ اختصاصی'); ?></span>
                    </div>

                    <div class="rb-jacket-body">
                        <h4 class="rb-jacket-title"><?php the_title(); ?></h4>
                        <?php if (!empty($author)) : ?>
                            <div class="rb-jacket-author" style="color: <?php echo esc_attr($current_style['accent']); ?>;">
                                <?php echo esc_html($author); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="rb-jacket-footer">
                        <span><?php echo esc_html($publisher ? $publisher : 'کتابفروشی آنلاین رَشن'); ?></span>
                        <span class="dashicons dashicons-book-alt" style="font-size:14px; opacity:0.8;"></span>
                    </div>
                </div>
            <?php endif; ?>
        </a>
    </div>

    <!-- Book Details -->
    <div class="rb-card-details">
        <div class="rb-card-meta">
            <?php echo esc_html($author ? $author : ($publisher ? 'نشر: ' . $publisher : '')); ?>
        </div>

        <h3 class="rb-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <!-- Price -->
        <div class="rb-card-price-row">
            <div class="rb-card-price">
                <?php echo wp_kses_post($product->get_price_html()); ?>
            </div>
        </div>

        <!-- Buy Button -->
        <div class="rb-card-actions">
            <?php
            $is_purchasable_simple = $product->is_purchasable() && $product->is_in_stock() && $product->is_type('simple');
            $buy_url               = $is_purchasable_simple ? esc_url($product->add_to_cart_url()) : esc_url(get_permalink());
            $buy_classes           = 'rb-btn-buy';
            if ($is_purchasable_simple) {
                $buy_classes .= ' add_to_cart_button ajax_add_to_cart product_type_simple';
            }
            ?>
            <a href="<?php echo $buy_url; ?>" 
               class="<?php echo esc_attr($buy_classes); ?>"
               data-product_id="<?php echo esc_attr($product->get_id()); ?>"
               data-product_sku="<?php echo esc_attr($product->get_sku()); ?>"
               aria-label="<?php echo esc_attr($product->add_to_cart_description()); ?>"
               rel="nofollow">
                <?php rashnubook_icon('cart'); ?>
                <span><?php echo esc_html($product->add_to_cart_text()); ?></span>
            </a>
        </div>
    </div>
</li>
