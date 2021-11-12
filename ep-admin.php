<?php
_e('<br> __FILE__ ');
_e(__FILE__);
_e('<br>');

_e('<br>$_GET= ');
print_r($_GET);

_e('<br>$_POST= ');
print_r($_POST);

// _e('<br>$_REQUEST= ');
// print_r($_REQUEST);
// _e('<br>');
// if($_REQUEST['to-plagin-from-widget']){
//     _e('<pre>');
//     foreach($_REQUEST['to-plagin-from-widget'] as $key_wp_http_referer=>$value_wp_http_referer){
//         _e('<br>-');
//         _e($key_wp_http_referer.' = ');
//         _e($value_wp_http_referer);
//         foreach($value_wp_http_referer as $value){
//             _e('<br>--');
//             _e($value);
//         }
//     }
//     _e('</pre>');
// }

// Проверим зарегистрирована ли функция get_plugins(). Это нужно для фронт-энда
// обычно get_plugins() работает только в админ-панели.
if ( ! function_exists( 'get_plugins' ) ) {
	// подключим файл с функцией get_plugins()
	// require ABSPATH . 'wp-admin/includes/plugin.php';
}

// получим данные плагинов
$all_plugins = get_plugins();

// Сохраним данные в лог ошибок, в котором можно будет посмотреть как выглядит полученный массив
// error_log( print_r( $all_plugins, true ) );
print_r( $all_plugins, true );

