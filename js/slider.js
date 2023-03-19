let offset = 0; //смещение от левого края
const sliderLine= document.querySelector('.infinity-slider');

document.querySelector('.itc-slider_btn_next').addEventListener('click', function(){
  offset = offset + 160;
  if(offset > 480) {
    offset=0;
  }
  sliderLine.style.left=-offset + 'px';
});
document.querySelector('.itc-slider_btn_prev').addEventListener('click', function(){
  offset = offset - 160;
  if(offset < 0) {
    offset=480;
  }
  sliderLine.style.left=-offset + 'px';
});
