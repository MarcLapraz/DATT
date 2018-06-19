<?php

//AUTEUR : Marc lapraz 
defined('BASEPATH') OR exit('No direct script access allowed');

class Carte_Model extends CI_Model {

 public function getPanneEnCours() {
        $this->db->select('panne.numero ,panne.annonceur, panne.stat as stat, panne.quitance, panne.description, panne.quitance as quitance, panne.information_supp as supp,'
                . ' panne.date_declaration_panne,type.libelle, installation.libelle as install,  '
                . 'panne.date_fin_panne as fin, panne.date_introduction_panne, installation.libelle, '
                . 'type.libelle, type.libelle as typepanne, tranchehoraire.libelle');
        $this->db->from('panne');
        $this->db->join('installation ', 'panne.installation = installation.numero');
        $this->db->join('typepanne as type', 'panne.type_panne = type.numero');
        $this->db->join('tranchehoraire', 'panne.tranche_horaire = tranchehoraire.numero');

        $termine = "termine";
        $null = "0000-00-00 00:00:00";
        $array = array('stat !=' => $termine, 'panne.date_fin_panne =' => $null);
        $this->db->where($array);
        $this->db->order_by('panne.numero', 'DESC');
        $sql = $this->db->get();
        return $sql->result();
    }

    

    
    
    
    
}
