<?php

/*
Plugin Name: Share This Image
Description: Allows you to share in social networks any of your images
Version: 1.28
Author: ILLID
Author URI: https://share-this-image.com/
Text Domain: share-this-image
*/


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'STI_VER', '1.28' );


define( 'STI_DIR', dirname( __FILE__ ) );
define( 'STI_URL', plugins_url( '', __FILE__ ) );


if ( ! class_exists( 'STI_Main' ) ) :

/**
 * Main plugin class
 *
 * @class STI_Main
 */
final class STI_Main {

    /**
     * @var STI_Main The single instance of the class
     */
    protected static $_instance = null;

    /**
     * Main STI_Main Instance
     *
     * Ensures only one instance of STI_Main is loaded or can be loaded.
     *
     * @static
     * @return STI_Main - Main instance
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     */
    public function __construct() {

        $this->includes();

        add_filter( 'plugin_action_links', array( $this, 'add_settings_link' ), 10, 2 );

        add_filter( 'plugin_row_meta', array( $this, 'extra_meta_links'), 10, 2 );

        add_action( 'admin_head', array( $this, 'add_meta_styles' ) );

        load_plugin_textdomain( 'share-this-image', false, dirname( plugin_basename( __FILE__ ) ). '/languages/' );

    }

    /**
     * Include required core files used in admin and on the frontend
     */
    private function includes() {
        include_once( 'includes/class-sti-versions.php' );
        include_once( 'includes/class-sti-functions.php' );
        include_once( 'includes/class-sti-admin-fields.php' );
        include_once( 'includes/class-sti-admin.php' );
        include_once( 'includes/class-sti-admin-ajax.php' );
        include_once( 'includes/class-sti-integrations.php' );
    }

    /*
     * Add settings link to plugins
     */
    public function add_settings_link( $links, $file ) {
        $plugin_base = plugin_basename( __FILE__ );

        if ( $file == $plugin_base ) {
            $setting_link = '<a href="' . admin_url('admin.php?page=sti-options') . '">'.esc_html__( 'Settings', 'share-this-image' ).'</a>';
            array_unshift( $links, $setting_link );

            $premium_link = '<a href="' . admin_url( 'admin.php?page=sti-options&tab=premium' ) . '">'.esc_html__( 'Premium Version', 'share-this-image' ).'</a>';
            array_unshift( $links, $premium_link );
        }

        return $links;
    }

    /*
     * Adds extra links to the plugin activation page
     */
    public function extra_meta_links( $meta, $file ) {
        $plugin_base = plugin_basename( __FILE__ );

        if ( $file == $plugin_base ) {
            $meta[] = '<a class="sti-stars" href="https://wordpress.org/support/plugin/share-this-image/reviews/?rate=5#new-post" target="_blank" title="' . __( 'Leave a review', 'share-this-image' ) . '"></a>';
        }

        return $meta;
    }

    /*
     * Add styles for plugins page
     */
    public function add_meta_styles() {
        global $pagenow;

        if ( $pagenow === 'plugins.php' ) {

            echo "<style>";
                echo ".sti-stars {";
                    echo "background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA0AAAANCAYAAABy6+R8AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDE0IDc5LjE1Njc5NywgMjAxNC8wOC8yMC0wOTo1MzowMiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTQgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjczN0NBQ0M4REI0NzExRTVBRkM4QjEwRTYzMEU5NzgwIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjczN0NBQ0M5REI0NzExRTVBRkM4QjEwRTYzMEU5NzgwIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NzM3Q0FDQzZEQjQ3MTFFNUFGQzhCMTBFNjMwRTk3ODAiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NzM3Q0FDQzdEQjQ3MTFFNUFGQzhCMTBFNjMwRTk3ODAiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz56rxCSAAABCklEQVR42mL8//8/AwZYzcgGJNmB+AtDKKYCJgbswACI84CYC5skLk1mQFwMxPzEaVrNyAIknYBYEIitsWli/L+KgQdIywPxNyAGuV8diFcAsQAQbwPiLKhaZiAGGfgQpEkcyGgDYk+wxxnAhkhCFf4F4ttQDYxA3AvEyxjBobeaURbImQjEgTj8CNJcAcSTgKH5ixEe5JBgrgPiajQNr4A4Cah4K8JPyNGwmtEYSJ6GOgUGToADJPT/P1yhFwjVADJ9B1RMA4it8AV5ABCfA2I/IA4D4mxoXNmhBjnCTyATo4B4MtApr5Gc7AwkjYB4GlD8K7omUGT+Bkp8wRLhokDyE1DuJ4gLEGAARw5K1iodv/cAAAAASUVORK5CYII=');";
                    echo "background-position: 0 0;";
                    echo "font-size: 0;";
                    echo "background-size: 13px 13px;";
                    echo "height: 13px;";
                    echo "display: inline-block;";
                    echo "width: 65px;";
                    echo "position: relative;";
                    echo "top: 2px;";
                echo "}";
            echo "</style>";
        }

    }

}

endif;


/**
 * Returns the main instance of STI_Main
 *
 * @return STI_Main
 */
function STI() {
    return STI_Main::instance();
}

/*
 * Check if WooCommerce is active
 */
if ( ! sti_is_plugin_active( 'share-this-image-pro/share-this-image-pro.php' ) ) {
    STI();
}

/*
 * Check whether the plugin is active by checking the active_plugins list.
 */
function sti_is_plugin_active( $plugin ) {
    return in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) || sti_is_plugin_active_for_network( $plugin );
}

/*
 * Check whether the plugin is active for the entire network
 */
function sti_is_plugin_active_for_network( $plugin ) {
    if ( !is_multisite() )
        return false;

    $plugins = get_site_option( 'active_sitewide_plugins' );
    if ( isset($plugins[$plugin]) )
        return true;

    return false;
}