<?php
//========= БД ===============================
// `option_id` LIKE '%monochrome%' OR `option_name` LIKE '%monochrome%' OR `option_value` LIKE '%monochrome%' OR `autoload` LIKE '%monochrome%'

// global $wpdb_enplagmono;
// $wpdb_enplagmono = new wpdb( 'root', 'root', 'eco', 'localhost' );

// $query_enplagmono="SELECT * FROM wp_options";
// $output_type='ARRAY_A';
// $row_offset=0;
 
//     // $sql = $wpdb_enplagmono->prepare( "SELECT * FROM `wp_options`", $var );
// $sql = $wpdb_enplagmono->query( "SELECT * FROM wp_options" );

//     // $row = $wpdb_enplagmono->get_row( "SELECT * FROM wp_options WHERE option_id = 16460", $output_type, $row_offset );
// $row = $wpdb_enplagmono->get_row( "SELECT * FROM wp_options WHERE option_name='widget_webmonochrome'", $output_type, $row_offset);
//     // $row = $wpdb_enplagmono->get_row( "SELECT * FROM wp_options", $output_type, $row_offset );
//===============================================================
class EpDb
{
    public $wpdb_enplagmono;
    public $query;
    public $prepare;
    public $row;

    function __construct($value){
        $wpdb_enplagmono = new wpdb( 'root', 'root', 'eco', 'localhost' );
        $this->wpdb_enplagmono=$wpdb_enplagmono;

        $query_enplagmono="SELECT * FROM wp_options";
        $output_type='ARRAY_A';
        $row_offset=0;

        $prepare = $wpdb_enplagmono->prepare( "SELECT * FROM wp_options WHERE option_name = %s", $value );
        $this->prepare=$prepare;

        $query = $wpdb_enplagmono->query( $prepare );
        $this->query=$query;

        $row = $wpdb_enplagmono->get_row( "SELECT * FROM wp_options WHERE option_name='".$value."'", $output_type, $row_offset);
        $this->row=$row;
    }
}
