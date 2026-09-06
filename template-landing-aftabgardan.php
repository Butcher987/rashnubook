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

// 1. Color Palette Options
$aftab_col_start     = rashnubook_get_option('aftabgardan_color_hero_start', '#2D231E');
$aftab_col_mid       = rashnubook_get_option('aftabgardan_color_hero_mid', '#3B2F2F');
$aftab_col_end       = rashnubook_get_option('aftabgardan_color_hero_end', '#1F4D3A');
$aftab_col_accent    = rashnubook_get_option('aftabgardan_color_accent', '#FFE5B4');
$aftab_col_primary   = rashnubook_get_option('aftabgardan_color_primary', '#1F4D3A');
$aftab_col_special   = rashnubook_get_option('aftabgardan_color_special', '#b83b26');
$aftab_col_card_text = rashnubook_get_option('aftabgardan_color_card_text', '#1e293b');

// 2. Hero Section Options
$aftab_hero_enable = rashnubook_get_option('aftabgardan_hero_enable', '1');
$aftabgardan_badge = rashnubook_get_option('aftabgardan_hero_badge', 'نشریه تخصصی فرهنگ، نقد ادبی و اندیشه حقوقی • کتابفروشی آنلاین رَشن');
$aftabgardan_title = rashnubook_get_option('aftabgardan_hero_title', 'ماهنامه ادبی و فرهنگی «آفتابگردان»');
$aftabgardan_desc  = rashnubook_get_option('aftabgardan_hero_desc', 'شماره دوازدهم (ویژه‌نامه تحلیلی پاییز و زمستان) | پرونده ویژه: «نسبت قانون و عدالت در آینه ادبیات داستانی معاصر ایران». ۱۸۰ صفحه نقد بی‌طرفانه، جستارهای تطبیقی و معرفی تازه‌های نشر با کاغذ بالکی و قطع رحلی نفیس.');
$aftab_btn1_text   = rashnubook_get_option('aftabgardan_hero_btn1_text', 'سفارش و اشتراک سالانه ماهنامه');
$aftab_btn1_url    = rashnubook_get_option('aftabgardan_hero_btn1_url', '#subscribe-plans');
$aftab_btn2_text   = rashnubook_get_option('aftabgardan_hero_btn2_text', 'مشاهده فهرست مقالات شماره ۱۲');
$aftab_btn2_url    = rashnubook_get_option('aftabgardan_hero_btn2_url', '#toc');

// 3. Mockup & Cover Options
$aftab_mockup_enable = rashnubook_get_option('aftabgardan_mockup_enable', '1');
$aftab_cover_img     = rashnubook_get_option('aftabgardan_cover_image', '');
$aftab_logo_img      = rashnubook_get_option('aftabgardan_logo_image', '');
$aftabgardan_issue   = rashnubook_get_option('aftabgardan_mockup_issue', 'شماره ۱۲');
$aftabgardan_season  = rashnubook_get_option('aftabgardan_mockup_season', 'سال دوم • زمستان');
$aftab_mockup_brand  = rashnubook_get_option('aftabgardan_mockup_brand', 'کتابفروشی آنلاین رَشن');
$aftab_mockup_title  = rashnubook_get_option('aftabgardan_mockup_title', 'آفتابگردان');
$aftab_mockup_desc   = rashnubook_get_option('aftabgardan_mockup_desc', 'فصلنامه تخصصی بازخوانی رمان‌های بزرگ و متون حقوقی');
$aftabgardan_editor  = rashnubook_get_option('aftabgardan_editor_name', 'شورای سردبیری رَشن بوک');
$aftabgardan_pages   = rashnubook_get_option('aftabgardan_mockup_pages', '۱۸۰ صفحه بالکی');

// 4. Highlights Strip Options
$aftab_hl_enable = rashnubook_get_option('aftabgardan_highlights_enable', '1');
$hl1_t = rashnubook_get_option('aftabgardan_hl1_title', 'کاغذ بالکی سوئدی');
$hl1_d = rashnubook_get_option('aftabgardan_hl1_desc', 'بسیار سبک و دوستدار چشم حین مطالعه');
$hl2_t = rashnubook_get_option('aftabgardan_hl2_title', 'ارسال پستی کتاب');
$hl2_d = rashnubook_get_option('aftabgardan_hl2_desc', 'تحویل بسته‌بندی نفیس در سراسر کشور');
$hl3_t = rashnubook_get_option('aftabgardan_hl3_title', 'ضمیمه صوتی و پادکست');
$hl3_d = rashnubook_get_option('aftabgardan_hl3_desc', 'روایت صوتی گزیده مقالات و شعرها');
$hl4_t = rashnubook_get_option('aftabgardan_hl4_title', 'تخفیف ویژه مشترکین');
$hl4_d = rashnubook_get_option('aftabgardan_hl4_desc', '۲۰٪ تخفیف دائمی خرید کتاب از رشنو بوک');

