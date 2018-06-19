<?php

//AUTEUR : Marc lapraz 
defined('BASEPATH') OR exit('No direct script access allowed');

class Intervention_Model extends CI_Model {
    //----------------------------------------------------------------------------
    //DESCRIPTION : retourne les informations d'une panne en fontion du numero de la clé pkPanne
    //PARAM : $numero -> pkPanne
    //USE : Derangement/Intervention/index/XXX 
    //----------------------------------------------------------------------------
    public function getInformation($numero) {
        $this->db->select('typepanne.libelle as type_panne, panne.description as description, panne.installation as installationNumero, panne.date_introduction_panne as panneDate, installation.libelle as libelle');
        $this->db->from('panne');
        $this->db->join('installation', 'panne.installation = installation.numero');
        
        $this->db->join('typepanne', 'panne.fk_typepanne = typepanne.numero');   
        $this->db->where('panne.numero =', $numero);
        $sql = $this->db->get();
        return $sql;
    }



    //DESCRIPTION : retourne une liste de materiel en fonction de la categorie 
    //PARAM : categorie numero
    public function getMaterielByCategorie($categorieNumero) {
        $this->db->select('materiel.numero as materielNumero, materiel.libelle as materielLibelle');
        $this->db->from('materiel');
        $this->db->where('materiel.categorieNumero =', $categorieNumero);
        $this->db->order_by("materiel.numero", "asc");
        $sql = $this->db->get();
        return $sql->result();
    }

    //DESCRIPTION : update intervention
    //PARAM : $numero -> pkPanneNumero
    //        $data -> array contenant les nouvelles données, l'ORM se charge de faire le taf
    public function update($numero, $data) {
        $this->db->where('pannenumero', $numero);
        $this->db->update('intervention', $data);
    }

    
   
    
    
    public function deleteComposant($data){
        
       $this->db->where("interventionNumero", $data["interventionNumero"]); 
       $this->db->where("materielNumero", $data["materielID"]);   
       $this->db->delete ("materielIntervention");
    
    }
    
    

}


   