<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Recherche_Model extends CI_Model {

    public function ajaxGetInfosInstallation($num) {
        $this->db->select('region.libelle as regionLib, installation.id as id, installation.nom_print as print, installation.numero_routeur as routeur, installation.mot_de_passe as mdp, installation.adresse_ip as ip ,installation.numero_telephone as phone ,installation.numero_pin as pin');
        $this->db->from('installation');
        $this->db->join('region as region', 'region.numero = installation.regionnumero');
        $this->db->where('installation.numero', $num);
        $sql = $this->db->get();
        return $sql->result();
    }

    public function ajaxGetPanneByNumeroInstallation($numero) {
        $this->db->select('p.numero as numero ,p.date_introduction_panne , p.stat ,p.date_fin_panne, p.type_panne, t.libelle');
        $this->db->from('panne as p');
        $this->db->join('typepanne as t ', 'p.type_panne = t.numero');
        $this->db->where('p.installation', $numero);
        $sql = $this->db->get();
        return $sql->result();
    }

    

    public function ajaxGetDetailIntervention($numero) {
        $this->db->select('intervention.numero,intervention.debut_intervention,intervention.fin_intervention, intUti.remarque, users.username ');
        $this->db->from('intervention');
        $this->db->join('interventionUtilisateur as intUti', 'intervention.numero = intUti.numeroIntervention');
        $this->db->join ('users', 'users.id = intUti.numeroUtilisateur');
        $this->db->where('panneNumero', $numero);
        $sql = $this->db->get();
        return $sql->result();
    }

    
   
    public function ajaxGetDetailDetails($numero){      
        $this->db->select("interventionUtilisateur.remarque, users.username, matIn.nouveauNumeroSerie, matIn.ancienNumeroSerie, mat.libelle, matIn.remarque, matIn.action");
        $this->db->from("interventionUtilisateur");    
        $this->db->join("users", "users.id = interventionUtilisateur.numeroUtilisateur");
        $this->db->join("materielIntervention as matIn", "matIn.InterventionNumero = interventionUtilisateur.numeroIntervention");     
        $this->db->join("materiel as mat", "mat.numero = matIn.materielNumero");     
        $this->db->where("numeroIntervention", $numero);     
        $sql = $this->db->get();
        return $sql->result();
    }
  
}
