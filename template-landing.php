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

$landing_badge = rashnubook_get_option('landing_hero_badge', 'پروموشن ویژه کتابفروشی آنلاین رَشن');
$landing_sub   = rashnubook_get_option('landing_hero_sub', 'روایتی کم‌نظیر از ادبیات داستانی معاصر، چاپ ویژه همراه با صحافی نفیس و ارسال پستی به سراسر کشور');
$landing_quote_text = rashnubook_get_option('landing_quote_text', 'اثری که نگرش شما را نسبت به ادبیات و هستی دگرگون خواهد کرد.');
$landing_quote_author = rashnubook_get_option('landing_quote_author', 'نقد ضمیمه فرهنگی رشنو');
$landing_spec_format = rashnubook_get_option('landing_spec_format', 'وزیری - گالینگور زرکوب نفیس');
$landing_spec_paper = rashnubook_get_option('landing_spec_paper', 'بالکی کرم سوئدی (سبک و ضد خستگی چشم)');
$landing_spec_edition = rashnubook_get_option('landing_spec_edition', 'ویرایش نو - بهار ۱۴۰۳');
$landing_spec_shipping = rashnubook_get_option('landing_spec_shipping', 'پست پیشتاز اختصاصی در بسته‌بندی حباب‌دار ایمن');
$landing_cta_pid = (int)rashnubook_get_option('landing_cta_product_id', 0);
if (!$landing_cta_pid && function_exists('get_page_by_path')) {
    $fallback_landing_p = get_page_by_path('landing-katouzian-law-package', OBJECT, 'product');
    if ($fallback_landing_p) {
        $landing_cta_pid = $fallback_landing_p->ID;
    }
}
$landing_cta_product = ($landing_cta_pid && function_exists('wc_get_product')) ? wc_get_product($landing_cta_pid) : null;
$landing_cta_old_price = rashnubook_get_option('landing_cta_old_price', ($landing_cta_product && $landing_cta_product->is_on_sale()) ? rashnubook_to_persian_numbers($landing_cta_product->get_regular_price()) . ' تومان' : '۴۵۰,۰۰۰ تومان');
$landing_cta_price = rashnubook_get_option('landing_cta_price', $landing_cta_product ? rashnubook_to_persian_numbers($landing_cta_product->get_price()) . ' تومان' : '۳۸۵,۰۰۰ تومان');

$landing_cta_custom_link = rashnubook_get_option('landing_cta_link', '');
if (!empty($landing_cta_custom_link)) {
    $landing_cta_link = $landing_cta_custom_link;
} elseif ($landing_cta_product) {
    $landing_cta_link = function_exists('wc_get_cart_url') ? add_query_arg('add-to-cart', $landing_cta_product->get_id(), wc_get_cart_url()) : $landing_cta_product->add_to_cart_url();
} else {
    $landing_cta_link = class_exists('WooCommerce') ? wc_get_page_permalink('shop') : '#';
}
?>

