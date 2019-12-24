<?php

// Adding the Open Graph in the Language Attributes
function add_opengraph_doctype($output)
{
    return $output . '
    xmlns="https://www.w3.org/1999/xhtml"
    xmlns:og="https://ogp.me/ns"
    xmlns:fb="http://www.facebook.com/2008/fbml"';
}

add_filter('language_attributes', 'add_opengraph_doctype');

// Add Open Graph Meta Info from the actual article data, or customize as necessary
function facebook_open_graph()
{
    global $post;

    if (!is_singular()) { // if it is not a post or a page
        return;
    }

    if ($excerpt = $post->post_excerpt) {
        $excerpt = strip_tags($post->post_excerpt);
        $excerpt = str_replace("", "'", $excerpt);
    } else {
        $excerpt = get_bloginfo('description');
    }
    
    if (!has_post_thumbnail($post->ID)) { //the post does not have featured image, use a default image
        //Create a default image on your server or an image in your media library, and insert it's URL here
        $default_image="https://bienauquotidien.com/wp-content/uploads/2019/05/logo-blog.png";
        echo '<meta property="og:image" content="' . $default_image . '"/>';
    } else {
        $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium');
        echo '<meta property="og:image" content="' . esc_attr($thumbnail_src[0]) . '"/>';
    }

    //You'll need to find your Facebook profile Id and add it as the admin
    echo '<meta property="fb:admins" content="100037003066917"/>';
    echo '<meta property="og:title" content="' . get_the_title() . '"/>';
    echo '<meta property="og:description" content="' . $excerpt . '"/>';
    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:url" content="' . get_permalink() . '"/>';

    //Let's also add some Twitter related meta data
    echo '<meta name="twitter:card" content="summary" />';
    //This is the site Twitter @username to be used at the footer of the card
    echo '<meta name="twitter:site" content="@site_user_name" />';
    //This the Twitter @username which is the creator / author of the article
    echo '<meta name="twitter:creator" content="@username_author" />';
    // Customize the below with the name of your site
    echo '<meta property="og:site_name" content="Être bien, vivre bien au quotidien"/>';
    echo "";
}

add_action('wp_head', 'facebook_open_graph', 0);
