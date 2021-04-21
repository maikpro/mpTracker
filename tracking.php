<?php
/**Set Cookies*/
// Set cookie for new users
add_action( 'init', 'set_newuser_cookie'); // Run when WordPress loads
function set_newuser_cookie() {
    $cookieTimer = intval( esc_attr( get_option('cookieTimer') ) );
    $ref = $_SERVER["HTTP_REFERER"]; // Get URL the user came to your site for
	if ( !isset($_COOKIE['origin'])) { // If not an admin or if cookie doesn't exist already
        setcookie( 'origin', $ref, time()+(60*$cookieTimer), COOKIEPATH, COOKIE_DOMAIN, false); // Set cookie for 30 days
	} else{
        $cookie_ref = $_COOKIE['origin'];
        $newRef = $cookie_ref . " | " . $ref;
        setcookie( 'origin', $newRef, time()+(60*$cookieTimer), COOKIEPATH, COOKIE_DOMAIN, false);
    }
}

function createArray($string){
    //$cookie_ref = $_COOKIE['origin'];
    $teile = explode(" | ", $string);
    return $teile;
}

function getUrlsToMark(){
    $counter = esc_attr( get_option("trackerCounter") );
    $arr=array();
    for ($i = 1; $i <= $counter; $i++) {
        $urlTracker = esc_attr( get_option('trackerUrl_'. $i)  );
        array_push($arr, $urlTracker);
    }
    return $arr;
}

function filter_Referrer($arr){
    $filtered_arr = array_filter ($arr, 'mpFilter');
    return $filtered_arr;
}

function mpFilter($var){
    return !strpos($var, "wp-admin") && !strpos($var, "haftung");
}

/*add_action( 'wp_footer', 'mp_testing' );
function mp_testing(){
    if( isset($_COOKIE['origin']) ){
        $cookie_ref = $_COOKIE['origin'];
        $teile = createArray($cookie_ref);
        //print_r($teile);
        $cookieTimer = intval( esc_attr( get_option('cookieTimer') ) );
        var_dump($cookieTimer);

        $urlTracker = esc_attr( get_option('trackerUrl') );
        var_dump($urlTracker);
    }

    var_dump(getUrlsToMark());
}*/


add_action('woocommerce_checkout_fields', 'set_Referrer');
function set_Referrer( $fields ) {
    $fields['billing']['billing_referrer'] = array(
        'type'      => 'text',
        'label'     => __('Referrer', 'woocommerce'),
        'required'  => false,
        'class'     => array('form-row-wide mp-checkout-field'),
        'clear'     => true
    );
    $cookie_ref = $_COOKIE['origin'];
    $fields['billing']['billing_referrer']['default'] = $cookie_ref;
    $fields['billing']['billing_referrer']['custom_attributes'] = array('readonly'=>'readonly');
    return $fields;
}


//Anzeige Vor- & Nachname ... später in der Bestellung
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'checkout_referrer', 10, 1 );
function checkout_referrer($order){
    $billing_ref = get_post_meta( $order->get_id(), '_billing_referrer', true );
    $arr = createArray($billing_ref);
    $filtered_arr = filter_Referrer($arr);

    $colorTracker = esc_attr( get_option('trackerColor') );
    $urlTracker = esc_attr( get_option('trackerUrl') );
    echo '<p><strong>'.__('Referrer').':</strong> <br></p>';
    foreach ($filtered_arr as &$value){
        //if( strpos($value, $urlTracker) ){
        if(in_array($value, getUrlsToMark(), false)){
            echo "<p><span style='color:" . $colorTracker . ";'>" . $value  . '</span></p>';
        } else{
            echo "<p>" . $value  . '</p>';
        }
    }
}