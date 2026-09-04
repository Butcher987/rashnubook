<?php
/**
 * Template Name: برگه درباره ما (About Us)
 * The template for displaying the about-us page
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main">
    <!-- 1. HERO BANNER: Atmospheric Literary Editorial Banner -->
    <section class="about-hero-banner" style="background: linear-gradient(140deg, #1b4332 0%, #255842 55%, #16382a 100%); color: #FAF7F2; padding: clamp(48px, 6vw, 76px) 0 clamp(44px, 5vw, 68px); position: relative; overflow: hidden; border-bottom: 3px solid #cfbe9f;">
        <!-- Subtle Pattern Overlay -->
        <div style="position: absolute; inset: 0; opacity: 0.05; background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 24px 24px; pointer-events: none;"></div>
        
        <div class="container" style="max-width: 1080px; width: 100%; position: relative; z-index: 1;">
            <!-- Breadcrumbs in banner -->
            <nav aria-label="راهنمای مسیر" style="font-size: 13.5px; color: rgba(250, 247, 242, 0.7); margin-bottom: 18px;">
                <a href="<?php echo esc_url(home_url('/')); ?>" style="color: #FFE5B4; text-decoration: none;">خانه</a>
                <span style="margin: 0 8px; opacity: 0.5;">/</span>
                <span>درباره ما</span>
            </nav>

            <div style="max-width: 780px;">
                <span class="about-banner-badge" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 229, 180, 0.15); border: 1px solid rgba(255, 229, 180, 0.35); color: #FFE5B4; font-size: 13px; font-weight: 800; padding: 6px 14px; border-radius: 999px; margin-bottom: 16px;">
                    <?php rashnubook_icon('book'); ?>
                    <span>کتابفروشی آنلاین رَشن • راسته کتابفروشان دانشگاه تهران</span>
                </span>
                
                <h1 class="font-editorial-title" style="font-size: clamp(28px, 4vw, 44px); font-weight: 900; line-height: 1.35; margin-bottom: 16px; color: #FAF7F2;">
                    روایت کتابفروشی آنلاین رَشن
                </h1>
                
                <p style="font-size: clamp(15px, 1.8vw, 17.5px); line-height: 1.9; color: rgba(250, 247, 242, 0.9); margin: 0; font-weight: 300;">
                    پایگاهی برای شیفتگان اندیشه، ادبیات فاخر و منابع تخصصی حقوقی. ما متعهد به گزینش و عرضه معتبرترین آثار مکتوب، ویرایش دقیق، کاغذ مرغوب و ارسال رایگان کتاب به سراسر ایران هستیم.
                </p>
            </div>
        </div>
    </section>

    <!-- 2. STATS / KEY HIGHLIGHTS BAR -->
    <div style="background: #ffffff; border-bottom: 1px solid var(--border-subtle); padding: 24px 0; box-shadow: 0 4px 16px rgba(59,47,47,0.03);">
        <div class="container" style="max-width: 1080px; width: 100%;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; text-align: center;">
                <div style="padding: 10px;">
                    <div style="font-size: 26px; font-weight: 900; color: var(--primary); margin-bottom: 4px;">۱۵,۰۰۰+</div>
                    <div style="font-size: 13px; color: var(--charcoal-muted); font-weight: 600;">عنوان کتاب حقوقی و ادبی برگزیده</div>
                </div>
                <div style="padding: 10px;">
                    <div style="font-size: 26px; font-weight: 900; color: var(--terracotta); margin-bottom: 4px;">۱۰۰٪</div>
                    <div style="font-size: 13px; color: var(--charcoal-muted); font-weight: 600;">ضمانت اصالت نسخه و چاپ قانونی</div>
                </div>
                <div style="padding: 10px;">
                    <div style="font-size: 26px; font-weight: 900; color: var(--secondary); margin-bottom: 4px;">رایگان</div>
                    <div style="font-size: 13px; color: var(--charcoal-muted); font-weight: 600;">ارسال به تمام نقاط ایران بدون شرط</div>
                </div>
                <div style="padding: 10px;">
                    <div style="font-size: 26px; font-weight: 900; color: var(--mocha); margin-bottom: 4px;">ماهنامه</div>
                    <div style="font-size: 13px; color: var(--charcoal-muted); font-weight: 600;">انتشار نشریه تخصصی آفتابگردان</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. MAIN ABOUT CONTENT -->
    <div class="container" style="max-width: 980px; width: 100%; padding-top: 50px; padding-bottom: 70px;">
        
        <!-- Story & Philosophy -->
        <article style="background: #ffffff; border: 1px solid var(--border-editorial); border-radius: 20px; padding: clamp(24px, 4vw, 44px); box-shadow: 0 8px 30px rgba(59,47,47,0.04); margin-bottom: 36px; line-height: 2.1; font-size: 16px; color: var(--charcoal-ink);">
            
            <div style="margin-bottom: 28px;">
                <span style="font-size: 12.5px; font-weight: 800; color: var(--terracotta); display: block; margin-bottom: 6px;">فلسفه و نام رَشن</span>
                <h2 class="font-editorial-title" style="font-size: 24px; font-weight: 900; color: var(--mocha); margin: 0;">
                    رسالت و آرمان کتابفروشی آنلاین رَشن
                </h2>
            </div>

            <p style="margin-bottom: 20px;">
                کتابفروشی آنلاین رَشن با تکیه بر اصالت فرهنگی و تعهد به ژرفای اندیشه، در قلب راسته کتابفروشان خیابان انقلاب و دانشگاه تهران پایه‌گذاری شد. نام <strong>«رَشن»</strong> در فرهنگ و اساطیر کهن ایرانی، ایزد دادگری، عدالت و داوری راستین است؛ ایزدی که ترازوی سنجش حقیقت را در دست دارد و از هرگونه ناراستی به دور است.
            </p>
            <p style="margin-bottom: 28px;">
                از همین رو، بنیادین‌ترین رسالت کتابفروشی آنلاین رَشن بر دو محور اصیل استوار گشته است: <strong>نشر و عرضه معتبرترین منابع دانشگاهی و آزمونی حقوق</strong> و <strong>بازخوانی فاخرترین شاهکارهای ادبیات داستانی، فلسفه و شعر معاصر</strong>.
            </p>

            <!-- 2 Pillars Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin: 36px 0;">
                <div style="background: var(--paper); border: 1px solid var(--border-editorial); border-radius: 14px; padding: 24px;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        <span style="font-size: 22px;">⚖️</span>
                        <h3 style="font-size: 18px; font-weight: 800; color: var(--primary); margin: 0;">بخش کتب تخصصی حقوقی</h3>
                    </div>
                    <p style="font-size: 14px; line-height: 1.85; color: var(--charcoal-muted); margin: 0;">
                        مرجع جامع منابع دست‌اول آزمون‌های وکالت، قضاوت، سردفتری و ارشد حقوق با آخرین اصلاحات و تحریرهای قانونی. ارائه آثاری از استادان بنام حقوق ایران چون دکتر کاتوزیان، دکتر لنگرودی و دکتر شمس.
                    </p>
                </div>

                <div style="background: var(--paper); border: 1px solid var(--border-editorial); border-radius: 14px; padding: 24px;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        <span style="font-size: 22px;">📖</span>
                        <h3 style="font-size: 18px; font-weight: 800; color: var(--mocha); margin: 0;">شاهکارهای ادبی و فلسفه</h3>
                    </div>
                    <p style="font-size: 14px; line-height: 1.85; color: var(--charcoal-muted); margin: 0;">
                        گزینش فاخرترین رمان‌های کلاسیک و معاصر با بهترین ترجمه‌ها و معتبرترین ویراست‌ها، کتب فلسفی تألیفی و ترجمه، و دیوان‌های نفیس شاعران بزرگ با کاغذ باکیفیت و صحافی مقاوم.
                    </p>
                </div>
            </div>

            <div style="margin-top: 36px; padding-top: 28px; border-top: 2px solid var(--border-subtle);">
                <h3 style="font-size: 20px; font-weight: 900; color: var(--primary); margin-bottom: 18px;">
                    چرا کتابفروشی آنلاین رَشن انتخابی متمایز است؟
                </h3>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 14px;">
                    <li style="display: flex; gap: 12px; align-items: flex-start;">
                        <span style="color: var(--primary); font-weight: 900; font-size: 18px; line-height: 1.4;">✓</span>
                        <div>
                            <strong style="color: var(--mocha); font-size: 15.5px;">گزینش علمی و بی‌طرفانه آثار:</strong>
                            <span style="font-size: 14.5px; color: var(--charcoal-muted);"> تمامی کتاب‌های موجود در کتابفروشی از میان بهترین چاپ‌ها، باکیفیت‌ترین ترجمه‌ها و معتبرترین ویراست‌ها گلچین شده‌اند.</span>
                        </div>
                    </li>
                    <li style="display: flex; gap: 12px; align-items: flex-start;">
                        <span style="color: var(--primary); font-weight: 900; font-size: 18px; line-height: 1.4;">✓</span>
                        <div>
                            <strong style="color: var(--mocha); font-size: 15.5px;">ارسال کاملاً رایگان به تمام نقاط کشور:</strong>
                            <span style="font-size: 14.5px; color: var(--charcoal-muted);"> ما معتقدیم فاصله جغرافیایی نباید مانع دسترسی آزاد به کتاب‌های مرجع باشد؛ از این رو، تمامی بسته‌ها با بسته‌بندی نفیس و نشانک هدیه بدون هزینه پستی ارسال می‌شوند.</span>
                        </div>
                    </li>
                    <li style="display: flex; gap: 12px; align-items: flex-start;">
                        <span style="color: var(--primary); font-weight: 900; font-size: 18px; line-height: 1.4;">✓</span>
                        <div>
                            <strong style="color: var(--mocha); font-size: 15.5px;">انتشار ماهنامه تخصصی آفتابگردان:</strong>
                            <span style="font-size: 14.5px; color: var(--charcoal-muted);"> نشریه ماهانه نقد ادبی و حقوقی رَشن، بستری برای گفتگو و ارتباط مستمر میان خوانندگان، دانشجویان و استادان است.</span>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Footer of card: Management & CTA -->
            <div style="border-top: 1px dashed var(--border-editorial); padding-top: 24px; margin-top: 36px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 18px;">
                <div>
                    <strong style="display: block; font-size: 16.5px; color: var(--mocha);">مدیریت کتابفروشی آنلاین رَشن: رادین</strong>
                    <span style="font-size: 13px; color: var(--secondary);">پاسخگوی اهالی کتاب و جامعه حقوقی ایران</span>
                </div>
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn-primary" style="padding: 12px 24px; font-size: 14.5px; font-weight: 800; border-radius: 10px; text-decoration: none;">
                        مشاهده ویترین کتاب‌ها
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact-us/')); ?>" class="btn btn-secondary" style="padding: 12px 22px; font-size: 14.5px; font-weight: 700; border-radius: 10px; border: 1px solid var(--border-editorial); text-decoration: none;">
                        تماس با کتابفروشی
                    </a>
                </div>
            </div>

        </article>
    </div>
</main>

<?php
get_footer();
