<?php
	/*	Plugin Name: money	*/
	register_activation_hook(__FILE__,'activationmoney');

 	function activationmoney(){
	//переустанавливаем крон задачи относящиеся к плагину
		wp_clear_scheduled_hook('update_curse');
		wp_schedule_event( time(), 'twicedaily', 'update_curse');
		updaterubusdeur();
	}

	add_action('update_curse', 'updaterubusdeur');

	function updaterubusdeur(){
		//получение данных с сайта НБРБ и запись в wp
		$url = 'https://www.nbrb.by/api/exrates/rates?periodicity=0';
		$response = wp_remote_get($url);
		$responseBody = wp_remote_retrieve_body($response);
		$currencies = json_decode($responseBody, true);
		$result = [
			'date' => $currencies[0]['Date'];
			'currencies' => []	
		];
		foreach($currencies as $currency){
			$result['currencies][] = [
				$currency['Cur_Abbreviation'] => $currency['Cur_OfficialRate']
			];
		}
		
		update_option('kurs', $result);
	}
	
	//Создание меню
	add_action( 'admin_menu', function(){
	        add_menu_page(
            'rub_to_money',
            'roublerate',
            'manage_options',
            'money/menu-page.php',
            '',
            plugins_url( 'money/images/menu-icon.svg' ),
            83
		);
	});
	
	//удаление плагина
	register_deactivation_hook( __FILE__, 'money_del' );
	
	function money_del() {
		wp_clear_scheduled_hook( 'update_curse' );
	}
?>
