<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* VUE associée :  Panne folder...
 * MODEL associé : Panne_Model
 * REMARQUE : Les méthodes n'ont aucun paramètre. Les valeurs sont récupérées dans le paramètre $_POST lors de la requête.
 * AUTEUR : Marc Lapraz
 */

// La classe panne étant Auth_Controller afin de pouvoir utiliser la classe Auth_Controller ici.
class Carte extends Auth_Controller {

    function __construct() {
        parent::__construct();
        // $this->load->helper('url');
        // $this->load->library('ion_auth');
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
        //  $data = $this->loadForm();
        //  $this->loadRulesPanne();
        //  $this->load->view('GPS/carte', true);
        $this->render('Carte/carte');
    }


    
    public function ajaxTest(){
        
       $install = $this->Carte_Model->getPanneEnCours();
       header('Content-Type: application/json');
       echo json_encode($install);
        
        
        
        
        
    }
    
    
    

}
