<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Convert extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{   
            $data['output'] = "";
            $data['withcomma'] = "";
            $this->load->view('vconvert',$data);
            
	}
        
        public function go(){
            $this->form_validation->set_rules('num_input','Input Number','trim|required|callback_validate_inputs');
             
            $num = str_replace(',','',$this->input->post('num_input'));
                /* remove commas*/
           
            if ($this->form_validation->run() == FALSE) {
                $data['output'] = "";
                $data['withcomma'] = "";
                $this->load->view('vconvert',$data);
            } else {
                 
                if(!empty($num)){
                    if ($this->input->post('convert')){
                        $data['output'] = $this->convert_to_words($num);
                        $data['withcomma'] = "";
                    }
                    if ($this->input->post('comma')){
                        $data['withcomma'] = number_format($num);
                        $data['output'] = "";
                    }
                }else if($num=="0"){
                    $data['output'] = "zero";
                }else{
                    $data['output'] = "";
                    $data['withcomma'] = "";
                }

                $this->load->view('vconvert', $data);
            }
        }
        
        public function validate_inputs($num_input){
            //if (($num_input < 0) || ($num_input > 999999999999999)) {
            //    $this->form_validation->set_message('validate_inputs', 'Invalid input.');
            //    return false;	
           // }
            //else if (!is_numeric($num_input)) {
             //   $this->form_validation->set_message('validate_inputs', 'Invalid input, not numeric.');
             //   return false;	
            //}
            //else{
                return true;
            //}
                
        }
        
        public function convert_to_words($number){
            
                $Tr = floor($number / 1000000000000);
		// Trillions  
                $number = $number - ($Tr * 1000000000000);
                $B = floor($number / 1000000000);                
		/// Billions    
                $number = $number -($B * 1000000000); 
		$M = floor($number / 1000000);
		// Millions  
		$number = $number- ($M * 1000000);
		$Th = floor($number / 1000);
		// Thousands  
		$number = $number -($Th * 1000);
		$Hn = floor($number / 100);
		/// Hundreds 
		$number = $number-($Hn * 100);
		$Tns = floor($number / 10);
		// Tens  
		$ons = $number % 10;
		// Ones 
		$output = "";
                if ($Tr) {
			$output .= $this->convert_to_words($Tr) .  " Trillion";
		}
                if ($B) {
			$output .= $this->convert_to_words($B) .  " Billion";
		}
		if ($M) {
			$output .= $this->convert_to_words($M) .  " Million";
		}
		if ($Th) {
			$output .= (empty($output) ? "" : " ") .$this->convert_to_words($Th) . " Thousand";
		}
		if ($Hn) {
			$output .= (empty($output) ? "" : " ") .$this->convert_to_words($Hn) . " Hundred";
		}
		$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
		$tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
		if ($Tns || $ons) {
                    if ($Tns < 2) {
                        $output .= " ".$ones[$Tns * 10 + $ons] ;
                    } else {
                        $output .= " ".$tens[$Tns] ;
                        if ($ons) {
                            $output .= "-" . $ones[$ons];
                        }
                    }
		}
		if (empty($output)) {
                    $output = "zero";
		}
                if ($ons[0]){
                    $output = "zero";
                }
		return $output;
            
        }
        
       
}
