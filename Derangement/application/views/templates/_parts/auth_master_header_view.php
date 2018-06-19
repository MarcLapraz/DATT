<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <!--L'ordre de chargement des scripts est important... Et ne pas upgrader en bootstrap 4.  -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title><?php echo $page_title; ?></title>
        <meta name="description" value="<?php echo $page_description; ?>" />

        <!--JQUERY (Toujours ajouter JQuery en premier) -->
        <script type = "text/javascript" src ="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>

        <!--ASSETS BOOTSTRAP en local -->
        <script src="<?php echo base_url(); ?>/assets/Bootstrap/transition.js"></script>
        <script src="<?php echo base_url(); ?>/assets/Bootstrap/collapse.js"></script>

        <!-- BOOTSTRAP 3.3.2 -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

        <!-- ASSETS DATETIME PICKER -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

        <!--DATATABLE  -->
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script> 
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>

        <!--Chargement des CSS Bootstrap et DataTable --> 
        <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/components/dropdown.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/components/dropdown.js"></script>

        <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/components/transition.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/components/transition.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
        
        
       <!-- <script src=" https://code.jquery.com/jquery-1.12.4.js"></script>-->
       <!-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> -->
        <script src=" https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
        <script src="  https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src=" https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
        <script src=" https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js "></script>
        <script src=" https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js "></script>
        
      
        <!--MAIN CSS chargé en dernier -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/CSS/mainCSS.css">
        
        <link rel="icon" href="<?php echo base_url(); ?>/assets/images/icon.png">

        <?php echo $before_closing_head; ?>
    </head>
        <body>