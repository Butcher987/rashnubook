<?php
/**
 * The template for displaying all pages
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$is_wide = (function_exists('is_cart') && is_cart()) || (function_exists('is_checkout') && is_checkout()) || (function_exists('is_account_page') && is_account_page());
?>

<main id="primary" class="site-main section-padding" style="padding: 32px 0 60px;">
    <div class="container" style="<?php echo $is_wide ? 'max-width: 1240px; width: 100%;' : 'max-width: 900px;'; ?>">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header" style="margin-bottom: 28px;">
                    <h1 class="font-editorial-title" style="font-size: 28px; font-weight: 900; color: var(--mocha); line-height: 1.3;">
                        <?php the_title(); ?>
                    </h1>
                </header>

                <div class="entry-content" style="font-size: 15.5px; line-height: 1.95;">
                    <?php
                    the_content();
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('برگه‌ها:', 'rashnubook'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>
            </article>

            <?php
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;

        endwhile;
        ?>
    </div>
</main>

<?php
get_footer();
