<?php
/**
 * The template for displaying comments
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area" style="margin-top: 48px; padding-top: 32px; border-top: 2px solid var(--border-subtle);">
    <?php if (have_comments()) : ?>
        <h3 class="comments-title" style="font-size: 20px; color: var(--primary); margin-bottom: 24px;">
            <?php
            $rashnubook_comment_count = get_comments_number();
            if ('1' === $rashnubook_comment_count) {
                printf(esc_html__('یک دیدگاه و یادداشت درباره این مطلب', 'rashnubook'));
            } else {
                printf(
                    /* translators: 1: comment count number. */
                    esc_html(_nx('%1$s دیدگاه و یادداشت', '%1$s دیدگاه و یادداشت', $rashnubook_comment_count, 'comments title', 'rashnubook')),
                    esc_html(rashnubook_to_persian_numbers(number_format_i18n($rashnubook_comment_count)))
                );
            }
            ?>
        </h3>

        <ol class="comment-list" style="list-style: none; padding: 0;">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size'=> 44,
            ));
            ?>
        </ol>

        <?php the_comments_navigation(); ?>

        <?php if (!comments_open()) : ?>
            <p class="no-comments"><?php esc_html_e('ارسال دیدگاه برای این بخش بسته شده است.', 'rashnubook'); ?></p>
        <?php endif; ?>

    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply'          => esc_html__('ارسال یادداشت یا نقد شما', 'rashnubook'),
        'title_reply_to'       => esc_html__('پاسخ به %s', 'rashnubook'),
        'cancel_reply_link'    => esc_html__('انصراف از پاسخ', 'rashnubook'),
        'label_submit'         => esc_html__('ثبت و انتشار نظر', 'rashnubook'),
        'class_submit'         => 'btn btn-primary',
        'comment_notes_before' => '<p style="font-size: 13px; color: var(--charcoal-muted); margin-bottom: 16px;">' . esc_html__('نشانی ایمیل شما منتشر نخواهد شد. بخش‌های موردنیاز علامت‌گذاری شده‌اند.', 'rashnubook') . '</p>',
    ));
    ?>
</div>
