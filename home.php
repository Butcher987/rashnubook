<?php
/**
 * The template for displaying the blog posts index / literary notes & reviews
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<?php
$blog_eyebrow = rashnubook_get_option('blog_archive_eyebrow', rashnubook_get_option('home_blog_eyebrow', 'اندیشه‌ورزی و نگاه به جهان کتاب'));
$blog_title   = rashnubook_get_option('blog_archive_title', 'یادداشت‌ها و نقد کتاب');
$blog_desc    = rashnubook_get_option('blog_archive_desc', 'مجموعه‌ای از جستارهای تحلیلی، معرفی تازه‌های نشر، نقد و بررسی شاهکارهای حقوقی و ادبی به قلم نویسندگان و منتقدان کتابفروشی آنلاین رَشن.');
?>

<main id="primary" class="site-main section-padding" style="background-color: var(--warm-cream, #faf7f2); min-height: 80vh; padding: 48px 0 80px;">
    <div class="container">
        <header class="blog-header-block section-header text-center" style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; margin-bottom: 48px; border-bottom: none;">
            <?php if (!empty($blog_eyebrow)) : ?>
                <div class="tento-eyebrow" style="display: inline-block; font-size: 13px; color: var(--tertiary, #b83b26); font-weight: 800; margin-bottom: 8px; letter-spacing: 0.5px;">
                    <?php echo esc_html($blog_eyebrow); ?>
                </div>
            <?php endif; ?>
            <h1 class="font-editorial-title" style="font-size: clamp(24px, 4vw, 36px); color: var(--primary, #1a2a3a); margin: 0 0 16px; font-weight: 900; width: 100%;">
                <?php echo esc_html($blog_title); ?>
            </h1>
            <?php if (!empty($blog_desc)) : ?>
                <p style="max-width: 650px; margin: 0 auto; color: var(--charcoal-muted, #555); font-size: 14.5px; line-height: 1.9;">
                    <?php echo esc_html($blog_desc); ?>
                </p>
            <?php endif; ?>
        </header>

        <?php if (have_posts()) : ?>
            <div class="tento-articles-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 28px;">
                <?php
                while (have_posts()) :
                    the_post();
                    $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
                    if (!$thumb_url) {
                        $thumb_url = RASHNUBOOK_URI . '/assets/images/rashnu-logo.jpg';
                    }
                    $categories = get_the_category();
                    $category_name = !empty($categories) ? $categories[0]->name : 'نقد و بررسی';
                    
                    // Calculate reading time
                    $content = get_post_field('post_content', get_the_ID());
                    $word_count = mb_strlen(strip_tags($content), 'UTF-8') / 5;
                    $reading_minutes = max(1, (int)ceil($word_count / 180));
                    $reading_time_text = rashnubook_to_persian_numbers($reading_minutes) . ' دقیقه';
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('tento-article-card'); ?> style="background: #fff; border-radius: 12px; border: 1px solid var(--border-editorial, #e6dfd5); overflow: hidden; display: flex; flex-direction: column; transition: transform 0.25s ease, box-shadow 0.25s ease; box-shadow: 0 4px 16px rgba(0,0,0,0.04);">
                        <a href="<?php the_permalink(); ?>" class="tento-article-media" style="display: block; position: relative; aspect-ratio: 16/10; overflow: hidden; background: #eee;">
                            <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;">
                            <span class="tento-article-tag" style="position: absolute; top: 12px; right: 12px; background: rgba(26, 42, 58, 0.88); backdrop-filter: blur(4px); color: #fff; font-size: 11.5px; font-weight: 700; padding: 4px 10px; border-radius: 6px;">
                                <?php echo esc_html($category_name); ?>
                            </span>
                        </a>
                        <div class="tento-article-body" style="padding: 22px; display: flex; flex-direction: column; flex-grow: 1;">
                            <div class="tento-article-meta" style="display: flex; align-items: center; gap: 8px; font-size: 12.5px; color: var(--charcoal-muted, #777); margin-bottom: 10px;">
                                <span><?php echo esc_html(rashnubook_to_persian_numbers(get_the_date('j F Y'))); ?></span>
                                <span>•</span>
                                <span>زمان مطالعه: <?php echo esc_html($reading_time_text); ?></span>
                            </div>
                            <h2 class="tento-article-title" style="font-size: 17px; line-height: 1.55; margin: 0 0 10px; font-weight: 700;">
                                <a href="<?php the_permalink(); ?>" style="color: var(--primary, #1a2a3a); text-decoration: none; transition: color 0.2s ease;">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            <p class="tento-article-excerpt" style="font-size: 13.5px; color: var(--charcoal-muted, #666); line-height: 1.8; margin-bottom: 20px; flex-grow: 1;">
                                <?php echo esc_html(wp_trim_words(get_the_excerpt(), 22, '...')); ?>
                            </p>
                            <div class="tento-article-footer" style="padding-top: 14px; border-top: 1px solid #f0ebe1;">
                                <a href="<?php the_permalink(); ?>" class="btn-book-action" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px; color: var(--secondary, #c28d4b); font-weight: 700; font-size: 13px;">
                                    <span><?php esc_html_e('مطالعه کامل یادداشت', 'rashnubook'); ?></span>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                    <?php
                endwhile;
                ?>
            </div>

            <div class="woocommerce-pagination" style="margin-top: 56px; text-align: center;">
                <?php
                the_posts_pagination(array(
                    'prev_text' => '&rarr; قبلی',
                    'next_text' => 'بعدی &larr;',
                ));
                ?>
            </div>
        <?php else : ?>
            <div style="background: #fff; border: 1px solid var(--border-editorial, #e6dfd5); border-radius: 12px; padding: 56px 24px; text-align: center; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 16px rgba(0,0,0,0.04);">
                <div style="font-size: 48px; margin-bottom: 16px;">📖</div>
                <h3 style="font-size: 20px; color: var(--primary, #1a2a3a); margin-bottom: 12px; font-weight: 800;"><?php esc_html_e('هنوز یادداشتی منتشر نشده است', 'rashnubook'); ?></h3>
                <p style="color: var(--charcoal-muted, #666); font-size: 14px; line-height: 1.8; margin-bottom: 24px;">
                    <?php esc_html_e('به زودی مقالات و یادداشت‌های تحلیلی و نقد کتاب در این بخش قرار خواهند گرفت.', 'rashnubook'); ?>
                </p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; background: var(--primary, #1a2a3a); color: #fff; padding: 10px 24px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 14px;">
                    <?php esc_html_e('بازگشت به صفحه اصلی', 'rashnubook'); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
