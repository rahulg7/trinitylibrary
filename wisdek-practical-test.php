<?php
/**
* Plugin Name: Wisdek-practical-test
* Plugin URI: https://www.your-site.com/
* Description: Test.
* Version: 0.1
* Author: your-name
* Author URI: https://www.your-site.com/
**/

add_action( 'admin_init', 'wpdocs_register_my_custom_menu_page' );
add_action( 'admin_init', 'jal_install' );


function jal_install () {
    global $wpdb;
 
    $table_name = $wpdb->prefix . "trinitylibrary_std"; 

$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  stdid int(9) NOT NULL,
  staffid int(9) NOT NULL,
  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  stdname varchar(55) NOT NULL,
  bookname varchar(55) NOT NULL,
  rtrn int(3) DEFAULT '0',
  PRIMARY KEY  (id)
) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
 }


 /**
 * Register a custom menu page.
 */
function wpdocs_register_my_custom_menu_page() {
	add_menu_page(
		__( 'Trinity Library', 'textdomain' ),
		   'custom menu',
            'manage_options',
            'custompage',
            'my_custom_menu_page',
            plugins_url( 'myplugin/images/icon.png' ),
        ); 
	);
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );

/**
 * Display a custom menu page
 */
function my_custom_menu_page(){

global $wpdb;

$table_name = $wpdb->prefix . "trinitylibrary_std"; 


//check if there is any book for the student which is due more than 10 days.

$res1 = $wpdb->get_results("SELECT * FROM $wpdb->$table_name WHERE stdid='".$_POST['stdid']."'");

foreach( $res1 as $results )
{
    $datetime1 = strtotime($result->time);
$datetime2 = strtotime(date("Y-m-d h:i:sa");

$secs = $datetime2 - $datetime1;// == <seconds between the two times>
$days = $secs / 864000;

if($days < 10)
{

}
else
{
    echo 'This book :'. $results->bookname.' need to be returned. Approaching 10 days time';
}

}

if($_POST['stdid']!="")
{

    $wpdb->insert($table_name, array(
        'stdid' => $_POST['stdid'];
        'staffid' => $_POST['staffid'],
        'time' => date("Y-m-d h:i:sa"),
        'stdname' => $_POST['stdname'],
        'bookname' => $_POST['bookname'],
        'rtrn' => $_POST['rtrn'], 
    ));

}


	
    echo '<form action="" method="POST">
    
    <inout type="text" name="stdid" id="stdid"/>
    <inout type="text" name="staffid" id="staffid"/>
    <inout type="text" name="stdname" id="stdname"/>
    <inout type="text" name="bookname" id="bookname"/>
    <inout type="text" name="rtrn" id="rtrn"/>
    <inout type="submit" name="book_rcrd" value="Submit" id="book_rcrd"/>
    </form>';

    //show record

    $res = $wpdb->get_results("SELECT * FROM $wpdb->$table_name");

    foreach( $res as $result ) {

        echo $result->staffid;
        echo $result->stdname;
        echo $result->bookname;

if($result->rtrn!=0 || $result->rtrn!="")
{
    echo "returning";
}
else
{
    echo "borrowing";
}

echo $result->time;

        
        
        
    }




}
