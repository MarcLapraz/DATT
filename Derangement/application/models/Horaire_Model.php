<?php

//AUTEUR : Marc lapraz 
defined('BASEPATH') OR exit('No direct script access allowed');

class Horaire_Model extends CI_Model {

    //DESCRIPTION : Retourne l'ensemble des tranches horaires triées par ordre alpha
    public function getAllHoraire() {
        $this->db->select('tranchehoraire.numero as horaireNumero, tranchehoraire.libelle as horaireLibelle');
        $this->db->from('tranchehoraire');
        $this->db->order_by("tranchehoraire.numero", "asc");
        $sql = $this->db->get();
        return $sql->result();
    }

    

}
