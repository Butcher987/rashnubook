<?php
/**
 * Template Name: برگه تماس با ما (Contact Us)
 * The template for displaying the contact-us page
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// 1. Page Header Options
$page_title    = rashnubook_get_option('contact_title', 'تماس با کتابفروشی آنلاین رَشن');
$page_subtitle = rashnubook_get_option('contact_subtitle', 'مشاوران و همکاران ما در بخش پشتیبانی، فروش و مشاوره‌های حقوقی آماده پاسخگویی به پرسش‌ها و سفارش‌های شما هستند.');

// 2. Contact Info Options
$info_eyebrow  = rashnubook_get_option('contact_info_eyebrow', 'ارتباط با ما');
$info_title    = rashnubook_get_option('contact_info_title', 'اطلاعات تماس و نشانی فروشگاه');

$address_label = rashnubook_get_option('contact_address_label', 'نشانی دفتر مرکزی و کتابفروشی:');
$address_val   = rashnubook_get_option('contact_address_val', rashnubook_get_option('address', 'تهران، میدان انقلاب اسلامی، روبروی دانشگاه تهران، راسته ناشران و کتابفروشان، کتابفروشی آنلاین رَشن'));

$phone_label   = rashnubook_get_option('contact_phone_label', 'شماره تلفن تماس و سفارش تلفنی:');
$phone_val     = rashnubook_get_option('contact_phone_val', rashnubook_get_option('phone', '۰۲۱-۸۸۹۹۰۰۱۱'));
$phone_note    = rashnubook_get_option('contact_phone_note', '(۱۰ خط ویژه پاسخگویی)');

$email_label   = rashnubook_get_option('contact_email_label', 'رایانامه (ایمیل) اداری و سازمانی:');
$email_val     = rashnubook_get_option('contact_email_val', rashnubook_get_option('email', 'info@rashnubook.ir'));

$insta_label   = rashnubook_get_option('contact_instagram_label', 'صفحه رسمی اینستاگرام:');
$insta_val     = rashnubook_get_option('contact_instagram_val', '@' . ltrim(rashnubook_get_option('instagram', 'rashno_book'), '@'));
$insta_url     = rashnubook_get_option('contact_instagram_url', rashnubook_get_option('social_instagram', 'https://instagram.com/rashno_book'));

$hours_label   = rashnubook_get_option('contact_hours_label', 'ساعات کاری و پاسخگویی:');
$hours_val     = rashnubook_get_option('contact_hours_val', "شنبه تا چهارشنبه: ساعت ۹:۰۰ صبح الی ۲۰:۰۰ شب یکسره\nپنج‌شنبه‌ها: ساعت ۹:۰۰ صبح الی ۱۸:۰۰ عصر");

$notice_text   = rashnubook_get_option('contact_notice_text', '💡 سفارش‌های ثبت‌شده در سایت در تمام روزهای هفته به صورت خودکار پردازش و با پست پیشتاز ارسال می‌شوند.');

// 3. Contact Form Options
$form_eyebrow   = rashnubook_get_option('contact_form_eyebrow', 'فرم پیام مستقیم');
$form_title     = rashnubook_get_option('contact_form_title', 'ارسال پیام و استعلام عناوین کتاب');
$form_btn_text  = rashnubook_get_option('contact_form_btn_text', 'ارسال پیام به کارشناسان رشنو');
$form_success   = rashnubook_get_option('contact_form_success_msg', 'پیام شما با موفقیت به کتابفروشی آنلاین رَشن ارسال شد. همکاران ما به زودی با شما تماس خواهند گرفت.');
$form_subjects  = rashnubook_get_option('contact_form_subjects', "استعلام موجودی و سفارش کتاب‌های ناموجود\nمشاوره تخصصی منابع آزمون وکالت و قضاوت\nپیگیری وضعیت ارسال مرسوله پستی\nسایر پیشنهادها و پیام‌های عمومی");
$form_shortcode = rashnubook_get_option('contact_form_shortcode', '');

$subject_lines = array_filter(array_map('trim', explode("\n", $form_subjects)));
?>

<main id="primary" class="site-main section-padding" style="padding: 36px 0 70px;">
    <div class="container" style="max-width: 1140px; width: 100%;">
        
        <!-- Breadcrumb & Header -->
        <div class="contact-header-wrap" style="text-align: center; margin-bottom: 40px;">
            <nav aria-label="راهنمای مسیر" style="font-size: 13.5px; color: var(--charcoal-muted); margin-bottom: 12px;">
                <a href="<?php echo esc_url(home_url('/')); ?>" style="color: var(--primary); text-decoration: none;">خانه</a>
                <span style="margin: 0 8px; opacity: 0.4;">/</span>
                <span>تماس با ما</span>
            </nav>
            <?php if (!empty($page_title)) : ?>
                <h1 class="font-editorial-title" style="font-size: 32px; font-weight: 900; color: var(--mocha); margin-bottom: 10px;">
                    <?php echo esc_html($page_title); ?>
                </h1>
            <?php endif; ?>
            <?php if (!empty($page_subtitle)) : ?>
                <p style="font-size: 15px; color: var(--charcoal-muted); max-width: 600px; margin: 0 auto; line-height: 1.8;">
                    <?php echo esc_html($page_subtitle); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- 2-Column Grid (Right: Contact Info, Left: Inquiry Form) -->
        <div class="contact-cards-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px; align-items: stretch; direction: rtl;">
            
            <!-- Column 1 (RIGHT in RTL): Contact Information Card -->
            <div class="contact-info-card" style="background: #ffffff; border: 1px solid var(--border-editorial); border-radius: 18px; padding: clamp(1.5rem, 3vw, 2.5rem); box-shadow: 0 10px 30px rgba(59,47,47,0.05); display: flex; flex-direction: column;">
                <div style="border-bottom: 2px solid var(--border-subtle); padding-bottom: 16px; margin-bottom: 24px;">
                    <?php if (!empty($info_eyebrow)) : ?>
                        <span style="font-size: 12px; font-weight: 800; color: var(--terracotta); display: block; margin-bottom: 4px; letter-spacing: 0.5px;"><?php echo esc_html($info_eyebrow); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($info_title)) : ?>
                        <h2 style="font-size: 22px; font-weight: 900; color: var(--primary); margin: 0;">
                            <?php echo esc_html($info_title); ?>
                        </h2>
                    <?php endif; ?>
                </div>

                <div style="display: flex; flex-direction: column; gap: 20px; flex: 1;">
                    <!-- Address -->
                    <?php if (!empty($address_val)) : ?>
                        <div style="display: flex; gap: 14px; align-items: flex-start;">
                            <div style="width: 42px; height: 42px; border-radius: 10px; background: rgba(27,67,50,0.08); color: var(--primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 20px;">
                                📍
                            </div>
                            <div>
                                <strong style="display: block; font-size: 14.5px; color: var(--mocha); margin-bottom: 4px;"><?php echo esc_html($address_label); ?></strong>
                                <p style="margin: 0; font-size: 14px; line-height: 1.8; color: var(--charcoal-ink);">
                                    <?php echo esc_html($address_val); ?>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Phone -->
                    <?php if (!empty($phone_val)) : ?>
                        <div style="display: flex; gap: 14px; align-items: flex-start;">
                            <div style="width: 42px; height: 42px; border-radius: 10px; background: rgba(162,79,59,0.08); color: var(--terracotta); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 20px;">
                                📞
                            </div>
                            <div>
                                <strong style="display: block; font-size: 14.5px; color: var(--mocha); margin-bottom: 4px;"><?php echo esc_html($phone_label); ?></strong>
                                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9\+]/', '', $phone_val)); ?>" style="font-size: 17px; font-weight: 900; color: var(--primary); text-decoration: none; direction: ltr; display: inline-block;">
                                    <?php echo esc_html($phone_val); ?>
                                </a>
                                <?php if (!empty($phone_note)) : ?>
                                    <span style="font-size: 12.5px; color: var(--charcoal-muted); margin-right: 6px;"><?php echo esc_html($phone_note); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Email -->
                    <?php if (!empty($email_val)) : ?>
                        <div style="display: flex; gap: 14px; align-items: flex-start;">
                            <div style="width: 42px; height: 42px; border-radius: 10px; background: rgba(74,90,79,0.08); color: var(--secondary); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 20px;">
                                ✉️
                            </div>
                            <div>
                                <strong style="display: block; font-size: 14.5px; color: var(--mocha); margin-bottom: 4px;"><?php echo esc_html($email_label); ?></strong>
                                <a href="mailto:<?php echo esc_attr($email_val); ?>" style="font-size: 14.5px; font-weight: 700; color: var(--terracotta); text-decoration: none;">
                                    <?php echo esc_html($email_val); ?>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Instagram -->
                    <?php if (!empty($insta_val)) : ?>
                        <div style="display: flex; gap: 14px; align-items: flex-start;">
                            <div style="width: 42px; height: 42px; border-radius: 10px; background: rgba(225,48,108,0.08); color: #e1306c; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <?php rashnubook_icon('instagram'); ?>
                            </div>
                            <div>
                                <strong style="display: block; font-size: 14.5px; color: var(--mocha); margin-bottom: 4px;"><?php echo esc_html($insta_label); ?></strong>
                                <a href="<?php echo esc_url($insta_url); ?>" target="_blank" rel="noopener noreferrer" style="font-size: 15px; font-weight: 800; color: var(--primary); text-decoration: none; direction: ltr; display: inline-block;">
                                    <?php echo esc_html($insta_val); ?>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Working Hours -->
                    <?php if (!empty($hours_val)) : ?>
                        <div style="display: flex; gap: 14px; align-items: flex-start;">
                            <div style="width: 42px; height: 42px; border-radius: 10px; background: rgba(59,47,47,0.08); color: var(--mocha); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 20px;">
                                ⏰
                            </div>
                            <div>
                                <strong style="display: block; font-size: 14.5px; color: var(--mocha); margin-bottom: 4px;"><?php echo esc_html($hours_label); ?></strong>
                                <p style="margin: 0; font-size: 14px; color: var(--charcoal-ink); line-height: 1.7;">
                                    <?php echo nl2br(esc_html($hours_val)); ?>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($notice_text)) : ?>
                    <div style="margin-top: 24px; padding-top: 18px; border-top: 1px dashed var(--border-editorial); font-size: 12.5px; color: var(--charcoal-muted); line-height: 1.7;">
                        <?php echo esc_html($notice_text); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Column 2 (LEFT in RTL): Inquiry & Message Form Card -->
            <div class="contact-form-card" style="background: #ffffff; border: 1px solid var(--border-editorial); border-radius: 18px; padding: clamp(1.5rem, 3vw, 2.5rem); box-shadow: 0 10px 30px rgba(59,47,47,0.05); display: flex; flex-direction: column;">
                <div style="border-bottom: 2px solid var(--border-subtle); padding-bottom: 16px; margin-bottom: 24px;">
                    <?php if (!empty($form_eyebrow)) : ?>
                        <span style="font-size: 12px; font-weight: 800; color: var(--primary); display: block; margin-bottom: 4px; letter-spacing: 0.5px;"><?php echo esc_html($form_eyebrow); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($form_title)) : ?>
                        <h2 style="font-size: 22px; font-weight: 900; color: var(--mocha); margin: 0;">
                            <?php echo esc_html($form_title); ?>
                        </h2>
                    <?php endif; ?>
                </div>

                <?php if (!empty($form_shortcode)) : ?>
                    <div class="rb-custom-contact-form-wrap" style="flex:1;">
                        <?php echo do_shortcode($form_shortcode); ?>
                    </div>
                <?php else : ?>
                    <form onsubmit="alert('<?php echo esc_js($form_success); ?>'); this.reset(); return false;" style="display: flex; flex-direction: column; gap: 18px; flex: 1;">
                        <div>
                            <label style="display: block; font-size: 13.5px; font-weight: 700; color: var(--mocha); margin-bottom: 6px;">
                                نام و نام خانوادگی <span style="color: var(--terracotta);">*</span>
                            </label>
                            <input type="text" required placeholder="مثال: دکتر سهراب سپهری" style="width: 100%; min-height: 48px; padding: 10px 16px; border: 1px solid var(--border-editorial); border-radius: 10px; background: var(--paper); font-size: 14.5px; font-family: inherit; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary)';" onblur="this.style.borderColor='var(--border-editorial)';">
                        </div>

                        <div>
                            <label style="display: block; font-size: 13.5px; font-weight: 700; color: var(--mocha); margin-bottom: 6px;">
                                شماره تلفن همراه <span style="color: var(--terracotta);">*</span>
                            </label>
                            <input type="tel" required placeholder="۰۹۱۲۳۴۵۶۷۸۹" style="width: 100%; min-height: 48px; padding: 10px 16px; border: 1px solid var(--border-editorial); border-radius: 10px; background: var(--paper); font-size: 14.5px; font-family: inherit; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary)';" onblur="this.style.borderColor='var(--border-editorial)';">
                        </div>

                        <div>
                            <label style="display: block; font-size: 13.5px; font-weight: 700; color: var(--mocha); margin-bottom: 6px;">
                                موضوع پیام یا بخش مربوطه:
                            </label>
                            <select style="width: 100%; min-height: 48px; padding: 10px 16px; border: 1px solid var(--border-editorial); border-radius: 10px; background: var(--paper); font-size: 14px; font-family: inherit; outline: none;">
                                <?php if (!empty($subject_lines)) : ?>
                                    <?php foreach ($subject_lines as $sub) : ?>
                                        <option value="<?php echo esc_attr($sub); ?>"><?php echo esc_html($sub); ?></option>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <option value="inquiry">استعلام موجودی و سفارش کتاب‌های ناموجود</option>
                                    <option value="exam">مشاوره تخصصی منابع آزمون وکالت و قضاوت</option>
                                    <option value="tracking">پیگیری وضعیت ارسال مرسوله پستی</option>
                                    <option value="general">سایر پیشنهادها و پیام‌های عمومی</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div>
                            <label style="display: block; font-size: 13.5px; font-weight: 700; color: var(--mocha); margin-bottom: 6px;">
                                متن پیام یا مشخصات کتاب‌های درخواستی <span style="color: var(--terracotta);">*</span>
                            </label>
                            <textarea rows="5" required placeholder="نام کتاب، نویسنده، ویرایش مدنظر یا پرسش خود را شرح دهید..." style="width: 100%; padding: 12px 16px; border: 1px solid var(--border-editorial); border-radius: 10px; background: var(--paper); font-size: 14px; font-family: inherit; outline: none; resize: vertical; line-height: 1.8; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary)';" onblur="this.style.borderColor='var(--border-editorial)';"></textarea>
                        </div>

                        <div style="margin-top: auto; padding-top: 8px;">
                            <button type="submit" class="btn btn-primary" style="width: 100%; min-height: 50px; font-size: 15.5px; font-weight: 800; border-radius: 10px; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; box-shadow: 0 4px 14px rgba(27,67,50,0.2);">
                                <span><?php echo esc_html($form_btn_text); ?></span>
                            </button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>

        </div>

    </div>
</main>

<style>
@media (max-width: 860px) {
    .contact-cards-grid {
        grid-template-columns: 1fr !important;
        gap: 24px !important;
    }
}
</style>

<?php
get_footer();
