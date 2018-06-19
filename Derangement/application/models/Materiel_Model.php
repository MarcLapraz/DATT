<?php

//AUTEUR : Marc lapraz 
defined('BASEPATH') OR exit('No direct script access allowed');

class TypePanne_Model extends CI_Model {

    
    //DESCRIPTION : Retourne tous les types de panne
    //PARAM : none
    public function getAllTypePanne() {
        $this->db->select('typepanne.numero as typePanneNumero, typepanne.libelle as typePanneLibelle');
        $this->db->from('typepanne');
        $this->db->order_by("typepanne.numero", "asc");
        $sql = $this->db->get();
        return $sql->result();
    }

    

}
