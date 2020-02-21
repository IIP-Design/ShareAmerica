<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'STI_Admin_Fields' ) ) :

    /**
     * Class for plugin admin ajax hooks
     */
    class STI_Admin_Fields {

        /**
         * @var STI_Admin_Fields The array of options that is need to be generated
         */
        private $options_array;

        /**
         * @var STI_Admin_Fields Current plugin instance options
         */
        private $plugin_options;

        /*
         * Constructor
         */
        public function __construct( $options, $plugin_options ) {

            $this->options_array = $options;
            $this->plugin_options = $plugin_options;

            $this->generate_fields();

        }

        /*
         * Generate options fields
         */
        private function generate_fields() {

            if ( empty( $this->options_array ) ) {
                return;
            }

            $plugin_options = $this->plugin_options;

            echo '<table class="form-table">';
            echo '<tbody>';

            foreach ( $this->options_array as $k => $value ) {

                if ( isset( $value['depends'] ) && ! $value['depends'] ) {
                    continue;
                }
                switch ( $value['type'] ) {

                    case 'text': ?>
                        <tr valign="top">
                            <th scope="row"><?php echo esc_html( $value['name'] ); ?></th>
                            <td>
                                <input type="text" name="<?php echo esc_attr( $value['id'] ); ?>" class="regular-text" value="<?php echo isset( $plugin_options[ $value['id'] ] ) ? esc_attr( stripslashes( $plugin_options[ $value['id'] ] ) ) : ''; ?>">
                                <br><span class="description"><?php echo wp_kses_post( $value['desc'] ); ?></span>
                            </td>
                        </tr>
                        <?php break;

                    case 'image': ?>

                        <tr valign="top">
                            <th scope="row"><?php echo esc_html( $value['name'] ); ?></th>
                            <td>
                                <img class="image-preview" src="<?php echo esc_url( stripslashes( $plugin_options[ $value['id'] ] ) ); ?>"  />
                                <input type="hidden" size="40" name="<?php echo esc_attr( $value['id'] ); ?>" class="image-hidden-input" value="<?php echo isset( $plugin_options[ $value['id'] ] ) ? esc_attr( stripslashes( $plugin_options[ $value['id'] ] ) ) : ''; ?>" />
                                <input class="button image-upload-btn" type="button" value="<?php echo esc_attr__( 'Upload Image', 'share-this-image' ); ?>" data-size="<?php echo esc_attr( $value['size'] ); ?>" />
                                <input class="button image-remove-btn" type="button" value="<?php echo esc_attr__( 'Remove Image', 'share-this-image' ); ?>" />
                            </td>
                        </tr>

                        <?php

                        break;

                    case 'number': ?>
                        <tr valign="top">
                            <th scope="row"><?php echo esc_html( $value['name'] ); ?></th>
                            <td>
                                <input type="number" name="<?php echo esc_attr( $value['id'] ); ?>" class="regular-text" value="<?php echo isset( $plugin_options[ $value['id'] ] ) ? intval( esc_attr( stripslashes( $plugin_options[ $value['id'] ] ) ) ) : ''; ?>">
                                <br><span class="description"><?php echo wp_kses_post( $value['desc'] ); ?></span>
                            </td>
                        </tr>
                        <?php break;

                    case 'number_add': ?>
                        <?php
                        $page_ids_val = isset( $plugin_options[ $value['id'] ] ) ? stripslashes( $plugin_options[ $value['id'] ] ) : '';
                        $page_ids_array = json_decode( $page_ids_val );
                        ?>
                        <tr valign="top">
                            <th scope="row"><?php echo $value['name']; ?></th>
                            <td data-container>

                                <ul data-add-number-list class="items-list clearfix">

                                    <?php

                                    if ( ! empty( $page_ids_array ) ) {

                                        foreach( $page_ids_array as $page_id ) {
                                            echo '<li class="item">';
                                                echo '<span data-name="' . esc_attr( $page_id ) . '" class="name">' . esc_attr( $page_id ) . '</span>';
                                                echo '<a data-remove-number-btn class="close">x</a>';
                                            echo '</li>';
                                        }

                                    }
                                    ?>

                                </ul>

                                <input data-add-number-val type="hidden" name="<?php echo esc_attr( $value['id'] ); ?>" value='<?php echo isset( $plugin_options[ $value['id'] ] ) ? esc_attr( stripslashes( $plugin_options[ $value['id'] ] ) ) : ''; ?>'>

                                <input data-add-number-name type="number" class="regular-text" value="">
                                <input data-add-number-btn type="submit" name="<?php echo esc_attr__( 'Add', 'share-this-image' ); ?>" class="button-primary" value="<?php echo esc_attr__( 'Add', 'share-this-image' ); ?>">
                                <br><span class="description"><?php echo wp_kses_post( $value['desc'] ); ?></span>
                            </td>
                        </tr>
                        <?php break;

                    case 'textarea': ?>
                        <tr valign="top">
                            <th scope="row"><?php echo esc_html( $value['name'] ); ?></th>
                            <td>
                                <textarea id="<?php echo esc_attr( $value['id'] ); ?>" name="<?php echo esc_attr( $value['id'] ); ?>" cols="45" rows="3"><?php print isset( $plugin_options[ $value['id'] ] ) ? esc_html( stripslashes( $plugin_options[ $value['id'] ] ) ) : ''; ?></textarea>
                                <br><span class="description"><?php echo wp_kses_post( $value['desc'] ); ?></span>
                            </td>
                        </tr>
                        <?php break;

                    case 'checkbox': ?>
                        <tr valign="top">
                            <th scope="row"><?php echo esc_html( $value['name'] ); ?></th>
                            <td>
                                <?php $checkbox_options = $plugin_options[ $value['id'] ]; ?>
                                <?php foreach ( $value['choices'] as $val => $label ) { ?>
                                    <input type="checkbox" name="<?php echo esc_attr( $value['id'] . '[' . $val . ']' ); ?>" id="<?php echo esc_attr( $value['id'] . '_' . $val ); ?>" value="1" <?php checked( $checkbox_options[$val], '1' ); ?>> <label for="<?php echo esc_attr( $value['id'] . '_' . $val ); ?>"><?php echo esc_html( $label ); ?></label><br>
                                <?php } ?>
                                <br><span class="description"><?php echo wp_kses_post( $value['desc'] ); ?></span>
                            </td>
                        </tr>
                        <?php break;

                    case 'radio': ?>
                        <tr valign="top">
                            <th scope="row"><?php echo esc_html( $value['name'] ); ?></th>
                            <td>
                                <?php foreach ( $value['choices'] as $val => $label ) { ?>
                                    <input class="radio" type="radio" name="<?php echo esc_attr( $value['id'] ); ?>" id="<?php echo esc_attr( $value['id'].$val ); ?>" value="<?php echo esc_attr( $val ); ?>" <?php checked( $plugin_options[ $value['id'] ], $val ); ?>> <label for="<?php echo esc_attr( $value['id'].$val ); ?>"><?php echo esc_html( $label ); ?></label><br>
                                <?php } ?>
                                <br><span class="description"><?php echo wp_kses_post( $value['desc'] ); ?></span>
                            </td>
                        </tr>
                        <?php break;

                    case 'select': ?>
                        <tr valign="top">
                            <th scope="row"><?php echo esc_html( $value['name'] ); ?></th>
                            <td>
                                <select name="<?php echo esc_attr( $value['id'] ); ?>">
                                    <?php foreach ( $value['choices'] as $val => $label ) { ?>
                                        <option value="<?php echo esc_attr( $val ); ?>" <?php selected( $plugin_options[ $value['id'] ], $val ); ?>><?php echo esc_html( $label ); ?></option>
                                    <?php } ?>
                                </select>
                                <br><span class="description"><?php echo wp_kses_post( $value['desc'] ); ?></span>
                            </td>
                        </tr>
                        <?php break;

                    case 'select_advanced': ?>
                        <tr valign="top">
                            <th scope="row"><?php echo esc_html( $value['name'] ); ?></th>
                            <td>
                                <select name="<?php echo esc_attr( $value['id'].'[]' ); ?>" multiple class="chosen-select">
                                    <?php $values = $plugin_options[ $value['id'] ]; ?>
                                    <?php foreach ( $value['choices'] as $val => $label ) {  ?>
                                        <?php $selected = ( is_array( $values ) && in_array( $val, $values ) ) ? ' selected="selected" ' : ''; ?>
                                        <option value="<?php echo esc_attr( $val ); ?>"<?php echo $selected; ?>><?php echo esc_html( $label ); ?></option>
                                    <?php } ?>
                                </select>
                                <br><span class="description"><?php echo wp_kses_post( $value['desc'] ); ?></span>

                            </td>
                        </tr>
                        <?php break;

                    case 'sortable': ?>
                        <tr valign="top">
                            <th scope="row"><?php echo esc_html( $value['name'] ); ?></th>
                            <td>


                                <script>
                                    jQuery(document).ready(function() {

                                        jQuery( "#<?php echo esc_attr( $value['id'] ); ?>1, #<?php echo esc_attr( $value['id'] ); ?>2" ).sortable({
                                            connectWith: ".connectedSortable",
                                            placeholder: "highlight",
                                            update: function(event, ui){
                                                var serviceList = '';
                                                jQuery("#<?php echo esc_attr( $value['id'] ); ?>2 li").each(function(){

                                                    serviceList = serviceList + ',' + jQuery(this).attr('id');

                                                });
                                                var serviceListOut = serviceList.substring(1);
                                                jQuery('#<?php echo esc_attr( $value['id'] ); ?>').attr('value', serviceListOut);
                                            }
                                        }).disableSelection();

                                    })
                                </script>

                                <span class="description"><?php echo wp_kses_post( $value['desc'] ); ?></span><br><br>

                                <?php
                                $all_buttons = $value['choices'];
                                $active_buttons = explode( ',', $plugin_options[ $value['id'] ] );
                                $active_buttons_array = array();

                                if ( count( $active_buttons ) > 0 ) {
                                    foreach ($active_buttons as $button) {
                                        $active_buttons_array[$button] = $all_buttons[$button];
                                    }
                                }

                                $inactive_buttons = array_diff($all_buttons, $active_buttons_array);
                                ?>


                                <div class="sortable-container">

                                    <div class="sortable-title">
                                        <?php esc_html_e( 'Active', 'share-this-image' ) ?><br>
                                        <?php esc_html_e( 'Change order by drag&drop', 'share-this-image' ) ?>
                                    </div>

                                    <ul id="<?php echo esc_attr( $value['id'] ); ?>2" class="sti-sortable enabled connectedSortable">
                                        <?php
                                        if ( count( $active_buttons_array ) > 0 ) {
                                            foreach ($active_buttons_array as $button_value => $button) {
                                                if ( ! $button ) continue;
                                                echo '<li id="' . esc_attr( $button_value ) . '" class="sti-btn sti-' . esc_attr( $button_value ) . '-btn">' . esc_html( $button ) . '</li>';
                                            }
                                        }
                                        ?>
                                    </ul>

                                </div>

                                <div class="sortable-container">

                                    <div class="sortable-title">
                                        <?php esc_html_e( 'Inactive', 'share-this-image' ) ?><br>
                                        <?php esc_html_e( 'Excluded from this option', 'share-this-image' ) ?>
                                    </div>

                                    <ul id="<?php echo $value['id']; ?>1" class="sti-sortable disabled connectedSortable">
                                        <?php
                                        if ( count( $inactive_buttons ) > 0 ) {
                                            foreach ($inactive_buttons as $button_value => $button) {
                                                echo '<li id="' . esc_attr( $button_value ) . '" class="sti-btn sti-' . esc_attr( $button_value ) . '-btn">' . esc_html( $button ) . '</li>';
                                            }
                                        }
                                        ?>
                                    </ul>

                                </div>

                                <input type="hidden" id="<?php echo $value['id']; ?>" name="<?php echo esc_attr( $value['id'] ); ?>" value="<?php echo esc_attr( $plugin_options[ $value['id'] ] ); ?>" />

                            </td>
                        </tr>
                        <?php break;

                    case 'heading': ?>
                        <tr valign="top" class="heading">
                            <th scope="row"><h3><?php echo esc_html( $value['name'] ); ?></h3></th>
                            <td>
                                <span class="description"><?php echo wp_kses_post( $value['desc'] ); ?></span>
                            </td>
                        </tr>
                        <?php break;
                }

            }

            echo '</tbody>';
            echo '</table>';

        }

    }

endif;