<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
echo isset($_SESSION['auth_message']) ? $_SESSION['auth_message'] : FALSE;
?>
<h1>Pannes classées</h1>

<div>
    <a class="toggle-vis" data-column="0">Status</a>
    <a class="toggle-vis" data-column="1">Réf.</a>
    <a class="toggle-vis" data-column="2">Annonceur</a>
    <a class="toggle-vis" data-column="3">t.h Déclaration</a>
    <a class="toggle-vis" data-column="4">H.Déclaration</a>
    <a class="toggle-vis" data-column="5">Région</a>
    <a class="toggle-vis" data-column="6">Install</a>
    <a class="toggle-vis" data-column="7">Origine</a>
    <a class="toggle-vis" data-column="8">Info.Client</a>

</div>


<table id="table" class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <td>Status</td><td>Réf.</td><td>InterNum</td><td>Annonceur</td>
            <td>t.h Déclaration</td><td>H.Déclaration</td><td>Région</td>
            <td>Install</td><td>Origine</td><td>Info.Client</td>
            <td>Quitance</td><td>Materiel</td><td>Intervenant</td>
            <td>t.h Intervention</td> <td>Debut</td><td>Fin</td>
            <td>durée</td><td>Durée panne</td><td>Remarque</td><td>Edition</td>
        </tr>
    </thead>
    <tbody></tbody>
</table>


<script>
    $(document).ready(function () {
        var table = $('#table').DataTable({
            "createdRow": function (row, data, dataIndex) {
                if (data[0] === `termine`) {
                    $(row).addClass('alert alert-success');
                } else {
                    $(row).addClass('alert alert-danger');
                }
            },
            dom: 'Bfrtip',
            buttons: 
                    [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
            "ajax": "PanneVisualisation/ajax_Pannes",
            "columnDefs": 
                    [
                        {
                        "targets": -1,
                        "data": null,
                        "defaultContent": '<button type="button" onclick="remarque(this);" class="btn btn-warning trig">Edit</button>'
                        },
                        {
                        "targets": [2],
                        "visible": false,
                        "searchable": false
                        }
                    ]
            });
        $('a.toggle-vis').on('click', function (e) {
            e.preventDefault();
            var column = table.column($(this).attr('data-column'));
            column.visible(!column.visible());
        });
    });
</script>


<script>
    function remarque(thisButton) {
        var table = $('#table').DataTable();
        var data2 = table.row($(thisButton).parents('tr')).data();
        console.log(data2);
    }
</script>    






<!--

<script>

    function remarque(thisButton) {

        var table = $('#table').DataTable();
        var data2 = table.row($(thisButton).parents('tr')).data();

        var toSend = data2[0];
        var data3 = new Array();
        data3.push({name: "pk", value: toSend});

        $.ajax({
            url: "/Derangement/PanneVisualisation/ajax_getRemarque",
            async: true,
            type: "POST",
            data: data3,
            dataType: "html",
            success: function (data) {

             var tabInterventionDetail = $('#tableInterventionDetails');
                tabInterventionDetail.empty();
                //Parser la réponse 
                var details = $.parseJSON(data);
                tabInterventionDetail.append('<thead><tr><th>Technicien</th><th>Remarque</th></tr></thead>');
                tabInterventionDetail.append('<tbody>');

                $.each(details, function (i, detail) {
                    // console.log(absences.stat);
                    tabInterventionDetail.append('<tr>'
                            + '<td>' + detail.username + '</td>'
                            + '<td>' + detail.remarque + '</td>'      
                            + '</tr>');
                });
                tabInterventionDetail.append('</tbody>');
                $("#myModal3").modal({backdrop: false});
 
 
 
 
            }
        });
     

    }

</script>    

!-->





































