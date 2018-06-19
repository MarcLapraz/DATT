<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
    <?php
    echo isset($_SESSION['auth_message']) ? $_SESSION['auth_message'] : FALSE;
    $username = $this->session->userdata('username');
    ?>

    <?php
    echo validation_errors();
    foreach ($sql->result() as $obj) {
        $dateIntro = $obj->panneIntroduction;
        $numero = $obj->numero;
        $description = $obj->description;
        $typePanneNum = $obj->typepanneNumero;
        $date = $obj->date_declaration_panne;
        $newDate = date("d-m-Y h:i", strtotime($date));
        $tranchehoraireNumero = $obj->tranchehoraireNumero;
        $regionNum = $obj->installationRegionNumero;
        $panneInstall = $obj->panneInstallation;
    }
    ?>
    <div class = "row">
        <div class="column" style="background-color:#aaa;">
            <h1>Modifier la panne</h1>
            <?php
            echo form_open('Panne/updatePanne');
            ?>
            <input type="hidden" name="numero" value="<?php echo $numero ?>"> 

            <label>Date introduction : </label>
            <input type='text'  class="form-control" id='dateForm' value='<?php echo $dateIntro; ?>' name="dateFrom" readonly/></br>

            <?php
            echo form_label('Date effective de la panne:', 'date') . '<br />';
            ?>
            <div class='input-group date' id='datetimepicker2'>
                <input type='text' class="form-control" id='dateForm' value='<?php echo $newDate; ?>' name="dateFrom"/></br>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>

            <br/>
            <?php
            echo form_label('Tranche horaire:', 'tranche_horaire') . '<br/>';
            echo form_dropdown('tranche_horaire', $AllHoraires, $tranchehoraireNumero, 'class="form-control"') . '<br/>';
            ?>
            <div id ='region_dropdown'>
                <?php
                $attribut = 'id="region"  class="form-control"';
                echo form_label('Région:', 'region') . '<br/>';
                echo form_dropdown('region', $AllRegions, $regionNum, $attribut) . '<br/>';
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
            echo form_dropdown('type_panne', $AllTypesPannes, $typePanneNum, 'class="form-control"') . '<br/>';

            echo form_label('Description de la panne:', 'description_panne') . '<br />';
            echo form_textarea('description_panne', $description, 'readOnly class="form-control"') . '<br/>';
            ?>

        </div>
        <div class="column" style="background-color:#bbb;">
            <h1>Informations client</h1>

            <?php
            echo form_label('Information client:', 'clientInformation') . '<br />';
            echo form_textarea('clientInformation', set_value('clientInformation'), 'class="form-control"') . '<br/>';
            ?>

        </div>

        <div style="text-align: center">
            <button type="submit" class="btn btn-info btn-circle btn-lg"><i class="glyphicon glyphicon-ok"></i></button>
        </div>

        <?php
        echo form_close();
        ?>
    </div>
</div>


<script type ="text/javascript">
    $(document).ready(function () {
        $('#region_dropdown select').change(function () {
            var selRegion = $(this).val();
            $.ajax({
                url: "/Derangement/Panne/ajax_getInstallation",
                async: false,
                type: "POST",
                data: "installationNumRegion=" + selRegion,
                dataType: "html",
                success: function (data) {
                    var dropdownInstallation = $('#menu');
                    dropdownInstallation.empty();
                    var installations = $.parseJSON(data);
                    $.each(installations, function (i, install) {
                        dropdownInstallation.append('<div class="item fluid" style="font-size: 25px" data-value= "' + install.installationNumero + '">' + install.installationLibelle + '</div>');
                    });
                }
            });
        });
        $('#region_dropdown select').trigger('change');
        $('#installation').dropdown('set selected', <?php echo $panneInstall ?>);
    });
</script>


<script type="text/javascript">
    $(function () {
        $('#datetimepicker2').datetimepicker({
            locale: 'fr',
            format: 'DD-MM-YYYY HH:mm:[00]',
            maxDate: 'now'
        });
    });
</script>




