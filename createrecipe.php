<?php
session_start();
include ("config/connect.php");
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
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/createrecipe.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
 <link rel="preconnect" href="https://fonts.googleapis.com">
 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
 <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Roboto:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
  <title>Создать рецепт</title>
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
    <h1>Добавить рецепт</h1>
    <form class="main-form" action="addrecipe.php" method="post">
      <!-- Основная информация рецепта -->
      Фотографии блюда. Должна быть хотя бы одна фотография.
      <input type="file" name="pictures" value="">
      <label for="title">Название рецепта/блюда (не более 70 знаков). Это поле не должно остаться пустым.</label>
<input type="text" name="title" value="" placeholder="Введите название рецепта">
<label for="description-recipe">Описание блюда (не более 1000 знаков). Это поле не должно остаться пустым.</label>
<input type="text" name="description-recipe" value="" placeholder="Введите описание блюда">
<label for="cooking_time">Введите время приготовления. Это поле вы можете оставить пустым.</label>
<input type="number" name="cooking_time" value="" placeholder="Время">
<select class="" name="">
  <option value=""></option>
  <option value="сек">сек</option>
  <option value="мин">мин</option>
  <option value="час">час</option>
  <option value="сут">сут</option>
</select>

<input type="number" name="" value="" placeholder="Количество">
<?php
$sql="SELECT * FROM `Unit`";
$result=mysqli_query($connect,$sql);
echo "<select name=''><option value=''></option>";
while($unit=mysqli_fetch_assoc($result)) {
  echo "<option value='{$unit['name']}'>{$unit['name']}</option>";
}
echo "</select>";
?>
<label for="portion">Введите количество порций</label>
<input type="number" name="portion" value="" placeholder="Количество">
<label for="calorific">Введите количество каллорий на одну порцию. Это поле вы можете оставить пустым.</label>
<input type="number" name="calorific" value="" placeholder="Количество">
<!-- Добавление ингредиента -->
<h3>Список ингредиентов</h3>
    <div class="ingredient-list">
      <button id='add' onclick="addIngr()">Добавить</button>
      <button id="del" onclick="removeIngr()">Удалить</button>
      <div class="" id="element-list">

      </div>
    </div>
    <h3>Приготовление</h3>
    <div class="description-list">
      <button id='add' onclick="addDes()">Добавить</button>
      <button id="del" onclick="removeDes()">Удалить</button>
      <div class="" id="desc-list">

      </div>
    </div>
<input type="submit" name="" value="Создать">
    </form>
  </main>
</div>
</body>
<script type="text/javascript">
var count=1;
function addIngr() {
  var elementlist = document.getElementById('element-list');
  var  element = document.createElement('div');
  element.setAttribute('id','element');
  element.innerHTML = `
            <label>Item ${count}</label>
            <input />`;
  elementlist.appendChild(element);
  //Чтобы форма не отправлялась
const of=document.querySelector('form')
of.addEventListener('click', e => {
//  elementlist.appendChild(element);
  const o=e.target;
  if(o.tagName!= 'BUTTON') return
  e.preventDefault()
})
count++;
}
function removeIngr() {
    var elementlist = document.getElementById('element-list');
    elementlist.removeChild(elementlist.lastChild);
  const of=document.querySelector('form')
  of.addEventListener('click', e => {
    const o=e.target;
    if(o.tagName!= 'BUTTON') return
    e.preventDefault()
    //o.closest('#element-list').removeChild(o.closest('#element'))
  })
  count--;
}
var count1=1;
function addDes() {
  var elementlist = document.getElementById('desc-list');
  var  element = document.createElement('div');
  element.setAttribute('id','step');
  element.innerHTML = `
            <label>Шаг ${count1}</label>
            <input />`;
  elementlist.appendChild(element);
  //Чтобы форма не отправлялась
const of=document.querySelector('form')
of.addEventListener('click', e => {
//  elementlist.appendChild(element);
  const o=e.target;
  if(o.tagName!= 'BUTTON') return
  e.preventDefault()
})
count1++;
}
function removeDes() {
    var elementlist = document.getElementById('desc-list');
    elementlist.removeChild(elementlist.lastChild);
  const of=document.querySelector('form')
  of.addEventListener('click', e => {
    const o=e.target;
    if(o.tagName!= 'BUTTON') return
    e.preventDefault()
    //o.closest('#element-list').removeChild(o.closest('#element'))
  })
  count1--;
}
</script>
</html>