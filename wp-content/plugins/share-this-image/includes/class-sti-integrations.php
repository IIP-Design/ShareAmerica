<?php
/**
 * STI integrations
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'STI_Integrations' ) ) :

    /**
     * Class for main plugin functions
    */
    class STI_Integrations {

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

            // Metaslider plugin
            add_filter( 'metaslider_flex_slider_parameters', array( $this, 'metaslider_flex_slider_parameters' ) );
            //add_filter( 'metaslider_nivo_slider_parameters', array( $this, 'metaslider_nivo_slider_parameters' ) );

        }

        /*
         * Metaslider flex slider integration
         */
        public function metaslider_flex_slider_parameters( $options ) {

            $settings = $this->get_settings();

            $options['after'] = 'function(slider){ $("'. esc_html( stripslashes( $settings['selector'] ) ) .'").sti(); }';

            return $options;
        }

        /*
        * Metaslider nivo slider integration
        */
        public function metaslider_nivo_slider_parameters( $options ) {

            $settings = $this->get_settings();

            $options['afterChange'] = 'function(){ $("'. esc_html( stripslashes( $settings['selector'] ) ) .', .nivo-main-image").sti(); }';

            return $options;

        }

        /*
         * Register plugin settings
         */
        public function get_settings( $id = false ) {
            $sti_options = get_option( 'sti_settings' );
            if ( $id ) {
                return $sti_options[ $id ];
            } else {
                return $sti_options;
            }
        }

    }

endif;

STI_Integrations::factory();