<?php
	/*	Plugin Name: Currency BYN	
		Description: Shows currency exchange rates for Belarus
		Version: 1.0.0
		Author: Lightning-Soft
		Text Domain: ls_cb
	*/

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
		
		update_option('kurs', $result);
	} 

	function ls_cb_get_currency_by_abbreviation($rate){
		$res=null;
		$result = get_option('kurs');
		foreach ($result['currencies'] as $k=>$v){
			if ($result['currencies']["$k"]['Cur_Abbreviation']==$rate){
				$res=$result['currencies']["$k"]['Cur_OfficialRate'];
				break;
			}
		}
		return $res;
	}

	function ls_cb_get_currencies(){
		return get_option('kurs')['currencies'];
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
            'Currency BYN',
            'Currency BYN',
            'manage_options',
            'money/menu-page.php',
            '',
            plugins_url( 'money/images/menu-icon.svg' ),
            83
		);
	});
	
	register_deactivation_hook( __FILE__, 'ls_cb_money_del' );
	
	function ls_cb_money_del() {
		wp_clear_scheduled_hook( 'ls_cb_update_curse' );
	}
?>
