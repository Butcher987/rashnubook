<?php
/**
 * The template for displaying archive pages
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
            <?php
            the_archive_title('<h1 class="section-title">', '</h1>');
            the_archive_description('<div class="archive-description" style="font-size: 13.5px; color: var(--charcoal-muted); margin-top: 8px;">', '</div>');
            ?>
        </header>

        <?php if (have_posts()) : ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('book-card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="book-cover-wrap" style="aspect-ratio: 16 / 9;">
                                <?php the_post_thumbnail('medium_large', array('class' => 'book-cover-img')); ?>
                            </div>
                        <?php endif; ?>
                        <span style="font-size: 12px; color: var(--secondary); font-weight: 600; margin-bottom: 6px;">
                            <?php echo esc_html(rashnubook_to_persian_numbers(get_the_date())); ?>
                        </span>
                        <h2 class="book-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p style="font-size: 13.5px; color: var(--charcoal-muted); margin-bottom: 16px;">
                            <?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?>
                        </p>
                        <div class="book-footer">
                            <a href="<?php the_permalink(); ?>" class="btn-book-action">
                                <span><?php esc_html_e('مشاهده', 'rashnubook'); ?></span>
                                <?php rashnubook_icon('arrow-left'); ?>
                            </a>
                        </div>
                    </article>
                    <?php
                endwhile;
                ?>
            </div>

            <div class="woocommerce-pagination" style="margin-top: 40px;">
                <?php the_posts_pagination(); ?>
            </div>
        <?php else : ?>
            <p><?php esc_html_e('موردی در این بخش یافت نشد.', 'rashnubook'); ?></p>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
