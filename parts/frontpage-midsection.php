<?php
/**
 * Frontpage - Midsection
 *
 * @package juliet
 */
?>
<?php 
$juliet_frontpage_midsection_show = juliet_get_option('juliet_frontpage_midsection_show');
error_log("midsection left: " . juliet_get_option( 'juliet_frontpage_midsection_left' ) ); 
if ( $juliet_frontpage_midsection_show == 1 ) { ?>
    
    <!-- Frontpage Featured Posts -->
    <div class="frontpage-midsection">
        <div class="row" data-fluid=".entry-summary,.entry-title">
            <div class="col-sm-6">
                <?php echo juliet_get_option( 'juliet_frontpage_midsection_text' ); ?>
            </div>
            <div class="col-sm-6">
                <?php echo '<img class="img-responsive" id="juliet_frontpage_midsection_picture" src=' . esc_html( juliet_get_option( 'juliet_frontpage_midsection_picture' ) ) . '>'; ?>
            </div>
        </div>
    </div>
    <!-- /Frontpage Featured Posts -->
    
<?php } ?>
