<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* VUE associée :  intervention/index_view.php
 * MODEL associé : Intervention_Model
 * REMARQUE : Les méthodes n'ont aucun paramètre. Les valeurs sont récupérées dans le _POST lors de la requête.
 * AUTEUR : Marc Lapraz
 */

class Recherche extends Auth_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('ion_auth');
        //  if ($this->ion_auth->is_admin() === FALSE) {
        //    redirect('/');
        // }
    }

    /* -NAME : function index()
     * -PARAMETRE : Aucun
     * -ROLE : Méthode exécuté par défaut au chargement de la page
     * -CONTENT : 
     *          1.Appel function loadFoarm , retour dans variable $data
     *          2.Appel de la function loadRulesPanne (régles de saisie..)
     *          3.Passage de $data dans la vue
     *          4.Affichage de la vue. Maintenant $data est atteignable sur la vue
     */

    public function index() {

        $typesPannes = $this->TypePanne_Model->getAllTypePanne();
        foreach ($typesPannes as $typePanne) {
            $typesPannesFinal [$typePanne->typePanneNumero] = $typePanne->typePanneLibelle;
        }
        $data['AllTypesPannes'] = array('typesPannes' => $typesPannesFinal);

        $installations = $this->Installation_Model->getAllInstallation();
        foreach ($installations as $installation) {
            $installationFinal [$installation->installationNumero] = $installation->installationLibelle;
        }
        $data['AllInstallations'] = array('installations' => $installationFinal);
        $this->load->view('recherche/index_view', $data, true);
        $this->render('recherche/index_view');
    }

    /* -NAME : function index()
     * -PARAMETRE : Aucun
     * -ROLE : Méthode exécuté par défaut au chargement de la page
     * -CONTENT : 
     *          1.Appel function loadFoarm , retour dans variable $data
     *          2.Appel de la function loadRulesPanne (régles de saisie..)
     *          3.Passage de $data dans la vue
     *          4.Affichage de la vue. Maintenant $data est atteignable sur la vue
     */

    public function ajax_recherche() {

        $installation = $this->input->post('installation');
        $install = $this->Recherche_Model->ajaxGetInfosInstallation($installation);
        header('Content-Type: application/json');
        echo json_encode($install);
    }

    /* -NAME : function index()
     * -PARAMETRE : Aucun
     * -ROLE : Méthode exécuté par défaut au chargement de la page
     * -CONTENT : 
     *          1.Appel function loadFoarm , retour dans variable $data
     *          2.Appel de la function loadRulesPanne (régles de saisie..)
     *          3.Passage de $data dans la vue
     *          4.Affichage de la vue. Maintenant $data est atteignable sur la vue
     */

    public function ajax_getPanneByNumero() {

        $numero = $this->input->post('installation');
        $panne = $this->Recherche_Model->ajaxGetPanneByNumeroInstallation($numero);
        header('Content-Type: application/json');
        echo json_encode($panne);
    }

    /* -NAME : function index()
     * -PARAMETRE : Aucun
     * -ROLE : Méthode exécuté par défaut au chargement de la page
     * -CONTENT : 
     *          1.Appel function loadFoarm , retour dans variable $data
     *          2.Appel de la function loadRulesPanne (régles de saisie..)
     *          3.Passage de $data dans la vue
     *          4.Affichage de la vue. Maintenant $data est atteignable sur la vue
     */

    public function ajaxGetDetailIntervention() {

        $panneNumero = $this->input->post('pk');
        $panne = $this->Recherche_Model->ajaxGetDetailIntervention($panneNumero);
        header('Content-Type: application/json');
        echo json_encode($panne);
    }

    /* -NAME : function index()
     * -PARAMETRE : Aucun
     * -ROLE : Méthode exécuté par défaut au chargement de la page
     * -CONTENT : 
     *          1.Appel function loadFoarm , retour dans variable $data
     *          2.Appel de la function loadRulesPanne (régles de saisie..)
     *          3.Passage de $data dans la vue
     *          4.Affichage de la vue. Maintenant $data est atteignable sur la vue
     */

    public function ajaxGetDetailDetails() {

        $num = $this->input->post('numero');
        $detail = $this->Recherche_Model->ajaxGetDetailDetails($num);
        header('Content-Type: application/json');
        echo json_encode($detail);
    }

}
