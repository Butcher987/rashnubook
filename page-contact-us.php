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
            <h1 class="font-editorial-title" style="font-size: 32px; font-weight: 900; color: var(--mocha); margin-bottom: 10px;">
                تماس با کتابفروشی آنلاین رَشن
            </h1>
            <p style="font-size: 15px; color: var(--charcoal-muted); max-width: 600px; margin: 0 auto; line-height: 1.8;">
                مشاوران و همکاران ما در بخش پشتیبانی، فروش و مشاوره‌های حقوقی آماده پاسخگویی به پرسش‌ها و سفارش‌های شما هستند.
            </p>
        </div>

        <!-- 2-Column Grid (Right: Contact Info, Left: Inquiry Form) - Identical to Login/Register structure -->
        <div class="contact-cards-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px; align-items: stretch; direction: rtl;">
            
            <!-- Column 1 (RIGHT in RTL): Contact Information Card -->
            <div class="contact-info-card" style="background: #ffffff; border: 1px solid var(--border-editorial); border-radius: 18px; padding: clamp(1.5rem, 3vw, 2.5rem); box-shadow: 0 10px 30px rgba(59,47,47,0.05); display: flex; flex-direction: column;">
                <div style="border-bottom: 2px solid var(--border-subtle); padding-bottom: 16px; margin-bottom: 24px;">
                    <span style="font-size: 12px; font-weight: 800; color: var(--terracotta); display: block; margin-bottom: 4px; letter-spacing: 0.5px;">ارتباط با ما</span>
                    <h2 style="font-size: 22px; font-weight: 900; color: var(--primary); margin: 0;">
                        اطلاعات تماس و نشانی فروشگاه
                    </h2>
                </div>

                <div style="display: flex; flex-direction: column; gap: 20px; flex: 1;">
                    <!-- Address -->
                    <div style="display: flex; gap: 14px; align-items: flex-start;">
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: rgba(27,67,50,0.08); color: var(--primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 20px;">
                            📍
                        </div>
                        <div>
                            <strong style="display: block; font-size: 14.5px; color: var(--mocha); margin-bottom: 4px;">نشانی دفتر مرکزی و کتابفروشی:</strong>
                            <p style="margin: 0; font-size: 14px; line-height: 1.8; color: var(--charcoal-ink);">
                                تهران، میدان انقلاب اسلامی، روبروی دانشگاه تهران، راسته ناشران و کتابفروشان، کتابفروشی آنلاین رَشن
                            </p>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div style="display: flex; gap: 14px; align-items: flex-start;">
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: rgba(162,79,59,0.08); color: var(--terracotta); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 20px;">
                            📞
                        </div>
                        <div>
                            <strong style="display: block; font-size: 14.5px; color: var(--mocha); margin-bottom: 4px;">شماره تلفن تماس و سفارش تلفنی:</strong>
                            <a href="tel:02188990011" style="font-size: 17px; font-weight: 900; color: var(--primary); text-decoration: none; direction: ltr; display: inline-block;">
                                ۰۲۱-۸۸۹۹۰۰۱۱
                            </a>
                            <span style="font-size: 12.5px; color: var(--charcoal-muted); margin-right: 6px;">(۱۰ خط ویژه پاسخگویی)</span>
                        </div>
                    </div>

                    <!-- Email -->
                    <div style="display: flex; gap: 14px; align-items: flex-start;">
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: rgba(74,90,79,0.08); color: var(--secondary); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 20px;">
                            ✉️
                        </div>
                        <div>
                            <strong style="display: block; font-size: 14.5px; color: var(--mocha); margin-bottom: 4px;">رایانامه (ایمیل) اداری و سازمانی:</strong>
                            <a href="mailto:info@rashnubook.ir" style="font-size: 14.5px; font-weight: 700; color: var(--terracotta); text-decoration: none;">
                                info@rashnubook.ir
                            </a>
                        </div>
                    </div>

                    <!-- Instagram -->
                    <div style="display: flex; gap: 14px; align-items: flex-start;">
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: rgba(225,48,108,0.08); color: #e1306c; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <?php rashnubook_icon('instagram'); ?>
                        </div>
                        <div>
                            <strong style="display: block; font-size: 14.5px; color: var(--mocha); margin-bottom: 4px;">صفحه رسمی اینستاگرام:</strong>
                            <a href="https://instagram.com/rashno_book" target="_blank" rel="noopener noreferrer" style="font-size: 15px; font-weight: 800; color: var(--primary); text-decoration: none; direction: ltr; display: inline-block;">
                                @rashno_book
                            </a>
                        </div>
                    </div>

                    <!-- Working Hours -->
                    <div style="display: flex; gap: 14px; align-items: flex-start;">
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: rgba(59,47,47,0.08); color: var(--mocha); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 20px;">
                            ⏰
                        </div>
                        <div>
                            <strong style="display: block; font-size: 14.5px; color: var(--mocha); margin-bottom: 4px;">ساعات کاری و پاسخگویی:</strong>
                            <p style="margin: 0; font-size: 14px; color: var(--charcoal-ink); line-height: 1.7;">
                                شنبه تا چهارشنبه: ساعت ۹:۰۰ صبح الی ۲۰:۰۰ شب یکسره<br>
                                پنج‌شنبه‌ها: ساعت ۹:۰۰ صبح الی ۱۸:۰۰ عصر
                            </p>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 24px; padding-top: 18px; border-top: 1px dashed var(--border-editorial); font-size: 12.5px; color: var(--charcoal-muted); line-height: 1.7;">
                    💡 سفارش‌های ثبت‌شده در سایت در تمام روزهای هفته به صورت خودکار پردازش و با پست پیشتاز رایگان ارسال می‌شوند.
                </div>
            </div>

            <!-- Column 2 (LEFT in RTL): Inquiry & Message Form Card -->
            <div class="contact-form-card" style="background: #ffffff; border: 1px solid var(--border-editorial); border-radius: 18px; padding: clamp(1.5rem, 3vw, 2.5rem); box-shadow: 0 10px 30px rgba(59,47,47,0.05); display: flex; flex-direction: column;">
                <div style="border-bottom: 2px solid var(--border-subtle); padding-bottom: 16px; margin-bottom: 24px;">
                    <span style="font-size: 12px; font-weight: 800; color: var(--primary); display: block; margin-bottom: 4px; letter-spacing: 0.5px;">فرم پیام مستقیم</span>
                    <h2 style="font-size: 22px; font-weight: 900; color: var(--mocha); margin: 0;">
                        ارسال پیام و استعلام عناوین کتاب
                    </h2>
                </div>

                <form onsubmit="alert('پیام شما با موفقیت به کتابفروشی آنلاین رَشن ارسال شد. همکاران ما به زودی با شما تماس خواهند گرفت.'); this.reset(); return false;" style="display: flex; flex-direction: column; gap: 18px; flex: 1;">
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
                            <option value="inquiry">استعلام موجودی و سفارش کتاب‌های ناموجود</option>
                            <option value="exam">مشاوره تخصصی منابع آزمون وکالت و قضاوت</option>
                            <option value="tracking">پیگیری وضعیت ارسال مرسوله پستی</option>
                            <option value="general">سایر پیشنهادها و پیام‌های عمومی</option>
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
                            <span>ارسال پیام به کارشناسان رشنو</span>
                        </button>
                    </div>
                </form>
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
