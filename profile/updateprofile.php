<?php
session_start();
include("../config/connect.php");
$sql="SELECT * FROM `User` WHERE `idUser`='{$_SESSION['idUser']}'";
$result= mysqli_query($connect, $sql);
$user=mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../css/header.css">
  <link rel="stylesheet" href="../css/updateprofile.css">
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
    <h1>Изменение профиля пользователя</h1>
    <div class="profile-change-block">
      <form class="form-block" action="../updtprofile.php" method="post" enctype="multipart/form-data">
        <div class="img">
          <img id="blanh" src="../<?php if($user['avatar']==NULL) {
            echo "css/ava_default.png";
          } else {
            echo "imgavatar/{$user['avatar']}";
          }; ?>">
        </div>
    <label for="imgInp" class="input-file" name="file">
    <input accept="image/*" type="file" name="file" id="imgInp" >
    </label>
      <?php if (isset($_SESSION['nickname'])) { ?>
    <div class="message-block"> <?php echo $_SESSION['nickname']; unset($_SESSION['nickname']); ?></div>
    <?php  }; ?>
      <input class="input-change" type="text" name="nickname" placeholder="Ник *" value="<?php echo "{$user['nickname']}"; ?>"/>
      <label for="nickname">Ник отображается всем пользователям</label>
      <?php if (isset($_SESSION['name'])) { ?>
      <div class="message-block"> <?php echo $_SESSION['name']; unset($_SESSION['name']); ?></div>
      <?php  }; ?>
      <input class="input-change" type="text" name="name" placeholder="Имя" value="<?php echo"{$user['name']}"; ?>"/>
      <?php if (isset($_SESSION['surname'])) { ?>
      <div class="message-block"> <?php echo $_SESSION['surname']; unset($_SESSION['surname']); ?></div>
      <?php  }; ?>
      <input class="input-change" type="text" name="surname" placeholder="Фамилия" value="<?php echo"{$user['surname']}"; ?>"/>
      <label for="surname">Отображение имени и фамилии можно будет отключить в настройках в любой момент</label>
      <?php if (isset($_SESSION['email'])) { ?>
    <div class="message-block"> <?php echo $_SESSION['email']; unset($_SESSION['email']); ?></div>
    <?php  }; ?>
      <input class="input-change" type="mail" name="email" placeholder="Электронная почта *" value="<?php echo"{$user['email']}"; ?>"/>
      <div class="submit-block">
        <input type="submit" name="submit" class="registr-btn" value="Подтвердить">
      </div>
</form>
  </div>
    </div>
  </main>
  <?php
  echo '<script type="text/javascript">
  imgInp.onchange = evt => {
    const [file] = imgInp.files
    if (file) {
      blanh.src=URL.createObjectURL(file);
    }
  };
  </script>'
  ?>
</body>
</html>
