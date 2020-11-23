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
		$url=['USD'=>'https://www.nbrb.by/api/exrates/rates/usd?parammode=2',
		 'EUR'=>'https://www.nbrb.by/api/exrates/rates/eur?parammode=2',
		 'RUB'=>'https://www.nbrb.by/api/exrates/rates/rub?parammode=2'
		];
		$usd=wp_remote_get( $url['USD'] );
		$usd=wp_remote_retrieve_body($usd);
		$usd=json_decode($usd, true);
		$eur=wp_remote_get( $url['EUR'] );
		$eur=wp_remote_retrieve_body($eur);
		$eur=json_decode($eur, true);
		$rub=wp_remote_get( $url['RUB'] );
		$rub=wp_remote_retrieve_body($rub);
		$rub=json_decode($rub, true);
		$RUB=$rub["Cur_OfficialRate"];
		$USD=$usd["Cur_OfficialRate"];
		$EUR=$eur["Cur_OfficialRate"];
		$money=["RUB"=>$RUB,"USD"=>"$USD","EUR=>$EUR"];
		update_option('kurs',$money);
	}
	//Создание меню
	add_action( 'admin_menu', function(){
		$money=get_option('kurs');
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
?>