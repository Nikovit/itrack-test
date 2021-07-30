<?php

// Считываем файл с данными, пусть он будет в формате json и в виде ассациативного архива
$json = array_values(json_decode(file_get_contents('cities.json'), true));

// Подключаемся к базе данных sqlite
$db = new PDO('sqlite:/mnt/disk2/admin/web/575975-cg37528.tmweb.ru/public_html/itrack/cites.sqlite');


// Записываем значения в базу
foreach ($json as $json_item){
    $update_db = $db->prepare("INSERT INTO cities (city, income, cost, city_residents) VALUES (:city, :income, :cost, :city_residents)");
    $update_db->bindParam(':city', $json_item["city"]);
    $update_db->bindParam(':income', $json_item["income"]);
    $update_db->bindParam(':cost', $json_item["costs"]);
    $update_db->bindParam(':city_residents', $json_item["city residents"]);
    $update_db->execute();
}