// 5. Editorial Note Options
$aftab_edit_enable = rashnubook_get_option('aftabgardan_editorial_enable', '1');
$edit_title  = rashnubook_get_option('aftabgardan_editorial_title', 'سرمقاله شورای سردبیری: در ستایش خواندنِ بی‌شتاب');
$edit_author = rashnubook_get_option('aftabgardan_editorial_author', 'شورای سردبیری کتابفروشی آنلاین رَشن');
$edit_avatar = rashnubook_get_option('aftabgardan_editorial_avatar', '');
$edit_text   = rashnubook_get_option('aftabgardan_editorial_text', '<p>در روزگاری که سرعت سرسام‌آور داده‌ها و روایت‌های کپسولی، مجالی برای تامل عمیق باقی نگذاشته است، «ماهنامه آفتابگردان» تلاشی است آگاهانه برای بازگشت به فضیلت تامل و غور در کلمات مکتوب. ما در رشنو بوک بر این باوریم که متون فاخر ادبی و آموزه‌های بنیادین حقوقی، دو بال پرواز جامعه به سوی دادگری، زیبایی و فرزانگی هستند.</p><p style="margin-top:12px;">در این شماره، اساتید برجسته حقوق و منتقدان چیره‌دست ادبیات، پیرامون مسئله «عدالت» و جلوه‌های آن در شاهکارهای داستانی ایران به گفتگو نشسته‌اند تا پیوند ناگسستنی ادب و قانون را به رخ کشند...</p>');

// 6. Table of Contents Options
$aftab_toc_enable = rashnubook_get_option('aftabgardan_toc_enable', '1');
$toc_eyebrow      = rashnubook_get_option('aftabgardan_toc_eyebrow', 'گزیده‌ای از محتوای این شماره');
$toc_title        = rashnubook_get_option('aftabgardan_toc_title', 'فهرست مقالات و عناوین پرونده ویژه');

$default_toc_rows = array(
    1 => array('section' => 'پرونده حقوق', 'title' => 'میراث جاودان دکتر ناصر کاتوزیان؛ از قواعد عمومی قراردادها تا فلسفه حقوق', 'author' => 'دکتر فریبرز صمصامی', 'page' => '۱۲'),
    2 => array('section' => 'نقد رمان', 'title' => 'روان‌کاوی شخصیت ماکان و استاد نقاش در رمان چشم‌هایش بزرگ علوی', 'author' => 'استاد مهرداد فرهنگ', 'page' => '۴۸'),
    3 => array('section' => 'شعر معاصر', 'title' => 'شهریار و زبان عاطفه؛ بررسی سوز و ساز غزل‌های معاصر آذربایجان', 'author' => 'ثریا کریمی', 'page' => '۸۲'),
    4 => array('section' => 'متون فلسفی', 'title' => 'دروازه ورود به حکمت غرب؛ چگونه چنین گفت زرتشت نیچه را بخوانیم؟', 'author' => 'کیوان اخوان', 'page' => '۱۱۴'),
    5 => array('section' => 'تازه‌های نشر', 'title' => 'بررسی تحلیلی کتب حقوق تجارت و آیین دادرسی مدنی چاپ پاییز', 'author' => 'شورای تحریریه رشنو', 'page' => '۱۵۶'),
    6 => array('section' => '', 'title' => '', 'author' => '', 'page' => ''),
    7 => array('section' => '', 'title' => '', 'author' => '', 'page' => ''),
    8 => array('section' => '', 'title' => '', 'author' => '', 'page' => ''),
);

$toc_rows = array();
for ($r = 1; $r <= 8; $r++) {
    $r_en = rashnubook_get_option("aftabgardan_toc_row_{$r}_enable", $r <= 5 ? '1' : '0');
    if ($r_en === '1' || $r_en === 1 || $r_en === true) {
        $sec = rashnubook_get_option("aftabgardan_toc_row_{$r}_section", $default_toc_rows[$r]['section'] ?? '');
        $tit = rashnubook_get_option("aftabgardan_toc_row_{$r}_title", $default_toc_rows[$r]['title'] ?? '');
        $aut = rashnubook_get_option("aftabgardan_toc_row_{$r}_author", $default_toc_rows[$r]['author'] ?? '');
        $pag = rashnubook_get_option("aftabgardan_toc_row_{$r}_page", $default_toc_rows[$r]['page'] ?? '');
        if (!empty($tit)) {
            $toc_rows[] = array('section' => $sec, 'title' => $tit, 'author' => $aut, 'page' => $pag);
        }
    }
}

