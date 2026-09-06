<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * @package RashnuBook
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}

$product_id = $product->get_id();
$attrs      = function_exists('rashnubook_get_book_attributes') ? rashnubook_get_book_attributes($product_id) : array();
$author     = $attrs['author'] ?? get_post_meta($product_id, '_book_author', true);
$translator = $attrs['translator'] ?? get_post_meta($product_id, '_book_translator', true);
$publisher  = $attrs['publisher'] ?? get_post_meta($product_id, '_book_publisher', true);
$isbn       = $attrs['isbn'] ?? get_post_meta($product_id, '_book_isbn', true);
$pages      = $attrs['pages'] ?? get_post_meta($product_id, '_book_pages', true);
$format     = $attrs['format'] ?? get_post_meta($product_id, '_book_format', true);
$cover      = $attrs['cover'] ?? get_post_meta($product_id, '_book_cover', true);
$edition    = $attrs['edition'] ?? get_post_meta($product_id, '_book_edition', true);
$quote      = $attrs['excerpt'] ?? get_post_meta($product_id, '_book_quote', true);
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('book-single-container', $product); ?>>
    <div class="book-single-grid">
        <!-- Col 1: Visual Book Artifact & 3D Cover Illusion -->
        <div class="book-single-gallery">
            <div class="book-single-cover">
                <?php if ($product->is_on_sale()) : ?>
                    <span class="book-badge-discount" style="font-size: 13px; padding: 4px 12px;">
                        <?php esc_html_e('تخفیف ویژه نشر', 'rashnubook'); ?>
                    </span>
                <?php endif; ?>

                <?php
                $cover_image_id = function_exists('rashnubook_get_product_cover_image_id') ? rashnubook_get_product_cover_image_id($product) : $product->get_image_id();
                if ($cover_image_id) {
                    echo wp_get_attachment_image($cover_image_id, 'rashnubook-book-single', false, array(
                        'id' => 'rashnu-main-product-image',
                        'class' => 'book-single-main-img'
                    ));
                } elseif (has_post_thumbnail()) {
                    the_post_thumbnail('rashnubook-book-single', array('id' => 'rashnu-main-product-image'));
                } else {
                    echo wc_placeholder_img('rashnubook-book-single');
                }
                ?>
            </div>

            <!-- Product Gallery Thumbnails -->
            <?php
            $gallery_ids = $product->get_gallery_image_ids();
            if (!empty($gallery_ids) && count($gallery_ids) > 0) :
                $all_gallery = array_unique(array_filter(array_merge($cover_image_id ? array($cover_image_id) : array(), $gallery_ids)));
                if (count($all_gallery) > 1) :
            ?>
                <div class="book-gallery-thumbnails" style="display: flex; gap: 8px; margin-top: 12px; overflow-x: auto; padding-bottom: 6px;">
                    <?php foreach ($all_gallery as $g_id) :
                        $large_url = wp_get_attachment_image_url($g_id, 'rashnubook-book-single') ?: wp_get_attachment_url($g_id);
                    ?>
                        <button type="button" class="book-thumb-btn" style="border: 2px solid var(--border-editorial); border-radius: 6px; overflow: hidden; padding: 0; background: #fff; cursor: pointer; flex-shrink: 0; width: 64px; height: 86px; transition: border-color 0.2s;" onclick="var m=document.getElementById('rashnu-main-product-image'); if(m) m.src='<?php echo esc_url($large_url); ?>'; this.parentElement.querySelectorAll('.book-thumb-btn').forEach(function(b){b.style.borderColor='var(--border-editorial)'}); this.style.borderColor='var(--primary)';">
                            <?php echo wp_get_attachment_image($g_id, 'thumbnail', false, array('style' => 'width: 100%; height: 100%; object-fit: cover; display: block;')); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; endif; ?>

            <!-- Features Quick Box below image -->
            <div style="margin-top: 20px; background: var(--card-sand); padding: 16px; border-radius: var(--radius-sm); border: 1px solid var(--border-editorial); display: flex; flex-direction: column; gap: 10px; font-size: 13px;">
                <div style="display: flex; align-items: center; gap: 8px; color: var(--primary);">
                    <?php rashnubook_icon('check'); ?>
                    <span>ضمانت سلامت فیزیکی و چاپ اصل</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px; color: var(--primary);">
                    <?php rashnubook_icon('shipping'); ?>
                    <span>ارسال فوری با پست پیشتاز اختصاصی</span>
                </div>
            </div>
        </div>

        <!-- Col 2: Book Details, Meta, Specs & Buy Box -->
        <div class="book-single-info">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px; flex-wrap: wrap;">
                <?php if (!empty($publisher)) : ?>
                    <span style="font-size: 12px; background: var(--card-sand); color: var(--primary); padding: 2px 8px; border-radius: var(--radius-sm); font-weight: 600;">
                        نشر: <?php echo esc_html($publisher); ?>
                    </span>
                <?php endif; ?>
                <?php if (!empty($format)) : ?>
                    <span style="font-size: 12px; background: rgba(31,77,58,0.08); color: var(--primary); padding: 2px 8px; border-radius: var(--radius-sm); font-weight: 600;">
                        قطع <?php echo esc_html($format); ?>
                    </span>
                <?php endif; ?>
                <?php if (!empty($cover)) : ?>
                    <span style="font-size: 12px; background: rgba(165,106,74,0.1); color: var(--tertiary); padding: 2px 8px; border-radius: var(--radius-sm); font-weight: 600;">
                        <?php echo esc_html($cover); ?>
                    </span>
                <?php endif; ?>
                <?php if (!empty($edition)) : ?>
                    <span style="font-size: 12px; color: var(--secondary); font-weight: 600;">
                        <?php echo esc_html($edition); ?>
                    </span>
                <?php endif; ?>
            </div>

            <h1 class="font-editorial-title"><?php the_title(); ?></h1>

            <div class="book-meta-inline">
                <?php if (!empty($author)) : ?>
                    <span>پدیدآور: <strong><?php echo esc_html($author); ?></strong></span>
                <?php endif; ?>

                <?php if (!empty($translator)) : ?>
                    <span style="opacity: 0.4;">|</span>
                    <span>مترجم: <strong><?php echo esc_html($translator); ?></strong></span>
                <?php endif; ?>
            </div>

            <!-- Price & Add To Cart Box -->
            <div class="purchase-box">
                <div class="purchase-price-row">
                    <span style="font-size: 14px; color: var(--charcoal-muted);">قیمت نسخه چاپی:</span>
                    <div style="font-size: 22px; font-weight: 800; color: var(--primary);">
                        <?php echo wp_kses_post($product->get_price_html()); ?>
                    </div>
                </div>

                <div>
                    <?php
                    // Display native WooCommerce Add to Cart Form
                    woocommerce_template_single_add_to_cart();
                    ?>
                </div>
            </div>

            <!-- Editorial Excerpt Quote if available -->
            <?php if (!empty($quote)) : ?>
                <div class="editorial-quote-box">
                    <p class="editorial-quote-text">«<?php echo esc_html($quote); ?>»</p>
                    <span class="editorial-quote-author">گزیده‌ای از متن کتاب</span>
                </div>
            <?php endif; ?>

            <!-- Book Specifications Table -->
            <div style="margin-top: 32px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <h3 style="font-size: 18px; color: var(--primary); margin: 0;">شناسنامه و مشخصات کتاب</h3>
                    <?php if (current_user_can('edit_post', $product_id)) : ?>
                        <a href="<?php echo esc_url(get_edit_post_link($product_id)); ?>" target="_blank" style="font-size: 12px; color: var(--secondary); text-decoration: none; display: inline-flex; align-items: center; gap: 4px; font-weight: 600;">
                            <span>ویرایش مشخصات (قطع، جلد...)</span>
                            <span style="font-size: 13px;">✏️</span>
                        </a>
                    <?php endif; ?>
                </div>
                <table class="book-specs-table">
                    <tbody>
                        <?php if (!empty($author)) : ?>
                            <tr><td>نویسنده / پدیدآور</td><td><?php echo esc_html($author); ?></td></tr>
                        <?php endif; ?>
                        <?php if (!empty($translator)) : ?>
                            <tr><td>مترجم</td><td><?php echo esc_html($translator); ?></td></tr>
                        <?php endif; ?>
                        <?php if (!empty($publisher)) : ?>
                            <tr><td>ناشر</td><td><?php echo esc_html($publisher); ?></td></tr>
                        <?php endif; ?>
                        <?php if (!empty($isbn)) : ?>
                            <tr><td>شابک (ISBN)</td><td><?php echo esc_html(rashnubook_to_persian_numbers($isbn)); ?></td></tr>
                        <?php endif; ?>
                        <?php if (!empty($pages)) : ?>
                            <tr><td>تعداد صفحه</td><td><?php echo esc_html(rashnubook_to_persian_numbers($pages)); ?> صفحه</td></tr>
                        <?php endif; ?>
                        <?php if (!empty($format)) : ?>
                            <tr><td>قطع کتاب</td><td><?php echo esc_html($format); ?></td></tr>
                        <?php endif; ?>
                        <?php if (!empty($cover)) : ?>
                            <tr><td>نوع جلد</td><td><?php echo esc_html($cover); ?></td></tr>
                        <?php endif; ?>
                        <?php if (!empty($edition)) : ?>
                            <tr><td>نوبت چاپ</td><td><?php echo esc_html($edition); ?></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Description / Overview -->
            <div style="margin-top: 32px;">
                <h3 style="font-size: 18px; color: var(--primary); margin-bottom: 12px;">معرفی و خلاصه کتاب</h3>
                <div style="font-size: 15px; line-height: 1.95; color: var(--charcoal-ink);">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div style="margin-top: 64px; border-top: 2px solid var(--border-subtle); padding-top: 40px;">
        <?php
        woocommerce_related_products(array(
            'posts_per_page' => 4,
            'columns'        => 4,
        ));
        ?>
    </div>
</div>

<?php do_action('woocommerce_after_single_product'); ?>
