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

// Social media links
$social_instagram = rashnubook_get_option('social_instagram', 'https://instagram.com/rashno_book');
$social_telegram  = rashnubook_get_option('social_telegram', 'https://t.me/rashno_book');
$social_whatsapp  = rashnubook_get_option('social_whatsapp', '');
$social_bale      = rashnubook_get_option('social_bale', '');
$social_eitaa     = rashnubook_get_option('social_eitaa', '');
$social_x         = rashnubook_get_option('social_x', '');
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
                            <a href="<?php echo esc_url($social_instagram); ?>" target="_blank" rel="noopener" title="اینستاگرام" class="footer-social-btn" style="width:38px; height:38px; border-radius:10px; background:rgba(255,255,255,0.12); display:flex; align-items:center; justify-content:center; color:#ffffff; text-decoration:none; transition:all 0.25s;" onmouseover="this.style.background='#E1306C'; this.style.color='#fff';" onmouseout="this.style.background='rgba(255,255,255,0.12)'; this.style.color='#ffffff';">
                                <?php rashnubook_icon('instagram'); ?>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($social_telegram)) : ?>
                            <a href="<?php echo esc_url($social_telegram); ?>" target="_blank" rel="noopener" title="کانال تلگرام" class="footer-social-btn" style="width:38px; height:38px; border-radius:10px; background:rgba(255,255,255,0.12); display:flex; align-items:center; justify-content:center; color:#ffffff; text-decoration:none; transition:all 0.25s;" onmouseover="this.style.background='#229ED9'; this.style.color='#fff';" onmouseout="this.style.background='rgba(255,255,255,0.12)'; this.style.color='#ffffff';">
                                <?php rashnubook_icon('telegram'); ?>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($social_whatsapp)) : ?>
                            <a href="<?php echo esc_url($social_whatsapp); ?>" target="_blank" rel="noopener" title="واتساپ پشتیبانی" class="footer-social-btn" style="width:38px; height:38px; border-radius:10px; background:rgba(255,255,255,0.12); display:flex; align-items:center; justify-content:center; color:#ffffff; text-decoration:none; transition:all 0.25s;" onmouseover="this.style.background='#25D366'; this.style.color='#fff';" onmouseout="this.style.background='rgba(255,255,255,0.12)'; this.style.color='#ffffff';">
                                <?php rashnubook_icon('whatsapp'); ?>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($social_bale)) : ?>
                            <a href="<?php echo esc_url($social_bale); ?>" target="_blank" rel="noopener" title="پیام‌رسان بله" class="footer-social-btn" style="width:38px; height:38px; border-radius:10px; background:rgba(255,255,255,0.12); display:flex; align-items:center; justify-content:center; color:#ffffff; text-decoration:none; transition:all 0.25s;" onmouseover="this.style.background='#16B37E'; this.style.color='#fff';" onmouseout="this.style.background='rgba(255,255,255,0.12)'; this.style.color='#ffffff';">
                                <?php rashnubook_icon('bale'); ?>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($social_eitaa)) : ?>
                            <a href="<?php echo esc_url($social_eitaa); ?>" target="_blank" rel="noopener" title="پیام‌رسان ایتا" class="footer-social-btn" style="width:38px; height:38px; border-radius:10px; background:rgba(255,255,255,0.12); display:flex; align-items:center; justify-content:center; color:#ffffff; text-decoration:none; transition:all 0.25s;" onmouseover="this.style.background='#E86B1E'; this.style.color='#fff';" onmouseout="this.style.background='rgba(255,255,255,0.12)'; this.style.color='#ffffff';">
                                <?php rashnubook_icon('eitaa'); ?>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($social_x)) : ?>
                            <a href="<?php echo esc_url($social_x); ?>" target="_blank" rel="noopener" title="شبکه اجتماعی X" class="footer-social-btn" style="width:38px; height:38px; border-radius:10px; background:rgba(255,255,255,0.12); display:flex; align-items:center; justify-content:center; color:#ffffff; text-decoration:none; transition:all 0.25s;" onmouseover="this.style.background='#000000'; this.style.color='#fff';" onmouseout="this.style.background='rgba(255,255,255,0.12)'; this.style.color='#ffffff';">
                                <?php rashnubook_icon('x'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Col 2: Important Links (Dynamic & Editable) -->
                <?php
                $def_col2_links = array(
                    array('title' => 'صفحه اصلی کتاب‌سرا', 'url' => home_url('/')),
                    array('title' => 'ویترین و کاتالوگ کتاب‌ها', 'url' => class_exists('WooCommerce') ? wc_get_page_permalink('shop') : home_url('/shop/')),
                    array('title' => 'سبد خرید و تسویه', 'url' => class_exists('WooCommerce') ? wc_get_cart_url() : home_url('/cart/')),
                    array('title' => 'پیگیری و سوابق سفارش', 'url' => class_exists('WooCommerce') ? wc_get_account_endpoint_url('orders') : home_url('/my-account/orders/')),
                    array('title' => 'ماهنامه ادبی آفتابگردان', 'url' => home_url('/aftabgardan/')),
                    array('title' => 'درباره کتابفروشی آنلاین رَشن', 'url' => home_url('/about-us/')),
                    array('title' => 'تماس با ما و ساعات کاری', 'url' => home_url('/contact-us/')),
                );
                rashnubook_render_footer_column('col2', __('پیوندهای مهم', 'rashnubook'), $def_col2_links);
                ?>

                <!-- Col 3: Selected Topics (Dynamic & Editable) -->
                <?php
                $def_col3_links = array(
                    array('title' => 'کتب تخصصی حقوقی و آزمونی', 'url' => home_url('/shop/?product_cat=law-books')),
                    array('title' => 'شاهکارهای ادبیات داستانی و رمان', 'url' => home_url('/shop/?product_cat=fiction')),
                    array('title' => 'فلسفه، منطق و حکمت', 'url' => home_url('/shop/?product_cat=philosophy')),
                    array('title' => 'شعر کهن و دیوان‌های معاصر', 'url' => home_url('/shop/?product_cat=poetry')),
                    array('title' => 'روان‌شناسی و خودکاوی', 'url' => home_url('/shop/?product_cat=psychology')),
                );
                rashnubook_render_footer_column('col3', __('موضوعات برگزیده', 'rashnubook'), $def_col3_links);
                ?>

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
                    <?php
                    $footer_insta_user = rashnubook_get_option('instagram', 'rashno_book');
                    $newsletter_title  = rashnubook_get_option('footer_newsletter_title', 'عضویت در خبرنامه یادداشت‌های ادبی و حقوقی:');
                    $newsletter_enable = rashnubook_get_option('footer_newsletter_enable', '1') !== '0';
                    ?>
                    <?php if (!empty($social_instagram)) : ?>
                        <p style="font-size: 13.5px; color: #ffffff; margin-bottom: 16px;">
                            <strong>اینستاگرام:</strong> <a href="<?php echo esc_url($social_instagram); ?>" target="_blank" rel="noopener" style="color:var(--tertiary); font-weight:700;"><span dir="ltr">@<?php echo esc_html($footer_insta_user); ?></span></a>
                        </p>
                    <?php endif; ?>

                    <?php if ($newsletter_enable) : ?>
                        <div class="rb-newsletter-box" style="background: rgba(255,255,255,0.06); padding: 14px; border-radius: var(--radius-sm); border: 1px solid rgba(255,255,255,0.1);">
                            <span style="font-size: 12px; display: block; margin-bottom: 8px; color: #a5d0b9; font-weight:600;"><?php echo esc_html($newsletter_title); ?></span>
                            <form id="rashnu-newsletter-form" style="display: flex; gap: 6px; position:relative;">
                                <input type="email" id="rashnu-newsletter-email" name="email" required placeholder="نشانی ایمیل..." style="flex:1; padding: 7px 10px; border-radius: 4px; border: none; font-size: 12px; outline: none; background: #fff; color: #1f2421;">
                                <button type="submit" id="rashnu-newsletter-submit" class="btn btn-tertiary" style="padding: 7px 14px; font-size: 12px; border-radius: 4px; cursor: pointer; white-space: nowrap;"><?php esc_html_e('ثبت', 'rashnubook'); ?></button>
                            </form>
                            <div id="rashnu-newsletter-msg" style="margin-top: 8px; font-size: 11.5px; display: none; line-height: 1.5; border-radius: 4px; padding: 6px 8px;"></div>
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

<?php wp_footer(); ?>
</body>
</html>
