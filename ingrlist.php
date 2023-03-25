<?php
session_start();
include ("config/connect.php");
$sql="SELECT * FROM `User` WHERE `idUser`='{$_SESSION['idUser']}'";
$result= mysqli_query($connect, $sql);
$user=mysqli_fetch_assoc($result);


if(isset($_REQUEST['search'])&&($_REQUEST['search']!="")) {
  $inputSearch=$_REQUEST['search'];
  if($inputSearch!=NULL) {
    if((strlen($inputSearch)/2)==1) {
      $symbol1=mb_substr($inputSearch,0);
        $sql="SELECT * FROM `Ingredient` WHERE `name`='$inputSearch' OR (`name` LIKE '{$symbol1}%') ORDER BY `name` ASC";
        $result=mysqli_query($connect,$sql);
    } else {
      $symbol3=mb_substr($inputSearch,0,3);
        $sql="SELECT * FROM `Ingredient` WHERE `name`='$inputSearch' OR (`name` LIKE '%{$symbol3}%')";
        $result=mysqli_query($connect,$sql);
    }

  } else {
    $sql="SELECT * FROM `Ingredient` WHERE `name`='$inputSearch'";
    $result=mysqli_query($connect,$sql);
  }
} else if(isset($_REQUEST['search'])&&($_REQUEST['search']=="")) {
  $sql="SELECT * FROM `Ingredient`";
  $result=mysqli_query($connect,$sql);
} else {
  $sql="SELECT * FROM `Ingredient`";
  $result=mysqli_query($connect,$sql);
}

function doesItExist(array $arr) {
  //Создаём новый массив
  $data=array(
    'name'=> $arr['name'] != false ? $arr['name'] : 'Нет данных'
  );
  return $data;//Возвращаем массив
}

function countPeople($result) {
    $kol=0;
  if($result->num_rows>0) {
    while($row=$result->fetch_assoc()) {
      $arr=doesItExist($row);
      //Вывод данных
      if($kol % 3==0) {
        echo "<div class='ingredient-list'>";
      }
      echo "<div class='ingredient-block'><img class='ingr-search-picture' src='ingredients/".$row['picture']."' >
     <div class='ingredient-name'>".$row['name']."</div>
       <div class='ingredient-description'>".$row['description']."</div></div>";
       if($kol % 3==2) {
         echo "</div>";
       }
       $kol++;
    }
    if($kol % 3 !=0) {
      echo "</div>";
    }
  } else {

    echo "<div class='search-text'>По такому запросу ингредиенты в базе данных не найдены.</div>";
    $connect = mysqli_connect('localhost','root','','Recipes');
    $sql="SELECT * FROM `Ingredient`";
    $result=mysqli_query($connect,$sql);
    while($row=$result->fetch_assoc()) {
      $arr=doesItExist($row);
      //Вывод данных
      if($kol % 3==0) {
        echo "<div class='ingredient-list'>";
      }
      echo "<div class='ingredient-block'><img class='ingr-search-picture' src='ingredients/".$row['picture']."' >
     <div class='ingredient-name'>".$row['name']."</div>
       <div class='ingredient-description'>".$row['description']."</div></div>";
       if($kol % 3==2) {
         echo "</div>";
       }
       $kol++;
    }
    if($kol % 3 !=0) {
      echo "</div>";
    }

  }
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/ingrlist.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
 <link rel="preconnect" href="https://fonts.googleapis.com">
 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
 <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Roboto:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
  <title>Список ингредиентов</title>
</head>
<body>
  <header>
    <div class="logo"> <a class="logo-text" href="../main/main.php">Not last dish</a> </div>
    <div class="search-block">
      <form class="" action="<?= $_SERVER['SCRIPT_NAME'] ?>">
        <input type="text" name="search" value="" placeholder="Поиск ингредиентов">
        <input type="submit" name="button" class="button-search" value="Найти">
      </form>
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
      <li class="create"><a href="createrecipe.php"><img src="../css/Create_icon.png" alt=""><div>Создать рецепт</div></a></li>
    <li class="settings"><a href="#"><img src="../css/Settings_icon.png" alt=""><div>Настройки</div></a></li>
    <li class="tech_support"><a href="#"><div class="img-other"><img src="../css/Tech_icon.png" alt=""></div><div>Техническая поддержка</div></a></li>
    <li class="ingredients"><a href="ingrlist.php"><div class="img-other"><img src="../css/Ingredients_icon.png" alt=""></div><div>Список ингредиентов</div></a></li>
    <li class="faq"><a href="#"><img src="../css/FAQ_icon.png" alt=""><div>FAQ</div></a></li>
  </ul>
  <div class="exit-block">
    <a href="../index.php">Выход</a>
  </div>
  </aside>
  <main>
    <h1>Список ингредиентов</h1>
    <div class="ingr-list">
      <?php
countPeople($result);
       ?>
    </div>
  </main>
</div>
</body>
</html>
