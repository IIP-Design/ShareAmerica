<?php
/**
 * STI admin functions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'STI_Admin' ) ) :

    /**
     * Class for plugin search
     */
    class STI_Admin {

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

            add_action( 'admin_init', array( &$this, 'register_settings' ) );
            add_action( 'admin_menu', array( &$this, 'add_admin_page' ) );
            add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ) );

            if ( ! get_option( 'sti_settings' ) ) {
                $this->initialize_settings();
            }

            add_action( 'admin_notices', array( $this, 'admin_notices_local' ) );

        }

        /*
        * Register plugin settings
        */
        public function register_settings() {
            register_setting( 'sti_settings', 'sti_settings' );
        }

        /*
         * Get plugin settings
         */
        public function get_settings() {
            $plugin_options = get_option( 'sti_settings' );
            return $plugin_options;
        }

        /**
         * Add options page
         */
        public function add_admin_page() {
            add_menu_page( esc_html__( 'Share Image Options', 'share-this-image' ), esc_html__( 'Share Images', 'share-this-image' ), 'manage_options', 'sti-options', array( &$this, 'display_admin_page' ), 'dashicons-format-image' );
        }

        /**
         * Generate and display options page
         */
        public function display_admin_page() {

            $options = $this->options_array();
            $settings = $this->get_settings();
            $nonce = wp_create_nonce( 'plugin-settings' );

            $tabs = array(
                'general' => __( 'General', 'share-this-image' ),
                'content' => __( 'Content', 'share-this-image' ),
                'premium' => __( 'Premium Version', 'share-this-image' ),
            );

            $current_tab = empty( $_GET['tab'] ) ? 'general' : sanitize_text_field( $_GET['tab'] );

            $tabs_html = '';

            foreach ( $tabs as $name => $label ) {
                $tabs_html .= '<a href="' . admin_url( 'admin.php?page=sti-options&tab=' . $name ) . '" class="nav-tab '.$name.'-tab ' . ( $current_tab == $name ? 'nav-tab-active' : '' ) . '">' . esc_html( $label ) . '</a>';
            }

            $tabs_html = '<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">'.$tabs_html.'</h2>';
            

            if ( isset( $_POST["Submit"] ) && current_user_can( 'manage_options' ) && isset( $_POST["_wpnonce"] ) && wp_verify_nonce( $_POST["_wpnonce"], 'plugin-settings' ) ) {
                //$update_settings = array();

                foreach ( $options[$current_tab] as $values ) {

                    if ( $values['type'] === 'heading' ) {
                        continue;
                    }

                    if ( $values['type'] === 'checkbox' ) {
                        foreach ( $values['choices'] as $key => $val ) {
                            $settings[$values['id']][$key] = (string) sanitize_text_field( $_POST[ $values['id'] ][$key] );
                        }
                        continue;
                    }

                    $settings[ $values['id'] ] = (string) sanitize_text_field( $_POST[ $values['id'] ] );

                }

                update_option( 'sti_settings', $settings );
            }

            $sti_options = get_option( 'sti_settings' ); ?>


            <div class="wrap">

                <h1 class="sti-title"><?php esc_html_e( 'Share This Image', 'share-this-image' ); ?></h1>

                <?php echo $tabs_html; ?>

                <form action="" name="sti_form" id="sti_form" class="sti_form form-tab-<?php echo $current_tab; ?>" method="post">

                    <?php

                    switch ($current_tab) {
                        case('content'):
                            new STI_Admin_Fields( $options['content'], $sti_options );
                            break;
                        case('premium'):
                            $this->premium_tab_content();
                            break;
                        default:
                            new STI_Admin_Fields( $options['general'], $sti_options );
                    }

                    ?>

                    <?php //new STI_Admin_Fields( $options, $sti_options ); ?>

                    <input type="hidden" name="_wpnonce" value="<?php echo esc_attr( $nonce ); ?>">

                    <p class="submit"><input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'share-this-image' ); ?>" /></p>

                </form>

            </div>

        <?php }

        /*
         * Display premium tab content
         */
        private function premium_tab_content() {

            echo '<div class="buy-premium">';
                echo '<a href="https://share-this-image.com/pricing/?utm_source=plugin&utm_medium=premium-tab&utm_campaign=sti-pro-plugin" target="_blank">';
                    echo '<span class="desc">' . __( 'Upgrade to the', 'share-this-image' ) . '<b> ' . __( 'Premium plugin version', 'share-this-image' ) . '</b><br>' . __( 'to have all available features!', 'share-this-image' ) . '</span>';
                    echo '<ul>';
                        echo '<li>30-day money back guarantee</li>';
                        echo '<li>One-time payment</li>';
                        echo '<li>Lifetime updates and support</li>';
                    echo '</ul>';
                    echo '</a>';
            echo '</div>';

            echo '<div class="features">';

                echo '<h3>' . __( 'Premium Features', 'share-this-image' ) . '</h3>';

                echo '<div class="features-item">';
                    echo '<div class="column">';
                        echo '<h4 class="title">';
                            echo __( 'Advanced Content Customization', 'share-this-image' );
                        echo '</h4>';
                        echo '<p class="desc">';
                            echo __( 'Set what title, description and URL must be used when sharing images. Set sources for this content and change their priority.', 'share-this-image' );
                            echo '<br><a href="https://share-this-image.com/guide/content-sources/?utm_source=plugin&utm_medium=premium-tab&utm_campaign=sti-pro-plugin" target="_blank">' . __( 'Learn more', 'share-this-image' ) . '</a>';
                        echo '</p>';
                    echo '</div>';
                    echo '<div class="column">';
                        echo '<div class="img">';
                            echo '<img alt="" src="' . STI_URL . '/assets/images/feature3.png' . '" />';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';

                echo '<div class="features-item">';
                    echo '<div class="column">';
                        echo '<h4 class="title">';
                            echo __( 'Content Variables', 'share-this-image' );
                        echo '</h4>';
                        echo '<p class="desc">';
                            echo __( "It is possible to use set of variables to customize shared content. Use all of them or just some. Also possible to use simple logic operators like 'if' and 'not if' to check availability of variables for currently sharing image.", 'share-this-image' );
                            echo '<br><a href="https://share-this-image.com/guide/content-variables/?utm_source=plugin&utm_medium=premium-tab&utm_campaign=sti-pro-plugin" target="_blank">' . __( 'Learn more', 'share-this-image' ) . '</a>';
                        echo '</p>';
                    echo '</div>';
                    echo '<div class="column">';
                        echo '<div class="img">';
                            echo '<img alt="" src="' . STI_URL . '/assets/images/feature7.png' . '" />';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';

                echo '<div class="features-item">';
                    echo '<div class="column">';
                        echo '<h4 class="title">';
                            echo __( 'Styling options', 'share-this-image' );
                        echo '</h4>';
                        echo '<p class="desc">';
                            echo __( "Choose from one of predefined styles for sharing buttons. Align sharing buttons to the left or right side of the image. Choose from vertical or horizontal orientation. Change buttons offsets.", 'share-this-image' );
                            echo '<br><a href="https://share-this-image.com/guide/buttons-styling/?utm_source=plugin&utm_medium=premium-tab&utm_campaign=sti-pro-plugin" target="_blank">' . __( 'Learn more', 'share-this-image' ) . '</a>';
                        echo '</p>';
                    echo '</div>';
                    echo '<div class="column">';
                        echo '<div class="img">';
                            echo '<img alt="" src="' . STI_URL . '/assets/images/feature6.png' . '" />';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';

                echo '<div class="features-item">';
                    echo '<div class="column">';
                        echo '<h4 class="title">';
                            echo __( 'Link, email, download buttons', 'share-this-image' );
                        echo '</h4>';
                        echo '<p class="desc">';
                            echo __( "New sharing buttoms: copy link to image button, send email button to send image via email with custom content and download buttons that give your users option to download images in just one click.", 'share-this-image' );
                            echo '<br><a href="https://share-this-image.com/guide/link-and-email-sharing/?utm_source=plugin&utm_medium=premium-tab&utm_campaign=sti-pro-plugin" target="_blank">' . __( 'Learn more', 'share-this-image' ) . '</a>';
                        echo '</p>';
                    echo '</div>';
                    echo '<div class="column">';
                        echo '<div class="img">';
                            echo '<img alt="" src="' . STI_URL . '/assets/images/feature1.png' . '" />';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';

                echo '<div class="features-item">';
                    echo '<div class="column">';
                        echo '<h4 class="title">';
                            echo __( 'Auto-scroll', 'share-this-image' );
                        echo '</h4>';
                        echo '<p class="desc">';
                            echo __( "Auto-scroll visitors that click on shared image in social network to the exact location of this image on website.", 'share-this-image' );
                            echo '<br><a href="https://share-this-image.com/guide/auto-scroll/?utm_source=plugin&utm_medium=premium-tab&utm_campaign=sti-pro-plugin" target="_blank">' . __( 'Learn more', 'share-this-image' ) . '</a>';
                        echo '</p>';
                    echo '</div>';
                    echo '<div class="column">';
                        echo '<div class="img">';
                            echo '<img alt="" src="' . STI_URL . '/assets/images/feature4.png' . '" />';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';

                echo '<div class="features-item">';
                    echo '<div class="column">';
                        echo '<h4 class="title">';
                            echo __( 'Exclude options', 'share-this-image' );
                        echo '</h4>';
                        echo '<p class="desc">';
                            echo __( "With help of plugin settings page it is possible to exclude all images from certain pages from sharing. Or exclude just single images with help if 'Black list' selector.", 'share-this-image' );
                            echo '<br><a href="https://share-this-image.com/guide/exclude-options/?utm_source=plugin&utm_medium=premium-tab&utm_campaign=sti-pro-plugin" target="_blank">' . __( 'Learn more', 'share-this-image' ) . '</a>';
                        echo '</p>';
                    echo '</div>';
                    echo '<div class="column">';
                        echo '<div class="img">';
                            echo '<img alt="" src="' . STI_URL . '/assets/images/feature2.png' . '" />';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';

                echo '<div class="features-item">';
                    echo '<div class="column">';
                        echo '<h4 class="title">';
                            echo __( 'Priority Support', 'share-this-image' );
                        echo '</h4>';
                        echo '<p class="desc">';
                            echo __( "You will benefit of our full support for any issues you have with this plugin.", 'share-this-image' );
                        echo '</p>';
                    echo '</div>';
                    echo '<div class="column">';
                        echo '<div class="img">';
                            echo '<img alt="" src="' . STI_URL . '/assets/images/feature5.png' . '" />';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';

            echo '</div>';

            echo '<div class="faq">';

            echo '<h3>' . __( 'Frequently Asked Questions', 'share-this-image' ) . '</h3>';

            echo '<div class="faq-item">';
                echo '<h4 class="question">';
                    echo __( 'Is this one-time payment?', 'share-this-image' );
                echo '</h4>';
                echo '<div class="answer">';
                    echo __( 'Yes, you pay once and you can use the plugin in a lifetime, get plugin updates and support.', 'share-this-image' );
                echo '</div>';
            echo '</div>';

            echo '<div class="faq-item">';
                echo '<h4 class="question">';
                    echo __( 'Do you offer refunds?', 'share-this-image' );
                echo '</h4>';
                echo '<div class="answer">';
                    echo __( "If you're not completely happy with your purchase and we're unable to resolve the issue, let us know and we'll refund the full purchase price.", 'share-this-image' );
                    echo '<br>';
                    echo __( 'Refunds can be processed within 30 days of the original purchase.', 'share-this-image' );
                echo '</div>';
            echo '</div>';

            echo '<div class="faq-item">';
                echo '<h4 class="question">';
                    echo __( 'Do I get updates for the premium plugin?', 'share-this-image' );
                echo '</h4>';
                echo '<div class="answer">';
                    echo __( 'Yes! Automatic updates for premium plugin available lifetime after the purchase.', 'share-this-image' );
                echo '</div>';
            echo '</div>';

            echo '<div class="faq-item">';
                echo '<h4 class="question">';
                    echo __( 'Can I use your plugin on multiple websites?', 'share-this-image' );
                echo '</h4>';
                echo '<div class="answer">';
                    echo __( 'Yes, you are free to use our plugin on as many websites as you like.', 'share-this-image' );
                echo '</div>';
            echo '</div>';

            echo '<div class="faq-item">';
                echo '<h4 class="question">';
                    echo __( 'What payment methods do you accept?', 'share-this-image' );
                echo '</h4>';
                echo '<div class="answer">';
                    echo __( 'We support major credit and debit cards, PayPal, and a variety of other mainstream payment methods, so there’s plenty to pick from.', 'share-this-image' );
                echo '</div>';
            echo '</div>';

            echo '<div class="faq-item">';
                echo '<h4 class="question">';
                    echo __( 'Do you offer support if I need help?', 'share-this-image' );
                echo '</h4>';
                echo '<div class="answer">';
                    echo __( 'Yes! You will benefit of our full support for any issues you have with this plugin.', 'share-this-image' );
                echo '</div>';
            echo '</div>';

            echo '<div class="faq-item">';
                echo '<h4 class="question">';
                    echo __( 'I have other pre-sale questions, can you help?', 'share-this-image' );
                echo '</h4>';
                echo '<div class="answer">';
                    echo __( 'Yes! You can ask us any question through our', 'share-this-image' ) . ' <a href="https://share-this-image.com/contact/?utm_source=plugin&utm_medium=premium-tab&utm_campaign=sti-pro-plugin" target="_blank">' . __( 'contact form.', 'share-this-image' ) . '</a>';
                echo '</div>';
            echo '</div>';

            echo '</div>';

            echo '<div class="buy-premium">';
                echo '<a href="https://share-this-image.com/pricing/?utm_source=plugin&utm_medium=premium-tab&utm_campaign=sti-pro-plugin" target="_blank">';
                    echo '<span class="desc">' . __( 'Upgrade to the', 'share-this-image' ) . '<b> ' . __( 'Premium plugin version', 'share-this-image' ) . '</b><br>' . __( 'to have all available features!', 'share-this-image' ) . '</span>';
                echo '</a>';
            echo '</div>';

        }

        /*
         * Options array that generate settings page
         */
        public function options_array() {

            require_once STI_DIR .'/includes/options.php';

            return $options;
        }

        /**
         * Initialize settings to their default values
         */
        public function initialize_settings() {
            $options = $this->options_array();
            $default_settings = array();

            foreach ( $options as $section_name => $section ) {
                foreach ($section as $values) {

                    if ($values['type'] === 'heading') {
                        continue;
                    }

                    if ($values['type'] === 'checkbox') {
                        foreach ($values['choices'] as $key => $val) {
                            $default_settings[$values['id']][$key] = (string) sanitize_text_field( $values['value'][$key] );
                        }
                        continue;
                    }

                    $default_settings[$values['id']] = (string) sanitize_text_field( $values['value'] );

                }
            }

            update_option( 'sti_settings', $default_settings );
        }

        /**
         * Enqueue admin scripts and styles
         */
        public function admin_enqueue_scripts() {
            if ( isset( $_GET['page'] ) && $_GET['page'] == 'sti-options' ) {
                wp_enqueue_style( 'sti-admin-style', STI_URL . '/assets/css/sti-admin.css', array(), STI_VER );
                wp_enqueue_script( 'jquery' );
                wp_enqueue_script( 'jquery-ui-sortable' );
                wp_enqueue_script( 'sti-admin-js', STI_URL . '/assets/js/admin.js', array('jquery'), STI_VER );
                wp_localize_script( 'sti-admin-js', 'sti_ajax_object', array(
                    'ajax_nonce' => wp_create_nonce( 'ajax_nonce' ),
                ) );
            }
        }

        /*
         * Add admin notice
         */
        public function admin_notices_local() {

            if ( get_option( 'sti-notice-dismiss-local-notice' ) ) {
                return;
            }

            if ( isset( $_GET['page'] ) && $_GET['page'] === 'sti-options' ) { ?>
                <div data-sti-notice="local-notice" class="notice notice-info is-dismissible">
                    <p><?php _e('<strong>Remember:</strong> Plugin won\'t scrap any data if you are using it on your <strong>local server</strong> or if your site disable <strong>search engine indexing</strong>.', 'share-this-image'); ?></p>

                    <p><?php _e('Please test STI plugin on publicly available site.', 'share-this-image'); ?></p>
                </div>
            <?php }

        }

    }


endif;

STI_Admin::factory();