<?php
/**
 * Array of plugin options
 */

$options = array();

$options['general'][] = array(
    "name"    => __( "What to Share", "share-this-image" ),
    "desc"    => '',
    "type"    => "heading"
);

$options['general'][] = array(
    "name"  => __( "Selector", "share-this-image" ),
    "desc"  => __( "Selectors for images. Separate several selectors with commas.", "share-this-image" ),
    "id"    => "selector",
    "value" => 'img',
    "type"  => "text"
);

$options['general'][] = array(
    "name"    => __( "Display Settings", "share-this-image" ),
    "desc"    => '',
    "type"    => "heading"
);

$options['general'][] = array(
    "name"  => __( "Minimal width", "share-this-image" ),
    "desc"  => __( "Minimum width of image in pixels to use for sharing.", "share-this-image" ),
    "id"    => "minWidth",
    "value" => '200',
    "type"  => "number"
);

$options['general'][] = array(
    "name"  => __( "Minimal height", "share-this-image" ),
    "desc"  => __( "Minimum height of image in pixels to use for sharing.", "share-this-image" ),
    "id"    => "minHeight",
    "value" => '200',
    "type"  => "number"
);

$options['general'][] = array(
    "name"  => __( "Twitter via", "share-this-image" ),
    "desc"  => __( "Set twitters 'via' property.", "share-this-image" ),
    "id"    => "twitter_via",
    "value" => '',
    "type"  => "text"
);

$options['general'][] = array(
    "name"  => __( "Share buttons", "share-this-image" ),
    "desc"  => __( "Drag and drop to the right area share buttons that you want to appear for image sharing", "share-this-image" ) . '<br>' . __( "Position of fields shows the position of each share button in the sharing box.", "share-this-image" ),
    "id"    => "primary_menu",
    "value" => "facebook,twitter,linkedin,pinterest",
    "choices" => array(
        "facebook"      => __( "Facebook", "share-this-image" ),
        "messenger"     => __( "Messenger", "share-this-image" ),
        "twitter"       => __( "Twitter", "share-this-image" ),
        "linkedin"      => __( "LinkedIn", "share-this-image" ),
        "pinterest"     => __( "Pinterest", "share-this-image" ),
        "whatsapp"      => __( "WhatsApp ", "share-this-image" ),
        "tumblr"        => __( "Tumblr", "share-this-image" ),
        "reddit"        => __( "Reddit", "share-this-image" ),
        "digg"          => __( "Digg", "share-this-image" ),
        "delicious"     => __( "Delicious", "share-this-image" ),
        "vkontakte"     => __( "Vkontakte", "share-this-image" ),
        "odnoklassniki" => __( "Odnoklassniki", "share-this-image" )
    ),
    "type"  => "sortable"
);

$options['general'][] = array(
    "name"  => __( "Enable on mobile?", "share-this-image" ),
    "desc"  => __( "Enable image sharing on mobile devices", "share-this-image" ),
    "id"    => "on_mobile",
    "value" => 'true',
    "type"  => "radio",
    'choices' => array(
        'true' => __( 'On', 'share-this-image' ),
        'false' => __( 'Off', 'share-this-image' )
    )
);

$options['general'][] = array(
    "name"  => __( "Always show?", "share-this-image" ),
    "desc"  => __( "Show sharing buttons only on hover or make them all visible on page load.", "share-this-image" ) . '<br>' .
               __( "NOTE: Enabling this option can cause some problems with images inside sliders, galleries, etc.", "share-this-image" ),
    "id"    => "always_show",
    "value" => 'false',
    "type"  => "radio",
    'choices' => array(
        'true' => __( 'On', 'share-this-image' ),
        'false' => __( 'Off', 'share-this-image' )
    )
);

$options['general'][] = array(
    "name"  => __( "Use intermediate page.", "share-this-image" ),
    "desc"  => __( "If you have some problems with redirection from social networks to page with sharing image try to switch Off this option.", "share-this-image" ) . '</br>' .
               __( "But before apply it need to be tested to ensure that all work's fine.", 'share-this-image' ),
    "id"    => "sharer",
    "value" => 'true',
    "type"  => "radio",
    'choices' => array(
        'true'  => __( 'On', 'share-this-image' ),
        'false' => __( 'Off', 'share-this-image' )
    )
);

$options['general'][] = array(
    "name"  => __( "Google Analytics", "share-this-image" ),
    "desc"  => __( "Use google analytics to track social buttons clicks. Need google analytics to be installed on your site.", "share-this-image" ) .
        '<br>' . __( "Will be send the event with category - 'STI click', action - 'social button name' and label of value of image URL.", "share-this-image" ),
    "id"    => "use_analytics",
    "value" => 'false',
    "type"  => "radio",
    'choices' => array(
        'true'  => __( 'On', 'share-this-image' ),
        'false' => __( 'Off', 'share-this-image' )
    )
);

$options['content'][] = array(
    "name"    => "",
    "desc"    => sprintf( __( 'Plugin has %s special rules %s how to choose what title and description to use for sharing.', 'share-this-image' ), '<a href="https://share-this-image.com/guide/customize-content/" target="_blank">', '</a>' ) . '<br>' .
                 __( 'There is different sources that plugin look in step by step searching for content according to priority of this sources.', 'share-this-image' ) . '<br>' .
                 __( 'Also with PRO plugin version you can change priority of this sources or even disable/enable some of them.', 'share-this-image' ) . '<br>' . '<br>' .
                 __( "For title: 'data-title attribute' -> 'image title attribute' -> 'default title option' -> 'page title'", "share-this-image" ) . '<br>' .
                 __( "For description: 'data-summary attribute' -> 'image caption' -> 'image alt attribute' -> 'default description option'", "share-this-image" ) . '<br>' . '<br>' .
                 sprintf( __( "It is also possible to create your fully unique title and description with help of special %s variables and conditions %s.", "share-this-image" ), '<a href="https://share-this-image.com/guide/customize-content/" target="_blank">', '</a>' ),
    "type"    => "heading"
);

$options['content'][] = array(
    "name"    => __( "Default Content", "share-this-image" ),
    "desc"    => '',
    "type"    => "heading"
);

$options['content'][] = array(
    "name"  => __( "Default Title", "share-this-image" ),
    "desc"  => __( "Content for 'Default Title' source.", "share-this-image" ),
    "id"    => "title",
    "value" => '',
    "type"  => "text"
);

$options['content'][] = array(
    "name"  => __( "Default Description", "share-this-image" ),
    "desc"  => __( "Content for 'Default Description' source.", "share-this-image" ),
    "id"    => "summary",
    "value" => '',
    "type"  => "textarea"
);