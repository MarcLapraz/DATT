<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container formUser">
    <?php
    echo isset($_SESSION['auth_message']) ? $_SESSION['auth_message'] : FALSE;

    // var_dump($typepanne);
    // var_dump($installations);
    ?>
    <h1>Recherche informations automate</h1>
    <form class="form-horizontal" id="form" method="POST">
        <fieldset>
            <div class="form-group">
                <label class="col-md-4 control-label" for="nom">nom</label>
                <div class="col-md-4">
                    <?php
                    echo form_dropdown('installation', $AllInstallations, 'large', 'class="form-control" id="drop"') . '<br/>';
                    ?>
                </div>
            </div>
            <div style="text-align: center" class="form-group">
                <button id="recherche"  class="btn btn-info btn-circle btn-lg"><i class="glyphicon glyphicon-ok"></i></button>
            </div>
        </fieldset>
    </form>

    <div class="col-md-4" id="info"></div>

    <div  class="col-md-8" id="info33"> 
        <table  id="tableAbsences" class="table table-striped"></table>
    </div>

    <div id="materielChange"></div>

    <div id='tableauAbsencesLeAppendNestPasLa' class="container"></div>

    <div id="some_modal" class="modal modal-fixed-footer">
        <div class="modal-content"></div>
    </div>


</div>

<div class="container">

    <!-- Modal -->
    <div class="modal fade" id="myModal2" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Liste interventions sur la panne</h4>
                </div>
                <div class="modal-body" id="coucou">

                    <table id="tableIntervention" class="table table-bordered"></table> <!--La fin de la table est dans la requête ajax  -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>

        </div>
    </div>


</div>


<div class="container">

    <!-- Modal -->
    <div class="modal fade" id="myModal3" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Detail intervention</h4>
                </div>
                <div class="modal-body" id="coucou">

                    <table id="tableInterventionDetails" class="table table-bordered"></table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>

        </div>
    </div>


</div>





<script>
    $(document).ready(function () {

        $("#myBtn2").click(function () {
            $("#myModal2").modal({backdrop: false});

        });

    });
</script>





<script type="text/javascript">
    $(document).ready(function () {
        $("#recherche").on("click", function (e) {
            e.preventDefault();
            var formArray = $("form").serializeArray();
            //  console.log(formArray);
            $.ajax({
                url: "/Derangement/recherche/ajax_recherche",
                async: true,
                type: "POST",
                data: formArray,
                dataType: "text",
                success: function (data) {
                    var install = $.parseJSON(data);
                    var infoDiv = $('#info');
                           
                    infoDiv.empty();
            
                    infoDiv.append('<div class="col-md"> <div> \n\
                                    <label>ID :</label> <input value="' + install[0].id + '" class="form-control input-sm" readonly />\n\
                                    </div> \n\
                                    <div>\n\
                                    <label>Region :</label> <input value="' + install[0].regionLib + '" class="form-control input-sm" readonly /> \n\
                                    </div> \n\
                                    <div>\n\
                                    <label>Print Oblitérateur : </label> <input value="' + install[0].print + '" class="form-control input-sm" readonly />\n\
                                    </div>\n\
                                    <div>\n\
                                    <label>Numero routeur :</label> <input value="' + install[0].routeur + '" class="form-control input-sm" readonly />\n\
                                    </div>\n\
                                    <div>\n\
                                    <label>Adresse ip :</label> <input value="' + install[0].ip + '" class="form-control input-sm" readonly /> \n\
                                    </div>\n\
                                    <div> \n\
                                    <label>Mot de passe :</label> <input value="' + install[0].mdp + '" class="form-control input-sm" readonly />\n\
                                    </div>\n\
                                    <div>\n\
                                    <label>Numero de téléphone :</label> <input value="' + install[0].phone + '" class="form-control input-sm" readonly /> \n\
                                    </div>\n\
                                    <div>\n\
                                    <label>Numero de pin :</label> <input value="' + install[0].pin + '" class="form-control input-sm" readonly /> \n\
                                    </div></br><div style="text-align: center" ><button id="details" onclick="data();" type="button" class="btn btn-info">Voir les pannes</button></div> </div>');
                }
            });
        });
    });
</script>







