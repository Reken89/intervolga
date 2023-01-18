<?php

//Определим тип загружаемого файла
$type = $_FILES['file_file']['type'];

//Если файл действительно CSV, выполняем загрузку файла на сервер
if ($type == 'text/csv'){ 
    //Загружаем файл на сервер (Для безопасности, выполняем загрузку не в корень проета!)
    $goal = copy($_FILES['file_file']['tmp_name'],$_SERVER['DOCUMENT_ROOT']."/intervolga/csv/".basename($_FILES['file_file']['name']));

    //Записываем в переменную file путь до csv файла
    $file = $_SERVER['DOCUMENT_ROOT']."/intervolga/csv/".$_FILES['file_file']['name'];

    //Для чтения CSV файла использую функцию fgetcsv
    //fgetcsv — Читает строку из файла и производит разбор данных CSV
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

            //Записываю нужную информацию в файлы
            $file = $_SERVER['DOCUMENT_ROOT']."/intervolga/upload/".$data[0];
            if (!file_exists($file)){
                $fp = fopen("$file", "w");
                fwrite($fp, $data[1]);
                fclose($fp);
            }
        }
        fclose($handle);
    }
        echo "Задача выполнена";
}else{
    echo "Формат файла отличается от CSV";
}