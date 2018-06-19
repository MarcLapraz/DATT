<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* VUE associée :  intervention/index_view.php
 * MODEL associé : Ion_Auth 
 * REMARQUE : Les méthodes n'ont aucun paramètre. Les valeurs sont récupérées dans le _POST lors de la requête.
 *            Ion_Auth simplifie la gestion des utilisateurs et des comptes
 * AUTEUR : Marc Lapraz
 */

class User extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
    }

    /* -NAME : function index()
     * -PARAMETRE : Aucun
     * -ROLE : fonction exécutée par défaut lors de l'appel au controller
     * -CONTENT : 
     *          1.Chargement de la vue welcome_message
     */

    public function index() {
        $this->load->view('welcome_message');
    }

    /* -NAME : function login()
     * -PARAMETRE : Aucun
     * -ROLE : fonction exécutée par défaut lors de l'appel au controller
     * -CONTENT : 
     *          1. Passage du titre de la page dans data à l'emplacement title
     *          2. Chargement de la library form_validation
     *          3. Création des régles de validation. unsername est obligatoire suppresion des espaces, password est obligatoire
     *          4. SI les régles de validation sont correctes
     *              4.1. Chargement du helper form
     *              4.2  Chargement de la vue
     */

    public function login() {
        $this->data['title'] = "Login";
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->load->helper('form');
            $this->render('user/login_view');
        } else {
            $remember = (bool) $this->input->post('remember');
            if ($this->ion_auth->login($this->input->post('username'), $this->input->post('password'), $remember)) {
                redirect('dashboard');
            } else {
                $_SESSION['auth_message'] = $this->ion_auth->errors();
                $this->session->mark_as_flash('auth_message');
                redirect('user/login');
            }
        }
    }

    /* -NAME : function logout()
     * -PARAMETRE : Aucun
     * -ROLE : Déconnexion de l'utilisateur courant
     * -CONTENT : 
     *          1.Appel de la method logout
     *          2.redirection sur la page login
     */

    public function logout() {
        $this->ion_auth->logout();
        redirect('user/login');
    }

}
