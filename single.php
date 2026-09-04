<?php
/**
 * The template for displaying all single posts
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main section-padding">
    <div class="container" style="max-width: 840px;">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header" style="margin-bottom: 28px; text-align: center;">
                    <div style="font-size: 13px; color: var(--secondary); margin-bottom: 12px;">
                        <span><?php the_category(' ، '); ?></span>
                        <span style="margin: 0 8px;">•</span>
                        <span><?php echo esc_html(rashnubook_to_persian_numbers(get_the_date())); ?></span>
                    </div>
                    <h1 style="font-size: 32px; font-weight: 800; color: var(--primary); line-height: 1.4; margin-bottom: 16px;">
                        <?php the_title(); ?>
                    </h1>
                    <div style="font-size: 13.5px; color: var(--charcoal-muted);">
                        <span><?php esc_html_e('نویسنده یادداشت:', 'rashnubook'); ?> <?php the_author(); ?></span>
                    </div>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div style="margin-bottom: 32px; border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--shadow-card);">
                        <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: auto;')); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content" style="font-size: 16px; line-height: 2; color: var(--charcoal-ink);">
                    <?php
                    the_content();
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('برگه‌ها:', 'rashnubook'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>

                <footer class="entry-footer" style="margin-top: 40px; padding-top: 20px; border-top: 1px solid var(--border-subtle);">
                    <?php the_tags('<div style="font-size: 13px; color: var(--charcoal-muted);">برچسب‌ها: ', ' ، ', '</div>'); ?>
                </footer>
            </article>

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;

        endwhile;
        ?>
    </div>
</main>

<?php
get_footer();
