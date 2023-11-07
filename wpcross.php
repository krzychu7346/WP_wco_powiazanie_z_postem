<?php
/*
Plugin Name: Custom Cross-Selling
Description: Dodaje wpisy blogowe jako kafelki w WooCommerce.
Version: 1.0
Author: Antime
*/


// Dodaj pole dla produktu WooCommerce do wyboru wpisów blogowych
function custom_cross_selling_product_field()
{
    echo '<div class="options_group">';
    woocommerce_wp_text_input(array(
        'id' => 'powiazane_realizacje',
        'label' => __('ID Wpisów Blogowych', 'woocommerce'),
        'desc_tip' => 'Podaj ID wpisów blogowych oddzielone przecinkami.',
    ));
    
    echo '</div>';
}

add_action('woocommerce_product_options_related', 'custom_cross_selling_product_field');

// Zapisz ID wpisów blogowych do metadanych produktu
function custom_cross_selling_save_product_field($post_id)
{
    $cross_selling_posts = sanitize_text_field($_POST['powiazane_realizacje']);
    update_post_meta($post_id, 'powiazane_realizacje', $cross_selling_posts);
}

add_action('woocommerce_process_product_meta', 'custom_cross_selling_save_product_field');



function testt()
{
    global $product; // Globalny obiekt produktu WooCommerce
    $product_id = $product->get_id(); // Pobierz ID produktu

    $cross_selling_posts = get_post_meta($product_id, 'powiazane_realizacje', true);
    $cross_selling_array = explode(',',  $cross_selling_posts);


    if (!empty($cross_selling_posts)) { ?>
        <div class="related bwp_slick-margin-mobile">
            <div class="title-block">
                <!-- <h2><?php //echo esc_html__('Nasze Realizacje', 'bumbleb'); ?></h2> -->
            </div>
            <div class="content-product-list" style="display:flex;flex-direction:row">

                    <?php foreach ($cross_selling_array as $key => $postID) : ?>
                        <?php //echo "Klucz" . $key . " Wartość: " . $postID; ?><br>

                        
                        <?php




                        if (is_numeric($postID)) {
                            $title = get_the_title($postID);
                            $link = get_permalink($postID);
                            $thumbnail_url = get_the_post_thumbnail_url($postID, 'small');
                            if ($thumbnail_url) {
                                $image = $thumbnail_url;
                            }else {
                                $image = '';
                            }
                           // echo  $title . " ".   $link . "<br>";
                            moj_wlasny_modul($title, $link, $image );
                        }


                        // var_dump( $cross_selling_array);
                        // var_dump($key);
                        // var_dump($upsell);
                        // $title = get_the_title($post_id);
                        // $post_object = get_post( $postID->get_id() );
                        //setup_postdata( $GLOBALS['post'] =& $post_object );
                        //wc_get_template_part( 'content-grid', 'product' );
                        // $post_object = get_post($postID->get_id());
                        // if ($post_object) {
                        //     $GLOBALS['post'] = $post_object;
                        //     setup_postdata($post_object);

                        //     wp_reset_postdata();  // Dobrze jest zresetować dane posta po użyciu setup_postdata
                        // }
                        // $post_object = get_post($postID);
                        // $post_object->ID=3976;
                        //$post_object->post_title="lllll";

                        // var_dump($GLOBALS['post']);
                        // if ($post_object) {

                        //     //$GLOBALS['post'] = $post_object;

                        //     // setup_postdata($post_object);
                        // }
                        // wc_get_template_part('content-grid', 'product');

                        ?>
                    <?php endforeach; ?>
                    </div>
                </div>
   

<?php
    }
}

add_action('woocommerce_product_meta_end', 'testt', 20);



function addContact(){
    echo '<i class="fa fa-twitter"></i>';
}

add_action('woocommerce_share', 'addContact', 10);



function moj_wlasny_modul($title, $link, $image ) {
    $template = '';

    $template .= '<div style="display: flex; align-items: center;">
    <img width="100px" style="padding:0.5rem"  src="'. $image . '"  alt="" decoding="async">
    <h3  style="font-size:1rem; margin:0 auto;"><a href="'. $link .'" tabindex="0">'. $title .'</a></h3>';
    $template .= '</div>';

    // $template .= '<div class="products-list grid">
    //                 <div class="products-entry content-product1 clearfix product-wapper" style="width: 345px;">
    //                     <div class="products-thumb">
    //                         <div class="product-thumb-hover">
    //                         <a href="'. $link . '" class="woocommerce-LoopProduct-link" tabindex="0">
    //                         <img width="300" height="180" src="'. $image . '" class="fade-in wp-post-image ls-is-cached lazyloaded" alt="" decoding="async">
    //                         <img width="300" height="180" src="'. $image . '" class="hover-image back" alt="" decoding="async">
    //                         </a>     
    //                         </div>  
    //                     </div>

    //                     <div class="products-content">
    //                         <div class="contents">
    //                             <div class="cat-products">
    //                                 <a href="" tabindex="0">Realizacje</a>
    //                             </div>
    //                                 <h3 class="product-title"><a href="'. $link .'" tabindex="0">'. $title .'</a></h3>

    //                             <div class="woo-price">
    //                                 <div class="btn-atc">
    //                                     <div data-title="Dowiedz się więcej"><a rel="nofollow" href="'. $link .'">Dowiedz się więcej</a></div>
    //                                 </div>
    //                             </div>

    //                         </div>
    //                     </div>
    //                 </div>
    //             </div>';

    echo $template;
}



