<?php
    /*	
        Plugin Name: LS WP Currency BYN	
		Plugin URI: https://wordpress.org/plugins/ls-wp-currency-byn
		Description: Shows currency exchange rates for Belarus
		Version: 1.0.0
		Author: Lightning Soft
		Author URI: https://lightning-soft.com/
		Text Domain: ls_cb
		License: GPL2
	*/

	define('LS_WP_CURRENCY_BYN_NAME', basename( __DIR__ ));

	register_activation_hook(__FILE__,'ls_cb_activationmoney');

 	function ls_cb_activationmoney(){
		wp_clear_scheduled_hook('ls_cb_update_curse');
		wp_schedule_event( time(), 'twicedaily', 'ls_cb_update_curse');
		ls_cb_updaterubusdeur();
	}

	add_action('ls_cb_update_curse', 'ls_cb_updaterubusdeur');

	function ls_cb_updaterubusdeur(){
		$url = 'https://www.nbrb.by/api/exrates/rates?periodicity=0';
		$response = wp_remote_get($url);
		$responseBody = wp_remote_retrieve_body($response);
		$currencies = json_decode($responseBody, true);
		$result = [
			'date' => $currencies[0]=date("d:m:Y"),
			'currencies' => []	
        ];
        foreach($currencies as $currency){
			$result['currencies'][] = [
				'Cur_Abbreviation' => $currency['Cur_Abbreviation'],
				'Cur_OfficialRate' => $currency['Cur_OfficialRate'],
				'Cur_Scale' => $currency['Cur_Scale']
			];
		}
		
		update_option('ls_cb_kurs', $result);
	} 

	function ls_cb_get_currency_by_abbreviation($rate){
		$res=null;
		$result = get_option('ls_cb_kurs');
		foreach ($result['currencies'] as $k=>$v){
			if ($result['currencies']["$k"]['Cur_Abbreviation']==$rate){
				$res=$result['currencies']["$k"]['Cur_OfficialRate'];
				break;
			}
		}
		return $res;
	}

	function ls_cb_get_currencies(){
		return get_option('ls_cb_kurs')['currencies'];

	}

	function ls_cb_get_usd_rate(){
		return ls_cb_get_currency_by_abbreviation('USD');
	}

	function ls_cb_get_eur_rate(){
		return ls_cb_get_currency_by_abbreviation('EUR');
	}

	function ls_cb_get_rub_rate(){
		return ls_cb_get_currency_by_abbreviation('RUB');
	}

	add_action( 'admin_menu', function(){
	        add_menu_page(
            'LS WP Currency BYN',
            'LS WP Currency BYN',
            'manage_options',
            LS_WP_CURRENCY_BYN_NAME . '/ls-wp-currency-byn-page.php',
            '',
            plugins_url( 'images/menu-icon.svg', __FILE__ ),
            83
		);
	});
?>