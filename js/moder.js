var ingredients= document.querySelector('.ingredients-block');
var categories = document.querySelector('.categories-block');
var tag = document.querySelector('.tag-block');
var row_in = document.querySelector('.row-in');
var row_ct = document.querySelector('.row-ct');
var row_tg = document.querySelector('.row-tg');
document.querySelector('.btn-ingredients').addEventListener('click', function(){
  if (ingredients.style.display=="block") {
    ingredients.style.display="none";
    row_in.style.transform="rotate(0deg)";
  } else {
    ingredients.style.display="block";
    categories.style.display="none";
    tag.style.display="none";
    row_in.style.transform="rotate(90deg)";
    row_ct.style.transform="rotate(0deg)";
    row_tg.style.transform="rotate(0deg)";
  }
});
document.querySelector('.btn-categories').addEventListener('click', function(){
  if (categories.style.display=="block") {
    categories.style.display="none";
    row_ct.style.transform="rotate(0deg)";
  } else {
    categories.style.display="block";
    ingredients.style.display="none";
    tag.style.display="none";
    row_ct.style.transform="rotate(90deg)";
    row_in.style.transform="rotate(0deg)";
    row_tg.style.transform="rotate(0deg)";
  }
});
document.querySelector('.btn-tag').addEventListener('click', function(){
  if (tag.style.display=="block") {
    tag.style.display="none";
    row_tg.style.transform="rotate(0deg)";
  } else {
    tag.style.display="block";
    categories.style.display="none";
    ingredients.style.display="none";
    row_tg.style.transform="rotate(90deg)";
    row_ct.style.transform="rotate(0deg)";
    row_in.style.transform="rotate(0deg)";
  }
});
//Доп вариант
/*function show_list() {
  var courses = document.getElementById("ingredients-block");

  if(courses.style.display=="block") {
    courses.style.display="none";
  } else {
    courses.style.display="block";
  }
}
window.onclick = function (event) {
  if(!event.target.matches('.btn-ingredients')) {
    document.getElementById('ingredients-block').style.display="none";
  }
}*/
