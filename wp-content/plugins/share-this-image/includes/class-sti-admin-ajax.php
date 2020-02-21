<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'STI_Admin_Ajax' ) ) :

    /**
     * Class for plugin admin ajax hooks
     */
    class STI_Admin_Ajax {

        /*
         * Constructor
         */
        public function __construct() {

            add_action( 'wp_ajax_sti-dismissNotice', array( $this, 'dismiss_notice' ) );

        }

        /*
         * Ajax hook for form renaming
         */
        public function dismiss_notice() {

            check_ajax_referer( 'ajax_nonce' );

            $notice_name = sanitize_text_field( $_POST['notice'] );

            update_option( 'sti-notice-dismiss-' . $notice_name, '1' );

            die;

        }

    }

endif;


new STI_Admin_Ajax();