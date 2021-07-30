<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/vendor/bootstrap/bootstrap.min.css">
    <title>itrack тестовое задание</title>
</head>
<body>

<?php
// Подключаемся к базе данных sqlite
$db = new PDO('sqlite:D:\OpenServer\OpenServer\domains\itrack\cites.sqlite');

// Сортировка массивов по полю
function income($a, $b) {
    if ($a['income'] == $b['income']) {
        return 0;
    }
    return ($a['income'] > $b['income']) ? -1 : 1;
}

function cost($a, $b) {
    if ($a['cost'] == $b['cost']) {
        return 0;
    }
    return ($a['cost'] > $b['cost']) ? -1 : 1;
}

function city_residents($a, $b) {
    if ($a['city_residents'] == $b['city_residents']) {
        return 0;
    }
    return ($a['city_residents'] > $b['city_residents']) ? -1 : 1;
}
?>



<div class="cities">
    <div class="container">
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-center" scope="col">#</th>
                            <th class="text-center" scope="col">Название</th>
                            <th class="text-center" scope="col">Доходы общие</th>
                            <th class="text-center" scope="col">Расходы общие</th>
                            <th class="text-center" scope="col">Количество жителей</th>
                            <th class="text-center" scope="col">Место в рейтинге по количеству жителей</th>
                            <th class="text-center" scope="col">Место в рейтинге по средним доходам населения</th>
                            <th class="text-center" scope="col">Место по средним расходам населения</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Делаем запрос к базе и сразу сделаем сортировку по количеству жителей
                        $st = $db->prepare("SELECT * FROM cities ORDER BY city_residents DESC");
                        $st->execute(array());
                        $results = $st->fetchAll();
                        $k = 1;

                        // Копируем и сортируем массивы, и изменяем индыксы массивов
                        $results_income = $array = array_merge(array(), $results);
                        uasort($results_income, 'income');
                        $results_income = array_values($results_income);

                        $results_cost = $array = array_merge(array(), $results);
                        uasort($results_cost, 'cost');
                        $results_cost = array_values($results_cost);

                        $results_city_residents = $array = array_merge(array(), $results);
                        uasort($results_city_residents, 'city_residents');
                        $results_city_residents = array_values($results_city_residents);



                        foreach ($results as $item) {
                            echo '<tr>';
                            echo '<th scope="row">' . $k . '</th>';
                            echo '<td class="text-center">' . $item['city'] . '</td>';
                            echo '<td class="text-center">' . $item['income'] . '</td>';
                            echo '<td class="text-center">' . $item['cost'] . '</td>';
                            echo '<td class="text-center">' . $item['city_residents'] . '</td>';


                            // Ищем в массиве номер ключа, который также является номером сортировки
                            // место в рейтинге по количеству жителей
                            $city = $item['city'];
                            $result_x = array_filter($results_city_residents, function($x) {
                                global $city;
                                return $x['city'] === $city;
                            });
                            $result_residents = key($result_x) + 1;
                            echo '<td class="text-center">' . $result_residents . '</td>';

                            // место в рейтинге по средним доходам населения
                            $result_x = array_filter($results_income, function($x) {
                                global $city;
                                return $x['city'] === $city;
                            });
                            $result_income = key($result_x) + 1;
                            echo '<td class="text-center">' . $result_income . '</td>';

                            // место по средним расходам населения
                            $result_x = array_filter($results_cost, function($x) {
                                global $city;
                                return $x['city'] === $city;
                            });
                            $result_cost = key($result_x) + 1;
                            echo '<td class="text-center">' . $result_cost . '</td>';
                            
                            echo '</tr class="text-center">';
                            $k++;
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
