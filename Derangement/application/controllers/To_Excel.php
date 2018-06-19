<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* VUE associée :  intervention/index_view.php
 * MODEL associé : Intervention_Model
 * REMARQUE : Les méthodes n'ont aucun paramètre. Les valeurs sont récupérées dans le _POST lors de la requête.
 * AUTEUR : Marc Lapraz
 */

class To_Excel extends Auth_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('ion_auth');
        //  if ($this->ion_auth->is_admin() === FALSE) {
        //    redirect('/');
        // }
    }

   
    public function index() {
   
        $data['sql'] = $this->To_Excel_Model->populateTable();
        
       //var_dump($data['sql']['1']->numero);
        //var_dump($data['sql']);
        //print_r( sizeof($data['sql']));
        
        
        $this->load->view('toExcel/index_view', $data, true);  
        $this->render('toExcel/index_view');
    }


    
    
    
     public function ajax_Pannes() {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $sql = $this->Panne_Model->getFormatedPanne();
        $dataReturn = array();

        foreach ($sql->result() as $r) {
            $dataReturn[] = array(
                $r->numero,
                $r->install,
                $r->intro,
                $r->typepanne,
                $r->description
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
    
    
    
    
    
    

}
