<?php
/**
 * Admin reminder to order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/admin-reminder-to-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author e-cook
 * @package WooCommerce/Templates/Emails/HTML
 * @version 0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p><?php _e( 'You can now place your orders for next week. You can choose from the following dishes:', 'juliet' ); ?></p>

<?php

$query = new WP_Query(
    array(
	'post_type'           => 'product',
	'post_status'         => 'publish',
	'ignore_sticky_posts' => 1,
	'posts_per_page'      => -1,
	'tax_query' => array(
	    array(
		'taxonomy' => 'product_tag',
		'field'    => 'slug',
		'terms'    => $target_tag,
	    ),
	),
    )
);

$doing_email = 1;

if ( $query->have_posts() ) {
    do_action( 'woocommerce_before_shop_loop' );
    woocommerce_product_loop_start();
    while( $query->have_posts() ) {
	$query->the_post();
	wc_get_template_part( 'content', 'product' );
    }
    woocommerce_product_loop_end();
    do_action( 'woocommerce_after_shop_loop' );
} else {
    do_action( 'woocommerce_no_products_found' );
}

unset( $doing_email );

/**
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