require_once plugin_dir_path( __FILE__ ).'ep-db.php';
if(class_exists('EpDb')){
    $ep_admin=new EpDb('ep_monochrome_options');
    $ep_admin_1=new EpDb('widget_monochrome');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ep-plugin</title>
</head>
<body>
    <div class="wrapper-admin">
        <div class="block-admin-one">
            <h1 class="ep_title"><?php esc_html_e('EP Monochrome Settings','enplagmono'); ?></h1>
            <?php settings_errors();//Выводит на экран сообщения (уведомления и ошибки) зарегистрированные функцией add_settings_error(). ?>
            <div class="ep_content">
                <form method="post" action="options.php">
                    <?php 
                        settings_fields('ep_monochrome');// Выводит скрытые поля формы на странице настроек (option_page, _wpnonce, ...).
                        do_settings_sections('ep-admin');// Выводит на экран все блоки опций, относящиеся к указанной странице настроек в админ-панели.
                        do_settings_sections('ep-admin-2');
                        do_settings_sections('ep-admin-3');
                        submit_button();// Выводит на экран кнопку submit с указанным текстом и классами.
                    ?>
                </form>
            </div>

            <div class="hr-wp-widget"></div>

            <?php
            function adminWidget(){
                $ep_widgets = get_option('widget_monochrome-widget-ep');

                foreach($ep_widgets as $key_ep_widgets=>$value_ep_widgets){
                    $last_ep_widget[$key_ep_widgets]=$value_ep_widgets;
                }

                array_pop($last_ep_widget);
                // $first_ep_widgets=$ep_widgets[array_key_first($ep_widgets)];

                $first_ep_widget=array_shift($last_ep_widget);


                                // $array_ep_options_default=[
                                //     'posts_per_page_1'=>'Для людей з порушенням зору',
                                //     'posts_per_page_2'=>'Людям з порушеннями зору',
                                //     'posts_per_page_3'=>'Звичайний режим',
                                // ];
                    
                                // echo '<br> =======$ep_widgets======= <br>';
                                // print_r($ep_widgets);
                                // echo '<br> =======$last_ep_widget======= <br>';
                                // print_r($last_ep_widget);
                    
                                // // $first_ep_widget=array_shift($last_ep_widget);
                    
                                // // is_active_widget( ) - Определяет отображается ли указанный виджет на сайте (во фронтэнде). Получает ID панели, в которой виджет находится.
                                // if ( is_active_widget(false, false, 'monochrome-widget-ep')){
                                //     if(!empty($first_ep_widget)){
                                //         $ep_option_1=$first_ep_widget['title_header'];
                                //         $ep_option_2=$first_ep_widget['title_link_on'];
                                //         $ep_option_3=$first_ep_widget['title_link_off'];
                    
                                //         // delete_option('widget_monochrome-widget-ep');
                                //     }
                                //     else{
                                //         $ep_option_1=$ep_options['posts_per_page_1'];
                                //         $ep_option_2=$ep_options['posts_per_page_2'];
                                //         $ep_option_3=$ep_options['posts_per_page_3'];
                                //     }
                    
                                //     // echo '<br> =======$ep_option_1======= <br>';
                                //     // print_r($ep_option_1);
                                //     // echo '<br> =======$ep_option_2======= <br>';
                                //     // print_r($ep_option_2);
                                //     // echo '<br> =======$ep_option_3======= <br>';
                                //     // print_r($ep_option_3);
                                // }
                                // else{
                                //     $ep_option_1=$ep_options['posts_per_page_1'];
                                //     $ep_option_2=$ep_options['posts_per_page_2'];
                                //     $ep_option_3=$ep_options['posts_per_page_3'];
                                // }

                return $first_ep_widget;
            }
            ?>

            <p style="font-size: 24px; font-weight: 600; color: #000;"><?php _e('Настройки виджета')?></p>

            <p class="text"><pre><?php
            
                // is_active_widget( ) - Определяет отображается ли указанный виджет на сайте (во фронтэнде). Получает ID панели, в которой виджет находится.
                if ( is_active_widget(false, false, 'monochrome-widget-ep')){
                    // print_r(adminWidget());
                    _e('<p class="form-table"><b>Заголовок вiджиту</b> ');
                    _e(adminWidget()['title_header']);
                    _e('</p>');

                    _e('<p class="form-table"><b>Текс посилання до включення режиму</b> ');
                    _e(adminWidget()['title_link_on']);
                    _e('</p>');

                    _e('<p class="form-table"><b>Текс посилання пiсля вимкнення режиму</b> ');
                    _e(adminWidget()['title_link_off']);
                    _e('</p>');
                    ?>
                    <input type="hidden" name="title_header" class="title_header" value="<?php _e(adminWidget()['title_header']) ?>">
                    <input type="hidden" name="title_link_on" class="title_link_on" value="<?php _e(adminWidget()['title_link_on']) ?>">
                    <input type="hidden" name="title_link_off" class="title_link_off" value="<?php _e(adminWidget()['title_link_off']) ?>">

                        <p class="text-script-1"></p>
                        <p class="text-script-2"></p>
                        <p class="text-script-3"></p>

                    <?php
                }
                else{
                    _e('Виджет не активирован');
                }
            ?></pre></p>

            <div class="hr-wp-widget"></div>

            <p class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla labore asperiores sit nisi at deleniti accusamus corporis accusantium commodi voluptate vel nihil nemo earum eum odit sint, similique pariatur id.</p>
            <p class="text">Dolore, expedita sint. Odio voluptatum itaque at ex adipisci rem illo ab? Mollitia totam sit corporis est placeat quisquam. Eligendi dignissimos quaerat ducimus autem architecto reiciendis perferendis, exercitationem sapiente est.</p>
            <p class="text">Eos quidem fuga eligendi? Minima omnis debitis excepturi eum? Voluptate dignissimos, architecto blanditiis rerum ducimus ea impedit saepe aliquam! Magni corrupti dolorem autem mollitia sunt dolores fugit quasi, voluptatibus reiciendis?</p>
            <p class="text">Aperiam a ipsam molestiae? Placeat quia natus quis perspiciatis illum similique doloremque reiciendis dolores ad exercitationem? Libero iusto culpa suscipit. Excepturi facere at mollitia quia nisi deserunt dolore molestias numquam?</p>
        </div>

        <div class="block-admin-two">
            <p class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi eum quidem saepe repellat laudantium fugiat magni, non iure veritatis ea blanditiis odit adipisci ut delectus eius modi libero itaque? Omnis.</p>
            <p class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat ipsam obcaecati quidem! Fugiat delectus perspiciatis placeat facere repellat. Alias eligendi nulla vel asperiores praesentium velit nobis, eius error. Est, repellat.</p>
            <p class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi eum quidem saepe repellat laudantium fugiat magni, non iure veritatis ea blanditiis odit adipisci ut delectus eius modi libero itaque? Omnis.</p>
            <p><pre><?php 
            // print_r($wpdb_enplagmono->last_result);
            // $drol=array_filter($wpdb_enplagmono->last_result, function($v, $k) {
            //         return $v->option_name == 'home';
            //     }, ARRAY_FILTER_USE_BOTH);

            // foreach($drol as $key){
            //     print_r($key->option_name);
            // }

            echo '<br>======= $wpdb->options =======<br>';
            print_r($ep_admin->users);
            echo '<br>======= $row =======<br>';
            print_r($ep_admin->row);
            echo '<br> -----prepare----- <br>';
            print_r($ep_admin->prepare);
            echo '<br> -----query----- <br>';
            print_r($ep_admin->query);
            echo '<br> ------------- <br>';
            echo '<br> unserialize <br>';
            print_r(unserialize($ep_admin->row['option_value']));

            echo '<br>======= $row_1 =======<br>';
            print_r($ep_admin_1->row);
            echo '<br> unserialize_1 <br>';
            print_r(unserialize($ep_admin_1->row['option_value']));

            ?></pre></p> 
        </div>

    </div>
    <script>
        const widget_1=document.querySelector('.title_header');
        const widget_2=document.querySelector('.title_link_on');
        const widget_3=document.querySelector('.title_link_off');

        const textScript_1=document.querySelector('.text-script-1');
        const textScript_2=document.querySelector('.text-script-2');
        const textScript_3=document.querySelector('.text-script-3');

        textScript_1.innerText=widget_1.value;
        textScript_2.innerText=widget_2.value;
        textScript_3.innerText=widget_3.value;
    </script>

    <!-- <script>
        const textScript_1=document.querySelector('.text-script-1');
        const textScript_2=document.querySelector('.text-script-2');
        const textScript_3=document.querySelector('.text-script-3');

        const posts_per_page_1=document.querySelector('.posts_per_page_1');
        const posts_per_page_2=document.querySelector('.posts_per_page_2');
        const posts_per_page_3=document.querySelector('.posts_per_page_3');

        const widget_1=document.querySelector('.widget-1');
        const widget_2=document.querySelector('.widget-2');
        const widget_3=document.querySelector('.widget-3');

        // textScript_1.innerText=posts_per_page_1.value;
        // textScript_2.innerText=posts_per_page_2.value;
        // textScript_3.innerText=posts_per_page_3.value;

        textScript_1.innerText=widget_1.value;
        textScript_2.innerText=widget_2.value;
        textScript_3.innerText=widget_3.value;

    </script> -->
    
</body>
</html>