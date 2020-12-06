<?php
	/*	Plugin Name: Currency BYN	
	Plugin URI: https://wordpress.org/plugins/Currency BYN
	Description: Shows currency exchange rates for Belarus
	Version: 0.1.0
	Author: LS
	Author URI: 
	Text Domain:
	*/
	register_activation_hook(__FILE__,'activationmoney');

 	function activationmoney(){
		wp_clear_scheduled_hook('update_curse');
		wp_schedule_event( time(), 'twicedaily', 'update_curse');
		updaterubusdeur();
	}

	add_action('update_curse', 'updaterubusdeur');

	function updaterubusdeur(){
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
	function GET_currency($rate){
		$result = get_option('kurs');
		foreach ($result['currencies'] as $k=>$v){
			if ($result['currencies']["$k"]['Cur_Abbreviation']==$rate){
				$res=$result['currencies']["$k"]['Cur_OfficialRate'];
			}
		}
		return $res;
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
	
	register_deactivation_hook( __FILE__, 'money_del' );
	
	function money_del() {
		wp_clear_scheduled_hook( 'update_curse' );
	}
?>
