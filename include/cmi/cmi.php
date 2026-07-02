<?php
	/*	
	*	Payment Plugin
	*	---------------------------------------------------------------------
	*	creating the stripe payment option
	*	---------------------------------------------------------------------
	*/

	$CURRENCY_CODES = [
	    'AED' => '784',
	    'AFN' => '971',
	    'ALL' => '008',
	    'AMD' => '051',
	    'AOA' => '973',
	    'ARS' => '032',
	    'AUD' => '036',
	    'AWG' => '533',
	    'AZN' => '944',
	    'BAM' => '977',
	    'BBD' => '052',
	    'BDT' => '050',
	    'BHD' => '048',
	    'BIF' => '108',
	    'BMD' => '060',
	    'BND' => '096',
	    'BOB' => '068',
	    'BOV' => '984',
	    'BRL' => '986',
	    'BSD' => '044',
	    'BTN' => '064',
	    'BWP' => '072',
	    'BYN' => '933',
	    'BZD' => '084',
	    'CAD' => '124',
	    'CDF' => '976',
	    'CHE' => '947',
	    'CHF' => '756',
	    'CHW' => '948',
	    'CLF' => '990',
	    'CLP' => '152',
	    'CNY' => '156',
	    'COP' => '170',
	    'COU' => '970',
	    'CRC' => '188',
	    'CUC' => '931',
	    'CUP' => '192',
	    'CVE' => '132',
	    'CZK' => '203',
	    'DJF' => '262',
	    'DKK' => '208',
	    'DOP' => '214',
	    'DZD' => '012',
	    'EGP' => '818',
	    'ERN' => '232',
	    'ETB' => '230',
	    'EUR' => '978',
	    'FJD' => '242',
	    'FKP' => '238',
	    'GBP' => '826',
	    'GEL' => '981',
	    'GHS' => '936',
	    'GIP' => '292',
	    'GMD' => '270',
	    'GNF' => '324',
	    'GTQ' => '320',
	    'GYD' => '328',
	    'HKD' => '344',
	    'HNL' => '340',
	    'HTG' => '332',
	    'HUF' => '348',
	    'IDR' => '360',
	    'ILS' => '376',
	    'INR' => '356',
	    'IQD' => '368',
	    'IRR' => '364',
	    'ISK' => '352',
	    'JMD' => '388',
	    'JOD' => '400',
	    'JPY' => '392',
	    'KES' => '404',
	    'KGS' => '417',
	    'KHR' => '116',
	    'KMF' => '174',
	    'KPW' => '408',
	    'KRW' => '410',
	    'KWD' => '414',
	    'KYD' => '136',
	    'KZT' => '398',
	    'LAK' => '418',
	    'LBP' => '422',
	    'LKR' => '144',
	    'LRD' => '430',
	    'LSL' => '426',
	    'LYD' => '434',
	    'MAD' => '504',
	    'MDL' => '498',
	    'MGA' => '969',
	    'MKD' => '807',
	    'MMK' => '104',
	    'MNT' => '496',
	    'MOP' => '446',
	    'MRU' => '929',
	    'MUR' => '480',
	    'MVR' => '462',
	    'MWK' => '454',
	    'MXN' => '484',
	    'MXV' => '979',
	    'MYR' => '458',
	    'MZN' => '943',
	    'NAD' => '516',
	    'NGN' => '566',
	    'NIO' => '558',
	    'NOK' => '578',
	    'NPR' => '524',
	    'NZD' => '554',
	    'OMR' => '512',
	    'PAB' => '590',
	    'PEN' => '604',
	    'PGK' => '598',
	    'PHP' => '608',
	    'PKR' => '586',
	    'PLN' => '985',
	    'PYG' => '600',
	    'QAR' => '634',
	    'RON' => '946',
	    'RSD' => '941',
	    'RUB' => '643',
	    'RWF' => '646',
	    'SAR' => '682',
	    'SBD' => '090',
	    'SCR' => '690',
	    'SDG' => '938',
	    'SEK' => '752',
	    'SGD' => '702',
	    'SHP' => '654',
	    'SLE' => '925',
	    'SOS' => '706',
	    'SRD' => '968',
	    'SSP' => '728',
	    'STN' => '930',
	    'SVC' => '222',
	    'SYP' => '760',
	    'SZL' => '748',
	    'THB' => '764',
	    'TJS' => '972',
	    'TMT' => '934',
	    'TND' => '788',
	    'TOP' => '776',
	    'TRY' => '949',
	    'TTD' => '780',
	    'TWD' => '901',
	    'TZS' => '834',
	    'UAH' => '980',
	    'UGX' => '800',
	    'USD' => '840',
	    'USN' => '997',
	    'UYI' => '940',
	    'UYU' => '858',
	    'UZS' => '860',
	    'VED' => '926',
	    'VEF' => '937',
	    'VND' => '704',
	    'VUV' => '548',
	    'WST' => '882',
	    'XAF' => '950',
	    'XCD' => '951',
	    'XCG' => '532',
	    'XDR' => '960',
	    'XOF' => '952',
	    'XPF' => '953',
	    'XSU' => '994',
	    'XUA' => '965',
	    'YER' => '886',
	    'ZAR' => '710',
	    'ZMW' => '967',
	    'ZWL' => '932',
	];

	add_filter('goodlayers_credit_card_payment_gateway_options', 'goodlayers_cmi_payment_gateway_options');
	if( !function_exists('goodlayers_cmi_payment_gateway_options') ){
		function goodlayers_cmi_payment_gateway_options( $options ){
			$options['cmi'] = esc_html__('CMI', 'tourmaster'); 

			return $options;
		}
	}

	add_filter('goodlayers_plugin_payment_option', 'goodlayers_cmi_payment_option');
	if( !function_exists('goodlayers_cmi_payment_option') ){
		function goodlayers_cmi_payment_option( $options ){

			$options['cmi'] = array(
				'title' => esc_html__('CMI', 'tourmaster'),
				'options' => array(
					'cmi-live-mode' => array(
						'title' => esc_html__('CMI Live Mode', 'tourmaster'),
						'type' => 'checkbox',
						// 'default' => 'enable'
					),
					'cmi-test-gateway' => array(
						'title' => __('CMI Test Gatway Url', 'tourmaster'),
						'type' => 'text'
					),
					'cmi-live-gateway' => array(
						'title' => __('CMI Live Gatway Url', 'tourmaster'),
						'type' => 'text'
					),
					'cmi-client-id' => array(
						'title' => __('CMI Clinet Id', 'tourmaster'),
						'type' => 'text'
					),
					'cmi-hash-key' => array(
						'title' => __('CMI Store Key', 'tourmaster'),
						'type' => 'text'
					),	
					// 'cmi-currency' => array(
					// 	'title' => __('CMI Currency Code', 'tourmaster'),
					// 	'type' => 'text',
					// 	'default' => '504'
					// ),	
					// 'cmi-success-page' => array(
					// 	'title' => esc_html__('CMI Ok Page', 'tourmaster'),
					// 	'type' => 'combobox',
					// 	'options' => tourmaster_get_post_list('page', true),
					// 	'default' => '#'
					// ),	
					// 'cmi-fail-page' => array(
					// 	'title' => esc_html__('CMI Fail Page', 'tourmaster'),
					// 	'type' => 'combobox',
					// 	'options' => tourmaster_get_post_list('page', true),
					// 	'default' => '#'
					// ),	
				)
			);

			return $options;
		} // goodlayers_cmi_payment_option
	}

	$current_payment_gateway = get_option('tourmaster_payment')['credit-card-payment-gateway'] ?? '';
	if( $current_payment_gateway == 'cmi' ){
		if( !class_exists('CMI\Payment\CmiPay') ){
			include_once(TOURMASTER_CMI_LOCAL . '/include/cmi/init.php');
		}

		add_filter('goodlayers_plugin_payment_attribute', 'goodlayers_cmi_payment_attribute');
		add_filter('goodlayers_cmi_payment_form', 'goodlayers_cmi_payment_form', 10, 2);

		// Register the REST API endpoints
		add_action('rest_api_init', function () {
		    register_rest_route('cmi/v1', '/payment/(?P<tid>[a-zA-Z0-9-]+)/callback', array(
		        'methods' => ['GET', 'POST'],
		        'callback' => 'goodlayers_cmi_payment_callback',
		        'permission_callback' => '__return_true'
		    ));
		});

	}	

	// add attribute for payment button
	if( !function_exists('goodlayers_cmi_payment_attribute') ){
		function goodlayers_cmi_payment_attribute( $attributes ){
			return array('type' => 'cmi');
		}
	}

	// Helper: convert any amount to MAD using TourMaster's cached exchange rates
	if( !function_exists('goodlayers_cmi_convert_to_mad') ){
		function goodlayers_cmi_convert_to_mad( $price, $from_currency ){
			$from_currency = strtolower(trim($from_currency));

			// Already MAD — nothing to do
			if( $from_currency === 'mad' ) return $price;

			// Use TourMaster's main (base) currency as the pivot
			$main_currency = strtolower(tourmaster_get_option('general', 'currency-code', 'usd'));

			// tourmaster_get_currency_rate() returns rates cached from floatrates.com
			// Format: [ 'usd' => 0.0986, 'eur' => 0.0913, 'mad' => 1.0, ... ]
			// Meaning: 1 unit of $main_currency = rate[X] units of currency X
			$rates = tourmaster_get_currency_rate($main_currency);

			if( empty($rates['mad']) ){
				error_log('[CMI] MAD rate not found in TourMaster currency data. Returning original price unchanged.');
				return $price;
			}

			// Price is already in the main/base currency — direct conversion
			if( $from_currency === $main_currency ){
				return floatval($price) * floatval($rates['mad']);
			}

			// Price is in a secondary currency: back-convert to main, then to MAD
			// from_price / rate[from] = price_in_main; price_in_main * rate[mad] = price_in_mad
			if( empty($rates[$from_currency]) ){
				error_log('[CMI] Rate for "' . $from_currency . '" not found in TourMaster data. Returning original price unchanged.');
				return $price;
			}

			$price_in_main = floatval($price) / floatval($rates[$from_currency]);
			return $price_in_main * floatval($rates['mad']);
		}
	}

	// payment form
	if( !function_exists('goodlayers_cmi_payment_form') ){
		function goodlayers_cmi_payment_form( $ret = '', $tid = '' ){
			// get the price
			$live = trim(apply_filters('goodlayers_payment_get_option', '', 'cmi-live-mode'));
			$test_gateway = trim(apply_filters('goodlayers_payment_get_option', '', 'cmi-test-gateway'));
			$live_gateway = trim(apply_filters('goodlayers_payment_get_option', '', 'cmi-live-gateway'));
			$clientid = trim(apply_filters('goodlayers_payment_get_option', '', 'cmi-client-id'));
			$hashkey = trim(apply_filters('goodlayers_payment_get_option', '', 'cmi-hash-key'));
			// $currency_code = trim(apply_filters('goodlayers_payment_get_option', 'usd', 'cmi-currency'));
			
			$t_data = apply_filters('goodlayers_payment_get_transaction_data', array(), $tid, array('email', 'currency', 'price', 'tour_id', 'contact_address', 'country', 'first_name', 'last_name', 'phone'));

			$price = '';
			if( !empty($t_data['price']['deposit-price']) ){
				$price = $t_data['price']['deposit-price'];
				if( !empty($t_data['price']['deposit-price-raw']) ){
					$deposit_amount = $t_data['price']['deposit-price-raw'];
				}
			}else if( !empty($t_data['price']['pay-amount']) ){
				$price = $t_data['price']['pay-amount'];
			}

			// apply currency — convert to MAD (ISO 4217: 504) for CMI gateway
			if( !empty($t_data['currency']) ){
				$source_currency = strtoupper($t_data['currency']['currency-code']);
				$price = $price * floatval($t_data['currency']['exchange-rate']);
			}else{
				$source_currency = strtoupper(tourmaster_get_option('general', 'currency-code', 'MAD'));
			}

			// Always charge in MAD regardless of the tour's display currency
			if( strtoupper($source_currency) !== 'MAD' ){
				$price = goodlayers_cmi_convert_to_mad($price, $source_currency);
			}
			$currency_code = 'MAD';

			$price = round(floatval($price));

			// collect payment information
			$cmiHandler = new \CMI\Payment\CmiHandler();
			$cmiPay = new \CMI\Payment\CmiPay();
			$rnd = microtime();
			$shopurl = home_url();
			// $okUrl = apply_filters('goodlayers_payment_get_option', '#', 'cmi-success-page');
			$okUrl = esc_url(add_query_arg(array('tid' => $tid, 'cmi_status' => 'success',), tourmaster_get_template_url('payment')));
			// $failUrl = apply_filters('goodlayers_payment_get_option', '#', 'cmi-fail-page');
			$failUrl = esc_url(add_query_arg(array('tid' => $tid, 'cmi_status' => 'failed'), tourmaster_get_template_url('payment')));
			$callbackUrl = get_rest_url(null, "/cmi/v1/payment/$tid/callback");
			$locale = get_locale();

			$cmiPay->setGatewayurl($live != 'enable' ? $test_gateway : $live_gateway)
            ->setClientid($clientid)
            ->setSecretKey($hashkey)
            ->setTel($t_data['phone'] ?? '')
            ->setEmail($t_data['email'] ?? '')
            ->setBillToName($t_data['first_name'] . ' ' . $t_data['last_name'])
            ->setBillToStateProv($t_data['contact_address'] && trim($t_data['contact_address']) !== '' ? $t_data['contact_address'] : '')
            ->setBillToCountry($t_data['country'] && trim($t_data['country']) !== '' ? tourmaster_country_to_iso($t_data['country']) : '')
            ->setOid(esc_attr($tid))
            ->setCurrency('504')
            ->setAmount(number_format($price, 2, '.', ''))
            ->setOkUrl($okUrl)
            ->setCallbackUrl($callbackUrl)
            ->setFailUrl($failUrl)
            ->setShopurl($shopurl)
            ->setEncoding('UTF-8')
            ->setStoretype('3D_PAY_HOSTING')
            ->setHashAlgorithm('ver3')
            ->setTranType('PreAuth')
            ->setRefreshtime(5)
            ->setLang(str_starts_with($locale, 'Ar') ? 'ar' : (str_starts_with($locale, 'Fr') ? 'fr' : 'en'))
            ->setRnd($rnd);

        	$hash = $cmiHandler->hashValue($cmiPay);
        	$cmiParams = $cmiHandler->unsetData($cmiHandler->convertData($cmiPay));


			ob_start();
?>
<div class="goodlayers-payment-form goodlayers-with-border" >
	<form action="<?= $cmiPay->getGatewayurl() ?>" method="POST" id="goodlayers-stripe-payment-form" >
		<?php foreach ($cmiParams as $name => $value) {
			echo '<input type="hidden" name="' . $name . '" value="' . $value . '"/>';
		} ?>
		<input type="hidden" name="hash" value="<?= $hash ?>"/>

		<button type="submit" id="card-button" style="display: none;"><?php esc_html_e('Submit Payment', 'tourmaster'); ?></button>
	</form>

	<script>
        setTimeout(() => {
            document.getElementById("goodlayers-stripe-payment-form").submit();
        }, 500);


        setTimeout(() => {
            document.getElementById("card-button").style.display = "block";
        }, 1000);
    </script>
</div>
<?php
			$ret = ob_get_contents();
			ob_end_clean();
			return $ret;
		}
	}

	if ( !function_exists('goodlayers_cmi_payment_callback') ) {
		function goodlayers_cmi_payment_callback ($request) {

			parse_str($request->get_body(), $params);

			// Get order id — banks sometimes return custom fields, check your payload
            $tid = intval( $request['tid'] ?? $params['oid'] ?? 0 );
            if ( ! $tid ) {
                return rest_ensure_response("FAILURE");
            }

			// get the price
			$clientid = trim(apply_filters('goodlayers_payment_get_option', '', 'cmi-client-id'));
			$hashkey = trim(apply_filters('goodlayers_payment_get_option', '', 'cmi-hash-key'));
			$currency_code = trim(apply_filters('goodlayers_payment_get_option', 'usd', 'cmi-currency'));
			
			$t_data = apply_filters('goodlayers_payment_get_transaction_data', array(), $tid, array('email', 'currency', 'price', 'tour_id', 'contact_address', 'country', 'first_name', 'last_name', 'phone'));


			// apply currency — convert to MAD (ISO 4217: 504) for CMI gateway
			if( !empty($t_data['currency']) ){
				$source_currency = strtoupper($t_data['currency']['currency-code']);
				$price = $price * floatval($t_data['currency']['exchange-rate']);
			}else{
				$source_currency = strtoupper(tourmaster_get_option('general', 'currency-code', 'MAD'));
			}

			// collect payment information
			$cmiHandler = new \CMI\Payment\CmiHandler();

        	$retrievedHash = trim(preg_replace("/\n$/", "", $params["HASH"]));

        	$cmiPay = array_merge($params, ['secretKey' => $hashkey]);
        	$hash = $cmiHandler->hashValue($cmiPay);

			// $f = fopen('request.log', 'a+');
			// fwrite($f, 'Generated Hash: '.$hash.PHP_EOL);
			// fwrite($f, 'Receved Hash'.$retrievedHash.PHP_EOL);
			// // fwrite($f, ($retrievedHash == $hash ? 'TRUE' : 'FALSE').PHP_EOL);
			// fwrite($f, 'ProcReturnCode: '.$params["ProcReturnCode"].PHP_EOL);
			// fwrite($f, 'Request Body: '.$request->get_body().PHP_EOL);
			// // fwrite($f, print_r($params, true).PHP_EOL);
			// fclose($f);

			if ($params["ProcReturnCode"] == "00") {
				if ($retrievedHash == $hash) {
	        		$paid_amount = $params['amount']; // CMI always returns amount in MAD


	        		// Convert MAD amount back to the order's original currency so TourMaster's
	        		// paid-vs-total comparison and invoice display use the correct currency.
	        		// Inverse of goodlayers_cmi_convert_to_mad():
	        		//   MAD → main_currency → source_currency
	        		$original_currency = strtolower($source_currency);
	        		if( $original_currency !== 'mad' ){
	        			$_cmi_main = strtolower(tourmaster_get_option('general', 'currency-code', 'MAD'));
	        			$_cmi_rates = tourmaster_get_currency_rate($_cmi_main);
	        			if( !empty($_cmi_rates['mad']) ){
	        				$_cmi_price_in_main = floatval($paid_amount) / floatval($_cmi_rates['mad']);
	        				if( $original_currency === $_cmi_main ){
	        					$paid_amount = $_cmi_price_in_main;
	        				} elseif( !empty($_cmi_rates[$original_currency]) ){
	        					$paid_amount = $_cmi_price_in_main * floatval($_cmi_rates[$original_currency]);
	        				}
	        			}
	        		}

		        	// collect payment information
					$payment_info = array(
						'payment_method' => 'cmi',
						'amount' => $paid_amount,
						'transaction_id' => $request['TransId'] ?? null,
						'payment_status' => 'paid',
						'submission_date' => current_time('mysql')
					);

					// additional data for payment fee
					if( !empty($t_data['price']['deposit-price']) ){
						if( !empty($t_data['price']['deposit-price-raw']) ){
							$payment_info['deposit_amount'] = $t_data['price']['deposit-price-raw'];
						}
						if( !empty($t_data['price']['deposit-credit-card-service-rate']) ){
							$payment_info['deposit_credit_card_service_rate'] = $t_data['price']['deposit-credit-card-service-rate'];
						}
						if( !empty($t_data['price']['deposit-credit-card-service-fee']) ){
							$payment_info['deposit_credit_card_service_fee'] = $t_data['price']['deposit-credit-card-service-fee'];
						}
					}else{
						if( !empty($t_data['price']['pay-amount-raw']) ){
							$payment_info['pay_amount'] = $t_data['price']['pay-amount-raw'];
						}
						if( !empty($t_data['price']['pay-amount-credit-card-service-rate']) ){
							$payment_info['pay_credit_card_service_rate'] = $t_data['price']['pay-amount-credit-card-service-rate'];
						}
						if( !empty($t_data['price']['pay-amount-credit-card-service-fee']) ){
							$payment_info['pay_credit_card_service_fee'] = $t_data['price']['pay-amount-credit-card-service-fee'];
						}
					}

					$payment_info['payment_detail'] = $params;

					// update data
					do_action('goodlayers_set_payment_complete', $tid, $payment_info);

	        		echo "ACTION=POSTAUTH";
	        		exit;
	        	}

        		echo "APPROVED";
        		exit;
			}

			echo "FAILURE";
			exit;
		}
	}

	if( !function_exists('goodlayers_cmi_handle_redirect') ){
		add_action('template_redirect', 'goodlayers_cmi_handle_redirect');
		function goodlayers_cmi_handle_redirect(){
			if( empty($_GET['cmi_status']) || empty($_GET['tid']) ){
				return;
			}

			$tid = intval($_GET['tid']);
			$status = sanitize_text_field($_GET['cmi_status']);

			get_header();

			echo '<div class="tourmaster-page-wrapper" id="tourmaster-page-wrapper" >';
			echo '<div class="tourmaster-template-wrapper" >';
			echo '<div class="tourmaster-container" >';
			echo '<div class="tourmaster-page-content tourmaster-item-pdlr clearfix" >';

			if( $status === 'success' ){
				echo tourmaster_payment_complete();
			}else{
				echo goodlayers_cmi_payment_failed_message($tid);
			}

			echo '</div></div></div></div>';

			get_footer();
			exit;
		}
	}

	if( !function_exists('goodlayers_cmi_payment_failed_message') ){
		function goodlayers_cmi_payment_failed_message( $tid ){
			$retry_url = esc_url(add_query_arg(array('tid' => $tid), tourmaster_get_template_url('payment')));

			$ret  = '<div class="tourmaster-payment-complete-wrap" >';
			$ret .= '<div class="tourmaster-payment-complete-head" >' . esc_html__('Payment Failed', 'tourmaster') . '</div>';
			$ret .= '<div class="tourmaster-payment-complete-content-wrap" >';
			$ret .= '<i class="icon_close_alt2 tourmaster-payment-complete-icon" ></i>';
			$ret .= '<div class="tourmaster-payment-complete-content" >';
			$ret .= esc_html__('We were unable to process your payment. No amount has been charged. Please try again.', 'tourmaster');
			$ret .= '</div>';
			$ret .= '<a class="tourmaster-payment-complete-button tourmaster-button" href="' . $retry_url . '" >' . esc_html__('Try Again', 'tourmaster') . '</a>';
			$ret .= '</div></div>';

			return $ret;
		}
	}

	if( !function_exists('tourmaster_country_to_iso') ){
		function tourmaster_country_to_iso($country){
			$countries = array(
				'AF' => 'Afghanistan',
				'AX' => 'Aland Islands',
				'AL' => 'Albania',
				'DZ' => 'Algeria',
				'AS' => 'American Samoa',
				'AD' => 'Andorra',
				'AO' => 'Angola',
				'AI' => 'Anguilla',
				'AQ' => 'Antarctica',
				'AG' => 'Antigua And Barbuda',
				'AR' => 'Argentina',
				'AM' => 'Armenia',
				'AW' => 'Aruba',
				'AU' => 'Australia',
				'AT' => 'Austria',
				'AZ' => 'Azerbaijan',
				'BS' => 'Bahamas',
				'BH' => 'Bahrain',
				'BD' => 'Bangladesh',
				'BB' => 'Barbados',
				'BY' => 'Belarus',
				'BE' => 'Belgium',
				'BZ' => 'Belize',
				'BJ' => 'Benin',
				'BM' => 'Bermuda',
				'BT' => 'Bhutan',
				'BO' => 'Bolivia',
				'BA' => 'Bosnia And Herzegovina',
				'BW' => 'Botswana',
				'BV' => 'Bouvet Island',
				'BR' => 'Brazil',
				'IO' => 'British Indian Ocean Territory',
				'BN' => 'Brunei Darussalam',
				'BG' => 'Bulgaria',
				'BF' => 'Burkina Faso',
				'BI' => 'Burundi',
				'KH' => 'Cambodia',
				'CM' => 'Cameroon',
				'CA' => 'Canada',
				'CV' => 'Cape Verde',
				'KY' => 'Cayman Islands',
				'CF' => 'Central African Republic',
				'TD' => 'Chad',
				'CL' => 'Chile',
				'CN' => 'China',
				'CX' => 'Christmas Island',
				'CC' => 'Cocos (Keeling) Islands',
				'CO' => 'Colombia',
				'KM' => 'Comoros',
				'CG' => 'Congo',
				'CD' => 'Congo, Democratic Republic',
				'CK' => 'Cook Islands',
				'CR' => 'Costa Rica',
				'CI' => 'Cote D\'Ivoire',
				'HR' => 'Croatia',
				'CU' => 'Cuba',
				'CY' => 'Cyprus',
				'CZ' => 'Czech Republic',
				'DK' => 'Denmark',
				'DJ' => 'Djibouti',
				'DM' => 'Dominica',
				'DO' => 'Dominican Republic',
				'EC' => 'Ecuador',
				'EG' => 'Egypt',
				'SV' => 'El Salvador',
				'GQ' => 'Equatorial Guinea',
				'ER' => 'Eritrea',
				'EE' => 'Estonia',
				'ET' => 'Ethiopia',
				'FK' => 'Falkland Islands (Malvinas)',
				'FO' => 'Faroe Islands',
				'FJ' => 'Fiji',
				'FI' => 'Finland',
				'FR' => 'France',
				'GF' => 'French Guiana',
				'PF' => 'French Polynesia',
				'TF' => 'French Southern Territories',
				'GA' => 'Gabon',
				'GM' => 'Gambia',
				'GE' => 'Georgia',
				'DE' => 'Germany',
				'GH' => 'Ghana',
				'GI' => 'Gibraltar',
				'GR' => 'Greece',
				'GL' => 'Greenland',
				'GD' => 'Grenada',
				'GP' => 'Guadeloupe',
				'GU' => 'Guam',
				'GT' => 'Guatemala',
				'GG' => 'Guernsey',
				'GN' => 'Guinea',
				'GW' => 'Guinea-Bissau',
				'GY' => 'Guyana',
				'HT' => 'Haiti',
				'HM' => 'Heard Island & Mcdonald Islands',
				'VA' => 'Holy See (Vatican City State)',
				'HN' => 'Honduras',
				'HK' => 'Hong Kong',
				'HU' => 'Hungary',
				'IS' => 'Iceland',
				'IN' => 'India',
				'ID' => 'Indonesia',
				'IR' => 'Iran, Islamic Republic Of',
				'IQ' => 'Iraq',
				'IE' => 'Ireland',
				'IM' => 'Isle Of Man',
				'IL' => 'Israel',
				'IT' => 'Italy',
				'JM' => 'Jamaica',
				'JP' => 'Japan',
				'JE' => 'Jersey',
				'JO' => 'Jordan',
				'KZ' => 'Kazakhstan',
				'KE' => 'Kenya',
				'KI' => 'Kiribati',
				'KR' => 'Korea',
				'KW' => 'Kuwait',
				'KG' => 'Kyrgyzstan',
				'LA' => 'Lao People\'s Democratic Republic',
				'LV' => 'Latvia',
				'LB' => 'Lebanon',
				'LS' => 'Lesotho',
				'LR' => 'Liberia',
				'LY' => 'Libyan Arab Jamahiriya',
				'LI' => 'Liechtenstein',
				'LT' => 'Lithuania',
				'LU' => 'Luxembourg',
				'MO' => 'Macao',
				'MK' => 'Macedonia',
				'MG' => 'Madagascar',
				'MW' => 'Malawi',
				'MY' => 'Malaysia',
				'MV' => 'Maldives',
				'ML' => 'Mali',
				'MT' => 'Malta',
				'MH' => 'Marshall Islands',
				'MQ' => 'Martinique',
				'MR' => 'Mauritania',
				'MU' => 'Mauritius',
				'YT' => 'Mayotte',
				'MX' => 'Mexico',
				'FM' => 'Micronesia, Federated States Of',
				'MD' => 'Moldova',
				'MC' => 'Monaco',
				'MN' => 'Mongolia',
				'ME' => 'Montenegro',
				'MS' => 'Montserrat',
				'MA' => 'Morocco',
				'MZ' => 'Mozambique',
				'MM' => 'Myanmar',
				'NA' => 'Namibia',
				'NR' => 'Nauru',
				'NP' => 'Nepal',
				'NL' => 'Netherlands',
				'AN' => 'Netherlands Antilles',
				'NC' => 'New Caledonia',
				'NZ' => 'New Zealand',
				'NI' => 'Nicaragua',
				'NE' => 'Niger',
				'NG' => 'Nigeria',
				'NU' => 'Niue',
				'NF' => 'Norfolk Island',
				'MP' => 'Northern Mariana Islands',
				'NO' => 'Norway',
				'OM' => 'Oman',
				'PK' => 'Pakistan',
				'PW' => 'Palau',
				'PS' => 'Palestinian Territory, Occupied',
				'PA' => 'Panama',
				'PG' => 'Papua New Guinea',
				'PY' => 'Paraguay',
				'PE' => 'Peru',
				'PH' => 'Philippines',
				'PN' => 'Pitcairn',
				'PL' => 'Poland',
				'PT' => 'Portugal',
				'PR' => 'Puerto Rico',
				'QA' => 'Qatar',
				'RE' => 'Reunion',
				'RO' => 'Romania',
				'RU' => 'Russian Federation',
				'RW' => 'Rwanda',
				'BL' => 'Saint Barthelemy',
				'SH' => 'Saint Helena',
				'KN' => 'Saint Kitts And Nevis',
				'LC' => 'Saint Lucia',
				'MF' => 'Saint Martin',
				'PM' => 'Saint Pierre And Miquelon',
				'VC' => 'Saint Vincent And Grenadines',
				'WS' => 'Samoa',
				'SM' => 'San Marino',
				'ST' => 'Sao Tome And Principe',
				'SA' => 'Saudi Arabia',
				'SN' => 'Senegal',
				'RS' => 'Serbia',
				'SC' => 'Seychelles',
				'SL' => 'Sierra Leone',
				'SG' => 'Singapore',
				'SK' => 'Slovakia',
				'SI' => 'Slovenia',
				'SB' => 'Solomon Islands',
				'SO' => 'Somalia',
				'ZA' => 'South Africa',
				'GS' => 'South Georgia And Sandwich Isl.',
				'ES' => 'Spain',
				'LK' => 'Sri Lanka',
				'SD' => 'Sudan',
				'SR' => 'Suriname',
				'SJ' => 'Svalbard And Jan Mayen',
				'SZ' => 'Swaziland',
				'SE' => 'Sweden',
				'CH' => 'Switzerland',
				'SY' => 'Syrian Arab Republic',
				'TW' => 'Taiwan',
				'TJ' => 'Tajikistan',
				'TZ' => 'Tanzania',
				'TH' => 'Thailand',
				'TL' => 'Timor-Leste',
				'TG' => 'Togo',
				'TK' => 'Tokelau',
				'TO' => 'Tonga',
				'TT' => 'Trinidad And Tobago',
				'TN' => 'Tunisia',
				'TR' => 'Turkey',
				'TM' => 'Turkmenistan',
				'TC' => 'Turks And Caicos Islands',
				'TV' => 'Tuvalu',
				'UG' => 'Uganda',
				'UA' => 'Ukraine',
				'AE' => 'United Arab Emirates',
				'GB' => 'United Kingdom',
				'US' => 'United States',
				'UM' => 'United States Outlying Islands',
				'UY' => 'Uruguay',
				'UZ' => 'Uzbekistan',
				'VU' => 'Vanuatu',
				'VE' => 'Venezuela',
				'VN' => 'Vietnam',
				'VG' => 'Virgin Islands, British',
				'VI' => 'Virgin Islands, U.S.',
				'WF' => 'Wallis And Futuna',
				'EH' => 'Western Sahara',
				'YE' => 'Yemen',
				'ZM' => 'Zambia',
				'ZW' => 'Zimbabwe',
			);

			return array_search($country, $countries);
		}
	}