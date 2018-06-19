<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* VUE associée :  Panne folder...
 * MODEL associé : Panne_Model
 * REMARQUE : Les méthodes n'ont aucun paramètre. Les valeurs sont récupérées dans le paramètre $_POST lors de la requête.
 * AUTEUR : Marc Lapraz
 */

// La classe panne étant Auth_Controller afin de pouvoir utiliser la classe Auth_Controller ici.
class GPS extends Auth_Controller {

    function __construct() {
        parent::__construct();
        // $this->load->helper('url');
        // $this->load->library('ion_auth');
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
        //  $data = $this->loadForm();
        //  $this->loadRulesPanne();
        //  $this->load->view('GPS/carte', true);
        $this->render('GPS/carte');
    }

    public function getClosestMachine() {

        $longitude = $this->input->post('longitude');
        $latitude = $this->input->post('latitude');
        $result = $this->GPS_Model->getClosestMachine($longitude, $latitude);
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function ajaxSavePanneQuitance() {

        $id = $this->input->post('id');
        
        $data = array(
            'annonceur' => $this->session->userdata('username'),
            'stat' => 'en cours',
            'date_introduction_panne' => date("Y-m-d H:i:s"), //heure système de l'introduction de la panne. -> MySql format
            'date_declaration_panne' => date("Y-m-d H:i:s"),
            'quitance' => 'oui',
            'description' => 'Maintenance/Surveillance test',
            'tranche_horaire' => 1,
            'installation' => $id,
            'type_panne' => 1 //,
          //  'clientNom' => $clientNom,
          //  'clientPrenom' => $clientPrenom,
          //  'clientRemarque' => $clientRemarque
        );
        $this->db->insert('panne', $data);
       
    }

}
