<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Required files from the third_party directory.
require_once(APPPATH . 'third_party/google_recaptcha/autoload.php');

class Recaptcha { 

    protected $is_valid     = FALSE;
    protected $error        = ''; 
    protected $site_key     = ''; 
    protected $secret_key   = ''; 
    protected $options      = array();
    
    /**
     * Constructor
     */
    public function __construct()
    {
        log_message('debug', "RECAPTCHA Class Initialized.");
        
        $this->CI =& get_instance();
        
        //Load the CI Config file for recaptcha
        $this->CI->load->config('recaptcha');
        //load in the values from the config file. 
        $this->site_key     = $this->CI->config->item('site_key');
        $this->secret_key   = $this->CI->config->item('secret_key');
        $this->options      = $this->CI->config->item('recaptcha_options');  
    }

    /** 
     * get_recaptcha_html  
     * Default Method to display recaptcha insite a form
     * 
     * @access public 
     * @param  
     * @return   
     */
    public function get_recaptcha_html()
    {  
        if(empty($this->site_key) OR empty($this->secret_key))
        {
            die("To use reCAPTCHA you must get an API key from <a href='https://www.google.com/recaptcha/admin/create'>https://www.google.com/recaptcha/admin/create</a>");
        }

        $options = "";
        foreach($this->options as $key => $value)
        {
            $options .= $key.':"'.$value.'", ';
        }

        $recaptcha_html = '
        <script type="text/javascript"> var RecaptchaOptions = { '.$options.' }; </script>
        <!-- https://www.google.com/recaptcha -->
        <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl='.$this->options['lang'].'"></script>
        <div class="g-recaptcha" data-sitekey="'.$this->site_key.'"></div>';
        return $recaptcha_html;
    } 

    /** 
     * check_recaptcha_response  
     * Default Method to check recaptcha response 
     * 
     * @access public 
     * @param  
     * @return   
     */
    public function check_recaptcha_response()
    {  
        $recaptcha_response = $this->CI->input->post('g-recaptcha-response'); 
        if($recaptcha_response)
        { 
            // Create an instance of the service using your secret

            //$recaptcha = new \ReCaptcha\ReCaptcha($this->secret_key);
            $recaptcha = new \ReCaptcha\ReCaptcha($this->secret_key, new \ReCaptcha\RequestMethod\CurlPost());

            // If file_get_contents() is locked down on your PHP installation to disallow
            // its use with URLs, then you can use the alternative request method instead.
            // This makes use of fsockopen() instead.
            // $recaptcha = new \ReCaptcha\ReCaptcha($secret, new \ReCaptcha\RequestMethod\SocketPost());

            // Make the call to verify the response and also pass the user's IP address
            $resp = $recaptcha->verify($recaptcha_response, $this->CI->input->ip_address());

            if($resp->isSuccess())
            { 
                $this->is_valid = TRUE;
            }
            else
            {
                $this->is_valid = FALSE;
                // If it's not successful, then one or more error codes will be returned.
                $recaptcha_error_codes = '<p>Something went wrong!! The following error was returned:</p>'; 
                $recaptcha_error_codes .= '<ul>';
                foreach ($resp->getErrorCodes() as $code)
                {
                    $recaptcha_error_codes .= '<li>' . $code . '</li>';
                }
                $recaptcha_error_codes .= '</ul>';  
                $recaptcha_error_codes .= '
                    <p>Check the error code reference at <a href="https://developers.google.com/recaptcha/docs/verify#error-code-reference">https://developers.google.com/recaptcha/docs/verify#error-code-reference</a></p>
                    <p><strong>Note:</strong> Error code <b>missing-input-response</b> may mean the user just did not complete the reCAPTCHA.</p>';  
                $this->error = $recaptcha_error_codes; 
            }
        } // Google ReCaptcha is pressed
        else
        {
            $this->is_valid = FALSE;
            $this->error    = 'Please complete the Google reCAPTCHA and then submit the contact form.';
        }
    } 

    /** 
     * get_recaptcha_response  
     * Default Method to check recaptcha response 
     * 
     * @access public 
     * @param  
     * @return   
     */
    public function get_recaptcha_response()
    {
        return $this->is_valid;
    }

    /** 
     * get_recaptcha_error  
     * Default Method to get the recaptcha error 
     * 
     * @access public 
     * @param  
     * @return   
     */
    public function get_recaptcha_error()
    {
        return $this->error;
    }
}