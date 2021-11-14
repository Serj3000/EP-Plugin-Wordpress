'use strict';
window.onload = function(){

  // const urlDp = new URL(window.location.href);
  const headerTag = document.head;
  const bodesTag = document.body;
  let bodyOldClass;

  (function(){
    if(bodesTag.getAttribute('class')===null){
      bodyOldClass=null;
    }
    else{
      bodyOldClass=bodesTag.getAttribute('class');
    }
  })();

  const aTagDp=[];
  const btnDpPlug = document.querySelectorAll('.header-ep');
  const aSideDp=[];
  const sidebarDpPlug = document.querySelectorAll('.sidebar-ep');

  // const widget_1s=document.querySelector('.title_header_1s');
  // const widget_2s=document.querySelector('.title_link_on_1s');
  // const widget_3s=document.querySelector('.title_link_off_1s');

  let options_per_page_1=null, options_per_page_2=null, options_per_page_3=null;
  let widget_title_header=null, widget_title_link_on=null,widget_title_link_off=null;

  if(ep_object_options.ep_options!==null){
    options_per_page_1=ep_object_options.ep_options.posts_per_page_1;
    options_per_page_2=ep_object_options.ep_options.posts_per_page_2;
    options_per_page_3=ep_object_options.ep_options.posts_per_page_3;

    aTagMonochrome(aTagDp, btnDpPlug);
  }

  const optionsPerPage=[
    options_per_page_1,
    options_per_page_2,
    options_per_page_3
  ];
  
  if(ep_object_widgets.ep_widgets!==null){
    widget_title_header=ep_object_widgets.ep_widgets.title_header;
    widget_title_link_on=ep_object_widgets.ep_widgets.title_link_on;
    widget_title_link_off=ep_object_widgets.ep_widgets.title_link_off;

    aTagMonochrome(aSideDp, sidebarDpPlug);
  }

  const widgetPerPage=[
    widget_title_header,
    widget_title_link_on,
    widget_title_link_off
  ];

  function aTagMonochrome(aNameDp, nameDpPlug){
    for(let i=0; i<nameDpPlug.length; i++){
      aNameDp[i] = document.createElement('a');
      nameDpPlug[i].append(aNameDp[i]);
      nameDpPlug[i].addEventListener('click', btnDpMonochrom);
    }
  }

  function validateMono(aNameDp, nameDpPlug, nameOptionWidget){
    // Проверка значения из localStorage. Если значение dark то будет темная тема
    for(let i=0; i<nameDpPlug.length; i++){
      aNameDp[i].className="btn-ep";
      aNameDp[i].value="enplagmono";

      switch(localStorage.getItem('MonochromStyle')){
        case 'dark':
            // Ссылка на темную тему
            aNameDp[i].setAttribute('data-checked', 'false');
            aNameDp[i].innerText=nameOptionWidget[2]; //'Звичайний режим';

            bodesTag.className=`ep-body-dark ${bodyOldClass}`;
          break;
        case 'light':
            // Ссылка на светлую тему
            aNameDp[i].setAttribute('data-checked', 'true');
            aNameDp[i].innerText=nameOptionWidget[1]; //'Людям з порушеннями зору';
            localStorage.removeItem('MonochromStyle');

            bodesTag.className=`ep-body-white ${bodyOldClass}`;
        break;  
        default:
            // Ссылка на светлую тему
            aNameDp[i].setAttribute('data-checked', 'true');
            aNameDp[i].innerText=nameOptionWidget[1]; //'Людям з порушеннями зору';

            bodesTag.className=`ep-body-white ${bodyOldClass}`;
          break;
      }
    }
  }
  validateMono(aTagDp, btnDpPlug, optionsPerPage);
  validateMono(aSideDp, sidebarDpPlug, widgetPerPage);

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

    validateMono(aTagDp, btnDpPlug, optionsPerPage);
    validateMono(aSideDp, sidebarDpPlug, widgetPerPage);
  }







  // ==========================================================================
  // ==========================================================================
  // ==========================================================================
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