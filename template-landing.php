<?php
/**
 * Template Name: برگه فرود اختصاصی کتاب (Landing Page)
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$rb_page_id   = get_the_ID();
$rb_hero_sub  = rashnubook_fix_meta($rb_page_id, 'rb_hero_sub', 'روایتی کم‌نظیر از ادبیات داستانی معاصر، چاپ ویژه همراه با صحافی نفیس و ارسال رایگان پستی به سراسر کشور');
$rb_old_price = rashnubook_fix_meta($rb_page_id, 'rb_old_price', '۴۵۰,۰۰۰');
$rb_price     = rashnubook_fix_meta($rb_page_id, 'rb_price', '۳۸۵,۰۰۰');
$rb_buy_url   = rashnubook_fix_meta($rb_page_id, 'rb_buy_url', '');
$rb_buy_link  = $rb_buy_url ? $rb_buy_url : (class_exists('WooCommerce') ? wc_get_page_permalink('shop') : '#order-now');
$rb_faq_raw   = rashnubook_fix_meta($rb_page_id, 'rb_landing_faq', '');
$rb_faq_items = $rb_faq_raw ? rashnubook_fix_parse_faq($rb_faq_raw) : array(
    array('q' => 'کتاب چه زمانی به دستم می‌رسد؟', 'a' => 'سفارش‌های تهران همان روز یا حداکثر ۲۴ ساعت کاری با پیک ارسال شده و سفارش‌های شهرستان‌ها ظرف ۲ الی ۳ روز کاری با پست پیشتاز تحویل داده می‌شوند.'),
    array('q' => 'آیا نسخه کتاب دارای ضمانت سلامت فیزیکی است؟', 'a' => 'بله، تمام کتاب‌ها پیش از ارسال توسط بخش کنترل کیفی بررسی و در بسته‌بندی چندلایه ویژه کتاب مقاوم در برابر ضربه ارسال می‌گردد. در صورت هرگونه نقص، تعویض رایگان انجام خواهد شد.'),
    array('q' => 'روش‌های پرداخت به چه صورت است؟', 'a' => 'امکان پرداخت آنلاین امن از طریق درگاه‌های عضو شبکه شتاب با تمامی کارت‌های بانکی فراهم است.'),
);
?>

<main id="primary" class="site-main landing-page-wrapper">
    <!-- Landing Hero -->
    <section class="landing-hero">
        <div class="container">
            <span class="hero-badge">
                <?php rashnubook_icon('star'); ?>
                <span>پروموشن ویژه کتابفروشی آنلاین رَشن</span>
            </span>
            <h1 class="landing-hero-title"><?php the_title(); ?></h1>
            <p class="landing-hero-sub"><?php echo esc_html($rb_hero_sub); ?></p>

            <!-- Countdown Timer -->
            <?php echo do_shortcode('[rashnubook_countdown hours="36"]'); ?>

            <div style="margin: 24px 0;">
                <a href="#order-now" class="btn btn-primary" style="padding: 14px 36px; font-size: 16px;">
                    <?php rashnubook_icon('cart'); ?>
                    <span>ثبت سفارش آنلاین با تخفیف</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Features strip -->
    <?php echo do_shortcode('[rashnubook_features]'); ?>

    <!-- Main Content Section -->
    <section class="section-padding">
        <div class="container" style="max-width: 860px;">
            <div class="landing-content" style="font-size: 16px; line-height: 2;">
                <?php
                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile;
                ?>
            </div>

            <!-- Editorial Quote -->
            <?php echo do_shortcode('[rashnubook_quote text="اثری که نگرش شما را نسبت به ادبیات و هستی دگرگون خواهد کرد." author="نقد ضمیمه فرهنگی رشنو"]'); ?>

            <!-- Book Specifications Box -->
            <div style="background: var(--paper); border: 1px solid var(--border-editorial); border-radius: var(--radius-md); padding: 28px; margin: 40px 0;">
                <h3 style="font-size: 20px; color: var(--primary); margin-bottom: 20px; border-bottom: 2px solid var(--border-subtle); padding-bottom: 8px;">
                    <?php esc_html_e('مشخصات و شناسنامه نسخه نفیس', 'rashnubook'); ?>
                </h3>
                <table class="book-specs-table">
                    <tbody>
                        <tr><td>قطع و جلد</td><td>وزیری - گالینگور زرکوب نفیس</td></tr>
                        <tr><td>نوع کاغذ</td><td>بالکی کرم سوئدی (سبک و ضد خستگی چشم)</td></tr>
                        <tr><td>نوبت چاپ</td><td>ویرایش نو - بهار ۱۴۰۳</td></tr>
                        <tr><td>ارسال</td><td>پست پیشتاز اختصاصی در بسته‌بندی حباب‌دار ایمن</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- FAQ Accordion -->
            <div style="margin: 48px 0;">
                <h3 style="text-align: center; font-size: 24px; color: var(--primary); margin-bottom: 24px;">
                    <?php esc_html_e('پرسش‌های متداول خوانندگان', 'rashnubook'); ?>
                </h3>
                <div class="faq-accordion">
                    <?php foreach ($rb_faq_items as $rb_i => $rb_item) : ?>
                        <div class="faq-item <?php echo 0 === $rb_i ? 'active' : ''; ?>">
                            <button class="faq-question">
                                <span><?php echo esc_html($rb_item['q']); ?></span>
                                <span class="material-symbols-outlined">+</span>
                            </button>
                            <div class="faq-answer">
                                <?php echo esc_html($rb_item['a']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Conversion Action Box -->
            <div id="order-now" class="purchase-box" style="text-align: center; background: #ffffff; box-shadow: var(--shadow-elevation);">
                <span style="font-size: 13px; color: var(--secondary); font-weight: 700;">فرصت محدود تا پایان موجودی چاپ نفیس</span>
                <h2 style="font-size: 26px; color: var(--primary); margin: 8px 0;">هم‌اکنون نسخه خود را دریافت کنید</h2>
                <div style="margin: 16px 0;">
                    <span style="font-size: 16px; text-decoration: line-through; color: var(--outline); margin-left: 12px;"><?php echo esc_html($rb_old_price); ?> تومان</span>
                    <span style="font-size: 26px; font-weight: 800; color: var(--primary);"><?php echo esc_html($rb_price); ?> تومان</span>
                </div>
                <a href="<?php echo esc_url($rb_buy_link); ?>" class="btn btn-primary" style="padding: 14px 40px; font-size: 16px; margin: 0 auto;">
                    <?php rashnubook_icon('cart'); ?>
                    <span>تکمیل سفارش و پرداخت آنلاین</span>
                </a>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
