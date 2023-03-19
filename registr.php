<?php
session_start();
include ("config/connect.php");
function validate($data) {
  $data=trim($data);
  $data=stripslashes($data);
  return $data;
}
//Сохранение значения с регистрации в input
$_SESSION['nicknamevalue']=$_POST['nickname'];
$_SESSION['emailvalue']=$_POST['email'];
$_SESSION['loginvalue']=$_POST['login'];
$_SESSION['namevalue']=$_POST['name'];
$_SESSION['surnamevalue']=$_POST['surname'];
//Значения, приходящие с формы
$nickname=validate($_POST['nickname']);
$name=validate($_POST['name']);
$surname=validate($_POST['surname']);
$mail=validate($_POST['email']);
$login=validate($_POST['login']);
$password=validate($_POST['password']);
$password_confirm=$_POST['password_confirm'];
//Загрузка аватара (фотографии)
if(!empty($_FILES['file'])) {
  $file=$_FILES['file'];
  $filename=$file['name'];
  $pathFile=__DIR__.'/imgavatar/'.$filename;

  if(!move_uploaded_file($file['tmp_name'], $pathFile)) {
    echo'Файл не смог загрузиться';
  }

} else {
  $filename=NULL;
}

//Проверка написания никнейма (строка, не содержащая специальных символов и не менее 4х символов впринципе)
//preg_match("#^[aA-zZ0-9\-_]",$nickname)
if(isset($nickname)&&strlen($nickname)>3 && !(preg_match('/[\'^£$%&*()}!{@#~?><>,|=_+¬-]/', $nickname))) {
unset($_SESSION['nickname']);
$_SESSION['1']=true;
} else {
    $_SESSION['1']=false;
$_SESSION['nickname']='Никнейм должен содержать в себе не менее 4х символов и не иметь специальных символов';
    header('Location: registration/registration.php');
}
//Проверка электронной почты
$sql="SELECT * FROM `User` WHERE `email`='$mail'";
$result= mysqli_query($connect, $sql);//посылает запрос на сервер
$mail_check = mysqli_fetch_array($result, MYSQLI_ASSOC);
if(isset($mail)&&filter_var($mail,FILTER_VALIDATE_EMAIL)) {
  if($mail_check['email']==$mail) {
    $_SESSION['2']=false;
  $_SESSION['email']='Аккаунт на эту электронную почту уже существует';
      header('Location: registration/registration.php');
  } else {
    $_SESSION['2']=true;
    unset($_SESSION['email']);
  };
} else {
    $_SESSION['2']=false;
  $_SESSION['email']='Электронная почта введена неправильно';
      header('Location: registration/registration.php');
}
//Проверка имени на наличие специальных символов и цифр
if((preg_match("#[0-9]+#", $name))||(preg_match('/[\'^£$%&*()}!{@#~?><>,|=_+¬-]/', $name))) {
    $_SESSION['3']=false;
  $_SESSION['name']='Поле имя может содержать только буквы. (Это поле вы можете оставить пустым).';
    header("Location: registration/registration.php");
} else {
  $_SESSION['3']=true;
  unset($_SESSION['name']);
}
//Проверка фамилии на наличие специальных символов и цифр
if((preg_match("#[0-9]+#", $surname))||(preg_match('/[\'^£$%&*()}!{@#~?><>,|=_+¬-]/', $surname))) {
    $_SESSION['4']=false;
  $_SESSION['surname']='Поле фамилия может содержать только буквы. (Это поле вы можете оставить пустым).';
    header("Location: registration/registration.php");
} else {
  $_SESSION['4']=true;
  unset($_SESSION['surname']);
}
//Проверка логина
if(isset($login)&&strlen($login)>5) {
  $_SESSION['5']=true;
  unset($_SESSION['login']);
} else {
  $_SESSION['5']=false;
  $_SESSION['login']='Логин должен содержать не менее 6 символов';
    header("Location: registration/registration.php");
}
//Проверка пароля

if(strlen($password)<6) {
    $_SESSION['predconfirm']=false;
  $_SESSION['confirm']='Пароль менее 6 знаков';
  header("Location: registration/registration.php");
} else if (!preg_match("#[0-9]+#", $password)) {
    $_SESSION['predconfirm']=false;
  $_SESSION['confirm']='Пароль не содержит в себе цифры';
  header("Location: registration/registration.php");
}else if(!preg_match('/[a-z]/', $password)) {
    $_SESSION['predconfirm']=false;
  $_SESSION['confirm']='Пароль не содержит в себе строчные буквы';
  header("Location: registration/registration.php");
}else if(!preg_match('/[A-Z]/', $password)) {
    $_SESSION['predconfirm']=false;
  $_SESSION['confirm']='Пароль не содержит в себе заглавные буквы';
  header("Location: registration/registration.php");
} else  if (!preg_match('/[\'^£$%&*()}!{@#~?><>,|=_+¬-]/', $password)) {
    $_SESSION['predconfirm']=false;
  $_SESSION['confirm']='Пароль не содержит в себе специальные символы';
  header("Location: registration/registration.php");
} else {
  $_SESSION['predconfirm']=true;
  unset ($_SESSION['confirm']);
};
//Проверка пароля на совпадение
if ($_SESSION['predconfirm']) {
  if($password===$password_confirm) {
    $_SESSION['6']=true;
    unset ($_SESSION['confirm']);
  } else {
    $_SESSION['6']=false;
    $_SESSION['confirm']='Пароли не совпадают';
      header("Location: registration/registration.php");
  }
};
//Проверка на наличие такого же логина и пароля
/*
$sql="SELECT * FROM `User` WHERE `login`='$login' && `password`='$password'";
$result= mysqli_query($connect, $sql);//посылает запрос на сервер
$count = mysqli_num_rows($result);
if($count==1) {
  $_SESSION['logpas']=false;
  $_SESSION['logpas']='Такой аккаунт уже существует';
    header("Location: registration/registration.php");
}
else {
  $_SESSION['logpas']=true;
  unset($_SESSION['logpas']);
}*/

if($_SESSION['1']==true && $_SESSION['2']==true && $_SESSION['3']==true && $_SESSION['4']==true && $_SESSION['5']==true && $_SESSION['6'] ==true && $_POST['terms'] && $_POST['privacy']) {
$sql="INSERT INTO `User` (`name`, `surname`, `nickname`,`avatar`, `login`, `password`, `idRole`, `email`) VALUES
  ( '$name', '$surname', '$nickname','$filename', '$login', '$password', 'Пользователь', '$mail' )";
  mysqli_query($connect, $sql);//посылает запрос на сервер
unset($_SESSION['notok']);
  $_SESSION['ok']='Регистрация прошла успешно';
  header("Location: index.php");
} else {
  $_SESSION['notok']='Что-то пошло не так';
  unset($_SESSION['ok']);
    header("Location: registration/registration.php");
}
?>
