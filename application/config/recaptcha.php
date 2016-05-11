<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * reCaptcha File Config
 *
 * File     : recaptcha.php
 * Created  : https://github.com/google/recaptcha
 * 
 * Author   : https://github.com/qaziumar/CI-Google-reCAPTCHA
 */

/*
|--------------------------------------------------------------------------
| Site key
|--------------------------------------------------------------------------
|
| Use this in the HTML code your site serves to users. 
|
*/ 
$config['site_key']   = 'YOUR_SITE_KEY';


/*
|--------------------------------------------------------------------------
| Secret key
|--------------------------------------------------------------------------
|
| Use this for communication between your site and Google. Be sure to keep it a secret.
|
| https://www.google.com/recaptcha/admin#site/320642516?setup
| 
|
*/ 

$config['secret_key']  = 'YOUR_SECRET_KEY';

/*
|--------------------------------------------------------------------------
| Set Recaptcha options
|--------------------------------------------------------------------------
|
| Set Recaptcha options
|
| Reference at https://developers.google.com/recaptcha/docs/customization
| 
|
*/  
$config['recaptcha_options']  = array(
    'theme'=>'red', // red/white/blackglass/clean
    'lang' => 'en' // en/nl/fl/de/pt/ru/es/tr
    //  'custom_translations' - Use this to specify custom translations of reCAPTCHA strings.
    //  'custom_theme_widget' - When using custom theming, this is a div element which contains the widget. See the custom theming section for how to use this.
    //  'tabindex' - Sets a tabindex for the reCAPTCHA text box. If other elements in the form use a tabindex, this should be set so that navigation is easier for the user
); 