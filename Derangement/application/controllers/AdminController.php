<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AdminController extends Auth_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
    }

    public function index() {
        $this->load->views('testAdmin');
    }
}
