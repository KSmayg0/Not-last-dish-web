<?php
$connect = mysqli_connect('localhost','root','','Recipes');

if(!$connect) {
    die('Ошибка подключения к БД');
}
//echo "Подключение произведено";
?>
