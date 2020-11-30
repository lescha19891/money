    <?php $currencies = get_option('kurs');?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Курсы валют НБРБ</h1>
        <span class="date"><?=$currencies[date];?></span>
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
                <tr class="alternate">
                    <td
                        class="manage-column column-categories"
                        scope="col">USD</td>
                    <td 
                        class="manage-column column-categories"
                        scope="col"><?=$currencies[USD];?></td>
                    <td
                        class="manage-column"
                        scope="col"></td>
                </tr>
                <tr>
                    <td
                        class="manage-column "
                        scope="col">EUR</td>
                    <td 
                        class="manage-column column-categories"
                        scope="col"><?=$currencies[EUR];?></td>
                    <td
                        class="manage-column"
                        scope="col"></td>
                </tr>
                <tr class="alternate">
                    <td
                        class="manage-column"
                        scope="col">RUB</td>
                    <td 
                        class="manage-column column-categories"
                        scope="col"><?=$currencies[RUB];?></td>
                    <td
                        class="manage-column"
                        scope="col">За 100 RUB</td>
                </tr>
        </tbody>
    </table>
    </div>
    