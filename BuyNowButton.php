<?php
/*
Plugin Name: Buy Now Button
Plugin URI: https://www.royaltechbd.com/
Description: A simple plugin to add Buy Now Button to WooCommerce Store.
Author: S. M. Mehdi Akram
Version: 1.0.1
Author URI: https://www.royaltechbd.com/
*/


//Load functions file
add_action('woocommerce_after_add_to_cart_button', 'add_buy_now_button');
function add_buy_now_button() {
    global $product;
?>
    <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button button alt" id="buy_now_button">
    <?php echo esc_html('Buy Now'); ?>
    </button>
    <input type="hidden" name="is_buy_now" id="is_buy_now" value="0" />
<?
}


function buy_now_submit_form(){
    ?>
  <script>
      jQuery(document).ready(function(){

          //By default buy now is 0
          jQuery('#is_buy_now') . val('0');

          // listen if someone clicks 'Buy Now' button
          jQuery('#buy_now_button').click(function(){
              // set value to 1
              jQuery('#is_buy_now').val('1');
              //submit the form
              jQuery('form.cart').submit();
          });
      });
  </script>
 <?php
}
add_action('woocommerce_after_add_to_cart_form', 'buy_now_submit_form');

add_filter('woocommerce_add_to_cart_redirect', 'redirect_to_checkout');
function redirect_to_checkout($redirect_url)
{
    if (isset($_POST['is_buy_now']) && $_POST['is_buy_now']) {
        global $woocommerce;
        $redirect_url = wc_get_checkout_url();
    }
    return $redirect_url;
}
