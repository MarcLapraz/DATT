<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">

    <?php
    echo isset($_SESSION['auth_message']) ? $_SESSION['auth_message'] : FALSE;
    $username = $this->session->userdata('username');
    ?>
    <?php echo validation_errors(); ?>
    <div class="row">
        <div class="column" style="background-color:#aaa;">

            <h1>Informations machine de vente </h1>
            <?php
            echo form_open('Panne/savePanne');   // On submit -> savePanne

            echo form_label('Heure et date annoncé par le client :', 'heure_panne') . '<br />';
            ?>
            <div class='input-group date' id='dateFormDiv'>
                <input type='text' class="form-control" id='dateForm'  name="dateFrom"/><br/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
            <br/>

            <div id='horaire_dropdown'>
                <?php
                $attribut1 = 'id="horaire"  class="form-control"   ';
                echo form_label('Tranche horaire:', 'tranche_horaire') . '<br/>';
                echo form_dropdown('tranche_horaire', $AllHoraires, set_value('tranche_horaire'), $attribut1) . '<br/>';
                
 
                ?>
            </div>

            <div id ='region_dropdown'>
                <?php
                $attribut = 'id="region"  class="form-control" ';
                echo form_label('Région:', 'region') . '<br/>';
                echo form_dropdown('region', $AllRegions, set_value('region'), $attribut) . '<br/>';
                ?>
            </div>

            <label for="installation">Installation:</label>
            <div  id='installation' class="ui search selection dropdown fluid">
                <input name="installation" type="hidden">
                <i class="dropdown icon"></i>
                <div class="default text">Choix installation</div>
                <div id ="menu" class="menu"> </div>
            </div>
            <br/>

            <?php
            echo form_label('Type de panne:', 'type_panne') . '<br/>';
            echo form_dropdown('type_panne', $AllTypesPannes, 'large', 'class="form-control"') . '<br/>';
            ?>


            <?php
            echo form_label('Description de la panne:', 'description_panne') . '<br />';
            echo form_textarea('description_panne', set_value('description_panne'), 'class="form-control"') . '<br/>';
            ?>
        </div>

        <div class="column" style="background-color:#bbb;">
            <h1>Informations client</h1>

            <?php
            echo form_label('Information client:', 'clientInformation') . '<br />';
            echo form_textarea('clientInformation', set_value('clientInformation'), 'class="form-control"') . '<br/>';
            ?>

        </div>
    </div>


    <!-- CENTRER LE BOUTON DE VALIDATION -->
    <div id="outer" style="width:100%">
        <div id="inner">
            <button type="submit" class="btn btn-info btn-circle btn-lg"><i class="glyphicon glyphicon-ok"></i></button>  
        </div>
    </div>



</div>






<script type ="text/javascript">
    $(document).ready(function () {
        $('#region_dropdown select').change(function () {
            $('#installation').dropdown('clear');
            var selRegion = $(this).val();
            $.ajax({
                url: "/Derangement/Panne/ajax_getInstallation",
                async: true,
                type: "POST",
                data: "installationNumRegion=" + selRegion,
                dataType: "html",
                success: function (data) {
                    var dropdownInstallation = $('#menu');
                    dropdownInstallation.empty();
                    var installations = $.parseJSON(data);
                    $.each(installations, function (i, install) {
                        dropdownInstallation.append('<div class="item fluid" style="font-size: 15px" data-value= "' + install.installationNumero + '">' + install.installationLibelle + '</div>');
                    });
                    $('#installation').dropdown();
                }
            });
        });
    });
</script>



<script type="text/javascript">
    $(function () {
        var dateNow = new Date();
        $('#dateForm').datetimepicker({
            locale: 'fr',
            format: 'DD-MM-YYYY HH:mm:[00]',
            maxDate: 'now',
            defaultDate: dateNow

        });
    });
</script>



<script>
    $(document).ready(function () {

        function getDayOfWeek(date) {
            var dayOfWeek = new Date(date).getDay();
            return isNaN(dayOfWeek) ? null : ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'][dayOfWeek];
        }

        $('#dateForm').on('dp.change', function (e) {

            $test = $('#dateForm').val();

            var fields = $test.split(' '); //console.log($test);
            var date = fields[0];

            var details = date.split('-');
            var jour = details[0];
            var mois = details[1];
            var annee = details[2];

            var heure = fields[1];
            var sep = heure.split(':');

            var toDate = annee + "-" + mois + "-" + jour;

            if (getDayOfWeek(toDate) === "Dimanche" || getDayOfWeek(toDate) === "Samedi") {
                document.getElementById("horaire").selectedIndex = 2;
            } else {
                if (sep[0] >= '16') {
                    document.getElementById("horaire").selectedIndex = 1;
                } else {
                    document.getElementById("horaire").selectedIndex = 0;
                }
            }
        });
    });
</script>    




