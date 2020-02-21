<!DOCTYPE html>

<html itemscope itemtype="http://schema.org/Blog">

    <head>

        <meta charset="UTF-8">
        <meta property="og:type" content="article" />
        <meta name="twitter:card" content="summary_large_image">

        <?php 
        
        $url = isset( $_GET['url'] ) ? htmlspecialchars( $_GET['url'] ) : '';
        
        if ( isset( $_GET['img'] ) ) {

            $http_ext = isset( $_GET['ssl'] ) ? 'https://' : 'http://';

            $page_link = $http_ext . $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
            $title = isset( $_GET['title'] ) ? htmlspecialchars( urldecode( $_GET['title'] ) ) : '';
            $desc = isset( $_GET['desc'] ) ? htmlspecialchars( urldecode( $_GET['desc'] ) ) : '';
            $image = $http_ext . htmlspecialchars( $_GET['img'] );
            $network = isset( $_GET['network'] ) ? htmlspecialchars( $_GET['network'] ) : '';

            $image_sizes = @getimagesize( $image );

            //if ( $network !== 'facebook' ) {
                echo '<link rel="canonical" href="' . $page_link . '" />';
                echo '<meta property="og:url" content="' . $page_link . '" />';
                echo '<meta property="twitter:url" content="' . $page_link . '" />';
            //}

            echo '<meta property="og:image" content="'.$image.'" />';

            if ( $image_sizes ) {
                list( $width, $height ) = $image_sizes;
                echo '<meta property="og:image:width" content="'.$width.'" />';
                echo '<meta property="og:image:height" content="'.$height.'" />';
            }

            if ( $network == 'twitter' ) {
                echo '<meta property="twitter:image" content="'.$image.'" />';
            }

            if ( $title ) {							
                echo '<title>'.$title.'</title>';
                echo '<meta property="og:title" content="'.$title.'" />';
                echo '<meta property="twitter:title" content="'.$title.'" />';
                echo '<meta property="og:site_name" content="'.$title.'" />';
            }

            if ( $desc ) {							
                echo '<meta name="description" content="'.$desc.'">';
                echo '<meta property="og:description" content="'.$desc.'" />';
                echo '<meta property="twitter:description" content="'.$desc.'" />';
            }

        }

        if (
            ( ! strpos( $_SERVER['HTTP_USER_AGENT'], 'linkedin' ) ) &&
            ( ! strpos( $_SERVER['HTTP_USER_AGENT'], 'search.google.com' ) ) &&
            ( ! strpos( $_SERVER['HTTP_USER_AGENT'], 'developers.google.com' ) ) &&
            ( ! strpos( $_SERVER['HTTP_USER_AGENT'], 'Google-AMPHTML' ) ) &&
            ( ! strpos( $_SERVER['HTTP_USER_AGENT'], '.facebook.com' ) ) &&
            $_SERVER['REMOTE_ADDR'] !== '108.174.2.200' &&
            $_SERVER['REMOTE_ADDR'] !== '66.249.81.90' &&
            $_SERVER['REMOTE_ADDR'] !== '31.13.97.116' &&
            ( ! isset( $_GET['debug'] ) )
        ) {
            echo '<meta http-equiv="refresh" content="0;url='.$url.'">';
        }

        ?>

        <style type="text/css">     
                body {background:#fff;font-family: arial,helvetica,lucida,verdana,sans-serif;margin:0;padding:0;}h1 {background:#f5f5f5;border-top:1px solid #eee;border-bottom:1px solid #eee;margin-top:10%;padding:50px;font-size:1.4em;font-weight:normal;text-align:center;color:#000;}
        </style>

    </head>

    <body>	
            <h1>contacting ...</h1>
    </body>

</html>																			