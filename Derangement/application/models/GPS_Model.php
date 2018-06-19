<?php

//AUTEUR : Marc lapraz 
defined('BASEPATH') OR exit('No direct script access allowed');

class GPS_Model extends CI_Model {

    public function getClosestMachine($longitude, $latitude) {
       
        // TEST DATA
        //[Evole max lat :  46.9897 * 1.0001 = 47.0366]
        //[Evole min lat :  46.9897 * 0.9995 = 46.96620]
        //[Evole max long :  6.92346 * 1.0001 = 6.924152]
        //[Evole min long  : 6.92346 * 0.997 = 6.92138] 
        
        $latMax = $latitude * 1.000001 ;    
        $latMin = $latitude * 0.9998;                
        $longMax = $longitude * 1.0001 ;    
        $longMin = $longitude * 0.99989 ;   
         
        $this->db->select('*');
        $this->db->from('installation');
               
        $this->db->where('latitude >=', $latMin);
        $this->db->where('latitude <=', $latMax);
        $this->db->where('longitude >=', $longMin);
        $this->db->where('longitude <=', $longMax);
        
        $sql = $this->db->get();
        
        return $sql->result();   
    }

    

}
