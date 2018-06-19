<?php

//AUTEUR : Marc lapraz DATT
defined('BASEPATH') OR exit('No direct script access allowed');

class Installation_Model extends CI_Model {

    //DESCRIPTION : Retourne l'ensemble les installations en fonction du numéro de région. 
    //PARAM : numRegion = pk de la region
    public function getInstallationByRegionNumero($numRegion) {
        $this->db->select('installation.numero as installationNumero, installation.libelle as installationLibelle');
        $this->db->from('installation');
        $this->db->where('installation.regionNumero =', $numRegion);
        $this->db->order_by("installation.numero", "asc");
        $sql = $this->db->get();
        return $sql->result();
    }

    //DESCRIPTION : Retourne l'ensemble des installation triées par ordre alha
    public function getAllInstallation(){
         $this->db->select('installation.numero as installationNumero, installation.libelle as installationLibelle');
        $this->db->from('installation');
        $this->db->order_by("installation.numero", "asc");
        $sql = $this->db->get();
        return $sql->result();
        
    }
    
    
    

}
