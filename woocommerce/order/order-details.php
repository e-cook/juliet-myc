<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! $order = wc_get_order( $order_id ) ) {
    return;
}
$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
?>

<section class="woocommerce-order-details">

    <h2 class="woocommerce-order-details__title"><?php _e( 'Order details', 'woocommerce' ); ?></h2>

    <form id="order-comments-form">
	<table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
	    
	    <thead>
		<tr>
		    <th class="woocommerce-table__product-name product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
		    <th class="woocommerce-table__product-table product-total"><?php _e( 'Total', 'woocommerce' ); ?></th>
		    <th class="woocommerce-table__product-table product-total"><?php _e( 'Comments', 'juliet' ); ?>
			&nbsp;<input type="submit" id="order-comments-submit-button" class="woocommerce-Button button button-primary disabled" value="<?php _e( 'Submit', 'woocommerce' ); ?>"></th>
		</tr>
	    </thead>

	    <tbody>
		<?php
		$order_item_product_ids = array();
		foreach ( $order->get_items() as $item_id => $item ) {
		    $product = apply_filters( 'woocommerce_order_item_product', $item->get_product(), $item );
		    $order_item_product_ids[] = $item->get_product()->get_id();
		    
		    wc_get_template( 'order/order-details-item.php', array(
			'order'		 => $order,
			'item_id'		 => $item_id,
			'item'		 => $item,
			'show_purchase_note' => $show_purchase_note,
			'purchase_note'	 => $product ? $product->get_purchase_note() : '',
			'product'	         => $product,
		    ) );
		}
		?>
		<?php do_action( 'woocommerce_order_items_table', $order ); ?>
	    </tbody>

	    <tfoot>
		<?php
		foreach ( $order->get_order_item_totals() as $key => $total ) {
		?>
		    <tr>
			<th scope="row"><?php echo $total['label']; ?></th>
			<td><?php echo $total['value']; ?></td>
			<td/>
		    </tr>
		<?php
		}
		?>
	    </tfoot>

	</table>
    </form>

    <?php
    function local_php_array_2_js( $arr ) {
	$js_arr = '[';
	$ct = 0;
	foreach ( $arr as $a ) {
	    if ( $ct > 0 ) {
		$js_arr .= ',';
	    } else {
		$ct = 1;
	    }
	    $js_arr .= '"' . $a . '"';
	}
	return $js_arr . ']';
    }
    ?>
    <script type="text/javascript">
     jQuery(document).ready(function() {
	 jQuery( '.order-comment-item' ).on( 'input' , function() {
	     jQuery( '#order-comments-submit-button' ).removeClass( 'disabled' );
	 });
	 alert('disabled button');
	 
	 jQuery.post( ajaxurl, {
	     action: 'myc_read_order_comments',
	     product_ids: <?php echo php_array_2_js( $order_item_product_ids ); ?>,
	     _nonce: '<?php echo wp_create_nonce( 'myc_read_order_comments' ) ?>'
	 }, function( response ) {
	     alert("response: " + JSON.stringify(response));
	     var props_of = JSON.parse( response );
	     for ( var product_id in props_of ) {
		 jQuery( '#star-' + props_of[ product_id ][ 'star' ] + '-' + product_id ).attr( 'checked', true );
		 if ( props_of[ product_id ][ 'repeat' ] == 1 ) {
		     jQuery( '#repeat-box-' + product_id ).attr( 'checked', true );
		 }
		 jQuery( '#variation-' + product_id ).val( props_of[ product_id ][ 'variation' ] );
		 jQuery( '#comment_content-' + product_id ).text( props_of[ product_id ][ 'comment_content' ] );
	     }
	 });
	 alert('posted question');
	 jQuery( '#order-comments-form' ).submit( function( event ) {
	     var postData = jQuery( this ).serializeArray();
	     event.preventDefault();
	     event.stopImmediatePropagation();
	     jQuery.post( ajaxurl, {
		 action: 'myc_write_order_comments',
		 data: postData,
		 _nonce: '<?php echo wp_create_nonce( 'myc_write_order_comments' ) ?>'
	     }, function() {
		 jQuery( '#order-comments-submit-button' ).addClass( 'disabled' );		 
	     });
	     return false;
	 });
	 alert("attached event");
     });
    </script>

    <?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>

    <?php if ( $show_customer_details ) : ?>
	<?php wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) ); ?>
    <?php endif; ?>

</section>
