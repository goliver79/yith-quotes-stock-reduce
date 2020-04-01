<?php
	if ( !class_exists( 'GoYithQuotesStockReduced' ) ) {
		class GoYithQuotesStockReduced {

			function activate() {
				add_filter( 'pre_option_woocommerce_manage_stock', array($this,'GoNotReduceStockOnAdminQuotes') );
			}

			/*
			 * no permitir descontar stock si los estados del pedido corresponden a algún estado relacionado con
			 * los presupuestos de YITH
			 */
			function GoNotReduceStockOnAdminQuotes($default) {
				if(is_ajax() && $_POST['action'] == 'woocommerce_add_order_item'){
					if(isset($_POST['order_id'])){
						$order_id = $_POST['order_id'];
						$order = wc_get_order($order_id);
						$wc_order_status_to_check = array('ywraq-new','ywraq-pending','ywraq-expired','ywraq-accepted','ywraq-rejected');
						if(in_array($order->get_status(),$wc_order_status_to_check)){
							return 0;
						}
					}else{
						return $default;
					}
				}
				return $default;
			}
		}

		$lgpd_yith_quotes_stock_reduced = new GoYithQuotesStockReduced();
		$lgpd_yith_quotes_stock_reduced->activate();
	}