// 7. Plans & Product Cards Options
$aftab_plans_enable = (rashnubook_get_option('aftabgardan_plans_enable', '1') !== '0' && rashnubook_get_option('aftabgardan_plans_enable', '1') !== 0 && !empty(rashnubook_get_option('aftabgardan_plans_enable', '1')));
$plans_eyebrow      = rashnubook_get_option('aftabgardan_plans_eyebrow', 'پیوستن به حلقه خوانندگان آفتابگردان');
$plans_title        = rashnubook_get_option('aftabgardan_plans_title', 'تعرفه‌ها و پلن‌های اشتراک ماهنامه');

// Card 1
$plan1_pid       = (int)rashnubook_get_option('aftabgardan_plan1_product_id', 0);
if (!$plan1_pid && function_exists('get_page_by_path')) {
    $fallback_p1 = get_page_by_path('aftabgardan-monthly-issue-12', OBJECT, 'product');
    if ($fallback_p1) {
        $plan1_pid = $fallback_p1->ID;
    }
}
$plan1_product   = ($plan1_pid && function_exists('wc_get_product')) ? wc_get_product($plan1_pid) : null;
$plan1_badge     = rashnubook_get_option('aftabgardan_plan1_badge', 'خرید تک‌شماره');
$plan1_title     = rashnubook_get_option('aftabgardan_plan1_title', $plan1_product ? $plan1_product->get_name() : 'شماره ۱۲ ماهنامه (چاپی)');
$plan1_price     = rashnubook_get_option('aftabgardan_plan1_price', $plan1_product ? $plan1_product->get_price() : '145000');
$plan1_old_price = rashnubook_get_option('aftabgardan_plan1_old_price', ($plan1_product && $plan1_product->is_on_sale()) ? $plan1_product->get_regular_price() : '');
$plan1_features  = rashnubook_get_option('aftabgardan_plan1_features', "۱۸۰ صفحه کاغذ بالکی اعلا\nارسال پستی به سراسر ایران\nدسترسی به پادکست و ضمیمه صوتی");
$plan1_btn_text  = rashnubook_get_option('aftabgardan_plan1_btn_text', 'سفارش نسخه چاپی شماره ۱۲');
$plan1_custom_url= rashnubook_get_option('aftabgardan_plan1_url', '');
if (!empty($plan1_custom_url)) {
    $plan1_url = $plan1_custom_url;
} elseif ($plan1_product) {
    $plan1_url = function_exists('wc_get_cart_url') ? add_query_arg('add-to-cart', $plan1_product->get_id(), wc_get_cart_url()) : $plan1_product->add_to_cart_url();
} else {
    $plan1_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
}
$plan1_lines     = array_filter(array_map('trim', explode("\n", $plan1_features)));

// Card 2
$plan2_pid       = (int)rashnubook_get_option('aftabgardan_plan2_product_id', 0);
if (!$plan2_pid && function_exists('get_page_by_path')) {
    $fallback_p2 = get_page_by_path('aftabgardan-annual-subscription', OBJECT, 'product');
    if ($fallback_p2) {
        $plan2_pid = $fallback_p2->ID;
    }
}
$plan2_product   = ($plan2_pid && function_exists('wc_get_product')) ? wc_get_product($plan2_pid) : null;
$plan2_ribbon_en = rashnubook_get_option('aftabgardan_plan2_ribbon_enable', '1');
$plan2_ribbon    = rashnubook_get_option('aftabgardan_plan2_ribbon', 'پیشنهاد ویژه مشترکین');
$plan2_badge     = rashnubook_get_option('aftabgardan_plan2_badge', 'اشتراک ۱۲ ماهه (سالانه)');
$plan2_title     = rashnubook_get_option('aftabgardan_plan2_title', $plan2_product ? $plan2_product->get_name() : 'اشتراک کامل چاپی + هدیه کتاب');
$plan2_price     = rashnubook_get_option('aftabgardan_plan2_price', $plan2_product ? $plan2_product->get_price() : '1450000');
$plan2_old_price = rashnubook_get_option('aftabgardan_plan2_old_price', ($plan2_product && $plan2_product->is_on_sale()) ? $plan2_product->get_regular_price() : '');
$plan2_features  = rashnubook_get_option('aftabgardan_plan2_features', "دریافت ماهانه ۱۲ شماره مجله با ارسال پستی\nهدیه یک جلد کتاب نفیس ادبی یا حقوقی به انتخاب مشترک\nکارت عضویت طلایی باشگاه کتابفروشی آنلاین رَشن\n۲۰٪ تخفیف دائمی بر روی تمامی کتاب‌های سایت");
$plan2_btn_text  = rashnubook_get_option('aftabgardan_plan2_btn_text', 'ثبت اشتراک سالانه طلایی');
$plan2_custom_url= rashnubook_get_option('aftabgardan_plan2_url', '');
if (!empty($plan2_custom_url)) {
    $plan2_url = $plan2_custom_url;
} elseif ($plan2_product) {
    $plan2_url = function_exists('wc_get_cart_url') ? add_query_arg('add-to-cart', $plan2_product->get_id(), wc_get_cart_url()) : $plan2_product->add_to_cart_url();
} else {
    $plan2_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
}
$plan2_lines     = array_filter(array_map('trim', explode("\n", $plan2_features)));
?>

