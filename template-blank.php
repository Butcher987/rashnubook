<?php
/**
 * Template Name: برگه خام لندینگ (Blank Canvas Landing Page)
 *
 * A clean canvas without standard header and footer for custom landing campaigns.
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('rashnubook-blank-landing'); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site-landing-blank">
    <main id="primary" class="site-main">
        <?php
        while (have_posts()) :
            the_post();
            the_content();
        endwhile;
        ?>
    </main>
</div>

<?php wp_footer(); ?>
</body>
</html>
