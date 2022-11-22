<?php if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class AccessControl {

  private $CI;

	public function __construct() {
		$this->CI =& get_instance();
	}

  public function checkAuth ($isAjax = false) {

    if (!$isAjax || ($isAjax && $this->CI->input->is_ajax_request())){
      if (isset($_SESSION['email']) && isset($_SESSION['full_name'])){
          return array('correct' => true);
      } else {
        return array('correct' => false, 'err' => 'NO_LOGGED');
      }
    } else {
      return array('correct' => false, 'err' => 'AJAX_REQUEST');
    }
  }

}
