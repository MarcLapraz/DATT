<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Contact extends Auth_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('ion_auth');
        if (!$this->ion_auth->in_group('admin')||!$this->ion_auth->in_group('members') ) {
            redirect('/');
        }
    }

     /*DESCRIPTION : Function exécutée par défaut
     * PARAM : none
     */
    public function index() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('mail', 'mail', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->load->helper('form');
            $this->render('contact');
        } else {
            $mail = $this->input->post('mail');
            $this->sendMail($mail);
            redirect('user/login');
        }
    }
    
    /*DESCRIPTION : Envoi d'un mail
     * PARAM : Contenu du mail
     */
     private function sendMail($mailBody) {
        //en-tête de mail
        $filename = 'assets/images/logo.png';
        //loader les fichiers de configuration
        $this->config->load('email');
        $conf = $this->config->item('email_conf');
        $this->load->library('email', $conf);
        $this->email->set_newline("\r\n");
        $this->load->library('email');

        $this->email->from('marc.lapraz@transn.ch', 'Marc.Lapraz');
        $this->email->subject('Support Application');
        $this->email->attach($filename);
        $this->email->to('marc.lapraz@transn.ch');

        $cid = $this->email->attachment_cid($filename);

        $message = '<div><img src="cid:' . $cid . '" alt="photo1"/></div>';
        $message .=  $mailBody  ;

        //array à passer au template email
        $data = array(
            'userName' =>  $this->session->userdata('username'),
            'email' => $this->session->userdata ('email'),
            'message' => $message
        );
        $body = $this->load->view('email/template.php', $data, TRUE);
        $this->email->message($body);
        $this->email->set_crlf( "\r\n" );
        $result = $this->email->send();
    }
}
