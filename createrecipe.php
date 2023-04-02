<?php
session_start();
include ("config/connect.php");
$sql="SELECT * FROM `User` WHERE `idUser`='{$_SESSION['idUser']}'";
$result= mysqli_query($connect, $sql);
$user=mysqli_fetch_assoc($result);

$sql="SELECT * FROM `Unit`";
$result=mysqli_query($connect,$sql);
$select="<select name=''><option value=''></option>";
while($unit=mysqli_fetch_assoc($result)) {
  $select=$select."<option value='{$unit['name']}'>{$unit['name']}</option>";
}
$select=$select."</select>";

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-http-equiv="Cache-Control" content="no-cache" />
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
    <form class="main-form" action="" method="post">
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

<label for="portion">Введите количество порций</label>
<input type="number" name="portion" value="" placeholder="Количество">
<label for="calorific">Введите количество каллорий на одну порцию. Это поле вы можете оставить пустым.</label>
<input type="number" name="calorific" value="" placeholder="Количество">
<!-- Добавление ингредиента -->
<h3>Список ингредиентов</h3>
    <div class="ingredient-list">
      <button id='add-in' onclick="addIngr()">Добавить</button>
      <button id="del-in" onclick="removeIngr()">Удалить</button>
      <div class="element-list" id="element-list">

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
//sessionStorage.clear();
//localStorage.clear();
  var elementlist = document.getElementById('element-list');
  var count;
  var desclist=document.getElementById('desc-list');
  var count1;
  var select=<?php echo json_encode($select); ?>
  /*Выводим массив session*/
  for(let i=1; i<sessionStorage.length+1; i++) {
//let key = sessionStorage.key(i);
  let el=document.createElement('div');
  el.innerHTML=sessionStorage.getItem(i);
  elementlist.appendChild(el);
 console.log(`${i}: ${sessionStorage.getItem(i)}`);
}

/*Выводим массив local*/
for(let i=1; i<localStorage.length+1; i++) {
//let key = sessionStorage.key(i);
let el=document.createElement('div');
el.innerHTML=localStorage.getItem(i);
desclist.appendChild(el);
//console.log(`${i}: ${localStorage.getItem(i)}`);
}

if(sessionStorage.length>=1) {
count=sessionStorage.length;
}
else {
  count=0;
}

if(localStorage.length>=1) {
count1=localStorage.length;
}
else {
  count1=0;
}

function addIngr() {
count++;
let elem = document.createElement('div');
elem.setAttribute('class','element');
elem.innerHTML="Ингредиент "+ count + ": <input type='number' name='' value='' placeholder='Количество'>"+ select;
elementlist.appendChild(elem);
  //Чтобы форма не отправлялась
const of=document.querySelector('form')
of.addEventListener('click', e => {
//  elementlist.appendChild(element);
  const o=e.target;
  if(o.tagName!= 'BUTTON') return
  e.preventDefault()
})
sessionStorage.setItem(count,"Ингредиент "+ count + ": <input type='number' name='ingredients[" + count + "]' value='' placeholder='Количество'>"+ select);
};

function removeIngr() {
    elementlist.removeChild(elementlist.lastChild);
  const of=document.querySelector('form')
  of.addEventListener('click', e => {
    const o=e.target;
    if(o.tagName!= 'BUTTON') return
    e.preventDefault()
    //o.closest('#element-list').removeChild(o.closest('#element'))
  })
  sessionStorage.removeItem(count);
    count--;
}

function addDes() {
count1++;
let elem = document.createElement('div');
elem.setAttribute('class','desc_element');
elem.innerHTML="Шаг "+ count1 + " :   <input type='file' name='photostep["+ count1 +"]' value=''><textarea name='description["+ count1 +"]'></textarea>";
desclist.appendChild(elem);
//Чтобы форма не отправлялась
const of=document.querySelector('form')
of.addEventListener('click', e => {
//  elementlist.appendChild(element);
const o=e.target;
if(o.tagName!= 'BUTTON') return
e.preventDefault()
})
localStorage.setItem(count1,"Шаг "+ count1 + " :   <input type='file' name='photostep["+ count1 +"]' value=''><textarea name='description["+ count1 +"]'></textarea>");
}

function removeDes() {
  desclist.removeChild(desclist.lastChild);
const of=document.querySelector('form')
of.addEventListener('click', e => {
  const o=e.target;
  if(o.tagName!= 'BUTTON') return
  e.preventDefault()
  //o.closest('#element-list').removeChild(o.closest('#element'))
})
localStorage.removeItem(count1);
  count1--;
}
</script>
</html>
