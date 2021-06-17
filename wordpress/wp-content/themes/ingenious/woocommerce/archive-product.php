<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

$page_class = "";
$woo_sb_layout = ingenious_get_option( "woo_sb_layout" );
$woo_sb_exists = in_array( $woo_sb_layout, array( "left", "right" ) );
ob_start();
do_action( 'woocommerce_sidebar' );
$woo_sb = ob_get_clean();
$page_class .= $woo_sb_exists ? "single_sidebar " : "";
$woo_columns = ingenious_get_option('woo_column');
$page_class .= $woo_columns;

	echo "<div id='page'" . ( !empty( $page_class ) ? " class='$page_class'" : "" ) . ">";
		echo "<div class='ingenious_layout_container'>";
			if ($woo_sb_exists) {
				echo "<div id='{$woo_sb_layout}_sidebar' class='sidebar'><ul>$woo_sb</ul></div>";
			}
			echo "<main id='page_content'>";

					do_action( 'woocommerce_before_main_content' );
					?>					

					<header class="woocommerce-products-header">
						<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
							<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
						<?php endif; ?>

						<?php
						/**
						 * Hook: woocommerce_archive_description.
						 *
						 * @hooked woocommerce_taxonomy_archive_description - 10
						 * @hooked woocommerce_product_archive_description - 10
						 */
						do_action( 'woocommerce_archive_description' );
						?>
					</header>

					<?php

					if ( woocommerce_product_loop() ) {

						/**
						 * Hook: woocommerce_before_shop_loop.
						 *
						 * @hooked wc_print_notices - 10
						 * @hooked woocommerce_result_count - 20
						 * @hooked woocommerce_catalog_ordering - 30
						 */
						echo ('<div class="woo_panel">');
							do_action( 'woocommerce_before_shop_loop' );
						echo ('</div>');


						woocommerce_product_loop_start();

						if ( wc_get_loop_prop( 'total' ) ) {
							while ( have_posts() ) {
								the_post();

								/**
								 * Hook: woocommerce_shop_loop.
								 *
								 * @hooked WC_Structured_Data::generate_product_data() - 10
								 */
								do_action( 'woocommerce_shop_loop' );

								wc_get_template_part( 'content', 'product' );
							}
						}

						woocommerce_product_loop_end();

						/**
						 * Hook: woocommerce_after_shop_loop.
						 *
						 * @hooked woocommerce_pagination - 10
						 */
						do_action( 'woocommerce_after_shop_loop' );

					} else {
						/**
						 * Hook: woocommerce_no_products_found.
						 *
						 * @hooked wc_no_products_found - 10
						 */
						do_action( 'woocommerce_no_products_found' );
					}

					/**
					 * Hook: woocommerce_after_main_content.
					 *
					 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
					 */
					do_action( 'woocommerce_after_main_content' );

			echo "</main>";
		echo "</div>";
	echo "</div>";

get_footer( 'shop' );
