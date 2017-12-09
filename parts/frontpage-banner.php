
<?php
/**
 * Frontpage Banner
 *
 * @package juliet
 */
?>
<?php 

/*** Banner ***/ 

$header_images = get_uploaded_header_images(); 
error_log("header_images: " . var_export($header_images,1));

$juliet_banner_heading = juliet_get_option('juliet_banner_heading');
$juliet_banner_description = juliet_get_option('juliet_banner_description');
$juliet_banner_url = juliet_get_option('juliet_banner_url');
if ( sizeof($header_images) > 0 ) { 
?>
<!-- Frontpage Banner -->
<div class="container">
    <div class="frontpage-banner">
	<div id="myc-frontpage-carousel" class="carousel slide" data-ride="carousel">
	    <!-- Indicators -->
	    <ol class="carousel-indicators">
	    <?php for ($i=0; $i < sizeof( $header_images ); $i++) { ?>
		<li data-target="#myc-frontpage-carousel" data-slide-to="<?php echo $i; ?>"<?php if ( 0 == $i ) { echo ' class="active"'; } ?>></li>
	    <?php } ?>
	    </ol>

	    <!-- Wrappers for slides -->
	    <div class="carousel-inner">
		<?php
		$first = 1;
		foreach ( $header_images as $id => $image ) { ?>
		    <div class="item<?php if ( 1 == $first ) { $first = 0; echo ' active'; } ?>">
			<img src="<?php echo esc_url($image['url']) ?>" alt="<?php echo esc_attr($juliet_banner_heading); ?>" class="img-responsive" />
		    </div>
		<?php } ?>
	    </div>
	</div>
	
	<?php if($juliet_banner_heading != '' || $juliet_banner_description != '') { ?>
        <div class="caption">
            
            <?php if($juliet_banner_url != '' && $juliet_banner_heading != '') { ?><h2><a href="<?php echo esc_url($juliet_banner_url); ?>"><?php echo esc_html($juliet_banner_heading); ?></a></h2><?php } ?>
        
            <?php if($juliet_banner_url == '' && $juliet_banner_heading != '') { ?><h2><?php echo esc_html($juliet_banner_heading); ?></h2><?php } ?>
            
            <?php if($juliet_banner_description != '') { ?><p class="description"><?php echo wp_kses_post($juliet_banner_description); ?></p><?php } ?>
            
        </div>
		<?php } ?>
    </div>
</div>
<!-- /Frontpage Banner -->
<?php  } ?>
