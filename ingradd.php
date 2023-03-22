<?php
//Добавление ингредиента в режиме модератора
session_start();
include ("config/connect.php");
function validate($data) {
  $data=trim($data);
  $data=stripslashes($data);
  return $data;
}
//Обработка
$title=validate($_POST['title']);
$description=validate($_POST['description']);

//Загрузка фотографии ингредиента
if(!empty($_FILES['file'])) {
  $file=$_FILES['file'];
  $filename=$file['name'];
  $pathFile=__DIR__.'/ingredients/'.$filename;

  if(!move_uploaded_file($file['tmp_name'], $pathFile)) {
    echo'Файл не смог загрузиться';
  }
}
if($filename==NULL) {
  $_SESSION['ingradd1']=false;
  $_SESSION['ingraddphoto']='Обязательно надо добавить фотографию';
  header('Location: update.php');
}else {
  $_SESSION['ingradd1']=true;
  unset($_SESSION['ingraddphoto']);
};
//Проверка названия ингредиента
if(strlen($title)>45 || empty($title)) {
  $_SESSION['ingraddtitle']='Вы превысили допустимый предел по количеству символов. У вас ' . strlen($title) . ' символов.';
  $_SESSION['ingradd2']=false;
  header('Location: update.php');
} else {
  $_SESSION['ingradd2']=true;
  unset($_SESSION['ingraddtitle']);
}
//Проверка описания ингредиента
if(strlen($description)>1000||empty($description)) {
  $_SESSION['ingradddescription']='Вы превысили допустимый предел по количеству символов. У вас ' . strlen($description) . ' символов.';
  $_SESSION['ingradd3']=false;
  header('Location: update.php');
} else {
  $_SESSION['ingradd3']=true;
  unset($_SESSION['ingradddescription']);
}
//Загрузка на сервер
if($_SESSION['ingradd1']==true && $_SESSION['ingradd2']==true && $_SESSION['ingradd3']==true) {
  $sql="INSERT INTO `Ingredient` (`name`,`picture`,`description`) VALUES ('$title','$filename','$description')";
  mysqli_query($connect,$sql);
  $_SESSION['ok']='Ингредиент успешно добавлен';
  unset($_SESSION['notok']);
  header('Location: update.php');
} else {
  $_SESSION['notok']='Что-то пошло не так';
  unset($_SESSION['ok']);
  header('Location: update.php');
}
?>
