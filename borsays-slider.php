<?php

/**
 * Plugin Name: Borsay's Slider
 * Plugin URI: https://www.wordpress.org/borsays-slider
 * Description: My Descrip
 * Version: 1.0
 * Requires at least: 5.6
 * Author: Aaron Borsay
 * Author URI: https://www.borsay.xyz
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: borsays-slider
 * Domain Path: /languages
 */

/*
 * Borsay's Slider is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
Borsay's Slider is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with Borsay's Slider. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

if(!defined( 'ABSPATH')){
	exit;
}
if( ! class_exists( 'Borsay_Slider')){
	class Borsay_Slider{
		function __construct(){
			$this->define_constants();

            add_action('admin_menu', array($this, 'add_menu'));

			require_once (BORSAY_SLIDER_PATH. 'post-types/class.borsay-slider-cpt.php');
			$Borsay_Slider_Post_Type = new Borsay_Slider_Post_Type();
            require_once (BORSAY_SLIDER_PATH. 'class.Borsay_Slider_Settings.php');
            $Borsay_Slider_Settings = new Borsay_Slider_Settings();
		}

		public function define_constants(): void {
			define('BORSAY_SLIDER_PATH', plugin_dir_path(__FILE__));
			define('BORSAY_SLIDER_URL', plugin_dir_url(__FILE__));
			define('BORSAY_SLIDER_VERSION', '1.0.0');
		}

		public static function activate(){
			//flush_rewrite_rules();
			update_option('rewrite_rules','');
		}
		public static function deactivate(){
			flush_rewrite_rules();
			unregister_post_type('borsay-slider');
		}
		public static function uninstall(){

		}

        public function add_menu(){
            add_menu_page(
                'Borsay Slider Options',
                'Borsay Slider',
                'manage_options',
                'borsay_slider_admin',
                array($this, 'borsay_slider_settings_page'),
                'dashicons-images-alt2',
            );

            add_submenu_page(
                'borsay_slider_admin',
                'Manage Slider',
                'Manage Slides',
                'manage_options',
                'edit.php?post_type=borsay-slider',
                null,
                null
            );
            add_submenu_page(
                'borsay_slider_admin',
                'Add New Slider',
                'Add New Slides',
                'manage_options',
                'post-new.php?post_type=borsay-slider',
                null,
                null
            );
        }

        public function  borsay_slider_settings_page(){
			if( !current_user_can('manage_options')){
				return;
			}
			if(isset( $_GET['settings-updated'])){
				add_settings_error('borsay_slider_options','borsay_slider_message',
					'Settings Saved', 'success');
			}
			settings_errors('borsay_slider_options');
            require_once (BORSAY_SLIDER_PATH . 'views/settings-page.php');
        }
	}
}


if( class_exists('Borsay_Slider')){
	register_activation_hook(__FILE__, array('Borsay_Slider', 'activate'));
	register_deactivation_hook(__FILE__, array('Borsay_Slider', 'deactivate'));
	register_uninstall_hook(__FILE__, array('Borsay_Slider', 'uninstall'));
	$borsay_slider = new Borsay_Slider();
}