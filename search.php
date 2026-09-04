<?php
/**
 * The template for displaying search results
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main section-padding">
    <div class="container">
        <header class="section-header">
            <h1 class="section-title">
                <?php printf(esc_html__('نتایج جستجو برای: «%s»', 'rashnubook'), '<span style="color:var(--secondary);">' . get_search_query() . '</span>'); ?>
            </h1>
        </header>

        <?php if (have_posts()) : ?>
            <div class="book-grid">
                <?php
                while (have_posts()) :
                    the_post();
                    if ('product' === get_post_type() && class_exists('WooCommerce')) :
                        wc_get_template_part('content', 'product');
                    else :
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('book-card'); ?>>
                            <h2 class="book-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p style="font-size: 13.5px; color: var(--charcoal-muted); margin: 10px 0;">
                                <?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?>
                            </p>
                            <div class="book-footer">
                                <a href="<?php the_permalink(); ?>" class="btn-book-action"><?php esc_html_e('مشاهده نتیجه', 'rashnubook'); ?></a>
                            </div>
                        </article>
                        <?php
                    endif;
                endwhile;
                ?>
            </div>

            <div class="woocommerce-pagination" style="margin-top: 40px;">
                <?php the_posts_pagination(); ?>
            </div>
        <?php else : ?>
            <div style="background: var(--paper); border: 1px solid var(--border-editorial); border-radius: var(--radius-md); padding: 40px; text-align: center;">
                <p style="font-size: 16px; margin-bottom: 20px; color: var(--charcoal-muted);">
                    <?php esc_html_e('متأسفانه نتیجه‌ای مطابق با عبارت جستجوی شما یافت نشد.', 'rashnubook'); ?>
                </p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary"><?php esc_html_e('بازگشت به خانه', 'rashnubook'); ?></a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
