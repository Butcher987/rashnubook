<?php
/**
 * The footer template for rashnubook.ir
 * Features: Editable footer sections, dynamic social media links, and Mobile App Bottom Bar.
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

$about_text = rashnubook_get_option('footer_about_text', 'کتابفروشی آنلاین رَشن، پایگاهی برای دوستداران ادبیات، اندیشه و فرهنگ اصیل. ما متعهد به گزینش و عرضه فاخرترین آثار مکتوب حقوقی و ادبی، ویرایش دقیق و ارائه باکیفیت‌ترین نسخه‌های چاپی در سراسر ایران هستیم.');
$address    = rashnubook_get_option('address', 'تهران، میدان انقلاب، روبروی دانشگاه تهران، راسته کتابفروشان، کتابفروشی آنلاین رَشن');
$phone      = rashnubook_get_option('phone', '۰۲۱-۸۸۹۹۰۰۱۱');
$email      = rashnubook_get_option('email', 'info@rashnubook.ir');
$copyright  = rashnubook_get_option('copyright_text', 'تمامی حقوق برای کتابفروشی آنلاین رَشن (rashnubook.ir) محفوظ است.');

// Social media links (editable via Customizer > شبکه‌های اجتماعی رشنو بوک)
$social_instagram = rashnubook_fix_social_url('instagram', 'https://instagram.com/rashno_book');
$social_telegram  = rashnubook_fix_social_url('telegram', 'https://t.me/rashno_book');
$social_whatsapp  = rashnubook_fix_social_url('whatsapp', '');
$social_bale      = rashnubook_fix_social_url('bale', '');
$social_eitaa     = rashnubook_fix_social_url('eitaa', '');
$social_x         = rashnubook_fix_social_url('x', '');

$ig_handle = '';
if (!empty($social_instagram)) {
    $ig_handle = preg_replace('#^https?://(www\.)?instagram\.com/?#i', '', $social_instagram);
    $ig_handle = ltrim(trim((string) $ig_handle, '/ '), '@');
}
?>
    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <!-- Col 1: About & Socials -->
                <div class="footer-col">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                        <img src="<?php echo esc_url(RASHNUBOOK_URI . '/assets/images/rashnu-logo.jpg'); ?>" alt="کتابفروشی آنلاین رَشن" style="height: 48px; width: 48px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(255,255,255,0.2);">
                        <div>
                            <span style="font-size: 19px; font-weight: 800; color: #ffffff; display: block; line-height: 1.2;">کتابفروشی آنلاین رَشن</span>
                            <span style="font-size: 11px; background: var(--terracotta); color: #ffffff; padding: 2px 6px; border-radius: 4px; font-weight: 700;">rashnubook.ir</span>
                        </div>
                    </div>
                    <p class="footer-desc">
                        <?php echo esc_html($about_text); ?>
                    </p>
                    
                    <!-- Official Social Media Links (Only displayed if link is provided) -->
                    <div class="footer-socials" style="display: flex; gap: 10px; margin-top: 14px; flex-wrap: wrap;">
                        <?php if (!empty($social_instagram)) : ?>
                            <a href="<?php echo esc_url($social_instagram); ?>" target="_blank" rel="noopener" title="اینستاگرام" class="footer-social-btn" style="width:36px; height:36px; border-radius:10px; background:rgba(255,255,255,0.1); display:flex; align-items:center; justify-content:center; text-decoration:none; transition:all 0.25s;">
                                <?php rashnubook_icon('instagram'); ?>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($social_telegram)) : ?>
                            <a href="<?php echo esc_url($social_telegram); ?>" target="_blank" rel="noopener" title="کانال تلگرام" class="footer-social-btn" style="width:36px; height:36px; border-radius:10px; background:rgba(255,255,255,0.1); display:flex; align-items:center; justify-content:center; text-decoration:none; transition:all 0.25s;">
                                <?php rashnubook_icon('telegram'); ?>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($social_whatsapp)) : ?>
                            <a href="<?php echo esc_url($social_whatsapp); ?>" target="_blank" rel="noopener" title="واتساپ پشتیبانی" class="footer-social-btn" style="width:36px; height:36px; border-radius:10px; background:rgba(255,255,255,0.1); display:flex; align-items:center; justify-content:center; text-decoration:none; transition:all 0.25s;">
                                <?php rashnubook_icon('whatsapp'); ?>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($social_bale)) : ?>
                            <a href="<?php echo esc_url($social_bale); ?>" target="_blank" rel="noopener" title="پیام‌رسان بله" class="footer-social-btn" style="width:36px; height:36px; border-radius:10px; background:rgba(255,255,255,0.1); display:flex; align-items:center; justify-content:center; text-decoration:none; transition:all 0.25s;">
                                <?php rashnubook_icon('bale'); ?>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($social_eitaa)) : ?>
                            <a href="<?php echo esc_url($social_eitaa); ?>" target="_blank" rel="noopener" title="پیام‌رسان ایتا" class="footer-social-btn" style="width:36px; height:36px; border-radius:10px; background:rgba(255,255,255,0.1); display:flex; align-items:center; justify-content:center; text-decoration:none; transition:all 0.25s;">
                                <?php rashnubook_icon('eitaa'); ?>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($social_x)) : ?>
                            <a href="<?php echo esc_url($social_x); ?>" target="_blank" rel="noopener" title="شبکه اجتماعی X" class="footer-social-btn" style="width:36px; height:36px; border-radius:10px; background:rgba(255,255,255,0.1); display:flex; align-items:center; justify-content:center; text-decoration:none; transition:all 0.25s;">
                                <?php rashnubook_icon('x'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div class="footer-col">
                    <h4><?php esc_html_e('پیوندهای مهم', 'rashnubook'); ?></h4>
                    <ul class="footer-links">
                        <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('صفحه اصلی کتاب‌سرا', 'rashnubook'); ?></a></li>
                        <?php if (class_exists('WooCommerce')) : ?>
                            <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"><?php esc_html_e('کتاب‌ها و دیگر محصولات', 'rashnubook'); ?></a></li>
                            <li><a href="<?php echo esc_url(wc_get_cart_url())); ?>"><?php esc_html_e('سبد خرید و تسویه', 'rashnubook'); ?></a></li>
                            <li><a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>"><?php esc_html_e('پیگیری و سوابق سفارش', 'rashnubook'); ?></a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo esc_url(home_url('/aftabgardan/')); ?>"><?php esc_html_e('ماهنامه ادبی آفتابگردان', 'rashnubook'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/about-us/')); ?>"><?php esc_html_e('درباره کتابفروشی آنلاین رَشن', 'rashnubook'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/contact-us/')); ?>"><?php esc_html_e('تماس با ما و ساعات کاری', 'rashnubook'); ?></a></li>
                    </ul>
                </div>

                <!-- Col 3: Categories -->
                <div class="footer-col">
                    <h4><?php esc_html_e('موضوعات برگزیده', 'rashnubook'); ?></h4>
                    <ul class="footer-links">
                        <li><a href="<?php echo esc_url(home_url('/shop/?product_cat=law-books')); ?>"><?php esc_html_e('کتب تخصصی حقوقی و آزمونی', 'rashnubook'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/shop/?product_cat=fiction')); ?>"><?php esc_html_e('شاهکارهای ادبیات داستانی و رمان', 'rashnubook'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/shop/?product_cat=philosophy')); ?>"><?php esc_html_e('فلسفه، منطق و حکمت', 'rashnubook'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/shop/?product_cat=poetry')); ?>"><?php esc_html_e('شعر کهن و دیوان‌های معاصر', 'rashnubook'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/shop/?product_cat=psychology')); ?>"><?php esc_html_e('روان‌شناسی و خودکاوی', 'rashnubook'); ?></a></li>
                    </ul>
                </div>

                <!-- Col 4: Contact & Newsletter -->
                <div class="footer-col">
                    <h4><?php esc_html_e('ارتباط با کتاب‌سرا', 'rashnubook'); ?></h4>
                    <p class="footer-desc" style="margin-bottom: 12px;">
                        <?php echo esc_html($address); ?>
                    </p>
                    <p style="font-size: 13.5px; color: #ffffff; margin-bottom: 8px;">
                        <strong><?php esc_html_e('تلفن:', 'rashnubook'); ?></strong> <?php echo esc_html($phone); ?>
                    </p>
                    <?php if (!empty($email)) : ?>
                        <p style="font-size: 13.5px; color: #ffffff; margin-bottom: 8px;">
                            <strong><?php esc_html_e('ایمیل:', 'rashnubook'); ?></strong> <?php echo esc_html($email); ?>
                        </p>
                    <?php endif; ?>
                    <?php if (!empty($ig_handle)) : ?>
                    <p style="font-size: 13.5px; color: #ffffff; margin-bottom: 16px;">
                        <strong>اینستاگرام:</strong> <a href="<?php echo esc_url($social_instagram); ?>" target="_blank" rel="noopener" style="color:var(--tertiary); font-weight:700;"><bdi dir="ltr">@<?php echo esc_html($ig_handle); ?></bdi></a>
                    </p>
                    <?php endif; ?>
                    <?php if (get_theme_mod('rashnubook_newsletter_enable', true)) : ?>
                    <div style="background: rgba(255,255,255,0.06); padding: 12px; border-radius: var(--radius-sm); border: 1px solid rgba(255,255,255,0.1);">
                        <span style="font-size: 12px; display: block; margin-bottom: 6px; color: #a5d0b9;"><?php echo esc_html(get_theme_mod('rashnubook_newsletter_title', 'عضویت در خبرنامه یادداشت‌های ادبی و حقوقی:')); ?></span>
                        <form class="rb-newsletter-form" style="display: flex; gap: 6px;" novalidate>
                            <input type="email" name="email" required placeholder="نشانی ایمیل..." style="flex:1; padding: 6px 10px; border-radius: 4px; border: none; font-size: 12px; outline: none; background: #fff; color: #1f2421; direction:ltr; text-align:left;">
                            <button type="submit" class="btn btn-tertiary" style="padding: 6px 12px; font-size: 12px; cursor:pointer;"><?php esc_html_e('ثبت', 'rashnubook'); ?></button>
                        </form>
                        <p class="rb-newsletter-msg" aria-live="polite"></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php
        $seals = function_exists('rashnubook_get_trust_seals') ? rashnubook_get_trust_seals() : array();
        $has_seals = !empty($seals['enamad']) || !empty($seals['samandehi']) || !empty($seals['custom']);
        if ($has_seals) :
        ?>
            <div class="footer-trust-seals" style="border-top: 1px solid rgba(255,255,255,0.08); padding: 18px 0; text-align: center;">
                <div class="container" style="display: flex; gap: 20px; justify-content: center; align-items: center; flex-wrap: wrap;">
                    <span style="font-size: 13px; color: #a5d0b9; font-weight: 600;">مجوزها و نمادهای اعتماد الکترونیکی:</span>
                    <?php if (!empty($seals['enamad'])) : ?>
                        <div class="trust-seal-item" style="background: #fff; padding: 6px 12px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center;">
                            <?php echo $seals['enamad']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($seals['samandehi'])) : ?>
                        <div class="trust-seal-item" style="background: #fff; padding: 6px 12px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center;">
                            <?php echo $seals['samandehi']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($seals['custom'])) : ?>
                        <div class="trust-seal-item" style="background: #fff; padding: 6px 12px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center;">
                            <?php echo $seals['custom']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="footer-bottom">
            <div class="container footer-bottom-inner">
                <div>
                    &copy; <?php echo esc_html(rashnubook_to_persian_numbers(date_i18n('Y'))); ?> <?php echo esc_html($copyright); ?>
                </div>
                <div style="display: flex; gap: 16px; align-items: center;">
                    <span>قالب سبک و اختصاصی رشنو بوک</span>
                    <span style="opacity: 0.3;">•</span>
                    <a href="<?php echo esc_url(home_url('/')); ?>" style="color: var(--tertiary);">rashnubook.ir</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- MOBILE APP-STYLE BOTTOM NAVIGATION BAR -->
    <nav class="rb-mobile-app-bar" aria-label="<?php esc_attr_e('ناوبری اپلیکیشن موبایل', 'rashnubook'); ?>">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="rb-app-nav-item <?php echo is_front_page() ? 'is-active' : ''; ?>">
            <span class="rb-app-nav-icon"><?php rashnubook_icon('book'); ?></span>
            <span><?php esc_html_e('خانه', 'rashnubook'); ?></span>
        </a>
        <a href="<?php echo esc_url(home_url('/#categories')); ?>" class="rb-app-nav-item" data-drawer-toggle="mobile-menu">
            <span class="rb-app-nav-icon"><?php rashnubook_icon('menu'); ?></span>
            <span><?php esc_html_e('دسته‌ها', 'rashnubook'); ?></span>
        </a>
        <button type="button" class="rb-app-nav-item" onclick="document.querySelector('.search-input')?.focus(); window.scrollTo({top:0, behavior:'smooth'});">
            <span class="rb-app-nav-icon"><?php rashnubook_icon('search'); ?></span>
            <span><?php esc_html_e('جستجو', 'rashnubook'); ?></span>
        </button>
        <?php if (class_exists('WooCommerce')) : ?>
            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="rb-app-nav-item <?php echo is_cart() ? 'is-active' : ''; ?>" data-drawer-toggle="mini-cart">
                <span class="rb-app-nav-icon">
                    <?php rashnubook_icon('cart'); ?>
                    <?php $cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
                    <?php if ($cart_count > 0) : ?>
                        <span class="rb-app-cart-badge"><?php echo esc_html(rashnubook_to_persian_numbers($cart_count)); ?></span>
                    <?php endif; ?>
                </span>
                <span><?php esc_html_e('سبد خرید', 'rashnubook'); ?></span>
            </a>
            <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="rb-app-nav-item <?php echo is_account_page() ? 'is-active' : ''; ?>">
                <span class="rb-app-nav-icon"><?php rashnubook_icon('user'); ?></span>
                <span><?php esc_html_e('حساب من', 'rashnubook'); ?></span>
            </a>
        <?php endif; ?>
    </nav>
</div><!-- #page -->

<script>
(function () {
    var form = document.querySelector('.rb-newsletter-form');
    if (!form) { return; }
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var msg = form.parentElement.querySelector('.rb-newsletter-msg');
        var email = form.querySelector('input[name="email"]').value.trim();
        if (!email) { return; }
        var data = new URLSearchParams();
        data.append('action', 'rashnubook_newsletter');
        data.append('nonce', window.rashnubook_ajax ? window.rashnubook_ajax.newsletter_nonce : '');
        data.append('email', email);
        fetch(window.rashnubook_ajax.ajax_url, { method: 'POST', body: data })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                if (msg) {
                    msg.textContent = (res && res.data && res.data.message) ? res.data.message : '';
                    msg.className = 'rb-newsletter-msg is-visible ' + (res && res.success ? 'is-success' : 'is-error');
                }
                if (res && res.success) { form.reset(); }
            })
            .catch(function () {
                if (msg) {
                    msg.textContent = 'خطا در برقراری ارتباط. لطفاً دوباره تلاش کنید.';
                    msg.className = 'rb-newsletter-msg is-visible is-error';
                }
            });
    });
})();
</script>

<?php wp_footer(); ?>
</body>
</html>
