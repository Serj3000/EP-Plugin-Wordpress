<?php
/**
 * @package Enable Plugin Monochrome
 */
if(!function_exists('add_action')){
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

class MonochromeWidgetEP extends WP_Widget
{ //Monochrome_Widget
	public $ep_widget;

	public $args = array(
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div></div>'
    );

	public $default_options=[
			'bviActive'         => 'false',
			'bviScriptLocation' => 'false',
			'bviTheme'          => 'white',
			'bviFont'           => 'arial',
			'bviFontSize'       => '16',
			'bviLetterSpacing'  => 'normal',
			'bviLineHeight'     => 'normal',
			'bviImages'         => 'true',
			'bviReload'         => 'false',
			'bviSpeech'         => 'true',
			'bviBuiltElements'  => 'true',
			'bviPanelHide'      => 'false',
			'bviPanelFixed'     => 'true',
			'bviLang'           => 'ru-RU',
			'bviLinkText'       => 'Версия сайта для слабовидящих',
			'bviLinkColor'      => '#ffffff',
			'bviLinkBg'         => '#e53935',
			'enplagmonoLinkText'=> 'Версия сайта для слабовидящих',
			'title_header'      => 'Для людей з порушеннями зору',
			'title_link_on'     => 'Людям з порушеннями зору',
			'title_link_off'    => 'Звичайний режим',
		];

	function __construct() {

		require_once plugin_dir_path( __FILE__ ).'ep-db.php';
		if(class_exists('EpDb')){
			$ep_widget=new EpDb('ep_monochrome_options');
			$this->ep_widget=$ep_widget;
		}

		load_plugin_textdomain('enplagmono', false, dirname( plugin_basename( __FILE__ )). '/lang/');//Подключает .mo файл перевода из указанной папки. Не работает с MU плагинами.
		
		parent::__construct( 
			'monochrome-widget-ep', //id_base
			__('EP Monochrome Widget', 'enplagmono'), // name
			array('description'=>__('Display after EP Monochrome', 'enplagmono'))
		);

		add_action( 'widgets_init', function() {
			// register_widget( ) - Регистрирует (создает) виджет. Функции нужно передать название созданного класса расширяющего основной класс виджетов WP_Widget.
			register_widget('MonochromeWidgetEP'); // Class MonochromeWidgetEP
		});

		// is_active_widget( ) - Определяет отображается ли указанный виджет на сайте (во фронтэнде). Получает ID панели, в которой виджет находится.
		if ( is_active_widget(false, false, 'monochrome-widget-ep')){
			add_action('wp_head', array($this, 'css'));
		}
	}

	function css() {
	?>
		<style type="text/css">
			.widgettitle{
				color: red;
			}
			
			.widget-wrap{
				color: green;
			}

			.textwidget{
				color: #000;
				margin: 10px 0;
				padding: 10px 0;
				font-size: 24px;
				border-bottom: 5px solid #000;
				line-height
			}

			.widefat{
				color: grey;
			}
		</style>
	<?php
	}
	//-------------------------------
	function js(){
	?>
		<script>
		</script>
	<?php 
	} 
	//-------------------------------
	/**
	 * Outputs the settings update form.
	 *
	 * @param array $instance
	 *
	 * @return string|void
	 */
	public function form( $instance ) {
		wp_nonce_field('enplagmonoNonce', '_id_enplagmono');
		$ep_options_plugin = get_option('ep_monochrome_options');

		$title=!empty( $instance['title_header'] ) ? $instance['title_header'] : $ep_options_plugin['posts_per_page_1'];
		$title_link_on=!empty($instance['title_link_on']) ? $instance['title_link_on'] : $ep_options_plugin['posts_per_page_2'];
		$title_link_off=!empty($instance['title_link_off']) ? $instance['title_link_off'] : $ep_options_plugin['posts_per_page_3'];
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title_header' ) ); ?>">Заголовок вiджиту:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_header' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'title_header' ) ); ?>" type="text"
					value="<?php echo esc_attr( $title ); ?>" placeholder="<?php echo $this->default_options['title_header']; ?>">
			
			<label for="<?php echo esc_attr( $this->get_field_id( 'title_link_on' ) ); ?>">Текс посилання до включення режиму:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_link_on' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'title_link_on' ) ); ?>" type="text"
					value="<?php echo esc_attr( $title_link_on ); ?>" placeholder="<?php echo $this->default_options['title_link_on']; ?>">

			<label for="<?php echo esc_attr( $this->get_field_id( 'title_link_off' ) ); ?>">Текс посилання пiсля вимкнення режиму:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_link_off' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'title_link_off' ) ); ?>" type="text"
					value="<?php echo esc_attr( $title_link_off ); ?>" placeholder="<?php echo $this->default_options['title_link_off']; ?>">
		</p>
		<p>
			<a href="#<?php //echo get_admin_url( false, 'ep-admin.php?page=ep-admin' ); ?>" class="page-title-action">Изменить цвет ссылки</a>
		</p>
		<?php

		$options_p = get_option('ep_monochrome_options');
		echo '<br> wp_options: ep_monochrome_options <br>';
			print_r($options_p);
		echo '<br> =============== <br>';

		$options_w = get_option('widget_monochrome-widget-ep');
		echo '<br> wp_options: widget_monochrome-widget-ep <br>';
			if(is_array($options_w)){
				foreach($options_w as $valu_option){
					print_r($valu_option);
				}
			}
			else{
				print_r($options_w); 
			} 

		echo '<br> =============== <br>';

		_e($this->id_base);

		echo '<br>======= $row =======<br>';
		print_r($this->ep_widget->row);
		echo '<br> unserialize <br>';
		print_r(unserialize($this->ep_widget->row['option_value']));
	}

	function update($new_instance, $old_instance){
		$instance=[]; //strip_tags( ) — Удаляет теги HTML и PHP из строки
		$instance['title_header']=strip_tags($new_instance['title_header']);
		$instance['title_link_on']=strip_tags($new_instance['title_link_on']);
		$instance['title_link_off']=strip_tags($new_instance['title_link_off']);
		return $instance;
	}

	function widget($args, $instance){
		echo $args['before_widget'];

		if (!empty($instance['title_header'])){
            // echo $args['before_title'] . apply_filters( 'widget_title', $instance['title_header'] ) . $args['after_title'];

			_e('<div class="textwidget">');
			_e(mb_strtoupper(strip_tags($instance['title_header'])), 'enplagmono');
			_e('</div>');
		}

		function optionWidget(){
                $ep_widgets1 = get_option('widget_monochrome-widget-ep');

                foreach($ep_widgets1 as $key_ep_widgets1=>$value_ep_widgets1){
                    $last_ep_widget1[$key_ep_widgets1]=$value_ep_widgets1;
                }

                array_pop($last_ep_widget1);
                $first_ep_widget1=array_shift($last_ep_widget1);

                return $first_ep_widget1;
            }

		if ( is_active_widget(false, false, 'monochrome-widget-ep')){
		?>
			<input type="hidden" name="title_header_1s" class="title_header_1s" value="<?php _e(optionWidget()['title_header']) ?>">
			<input type="hidden" name="title_link_on_1s" class="title_link_on_1s" value="<?php _e(optionWidget()['title_link_on']) ?>">
			<input type="hidden" name="title_link_off_1s" class="title_link_off_1s" value="<?php _e(optionWidget()['title_link_off']) ?>">
		<?php } ?>

		<!-- <div class="header-ep btn-ep-widget"></div> -->
		<div class="sidebar-ep btn-ep-widget"></div>

		<?php
		echo $args['after_widget'];
	}
}
