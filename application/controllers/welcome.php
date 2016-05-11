<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->library('recaptcha');
		 //Store the captcha HTML for correct MVC pattern use.
        $data['recaptcha_html'] = $this->recaptcha->get_recaptcha_html();

        if(isset($this->input->post('g-recaptcha-response')))
        {
			$this->recaptcha->check_recaptcha_response();
			if( ! $this->recaptcha->get_recaptcha_response()) 
			{
				echo $msg = 'Recaptcha Failed:' . $this->recaptcha->get_recaptcha_error();
				
			}
			else
			{
				echo $msg = 'Recaptcha Passed:';
			}
        }
		$this->load->view('welcome_message',$data);
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */