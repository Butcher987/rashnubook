<?php
/**
 * Result Count
 *
 * Shows text: Showing x - x of x results.
 *
 * @package RashnuBook
 */

if (!defined('ABSPATH')) {
    exit;
}

$fn_fa = function_exists('rashnubook_to_persian_numbers') ? 'rashnubook_to_persian_numbers' : function($n) { return $n; };
?>
<p class="woocommerce-result-count">
    <?php
    if (1 === intval($total)) {
        esc_html_e('نمایش تک نتیجه', 'rashnubook');
    } elseif ($total <= $per_page || -1 === $per_page) {
        /* translators: %s: total results */
        printf(
            esc_html__('نمایش همه %s نتیجه', 'rashnubook'),
            '<span class="count">' . esc_html($fn_fa($total)) . '</span>'
        );
    } else {
        $first = ($per_page * $current) - $per_page + 1;
        $last  = min($total, $per_page * $current);
        /* translators: 1: first result 2: last result 3: total results */
        printf(
            esc_html__('نمایش %1$s تا %2$s از مجموع %3$s نتیجه', 'rashnubook'),
            '<span class="first">' . esc_html($fn_fa($first)) . '</span>',
            '<span class="last">' . esc_html($fn_fa($last)) . '</span>',
            '<span class="total">' . esc_html($fn_fa($total)) . '</span>'
        );
    }
    ?>
</p>
