<?php

/* VUE associée :  dashboard/index_view.php
 * MODEL associé : none
 * REMARQUE : Les méthodes n'ont aucun paramètre. Les valeurs sont récupérées dans le _POST lors de la requête.
 * AUTEUR : Marc Lapraz
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Auth_Controller {

    public function index() {
        $this->render('dashboard/index_view');
        //$this->isAdmin(); 
    }

   
}
