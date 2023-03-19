<?php
include("config/connect.php");
    session_start();

if (isset($_POST['submit'])) {
  function validate($data) {
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
  }
  $login=validate($_POST['login']);
  $password=validate($_POST['password']);

  $sql="SELECT * FROM `User` WHERE `login`='$login' and `password`='$password'";
  $result= mysqli_query($connect, $sql);//посылает запрос на сервер
  $user=mysqli_fetch_assoc($result);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC); //возвращает массив: *ассоциативный*, численный или оба
  $count = mysqli_num_rows($result);//количество рядов результата запроса
  if($count==1) {
    $_SESSION['idUser']=$user['idUser'];
    header("Location: main/main.php");
  }
  else {
          unset($_SESSION['ok']);
    header("Location: index.php?error=Ошибка. Неправильный логин или пароль.");
  }
}


 ?>
