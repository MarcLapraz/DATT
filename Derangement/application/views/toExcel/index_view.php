<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
echo isset($_SESSION['auth_message']) ? $_SESSION['auth_message'] : FALSE;
$username = $this->session->userdata('username');
?>

<div> 
    <div class="container">
        <input class="form-control" id="myInput" type="text" placeholder="Search..">
    </div>

    <div>
        <button id = "status">Status</button>



    </div>



    <table class="table table-striped">
        <thead> 
            <tr>
                <th id="th_stat">Status</th> <th>Réf</th><th>Annonceur</th> <th>Tranche horaire</th> 
                <th>H.Déclaration</th><th>Région</th><th>Installation</th><th>Origine</th> 
                <th>Info client</th><th>Remarques</th><th>Quitance</th> <th>Materiel</th>
                <th>Intervenant</th><th>Tranche horaire</th><th>Constat</th> <th>Debut</th> <th>fin</th> <th>Durée inter.</th> <th>Durée panne</th> <th>Modifier</th>               
            </tr>
        </thead>
        <tbody id ="myBody">

            <?php foreach ($sql as $object) { ?>

                <tr> 
                    <td id ="td_stat"> <?php echo $object->stat; ?> </td> 
                    <td> <?php echo $object->panneNumero; ?> </td> 
                    <td> <?php echo $object->annonceur; ?> </td> 
                    <td> <?php echo $object->tranche; ?></td>
                    <td><?php echo $object->date_introduction_panne; ?></td>
                    <td><?php echo $object->region; ?></td>
                    <td><?php echo $object->installationLibelle; ?></td>
                    <td><?php echo $object->typepanneLibelle; ?></td>

                    <td><a href="#" title="<?php echo "info"; ?>" data-toggle="popover" data-trigger="focus" data-content="<?php echo $object->remarqueClient; ?>">Infos client</a></td>


                    <td><?php echo $object->panneDescription; ?></td>
                    <td><?php echo $object->quitanceLibelle; ?> </td>
                    <td><?php echo $object->listeMatos; ?></td>                  
                    <td><?php echo $object->user; ?> </td>   
                    <td><?php echo $object->tranche; ?></td> 
                    <td><?php echo $object->remarque; ?> </td>
                    <td><?php echo $object->debut; ?></td>  
                    <td><?php echo $object->fin; ?></td>  
                    <td><?php
                        $date1 = date_create($object->fin);
                        $date2 = date_create($object->debut);
                        $diff = date_diff($date1, $date2);
                        echo $diff->format("%D jour(s) %H:%I:%S");
                        ?>
                    </td>

                    <td><?php
                        $date3 = date_create($object->fin);
                        $date4 = date_create($object->date_introduction_panne);
                        $diff2 = date_diff($date3, $date4);
                        echo $diff2->format("%D jour(s) %H:%I:%S");
                        ?>
                    </td>

                    <td>

                        <button type="button" class="btn btn-default btn-sm">
                            <span class="glyphicon glyphicon-pencil"></span> 
                        </button>
                    </td>

                </tr>
            <?php } ?>


        </tbody>
    </table>
</div>


<script>
    //filtre 
    $(document).ready(function () {
        $("#myInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#myBody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover();
    });
</script>


<script>

    $(document).ready(function () {

    $("#status").click(function(){
        
        $("#td_stat").addClass("hidden");
        $("#th_stat").addClass("hidden");
        
    });




    });





</script>


