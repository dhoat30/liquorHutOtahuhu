<?php

//gallery 

add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );
function mytheme_add_woocommerce_support(){
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 200,
        'gallery_thumbnail_image_width' => 100,
        'single_image_width' => 900
        ) );
}

//adding container on product archive page
add_action('add_filters', 'add_container', 1); 
function add_container($class){
echo '<div class="row-container container flex-row flex-space-between margin-row '.$class.'">';

}

//add closing div
add_action('woocommerce_after_main_content', 'add_container_closing_div'); 

function add_container_closing_div(){
echo '</div>';
}

function add_double_container_closing_div(){
    echo '</div></div>';
    }
    







//archive page title filter
//remove ordering 
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar' );


//add div container for breadcrumbs and image on single product
//
//gallery thumbnail size
add_filter( 'woocommerce_gallery_thumbnail_size', function( $size ) {
    return 'woocommerce_thumbnail';
    } );
add_action('breadcrumb_image_container', 'add_image_breadcrumb_container'); 
function add_image_breadcrumb_container(){
    if(is_single()){
        echo '<div class="img-container">';
    }
}

add_action('double_closing_div', 'add_double_container_closing_div' );
//add_action('woocommerce_single_product_summary', 'WC_Structured_Data::generate_product_data()', 7); 

//add short description 
add_action('double_closing_div', function(){
    global $post, $wp_query;
    $postID = $wp_query->post->ID;
    $product = wc_get_product( $postID );
    echo '<section class="bc-single-product__warranty desktop-warranty">' ; 
    echo $product->get_short_description();
    echo '</section>';

},1);
add_action('add_availability_share', function(){
    global $post, $wp_query;
    $postID = $wp_query->post->ID;
    $product = wc_get_product( $postID );
    echo '<section class="bc-single-product__warranty mobile-warranty">' ; 
    echo $product->get_short_description();
    echo '</section>';

},120);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
//wrapping container for gallery and product summary 
$class= 'img-summary-container'; 


    add_action('woocommerce_breadcrumb', function() { global $class ; 
        if(is_single()){
            add_container($class);
        }   
    }, 0);




//single product summary layout
//add description 
add_action('woocommerce_single_product_summary', function(){
    echo '<h3 class="product-description">'.get_the_content().'</h3>';
}, 7);

//add details 
add_action('woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 8); 

//remove woocommerce_data tab
//remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs');

function tutsplus_remove_product_long_desc( $tabs ) {
 
    unset( $tabs['description'] ); //remove description 
    $tabs['additional_information']['title'] = __( 'Details' ); //change name to Details
    return $tabs;
}

add_filter( 'woocommerce_product_tabs', 'tutsplus_remove_product_long_desc', 98 );

//remove dimensions in additional information 
add_filter( 'wc_product_enable_dimensions_display', '__return_false' );

//add label infront of quantity
add_action('woocommerce_before_quantity_input_field', function(){
    echo '<h6 class="qty-text roboto-font regular">Quantity:</h6>';
});

//remove meta-data 
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);


//remove tabs
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);



//closing div for product container

add_action('woocommerce_after_single_product_summary', 'add_container_closing_div');


//checkout 

add_action('woocommerce_checkout_before_order_review_heading', function(){
    echo '<div class="order-review-container">';
});
add_action('woocommerce_review_order_after_payment', 'add_container_closing_div');

