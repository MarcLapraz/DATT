<?php

//AUTEUR : Marc lapraz
//
defined('BASEPATH') OR exit('No direct script access allowed');

class Panne_Model extends CI_Model {

    //-------------------------------------------------------------------------
    //DESCRIPTION : Retourne les pannes dont les status est différent de termine. 
    //USE -> Derangement/PanneEnAttente (default method; loading page)
    //-----------------------------------------------------------------------
    public function getPanneEnCours() {
        $this->db->select('panne.numero ,panne.annonceur, panne.stat as stat, panne.quitance, panne.description, panne.quitance as quitance,'
                . ' panne.date_declaration_panne,type.libelle, installation.libelle as install,  '
                . 'panne.date_fin_panne as fin, panne.date_introduction_panne, installation.libelle, '
                . 'type.libelle, type.libelle as typepanne, tranchehoraire.libelle ,panne.intervention as intervention, users.username as userQuitance, userAlias.username as userCharge ');
        $this->db->from('panne');
        $this->db->join('installation ', 'panne.installation = installation.numero');
        $this->db->join('typepanne as type', 'panne.fk_typepanne = type.numero');
        $this->db->join('tranchehoraire', 'panne.tranche_horaire = tranchehoraire.numero');
        $this->db->join('users', 'panne.fk_userQuitance = users.id', 'left');
        $this->db->join('users as userAlias', 'panne.fk_userCharge = userAlias.id', 'left');


        $termine = "termine";
        $null = "0000-00-00 00:00:00";
        $array = array('stat !=' => $termine, 'panne.date_fin_panne =' => $null);
        $this->db->where($array);
        $this->db->order_by('panne.numero', 'DESC');
        $sql = $this->db->get();
        return $sql;
    }

    
    
    
    //DESCRIPTION : Retourne UNE panne en fonciton de sa clé primaire
    //PARAM : $numero -> pkPanneNumero
    public function getPanneByNumero($numero) {
        $this->db->select('panne.numero as numero, panne.description as description, panne.date_introduction_panne as panneIntroduction, '
                . 'panne.installation as panneInstallation,'
                . 'panne.date_declaration_panne,'
                . 'installation.regionNumero as installationRegionNumero,'
                . 'panne.fk_typepanne as typepanneNumero,'
                . 'panne.tranche_horaire as tranchehoraireNumero');
        $this->db->from('panne');
        $this->db->join('installation ', 'panne.installation = installation.numero');
        $this->db->where('panne.numero =', $numero);
        $this->db->order_by('panne.numero', 'DESC');
        $sql = $this->db->get();
        return $sql;
    }

    //DESCRIPTION : Retourne tous les types de panne. 
    //PARAM : none
    public function getAllTypePanne() {
        $this->db->select('typepanne.numero as typePanneNumero, typepanne.libelle as typePanneLibelle');
        $this->db->from('typepanne');
        $this->db->order_by("typepanne.numero", "asc");
        $sql = $this->db->get();
        return $sql->result();
    }

    
    
    
    
    
    
    //DESCRIPTION : Retourner les pannes dont le status est ok
    //PARAM : none
    public function getPanneTraitement() {
        $this->db->select('panne.numero ,panne.annonceur, panne.stat, panne.quitance, panne.description, panne.quitance as quitance,'
                . 'panne.date_declaration_panne,type.libelle, installation.libelle as install, '
                . 'panne.date_fin_panne, panne.date_introduction_panne, installation.libelle, '
                . 'type.libelle, type.libelle as typepanne, tranchehoraire.libelle');
        $this->db->from('panne');
        $this->db->join('installation ', 'panne.installation = installation.numero');
        $this->db->join('typepanne as type', 'panne.type_panne = type.numero');
        $this->db->join('tranchehoraire', 'panne.tranche_horaire = tranchehoraire.numero');
        $where = "stat != 'ok' ";
        $this->db->where($where);
        $this->db->order_by('panne.numero', 'DESC');
        $sql = $this->db->get();
        return $sql;
    }

    //DESCRIPTION : Retourne la remarque du technicien 
    //PARAM : $numero = intervention.panneNumero ==  pkPanneNumero
    public function getAjaxRemarque($numero) {
        $this->db->select('intUti.remarque,users.username ');
        $this->db->from('interventionutilisateur as intUti');
        $this->db->join('intervention', 'intUti.numeroIntervention = intervention.numero');
        $this->db->join('users', 'intUti.numeroutilisateur = users.id');
        $this->db->where('intervention.pannenumero', $numero);

        $sql = $this->db->get();
        return $sql->result();
    }

    //DESCRIPTION : Updater une panne
    //PARAM : $numero -> pkPanne ; $data -> array contenant les nouvelles données
    public function update($numero, $data) {
        $this->db->where("numero", $numero);
        $this->db->update('panne', $data);
    }

    //DESCRIPTION : Effacer une panne
    //PARAM : $numero = pkNumero
    public function delete($numero) {
        $this->db->where("numero", $numero);
        $this->db->delete("panne");
    }

    
    
    
    
    //------------------------------------------------------------------------------------------
    
    
    //DESCRIPTION : Retourne les pannes 
    /*  public function getFormatedPanne() {
      $this->db->select('panne.numero ,panne.annonceur, panne.stat, panne.quitance, panne.description,'
      . ' panne.date_declaration_panne,type.libelle, installation.libelle as install, '
      . 'panne.date_fin_panne, panne.date_introduction_panne as intro, installation.libelle, '
      . 'type.libelle, type.libelle as typepanne, tranchehoraire.libelle');
      $this->db->from('panne');
      $this->db->join('installation ', 'panne.installation = installation.numero');
      $this->db->join('typepanne as type', 'panne.type_panne = type.numero');
      $this->db->join('tranchehoraire', 'panne.tranche_horaire = tranchehoraire.numero');
      $this->db->order_by('panne.numero', 'DESC');
      $sql = $this->db->get();
      return $sql;
      }

     */

    //DESCRIPTION : Changer le status de la quitance 
    //PARAM : $numero -> pkPAnne ; $data array contenant les nouvelles données
    //REMARQUE : lÔRM se charge de faire le taf. 
    //  public function setQuitance($numero, $data) {
    //      $this->db->where("numero", $numero);
    //      $this->db->update('panne', $data);
    // }
}
