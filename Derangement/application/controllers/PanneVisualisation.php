<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* VUE associée :  panne/visualisation.php
 * MODEL associé : Panne_Model
 * REMARQUE : Les méthodes n'ont aucun paramètre. Les valeurs sont récupérées dans le _POST lors de la requête.
 * AUTEUR : Marc Lapraz
 */

class PanneVisualisation extends Auth_Controller {

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
     *          1. Affichage de la vue
     */

    public function index() {
        $this->render('panne/visualisation');
    }

    /* -NAME : function ajax_Pannes()
     * -PARAMETRE : Aucun
     * -ROLE : Alimentation de la DATATABLE 
     */

    public function ajax_Pannes() {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $sql = $this->To_Excel_Model->populateTable();
        $dataReturn = array();

        foreach ($sql->result() as $r) {

            $date_a = new DateTime($r->debut);
            $date_b = new DateTime($r->fin);
            $date_c = new DateTime($r->introduction);

            $interval1 = date_diff($date_a, $date_b);
            $tt = $interval1->format('%h heure(s) %i min');
            $interval2 = date_diff($date_c, $date_b);
            $aa = $interval2->format('%d jour(s) %h heure(s) %i min');

            $dataReturn[] = array(
                $r->status,
                $r->panneNumero,
                $r->interNumero,
                $r->annonceur,
                $r->tranche,
                $r->introduction,
                $r->region,
                $r->installationLibelle,
                $r->typepanneLibelle,
                $r->remarqueClient,
                $r->quitanceLibelle,
                $r->listeMatos,
                $r->user,
                $r->interth,
                $r->debut,
                $r->fin,
                $tt,
                $aa,
                $r->remarque
                
            );
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $sql->num_rows(),
            "recordsFiltered" => $sql->num_rows(),
            "data" => $dataReturn
        );
        echo json_encode($output);
        exit();
    }

    /* -NAME : function ajax_getRemarque()
     * -PARAMETRE : Aucun
     * -ROLE : Méthode exécuté par défaut au chargement de la page
     * -CONTENT : 
     *          1.Appel function loadFoarm , retour dans variable $data
     *          2.Appel de la function loadRulesPanne (régles de saisie..)
     *          3.Passage de $data dans la vue
     *          4.Affichage de la vue. Maintenant $data est atteignable sur la vue
     */

    public function ajax_getRemarque() {

        $pk = $this->input->post('pk');
        $toView = $this->Panne_Model->getAjaxRemarque($pk);
        header('Content-Type: application/json');
        echo json_encode($toView);
    }

}
