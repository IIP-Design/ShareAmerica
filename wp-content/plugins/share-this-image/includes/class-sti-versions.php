<?php
/**
 * Versions capability
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'STI_Versions' ) ) :

    /**
     * Class for plugin search
     */
    class STI_Versions {

        /**
         * Return a singleton instance of the current class
         *
         * @return object
         */
        public static function factory() {
            static $instance = false;

            if ( ! $instance ) {
                $instance = new self();
                $instance->setup();
            }

            return $instance;
        }

        /**
         * Placeholder
         */
        public function __construct() {}

        /**
         * Setup actions and filters for all things settings
         */
        public function setup() {

            $current_version = get_option( 'sti_plugin_ver' );
            
            if ( $current_version ) {

                if ( version_compare( $current_version, '1.17', '<' ) ) {

                    $settings = get_option( 'sti_settings' );

                    if ( $settings ) {
                        if ( strpos( $settings['primary_menu'], 'google') !== false) {
                            $settings['primary_menu'] = str_replace( array( 'google,', 'google' ), '', $settings['primary_menu'] );
                            update_option( 'sti_settings', $settings );
                        }

                    }

                }

                if ( version_compare( $current_version, '1.28', '<' ) ) {

                    $settings = get_option( 'sti_settings' );

                    if ( $settings ) {
                        if ( ! isset( $settings['use_analytics'] ) ) {
                            $settings['use_analytics'] = 'false';
                            update_option( 'sti_settings', $settings );
                        }
                    }

                }

            }

            update_option( 'sti_plugin_ver', STI_VER );

        }

    }


endif;

add_action( 'admin_init', 'STI_Versions::factory' );