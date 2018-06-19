<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class To_Excel_Model extends CI_Model {
   
    
    public function populateTable(){
        
        $this->db->select("p.annonceur as annonceur ,p.clientInformation as remarqueClient, th.libelle as tranche, "
                        . "reg.libelle as region, install.libelle as installationLibelle, "
                        . "tp.libelle as typepanneLibelle, p.stat as status, p.date_introduction_panne as introduction, p.numero as panneNumero, p.quitance as quitanceLibelle,"
                        . "p.description as panneDescription, inter.debut_intervention as debut,"
                        . "inter.fin_intervention as fin, GROUP_CONCAT(materiel.libelle) as listeMatos, GROUP_CONCAT(DISTINCT us.username) as user,"
                        . "interUtilisateur.remarque as remarque, tranche.libelle as interth, GROUP_CONCAT(inter.numero)as interNumero ");
        
        $this->db->from("panne as p");   
        
        $this->db->join("intervention as inter"," p.numero = inter.pannenumero" );
     
        $this->db->join("tranchehoraire as tranche ", "inter.tranche_horaire = tranche.numero");
          
        $this->db->join("typepanne as tp","p.fk_typepanne= tp.numero" );
        
        $this->db->join("installation as install ","install.numero = p.installation" );
        
        $this->db->join ("tranchehoraire as th", "th.numero = p.tranche_horaire");
        
        $this->db->join("region as reg", "install.regionNumero = reg.numero");
          
        $this->db->join("materielintervention as matIntervention", "inter.numero = matIntervention.interventionNumero", 'left');
          
        $this->db->join("materiel as materiel","matIntervention.materielNumero = materiel.numero" , 'left' );
        
        $this->db->join("interventionutilisateur as interUtilisateur" , "inter.numero = interUtilisateur.numeroIntervention");
        
        $this->db->join ("users as us" ,"interUtilisateur.numeroutilisateur = us.id" );
        
   
         $this->db->group_by('p.numero'); 
        
        
        $sql = $this->db->get();
        return $sql;
   
    }
}
