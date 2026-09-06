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

// 1. Hero Banner Options
$hero_enable = rashnubook_get_option('about_hero_enable', '1') !== '0';
$hero_badge  = rashnubook_get_option('about_hero_badge', 'کتابفروشی آنلاین رَشن • راسته کتابفروشان دانشگاه تهران');
$hero_title  = rashnubook_get_option('about_hero_title', 'روایت کتابفروشی آنلاین رَشن');
$hero_desc   = rashnubook_get_option('about_hero_desc', 'پایگاهی برای شیفتگان اندیشه، ادبیات فاخر و منابع تخصصی حقوقی. ما متعهد به گزینش و عرضه معتبرترین آثار مکتوب، ویرایش دقیق، کاغذ مرغوب و ارسال پستی کتاب به سراسر ایران هستیم.');

// 2. Stats Options
$stats_enable = rashnubook_get_option('about_stats_enable', '1') !== '0';
$stat1_num    = rashnubook_get_option('about_stat_1_num', '۱۵,۰۰۰+');
$stat1_text   = rashnubook_get_option('about_stat_1_text', 'عنوان کتاب حقوقی و ادبی برگزیده');
$stat2_num    = rashnubook_get_option('about_stat_2_num', '۱۰۰٪');
$stat2_text   = rashnubook_get_option('about_stat_2_text', 'ضمانت اصالت نسخه و چاپ قانونی');
$stat3_num    = rashnubook_get_option('about_stat_3_num', 'پستی');
$stat3_text   = rashnubook_get_option('about_stat_3_text', 'ارسال با پست پیشتاز به تمام نقاط کشور');
$stat4_num    = rashnubook_get_option('about_stat_4_num', 'ماهنامه');
$stat4_text   = rashnubook_get_option('about_stat_4_text', 'انتشار نشریه تخصصی آفتابگردان');

// 3. Story & Mission Options
$story_enable  = rashnubook_get_option('about_story_enable', '1') !== '0';
$story_eyebrow = rashnubook_get_option('about_story_eyebrow', 'فلسفه و نام رَشن');
$story_title   = rashnubook_get_option('about_story_title', 'رسالت و آرمان کتابفروشی آنلاین رَشن');
$story_p1      = rashnubook_get_option('about_story_p1', 'کتابفروشی آنلاین رَشن با تکیه بر اصالت فرهنگی و تعهد به ژرفای اندیشه، در قلب راسته کتابفروشان خیابان انقلاب و دانشگاه تهران پایه‌گذاری شد. نام «رَشن» در فرهنگ و اساطیر کهن ایرانی، ایزد دادگری، عدالت و داوری راستین است؛ ایزدی که ترازوی سنجش حقیقت را در دست دارد و از هرگونه ناراستی به دور است.');
$story_p2      = rashnubook_get_option('about_story_p2', 'از همین رو، بنیادین‌ترین رسالت کتابفروشی آنلاین رَشن بر دو محور اصیل استوار گشته است: نشر و عرضه معتبرترین منابع دانشگاهی و آزمونی حقوق و بازخوانی فاخرترین شاهکارهای ادبیات داستانی، فلسفه و شعر معاصر.');

// 4. Pillars Options
$pillars_enable = rashnubook_get_option('about_pillars_enable', '1') !== '0';
$pillar1_icon   = rashnubook_get_option('about_pillar1_icon', '⚖️');
$pillar1_title  = rashnubook_get_option('about_pillar1_title', 'بخش کتب تخصصی حقوقی');
$pillar1_desc   = rashnubook_get_option('about_pillar1_desc', 'مرجع جامع منابع دست‌اول آزمون‌های وکالت، قضاوت، سردفتری و ارشد حقوق با آخرین اصلاحات و تحریرهای قانونی. ارائه آثاری از استادان بنام حقوق ایران چون دکتر کاتوزیان، دکتر لنگرودی و دکتر شمس.');
$pillar2_icon   = rashnubook_get_option('about_pillar2_icon', '📖');
$pillar2_title  = rashnubook_get_option('about_pillar2_title', 'شاهکارهای ادبی و فلسفه');
$pillar2_desc   = rashnubook_get_option('about_pillar2_desc', 'گزینش فاخرترین رمان‌های کلاسیک و معاصر با بهترین ترجمه‌ها و معتبرترین ویراست‌ها، کتب فلسفی تألیفی و ترجمه، و دیوان‌های نفیس شاعران بزرگ با کاغذ باکیفیت و صحافی مقاوم.');

