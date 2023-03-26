<?php
session_start();
include("../config/connect.php");
$sql="SELECT * FROM `User` WHERE `idUser`='{$_SESSION['idUser']}'";
$result= mysqli_query($connect, $sql);
$user=mysqli_fetch_assoc($result);

if(isset($_POST['submit'])) {
  $file='D:/OpenServer/OSPanel/domains/Recipes/imgavatar/'.$user['avatar'];
  unlink($file);
  $sql="UPDATE `User` SET `avatar` = NULL WHERE `idUser`={$user['idUser']}";
  $result= mysqli_query($connect, $sql);
  header('Location: profile.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/profile.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Roboto:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
  <title>Страница профиля</title>
</head>
<body>
  <header>
    <div class="logo"> <a class="logo-text" href="../main/main.php">Not last dish</a> </div>
    <div class="search-block">
      <input type="text" name="search" value="" placeholder="Поиск">
      <button type="button" name="button" class="button-search">Найти</button>
    </div>
    <?php
  if($user['idRole']=='Модератор') {
    echo '<a class="moder" href="../update.php"><div class="moder-button">Режим модератора</div></a>';
  };
     ?>
  </header>
  <div class="body">
  <aside class="aside-block">
  <ul class="menu">
    <li class="profile"><a href="../profile/profile.php"><img src="../css/Profile_icon.png" alt=""><div>Профиль</div></a></li>
    <li class="favorites"><a href="#"><img src="../css/Favorites_icon.png" alt=""><div>Избранное</div></a></li>
      <li class="create"><a href="../createrecipe.php"><img src="../css/Create_icon.png" alt=""><div>Создать рецепт</div></a></li>
    <li class="settings"><a href="#"><img src="../css/Settings_icon.png" alt=""><div>Настройки</div></a></li>
    <li class="tech_support"><a href="#"><div class="img-other"><img src="../css/Tech_icon.png" alt=""></div><div>Техническая поддержка</div></a></li>
    <li class="ingredients"><a href="../ingrlist.php"><div class="img-other"><img src="../css/Ingredients_icon.png" alt=""></div><div>Список ингредиентов</div></a></li>
    <li class="faq"><a href="#"><img src="../css/FAQ_icon.png" alt=""><div>FAQ</div></a></li>
  </ul>
  <div class="exit-block">
    <a href="../index.php">Выход</a>
  </div>
  </aside>
  <main>
<h1>Профиль пользователя</h1>
<div class="profile-block">
  <div class="change-profile-block">
    <div class="change-profile">
        <a href="updateprofile.php">Редактировать профиль</a>
    </div>
    <?php if (isset($_SESSION['ok'])) { ?>
    <div class="registr-message-block">
      <div class="registr-message"><?php echo $_SESSION['ok']; unset($_SESSION['ok']); ?></div>
    </div>
      <?php }; ?>
  </div>
  <div class="profile-header">
  <div class="profile-name">
    <div class="nickname"><?php echo "{$user['nickname']}"; ?></div>
    <div class="name-surname">
      <div class="name"><?php echo "{$user['name']}"; ?></div> <?php if ($user['name']!=NULL && $user['surname']!=NULL) echo "&nbsp"; ?><div class="surname"><?php echo "{$user['surname']}"; ?></div>
    </div>
    <div class="rang-block">
      Ранг пользователя: <?php if($user['rang']==NULL) {
        echo "нет ранга";
      } else {
        echo "{$user['rang']}";
      } ;   ?>
    </div>
  </div>
  <div class="avatar-block">
    <?php if($user['avatar']==NULL) {
      ?>
      <img class="user-avatar" src="../css/ava_default.png" alt="">
      <?php
    } else { ?>
    <img class="user-avatar" src="../imgavatar/<?= $user['avatar']; ?>" alt="">
    <?php
    } ?>
    <?php if($user['avatar']!=NULL) {
      ?>
      <form class="" action="profile.php" method="post">
        <input type="submit" name="submit" value="" />
      </form>
      <?php
    }
    ?>
  </div>
  </div>
<div class="email-block">
  <h3>Электронная почта</h3>
  <div class="email">
    <?php echo "{$user['email']}"; ?>
  </div>
</div>
<div class="stat-block">
  <div class="user-recipes">
    Выпущенных рецептов: <?php
    $sql="SELECT COUNT(*) AS `User_recipes` FROM `Recipe` WHERE `idUser`='{$user['idUser']}';";
    $result=mysqli_query($connect,$sql);
$userrecipes=mysqli_fetch_assoc($result);
echo "{$userrecipes['User_recipes']}";
    ?>
  </div>
  <div class="feedback">
    Оставленных отзывов: <?php
    $sql="SELECT COUNT(*) AS `Reviews_result` FROM `Review` WHERE `idUser_review`='{$user['idUser']}';";
    $result=mysqli_query($connect,$sql);
$reviews=mysqli_fetch_assoc($result);
echo "{$reviews['Reviews_result']}";
     ?>
  </div>
</div>
<div class="achivement-block">
<h3>Список достижений</h3>
<p>У вас пока нет достижений</p>
<div class="button-show"><a href="#">Показать все</a></div>
</div>
<hr>
<div class="user-recipes-block">
  <h3>Выпущенные рецепты</h3>
  <div class="user-recipes">
    У вас пока нет выпущенных рецептов
  </div>
</div>
</div>
  </main>
    </div>
</body>
</html>
