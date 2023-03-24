<?php
//Файл на изменение ингредиента в режиме модератора
session_start();
include ("config/connect.php");
$sql="SELECT * FROM `Ingredient` WHERE `idIngredient`='{$_SESSION['idIngredient']}'";
$result=mysqli_query($connect,$sql);
$Ingredient=mysqli_fetch_assoc($result);
function validate($data) {
  $data=trim($data);
  $data=stripslashes($data);
  return $data;
};
$name=$_POST['name'];
$description=$_POST['description'];
//Проверка названия ингредиента
if(strlen($name)>45 || empty($name)) {
  $_SESSION['upingrname']='Вы превысили допустимый предел по количеству символов. У вас ' . strlen($name) . ' символов.';
  $_SESSION['ingrup1']=false;
  header("Location: update.php?id=". $_SESSION['idIngredient']."#srup");
} else {
  $_SESSION['ingrup1']=true;
  unset($_SESSION['upingrname']);
}
//Проверка описания ингредиента
if(strlen($description)>1000||empty($description)) {
  $_SESSION['upingrdescription']='Вы превысили допустимый предел по количеству символов. У вас ' . strlen($description) . ' символов.';
  $_SESSION['ingrup2']=false;
  header("Location: update.php?id=".$_SESSION['idIngredient']."#srup");
} else {
  $_SESSION['ingrup2']=true;
  unset($_SESSION['upingrdescription']);
}
//проверка изображения
if(!empty($_FILES['file'])) {
  $file=$_FILES['file'];
  $filename=$file['name'];
  $pathFile=__DIR__.'/ingredients/'.$filename;
  $prevImg=__DIR__.'/ingredients/'.$user['avatar'];
  if(!move_uploaded_file($file['tmp_name'], $pathFile)) {
    echo'Файл не смог загрузиться';
  } else {
    unlink($prevImg);
  }
};
if($filename==NULL) {
  $filename=$Ingredient['picture'];
};
if($_SESSION['ingrup1']==true && $_SESSION['ingrup2']==true) {
  $sql="UPDATE `Ingredient` SET `name`='{$name}', `picture`='{$filename}', `description`='{$description}' WHERE `idIngredient`='{$Ingredient['idIngredient']}'";
  mysqli_query($connect,$sql);
  $_SESSION['ok']='Игредиент успешно изменён';
  header('Location: update.php');
} else {
unset($_SESSION['ok']);
}
 ?>
