<?php
session_start();
include ("config/connect.php");
$sql="SELECT * FROM `User` WHERE `idUser`='{$_SESSION['idUser']}'";
$result= mysqli_query($connect, $sql);
$user=mysqli_fetch_assoc($result);
function validate($data) {
  $data=trim($data);
  $data=stripslashes($data);
  return $data;
};
$nickname=validate($_POST['nickname']);
$name=validate($_POST['name']);
$surname=validate($_POST['surname']);
$mail=validate($_POST['email']);

//Проверка написания никнейма (строка, не содержащая специальных символов и не менее 4х символов впринципе)
//preg_match("#^[aA-zZ0-9\-_]",$nickname)
if(isset($nickname)&&strlen($nickname)>3 && !(preg_match('/[\'^£$%&*()}!{@#~?><>,|=_+¬-]/', $nickname))) {
unset($_SESSION['nickname']);
$_SESSION['11']=true;
} else {
    $_SESSION['11']=false;
$_SESSION['nickname']='Никнейм должен содержать в себе не менее 4х символов и не иметь специальных символов';
    header('Location: profile/updateprofile.php');
}
//Проверка электронной почты
$sql="SELECT * FROM `User` WHERE `email`='$mail'";
$result= mysqli_query($connect, $sql);//посылает запрос на сервер
$mail_check = mysqli_fetch_array($result, MYSQLI_ASSOC);
if(isset($mail)&&filter_var($mail,FILTER_VALIDATE_EMAIL)) {
  if($mail_check['email']==$mail && $mail_check['idUser']!=$user['idUser']) {
    $_SESSION['12']=false;
  $_SESSION['email']='Аккаунт на эту электронную почту уже существует';
      header('Location: profile/updateprofile.php');
  } else {
    $_SESSION['12']=true;
    unset($_SESSION['email']);
  };
} else {
    $_SESSION['12']=false;
  $_SESSION['email']='Электронная почта введена неправильно';
      header('Location: profile/updateprofile.php');
}
//Проверка имени на наличие специальных символов и цифр
if((preg_match("#[0-9]+#", $name))||(preg_match('/[\'^£$%&*()}!{@#~?><>,|=_+¬-]/', $name))) {
    $_SESSION['13']=false;
  $_SESSION['name']='Поле имя может содержать только буквы. (Это поле вы можете оставить пустым).';
    header("Location: profile/updateprofile.php");
} else {
  $_SESSION['13']=true;
  unset($_SESSION['name']);
}
//Проверка фамилии на наличие специальных символов и цифр
if((preg_match("#[0-9]+#", $surname))||(preg_match('/[\'^£$%&*()}!{@#~?><>,|=_+¬-]/', $surname))) {
    $_SESSION['14']=false;
  $_SESSION['surname']='Поле фамилия может содержать только буквы. (Это поле вы можете оставить пустым).';
    header("Location: profile/updateprofile.php");
} else {
  $_SESSION['14']=true;
  unset($_SESSION['surname']);
};
if($_SESSION['11']==true && $_SESSION['12']==true && $_SESSION['13']==true && $_SESSION['14']==true) {
  if(!empty($_FILES['file'])) {
    $file=$_FILES['file'];
    $filename=$file['name'];
    $pathFile=__DIR__.'/imgavatar/'.$filename;
    $prevImg=__DIR__.'/imgavatar/'.$user['avatar'];
    if(!move_uploaded_file($file['tmp_name'], $pathFile)) {
      echo'Файл не смог загрузиться';
    } else {
      unlink($prevImg);
    }
  };
  if($filename==NULL) {
    $filename=$user['avatar'];
  };
  $sql="UPDATE `User` SET `nickname`='{$nickname}',`name`='{$name}',`surname`='{$surname}', `email`='{$mail}',`avatar`='{$filename}' WHERE `idUser`='{$user['idUser']}'";
  mysqli_query($connect,$sql);

  $_SESSION['ok']='Профиль успешно изменён';
  header("Location: profile/profile.php");
} else {
  unset($_SESSION['ok']);
    header("Location: profile/updateprofile.php");
}
?>
