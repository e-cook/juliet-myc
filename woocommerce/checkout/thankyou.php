<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="woocommerce-order">

    <?php if ( $order ) : ?>

	<?php if ( $order->has_status( 'failed' ) ) : ?>

	    <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'juliet' ); ?></p>

	    <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
		<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'juliet' ) ?></a>
		<?php if ( is_user_logged_in() ) : ?>
		    <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My account', 'juliet' ); ?></a>
		<?php endif; ?>
	    </p>

	<?php else : ?>

            <div class="thankyou-message">
		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( '<h2>Thank you!</h2> <p>Your order has been received.</p>', 'juliet' ), $order ); ?></p>
            </div>

            <div class="order-details">
                <ul class="list-dash">

                    <li>
                        - <?php _e( 'Order number:', 'juliet' ); ?>
                        <strong><?php echo $order->get_order_number(); ?></strong>
                    </li>

                    <li>
                        - <?php _e( 'Date:', 'juliet' ); ?>
                        <strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
                    </li>

		    <li>
			- <?php _e( 'Delivery date:', 'juliet' ); ?>
			<strong><?php echo wc_format_datetime( new WC_DateTime( get_post_meta( $order->get_id(), '_shipping_delivery_date', true ) ) ); ?></strong>
		    </li>

                    <li>
                        - <?php _e( 'Total:', 'juliet' ); ?>
                        <strong><?php echo $order->get_formatted_order_total(); ?></strong>
                    </li>

                    <?php if ( $order->get_payment_method_title() ) : ?>

			<li>
                            - <?php _e( 'Payment method:', 'juliet' ); ?>
                            <strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
			</li>

                    <?php endif; ?>

                </ul>
            </div>

	<?php endif; ?>

        <br>

        <div class="col-md-9">
            <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
            <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
        </div>

    <?php else : ?>

	<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( '<h2>Thank you.</h2> <p>Your order has been received.</p>', 'juliet' ), null ); ?></p>

    <?php endif; ?>

</div>