// 5. Why Choose Us Options
$features_enable = rashnubook_get_option('about_features_enable', '1') !== '0';
$features_title  = rashnubook_get_option('about_features_title', 'چرا کتابفروشی آنلاین رَشن انتخابی متمایز است؟');
$feat1_title     = rashnubook_get_option('about_feat1_title', 'گزینش علمی و بی‌طرفانه آثار:');
$feat1_desc      = rashnubook_get_option('about_feat1_desc', 'تمامی کتاب‌های موجود در کتابفروشی از میان بهترین چاپ‌ها، باکیفیت‌ترین ترجمه‌ها و معتبرترین ویراست‌ها گلچین شده‌اند.');
$feat2_title     = rashnubook_get_option('about_feat2_title', 'ارسال پستی به تمام نقاط کشور:');
$feat2_desc      = rashnubook_get_option('about_feat2_desc', 'ما معتقدیم فاصله جغرافیایی نباید مانع دسترسی آزاد به کتاب‌های مرجع باشد؛ از این رو، تمامی بسته‌ها با بسته‌بندی نفیس، مقاوم و نشانک هدیه از طریق پست پیشتاز به سراسر ایران ارسال می‌شوند.');
$feat3_title     = rashnubook_get_option('about_feat3_title', 'انتشار ماهنامه تخصصی آفتابگردان:');
$feat3_desc      = rashnubook_get_option('about_feat3_desc', 'نشریه ماهانه نقد ادبی و حقوقی رَشن، بستری برای گفتگو و ارتباط مستمر میان خوانندگان، دانشجویان و استادان است.');

// 6. Management & CTA Options
$manager_enable = rashnubook_get_option('about_manager_enable', '1') !== '0';
$manager_name   = rashnubook_get_option('about_manager_name', 'مدیریت کتابفروشی آنلاین رَشن: رادین');
$manager_role   = rashnubook_get_option('about_manager_role', 'پاسخگوی اهالی کتاب و جامعه حقوقی ایران');
$btn1_text      = rashnubook_get_option('about_btn1_text', 'مشاهده ویترین کتاب‌ها');
$btn1_url       = rashnubook_get_option('about_btn1_url', '');
if (empty($btn1_url) && class_exists('WooCommerce')) {
    $btn1_url = get_permalink(wc_get_page_id('shop'));
}
if (empty($btn1_url)) {
    $btn1_url = home_url('/shop/');
}

$btn2_text      = rashnubook_get_option('about_btn2_text', 'تماس با کتابفروشی');
$btn2_url       = rashnubook_get_option('about_btn2_url', '');
if (empty($btn2_url)) {
    $btn2_url = home_url('/contact-us/');
}
?>

