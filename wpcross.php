<?php
/*
Plugin Name: WCO Wpisy blogowe na karcie produktu (realizacje)
Description: Dodaje wpisy blogowe jako kafelki w WooCommerce.
Version: 1.1
Author: Antime
*/

// Dodaj pole dla produktu WooCommerce do wyboru wpisów blogowych
function custom_powiazane_realizacje_product_field()
{
    echo '<div class="options_group">';
    woocommerce_wp_text_input(array(
        'id' => 'powiazane_realizacje',
        'label' => __('ID Wpisów Blogowych', 'woocommerce'),
        'desc_tip' => 'Podaj ID wpisów blogowych oddzielone przecinkami.',
    ));

    echo '</div>';
}

add_action('woocommerce_product_options_related', 'custom_powiazane_realizacje_product_field');

// Zapisz ID wpisów blogowych do metadanych produktu
function custom_cross_powiazane_realizacje_product_field($post_id)
{
    $powiazane_realizacje_posts = sanitize_text_field($_POST['powiazane_realizacje']);
    update_post_meta($post_id, 'powiazane_realizacje', $powiazane_realizacje_posts);
}

add_action('woocommerce_process_product_meta', 'ustom_cross_powiazane_realizacje_product_field');



function show_realizacje()
{
    global $product; // Globalny obiekt produktu WooCommerce
    $product_id = $product->get_id(); // Pobierz ID produktu

    $powiazane_realizacje_posts = get_post_meta($product_id, 'powiazane_realizacje', true);
    $powiazane_realizacje_array = explode(',',  $powiazane_realizacje_posts);


    if (!empty($powiazane_realizacje_posts)) { ?>
        <!-- <div class="related bwp_slick-margin-mobile"> -->
        <!-- <div class="title-block"> -->
        <!-- <h2><?php //echo esc_html__('Nasze Realizacje', 'bumbleb'); 
                    ?></h2> -->
        <!-- </div> -->
        <div id="realizacja">
            <?php foreach ($powiazane_realizacje_array as $key => $postID) : ?>
                <?php
                 if (is_numeric($postID)) {
                    $title = get_the_title($postID);
                    $link = get_permalink($postID);
                    $thumbnail_url = get_the_post_thumbnail_url($postID, 'small');
                    if ($thumbnail_url) {
                        $image = $thumbnail_url;
                    } else {
                        $image = '';
                    }
                    ganarateTemplate($title, $link, $image);
                }
                ?>
            <?php endforeach; ?>
        </div>
        <style>

#realizacja{
    margin-top: 30px;
    display:flex;
    flex-direction:row;
    position: relative;
}

#realizacja:before{
    content:'Nasza realizacja';
    position: absolute;
    top:-21px;
    z-index: -1;
    left: 0px;
    padding:2px 5px;
    background-color: #f2a015;
    font-weight: 600;
}

        </style>
        <!-- </div> -->
<?php
    }
}



add_action('woocommerce_product_meta_end', 'show_realizacje', 20);


function ganarateTemplate($title, $link, $image)
{
    $template = '';

    $template .= '<div style="display: flex; align-items: center;user-select:none">
    <a href="' . $link . '">
    <img width="150px" style="padding:0.5rem"  src="' . $image . '"  alt="" decoding="async">
    <h3  style="font-size:1rem; margin:0 auto;">' . $title . '</a></h3>';
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
