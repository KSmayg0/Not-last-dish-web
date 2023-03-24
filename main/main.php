<?php
session_start();
include("../config/connect.php");
$sql="SELECT * FROM `User` WHERE `idUser`='{$_SESSION['idUser']}'";
$result= mysqli_query($connect, $sql);
$user=mysqli_fetch_assoc($result);

$categories = "SELECT `name_category` FROM `Categories`";
$result_category= mysqli_query($connect, $categories);
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <link rel="stylesheet" href="../css/main.css">
   <link rel="stylesheet" href="../css/header.css">
   <link rel="preconnect" href="https://fonts.googleapis.com">
 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
 <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Roboto:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
   <title>Главная страница</title>
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
}
   ?>
</header>
<div class="body">
<aside class="aside-block">
<ul class="menu">
  <li class="profile"><a href="../profile/profile.php"><img src="../css/Profile_icon.png" alt=""><div>Профиль</div></a></li>
  <li class="favorites"><a href="#"><img src="../css/Favorites_icon.png" alt=""><div>Избранное</div></a></li>
  <li class="create"><a href="#"><img src="../css/Create_icon.png" alt=""><div>Создать рецепт</div></a></li>
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
<h1>Категории</h1>
<div class="slider">
<div class="infinity-slider">
  <?php
while($group=mysqli_fetch_array($result_category)) {
  ?>
  <div class="category slider-item"><a href="#"><div><?php echo "{$group['name_category']}"; ?></div></a></div>
  <?php
}
   ?>
</div>
<a class="itc-slider_btn itc-slider_btn_prev"><img src="../css/arrow_prev.png" alt=""></a>
<a class="itc-slider_btn itc-slider_btn_next"><img src="../css/arrow_next.png" alt=""></a>
</div>
</main>
</div>
<footer>

</footer>

 </body>
<script src="../js/slider.js">
</script>
 </html>
