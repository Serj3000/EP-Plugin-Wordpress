<?php
/**
 * @package Enable Plugin Monochrome
 * @version 3.3.0
 */
/*
Plugin Name: Enable Plugin Monochrome
Plugin URI: http://wordpress.org/plugins/#/
Description: Плагин поможет организовать переключение темы вашего сайта в монохромный вариант отображения. При активации плагина, в панели администратора появится пункт меню EP Monochrome, в котором можно получить рекомендации по интеграции и настройке плагина.
Author: Sergej Onischenko
Version: 3.3.0
Author URI: http://#/
License: GPLv2 or later
Text Domain: enplagmono
Domain Path: /lang
*/
// Проверка доступа к файлу из вне
if(!function_exists('add_action')){
    echo 'Hi there! I\'m just a plugin, not much I can do when called directly.';
    exit;
}

// Класса EnableMonochrome.
class EnableMonochrome
{
    function register(){
        add_action('get_header', array($this, 'enqueue_plugin'));

        // Добавим в таблицу плагинов в админ-панели, под названием нашего плагина, ссылку Setting (Настройки)
                // Хук-фильтр plugin_action_links_(plugin_file) позволяет удалить/добавить ссылки, которые выводятся под названием каждого плагина в таблице плагинов в админ-панели (например: Активировать, Деактивировать, Удалить).
        add_filter('plugin_action_links_'.plugin_basename(__FILE__), [$this, 'add_plugin_setting_links']);

        add_action('admin_init', [$this, 'settings_init']);
    }

    // Функция для добавления в таблице плагинов в админ-панели ссылки Setting (Настройки)
    function add_plugin_setting_links($links){
        print_r($links);
        $my_custome_link='<a href="admin.php?page=ep-admin">Настройки</a>';
        array_push($links, $my_custome_link);
        return $links;
    }

    //Register settings
    public function settings_init(){
        register_setting('ep_monochrome','ep_monochrome_options');// Регистрирует новую опцию и callback функцию (функцию обратного вызова) для обработки значения опции при её сохранении в БД.

        add_settings_section('ep_monochrome_section_1', esc_html__('Settings 1','enplagmono'), [$this, 'settings_section_html'], 'ep-admin');// Создает новый блок (секцию), в котором выводятся поля настроек. Т.е. в этот блок затем добавляются опции, с помощью add_settings_field()
        add_settings_section('ep_monochrome_section_2', esc_html__('Settings 2','enplagmono'), [$this, 'settings_section_html'], 'ep-admin');

        add_settings_field('posts_per_page_1', esc_html__('Posts per page 1','enplagmono'), [$this, 'posts_per_page_html'], 'ep-admin', 'ep_monochrome_section_1');// Создает поле опции для указанной секции (указанного блока настроек).
        add_settings_field('posts_per_page_2', esc_html__('Posts per page 2','enplagmono'), [$this, 'posts_per_page_html'], 'ep-admin', 'ep_monochrome_section_2');
    }

    //Settings section html
    public function settings_section_html(){
        echo esc_html__("Hello, world!", 'enplagmono');
    }

    //Settings fields HTML
    public function posts_per_page_html(){
        $options = get_option('ep_monochrome_options'); ?>

        <p><input type="text" name="ep_monochrome_options[posts_per_page_1]" value="<?php echo isset($options['posts_per_page_1']) ? $options['posts_per_page_1'] : "";  ?>" />111</p>

        <p><input type="text" name="ep_monochrome_options[posts_per_page_2]" value="<?php echo isset($options['posts_per_page_2']) ? $options['posts_per_page_2'] : "";  ?>" />222</p>
    <?php }

    //Создаем метод для подключения файлов css и js
    function enqueue_plugin(){
        //wp_enqueue_style() - Правильно добавляет файл CSS стилей. Регистрирует файл стилей, если он еще не был зарегистрирован
        wp_enqueue_style('enplagmono-plugin-style', plugins_url('assets/css/ep-site.css', __FILE__));

        //wp_enqueue_script() - Правильно подключает скрипт (JavaScript файл) на страницу.
        wp_enqueue_script('enplagmono-plugin-script', plugins_url('assets/js/ep-site.js', __FILE__));
        // wp_enqueue_script('enplagmono-admin-script', plugins_url('assets/js/ep-admin.js', __FILE__));

        //plugins_url() - Получает URL папки плагинов или mu (must use) плагинов (без слэша на конце).
    }

        // Update rewrite rules
        static function activation() {
            // Обновляем правила перезаписи ЧПУ: удаляем имеющиеся, генерируем и записывает новые, с помощью flush_rewrite_rules().
            flush_rewrite_rules();
        }
    
        // Update rewrite rules
        static function deactivation() {
            echo '<script src="'.plugins_url('assets/js/ep-remove.js', __FILE__).'"></script>';
            // Обновляем правила перезаписи ЧПУ: удаляем имеющиеся, генерируем и записывает новые, с помощью flush_rewrite_rules().
            flush_rewrite_rules();
        }
}

