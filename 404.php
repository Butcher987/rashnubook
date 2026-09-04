<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main section-padding">
    <div class="container" style="max-width: 600px; text-align: center;">
        <div style="background: var(--paper); border: 1px solid var(--border-editorial); border-radius: var(--radius-lg); padding: 50px 30px; box-shadow: var(--shadow-card);">
            <div style="font-size: 72px; font-weight: 800; color: var(--tertiary); line-height: 1; margin-bottom: 16px;">
                ۴۰۴
            </div>
            <h1 style="font-size: 24px; color: var(--primary); margin-bottom: 16px;">
                <?php esc_html_e('برگی که در جستجوی آن بودید، ورق خورده است!', 'rashnubook'); ?>
            </h1>
            <p style="font-size: 14.5px; color: var(--charcoal-muted); line-height: 1.8; margin-bottom: 28px;">
                صفحه مورد نظر شما جابه‌جا شده یا دیگر در دسترس نیست. می‌توانید از طریق کادر جستجو یا صفحه اصلی، به سیر در کتابفروشی آنلاین رَشن ادامه دهید.
            </p>
            <div style="display: flex; justify-content: center; gap: 12px;">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                    <?php esc_html_e('بازگشت به پیشخوان کتابفروشی', 'rashnubook'); ?>
                </a>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
