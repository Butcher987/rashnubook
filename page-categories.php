<?php
/**
 * Template Name: دسته‌بندی‌های موضوعی کتاب
 * The template for displaying hierarchical product categories inspired by IranKetab.
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Fetch all top-level product categories
$parent_cats = get_terms(array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => false,
    'parent'     => 0,
    'exclude'    => array(get_option('default_product_cat', 0)),
));

// Helper for category contextual icon/emoji
function rashnubook_get_cat_icon($name) {
    if (mb_stripos($name, 'حقوق') !== false || mb_stripos($name, 'قانون') !== false || mb_stripos($name, 'قضا') !== false) {
        return '⚖️';
    } elseif (mb_stripos($name, 'فلسف') !== false || mb_stripos($name, 'اندیش') !== false) {
        return '🏛️';
    } elseif (mb_stripos($name, 'ادبی') !== false || mb_stripos($name, 'شعر') !== false || mb_stripos($name, 'داستان') !== false || mb_stripos($name, 'رمان') !== false) {
        return '✒️';
    } elseif (mb_stripos($name, 'تاری') !== false || mb_stripos($name, 'تمدن') !== false) {
        return '📜';
    } elseif (mb_stripos($name, 'روان') !== false || mb_stripos($name, 'موفقیت') !== false) {
        return '🧠';
    } elseif (mb_stripos($name, 'هنر') !== false || mb_stripos($name, 'سینما') !== false || mb_stripos($name, 'تئاتر') !== false) {
        return '🎨';
    } elseif (mb_stripos($name, 'کودک') !== false || mb_stripos($name, 'نوجوان') !== false) {
        return '🧸';
    } elseif (mb_stripos($name, 'سیاس') !== false || mb_stripos($name, 'جامعه') !== false) {
        return '🌐';
    } elseif (mb_stripos($name, 'اقتصاد') !== false || mb_stripos($name, 'مدیریت') !== false || mb_stripos($name, 'مالی') !== false) {
        return '📈';
    } elseif (mb_stripos($name, 'دین') !== false || mb_stripos($name, 'عرفان') !== false || mb_stripos($name, 'مذهب') !== false) {
        return '🕯️';
    } elseif (mb_stripos($name, 'علم') !== false || mb_stripos($name, 'پزشک') !== false || mb_stripos($name, 'نجوم') !== false) {
        return '🔬';
    }
    return '📚';
}
?>

<main id="primary" class="site-main page-categories-main" style="background-color: var(--warm-cream, #faf7f2); min-height: 80vh; padding: 48px 0 80px;">
    <div class="container">
        <!-- Page Header -->
        <header class="section-header text-center" style="text-align: center; margin-bottom: 40px;">
            <div class="tento-eyebrow" style="display: inline-block; font-size: 13px; color: var(--tertiary, #b83b26); font-weight: 800; margin-bottom: 8px; letter-spacing: 0.5px;">
                <?php esc_html_e('راهنمای جامع موضوعی کتابفروشی رَشن', 'rashnubook'); ?>
            </div>
            <h1 class="font-editorial-title" style="font-size: clamp(26px, 4vw, 36px); color: var(--primary, #1a2a3a); margin: 0 0 16px; font-weight: 800;">
                <?php esc_html_e('دسته‌بندی‌های موضوعی کتاب و محصولات', 'rashnubook'); ?>
            </h1>
            <p style="max-width: 680px; margin: 0 auto 28px; color: var(--charcoal-muted, #555); font-size: 15px; line-height: 1.9;">
                <?php esc_html_e('برای دسترسی آسان و تفکیک‌شده به عناوین مورد نظرتان، می‌توانید از میان موضوعات تخصصی، حوزه‌های پژوهشی و شاخه‌های مطالعاتی زیر کتاب دلخواه خود را برگزینید.', 'rashnubook'); ?>
            </p>

            <!-- Quick Filter Bar -->
            <div class="categories-search-box" style="max-width: 460px; margin: 0 auto; position: relative;">
                <input type="text" id="rashnu-cat-filter-input" placeholder="<?php esc_attr_e('جستجو در میان عنوان دسته‌بندی‌ها...', 'rashnubook'); ?>" style="width: 100%; padding: 13px 44px 13px 18px; border: 1.5px solid var(--border-editorial, #dcd4c7); border-radius: 30px; font-size: 14px; background: #fff; outline: none; transition: border-color 0.2s, box-shadow 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
                <span style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #888; pointer-events: none;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </span>
            </div>
        </header>

        <!-- Categories Container -->
        <?php if (!empty($parent_cats) && !is_wp_error($parent_cats)) : ?>
            <div id="rashnu-categories-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
                <?php foreach ($parent_cats as $parent_cat) :
                    $cat_link = get_term_link($parent_cat);
                    $sub_cats = get_terms(array(
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => false,
                        'parent'     => $parent_cat->term_id,
                    ));
                    $icon = rashnubook_get_cat_icon($parent_cat->name);
                    
                    // Thumbnail
                    $thumb_id = get_term_meta($parent_cat->term_id, 'thumbnail_id', true);
                    $thumb_url = $thumb_id ? wp_get_attachment_url($thumb_id) : '';
                ?>
                    <div class="rashnu-cat-card" data-cat-name="<?php echo esc_attr(mb_strtolower($parent_cat->name)); ?>" style="background: #fff; border-radius: 14px; border: 1px solid var(--border-editorial, #e6dfd5); padding: 24px; display: flex; flex-direction: column; transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease; box-shadow: 0 3px 12px rgba(0,0,0,0.03);">
                        
                        <!-- Top Header -->
                        <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 16px;">
                            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(194, 141, 75, 0.12); display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0;">
                                <?php if ($thumb_url) : ?>
                                    <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($parent_cat->name); ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px;">
                                <?php else : ?>
                                    <span><?php echo esc_html($icon); ?></span>
                                <?php endif; ?>
                            </div>
                            <div style="flex-grow: 1; min-width: 0;">
                                <h2 style="font-size: 17px; font-weight: 800; margin: 0 0 4px; color: var(--primary, #1a2a3a); line-height: 1.4;">
                                    <a href="<?php echo esc_url($cat_link); ?>" style="color: inherit; text-decoration: none; transition: color 0.2s;">
                                        <?php echo esc_html($parent_cat->name); ?>
                                    </a>
                                </h2>
                                <span style="font-size: 12px; color: var(--tertiary, #b83b26); font-weight: 700;">
                                    <?php echo esc_html(rashnubook_to_persian_numbers($parent_cat->count)); ?> عنوان کتاب
                                </span>
                            </div>
                        </div>

                        <!-- Description if present -->
                        <?php if (!empty($parent_cat->description)) : ?>
                            <p style="font-size: 13px; color: #666; line-height: 1.7; margin: 0 0 16px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                <?php echo esc_html($parent_cat->description); ?>
                            </p>
                        <?php endif; ?>

                        <!-- Subcategories List (Pills) -->
                        <?php if (!empty($sub_cats) && !is_wp_error($sub_cats)) : ?>
                            <div class="rashnu-subcat-pills" style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px; flex-grow: 1;">
                                <?php foreach ($sub_cats as $sub) :
                                    $sub_link = get_term_link($sub);
                                ?>
                                    <a href="<?php echo esc_url($sub_link); ?>" style="display: inline-flex; align-items: center; gap: 4px; background: #f7f4ee; color: var(--primary, #1a2a3a); font-size: 12px; font-weight: 600; padding: 5px 11px; border-radius: 20px; text-decoration: none; border: 1px solid #ece4d8; transition: background 0.2s, border-color 0.2s;">
                                        <span><?php echo esc_html($sub->name); ?></span>
                                        <span style="font-size: 10.5px; opacity: 0.65;">(<?php echo esc_html(rashnubook_to_persian_numbers($sub->count)); ?>)</span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php else : ?>
                            <div style="flex-grow: 1;"></div>
                        <?php endif; ?>

                        <!-- Bottom Action Link -->
                        <div style="padding-top: 14px; border-top: 1px solid #f2ede4; margin-top: auto;">
                            <a href="<?php echo esc_url($cat_link); ?>" style="display: inline-flex; align-items: center; justify-content: space-between; width: 100%; color: var(--secondary, #c28d4b); font-size: 13px; font-weight: 700; text-decoration: none;">
                                <span><?php printf(esc_html__('مشاهده همه آثار %s', 'rashnubook'), esc_html($parent_cat->name)); ?></span>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <!-- Fallback empty state -->
            <div style="background: #fff; border: 1px solid var(--border-editorial, #e6dfd5); border-radius: 12px; padding: 56px 24px; text-align: center; max-width: 600px; margin: 0 auto;">
                <div style="font-size: 48px; margin-bottom: 16px;">📚</div>
                <h3 style="font-size: 20px; color: var(--primary, #1a2a3a); margin-bottom: 12px; font-weight: 800;"><?php esc_html_e('دسته‌بندی‌ها در حال به‌روزرسانی هستند', 'rashnubook'); ?></h3>
                <p style="color: var(--charcoal-muted, #666); font-size: 14px; line-height: 1.8; margin-bottom: 24px;">
                    <?php esc_html_e('دسته‌بندی‌های موضوعی به زودی با افزوده شدن کتب و عناوین جدید فعال خواهند شد.', 'rashnubook'); ?>
                </p>
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; background: var(--primary, #1a2a3a); color: #fff; padding: 10px 24px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 14px;">
                    <?php esc_html_e('مشاهده فروشگاه کتاب', 'rashnubook'); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('rashnu-cat-filter-input');
    var cards = document.querySelectorAll('.rashnu-cat-card');
    if (searchInput && cards.length) {
        searchInput.addEventListener('input', function(e) {
            var val = e.target.value.trim().toLowerCase();
            cards.forEach(function(card) {
                var text = card.textContent.toLowerCase();
                if (!val || text.indexOf(val) !== -1) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
});
</script>

<?php
get_footer();
