<?php
/**
 * Order Item Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-item.php.
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

if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
    return;
}
?>
<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'woocommerce-table__line-item order_item', $item, $order ) ); ?>">

    <td class="woocommerce-table__product-name product-name">
	<?php
	$is_visible        = $product && $product->is_visible();
	$product_permalink = apply_filters( 'woocommerce_order_item_permalink', $is_visible ? $product->get_permalink( $item ) : '', $item, $order );

	echo apply_filters( 'woocommerce_order_item_name', $product_permalink ? sprintf( '<a href="%s">%s</a>', $product_permalink, $item->get_name() ) : $item->get_name(), $item, $is_visible );
	echo apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times; %s', $item->get_quantity() ) . '</strong>', $item );

	do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order );

	wc_display_item_meta( $item );
	wc_display_item_downloads( $item );

	do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order );
	?>
    </td>

    <td class="woocommerce-table__product-total product-total">
	<?php echo $order->get_formatted_line_subtotal( $item ); ?>
    </td>

    <td class="woocommerce-table__product-comments product-comments">
	<div id="open-comment-<?php echo $product->get_id() ?>" class="comment-toggler"><?php _e('Add comment', 'juliet') ?></div>
    </td>
    <script>
     jQuery(document).ready(function(){
	 jQuery("#open-comment-<?php echo $product->get_id() ?>").click(function(){
             jQuery("#comment-panel-<?php echo $product->get_id() ?>").slideToggle("slow");
	 });
     });
    </script>
</tr>

<tr>
    <td colspan="3">
	<div id="comment-panel-<?php echo $product->get_id() ?>" class="order-comment" >
	    <div class="stars">
		<?php _e( 'How did you like it?', 'juliet' );
		$id = $product->get_id();
		?><br/>
		<input class="star star-5 order-comment-item" id="star-5-<?php echo $id ?>" type="radio" name="star-<?php echo $id ?>" value="5" />
		<label class="star star-5" for="star-5-<?php echo $id ?>"></label>
		<input class="star star-4-<?php echo $id ?> order-comment-item" id="star-4-<?php echo $id ?>" type="radio" name="star-<?php echo $id ?>" value="4" />
		<label class="star star-4" for="star-4-<?php echo $id ?>"></label>
		<input class="star star-3 order-comment-item" id="star-3-<?php echo $id ?>" type="radio" name="star-<?php echo $id ?>" value="3" />
		<label class="star star-3" for="star-3-<?php echo $id ?>"></label>
		<input class="star star-2 order-comment-item" id="star-2-<?php echo $id ?>" type="radio" name="star-<?php echo $id ?>" value="2" />
		<label class="star star-2" for="star-2-<?php echo $id ?>"></label>
		<input class="star star-1 order-comment-item" id="star-1-<?php echo $id ?>" type="radio" name="star-<?php echo $id ?>" value="1" />
		<label class="star star-1" for="star-1-<?php echo $id ?>"></label>
	    </div>
	    <div>
		<input type="checkbox" name="repeat-<?php echo $id ?>" id="repeat-box-<?php echo $id ?>" value="repeat-<?php echo $id ?>" class="order-comment-item">
		<label for="repeat-box-<?php echo $id ?>"><?php _e( 'Repeat meal', 'juliet' ) . '?'; ?></label>
	    </div>
	    <div>
		<?php _e( 'Would you like a variation? What kind?', 'juliet' ) ?> &nbsp;
		<input type="text" class="order-comment-item" id="variation-<?php echo $id ?>" name="variation-<?php echo $id ?>">
	    </div>
	    <?php _e( 'How can we improve this dish?', 'juliet' ) ?>
	    <textarea class="order-comment-item" id="comment_content-<?php echo $id ?>" name="comment_content-<?php echo $id ?>" rows="10" cols="60"></textarea>
	</div>
    </td>
</tr>

<?php if ( $show_purchase_note && $purchase_note ) : ?>

    <tr class="woocommerce-table__product-purchase-note product-purchase-note">

	<td colspan="3"><?php echo wpautop( do_shortcode( wp_kses_post( $purchase_note ) ) ); ?></td>

    </tr>

<?php endif; ?>
