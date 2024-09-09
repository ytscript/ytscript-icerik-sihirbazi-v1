<?php
/*
Plugin Name: Ytscript: İçerik Sihirbazı v2
Plugin URI: https://ytscript.com
Description: İçerik Sihirbazı İçerik Üret eklentisinde kullanmak üzere, seçeceğiniz kategorilerde özgün başlıklar üretmenizi sağlar.
Version: 1.2
Author: ytscript
Author URI: https://ytscript.com
License: GNU
*/

if (!defined('ABSPATH')) die;
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 0);
error_reporting(0);
set_time_limit(180);

include('functions.php');

function ytscript_content_wizard()
{
    add_menu_page(
        'Ytscript: İçerik Sihirbazı', // Menü başlığı
        'Ytscript: İçerik Sihirbazı', // Menü adı
        'manage_options', // Gerekli yetki seviyesi
        'ytscript_content_wizard', // Menu slug
        'ytscript_content_wizard_page', // Sayfa içeriğini göstermek için kullanılan işlev adı
        'dashicons-admin-plugins', // Icon
        99 // Sıra numarası
    );

    add_submenu_page(
        'ytscript_content_wizard',
        'Ayarlar',
        'Ayarlar',
        'manage_options',
        'ayarlar',
        'alt_menu_callback_function' // Alt menü için içerik gösteren işlev adı
    );
    
}

function ytscript_content_wizard_page()
{
    include('content.php');
}
function alt_menu_callback_function()
{
    // Başka dosyadan içeriği dahil etme
    include 'apipage.php';
}

add_action('admin_menu', 'ytscript_content_wizard');
wp_enqueue_style('style', plugins_url('style.css', __FILE__), '', '1.0');


