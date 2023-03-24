<?php
session_start();
include ("config/connect.php");
$sql="SELECT * FROM `User` WHERE `idUser`='{$_SESSION['idUser']}'";
$result= mysqli_query($connect, $sql);
$user=mysqli_fetch_assoc($result);

if(isset($_REQUEST['search-ingr-up'])) {
  $inputSearch=$_REQUEST['search-ingr-up'];
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
      echo "<div class='ingredient-block'><a class='link-update' href='update.php?id=".$row['idIngredient']."#srup'><img src='css/update.png'></a><img class='ingr-search-picture' src='ingredients/".$row['picture']."' >
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
  }
}

if(isset($_REQUEST['search-ingr-del'])) {
  $inputSearch1=$_REQUEST['search-ingr-del'];
  if($inputSearch1!=NULL) {
    if((strlen($inputSearch1)/2)==1) {
      $symbol1=mb_substr($inputSearch1,0);
        $sql="SELECT * FROM `Ingredient` WHERE `name`='$inputSearch1' OR (`name` LIKE '{$symbol1}%') ORDER BY `name` ASC";
        $result=mysqli_query($connect,$sql);
    } else {
      $symbol3=mb_substr($inputSearch1,0,3);
        $sql="SELECT * FROM `Ingredient` WHERE `name`='$inputSearch1' OR (`name` LIKE '%{$symbol3}%')";
        $result=mysqli_query($connect,$sql);
    }

  } else {
    $sql="SELECT * FROM `Ingredient` WHERE `name`='$inputSearch1'";
    $result=mysqli_query($connect,$sql);
  }
}

