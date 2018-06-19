<?php

//AUTEUR : Marc lapraz 
defined('BASEPATH') OR exit('No direct script access allowed');

class Region_Model extends CI_Model {

    //DESCRIPTION : Retourne l'ensemble des regions triées par ordre alpha
    public function getAllRegion() {
        $this->db->select('region.numero as regionNumero, region.libelle as regionLibelle');
        $this->db->from('region');
        $this->db->order_by("region.libelle", "asc");
        $sql = $this->db->get();
        return $sql->result();
    }

    

}
