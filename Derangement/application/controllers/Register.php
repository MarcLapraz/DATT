<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* VUE associée :  intervention/index_view.php
 * MODEL associé : Intervention_Model
 * REMARQUE : Les méthodes n'ont aucun paramètre. Les valeurs sont récupérées dans le _POST lors de la requête.
 * AUTEUR : Marc Lapraz
 */

class Register extends Auth_Controller {

    //Constructeur
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('ion_auth');
        if ($this->ion_auth->is_admin() === FALSE) {
            redirect('/');
        }
    }

    /* -NAME : function index()
     * -PARAMETRE : Aucun
     * -ROLE : Méthode exécuté par défaut au chargement de la page permettant d'enregister un nouvel utilisateur
     * -CONTENT : 
     *          1. Chargement des règles de validation
     *          2. Si les règles de validation sont ok
     *              2.1 Chargement du helper form
     *              2.2 Affichage de la vue register 
     *          3. Sinon
     *              3.1 récupération de valeurs post (username, email, phone, password)
     *              3.2 Chargement de la librairie Ion:auth
     *                  3.2.1 Si Resgister retourne vraie 
     *                      3.2.1.1 Le compte est crée
     *                      3.2.1.2 Ajout param dans la session de l'utilisateur
     *                      3.2.1.3 Redirection
     *                  3.2.2 Sinon erreur
     *                      3.2.2.1 load error
     *                      3.2.2.2 Redirection    
     */

    public function index() {
        $this->loadRules();
        if ($this->form_validation->run() === FALSE) {
            $this->load->helper('form');
            $this->render('register/index_view');
        } else {
            // $first_name = $this->input->post('first_name');
            // $last_name = $this->input->post('last_name');
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            $password = $this->input->post('password');
            $additional_data = array(
                'phone' => $phone
            );
            $this->load->library('ion_auth');
            if ($this->ion_auth->register($username, $password, $email, $additional_data)) {
                $_SESSION['auth_message'] = 'Le compte est crée.';
                $this->session->mark_as_flash('auth_message');
                redirect('user/login');
            } else {
                $_SESSION['auth_message'] = $this->ion_auth->errors();
                $this->session->mark_as_flash('auth_message');
                redirect('register');
            }
        }
    }

    
    /* -NAME : function loadRules()
     * -PARAMETRE : Aucun
     * -ROLE : Création des règles de validation 
     * -CONTENT : 
     *          1.Chargement de la librairie form_validation
     *          2. Création d'un container div pour l'affichage des erreurs de validation
     *         3. username -> obligatoire, unique, sans espace
     *            email -> format email p.ex coucou@coucou.ch sans espace
     *            phone -> pas d'espace
     *            password -> long. min 8 caractères max 20 caractères sans espace
     *            confirm_password -> doit correspondre à password 
     */

    private function loadRules() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
        $this->form_validation->set_rules('phone', 'phone', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|min_length[8]|max_length[20]|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|matches[password]|required');
    }

}
