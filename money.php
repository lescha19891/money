<?php
/*
	Plugin Name: money
    */
add_action('after_setup_theme','rubToMoney');
 function rubToMoney(){
	 //получение данных от Нацбанка
	 //соединение с БД
	 	$servername = "localhost";
		  $username = DB_USER; 
		  
	 	$password = DB_PASSWORD;
	 	$dbname = DB_NAME;
	 	$conn = mysqli_connect($servername, $username, $password, $dbname);
			if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
	 //проверка на существование и создание таблицы
		$sql = "CREATE TABLE IF NOT EXISTS  money_to_rub (
		ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
       	USD FLOAT UNSIGNED,
        EUR FLOAT UNSIGNED,
        RUR FLOAT UNSIGNED,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";
		mysqli_query($conn, $sql);
	 
	 //Запись данных Нацбанка в таблицу ,???ЗАПИСЫВАЕТ В БАЗУ 2 ЗН6АЧЕНИЯ???
	 $USD=2.55; $EUR=3.4; $RUR=0.5;
	 $sql="INSERT INTO money_to_rub ( USD, EUR, RUR)  VALUES ($USD, $EUR, $RUR)";
		mysqli_query($conn, $sql);

	 //вывод последней записи в массив

        $sql = "SELECT * FROM money_to_rub order by ID desc	limit 1";
		$result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array ($result); 
		$money_rub[] =[
        "ID"=>$row ['ID'],
        "USD"=>$row['USD'],
        "EUR"=>$row['EUR'],
		"RUR"=>$row [ 'RUR']
		];
	 //Очистка базы если записей больше 10
		if ($row ['ID']>10){
			$sql= "DROP TABLE  money_to_rub ";
			mysqli_query($conn, $sql);
		}	
		mysqli_close($conn);
		return  $money_rub; 
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
	})
?>