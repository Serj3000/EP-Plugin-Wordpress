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
            <p class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla labore asperiores sit nisi at deleniti accusamus corporis accusantium commodi voluptate vel nihil nemo earum eum odit sint, similique pariatur id.</p>
            <p class="text">Dolore, expedita sint. Odio voluptatum itaque at ex adipisci rem illo ab? Mollitia totam sit corporis est placeat quisquam. Eligendi dignissimos quaerat ducimus autem architecto reiciendis perferendis, exercitationem sapiente est.</p>
            <p class="text">Eos quidem fuga eligendi? Minima omnis debitis excepturi eum? Voluptate dignissimos, architecto blanditiis rerum ducimus ea impedit saepe aliquam! Magni corrupti dolorem autem mollitia sunt dolores fugit quasi, voluptatibus reiciendis?</p>
            <p class="text">Aperiam a ipsam molestiae? Placeat quia natus quis perspiciatis illum similique doloremque reiciendis dolores ad exercitationem? Libero iusto culpa suscipit. Excepturi facere at mollitia quia nisi deserunt dolore molestias numquam?</p>
            <p class="text">Quibusdam nostrum amet excepturi id ad in ipsam quidem doloribus cumque at, nulla ipsum fugit ea iure expedita rem fugiat itaque vero impedit debitis saepe autem commodi tenetur voluptates! Ex!</p>
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

    <h1 class="ep_title"><?php esc_html_e('EP Monochrome Settings','enplagmono'); ?></h1>
    <?php settings_errors();//Выводит на экран сообщения (уведомления и ошибки) зарегистрированные функцией add_settings_error(). ?>
    <div class="ep_content">
        <form method="post" action="options.php">
            <?php 
                settings_fields('ep_monochrome');// Выводит скрытые поля формы на странице настроек (option_page, _wpnonce, ...).
                do_settings_sections('ep-admin');// Выводит на экран все блоки опций, относящиеся к указанной странице настроек в админ-панели.
                submit_button();// Выводит на экран кнопку submit с указанным текстом и классами.
            ?>
        </form>
    </div>
</body>
</html>