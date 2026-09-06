<?php
/**
 * The front page template for rashnubook.ir
 * Bento & Tento Modular Architecture:
 * - Dynamic Hero Slider with WooCommerce Book Selection
 * - Modular Category Cards Strip
 * - Dynamic Bento Product Rails (Autoplay 3s Carousel)
 * - Editorial Quote
 * - Promotional Aftabgardan Banner
 * - Literary Articles & Reviews
 * - Trust & Service Badges
 *
 * All elements are 100% customizable from the dedicated theme options panel.
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$shop_url = class_exists('WooCommerce') ? wc_get_page_permalink('shop') : '#categories';

// Master Visibility Toggles
$hero_enable       = rashnubook_get_option('hero_enable', '1') !== '0';
$hero_autoplay     = rashnubook_get_option('hero_autoplay', '1') !== '0' ? 'true' : 'false';
$hero_interval     = rashnubook_get_option('hero_interval', '6000');
$home_cats_enable  = rashnubook_get_option('home_cats_enable', '1') !== '0';
$home_rails_enable = rashnubook_get_option('home_rails_enable', '1') !== '0';
$home_quote_enable = rashnubook_get_option('home_quote_enable', '1') !== '0';
$home_banner_enable= rashnubook_get_option('home_banner_enable', '1') !== '0';
$home_blog_enable  = rashnubook_get_option('home_blog_enable', '1') !== '0';
$home_trust_enable = rashnubook_get_option('home_trust_enable', '1') !== '0';
?>

<main id="primary" class="site-main" style="padding: 24px 0 60px;">
    <div class="container">

        <!-- 1. TENTO-STYLE HERO SLIDER WITH BOOK SELECTION -->
        <?php
        if ($hero_enable) :
            $all_slides = function_exists('rashnubook_get_hero_slides') ? rashnubook_get_hero_slides() : array();
            $active_slides = array_filter($all_slides, static fn($s) => !empty($s['enabled']));
            if (empty($active_slides)) {
                $active_slides = array_slice($all_slides, 0, 1);
            }
            $active_slides = array_values($active_slides);
            $total_active = count($active_slides);
            $hero_slider_bg = rashnubook_get_option('hero_slider_bg', '');
            $slider_style   = $hero_slider_bg ? 'background-image: linear-gradient(135deg, rgba(18, 43, 32, 0.92) 0%, rgba(31, 77, 58, 0.88) 100%), url(' . esc_url($hero_slider_bg) . '); background-size: cover; background-position: center;' : '';
        ?>
            <section class="tento-hero-slider" data-hero-slider data-autoplay="<?php echo esc_attr($hero_autoplay); ?>" data-interval="<?php echo esc_attr($hero_interval); ?>" role="region" aria-label="<?php esc_attr_e('اسلایدر معرفی کتاب‌های برگزیده', 'rashnubook'); ?>" style="<?php echo esc_attr($slider_style); ?>">
                <div class="tento-hero-slides">
                    <?php foreach ($active_slides as $index => $slide) :
                        $is_first    = ($index === 0);
                        $buy_url     = !empty($slide['btn1_url']) ? $slide['btn1_url'] : $shop_url;
                        $slide_type  = !empty($slide['slide_type']) ? $slide['slide_type'] : 'content';
                        $bg_image    = !empty($slide['bg_image']) ? $slide['bg_image'] : '';
                        $banner_img  = !empty($slide['banner_image']) ? $slide['banner_image'] : '';
                        $banner_link = !empty($slide['banner_link']) ? $slide['banner_link'] : $buy_url;
                    ?>
                        <?php if ($slide_type === 'banner' && !empty($banner_img)) : ?>
                            <article class="tento-hero-slide tento-slide-banner <?php echo $is_first ? 'is-active' : ''; ?>" data-hero-slide aria-hidden="<?php echo $is_first ? 'false' : 'true'; ?>">
                                <a href="<?php echo esc_url($banner_link); ?>" class="tento-hero-banner-link" style="display:block; width:100%; height:100%; min-height:420px; overflow:hidden;">
                                    <img src="<?php echo esc_url($banner_img); ?>" alt="<?php echo esc_attr($slide['title']); ?>" style="width:100%; height:100%; object-fit:cover; display:block;">
                                </a>
                            </article>
                        <?php else :
                            $slide_bg_style = $bg_image ? 'background-image: linear-gradient(135deg, rgba(18, 43, 32, 0.90) 0%, rgba(31, 77, 58, 0.85) 100%), url(' . esc_url($bg_image) . '); background-size: cover; background-position: center;' : '';
                        ?>
                            <article class="tento-hero-slide <?php echo $is_first ? 'is-active' : ''; ?> <?php echo $bg_image ? 'has-bg-image' : ''; ?>" data-hero-slide aria-hidden="<?php echo $is_first ? 'false' : 'true'; ?>" style="<?php echo esc_attr($slide_bg_style); ?>">
                                <div class="tento-hero-grid">
                                    <div class="tento-hero-info">
                                        <?php if (!empty($slide['badge'])) : ?>
                                            <span class="tento-hero-badge">
                                                <?php rashnubook_icon('star'); ?>
                                                <span><?php echo esc_html($slide['badge']); ?></span>
                                            </span>
                                        <?php endif; ?>

                                        <h1 class="tento-hero-title"><?php echo esc_html($slide['title']); ?></h1>

                                        <?php if (!empty($slide['meta'])) : ?>
                                            <p class="tento-hero-meta"><?php echo esc_html($slide['meta']); ?></p>
                                        <?php endif; ?>

                                        <?php if (!empty($slide['desc'])) : ?>
                                            <p class="tento-hero-desc"><?php echo esc_html($slide['desc']); ?></p>
                                        <?php endif; ?>

                                        <?php if (!empty($slide['price'])) : ?>
                                            <div class="tento-hero-price-wrap">
                                                <?php if (!empty($slide['old_price']) && (float)$slide['old_price'] > (float)$slide['price']) : ?>
                                                    <span class="tento-hero-old-price"><?php echo esc_html(rashnubook_to_persian_numbers($slide['old_price'])); ?> تومان</span>
                                                <?php endif; ?>
                                                <span class="tento-hero-price"><?php echo esc_html(rashnubook_to_persian_numbers($slide['price'])); ?> تومان</span>
                                                <?php if (!empty($slide['discount'])) : ?>
                                                    <span class="tento-hero-discount-badge"><?php echo esc_html(rashnubook_to_persian_numbers($slide['discount'])); ?>٪ تخفیف ویژه</span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="tento-hero-actions">
                                            <?php if (!empty($slide['btn1_text'])) : ?>
                                                <a href="<?php echo esc_url($buy_url); ?>" class="tento-btn-primary">
                                                    <?php rashnubook_icon('cart'); ?>
                                                    <span><?php echo esc_html($slide['btn1_text']); ?></span>
                                                </a>
                                            <?php endif; ?>

                                            <?php if (!empty($slide['btn2_text']) && !empty($slide['btn2_url'])) : ?>
                                                <a href="<?php echo esc_url($slide['btn2_url']); ?>" class="tento-btn-secondary">
                                                    <span><?php echo esc_html($slide['btn2_text']); ?></span>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="tento-hero-visual">
                                        <?php
                                        if (function_exists('rashnubook_render_3d_book_mockup')) {
                                            rashnubook_render_3d_book_mockup(array(
                                                'cover_id'    => $slide['cover_id'] ?? 0,
                                                'custom_url'  => $slide['custom_image'] ?? '',
                                                'title'       => $slide['title'],
                                                'author'      => $slide['meta'],
                                                'bg_gradient' => $slide['bg_gradient'] ?? 'linear-gradient(135deg, #1F4D3A 0%, #153628 100%)',
                                                'spine_color' => $slide['spine_color'] ?? '#142c20',
                                                'edition'     => $slide['edition'] ?? 'چاپ نفیس',
                                                'pages'       => $slide['pages'] ?? '',
                                                'publisher'   => $slide['publisher'] ?? 'کتابفروشی آنلاین رَشن',
                                                'link'        => $buy_url,
                                            ));
                                        }
                                        ?>
                                    </div>
                                </div>
                            </article>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <!-- Controls -->
                <?php if ($total_active > 1) : ?>
                    <div class="tento-hero-controls">
                        <button type="button" class="tento-hero-arrow" data-hero-prev aria-label="<?php esc_attr_e('اسلاید قبلی', 'rashnubook'); ?>">‹</button>
                        <div class="tento-hero-dots">
                            <?php for ($d = 0; $d < $total_active; $d++) : ?>
                                <button type="button" class="tento-hero-dot <?php echo $d === 0 ? 'is-active' : ''; ?>" data-hero-dot="<?php echo $d; ?>" aria-label="<?php echo esc_attr(sprintf(__('اسلاید %s', 'rashnubook'), rashnubook_to_persian_numbers($d + 1))); ?>"></button>
                            <?php endfor; ?>
                        </div>
                        <button type="button" class="tento-hero-arrow" data-hero-next aria-label="<?php esc_attr_e('اسلاید بعدی', 'rashnubook'); ?>">›</button>
                    </div>
                <?php endif; ?>
            </section>
        <?php endif; ?>


        <!-- 2. CATEGORY CARDS STRIP (ویترین موضوعی رشنو) -->
        <?php
        if ($home_cats_enable) :
            $cats_eyebrow = rashnubook_get_option('home_cats_eyebrow', 'ویترین موضوعی رشنو');
            $cats_title   = rashnubook_get_option('home_cats_title', 'دسته‌بندی‌های تخصصی کتاب‌سرا');
            $cats_link_t  = rashnubook_get_option('home_cats_link_text', 'مشاهده همه دسته‌ها');
            $cats_link_u  = rashnubook_get_option('home_cats_link_url', '');
            if (empty($cats_link_u)) {
                $cats_link_u = $shop_url;
            }
            $active_cards = function_exists('rashnubook_get_active_category_cards') ? rashnubook_get_active_category_cards() : array();
        ?>
            <section class="tento-cat-section" id="categories" aria-label="<?php esc_attr_e('دسته‌بندی‌های کتاب', 'rashnubook'); ?>">
                <div class="tento-section-header">
                    <div>
                        <?php if ($cats_eyebrow) : ?><span class="tento-eyebrow"><?php echo esc_html($cats_eyebrow); ?></span><?php endif; ?>
                        <h2 class="tento-section-title"><?php echo esc_html($cats_title); ?></h2>
                    </div>
                    <?php if ($cats_link_t) : ?>
                        <a href="<?php echo esc_url($cats_link_u); ?>" class="tento-view-all">
                            <?php echo esc_html($cats_link_t); ?>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="tento-cat-grid">
                    <?php foreach ($active_cards as $ccard) :
                        $card_url = !empty($ccard['url']) ? $ccard['url'] : (!empty($ccard['slug']) ? add_query_arg('product_cat', $ccard['slug'], $shop_url) : $shop_url);
                    ?>
                        <a href="<?php echo esc_url($card_url); ?>" class="tento-cat-card">
                            <div class="tento-cat-icon">
                                <?php rashnubook_icon($ccard['icon'] ?: 'book'); ?>
                            </div>
                            <div class="tento-cat-title"><?php echo esc_html($ccard['title']); ?></div>
                            <?php if (!empty($ccard['count'])) : ?>
                                <div class="tento-cat-count"><?php echo esc_html(rashnubook_to_persian_numbers($ccard['count'])); ?></div>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>


        <!-- 3. TENTO-STYLE CATEGORY PRODUCT RAILS (Bento Rails) -->
        <?php
        if ($home_rails_enable && class_exists('WooCommerce')) :
            $rails = function_exists('rashnubook_get_homepage_rails') ? rashnubook_get_homepage_rails() : array();
            $active_rails = array_filter($rails, static fn($r) => !empty($r['enabled']));

            foreach ($active_rails as $rail) :
                $r_cat   = !empty($rail['cat']) ? trim($rail['cat']) : '';
                $r_count = !empty($rail['count']) ? (int)$rail['count'] : 8;
                if ($r_count <= 0 || $r_count > 8) {
                    $r_count = 8;
                }
                $r_order = !empty($rail['orderby']) ? $rail['orderby'] : 'date';
                $r_link  = !empty($rail['link_url']) ? $rail['link_url'] : ($r_cat ? add_query_arg('product_cat', rawurlencode(urldecode($r_cat)), $shop_url) : $shop_url);
                $r_text  = !empty($rail['link_text']) ? $rail['link_text'] : 'مشاهده همه';
            ?>
                <section class="lg-category-rail" data-product-rail data-interval="3000" aria-label="<?php echo esc_attr($rail['title']); ?>">
                    <div class="lg-category-rail__heading">
                        <div>
                            <?php if (!empty($rail['eyebrow'])) : ?>
                                <span class="rail-eyebrow"><?php echo esc_html($rail['eyebrow']); ?></span>
                            <?php endif; ?>
                            <h3 class="rail-title"><?php echo esc_html($rail['title']); ?></h3>
                        </div>
                        <div class="lg-category-rail__actions">
                            <a href="<?php echo esc_url($r_link); ?>" class="rail-link-all"><?php echo esc_html($r_text); ?></a>
                            <button type="button" data-rail-prev aria-label="محصول قبلی">‹</button>
                            <button type="button" data-rail-next aria-label="محصول بعدی">›</button>
                        </div>
                    </div>
                    <div class="lg-category-rail__track" data-rail-track>
                        <?php
                        if (!empty($r_cat)) {
                            // Support both slug format and decode for Persian WooCommerce slugs
                            $r_cat_clean = urldecode($r_cat);
                            echo do_shortcode(sprintf('[products category="%s" limit="%d" orderby="%s" columns="4"]', esc_attr($r_cat_clean), $r_count, esc_attr($r_order)));
                        } else {
                            echo do_shortcode(sprintf('[products limit="%d" orderby="%s" columns="4"]', $r_count, esc_attr($r_order)));
                        }
                        ?>
                    </div>
                </section>
            <?php endforeach; ?>
        <?php endif; ?>


        <!-- 4. EDITORIAL QUOTE -->
        <?php
        if ($home_quote_enable) :
            $q_text   = rashnubook_get_option('quote_text', 'کتاب، پناهگاهی امن در برابر هیاهوی جهان و دریچه‌ای گشوده رو به جاودانگی اندیشه بشری است.');
            $q_author = rashnubook_get_option('quote_author', 'شورای سردبیری و هیئت علمی رَشن');
        ?>
            <div style="margin: 40px 0;">
                <?php echo do_shortcode('[rashnubook_quote text="' . esc_attr($q_text) . '" author="' . esc_attr($q_author) . '"]'); ?>
            </div>
        <?php endif; ?>


        <!-- 5. BANNER: AFTABGARDAN MONTHLY JOURNAL -->
        <?php
        if ($home_banner_enable) :
            $b_badge     = rashnubook_get_option('home_banner_badge', 'نشریه اختصاصی کتابفروشی آنلاین رَشن • شماره دوازدهم');
            $b_title     = rashnubook_get_option('home_banner_title', 'ماهنامه ادبی و فرهنگی «آفتابگردان»');
            $b_desc      = rashnubook_get_option('home_banner_desc', 'پرونده ویژه شماره جدید: «نسبت قانون، اخلاق و عدالت در ادبیات داستانی معاصر». با مقالاتی از برجسته‌ترین استادان حقوق و منتقدان ادبی، کاغذ بالکی سوئدی و ضمیمه صوتی اختصاصی.');
            $b_btn1_t    = rashnubook_get_option('home_banner_btn1_text', 'ورود به صفحه ماهنامه و سفارش نسخه چاپی');
            $b_btn1_u    = rashnubook_get_option('home_banner_btn1_url', home_url('/aftabgardan/'));
            $b_btn2_t    = rashnubook_get_option('home_banner_btn2_text', 'پلن‌های اشتراک سالانه');
            $b_btn2_u    = rashnubook_get_option('home_banner_btn2_url', home_url('/aftabgardan/#subscribe-plans'));
            $b_card_b    = rashnubook_get_option('home_banner_card_badge', 'شماره ۱۲ • بهار ۱۴۰۵');
            $b_card_t    = rashnubook_get_option('home_banner_card_title', 'آفتابگردان');
            $b_card_d    = rashnubook_get_option('home_banner_card_desc', 'ویژه‌نامه «تحلیل حقوقی و فلسفی آثار هدایت، ساعدی و دانشور» با همکاری استادان دانشگاه تهران.');
            $b_card_f    = rashnubook_get_option('home_banner_card_footer', 'قطع رقعی • ۹۶ صفحه • کاغذ نخودی ۷۰ گرم');
            $aftab_cover_img = rashnubook_get_option('aftabgardan_cover_image', '');
            $aftab_logo_img  = rashnubook_get_option('aftabgardan_logo_image', '');
        ?>
            <section class="tento-aftabgardan-banner" aria-label="<?php esc_attr_e('ماهنامه ادبی آفتابگردان', 'rashnubook'); ?>">
                <div class="aftabgardan-grid">
                    <div>
                        <?php if ($b_badge) : ?>
                            <span class="aftabgardan-badge">
                                <?php rashnubook_icon('star'); ?>
                                <span><?php echo esc_html($b_badge); ?></span>
                            </span>
                        <?php endif; ?>

                        <h2 class="aftabgardan-title"><?php echo esc_html($b_title); ?></h2>
                        <p class="aftabgardan-desc"><?php echo esc_html($b_desc); ?></p>

                        <div class="aftabgardan-actions">
                            <?php if ($b_btn1_t && $b_btn1_u) : ?>
                                <a href="<?php echo esc_url($b_btn1_u); ?>" class="btn-aftabgardan">
                                    <?php echo esc_html($b_btn1_t); ?>
                                </a>
                            <?php endif; ?>

                            <?php if ($b_btn2_t && $b_btn2_u) : ?>
                                <a href="<?php echo esc_url($b_btn2_u); ?>" class="btn-aftabgardan-outline">
                                    <?php echo esc_html($b_btn2_t); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="aftabgardan-cover">
                        <div class="aftabgardan-cover-card" style="background: linear-gradient(145deg, #FAF7F2 0%, #EAE1D0 100%); border-radius: 12px; border-right: 5px solid #cfbe9f; box-shadow: -10px 18px 36px rgba(0, 0, 0, 0.4); padding: 22px; color: #1e293b; position: relative; overflow: hidden;">
                            <?php if (!empty($aftab_cover_img)) : ?>
                                <div style="margin:-22px -22px 14px -22px; max-height:140px; overflow:hidden;">
                                    <img src="<?php echo esc_url($aftab_cover_img); ?>" alt="<?php echo esc_attr($b_card_t); ?>" style="width:100%; height:140px; object-fit:cover; display:block;">
                                </div>
                            <?php endif; ?>

                            <?php if ($b_card_b) : ?>
                                <div class="aftabgardan-badge" style="background: var(--paper); color: var(--mocha); margin-bottom: 12px; font-weight: 800;">
                                    <?php echo esc_html($b_card_b); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($aftab_logo_img)) : ?>
                                <div style="margin-bottom:8px;">
                                    <img src="<?php echo esc_url($aftab_logo_img); ?>" alt="لوگو" style="max-height:26px; width:auto; display:block;">
                                </div>
                            <?php endif; ?>

                            <h3 style="font-size: 20px; font-weight: 900; color: #0f172a; margin-bottom: 8px;">
                                <?php echo esc_html($b_card_t); ?>
                            </h3>

                            <p style="font-size: 13px; font-weight: 600; color: #1e293b; line-height: 1.8; margin-bottom: 16px;">
                                <?php echo esc_html($b_card_d); ?>
                            </p>

                            <?php if ($b_card_f) : ?>
                                <div style="font-size: 11.5px; font-weight: 700; color: #334155; border-top: 1px dashed #cbd5e1; padding-top: 10px;">
                                    <?php echo esc_html($b_card_f); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>


        <!-- 6. LITERARY ARTICLES & BOOK REVIEWS SECTION -->
        <?php
        if ($home_blog_enable) :
            $bl_eyebrow = rashnubook_get_option('home_blog_eyebrow', 'اندیشه‌ورزی و نقد کتاب');
            $bl_title   = rashnubook_get_option('home_blog_title', 'یادداشت‌های تحلیلی و معرفی کتاب‌ها');
            $bl_count   = (int)rashnubook_get_option('home_blog_count', 3);
            $bl_link_t  = rashnubook_get_option('home_blog_link_text', 'آرشیو همه یادداشت‌ها');
            $bl_link_u  = rashnubook_get_option('home_blog_link_url', home_url('/blog/'));
            if (empty($bl_link_u) || $bl_link_u === home_url('/?post_type=post')) {
                $bl_link_u = home_url('/blog/');
            }
        ?>
            <section class="tento-articles-section" aria-label="<?php esc_attr_e('یادداشت‌ها و نقد کتاب', 'rashnubook'); ?>">
                <div class="tento-section-header">
                    <div>
                        <?php if ($bl_eyebrow) : ?><span class="tento-eyebrow"><?php echo esc_html($bl_eyebrow); ?></span><?php endif; ?>
                        <h2 class="tento-section-title"><?php echo esc_html($bl_title); ?></h2>
                    </div>
                    <?php if ($bl_link_t) : ?>
                        <a href="<?php echo esc_url($bl_link_u); ?>" class="tento-view-all">
                            <?php echo esc_html($bl_link_t); ?>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="tento-articles-grid">
                    <?php
                    $recent_posts = new WP_Query(array(
                        'post_type'      => 'post',
                        'posts_per_page' => $bl_count > 0 ? $bl_count : 3,
                        'post_status'    => 'publish',
                    ));

                    if ($recent_posts->have_posts()) :
                        while ($recent_posts->have_posts()) :
                            $recent_posts->the_post();
                            $thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                            if (!$thumb) {
                                $thumb = RASHNUBOOK_URI . '/assets/images/rashnu-logo.jpg';
                            }
                    ?>
                        <article class="tento-article-card">
                            <a href="<?php the_permalink(); ?>" class="tento-article-media">
                                <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                                <span class="tento-article-tag">نقد و بررسی</span>
                            </a>
                            <div class="tento-article-body">
                                <div class="tento-article-meta">
                                    <span><?php echo esc_html(get_the_date('j F Y')); ?></span>
                                    <span>•</span>
                                    <span>زمان مطالعه: ۵ دقیقه</span>
                                </div>
                                <h3 class="tento-article-title">
                                    <a href="<?php the_permalink(); ?>" style="color:inherit; text-decoration:none;">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                <p class="tento-article-excerpt">
                                    <?php echo esc_html(wp_trim_words(get_the_excerpt(), 22, '...')); ?>
                                </p>
                                <div class="tento-article-footer">
                                    <span>مطالعه مقاله و مشاهده کتاب</span>
                                </div>
                            </div>
                        </article>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </section>
        <?php endif; ?>


        <!-- 7. TRUST & FEATURES STRIP -->
        <?php
        if ($home_trust_enable) :
            $trust_badges = function_exists('rashnubook_get_trust_badges') ? rashnubook_get_trust_badges() : array();
            $active_badges = array_filter($trust_badges, static fn($b) => !empty($b['enabled']));
            if (!empty($active_badges)) :
        ?>
            <section class="features-grid" style="margin-bottom: 48px;">
                <?php foreach ($active_badges as $badge) : ?>
                    <div class="feature-card">
                        <div class="feature-icon-wrap" style="color:<?php echo esc_attr($badge['color']); ?>; background: <?php echo esc_attr($badge['bg']); ?>;">
                            <?php if (!empty($badge['custom_icon'])) : ?>
                                <img src="<?php echo esc_url($badge['custom_icon']); ?>" alt="<?php echo esc_attr($badge['title']); ?>" style="width:24px; height:24px; object-fit:contain;">
                            <?php else : ?>
                                <?php rashnubook_icon($badge['icon']); ?>
                            <?php endif; ?>
                        </div>
                        <div class="feature-info">
                            <div class="feature-title"><?php echo esc_html($badge['title']); ?></div>
                            <div class="feature-desc"><?php echo esc_html($badge['desc']); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</main>

<?php
get_footer();