function countPeople1($result) {
    $kol=0;
  if($result->num_rows>0) {
    while($row=$result->fetch_assoc()) {
      $arr=doesItExist($row);
      //Вывод данных
      if($kol % 3==0) {
        echo "<div class='ingredient-list'>";
      }
      echo "<div class='ingredient-block'><a class='link-update' href='update.php?idd=".$row['idIngredient']."#srdel'><img src='css/trash.png'></a><img class='ingr-search-picture' src='ingredients/".$row['picture']."' >
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
  <link rel="stylesheet" href="css/moder.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
 <link rel="preconnect" href="https://fonts.googleapis.com">
 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
 <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Roboto:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
  <title>Режим модератора</title>
</head>
<body>
  <header>
    <div class="logo"> <a class="logo-text" href="../main/main.php">Not last dish</a> </div>
    <div class="search-block">
      <input type="text" name="search" placeholder="Поиск">
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
    <li class="create"><a href="#"><img src="../css/Create_icon.png" alt=""><div>Создать рецепт</div></a></li>
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
    <div class="up-block">
      <h1>Режим модератора</h1>
      <?php if (isset($_SESSION['ok'])) { ?>
      <div class="message-block-good"> <?php echo $_SESSION['ok']; unset($_SESSION['ok']); ?></div>
      <?php  }; ?>
    </div>

<div class="list-block">

  <!-- Вывод группы элементов ингредиентов -->

<button class="btn-list btn-ingredients" type="button" name="button">Добавить / Изменить / Удалить ингредиенты<img class="row-in" src="css/arrow_next.png" alt=""></button>

<div class="ingredients-block <?php if(isset($_GET['search-ingr-up'])||(isset($_GET['id']))||(isset($_GET['idd']))||(isset($_GET['search-ingr-del']))) {echo "show-block";} else {echo "hide";} ?>" id="ingredients-block">

  <!-- Добавить ингредиент -->

<form class="add-ingr-form" action="ingradd.php" method="post" enctype="multipart/form-data">
<h3>Добавление ингредиента</h3>
  <?php if (isset($_SESSION['ingraddphoto'])) { ?>
<div class="message-block"> <?php echo $_SESSION['ingraddphoto']; unset($_SESSION['ingraddphoto']); ?></div>
<?php  }; ?>

  <div class="img">
    <img id="blanh" src="../css/ingr_icon.png">
  </div>
  <label for="imgInp" class="input-file">
  <input accept="image/*" type="file" name="file" id="imgInp" >
  </label>
<div class="subtitle-img">
  Внимание! Добавляйте изображение с соответствующим названием ингредиента. Например: Банан - banan.
</div>
  <label for="title">Название ингредиента (не более 45 знаков). Это поле не может быть пустым.</label>
  <?php if (isset($_SESSION['ingraddtitle'])) { ?>
<div class="message-block"> <?php echo $_SESSION['ingraddtitle']; unset($_SESSION['ingraddtitle']); ?></div>
<?php  }; ?>
<input type="text" name="title" value="">
<label for="description">Описание ингредиента (не более 1000 знаков). Это поле не может быть пустым.</label>
<?php if (isset($_SESSION['ingradddescription'])) { ?>
<div class="message-block"> <?php echo $_SESSION['ingradddescription']; unset($_SESSION['ingradddescription']); ?></div>
<?php  }; ?>
<textarea class="description-ingr" type="text" name="description" value=""></textarea>
<input type="submit" name="submit-ingradd" value="Добавить">
</form>

<!--Изменить ингредиент-->

<div class="ingr-up-search-block">
<h3 class="title">Изменить ингредиент</h3>
<form id="srresup" class="" action="<?= $_SERVER['SCRIPT_NAME'] ?>#srresup">
  <input type="text" name="search-ingr-up" value="" placeholder="Введите название ингредиента">
  <input type="submit" name="submit-search-ingr-up" value="Найти">
</form>
<div class="ingr-list">
<?php
if(isset($inputSearch)) {
  countPeople($result); //Функция вывода ингредиентов
} else {
  echo "<div class='search-text'>Здесь отображается список ингредиентов.</div>";
}
 ?>
</div>
</div>
<form id="srup" class="up-ingr-form <?php if(isset($_GET['id'])) {echo "show";} else {echo "hide";} ?>" action="ingrup.php" method="post">
  <?php
  if(isset($_GET['id'])||isset($_SESSION['idIngredient'])) {
    if(isset($_GET['id']) && $_GET['id']!=NULL) {
      $_SESSION['idIngredient']=$_GET['id'];
 $updateIngredient=$_SESSION['idIngredient'];
 $sql="SELECT * FROM `Ingredient` WHERE `idIngredient`='{$updateIngredient}'";
 $result=mysqli_query($connect,$sql);
 $Ingredient=mysqli_fetch_assoc($result);
    }

 }
  ?>
<h3>Изменение ингредиента</h3>
<div class="img">
  <img id="blanh1" src="ingredients/<?php if(isset($_GET['id'])) {echo $Ingredient['picture'];} ?>">
</div>
<label for="imgInp" class="input-file">
<input accept="image/*" type="file" name="file" id="imgInp1" >
</label>
<div class="subtitle-img">
  Внимание! Добавляйте изображение с соответствующим названием ингредиента. Например: Банан - banan.
</div>
<?php if (isset($_SESSION['upingrname'])) { ?>
<div class="message-block"> <?php echo $_SESSION['upingrname']; unset($_SESSION['upingrname']); ?></div>
<?php  }; ?>
<label for="name">Название ингредиента (не более 45 знаков). Это поле не может быть пустым.</label>
<input type="text" name="name" value="<?php if(isset($_GET['id'])) { echo $Ingredient['name'];} ?>">

<?php if (isset($_SESSION['upingrdescription'])) { ?>
<div class="message-block"> <?php echo $_SESSION['upingrdescription']; unset($_SESSION['upingrdescription']); ?></div>
<?php  }; ?>

<label for="description">Описание ингредиента (не более 1000 знаков). Это поле не может быть пустым.</label>
<textarea class="description-ingr" type="text" name="description" value=""><?php if(isset($_GET['id'])) {echo $Ingredient['description'];} ?></textarea>
<input type="submit" name="submit-ingrup" value="Обновить">
</form>

<!-- Удаление ингредиента -->

<div class="ingr-del-search-block">
  <h3 class="title">Удалить ингредиент</h3>
<form id="srresdel" class="" action="<?= $_SERVER['SCRIPT_NAME'] ?>#srresdel">
  <input type="text" name="search-ingr-del" value="" placeholder="Введите название ингредиента">
  <input type="submit" name="submit-search-ingr-del" value="Найти">
</form>
<div class="ingr-list">
<?php
if(isset($inputSearch1)) {
  countPeople1($result); //Функция вывода ингредиентов
} else {
  echo "<div class='search-text'>Здесь отображается список ингредиентов.</div>";
}
 ?>
</div>
</div>
  <form id="srdel" class="del-ingr-form <?php if(isset($_GET['idd'])) {echo "show";} else {echo "hide";} ?>" action="ingrdel.php" method="post" enctype="multipart/form-data">
    <?php
    if(isset($_GET['idd'])||isset($_SESSION['idIngredient'])) {
      if(isset($_GET['idd']) && $_GET['idd']!=NULL) {
        $_SESSION['idIngredient']=$_GET['idd'];
   $deleteIngredient=$_SESSION['idIngredient'];
   $sql="SELECT * FROM `Ingredient` WHERE `idIngredient`='{$deleteIngredient}'";
   $result=mysqli_query($connect,$sql);
   $Ingredient=mysqli_fetch_assoc($result);
      }

   }
    ?>
  <h3>Удаление ингредиента</h3>
  <div class="img">
    <img src="ingredients/<?php if(isset($_GET['idd'])) {echo $Ingredient['picture'];} ?>">
  </div>

  <p>Название ингредиента: </p>
  <input type="text" name="name" value="<?php if(isset($_GET['idd'])) { echo $Ingredient['name'];} ?>">

  <p>Описание ингредиента: </p>
  <textarea class="description-ingr" type="text" name="description" value=""><?php if(isset($_GET['idd'])) {echo $Ingredient['description'];} ?></textarea>
  <input type="submit" name="submit-ingrdel" value="Удалить">
  </form>

</div> <!-- .ingredient-block -->

<!-- Блок добавления, изменения, удаления группы категорий-->

<button class="btn-list btn-categories" type="button" name="button">Добавить / Изменить / Удалить группу категорий<img class="row-ct" src="css/arrow_next.png" alt=""></button>
<div class="categories-block">
  <form class="" action="index.html" method="post">
    <span>Проверка группы категорий</span>
  </form>
</div>

<button class="btn-list btn-tag" type="button" name="button">Добавить / Изменить / Удалить категории<img class="row-tg" src="css/arrow_next.png" alt=""></button>
<div class="tag-block">
  <form class="" action="index.html" method="post">
    <span>Проверка категорий</span>
  </form>
</div>

</div><!-- .list-block -->
  </main>
  <?php
  echo '<script type="text/javascript">
  imgInp.onchange = evt => {
    const [file] = imgInp.files
    if (file) {
      blanh.src=URL.createObjectURL(file);
    }
  };
  imgInp1.onchange = evt => {
    const [file] = imgInp1.files
    if (file) {
      blanh1.src=URL.createObjectURL(file);
    }
  };
  imgInp2.onchange = evt => {
    const [file] = imgInp1.files
    if (file) {
      blanh2.src=URL.createObjectURL(file);
    }
  };
  </script>'
  ?>
  <script type="text/javascript" src="js/moder.js"></script>
</body>
</html>