<main id="primary" class="site-main landing-page-wrapper">
    <!-- Landing Hero -->
    <section class="landing-hero">
        <div class="container">
            <span class="hero-badge">
                <?php rashnubook_icon('star'); ?>
                <span><?php echo esc_html($landing_badge); ?></span>
            </span>
            <h1 class="landing-hero-title"><?php the_title(); ?></h1>
            <p class="landing-hero-sub"><?php echo esc_html($landing_sub); ?></p>

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
            <?php echo do_shortcode('[rashnubook_quote text="' . esc_attr($landing_quote_text) . '" author="' . esc_attr($landing_quote_author) . '"]'); ?>

            <!-- Book Specifications Box -->
            <div style="background: var(--paper); border: 1px solid var(--border-editorial); border-radius: var(--radius-md); padding: 28px; margin: 40px 0;">
                <h3 style="font-size: 20px; color: var(--primary); margin-bottom: 20px; border-bottom: 2px solid var(--border-subtle); padding-bottom: 8px;">
                    <?php esc_html_e('مشخصات و شناسنامه نسخه نفیس', 'rashnubook'); ?>
                </h3>
                <table class="book-specs-table">
                    <tbody>
                        <tr><td>قطع و جلد</td><td><?php echo esc_html($landing_spec_format); ?></td></tr>
                        <tr><td>نوع کاغذ</td><td><?php echo esc_html($landing_spec_paper); ?></td></tr>
                        <tr><td>نوبت چاپ</td><td><?php echo esc_html($landing_spec_edition); ?></td></tr>
                        <tr><td>ارسال</td><td><?php echo esc_html($landing_spec_shipping); ?></td></tr>
                    </tbody>
                </table>
            </div>

            <!-- FAQ Accordion -->
            <div style="margin: 48px 0;">
                <h3 style="text-align: center; font-size: 24px; color: var(--primary); margin-bottom: 24px;">
                    <?php esc_html_e('پرسش‌های متداول خوانندگان', 'rashnubook'); ?>
                </h3>
                <div class="faq-accordion">
                    <div class="faq-item active">
                        <button class="faq-question">
                            <span>کتاب چه زمانی به دستم می‌رسد؟</span>
                            <span class="material-symbols-outlined">+</span>
                        </button>
                        <div class="faq-answer">
                            سفارش‌های تهران همان روز یا حداکثر ۲۴ ساعت کاری با پیک ارسال شده و سفارش‌های شهرستان‌ها ظرف ۲ الی ۳ روز کاری با پست پیشتاز تحویل داده می‌شوند.
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question">
                            <span>آیا نسخه کتاب دارای ضمانت سلامت فیزیکی است؟</span>
                            <span class="material-symbols-outlined">+</span>
                        </button>
                        <div class="faq-answer">
                            بله، تمام کتاب‌ها پیش از ارسال توسط بخش کنترل کیفی بررسی و در بسته‌بندی چندلایه ویژه کتاب مقاوم در برابر ضربه ارسال می‌گردد. در صورت هرگونه نقص، تعویض رایگان انجام خواهد شد.
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question">
                            <span>روش‌های پرداخت به چه صورت است؟</span>
                            <span class="material-symbols-outlined">+</span>
                        </button>
                        <div class="faq-answer">
                            امکان پرداخت آنلاین امن از طریق درگاه‌های عضو شبکه شتاب با تمامی کارت‌های بانکی فراهم است.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Conversion Action Box -->
            <?php
            $landing_cta_enable = rashnubook_get_option('aftabgardan_plans_enable', rashnubook_get_option('landing_cta_enable', '1')) !== '0';
            if ($landing_cta_enable) :
            ?>
                <div id="order-now" class="purchase-box" style="text-align: center; background: #ffffff; box-shadow: var(--shadow-elevation);">
                    <span style="font-size: 13px; color: var(--secondary); font-weight: 700;">فرصت محدود تا پایان موجودی چاپ نفیس</span>
                    <h2 style="font-size: 26px; color: var(--primary); margin: 8px 0;">هم‌اکنون نسخه خود را دریافت کنید</h2>
                    <div style="margin: 16px 0;">
                        <span style="font-size: 16px; text-decoration: line-through; color: var(--outline); margin-left: 12px;"><?php echo esc_html($landing_cta_old_price); ?></span>
                        <span style="font-size: 26px; font-weight: 800; color: var(--primary);"><?php echo esc_html($landing_cta_price); ?></span>
                    </div>
                    <?php if (class_exists('WooCommerce')) : ?>
                        <a href="<?php echo esc_url($landing_cta_link); ?>" class="btn btn-primary" style="padding: 14px 40px; font-size: 16px; margin: 0 auto;">
                            <?php rashnubook_icon('cart'); ?>
                            <span>تکمیل سفارش و پرداخت آنلاین</span>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
get_footer();
