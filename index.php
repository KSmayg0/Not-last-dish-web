<?php
include("config/connect.php");
session_start();
unset($_SESSION['nicknamevalue']);
unset($_SESSION['emailvalue']);
unset($_SESSION['namevalue']);
unset($_SESSION['surnamevalue']);
unset($_SESSION['loginvalue']);
unset($_SESSION['passwordvalue']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <title>Not last dish</title>
</head>
<body>
  <section class="section-login">
      <div class="registr-block">
    <?php if (isset($_SESSION['ok'])) { ?>
  <div class="registr-message-block">
      <p class="registr-message"><?php echo $_SESSION['ok']; unset($_SESSION['ok']); ?></p>
  </div>
      <?php }; ?>
        </div>
  <div class="main-block">
  <form action="login.php" method="post" enctype="multipart/form-data">
    <?php
if(isset($_GET['error'])) {
  ?>
  <div class="error-block">
  <div class="error"> <?php echo $_GET['error'];?></div> </div>
<?php }; ?>

        <input type="text" id="login" name="login" placeholder="Логин">
        <input type="password" id="password" name="password" placeholder="Пароль">
        <div class="forget-pass-block"><a class="forget-pass" href="#">Забыли пароль?</a></div>
        <div class="checkbox-block"><label class="checkbox">
          <input type="checkbox"><span class="fake"></span> <span class="text">Запомнить меня</span>
          </label></div>
        <div class="button-submit"><input type="submit" id="btn" value="Войти" name="submit" /></div>
  </form>
  </div>
    </section>
    <div class="subtitle-block">
      <p class="subtitle">Нет аккаунта? Зарегистрируйтесь здесь</p>
    </div>
    <section class="section-registr">
        <a href="registration/registration.php" class="registr"> <div class="registr-btn">
           Регистрация
        </div></a>
    </section>
    <script type="text/javascript">
    </script>
</body>
</html>
