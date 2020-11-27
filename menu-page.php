    <h1 class="wp-heading">КУРСЫ ВАЛЮТ</h1>
    <?PHP $money=GET_OPTION('kurs');?>
    <h2><?php echo "update date: $money[date]"?></h2>
    <h2><?php echo "1 USD: $money[USD]"?></h2>
    <h2><?php echo "1 EUR: $money[EUR]"?></h2>
    <h2><?php echo "100 RUB: $money[RUB]"?></h2>
   <?php var_dump($money)?>