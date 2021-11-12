'use strict';
window.onload = function(){

  const widget_1=document.querySelector('.title_header');
  const widget_2=document.querySelector('.title_link_on');
  const widget_3=document.querySelector('.title_link_off');

  const textScript_1=document.querySelector('.text-script-1');
  const textScript_2=document.querySelector('.text-script-2');
  const textScript_3=document.querySelector('.text-script-3');

  // const urlDp = new URL(window.location.href);

  const headerTag = document.head;
  const bodesTag = document.body;
  let bodyOldClass;

  const btnDpPlug = document.querySelectorAll('.header-ep');
  const aTagDp=[];

  for(let i=0; i<btnDpPlug.length; i++){
    aTagDp[i] = document.createElement('a');
    btnDpPlug[i].append(aTagDp[i]);
    btnDpPlug[i].addEventListener('click', btnDpMonochrom);
  }

  (function(){
    if(bodesTag.getAttribute('class')===null){
      bodyOldClass=null;
    }
    else{
      bodyOldClass=bodesTag.getAttribute('class');
    }
  })();

  function validMono(){
    // Проверка значения из localStorage. Если значение dark то будет темная тема
    for(let i=0; i<btnDpPlug.length; i++){
      aTagDp[i].className="btn-ep";
      aTagDp[i].value="enplagmono";

      switch(localStorage.getItem('MonochromStyle')){
        case 'dark':
            // Ссылка на темную тему
            aTagDp[i].setAttribute('data-checked', 'false');
            aTagDp[i].innerText=widget_3.value; //'Звичайний режим';

            bodesTag.className=`ep-body-dark ${bodyOldClass}`;
          break;
        case 'light':
            // Ссылка на светлую тему
            aTagDp[i].setAttribute('data-checked', 'true');
            aTagDp[i].innerText=widget_2.value; //'Людям з порушеннями зору';
            localStorage.removeItem('MonochromStyle');

            bodesTag.className=`ep-body-white ${bodyOldClass}`;
        break;  
        default:
            // Ссылка на светлую тему
            aTagDp[i].setAttribute('data-checked', 'true');
            aTagDp[i].innerText=widget_2.value; //'Людям з порушеннями зору';

            bodesTag.className=`ep-body-white ${bodyOldClass}`;
          break;
      }
    }
  }

  validMono();

  // Событие при нажатии кнопки
  // btnDpPlug.addEventListener('click', btnDpMonochrom);
  function btnDpMonochrom(eve){
    const btnEveClick = eve.target.getAttribute('data-checked');

    switch(btnEveClick){
      case 'true':
          // устанавливаем значение для темной темы
          localStorage.setItem('MonochromStyle', 'dark'); // записываем значение dark в localStorage;
        break;
      case 'false':
          // сохраняем значение для светлой темы
          localStorage.setItem('MonochromStyle', 'light'); // записываем значение light в localStorage
        break;
      default:
          // сохраняем значение для темной темы
          localStorage.setItem('MonochromStyle', 'dark'); // записываем значение dark в localStorage
        break;
  }

    validMono();
  }



  // Start ZOOM ===============================================================
  const wordsParagraphs=document.querySelectorAll('p');
  const wordsLinks=document.querySelectorAll('a');

  for(let i=0; i<wordsParagraphs.length; i++){
    // if(wordsParagraphs[i].style='' || wordsParagraphs[i].style===undefined){
    //   wordsParagraphs[i].setAttribute('style', 'font-size: 36px !important; line-height: 40px !important;');
    // }
    //   else{
    //     wordsParagraphs[i].style+='; font-size: 36px !important; line-height: 40px !important;';
    //   }

    wordsParagraphs[i].className+=' font-paragraph-22';
  }

  console.log('wordsParagraphs');
  console.log(wordsParagraphs);

  for(let i=0; i<wordsLinks.length; i++){
    wordsLinks[i].className+=' font-link-22';
  }

  console.log('wordsLinks');
  console.log(wordsLinks);
  // End ZOOM ===============================================================


  const html = document.documentElement;
  // Свойство tagName узла содержит имя тега в верхнем регистре
  console.log(html.tagName); // => 'HTML'
  
  // Содержимое тега HTML в виде узлов DOM-дерева.
  // Текст тоже представлен узлом
  console.log(html.childNodes); // [head, text, body]
  console.log(html.children[1].innerHTML); // [head, text, body]children
  
  // Потому что head выше body
  console.log(html.firstChild); // <head>...</head>
    console.log(html.lastElementChild); // <body>...</body>
  
  // Второй ребенок. Обращение по индексу.
  console.log(html.childNodes[4]); // #text
  

}