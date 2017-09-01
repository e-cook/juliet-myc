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

<h1><?php echo $email_heading; ?></h1>

<p><?php echo $email_intro; ?></p>

<?php
global $wpdb;

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

if ( $query->have_posts() ) {
    do_action( 'woocommerce_before_shop_loop' );
    echo '<table style="border-spacing:20px 20px;">';

    while( $query->have_posts() ) {
	$query->the_post();
	global $post, $product;
	$row = '<tr>';
	$row .= '<td>' . wp_get_attachment_image( get_post_thumbnail_id( $post->ID ) ) . '</td>';
	$row .= '<td>';
	$row .= '<h2><a href="' . $product->get_permalink() . '">' . $post->post_title . '</a></h2><br>';

	$row .= '<p style="margin-top:0;margin-bottom:5px;"><i>';
	$tags_of_product = $wpdb->get_col( "SELECT t.name FROM {$wpdb->prefix}term_relationships tr INNER JOIN {$wpdb->prefix}term_taxonomy tt USING (term_taxonomy_id) INNER JOIN {$wpdb->prefix}terms t USING (term_id) WHERE tr.object_id = {$post->ID} AND tt.taxonomy = 'product_tag'" );
	$row .= implode( ', ', $tags_of_product );
	$row .= '</i></p>';

	if ( 'variable_meal' == $product->get_type() ) {
	    $row .= '<p style="margin-top:0;margin-bottom:5px;"><b>' . __( 'Available sizes', 'juliet' ) . '</b>: '; 
	    $attr_array = array();
	    foreach ( $product->get_attributes() as $taxonomy => $attr_obj ) {
		foreach ( $attr_obj->get_options() as $option_id ) {
		    $attr_array[] = get_term_by( 'id', $option_id, $taxonomy )->name;
		}
	    }
	    $row .= implode( ', ', $attr_array );
	    $row .= '</p>';
	}

	$row .= '<p style="margin-top:0;margin-bottom:5px;" class="price"><b>' . __( 'Price', 'juliet' ) . '</b>: ' . $product->get_price_html() . '</p>';
	$row .= '<p style="margin-top:0;margin-bottom:5px;"><i>' . $product->get_description() . '</i></p>';
	$row .= '</td>';
	$row .= '</tr>';
	echo $row;
    }
    echo '</table>';
    woocommerce_product_loop_end();
    do_action( 'woocommerce_after_shop_loop' );
} else {
    do_action( 'woocommerce_no_products_found' );
}


/**
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
