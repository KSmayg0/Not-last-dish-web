<?php
session_start();
include("../config/connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../css/registr.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <title>Document</title>
</head>
<body>
    <a href="../index.php" class="signin"> <div class="signin-btn">
       Вход
    </div></a>
  <div class="suptitle">Уже есть аккаунт? Войдите в него</div>
  <div class="registr-title"><div class="">
    Регистрация</div></div>
      <section>
        <div class="imgupblock">
          <img src="../css/Maskgroupup.png" alt="" class="imgup">
        </div>
  <form name="form" action="../registr.php" method="post" enctype="multipart/form-data">
    <div class="backgr">
      <?php if (isset($_SESSION['notok'])) { ?>
  <div class="message-block"> <?php echo $_SESSION['notok']; unset($_SESSION['notok']); ?></div>
    <?php  }; ?>
    <div class="img">
      <img id="blanh" src="../css/ava_default.png">
    </div>
<label for="imgInp" class="input-file">
<input accept="image/*" type="file" name="file" id="imgInp" >
</label>

        <?php if (isset($_SESSION['nickname'])) { ?>
    <div class="message-block"> <?php echo $_SESSION['nickname']; unset($_SESSION['nickname']); ?></div>
      <?php  }; ?>
        <input type="text" name="nickname" placeholder="Ник *" value="<?php if(isset($_SESSION['nicknamevalue'])) echo $_SESSION['nicknamevalue']; ?>"/>
        <label for="nickname">Ник будет отображаться всем пользователям</label>
        <?php if (isset($_SESSION['name'])) { ?>
        <div class="message-block"> <?php echo $_SESSION['name']; unset($_SESSION['name']); ?></div>
        <?php  }; ?>
        <input type="text" name="name" placeholder="Имя" value="<?php if(isset($_SESSION['namevalue'])) echo $_SESSION['namevalue']; ?>"/>
        <?php if (isset($_SESSION['surname'])) { ?>
        <div class="message-block"> <?php echo $_SESSION['surname']; unset($_SESSION['surname']); ?></div>
        <?php  }; ?>
        <input type="text" name="surname" placeholder="Фамилия" value="<?php if(isset($_SESSION['surnamevalue'])) echo $_SESSION['surnamevalue']; ?>"/>
        <label for="surname">Отображение имени и фамилии можно будет отключить в настройках в любой момент</label>
        <?php if (isset($_SESSION['email'])) { ?>
    <div class="message-block"> <?php echo $_SESSION['email']; unset($_SESSION['email']); ?></div>
      <?php  }; ?>
        <input type="mail" name="email" placeholder="Электронная почта *" value="<?php if(isset($_SESSION['emailvalue'])) echo $_SESSION['emailvalue']; ?>"/>
        <?php if (isset($_SESSION['logpas'])) { ?>
        <div class="message-block"> <?php echo $_SESSION['logpas']; unset($_SESSION['logpas']); ?></div>
        <?php  }; ?>
        <?php if (isset($_SESSION['login'])) { ?>
        <div class="message-block"> <?php echo $_SESSION['login']; unset($_SESSION['login']); ?></div>
        <?php  }; ?>
        <input type="text" name="login" placeholder="Логин *" value="<?php if(isset($_SESSION['loginvalue'])) echo $_SESSION['loginvalue']; ?>"/>
        <div class="block-for-input">
          <input type="text" name="password" id="pass" placeholder="Пароль *"/>
<div class="block-base"></div>
          <div id="block-check"></div>
        </div>
        <ul>
          <li id="li1">Пароль должен содержать не менее 6 символов</li>
          <li id="li2">Заглавные буквы и строчные буквы</li>
          <li id="li3">Специальные символы</li>
          <li id="li4">Минимум 1 цифру</li>
        </ul>
        <input type="password" name="password_confirm" id="passconfirm" placeholder="Подтверждение пароля *">
        <?php if(isset($_SESSION['confirm'])) { ?>
<div class="message-block"> <?php echo $_SESSION['confirm']; unset($_SESSION['confirm']); ?></div>
        <?php }; ?>
        <div class="checkbox checkbox-first">
          <input type="checkbox" name="terms"><span>Я принимаю</span><a class="links" href="#">Пользовательское соглашение</a>
        </div>
        <div class="checkbox checkbox-second">
          <input type="checkbox" name="privacy"><span>Я принимаю</span><a class="links" href="#">Политику конфиденциальности</a>
        </div>
            </div>
            <div class="imgbotblock">
              <img src="../css/Maskgroupbottom.png" alt="" class="imgbot">
            </div>
        <div class="submit-block">
          <input type="submit" name="submit" class="registr-btn" value="Создать">
        </div>

  </form>
    </section>
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
  <script type="text/javascript">


  var s_letters = "qwertyuiopasdfghjklzxcvbnm"; // Буквы в нижнем регистре
  var b_letters = "QWERTYUIOPLKJHGFDSAZXCVBNM"; // Буквы в верхнем регистре
  var digits = "0123456789"; // Цифры
  var specials = "!@#$%^&*()_-+=\|/.,:;[]{}"; // Спецсимволы

  var input_test = document.getElementById('pass');//получаем поле
  var pass_confirm = document.getElementById('passconfirm');
  var block_check = document.getElementById('block-check');//получаем блок с индикатором
  var li1 = document.getElementById('li1');
    var li2 = document.getElementById('li2');
    var li4 = document.getElementById('li4');

  input_test.addEventListener('keyup', function(evt){
  var input_test_val = input_test.value;//получаем значение из поля

  var is_s = false; // Есть ли в пароле буквы в нижнем регистре
  var is_b = false; // Есть ли в пароле буквы в верхнем регистре
  var is_d = false; // Есть ли в пароле цифры
  var is_sp = false; // Есть ли в пароле спецсимволы

  for (var i = 0; i < input_test_val.length; i++) {
      /* Проверяем каждый символ пароля на принадлежность к тому или иному типу */
      if (!is_s && s_letters.indexOf(input_test_val[i]) != -1) {
           is_s = true
      }
      else if (!is_b && b_letters.indexOf(input_test_val[i]) != -1) {
            is_b = true
      }
      else if (!is_d && digits.indexOf(input_test_val[i]) != -1) {
             is_d = true
      }
      else if (!is_sp && specials.indexOf(input_test_val[i]) != -1) {
             is_sp = true
      }
  }

  var rating = 0;
  var check=0;
  if(input_test_val.length>5) {
    check++;
    li1.classList.add('right');
  } else {
    li1.classList.remove('right');
  }
  if (is_s) rating++; // Если в пароле есть символы в нижнем регистре, то увеличиваем рейтинг сложности
  if (is_b) rating++;
  if((is_s==true)&&(is_b==true)) {
    check++;
    li2.classList.add('right');
  } else {
    li2.classList.remove('right');
  } // Если в пароле есть символы в верхнем регистре, то увеличиваем рейтинг сложности
  if (is_d) {
    rating++;
    check++;
      li4.classList.add('right');
  }else {
    li4.classList.remove('right');
  }; // Если в пароле есть цифры, то увеличиваем рейтинг сложности
  if (is_sp) {
    rating++;
    check++;
    li3.classList.add('right');
  }else {
    li3.classList.remove('right');
  };
  // Если в пароле есть спецсимволы, то увеличиваем рейтинг сложности
  /* Далее идёт анализ длины пароля и полученного рейтинга, и на основании этого готовится текстовое описание сложности пароля */
  if (input_test_val.length < 6 && rating < 3) {
      block_check.style.width = "10%";
      block_check.style.backgroundColor = '#e7140d';
  }
  else if (input_test_val.length < 6 && rating >= 3) {
      block_check.style.width = "50%";
      block_check.style.backgroundColor = '#ffdb00';
  }
  else if (input_test_val.length >= 8 && rating < 3) {
      block_check.style.width = "50%";
      block_check.style.backgroundColor = '#ffdb00';
  }
  else if (input_test_val.length >= 8 && rating >= 3) {
      block_check.style.width = "100%";
      block_check.style.backgroundColor = '#61ac27';
  }
  else if (input_test_val.length >= 6 && rating == 1) {
      block_check.style.width = "10%";
      block_check.style.backgroundColor = '#e7140d';
  }
  else if (input_test_val.length >= 6 && rating > 1 && rating < 4) {
      block_check.style.width = "50%";
      block_check.style.backgroundColor = '#ffdb00';
  }
  else if (input_test_val.length >= 6 && rating == 4) {
      block_check.style.width = "100%";
      block_check.style.backgroundColor = '#61ac27';
  };
  });
  </script>
</body>
</html>
