<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* VUE associée :  intervention/index_view.php
 * MODEL associé : Intervention_Model
 * REMARQUE : Les méthodes n'ont aucun paramètre. Les valeurs sont récupérées dans le _POST lors de la requête.
 * AUTEUR : Marc Lapraz
 */

class Intervention extends Auth_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('ion_auth');
        //  if ($this->ion_auth->is_admin() === FALSE) {
        //    redirect('/');
        // }
    }

    /* -----------------------------------------------------------------------------
     * -NAME : function index()
     * -USED BY: loading page
     * -PARAMETRE : Aucun
     * -ROLE : fonction exécutée par défaut lors de l'appel au controller
     * -CONTENT : 
     *          1.Récupération du segement 3 composant l'uri / ----> .../Intervention/index/325  + ajout du retour de la fonction dans le tableau $data
     *          2.Appel de la méthode getInformation en passant la clé (sous forme de tableau à l'indice pkPanne) en paramètre
     *          3.Passage du tableau $data dans la vue SANS afficher la vue (3 ème param -> true)
     *          4.Render -> Chargement de la vue 
     * -----------------------------------------------------------------------------
     */

    public function index() {

        $currentDate = new DateTime("now", new DateTimeZone("Europe/Amsterdam"));
        if ($currentDate->format('N') >= 6) {
            $data['tranche'] = "Week-end";
            $data['tranche_pk'] = "3";
        } else {
            if ($currentDate->format('H') < 16) {
                $data['tranche'] = "Semaine pendant bureau";
                $data['tranche_pk'] = "1";
            } else {
                $data['tranche'] = "Semaine hors bureau";
                $data['tranche_pk'] = "2";
            }
        }

        $data['pkPanne'] = $this->uri->segment(3);
        $data['sql'] = $this->Intervention_Model->getInformation($data['pkPanne']);
        $this->load->view('intervention/index_view', $data, true);
        $this->render('intervention/index_view');
    }

    /* -NAME : function getMaterielAjax()
     * -PARAMETRE : Aucun
     * -ROLE : Retourne la liste de materiel en fonction du numéro de la catégorie
     * -RETURN : json response
     * -CONTENT : 
     *          1.Récupération du paramètre POST numero envoyé par la requête AJAX (dans data parameter)
     *          2.Appel de la méthode getMaterielByCategorie en passant la valeur récupérée dans le POST AJAX
     *          3.Définition de l'en-tête json
     *          4.Encodage de la réponse en format json
     */

    public function getMaterielAjax() {
        $numero = $this->input->post('numero');
        $materiel = $this->Intervention_Model->getMaterielByCategorie($numero);
        header('Content-Type: application/json');
        echo json_encode($materiel);
    }

    /* -NAME : function saveInterventionAjax()
     * -PARAMETRE : Aucun
     * -ROLE : TRANSACTION permettant de sauver une intervention
     * -RETURN : json response
     * -CONTENT : 
     *          1.DEBUT de la transaction
     *              1.1. Récupération de l'id de l'utilisateur connecté
     *              1.2  Récupération de la valeur post numero correspondant au numero de la panne courante
     *              1.3  Création tableau associatif $data (heure system & panne numero)
     *              1.4  Insertion dans la table intervention
     *              1.5  Récupération de la clé primaire apres insertion (point 1.4)
     *              1.6  Création tableau associatif $data2
     *              1.7  Insertion dans la table interventionutilisateur
     *          2. FIN de la transaction
     *          3. Déclaration de l'entête pour le retour de la fonction
     *          4.Clé ,valeur à retourner
     *          5.Encodage de la réponse
     */

    public function saveInterventionAjax() {


        $this->db->trans_start();
        $numeroUser = $this->ion_auth->user()->row()->id;
        $numero = $this->input->post('numero');
        $tranche = $this->input->post('tranche');

        //-----------------UPDATE PANNE INTERVENTION COLUMN INTERVENTION = 'OUI'
        $dataInter = array(
            'intervention' => 'oui'
        );
        $this->db->where("numero", $numero);
        $this->db->update('panne', $dataInter);

        //------------------INSERT DEBUT INTERVENTION + TRANCHE_HORAIRE INTO INTERVENTION WHERE PANNENUMERO = PARAM.
        $data = array(
            'panneNumero' => $numero,
            'debut_intervention' => date("Y-m-d H:i:s"), //heure système de l'introduction de la panne. -> MySql format
            'tranche_horaire' => $tranche
        );

        $this->db->insert('intervention', $data); // pas besoin du model. L'ORM se charge de faire l insert
        //-----------------RECUP LAST ID----------------------------------

        $pknumero = $this->db->insert_id();
        $data2 = array(
            'numerointervention' => $pknumero,
            'numeroutilisateur' => $numeroUser
        );
        $this->db->insert('interventionutilisateur', $data2);


        $this->db->trans_complete();
        header('Content-Type: application/json');
        $toEncode = ["pkIntervention" => $pknumero];
        echo json_encode($toEncode);
    }

    
    
    
    //---------------------------------------------------------------------------------------
    /* -NAME : function closeInterventionAjax()
     * -PARAMETRE : Aucun
     * -ROLE : Cloturer une intervetion
     * -CONTENT : 
     *          1.Récupération du paramètre POST numero envoyé par la requête AJAX
     *          2.Set la date/heure courante dans $date_fin
     *          3.Création du tableau $data, set fin_intervention -> $date_fin dans $data
     *          4.UPDATE intervention where $numero = numero
     */

    public function closeInterventionAjax() {
        $numero = $this->input->post('numero');
        $date_fin = date("Y-m-d H:i:s");
        $data = ["fin_intervention" => $date_fin];
        $this->db->where("numero", $numero);
        $this->db->update('intervention', $data);
    }

    /* -NAME : function saveMaterielAjax()
     * -PARAMETRE : Aucun
     * -ROLE : Sauvegarde du materiel
     * -CONTENT : 
     *          1.Récupération des paramètres POST  (idArticle ... pk)
     *          2.Passage des paramètre dans un arra $data sous form clé valeur
     *          3. Insert dans la base de données sans passer par le modèle. L'ORM se charge de faire l'insert
     */

    public function saveMaterielAjax() {

        $idArticle = $this->input->post('select_article');
        $radio = $this->input->post('radios');
        $ancien = $this->input->post('ancienNumeroSerie');
        $nouveau = $this->input->post('nouveauNumeroSerie');
        $remarque = $this->input->post('remarque');
        $pk = $this->input->post('pk');
        $data = array(
            'materielNumero' => $idArticle,
            'action' => $radio,
            'InterventionNumero' => $pk,
            'ancienNumeroSerie' => $ancien,
            'nouveauNumeroSerie' => $nouveau,
            'remarque' => $remarque
        );
        $this->db->insert('materielintervention', $data);
    }

    /* -NAME : function resoluAjax()
     * -PARAMETRE : Aucun
     * -ROLE : Méthode appelée lorsqu'une intervention est résolue (machine fonctionnelle)
     * -REMARQUE : Utilisation d'une transaction pour traiter les 2 updates au travers d'un appel
     * -CONTENT : 
     *          1.Récupération du paramètre POST numero envoyé par la requête AJAX & set date du moment dans $date_fin_panne
     *          2.DEBUT de la transaction (2 insert dans 2 tables, le but étant de 
     *              2.1.Passage de la remarque dans le tableau $data1 
     *              2.2.UPDATE interventionUtilisateur
     *             2.3 création $data2 (clé valeur) avec les données relatives
     *             2.4 UPDATE status de la panne courante
     *         3. FIN de la transaction 
     */

    public function resoluAjax() {
        $pkPanne = $this->input->post('pkPanne');
        $interventionNumero = $this->input->post('interventionNumero');
        $remarque = $this->input->post('remarque');
        $date_fin_panne = date("Y-m-d H:i:s"); // date,heure system 
        //---------START OF TRANSACTION---------------------
        $this->db->trans_start();
        //update intervention, ajout de la remarque. 
        $data1 = ["remarque" => $remarque];
        $this->db->where("numeroIntervention", $interventionNumero);
        $this->db->update('interventionUtilisateur', $data1);

        //update du status de la panne en terminée  
        $data2 = ["stat" => "termine", "date_fin_panne" => $date_fin_panne];
        $this->db->where("numero", $pkPanne);
        $this->db->update('panne', $data2);
        //--------END OF TRANSACTION-----------------------------
        $this->db->trans_complete();

        header('Content-Type: application/json');
        $redirection['redirect_url'] = base_url();
        echo json_encode($redirection);
    }

    /* -NAME : function nonresoluAjax()
     * -PARAMETRE : Aucun
     * -ROLE : ACTION lorsqu'une intervention ne résoud pas la panne
     * -CONTENT : 
     *          1.Récupération du paramètre POST numero envoyé par la requête AJAX
     *          2.Création du $data1 avec la remarque en paramètre 
     *          3.UPDATE grace à l'ORM  
     */

    public function nonresoluAjax() {
        $interventionNumero = $this->input->post('interventionNumero');
        $remarque = $this->input->post('remarque');
        $data1 = ["remarque" => $remarque];
        $this->db->where("numeroIntervention", $interventionNumero);
        $this->db->update('interventionUtilisateur', $data1);

        header('Content-Type: application/json');
        $redirection['redirect_url'] = base_url();
        echo json_encode($redirection);
    }

    public function deleteComposantAjax() {
        $interventionNumero = $this->input->post('interventionNumero');
        $materielID = $this->input->post('materielID');
        $data = ["interventionNumero" => $interventionNumero, "materielID" => $materielID];
        $this->Intervention_Model->deleteComposant($data);
    }

}
