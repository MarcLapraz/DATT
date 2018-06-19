<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
    <?php
    echo isset($_SESSION['auth_message']) ? $_SESSION['auth_message'] : FALSE;
    ?>
    <h1>Recherche pannes par automate</h1>

    <form class="form-horizontal">
        <fieldset>
 
            <legend>Recherche mutli-critères</legend>
       
            <div class="form-group">
                <label class="col-md-4 control-label" for="IDRecherche">Recherche par ID</label>  
                <div class="col-md-4">
                    <input id="IDRecherche" name="IDRecherche" type="text" placeholder="ID" class="form-control input-md">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="nameRecherche">Recherche par nom d'arrêt</label>
                <div class="col-md-4">

                    <?php
                    echo form_dropdown('type_panne', $installations, 'large', 'class="form-control"');
                    ?>

                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="panneRecherche">Recherche par cause de panne</label>
                <div class="col-md-4">
                    <select id="panneRecherche" name="panneRecherche" class="form-control">
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="rechercheButton">Rechercher </label>
                <div class="col-md-4">
                    <button id="rechercheButton" name="rechercheButton" class="btn btn-primary">Valider</button>
                </div>
            </div>

           
            <label for="installation">Installation:</label>
            <div  id='installation' class="ui search selection dropdown fluid">
                <input name="installation" type="hidden">
                <i class="dropdown icon"></i>
                <div class="default text">Choix installation</div>
                <div id ="menu" class="menu"> </div>
            </div>
            <br/>

        </fieldset>
    </form>
</div>




<script type ="text/javascript">
    $(document).ready(function () {
        //Listener sur le region-dropdown		
        //  $('#region_dropdown select').change(function () {
        //  var selRegion = $(this).val();
        //console.log(selRegion);
        $.ajax({
            url: "/Derangement/Panne/recherche",
            async: false,
            type: "POST",
            data: "",
            dataType: "html",
            success: function (data) {

                console.log(data);


                var dropdownInstallation = $('#menu');
                dropdownInstallation.empty();
                var installations = $.parseJSON(data);
                $.each(installations, function (i, install) {
                    dropdownInstallation.append('<div class="item fluid" style="font-size: 25px" data-value= "' + install.installationNumero + '">' + install.installationLibelle + '</div>');
                });
            }
        });
        //  });

    });
</script>