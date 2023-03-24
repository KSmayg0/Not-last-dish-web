<?php
include ("config/connect.php");
session_start();
$sql="DELETE FROM `Ingredient` WHERE `idIngredient`='{$_SESSION['idIngredient']}'";
$result=mysqli_query($connect,$sql);
if($result) {
  $_SESSION['ok']="Ингредиент успешно удалён";
  header('Location: update.php');
} else {
  $_SESSION['ok']="Удаление не прошло";
  header('Location: update.php');
}

 ?>