<!-- Dynamic Color Palette & High Contrast Styles -->
<style>
:root {
  --aftab-hero-start: <?php echo esc_attr($aftab_col_start); ?>;
  --aftab-hero-mid: <?php echo esc_attr($aftab_col_mid); ?>;
  --aftab-hero-end: <?php echo esc_attr($aftab_col_end); ?>;
  --aftab-accent: <?php echo esc_attr($aftab_col_accent); ?>;
  --aftab-primary: <?php echo esc_attr($aftab_col_primary); ?>;
  --aftab-special: <?php echo esc_attr($aftab_col_special); ?>;
  --aftab-card-text: <?php echo esc_attr($aftab_col_card_text); ?>;
}

.landing-page-wrapper .aftab-hero-gradient {
  background: linear-gradient(135deg, var(--aftab-hero-start, #2D231E) 0%, var(--aftab-hero-mid, #3B2F2F) 55%, var(--aftab-hero-end, #1F4D3A) 100%);
}

.landing-page-wrapper .aftab-badge-accent {
  background: rgba(255, 255, 255, 0.12);
  border: 1px solid rgba(255, 255, 255, 0.25);
  color: var(--aftab-accent, #FFE5B4);
}

.landing-page-wrapper .btn-aftab-primary {
  background: var(--aftab-accent, #FFE5B4);
  color: #2D231E;
  font-size: 15.5px;
  font-weight: 900;
  padding: 14px 28px;
  border-radius: 10px;
  border: none;
  box-shadow: 0 8px 24px rgba(0,0,0,0.3);
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  transition: all 0.25s ease;
}

.landing-page-wrapper .btn-aftab-primary:hover {
  background: #ffffff;
  transform: translateY(-2px);
  box-shadow: 0 12px 28px rgba(0,0,0,0.35);
}

.landing-page-wrapper .btn-aftab-secondary {
  border: 1.5px solid rgba(255,255,255,0.45);
  color: #ffffff;
  font-size: 15px;
  font-weight: 700;
  padding: 14px 24px;
  border-radius: 10px;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  transition: all 0.25s ease;
}

.landing-page-wrapper .btn-aftab-secondary:hover {
  border-color: #ffffff;
  background: rgba(255,255,255,0.12);
}

/* High Contrast Card Styles */
.aftab-plan-feature-item {
  color: var(--aftab-card-text, #1e293b) !important;
  font-size: 14px;
  font-weight: 600;
  line-height: 2.2;
  display: flex;
  align-items: flex-start;
  gap: 10px;
  text-align: right;
  margin-bottom: 8px;
}

.aftab-check-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  font-size: 12px;
  font-weight: 900;
  flex-shrink: 0;
  margin-top: 5px;
}

.aftab-check-icon.primary {
  background: rgba(31, 77, 58, 0.12);
  color: var(--aftab-primary, #1F4D3A);
  border: 1px solid rgba(31, 77, 58, 0.25);
}

.aftab-check-icon.special {
  background: rgba(184, 59, 38, 0.12);
  color: var(--aftab-special, #b83b26);
  border: 1px solid rgba(184, 59, 38, 0.25);
}
</style>

<main id="primary" class="site-main landing-page-wrapper">

    <!-- 1. HERO SECTION: AFTABGARDAN MONTHLY -->
    <?php if ($aftab_hero_enable === '1') : ?>
        <section class="aftab-hero-gradient" style="color:#ffffff; padding: 64px 0 84px; position:relative; overflow:hidden;">
            <div class="container" style="max-width: 1140px; position:relative; z-index:2;">
                <div style="display:grid; grid-template-columns: 1.2fr 0.8fr; gap:44px; align-items:center;">
                    <div>
                        <?php if (!empty($aftabgardan_badge)) : ?>
                            <span class="aftab-badge-accent" style="display:inline-flex; align-items:center; gap:8px; padding:5px 16px; border-radius:20px; font-size:12.5px; font-weight:800; margin-bottom:18px;">
                                <?php rashnubook_icon('star'); ?>
                                <span><?php echo esc_html($aftabgardan_badge); ?></span>
                            </span>
                        <?php endif; ?>

                        <h1 class="font-editorial-title" style="font-size: clamp(28px, 4vw, 44px); font-weight: 900; line-height: 1.3; color:#ffffff; margin-bottom: 18px;">
                            <?php echo esc_html($aftabgardan_title); ?>
                        </h1>
                        <p style="font-size: 16.5px; line-height: 1.95; color: #E8E2D5; margin-bottom: 28px;">
                            <?php echo esc_html($aftabgardan_desc); ?>
                        </p>
                        <div style="display:flex; gap:14px; flex-wrap:wrap;">
                            <?php if (!empty($aftab_btn1_text) && ($aftab_plans_enable || ($aftab_btn1_url !== '#subscribe-plans' && $aftab_btn1_url !== '#order-now'))) : ?>
                                <a href="<?php echo esc_url($aftab_btn1_url); ?>" class="btn-aftab-primary">
                                    <?php rashnubook_icon('cart'); ?>
                                    <span><?php echo esc_html($aftab_btn1_text); ?></span>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($aftab_btn2_text)) : ?>
                                <a href="<?php echo esc_url($aftab_btn2_url); ?>" class="btn-aftab-secondary">
                                    <span><?php echo esc_html($aftab_btn2_text); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- 3D Book Mockup & Cover Card -->
                    <?php if ($aftab_mockup_enable === '1') : ?>
                        <div style="display:flex; justify-content:center;">
                            <div class="tento-book-spine-mockup" style="width:270px; aspect-ratio:1/1.42; background: linear-gradient(135deg, #FAF7F2 0%, #EFE7D8 100%); color:#1e293b; border-right:6px solid #cfbe9f; box-shadow:-16px 24px 48px rgba(0,0,0,0.5); transform:rotate(-2deg); border-radius:4px; overflow:hidden; position:relative;">
                                <?php if (!empty($aftab_cover_img)) : ?>
                                    <!-- Real Cover Image Display -->
                                    <div style="position:relative; width:100%; height:100%;">
                                        <img src="<?php echo esc_url($aftab_cover_img); ?>" alt="<?php echo esc_attr($aftabgardan_title); ?>" style="width:100%; height:100%; object-fit:cover; display:block;">
                                        <?php if (!empty($aftab_logo_img)) : ?>
                                            <div style="position:absolute; top:12px; right:12px; max-width:85px; background:rgba(255,255,255,0.92); padding:4px 8px; border-radius:6px; box-shadow:0 3px 12px rgba(0,0,0,0.25); backdrop-filter:blur(4px);">
                                                <img src="<?php echo esc_url($aftab_logo_img); ?>" alt="لوگوی نشریه" style="max-height:28px; width:auto; display:block;">
                                            </div>
                                        <?php endif; ?>
                                        <div style="position:absolute; bottom:12px; right:12px; left:12px; background:rgba(15,23,42,0.88); color:#ffffff; padding:7px 12px; border-radius:6px; font-size:11.5px; display:flex; justify-content:space-between; align-items:center; backdrop-filter:blur(6px); box-shadow:0 4px 14px rgba(0,0,0,0.35);">
                                            <span style="font-weight:900; color:var(--aftab-accent, #FFE5B4);"><?php echo esc_html($aftabgardan_issue); ?></span>
                                            <span style="font-size:11px; font-weight:700; color:#e2e8f0;"><?php echo esc_html($aftabgardan_season); ?></span>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <!-- Typographic Mockup with High Contrast & Logo Support -->
                                    <div class="tento-mockup-inner" style="padding:22px 18px; height:100%; display:flex; flex-direction:column; justify-content:space-between;">
                                        <div style="display:flex; justify-content:space-between; align-items:center; font-size:11.5px; font-weight:800;">
                                            <span style="background:var(--aftab-primary, #1F4D3A); color:#ffffff; padding:3px 10px; border-radius:4px;"><?php echo esc_html($aftabgardan_issue); ?></span>
                                            <span style="color:#78350f; font-weight:900;"><?php echo esc_html($aftabgardan_season); ?></span>
                                        </div>
                                        <div style="text-align:center; padding: 14px 0;">
                                            <?php if (!empty($aftab_logo_img)) : ?>
                                                <div style="margin-bottom:10px;">
                                                    <img src="<?php echo esc_url($aftab_logo_img); ?>" alt="لوگو" style="max-height:36px; width:auto; margin:0 auto; display:block;">
                                                </div>
                                            <?php endif; ?>
                                            <div style="font-size:12px; color:#78350f; font-weight:900; letter-spacing:0.5px; margin-bottom:6px;">
                                                <?php echo esc_html($aftab_mockup_brand); ?>
                                            </div>
                                            <h3 style="font-size:26px; font-weight:900; color:var(--aftab-primary, #1F4D3A); margin-bottom:10px; line-height:1.2;">
                                                <?php echo esc_html($aftab_mockup_title); ?>
                                            </h3>
                                            <p style="font-size:12.5px; font-weight:700; color:#0f172a; line-height:1.75; max-width:190px; margin:0 auto;">
                                                <?php echo esc_html($aftab_mockup_desc); ?>
                                            </p>
                                        </div>
                                        <div style="border-top:1.5px solid #cbd5e1; padding-top:10px; display:flex; justify-content:space-between; font-size:11px; font-weight:800; color:#1e293b;">
                                            <span>مدیر مسئول: <?php echo esc_html($aftabgardan_editor); ?></span>
                                            <span><?php echo esc_html($aftabgardan_pages); ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- 2. HIGHLIGHTS STRIP -->
    <?php if ($aftab_hl_enable === '1') : ?>
        <section style="background:var(--ivory, #FAF7F2); border-bottom:1px solid var(--border-editorial, #DCCCB3); padding:24px 0;">
            <div class="container" style="max-width: 1140px;">
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:20px; text-align:center;">
                    <div>
                        <strong style="display:block; font-size:16px; color:#0f172a; font-weight:900; margin-bottom:4px;"><?php echo esc_html($hl1_t); ?></strong>
                        <span style="font-size:13px; color:#475569; font-weight:600;"><?php echo esc_html($hl1_d); ?></span>
                    </div>
                    <div>
                        <strong style="display:block; font-size:16px; color:#0f172a; font-weight:900; margin-bottom:4px;"><?php echo esc_html($hl2_t); ?></strong>
                        <span style="font-size:13px; color:#475569; font-weight:600;"><?php echo esc_html($hl2_d); ?></span>
                    </div>
                    <div>
                        <strong style="display:block; font-size:16px; color:#0f172a; font-weight:900; margin-bottom:4px;"><?php echo esc_html($hl3_t); ?></strong>
                        <span style="font-size:13px; color:#475569; font-weight:600;"><?php echo esc_html($hl3_d); ?></span>
                    </div>
                    <div>
                        <strong style="display:block; font-size:16px; color:#0f172a; font-weight:900; margin-bottom:4px;"><?php echo esc_html($hl4_t); ?></strong>
                        <span style="font-size:13px; color:#475569; font-weight:600;"><?php echo esc_html($hl4_d); ?></span>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- 3. EDITORIAL NOTE & AUTHORS -->
    <section class="section-padding" style="padding:60px 0;">
        <div class="container" style="max-width: 880px;">

            <?php if ($aftab_edit_enable === '1') : ?>
                <div style="background:#ffffff; border:1px solid var(--border-editorial, #DCCCB3); border-radius:18px; padding:clamp(1.5rem, 3vw, 2.5rem); box-shadow:0 6px 24px rgba(59,47,47,0.06); margin-bottom:54px;">
                    <div style="display:flex; align-items:center; gap:16px; margin-bottom:20px; border-bottom:1px solid #e2e8f0; padding-bottom:16px;">
                        <?php if (!empty($edit_avatar)) : ?>
                            <div style="width:52px; height:52px; border-radius:50%; overflow:hidden; border:2px solid var(--aftab-primary, #1F4D3A); flex-shrink:0;">
                                <img src="<?php echo esc_url($edit_avatar); ?>" alt="<?php echo esc_attr($edit_author); ?>" style="width:100%; height:100%; object-fit:cover;">
                            </div>
                        <?php else : ?>
                            <div style="width:52px; height:52px; border-radius:50%; background:var(--aftab-primary, #1F4D3A); color:#ffffff; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:22px; flex-shrink:0;">
                                <?php echo esc_html(mb_substr($edit_author, 0, 1, "UTF-8")); ?>
                            </div>
                        <?php endif; ?>
                        <div>
                            <h2 style="font-size:19px; font-weight:900; color:#0f172a; margin:0 0 4px 0;"><?php echo esc_html($edit_title); ?></h2>
                            <span style="font-size:13px; font-weight:700; color:#64748b;">به قلم: <?php echo esc_html($edit_author); ?></span>
                        </div>
                    </div>
                    <div style="font-size:15.5px; line-height:2.2; color:#1e293b; font-weight:500;">
                        <?php echo wp_kses_post($edit_text); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- 4. TABLE OF CONTENTS -->
            <?php if ($aftab_toc_enable === '1' && !empty($toc_rows)) : ?>
                <div id="toc" style="margin-bottom:60px;">
                    <div style="text-align:center; margin-bottom:28px;">
                        <?php if (!empty($toc_eyebrow)) : ?>
                            <span style="font-size:13px; font-weight:800; color:var(--aftab-special, #b83b26); display:inline-block; margin-bottom:4px;">
                                <?php echo esc_html($toc_eyebrow); ?>
                            </span>
                        <?php endif; ?>
                        <h2 class="font-editorial-title" style="font-size:26px; font-weight:900; color:#0f172a; margin:0;">
                            <?php echo esc_html($toc_title); ?>
                        </h2>
                    </div>

                    <div style="overflow-x:auto; background:#ffffff; border-radius:14px; border:1px solid #e2e8f0; box-shadow:0 4px 18px rgba(0,0,0,0.03);">
                        <table class="shop_table" style="width:100%; margin:0; border:none;">
                            <thead>
                                <tr style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
                                    <th style="width:18%; padding:14px 18px; font-size:13px; font-weight:800; color:#334155;">بخش</th>
                                    <th style="padding:14px 18px; font-size:13px; font-weight:800; color:#334155;">عنوان مقاله / جستار تحلیلی</th>
                                    <th style="width:25%; padding:14px 18px; font-size:13px; font-weight:800; color:#334155;">نویسنده / مترجم</th>
                                    <th style="width:12%; text-align:center; padding:14px 18px; font-size:13px; font-weight:800; color:#334155;">صفحه</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($toc_rows as $row) : ?>
                                    <tr style="border-bottom:1px solid #f1f5f9; transition:background 0.2s ease;">
                                        <td style="padding:14px 18px; font-size:13.5px;"><strong style="color:var(--aftab-primary, #1F4D3A);"><?php echo esc_html($row['section']); ?></strong></td>
                                        <td style="padding:14px 18px; font-size:14px; font-weight:700; color:#0f172a; line-height:1.7;"><?php echo esc_html($row['title']); ?></td>
                                        <td style="padding:14px 18px; font-size:13.5px; color:#475569; font-weight:600;"><?php echo esc_html($row['author']); ?></td>
                                        <td style="text-align:center; padding:14px 18px; font-weight:800; color:var(--aftab-primary, #1F4D3A); font-size:14px;"><?php echo esc_html(rashnubook_to_persian_numbers($row['page'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <!-- 5. SUBSCRIPTION PLANS & PRODUCT CARDS (HIGH CONTRAST & FULLY CUSTOMIZABLE) -->
            <?php if ($aftab_plans_enable) : ?>
                <div id="subscribe-plans" style="margin-top:54px;">
                    <div style="text-align:center; margin-bottom:34px;">
                        <?php if (!empty($plans_eyebrow)) : ?>
                            <span style="font-size:13px; font-weight:800; color:var(--aftab-special, #b83b26); display:inline-block; margin-bottom:4px;">
                                <?php echo esc_html($plans_eyebrow); ?>
                            </span>
                        <?php endif; ?>
                        <h2 class="font-editorial-title" style="font-size:27px; font-weight:900; color:#0f172a; margin:0;">
                            <?php echo esc_html($plans_title); ?>
                        </h2>
                    </div>

                    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:28px; align-items:stretch;">
                        
                        <!-- Plan 1: Single Issue -->
                        <div class="aftabgardan-plan-card" style="background:#ffffff; border:1.5px solid #cbd5e1; border-radius:20px; padding:34px 28px; text-align:center; box-shadow:0 6px 20px rgba(0,0,0,0.04); display:flex; flex-direction:column; justify-content:space-between; transition:transform 0.25s ease, box-shadow 0.25s ease;">
                            <div>
                                <?php if (!empty($plan1_badge)) : ?>
                                    <span style="display:inline-block; padding:5px 14px; background:#f1f5f9; color:#1e293b; border-radius:12px; font-size:12.5px; font-weight:800; margin-bottom:14px; border:1px solid #cbd5e1;">
                                        <?php echo esc_html($plan1_badge); ?>
                                    </span>
                                <?php endif; ?>

                                <h3 style="font-size:21px; font-weight:900; color:#0f172a; margin-bottom:12px;">
                                    <?php echo esc_html($plan1_title); ?>
                                </h3>

                                <?php if (!empty($plan1_old_price)) : ?>
                                    <div style="font-size:14px; color:#94a3b8; text-decoration:line-through; font-weight:700; margin-top:4px;">
                                        <?php echo esc_html(rashnubook_to_persian_numbers($plan1_old_price)); ?> تومان
                                    </div>
                                <?php endif; ?>

                                <div style="font-size:26px; font-weight:900; color:var(--aftab-primary, #1F4D3A); margin:12px 0 22px;">
                                    <?php echo esc_html(rashnubook_to_persian_numbers($plan1_price)); ?> تومان
                                </div>

                                <ul style="list-style:none; padding:0; margin:0 0 28px; text-align:right;">
                                    <?php foreach ($plan1_lines as $feat) : ?>
                                        <li class="aftab-plan-feature-item">
                                            <span class="aftab-check-icon primary">✓</span>
                                            <span><?php echo wp_kses_post($feat); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <a href="<?php echo esc_url($plan1_url); ?>" 
                               class="btn btn-primary"
                               style="width:100%; padding:14px; font-size:15px; font-weight:800; border-radius:10px; background:#f8fafc; color:#0f172a; border:1.5px solid #cbd5e1; text-decoration:none; display:inline-block; text-align:center; transition:all 0.2s ease;">
                                <?php echo esc_html($plan1_btn_text); ?>
                            </a>
                        </div>

                        <!-- Plan 2: Annual VIP Subscription & Special Offer -->
                        <div class="aftabgardan-plan-card" style="background:#ffffff; border:2.5px solid var(--aftab-primary, #1F4D3A); border-radius:20px; padding:34px 28px; text-align:center; box-shadow:0 10px 36px rgba(31,77,58,0.14); position:relative; display:flex; flex-direction:column; justify-content:space-between; transition:transform 0.25s ease, box-shadow 0.25s ease;">
                            <?php if ($plan2_ribbon_en === '1' && !empty($plan2_ribbon)) : ?>
                                <span style="position:absolute; top:-14px; right:50%; transform:translateX(50%); background:var(--aftab-special, #b83b26); color:#ffffff; font-size:12px; font-weight:900; padding:4px 18px; border-radius:20px; box-shadow:0 4px 12px rgba(184,59,38,0.35); white-space:nowrap;">
                                    <?php echo esc_html($plan2_ribbon); ?>
                                </span>
                            <?php endif; ?>

                            <div>
                                <?php if (!empty($plan2_badge)) : ?>
                                    <span style="display:inline-block; padding:5px 14px; background:rgba(31,77,58,0.12); color:var(--aftab-primary, #1F4D3A); border-radius:12px; font-size:12.5px; font-weight:900; margin-bottom:14px; border:1px solid rgba(31,77,58,0.25);">
                                        <?php echo esc_html($plan2_badge); ?>
                                    </span>
                                <?php endif; ?>

                                <h3 style="font-size:21px; font-weight:900; color:#0f172a; margin-bottom:12px;">
                                    <?php echo esc_html($plan2_title); ?>
                                </h3>

                                <?php if (!empty($plan2_old_price)) : ?>
                                    <div style="font-size:14px; color:#94a3b8; text-decoration:line-through; font-weight:700; margin-top:4px;">
                                        <?php echo esc_html(rashnubook_to_persian_numbers($plan2_old_price)); ?> تومان
                                    </div>
                                <?php endif; ?>

                                <div style="font-size:26px; font-weight:900; color:var(--aftab-primary, #1F4D3A); margin:12px 0 22px;">
                                    <?php echo esc_html(rashnubook_to_persian_numbers($plan2_price)); ?> تومان
                                </div>

                                <ul style="list-style:none; padding:0; margin:0 0 28px; text-align:right;">
                                    <?php foreach ($plan2_lines as $feat) : ?>
                                        <li class="aftab-plan-feature-item">
                                            <span class="aftab-check-icon special">✓</span>
                                            <span><?php echo wp_kses_post($feat); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <a href="<?php echo esc_url($plan2_url); ?>" 
                               class="btn btn-primary"
                               style="width:100%; padding:14px; font-size:15px; font-weight:900; border-radius:10px; background:var(--aftab-primary, #1F4D3A); color:#ffffff; border:none; text-decoration:none; display:inline-block; text-align:center; box-shadow:0 6px 20px rgba(31,77,58,0.3); transition:all 0.2s ease;">
                                <?php echo esc_html($plan2_btn_text); ?>
                            </a>
                        </div>

                    </div>
                </div>
            <?php endif; ?>

        </div>
    </section>
</main>

<?php
get_footer();
