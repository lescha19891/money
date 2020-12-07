    <?php $result = get_option('ls_cb_kurs');?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Курсы валют НБРБ</h1>
        <span class="date"><?=$result['date'];?></span>
        <table class="widefat fixed"
        cellspacing="0">
        <thead>
            <tr>
                <th
                    class="manage-column column-categories"
                    scope="col">Валюта</th>
                <th
                    class="manage-column column-categories"
                    scope="col">Значение</th>
                <th
                    class="manage-column"
                    scope="col">Дополнительная информация</th>
            </tr>
        </thead>
            <tbody>
                <?php for($i = 1; $i < count($result['currencies']); $i++) : 
                    $currency = $result['currencies'][$i];
                ?>
                    <tr class="alternate">
                        <td
                            class="manage-column column-categories"
                            scope="col"><?=$currency['Cur_Abbreviation']?></td>
                        <td 
                            class="manage-column column-categories"
                            scope="col"><?=$currency['Cur_OfficialRate'];?></td>
                        <td
                            class="manage-column"
                            scope="col"><?=$currency['Cur_OfficialRate'];?> BYN за <?=$currency['Cur_Scale'];?> <?=$currency['Cur_Abbreviation']?></td>
                    </tr>
                <?php endfor;?>
        </tbody>
    </table>
    </div>
    