<script type="text/javascript">
    function data() {
        var formArray = $("form").serializeArray();
        $.ajax({
            url: "/Derangement/Recherche/ajax_getPanneByNumero",
            async: true,
            type: "POST",
            data: formArray,
            dataType: "text",
            success: function (data) {
                var tab = $('#tableAbsences');
                tab.empty();
                //Parser la réponse 
                var pannes = $.parseJSON(data);
                tab.append('<thead><tr><th class="hidden">Numero</th><th class="hidden">Status</th><th>Date debut</th><th>Date fin</th><th>Type panne</th><th>Details</th></tr></thead>');
                tab.append('<tbody>');
                $.each(pannes, function (i, panne) {
                    // console.log(absences.stat);
                    if (panne.stat == "termine") {
                        var to = '<tr class="success">';
                    }
                    if (panne.stat == "en cours") {
                        var to = '<tr class="warning">';
                    }
                    if (panne.stat == "en attente") {
                        var to = '<tr class="danger">';
                    }
                    tab.append(to + '<td class="pk hidden">' + panne.numero + '</td>'
                            + '<td class="hidden">' + panne.stat + '</td>'
                            + '<td>' + panne.date_introduction_panne + '</td>'
                            + '<td>' + panne.date_fin_panne + '</td>'
                            + '<td>' + panne.libelle + '</td>'
                            + '<td> <button type="button" class="btn btn-info btn-md detail" onclick="test(this);" id="myBtn2">Details</button></td>'
                            + '</tr>');
                });
                tab.append('</tbody>');
            }
        });
    }
</script>





<script type="text/javascript">
    function test(thisBtn) {

        var row = $(thisBtn).parent().parent();
        var numeroPK = row[0].cells[0].innerText;
        var data = $("form").serializeArray();
        data.push({name: "pk", value: numeroPK});
        $.ajax({
            url: "/Derangement/Recherche/ajaxGetDetailIntervention",
            async: true,
            type: "POST",
            data: data,
            dataType: "text",
            success: function (data) {
                var tabIntervention = $('#tableIntervention');
                tabIntervention.empty();
                //Parser la réponse 
                var interventions = $.parseJSON(data);
                tabIntervention.append('<thead><tr><th class="hidden">Numero</th><th>Technicien</th><th>Debut intervention</th><th>fin_intervention</th><th>Remarque</th><th>details</th></tr></thead>');
                tabIntervention.append('<tbody>');

                $.each(interventions, function (i, intervention) {
                    // console.log(absences.stat);

                    tabIntervention.append('<tr>'
                            + '<td class="hidden">' + intervention.numero + '</td>'
                            + '<td>' + intervention.username + '</td>'
                            + '<td>' + intervention.debut_intervention + '</td>'
                            + '<td>' + intervention.fin_intervention + '</td>'
                            + '<td>  <a onclick="b();" href="#" title="title" data-toggle="popover2" data-trigger="focus" data-content=" ' + intervention.remarque + ' ">Description</a> </td>'
                            + '<td><button type="button" class="btn btn-info btn-md detail" onclick="test2(this);" id="myBtn2">Details</button></td>'
                            + '</tr>');
                });
                tabIntervention.append('</tbody>');
                $("#myModal2").modal({backdrop: false});
            }
        });
    }
</script>


<script type="text/javascript">
    function test2(thisSelectTest2) {

        var row = $(thisSelectTest2).parent().parent();
        var numeroPK2 = row[0].cells[0].innerText;

        var data1 = new Array();
        data1.push({name: "numero", value: numeroPK2});

        $.ajax({
            url: "/Derangement/Recherche/ajaxGetDetailDetails",
            async: true,
            type: "POST",
            data: data1,
            dataType: "text",
            success: function (data) {
                var tabInterventionDetail = $('#tableInterventionDetails');
                tabInterventionDetail.empty();
                //Parser la réponse 
                var details = $.parseJSON(data);
                tabInterventionDetail.append('<thead><tr><th>Username</th><th>Materiel</th><th>Ancien numero</th><th>Nouveau numero</th><th>Libelle</th><th>Remarque</th></tr></thead>');
                tabInterventionDetail.append('<tbody>');

                $.each(details, function (i, detail) {
                    // console.log(absences.stat);
                    tabInterventionDetail.append('<tr>'
                            + '<td>' + detail.username + '</td>'
                            + '<td>' + detail.libelle + '</td>'
                            + '<td>' + detail.ancienNumeroSerie + '</td>'
                            + '<td>' + detail.nouveauNumeroSerie + '</td>'
                            + '<td> <a onclick="a();" href="#" title="title" data-toggle="popover" data-trigger="focus" data-content=" ' + detail.remarque + ' ">Description</a></td>'
                            + '<td>' + detail.action + '</td>'
                            + '</tr>');
                });
                tabInterventionDetail.append('</tbody>');
                $("#myModal3").modal({backdrop: false});
            }
        });
    }
</script>


<script type="text/javascript">
    function a() {
        $('[data-toggle="popover"]').popover();
    }
</script>



<script type="text/javascript">
    function b() {
        $('[data-toggle="popover2"]').popover();
    }
</script>