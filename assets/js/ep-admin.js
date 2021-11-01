'use strict';
window.onload = function(){
  const widgetInputs=document.querySelectorAll('.widefat');
  console.log('widgetInputs');
  for(let i=0; i<widgetInputs.length; i++){
    alert(widgetInputs[i]);
  }
}