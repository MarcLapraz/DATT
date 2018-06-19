<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* VUE associée :  Panne folder...
 * MODEL associé : Panne_Model
 * REMARQUE : Les méthodes n'ont aucun paramètre. Les valeurs sont récupérées dans le paramètre $_POST lors de la requête.
 * AUTEUR : Marc Lapraz
 */

// La classe panne étant Auth_Controller afin de pouvoir utiliser la classe Auth_Controller ici.
class Panne extends Auth_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('ion_auth');
        //  if ($this->ion_auth->is_admin() === FALSE) {
        //    redirect('/');
        // }
    }

    /* -NAME : function index()
     * -PARAMETRE : Aucun
     * -ROLE : Méthode exécuté par défaut au chargement de la page
     * -CONTENT : 
     *          1.Appel function loadFoarm , retour dans variable $data
     *          2.Appel de la function loadRulesPanne (régles de saisie..)
     *          3.Passage de $data dans la vue
     *          4.Affichage de la vue. Maintenant $data est atteignable sur la vue
     */
    public function index() {
        $data = $this->loadForm();
        $this->loadRulesPanne();
        $this->load->view('panne/index_view', $data, true);
        $this->render('panne/index_view');
    }


    /*-NAME : function loadRulesPanne()
    * -PARAMETRE : Aucun
    * -ROLE : chargement des règles de gestion
    * -CONTENT : 
    *          1.Chargement de la library 
    *          2.Configuration des règles 
    */
    private function loadRulesPanne() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('dateFrom', 'date form', 'trim|required');
        //$this->form_validation->set_rules('description_panne', 'decription', 'trim|required');
        $this->form_validation->set_rules('tranche_horaire', 'horaire', 'trim|required');
        $this->form_validation->set_rules('region', 'region', 'trim|required');
        $this->form_validation->set_rules('installation', 'installation', 'trim|required');
        $this->form_validation->set_rules('type_panne', 'type panne', 'trim|required');
    }

    
    /*-NAME : function loadForm()
    * -PARAMETRE : Aucun
    * -RETOUR : $data -> Tab. associatif contenant les différantes variables sous format clé, valeur
    * -ROLE : Chargement du formulaire avec les données à sélectionner
    * -REMARQUE -> Voir les model correspondant dans le dossier model... 
    * -CONTENT : 
    *          1. $regions -> Appel de la function getAllRegion du model Region_Model qui retourne toutes les regions en BD
    *          2. $horaires -> Appel de la fonction getAllHoraire du model Horaire_Model qui retourne tous les horaires en BD
    *          3. $typesPannes -> Appel de la fonction getAllTypePanne du model TypePanne_Model qui retourne tous les types de pannes en BD
    *          4. Pour $regions, $horaires, $typesPanne : Creation d'un tableau associatif et ajout dans la variable $data
    */
    public function loadForm() {
        $regions = $this->Region_Model->getAllRegion();
        $horaires = $this->Horaire_Model->getAllHoraire();
        $typesPannes = $this->TypePanne_Model->getAllTypePanne();
        foreach ($regions as $region) {
            $regionFinal [$region->regionNumero] = $region->regionLibelle;
        }
        $data['AllRegions'] = array('regions' => $regionFinal);
        foreach ($horaires as $horaire) {
            $horaireFinal [$horaire->horaireNumero] = $horaire->horaireLibelle;
        }
        $data['AllHoraires'] = array('horaires' => $horaireFinal);
        foreach ($typesPannes as $typePanne) {
            $typesPannesFinal [$typePanne->typePanneNumero] = $typePanne->typePanneLibelle;
        }
        $data['AllTypesPannes'] = array('typesPannes' => $typesPannesFinal);
        return $data;
    }

    //-------------Attention au formattage des dates, l'appli est connectée à une base mySql--------------------
    /* -NAME : function savePanne()
    * -PARAMETRE : Aucun
    * -ROLE : Sauvegarder une panne en base de données
    * -CONTENT : 
    *          1. Appel de la function LoadRulesPanne. on peut utiliser this-> car la function est contenue dans cette page
    *          2. SI les regles de validation sont OK (vraies)
    *               2.1 Réupération des valeurs contenues dans le paramètre post 
    *               2.2 Création du tableau associatif $data
    *               2.3 Insértion dans la base de données / table panne
     *              2.4 Redirection sur le dashboard
     *         3. SINON retour à l'index.
     * ----------------------------------------------------------------------------------------------------------
    */
    public function savePanne() {
        $this->loadRulesPanne();
        if ($this->form_validation->run() === TRUE) {
            $date_declaration = $this->input->post('dateFrom');
            //$datum3 est un objet, car il faut pouvoir transformer le format de départ en format mySql.
            $dateMysql = new DateTime($date_declaration, new DateTimeZone('Europe/Amsterdam'));
            $description_panne = $this->input->post('description_panne');
            $tranche_horaire = $this->input->post('tranche_horaire');
            $installation = $this->input->post('installation');
            $type_panne = $this->input->post('type_panne');
                               
            $clientInformation = $this->input->post('clientInformation');
            
            $data = array(
                'annonceur' => $this->session->userdata('username'),
                'stat' => 'en attente',
                'date_introduction_panne' => date("Y-m-d H:i:s"), //heure système de l'introduction de la panne. -> MySql format
                'date_declaration_panne' => $dateMysql->format("Y-m-d H:i:s"),
                'quitance' => 'non',
                'description' => $description_panne,
                'tranche_horaire' => $tranche_horaire,
                'installation' => $installation,
                'fk_typepanne' => $type_panne,
                'clientInformation' => $clientInformation,
                'intervention'=> 'non'
          
            );
            $this->db->insert('panne', $data);
            redirect('Dashboard');
        } else {
            $this->index();
        }
    }

   
    /*-NAME : function ajax_getInstallation()
    * -PARAMETRE : Aucun
    * -ROLE : Retourne les installations en fonction de la région
    * -RETURN : json response (region)
    * -CONTENT : 
    *          1.Récupération du paramètre POST numero envoyé par la requête AJAX
    *          2.Appel de la methode getInstallationByRegionNumero qui retourne les installations en fonction du numero de région
    *          3.Déclaration de l'en-tête
    *          4.Encodage de la reponse en json
    */
    public function ajax_getInstallation() {
        $numRegion = $this->input->post('installationNumRegion');
        $regions = $this->Installation_Model->getInstallationByRegionNumero($numRegion);
        header('Content-Type: application/json');
        echo json_encode($regions);
    }

    
    /* -NAME : function delete()
    * -PARAMETRE : clé primaire panne
    * -ROLE : Supprimer une panne et redirection 
    * -CONTENT : 
    *          1.Récupération du paramètre numero
    *          2.Redirect sur la page qui affiche les pannes en attente de traitement.
    */
    public function delete($numero) {
        $this->Panne_Model->delete($numero);
        redirect('PanneEnAttente');
    }

}
