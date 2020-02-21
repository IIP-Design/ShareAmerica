<?php
/**
 * STI functions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'STI_Functions' ) ) :

    /**
     * Class for main plugin functions
     */
    class STI_Functions {

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

            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 999999 );
            add_action( 'wp_head', array( $this, 'metatags' ), 1 );

            add_shortcode( 'sti_image', array( $this, 'shortcode' ) );

            if ( $this->is_sharing() ) {

                add_filter( 'wp_title', array( $this, 'generate_title' ), 999999 );

                add_filter( 'wpseo_opengraph_image', array( $this, 'disable_yoast' ), 999999 );
                add_filter( 'wpseo_twitter_image', array( $this, 'disable_yoast' ), 999999 );

                add_filter( 'wpseo_og_og_image_width', array( $this, 'disable_yoast' ), 999999 );
                add_filter( 'wpseo_og_og_image_height', array( $this, 'disable_yoast' ), 999999 );

                add_filter( 'wpseo_opengraph_title', array( $this, 'disable_yoast' ), 999999 );
                add_filter( 'wpseo_twitter_title', array( $this, 'disable_yoast' ), 999999 );
                add_filter( 'wpseo_title', array( $this, 'disable_yoast' ), 999999 );

                add_filter( 'wpseo_opengraph_desc', array( $this, 'disable_yoast' ), 999999 );
                add_filter( 'wpseo_twitter_description', array( $this, 'disable_yoast' ), 999999 );
                add_filter( 'wpseo_metadesc', array( $this, 'disable_yoast' ), 999999 );

                add_action( 'wpseo_head', array( $this, 'disable_yoast' ), 999999 );

                add_filter( 'wpseo_canonical', array( $this, 'disable_yoast' ), 999999 );

                add_filter( 'wpseo_opengraph_type', array( $this, 'disable_yoast' ), 999999 );

                add_filter( 'wpseo_output_twitter_card', array( $this, 'disable_yoast' ), 999999 );

            }

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

        /*
         * Return list of active share buttons
         */
        private function get_primary_menu() {

            $primary_menu_array = explode( ',', $this->get_settings('primary_menu') );

            /**
             * Array of sharing buttons
             * @since 1.22
             * @param $primary_menu_array array
             */
            $primary_menu_array = apply_filters( 'sti_buttons_array', $primary_menu_array );

            return $primary_menu_array;

        }

        /**
         * Enqueue frontend scripts and styles
         *
         * @return void
         */
        public function enqueue_scripts() {

            $settings = $this->get_settings();

            if ( wp_is_mobile() && $settings['on_mobile'] === 'false' ) {
                return false;
            }

            wp_enqueue_style( 'sti-style', STI_URL . '/assets/css/sti.css', array(), STI_VER );
            wp_enqueue_script( 'sti-script', STI_URL . '/assets/js/sti.js', array('jquery'), STI_VER, true );
            wp_localize_script( 'sti-script', 'sti_vars', array(
                'ajaxurl'      => admin_url( 'admin-ajax.php' ),
                'selector'     => stripslashes( $settings['selector'] ),
                'title'        => stripslashes( $settings['title'] ),
                'summary'      => stripslashes( $settings['summary'] ),
                'minWidth'     => $settings['minWidth'],
                'minHeight'    => $settings['minHeight'],
                'sharer'       => ( $settings['sharer'] == 'true' ) ? STI_URL . '/sharer.php' : '',
                'is_mobile'    => wp_is_mobile() ? true : false,
                'always_show'  => ( $settings['always_show'] == 'true' ) ? true : false,
                'analytics'    => ( $settings['use_analytics'] == 'true' ) ? true : false,
                'primary_menu' => $this->get_primary_menu(),
                'twitterVia'   => $settings['twitter_via'],
            ) );

        }
        
        /**
         * Add special metatags to the head of the site
         */
        public function metatags() {

            if ( $this->is_sharing() ) {

                $http_ext = isset( $_GET['ssl'] ) ? 'https://' : 'http://';

                $page_link = esc_url( $http_ext . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"] );

                $title = isset( $_GET['title'] ) ? htmlspecialchars( urldecode( $_GET['title'] ) ) : '';
                $desc = isset( $_GET['desc'] ) ? htmlspecialchars( urldecode( $_GET['desc'] ) ) : '';
                $image = $http_ext . htmlspecialchars( $_GET['img'] );
                $network = isset( $_GET['network'] ) ? htmlspecialchars( $_GET['network'] ) : '';

                $image_sizes = @getimagesize( $image );

                echo '<!-- Share This Image plugin meta tags -->';

                echo '<meta property="og:type" content="article" />';
                echo '<meta name="twitter:card" content="summary_large_image">';

                //if ( $network !== 'facebook' ) {
                    echo '<link rel="canonical" href="' . $page_link . '" />';
                    echo '<meta property="og:url" content="' . $page_link . '" />';
                    echo '<meta property="twitter:url" content="' . $page_link . '" />';
                //}

                echo '<meta property="og:image" content="'.$image.'" />';

                if ( $network == 'twitter' ) {
                    echo '<meta property="twitter:image" content="'.$image.'" />';
                }

                if ( $image_sizes ) {
                    list( $width, $height ) = $image_sizes;
                    echo '<meta property="og:image:width" content="'.$width.'" />';
                    echo '<meta property="og:image:height" content="'.$height.'" />';
                }

                if ( $title ) {
                    echo '<title>'.$title.'</title>';
                    echo '<meta property="og:title" content="'.$title.'" />';
                    echo '<meta property="twitter:title" content="'.$title.'" />';
                    echo '<meta property="og:site_name" content="'.$title.'" />';
                }

                if ( $desc ) {
                    echo '<meta name="description" content="'.$desc.'">';
                    echo '<meta property="og:description" content="'.$desc.'"/>';
                    echo '<meta property="twitter:description" content="'.$desc.'"/>';
                }

                echo '<!-- END Share This Image plugin meta tags -->';

            }

            if ( isset( $_GET['close'] ) ) { ?>
                <script type="text/javascript">
                    window.close();
                </script>
            <?php }

        }

        /*
         * Shortcode for image sharing
         */
        public function shortcode( $atts = array() ) {

            extract( shortcode_atts( array(
                'image'           => '',
                'shared_image'    => '',
                'shared_url'      => '',
                'shared_title'    => '',
                'shared_desc'     => '',
            ), $atts ) );


            $params_string = '';
            $output = '';

            $params = array(
                'data-media'   => $shared_image,
                'data-url'     => $shared_url,
                'data-title'   => $shared_title,
                'data-summary' => $shared_desc,
            );

            foreach( $params as $key => $value ) {
                if ( $value ) {
                    $params_string .= $key . '="' . esc_attr( $value ) . '" ';
                }
            }

            if ( $image ) {
                $output = '<img src="' . esc_url( $image ) . '" ' . $params_string . '>';
            }

            return apply_filters( 'sti_shortcode_output', $output );

        }

        /*
         * Disable yoast metatags
         */
        public function disable_yoast( $content ) {
            return false;
        }

        /*
         * Add shared title in don't use
         */
        public function generate_title( $title ) {
            $title = isset( $_GET['title'] ) ? sanitize_text_field( urldecode( $_GET['title'] ) ) : '';
            return $title;
        }

        /*
         * Check if need to add meta tags on page for shared content
         */
        private function is_sharing() {
            return isset( $_GET['img'] );
        }

    }


endif;

STI_Functions::factory();