<main id="primary" class="site-main">
    <?php if ($hero_enable) : ?>
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
                    <?php if (!empty($hero_badge)) : ?>
                        <span class="about-banner-badge" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 229, 180, 0.15); border: 1px solid rgba(255, 229, 180, 0.35); color: #FFE5B4; font-size: 13px; font-weight: 800; padding: 6px 14px; border-radius: 999px; margin-bottom: 16px;">
                            <?php rashnubook_icon('book'); ?>
                            <span><?php echo esc_html($hero_badge); ?></span>
                        </span>
                    <?php endif; ?>
                    
                    <?php if (!empty($hero_title)) : ?>
                        <h1 class="font-editorial-title" style="font-size: clamp(28px, 4vw, 44px); font-weight: 900; line-height: 1.35; margin-bottom: 16px; color: #FAF7F2;">
                            <?php echo esc_html($hero_title); ?>
                        </h1>
                    <?php endif; ?>
                    
                    <?php if (!empty($hero_desc)) : ?>
                        <p style="font-size: clamp(15px, 1.8vw, 17.5px); line-height: 1.9; color: rgba(250, 247, 242, 0.9); margin: 0; font-weight: 300;">
                            <?php echo esc_html($hero_desc); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($stats_enable) : ?>
        <!-- 2. STATS / KEY HIGHLIGHTS BAR -->
        <div style="background: #ffffff; border-bottom: 1px solid var(--border-subtle); padding: 24px 0; box-shadow: 0 4px 16px rgba(59,47,47,0.03);">
            <div class="container" style="max-width: 1080px; width: 100%;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; text-align: center;">
                    <div style="padding: 10px;">
                        <div style="font-size: 26px; font-weight: 900; color: var(--primary); margin-bottom: 4px;"><?php echo esc_html($stat1_num); ?></div>
                        <div style="font-size: 13px; color: var(--charcoal-muted); font-weight: 600;"><?php echo esc_html($stat1_text); ?></div>
                    </div>
                    <div style="padding: 10px;">
                        <div style="font-size: 26px; font-weight: 900; color: var(--terracotta); margin-bottom: 4px;"><?php echo esc_html($stat2_num); ?></div>
                        <div style="font-size: 13px; color: var(--charcoal-muted); font-weight: 600;"><?php echo esc_html($stat2_text); ?></div>
                    </div>
                    <div style="padding: 10px;">
                        <div style="font-size: 26px; font-weight: 900; color: var(--secondary); margin-bottom: 4px;"><?php echo esc_html($stat3_num); ?></div>
                        <div style="font-size: 13px; color: var(--charcoal-muted); font-weight: 600;"><?php echo esc_html($stat3_text); ?></div>
                    </div>
                    <div style="padding: 10px;">
                        <div style="font-size: 26px; font-weight: 900; color: var(--mocha); margin-bottom: 4px;"><?php echo esc_html($stat4_num); ?></div>
                        <div style="font-size: 13px; color: var(--charcoal-muted); font-weight: 600;"><?php echo esc_html($stat4_text); ?></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- 3. MAIN ABOUT CONTENT -->
    <div class="container" style="max-width: 980px; width: 100%; padding-top: 50px; padding-bottom: 70px;">
        
        <article style="background: #ffffff; border: 1px solid var(--border-editorial); border-radius: 20px; padding: clamp(24px, 4vw, 44px); box-shadow: 0 8px 30px rgba(59,47,47,0.04); margin-bottom: 36px; line-height: 2.1; font-size: 16px; color: var(--charcoal-ink);">
            
            <?php if ($story_enable) : ?>
                <!-- Story & Philosophy -->
                <div style="margin-bottom: 28px;">
                    <?php if (!empty($story_eyebrow)) : ?>
                        <span style="font-size: 12.5px; font-weight: 800; color: var(--terracotta); display: block; margin-bottom: 6px;"><?php echo esc_html($story_eyebrow); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($story_title)) : ?>
                        <h2 class="font-editorial-title" style="font-size: 24px; font-weight: 900; color: var(--mocha); margin: 0;">
                            <?php echo esc_html($story_title); ?>
                        </h2>
                    <?php endif; ?>
                </div>

                <?php if (!empty($story_p1)) : ?>
                    <p style="margin-bottom: 20px;">
                        <?php echo wp_kses_post($story_p1); ?>
                    </p>
                <?php endif; ?>
                <?php if (!empty($story_p2)) : ?>
                    <p style="margin-bottom: 28px;">
                        <?php echo wp_kses_post($story_p2); ?>
                    </p>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ($pillars_enable) : ?>
                <!-- 2 Pillars Grid -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin: 36px 0;">
                    <div style="background: var(--paper); border: 1px solid var(--border-editorial); border-radius: 14px; padding: 24px;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                            <?php if (!empty($pillar1_icon)) : ?><span style="font-size: 22px;"><?php echo esc_html($pillar1_icon); ?></span><?php endif; ?>
                            <h3 style="font-size: 18px; font-weight: 800; color: var(--primary); margin: 0;"><?php echo esc_html($pillar1_title); ?></h3>
                        </div>
                        <p style="font-size: 14px; line-height: 1.85; color: var(--charcoal-muted); margin: 0;">
                            <?php echo esc_html($pillar1_desc); ?>
                        </p>
                    </div>

                    <div style="background: var(--paper); border: 1px solid var(--border-editorial); border-radius: 14px; padding: 24px;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                            <?php if (!empty($pillar2_icon)) : ?><span style="font-size: 22px;"><?php echo esc_html($pillar2_icon); ?></span><?php endif; ?>
                            <h3 style="font-size: 18px; font-weight: 800; color: var(--mocha); margin: 0;"><?php echo esc_html($pillar2_title); ?></h3>
                        </div>
                        <p style="font-size: 14px; line-height: 1.85; color: var(--charcoal-muted); margin: 0;">
                            <?php echo esc_html($pillar2_desc); ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($features_enable) : ?>
                <!-- Why Choose Us -->
                <div style="margin-top: 36px; padding-top: 28px; border-top: 2px solid var(--border-subtle);">
                    <?php if (!empty($features_title)) : ?>
                        <h3 style="font-size: 20px; font-weight: 900; color: var(--primary); margin-bottom: 18px;">
                            <?php echo esc_html($features_title); ?>
                        </h3>
                    <?php endif; ?>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 14px;">
                        <li style="display: flex; gap: 12px; align-items: flex-start;">
                            <span style="color: var(--primary); font-weight: 900; font-size: 18px; line-height: 1.4;">✓</span>
                            <div>
                                <strong style="color: var(--mocha); font-size: 15.5px;"><?php echo esc_html($feat1_title); ?></strong>
                                <span style="font-size: 14.5px; color: var(--charcoal-muted);"> <?php echo esc_html($feat1_desc); ?></span>
                            </div>
                        </li>
                        <li style="display: flex; gap: 12px; align-items: flex-start;">
                            <span style="color: var(--primary); font-weight: 900; font-size: 18px; line-height: 1.4;">✓</span>
                            <div>
                                <strong style="color: var(--mocha); font-size: 15.5px;"><?php echo esc_html($feat2_title); ?></strong>
                                <span style="font-size: 14.5px; color: var(--charcoal-muted);"> <?php echo esc_html($feat2_desc); ?></span>
                            </div>
                        </li>
                        <li style="display: flex; gap: 12px; align-items: flex-start;">
                            <span style="color: var(--primary); font-weight: 900; font-size: 18px; line-height: 1.4;">✓</span>
                            <div>
                                <strong style="color: var(--mocha); font-size: 15.5px;"><?php echo esc_html($feat3_title); ?></strong>
                                <span style="font-size: 14.5px; color: var(--charcoal-muted);"> <?php echo esc_html($feat3_desc); ?></span>
                            </div>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($manager_enable) : ?>
                <!-- Footer of card: Management & CTA -->
                <div style="border-top: 1px dashed var(--border-editorial); padding-top: 24px; margin-top: 36px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 18px;">
                    <div>
                        <strong style="display: block; font-size: 16.5px; color: var(--mocha);"><?php echo esc_html($manager_name); ?></strong>
                        <span style="font-size: 13px; color: var(--secondary);"><?php echo esc_html($manager_role); ?></span>
                    </div>
                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        <?php if (!empty($btn1_text)) : ?>
                            <a href="<?php echo esc_url($btn1_url); ?>" class="btn btn-primary" style="padding: 12px 24px; font-size: 14.5px; font-weight: 800; border-radius: 10px; text-decoration: none;">
                                <?php echo esc_html($btn1_text); ?>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($btn2_text)) : ?>
                            <a href="<?php echo esc_url($btn2_url); ?>" class="btn btn-secondary" style="padding: 12px 22px; font-size: 14.5px; font-weight: 700; border-radius: 10px; border: 1px solid var(--border-editorial); text-decoration: none;">
                                <?php echo esc_html($btn2_text); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

        </article>
    </div>
</main>

<?php
get_footer();