// Инициализация класса EnableMonochrome
if(class_exists('EnableMonochrome')){
    //Для того, чтобы запустить инициализацию класса EnableMonochrome при запуске функции register_activation_hook() создаем переменную $obj_archive_post с объектом EnableMonochrome которую передаем в качестве параметра для функции register_activation_hook() и register_deactivation_hook()
    $obj_archive_post=new EnableMonochrome();
    $obj_archive_post->register();
}

// Регистрирует функцию, которая будет срабатывать во время активации плагина.
register_activation_hook(__FILE__, array($obj_archive_post, 'activation'));

// Регистрирует функцию, которая будет срабатывать во время деактивации плагина.
register_deactivation_hook(__FILE__, array($obj_archive_post, 'deactivation'));

//============================================================================
/**
 * Register a custom menu page.
 */
function enplagmono_register_menu_page() {
    add_menu_page(
        esc_html__('EP Monochrome Title', 'enplagmono'), // Текст, который будет использован в теге <title> на странице, относящейся к пункту меню.
        esc_html__('EP Monochrome Menu', 'enplagmono'), // Название пункта меню в сайдбаре админ-панели.
        'manage_options', // Права пользователя (возможности), необходимые чтобы пункт меню появился в списке.
        'ep-admin', // Уникальное название (slug), по которому затем можно обращаться к этому меню.
                // Если параметр $function не указан, этот параметр должен равняться названию PHP файла относительно каталога плагинов, который отвечает за вывод кода страницы этого пункта меню.
                // Можно указать произвольную ссылку (URL), куда будет вести клик пункта меню.
        'enplagmono_show_content', // Название функции, которая выводит контент страницы пункта меню.
        // Этот необязательный параметр и если он не указан, WordPress ожидает что текущий подключаемый PHP файл генерирует код страницы админ-меню, без вызова функции.
                // Если функция является методом класса, она вызывается по ссылке:
                // array( $this, 'function_name' )
                // или статически:
                // array( __CLASS__, 'function_name' ).
                // Во всех остальных случаях указываем название функции в виде строки.
        'dashicons-welcome-view-site', // Иконка для пункта меню, например: plugins_url( './assets/images/eye.svg' ).
                // Воспользуйтесь сайтом иконок для WP https://developer.wordpress.org/resource/dashicons/#welcome-view-site
        100 // Число определяющее позицию меню. Чем больше цифра, тем ниже будет расположен пункт меню.
    );
}
add_action('admin_menu', 'enplagmono_register_menu_page');

// Подгрузка языковых пакетов
function enplagmono_load_plugin_textdomain(){
    load_plugin_textdomain('enplagmono', FALSE, basename(dirname(__FILE__)).'/lang/');
}
add_action('plagins_loaded', 'db_load_plugin_textdomain');

// Функция, которая выводит контент в админке при выборе в меню EP Plugin
function enplagmono_show_content(){
    _e('<h2 class="title-dp-plagin">Welcome to the plugin "Enable Plugin Monochrome" options settings</h2>','db');

    require_once plugin_dir_path(__FILE__).'ep-admin.php';
}

// Регистрация файлов css и js для admin
function enqueue_register_admin(){
    //wp_register_style() - Регистрирует файл CSS стилей.
    wp_register_style('enplagmono-plugin-style-admin', plugins_url('assets/css/ep-admin.css', __FILE__));

    //wp_register_script() - Регистрирует скрипт (JavaScript файл) на страницу.
    wp_register_script('enplagmono-plugin-script-admin', plugins_url('assets/js/ep-admin.js', __FILE__));

    //plugins_url() - Получает URL папки плагинов или mu (must use) плагинов (без слэша на конце).

    // wp_register_script('enplagmono-widget-site-script', plugins_url('assets/js/ep-site.js', __FILE__));

}
add_action('admin_enqueue_scripts', 'enqueue_register_admin');

// Подключение файлов css и js для admin
function enqueue_load_admin($hook){
    //Проверяем, что подключение css и js будет только для страницы со slug-ом dp-admin
    if($hook!='toplevel_page_ep-admin'){
        return;
    }
    //wp_enqueue_style() - Правильно добавляет файл CSS стилей. Регистрирует файл стилей, если он еще не был зарегистрирован
    wp_enqueue_style('enplagmono-plugin-style-admin');
    //wp_enqueue_script() - Правильно подключает скрипт (JavaScript файл) на страницу.
    wp_enqueue_script('enplagmono-plugin-script-admin');
    wp_enqueue_script('enplagmono-widget-site-script');
}
add_action('admin_enqueue_scripts', 'enqueue_load_admin');

//======================  Start Widget  ===========================
// Инициализация класса Monochrome_Widget
require plugin_dir_path( __FILE__ ).'ep-widget.php';

if(class_exists('MonochromeWidgetEP')){
    // new Monochrome_Widget();
    new MonochromeWidgetEP();
}
//=======================  End Widget  ============================

//======================  Start DB  ===========================
// Инициализация класса Monochrome_Widget
// require plugin_dir_path( __FILE__ ).'ep-db.php';

// if(class_exists('EpDb')){
//     new EpDb();
// }
//=======================  End DB  ============================
