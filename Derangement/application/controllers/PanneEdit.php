<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* VUE associée :  Panne folder...
 * MODEL associé : Panne_Model
 * REMARQUE : Les méthodes n'ont aucun paramètre. Les valeurs sont récupérées dans le paramètre $_POST lors de la requête.
 * AUTEUR : Marc Lapraz
 */

class PanneEdit extends Auth_Controller {

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
     * -CONTENT : None       
     */

    public function index() {
        // $data = $this->loadForm();
        // $this->loadRulesPanne();
        // $this->load->view('panne/index_view', $data, true);
        // $this->render('panne/index_view');
    }

    /* -NAME : function loadForm()
     * -PARAMETRE : Aucun
     * -ROLE : Méthode exécuté par défaut au chargement de la page
     * -CONTENT : 
     *          1.Appel function loadFoarm , retour dans variable $data
     *          2.Appel de la function loadRulesPanne (régles de saisie..)
     *          3.Passage de $data dans la vue
     *          4.Affichage de la vue. Maintenant $data est atteignable sur la vue
     */

    public function loadForm() {
        $regions = $this->Region_Model->getAllRegion();
        $horaires = $this->Horaire_Model->getAllHoraire();
        $typesPannes = $this->TypePanne_Model->getAllTypePanne();
        foreach ($regions as $region) {
            $regionFinal [$region->regionNumero] = $region->regionLibelle;
        }
        $data['AllRegions'] = array('regions' => $regionFinal);
        foreach ($horaires as $horaire) {
            $horaireFinal [$horaire->horaireNumero] = $horaire->horaireLibelle;
        }
        $data['AllHoraires'] = array('horaires' => $horaireFinal);
        foreach ($typesPannes as $typePanne) {
            $typesPannesFinal [$typePanne->typePanneNumero] = $typePanne->typePanneLibelle;
        }
        $data['AllTypesPannes'] = array('typesPannes' => $typesPannesFinal);
        return $data;
    }

    /* -------------------------------------------------------------------
     *  -NAME : function editPanne()
     * -PARAMETRE : PK panne
     * -ROLE : Modification d'une panne enregistré
     * -CONTENT : 
     *          1.Appel function loadFoarm , retour dans variable $data
     *          2.Appel de la function loadRulesPanne (régles de saisie..)
     *          3.Passage de $data dans la vue
     *          4.Affichage de la vue. Maintenant $data est atteignable sur la vue
     * ------------------------------------------------------------------------
     */

    public function editPanne($numero) {
        $data = $this->loadForm();
        $data['sql'] = $this->Panne_Model->getPanneByNumero($numero);
        $this->load->view('panne/edit_view', $data, true);
        $this->render('panne/edit_view');
    }

    /* -NAME : function updatePanne()
     * -PARAMETRE : Aucun
     * -ROLE : Méthode exécuté par défaut au chargement de la page
     * -CONTENT : 
     *          1.Appel function loadFoarm , retour dans variable $data
     *          2.Appel de la function loadRulesPanne (régles de saisie..)
     *          3.Passage de $data dans la vue
     *          4.Affichage de la vue. Maintenant $data est atteignable sur la vue
     */

    public function updatePanne() {
        $this->loadRulesPanne();
        if ($this->form_validation->run() === TRUE) {
            $numero = $this->input->post('numero');
            $date_declaration = $this->input->post('dateFrom');

            $dateMysql = new DateTime($date_declaration, new DateTimeZone('Europe/Amsterdam'));
            $description_panne = $this->input->post('description_panne');
            $infocomplementaire = $this->input->post('InfoComplementaire_panne');

            $tranche_horaire = $this->input->post('tranche_horaire');
            $installation = $this->input->post('installation');
            $type_panne = $this->input->post('type_panne');
            $data = array(
                'annonceur' => $this->session->userdata('username'),
                'stat' => 'en attente',
                'date_introduction_panne' => date("Y-m-d H:i:s"), //heure système de l'introduction de la panne. -> MySql format
                'date_declaration_panne' => $dateMysql->format("Y-m-d H:i:s"),
                'quitance' => 'non',
                'description' => $description_panne,
                'information_supp' => $infocomplementaire,
                'tranche_horaire' => $tranche_horaire,
                'installation' => $installation,
                'type_panne' => $type_panne
            );
            $this->Panne_Model->update($numero, $data);
            redirect('Dashboard');
        } else {
            $this->index();
        }
    }

    /* -NAME : function loadRulesPanne()
     * -PARAMETRE : Aucun
     * -ROLE : Méthode exécuté par défaut au chargement de la page
     * -CONTENT : 
     *          1.Appel function loadFoarm , retour dans variable $data
     *          2.Appel de la function loadRulesPanne (régles de saisie..)
     *          3.Passage de $data dans la vue
     *          4.Affichage de la vue. Maintenant $data est atteignable sur la vue
     */

    private function loadRulesPanne() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('dateFrom', 'date form', 'trim|required');
        $this->form_validation->set_rules('description_panne', 'decription', 'trim|required');
        $this->form_validation->set_rules('tranche_horaire', 'horaire', 'trim|required');
        $this->form_validation->set_rules('region', 'region', 'trim|required');
        $this->form_validation->set_rules('installation', 'installation', 'trim|required');
        $this->form_validation->set_rules('type_panne', 'type panne', 'trim|required');
    }

}
