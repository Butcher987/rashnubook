<?php
/**
 * My Account navigation
 * Tento / Bento inspired layout for rashnubook.ir
 *
 * @package RashnuBook
 */

defined('ABSPATH') || exit;

$current_user = wp_get_current_user();
$is_admin = in_array('administrator', (array) $current_user->roles);

do_action('woocommerce_before_account_navigation');
?>

<nav class="woocommerce-MyAccount-navigation" aria-label="<?php esc_html_e('منوی حساب کاربری', 'rashnubook'); ?>">
    <!-- User Profile Header Box (Tento Style) -->
    <div class="rb-account-profile-header">
        <div class="rb-account-avatar">
            <?php echo get_avatar($current_user->ID, 64); ?>
        </div>
        <div class="rb-account-profile-info">
            <h3 class="rb-account-name"><?php echo esc_html($current_user->display_name); ?></h3>
            <span class="rb-account-badge">
                <?php echo $is_admin ? esc_html__('مدیر کتاب‌سرا', 'rashnubook') : esc_html__('مشتری کتاب‌سرا', 'rashnubook'); ?>
            </span>
        </div>
    </div>

    <!-- Navigation Links -->
    <ul class="rb-account-menu">
        <?php foreach (wc_get_account_menu_items() as $endpoint => $label) :
            $icon_class = 'dashicons-marker';
            switch ($endpoint) {
                case 'dashboard':
                    $icon_class = 'dashicons-dashboard';
                    break;
                case 'orders':
                    $icon_class = 'dashicons-cart';
                    break;
                case 'downloads':
                    $icon_class = 'dashicons-download';
                    break;
                case 'edit-address':
                    $icon_class = 'dashicons-location-alt';
                    break;
                case 'edit-account':
                    $icon_class = 'dashicons-admin-users';
                    break;
                case 'customer-logout':
                    $icon_class = 'dashicons-migrate';
                    break;
            }
            ?>
            <li class="<?php echo esc_attr(wc_get_account_menu_item_classes($endpoint)); ?>">
                <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>">
                    <span class="dashicons <?php echo esc_attr($icon_class); ?>"></span>
                    <span class="rb-menu-label"><?php echo esc_html($label); ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<?php do_action('woocommerce_after_account_navigation'); ?>
