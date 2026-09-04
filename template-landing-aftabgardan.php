<?php
/**
 * Template Name: لندینگ پیج ماهنامه آفتابگردان (Aftabgardan Monthly)
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main landing-page-wrapper">
    <!-- Hero Section: Aftabgardan Monthly -->
    <section style="background: linear-gradient(135deg, #2D231E 0%, #3B2F2F 55%, #1F4D3A 100%); color:#ffffff; padding: 60px 0 80px; position:relative; overflow:hidden;">
        <div class="container" style="max-width: 1140px; position:relative; z-index:2;">
            <div style="display:grid; grid-template-columns: 1.2fr 0.8fr; gap:40px; align-items:center;">
                <div>
                    <span style="display:inline-flex; align-items:center; gap:8px; background:rgba(220,204,179,0.2); border:1px solid rgba(220,204,179,0.35); padding:4px 14px; border-radius:20px; font-size:12px; font-weight:700; color:#FFE5B4; margin-bottom:16px;">
                        <?php rashnubook_icon('star'); ?>
                        <span>نشریه تخصصی فرهنگ، نقد ادبی و اندیشه حقوقی • کتابفروشی آنلاین رَشن</span>
                    </span>
                    <h1 class="font-editorial-title" style="font-size: clamp(28px, 4vw, 42px); font-weight: 900; line-height: 1.3; color:#ffffff; margin-bottom: 16px;">
                        ماهنامه ادبی و فرهنگی «آفتابگردان»
                    </h1>
                    <p style="font-size: 17px; line-height: 1.9; color: #E8E2D5; margin-bottom: 24px;">
                        شماره دوازدهم (ویژه‌نامه تحلیلی پاییز و زمستان) | پرونده ویژه: «نسبت قانون و عدالت در آینه ادبیات داستانی معاصر ایران». ۱۸۰ صفحه نقد بی‌طرفانه، جستارهای تطبیقی و معرفی تازه‌های نشر با کاغذ بالکی و قطع رحلی نفیس.
                    </p>
                    <div style="display:flex; gap:14px; flex-wrap:wrap;">
                        <a href="#subscribe-plans" class="btn btn-primary" style="background:#FFE5B4; color:#2D231E; font-size:15.5px; font-weight:900; padding:14px 28px; border-radius:10px; border:none; box-shadow:0 8px 24px rgba(0,0,0,0.3);">
                            <?php rashnubook_icon('cart'); ?>
                            <span>سفارش و اشتراک سالانه ماهنامه</span>
                        </a>
                        <a href="#toc" class="btn btn-secondary" style="border:1.5px solid rgba(255,255,255,0.4); color:#fff; font-size:15px; font-weight:700; padding:14px 24px; border-radius:10px;">
                            <span>مشاهده فهرست مقالات شماره ۱۲</span>
                        </a>
                    </div>
                </div>

                <div style="display:flex; justify-content:center;">
                    <div class="tento-book-spine-mockup" style="width:260px; aspect-ratio:1/1.42; background: linear-gradient(135deg, #FAF7F2 0%, #EFE7D8 100%); color:#3B2F2F; border-right:6px solid #cfbe9f; box-shadow:-16px 24px 48px rgba(0,0,0,0.45); transform:rotate(-2deg);">
                        <div class="tento-mockup-inner">
                            <div style="display:flex; justify-content:space-between; font-size:11px; font-weight:800;">
                                <span style="background:#1F4D3A; color:#fff; padding:2px 8px; border-radius:4px;">شماره ۱۲</span>
                                <span style="color:#A56A4A;">سال دوم • زمستان</span>
                            </div>
                            <div style="text-align:center; padding: 24px 0;">
                                <div style="font-size:12px; color:#A56A4A; font-weight:800; letter-spacing:1px; margin-bottom:6px;">کتابفروشی آنلاین رَشن</div>
                                <h3 style="font-size:26px; font-weight:900; color:#1F4D3A; margin-bottom:10px; line-height:1.2;">آفتابگردان</h3>
                                <p style="font-size:12px; color:#64748b; line-height:1.6; max-width:180px; margin:0 auto;">
                                    فصلنامه تخصصی بازخوانی رمان‌های بزرگ و متون حقوقی
                                </p>
                            </div>
                            <div style="border-top:1px solid #DCCCB3; padding-top:10px; display:flex; justify-content:space-between; font-size:11px; color:#64748b;">
                                <span>مدیر مسئول: رادین</span>
                                <span>۱۸۰ صفحه بالکی</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Highlights Strip -->
    <section style="background:var(--ivory); border-bottom:1px solid var(--border-editorial); padding:24px 0;">
        <div class="container" style="max-width: 1140px;">
            <div style="display:grid; grid-template-columns: repeat(4, 1fr); gap:20px; text-align:center;">
                <div>
                    <strong style="display:block; font-size:16px; color:var(--mocha); font-weight:900;">کاغذ بالکی سوئدی</strong>
                    <span style="font-size:12.5px; color:var(--secondary);">بسیار سبک و دوستدار چشم حین مطالعه</span>
                </div>
                <div>
                    <strong style="display:block; font-size:16px; color:var(--mocha); font-weight:900;">ارسال رایگان پستی</strong>
                    <span style="font-size:12.5px; color:var(--secondary);">تحویل بسته‌بندی نفیس در سراسر کشور</span>
                </div>
                <div>
                    <strong style="display:block; font-size:16px; color:var(--mocha); font-weight:900;">ضمیمه صوتی و پادکست</strong>
                    <span style="font-size:12.5px; color:var(--secondary);">روایت صوتی گزیده مقالات و شعرها</span>
                </div>
                <div>
                    <strong style="display:block; font-size:16px; color:var(--mocha); font-weight:900;">تخفیف ویژه مشترکین</strong>
                    <span style="font-size:12.5px; color:var(--secondary);">۲۰٪ تخفیف دائمی خرید کتاب از رشنو بوک</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Editorial Note (سرمقاله رادین) -->
    <section class="section-padding" style="padding:60px 0;">
        <div class="container" style="max-width: 860px;">
            <div style="background:#ffffff; border:1px solid var(--border-editorial); border-radius:18px; padding:clamp(1.5rem, 3vw, 2.5rem); box-shadow:0 6px 24px rgba(59,47,47,0.04); margin-bottom:48px;">
                <div style="display:flex; align-items:center; gap:14px; margin-bottom:18px; border-bottom:1px solid var(--border-subtle); padding-bottom:14px;">
                    <div style="width:48px; height:48px; border-radius:50%; background:var(--primary); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:20px;">
                        ر
                    </div>
                    <div>
                        <h2 style="font-size:18px; font-weight:900; color:var(--mocha); margin:0;">سرمقاله مدیر مسئول: در ستایش خواندنِ بی‌شتاب</h2>
                        <span style="font-size:12px; color:var(--secondary);">به قلم: رادین (مدیر کتابفروشی آنلاین رَشن)</span>
                    </div>
                </div>
                <div style="font-size:15.5px; line-height:2.1; color:var(--charcoal-ink);">
                    <p>
                        در روزگاری که سرعت سرسام‌آور داده‌ها و روایت‌های کپسولی، مجالی برای تامل عمیق باقی نگذاشته است، «ماهنامه آفتابگردان» تلاشی است آگاهانه برای بازگشت به فضیلت تامل و غور در کلمات مکتوب. ما در رشنو بوک بر این باوریم که متون فاخر ادبی و آموزه‌های بنیادین حقوقی، دو بال پرواز جامعه به سوی دادگری، زیبایی و فرزانگی هستند.
                    </p>
                    <p style="margin-top:12px;">
                        در این شماره، اساتید برجسته حقوق و منتقدان چیره‌دست ادبیات، پیرامون مسئله «عدالت» و جلوه‌های آن در شاهکارهای داستانی ایران به گفتگو نشسته‌اند تا پیوند ناگسستنی ادب و قانون را به رخ کشند...
                    </p>
                </div>
            </div>

            <!-- Table of Contents (فهرست مطالب شماره ۱۲) -->
            <div id="toc" style="margin-bottom:54px;">
                <div style="text-align:center; margin-bottom:28px;">
                    <span style="font-size:13px; font-weight:800; color:var(--terracotta);">گزیده‌ای از محتوای این شماره</span>
                    <h2 class="font-editorial-title" style="font-size:26px; font-weight:900; color:var(--mocha); margin-top:4px;">
                        فهرست مقالات و عناوین پرونده ویژه
                    </h2>
                </div>

                <table class="shop_table" style="width:100%;">
                    <thead>
                        <tr>
                            <th style="width:15%;">بخش</th>
                            <th>عنوان مقاله / جستار تحلیلی</th>
                            <th style="width:25%;">نویسنده / مترجم</th>
                            <th style="width:15%; text-align:center;">صفحه</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>پرونده حقوق</strong></td>
                            <td>میراث جاودان دکتر ناصر کاتوزیان؛ از قواعد عمومی قراردادها تا فلسفه حقوق</td>
                            <td>دکتر فریبرز صمصامی</td>
                            <td style="text-align:center;">۱۲</td>
                        </tr>
                        <tr>
                            <td><strong>نقد رمان</strong></td>
                            <td>روان‌کاوی شخصیت ماکان و استاد نقاش در رمان چشم‌هایش بزرگ علوی</td>
                            <td>استاد مهرداد فرهنگ</td>
                            <td style="text-align:center;">۴۸</td>
                        </tr>
                        <tr>
                            <td><strong>شعر معاصر</strong></td>
                            <td>شهریار و زبان عاطفه؛ بررسی سوز و ساز غزل‌های معاصر آذربایجان</td>
                            <td>ثریا کریمی</td>
                            <td style="text-align:center;">۸۲</td>
                        </tr>
                        <tr>
                            <td><strong>متون فلسفی</strong></td>
                            <td>دروازه ورود به حکمت غرب؛ چگونه چنین گفت زرتشت نیچه را بخوانیم؟</td>
                            <td>کیوان اخوان</td>
                            <td style="text-align:center;">۱۱۴</td>
                        </tr>
                        <tr>
                            <td><strong>تازه‌های نشر</strong></td>
                            <td>بررسی تحلیلی کتب حقوق تجارت و آیین دادرسی مدنی چاپ پاییز</td>
                            <td>شورای تحریریه رشنو</td>
                            <td style="text-align:center;">۱۵۶</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Subscription Plans (پلن‌های اشتراک) -->
            <div id="subscribe-plans" style="margin-top:54px;">
                <div style="text-align:center; margin-bottom:32px;">
                    <span style="font-size:13px; font-weight:800; color:var(--terracotta);">پیوستن به حلقه خوانندگان آفتابگردان</span>
                    <h2 class="font-editorial-title" style="font-size:26px; font-weight:900; color:var(--mocha); margin-top:4px;">
                        تعرفه‌ها و پلن‌های اشتراک ماهنامه
                    </h2>
                </div>

                <div style="display:grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap:28px;">
                    <!-- Plan 1: Single Issue -->
                    <div style="background:#ffffff; border:1.5px solid var(--border-editorial); border-radius:18px; padding:32px 28px; text-align:center; box-shadow:0 4px 18px rgba(59,47,47,0.04); display:flex; flex-direction:column; justify-content:space-between;">
                        <div>
                            <span style="display:inline-block; padding:4px 12px; background:var(--ivory); color:var(--mocha); border-radius:12px; font-size:12px; font-weight:800; margin-bottom:12px;">خرید تک‌شماره</span>
                            <h3 style="font-size:20px; font-weight:900; color:var(--mocha); margin-bottom:12px;">شماره ۱۲ ماهنامه (چاپی)</h3>
                            <div style="font-size:24px; font-weight:900; color:var(--primary); margin:16px 0;">
                                <?php echo esc_html(rashnubook_to_persian_numbers('145000')); ?> تومان
                            </div>
                            <ul style="list-style:none; padding:0; margin:0 0 24px; font-size:13.5px; line-height:2.2; color:var(--charcoal-muted); text-align:right;">
                                <li>✓ ۱۸۰ صفحه کاغذ بالکی اعلا</li>
                                <li>✓ ارسال پستی رایگان به سراسر ایران</li>
                                <li>✓ دسترسی به پادکست و ضمیمه صوتی</li>
                            </ul>
                        </div>
                        <a href="<?php echo esc_url(home_url('/cart/?add-to-cart=812')); ?>" class="btn btn-primary" style="width:100%; padding:12px; font-size:14.5px; font-weight:800; border-radius:8px;">
                            سفارش نسخه چاپی شماره ۱۲
                        </a>
                    </div>

                    <!-- Plan 2: Annual VIP Subscription -->
                    <div style="background:#ffffff; border:2px solid var(--primary); border-radius:18px; padding:32px 28px; text-align:center; box-shadow:0 8px 30px rgba(31,77,58,0.12); position:relative; display:flex; flex-direction:column; justify-content:space-between;">
                        <span style="position:absolute; top:-12px; right:50%; transform:translateX(50%); background:var(--terracotta); color:#fff; font-size:11px; font-weight:800; padding:3px 14px; border-radius:12px;">
                            پیشنهاد ویژه مشترکین
                        </span>
                        <div>
                            <span style="display:inline-block; padding:4px 12px; background:rgba(31,77,58,0.1); color:var(--primary); border-radius:12px; font-size:12px; font-weight:800; margin-bottom:12px;">اشتراک ۱۲ ماهه (سالانه)</span>
                            <h3 style="font-size:20px; font-weight:900; color:var(--mocha); margin-bottom:12px;">اشتراک کامل چاپی + هدیه کتاب</h3>
                            <div style="font-size:24px; font-weight:900; color:var(--primary); margin:16px 0;">
                                <?php echo esc_html(rashnubook_to_persian_numbers('1450000')); ?> تومان
                            </div>
                            <ul style="list-style:none; padding:0; margin:0 0 24px; font-size:13.5px; line-height:2.2; color:var(--charcoal-muted); text-align:right;">
                                <li>✓ دریافت ماهانه ۱۲ شماره مجله با ارسال رایگان</li>
                                <li>✓ <strong>هدیه یک جلد کتاب نفیس ادبی یا حقوقی</strong> به انتخاب مشترک</li>
                                <li>✓ کارت عضویت طلایی باشگاه کتابفروشی آنلاین رَشن</li>
                                <li>✓ ۲۰٪ تخفیف دائمی بر روی تمامی کتاب‌های سایت</li>
                            </ul>
                        </div>
                        <a href="<?php echo esc_url(home_url('/cart/?add-to-cart=813')); ?>" class="btn btn-primary" style="width:100%; padding:12px; font-size:14.5px; font-weight:900; border-radius:8px; background:var(--primary);">
                            ثبت اشتراک سالانه طلایی
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
