<?php
/**
 * Landing Page helper shortcodes and builder components for rashnubook.ir
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Shortcode: Landing Hero
 * [rashnubook_landing_hero title="شاهکار ادبیات قرن بیستم" subtitle="..." btn_text="خرید با تخفیف ویژه" btn_url="#order"]
 */
function rashnubook_shortcode_landing_hero($atts) {
    $atts = shortcode_atts(array(
        'title'       => 'شاهکار ادبیات قرن بیستم',
        'subtitle'    => 'فرصتی تکرارنشدنی برای تهیه مجموعه نفیس و نایاب با تخفیف اختصاصی همراه با ارسال پستی',
        'btn_text'    => 'سفارش فوری با ۳۰٪ تخفیف',
        'btn_url'     => '#order',
        'badge'       => 'ویژه اعضای باشگاه خوانندگان',
        'image_url'   => '',
    ), $atts, 'rashnubook_landing_hero');

    ob_start();
    ?>
    <section class="landing-hero">
        <div class="container">
            <?php if (!empty($atts['badge'])) : ?>
                <div class="hero-badge"><?php echo esc_html($atts['badge']); ?></div>
            <?php endif; ?>
            <h1 class="landing-hero-title"><?php echo esc_html($atts['title']); ?></h1>
            <p class="landing-hero-sub"><?php echo esc_html($atts['subtitle']); ?></p>
            <div style="display: flex; justify-content: center; gap: 16px; margin-bottom: 30px;">
                <a href="<?php echo esc_url($atts['btn_url']); ?>" class="btn btn-primary" style="padding: 14px 32px; font-size: 16px;">
                    <?php echo esc_html($atts['btn_text']); ?>
                </a>
            </div>
            <?php if (!empty($atts['image_url'])) : ?>
                <div style="max-width: 500px; margin: 30px auto 0; box-shadow: var(--shadow-elevation); border-radius: var(--radius-md); overflow: hidden;">
                    <img src="<?php echo esc_url($atts['image_url']); ?>" alt="<?php echo esc_attr($atts['title']); ?>" style="width: 100%; height: auto;">
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('rashnubook_landing_hero', 'rashnubook_shortcode_landing_hero');

/**
 * Shortcode: Countdown Banner
 * [rashnubook_countdown hours="24" label="مهلت استفاده از تخفیف ویژه"]
 */
function rashnubook_shortcode_countdown($atts) {
    $atts = shortcode_atts(array(
        'hours' => '24',
        'label' => 'مهلت باقی‌مانده برای خرید با تخفیف ویژه انتشارات:',
    ), $atts, 'rashnubook_countdown');

    ob_start();
    ?>
    <div style="text-align: center; margin: 24px 0;">
        <div class="countdown-bar">
            <span style="font-size: 14px; font-weight: 600; color: var(--charcoal-ink);"><?php echo esc_html($atts['label']); ?></span>
            <div class="countdown-item">
                <span class="countdown-value"><?php echo esc_html(rashnubook_to_persian_numbers($atts['hours'])); ?></span>
                <span class="countdown-label">ساعت</span>
            </div>
            <span style="font-weight: bold; color: var(--tertiary);">:</span>
            <div class="countdown-item">
                <span class="countdown-value">۴۸</span>
                <span class="countdown-label">دقیقه</span>
            </div>
            <span style="font-weight: bold; color: var(--tertiary);">:</span>
            <div class="countdown-item">
                <span class="countdown-value">۳۵</span>
                <span class="countdown-label">ثانیه</span>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('rashnubook_countdown', 'rashnubook_shortcode_countdown');

/**
 * Shortcode: Features Strip
 * [rashnubook_features]
 */
function rashnubook_shortcode_features() {
    ob_start();
    ?>
    <div class="features-strip">
        <div class="container">
            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon"><?php rashnubook_icon('shipping'); ?></div>
                    <div>
                        <div class="feature-title">ارسال سریع و مطمئن</div>
                        <div class="feature-subtitle">بسته‌بندی مقاوم کتاب با پست پیشتاز</div>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><?php rashnubook_icon('book'); ?></div>
                    <div>
                        <div class="feature-title">ضمانت اصالت نسخه</div>
                        <div class="feature-subtitle">چاپ نفیس و اصل نشر با کیفیت کاغذ اعلا</div>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><?php rashnubook_icon('heart'); ?></div>
                    <div>
                        <div class="feature-title">نشان ویژه کتابخوان</div>
                        <div class="feature-subtitle">نشانک (بوک‌مارک) اختصاصی رایگان در هر بسته</div>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><?php rashnubook_icon('check'); ?></div>
                    <div>
                        <div class="feature-title">پشتیبانی اختصاصی</div>
                        <div class="feature-subtitle">مشاوره انتخاب کتاب و پیگیری آنلاین سفارش</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('rashnubook_features', 'rashnubook_shortcode_features');

/**
 * Shortcode: Editorial Quote
 * [rashnubook_quote text="..." author="..."]
 */
function rashnubook_shortcode_quote($atts) {
    $atts = shortcode_atts(array(
        'text'   => 'خواندن این اثر، آغاز سفری شگفت‌انگیز به ژرفای ادبیات و درک عمیق‌تر از سرشت آدمی است.',
        'author' => 'یادداشت شورای علمی و ادبی رشنو',
    ), $atts, 'rashnubook_quote');

    ob_start();
    ?>
    <div class="editorial-quote-box">
        <p class="editorial-quote-text">«<?php echo esc_html($atts['text']); ?>»</p>
        <span class="editorial-quote-author"><?php echo esc_html($atts['author']); ?></span>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('rashnubook_quote', 'rashnubook_shortcode_quote');
