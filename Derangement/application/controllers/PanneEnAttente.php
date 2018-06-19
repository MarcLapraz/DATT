<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* VUE associée :  intervention/index_view.php
 * MODEL associé : Panne_Model
 * REMARQUE : Les méthodes n'ont aucun paramètre. Les valeurs sont récupérées dans le _POST lors de la requête.
 * AUTEUR : Marc Lapraz
 */

class PanneEnAttente extends Auth_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('ion_auth');
        //  if ($this->ion_auth->is_admin() === FALSE) {
        //    redirect('/');
        // }
    }

    /* ------------------------------------------------------------------------------
     * -NAME : function index()
     * -PARAMETRE : Aucun
     * -ROLE : Méthode exécuté par défaut au chargement de la page
     * -CONTENT : 
     *          1.Appel de la function viewWaitingPannes 
     * ------------------------------------------------------------------------------
     */

    public function index() {
        $this->viewWaitingPannes();
    }

    /* -----------------------------------------------------------------------------------
     *  -NAME : function viewWaitingPannes()
     * -PARAMETRE : Aucun
     * -ROLE : Retourne les panne en cours
     * -CONTENT : 
     *          1.Appel de la function getPanneEnCours (panne.status = encours) et retour dans le tableau $data à l'emplacement ['sql']
     *          2. Passage de $data dans la vue panneAttente_view
     *          3.Affichage de la vue
     * ----------------------------------------------------------------------------------
     */

    public function viewWaitingPannes() {
        $data['sql'] = $this->Panne_Model->getPanneEnCours();
        $this->load->view('panne/panneAttente_view', $data, true);
        $this->render('panne/panneAttente_view');
    }

    /* ---------------------------------------------------------------------------------
     *  -NAME : function ajax_Quitance()
     * -PARAMETRE : Aucun
     * -ROLE : Set de la quitance lors de la validation d'une panne par une technicien
     * -CONTENT : 
     *          1. Récupération du numero lors de la requête post
     *          2. Création d'un tableau 
     *          3. Appel de la function setQuitance avec le numero et le tableau en paramètre
     * --------------------------------------------------------------------------------------
     */

    public function ajax_Quitance() {
        $numero = $this->input->post('numero');
        $data = array(
            "quitance" => 'oui',
            "stat" => 'en cours',
            "intervention" => 'non',
            "fk_userQuitance" => $this->ion_auth->user()->row()->id
        );
        $this->Panne_Model->update($numero, $data);
    }

    /* ---------------------------------------------------------------------------------
     *  -NAME : function ajax_Quitance()
     * -PARAMETRE : Aucun
     * -ROLE : Set de la quitance lors de la validation d'une panne par une technicien
     * -CONTENT : 
     *          1. Récupération du numero lors de la requête post
     *          2. Création d'un tableau 
     *          3. Appel de la function setQuitance avec le numero et le tableau en paramètre
     * --------------------------------------------------------------------------------------
     */

    public function ajax_Charge() {
        $numero = $this->input->post('numero');
        $data = array(
            "fk_userCharge" => $this->ion_auth->user()->row()->id
        );
        $this->Panne_Model->update($numero, $data);
    }

    /* ---------------------------------------------------------------------------------
     *  -NAME : function ajax_Quitance()
     * -PARAMETRE : Aucun
     * -ROLE : Set de la quitance lors de la validation d'une panne par une technicien
     * -CONTENT : 
     *          1. Récupération du numero lors de la requête post
     *          2. Création d'un tableau 
     *          3. Appel de la function setQuitance avec le numero et le tableau en paramètre
     * --------------------------------------------------------------------------------------
     */

    public function ajax_Decharge() {
        $numero = $this->input->post('numero');
        $data = array(
            "fk_userCharge" => null
        );

        $this->Panne_Model->update($numero, $data);
    }

}
