<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function loadMenu()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('admin/header');
            $this->load->view('admin/menu');
            $this->load->view('admin/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }
}
