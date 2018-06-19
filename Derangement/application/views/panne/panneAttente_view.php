<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container formUser">
    <?php
    echo isset($_SESSION['auth_message']) ? $_SESSION['auth_message'] : FALSE;
    ?>
    <h1>Pannes à traiter</h1>
    <table id="table" class="table table-striped">
        <tr>
            <th class = "hidden"> numero</th>
            <th>Quitancé par</th>
            <th>Installation</th>
            <th>Type de panne</th>
            <th>Date de déclaration</th>
            <th>Description</th>
            <th>Prendre en charge </th>
            <th>Action</th>
        </tr>  
        <?php
        var_dump($sql->result());


        foreach ($sql->result() as $object) {
            ?>	
            <tr>
                <td id ="numero" class = "num hidden"><?php echo $object->numero ?></td>
                <td>
                    <?php
                    if ($object->quitance == 'non') {
                        ?>
                        <a class ="btn btn-info btn-xs click " id="quitance" >Quitance </a>  
                        <?php
                    } else {
                        echo $object->userQuitance;
                    }
                    ?>
                </td>
                <td><?php echo $object->install ?></td>
                <td><?php echo $object->typepanne ?></td>
                <td><?php echo date("d.m.Y", strtotime($object->date_introduction_panne)) ?></td>
                <td>    
                    <a href="#" title="<?php echo $object->install; ?>" data-toggle="popover" data-trigger="focus" data-content="<?php echo $object->description; ?>">Description</a>
                </td>  
                <td>

                    <?php if ($object->quitance == 'oui' && $object->userCharge === null) { ?>
                        <button id="charge" class="charge btn btn-success btn-m ">Prendre en charge</button>
                        <?php
                    } if ($object->quitance == 'oui' && $object->userCharge != null) {
                        ?>
                        <button id="decharge" class="decharge btn btn-success btn-m"><?php echo $object->userCharge; ?></button>
                        <?php
                    }
                    ?>
                </td>
                <td> 
                    <?php
                    if ($object->quitance == 'non') {
                        ?>
                        <a class ="btn btn-success btn-m" id ="edit" href="<?php echo base_url(); ?>PanneEdit/editPanne/<?php echo $object->numero; ?>">Modifier </a>  	 

                        <a href = "javascript:if(confirm('confirmer la suppression'))
                           {document.location ='<?php echo base_url(); ?>/Panne/delete/<?php echo $object->numero; ?>'}" 
                           class = "btn btn-danger btn-m" >Supprimer </a>		              
                           <?php
                       }

                       if ($object->quitance == 'oui') {

                           if ($object->stat == 'en cours' && $object->intervention == 'non' && $object->userCharge != null) {
                               ?>  
                            <a class ="btn btn-success btn-m intervention" href="<?php echo base_url(); ?>Intervention/index/<?php echo $object->numero; ?>">Intervention </a>   
                            <?php
                        }
                        if ( $object->stat == 'en cours' && $object->intervention == 'oui' && $object->userCharge != null) {
                            ?>           
                            <a class ="btn btn-success btn-m " href="<?php echo base_url(); ?>Intervention/index/<?php echo $object->numero; ?>">Continuer  </a>   
                            <?php
                        }
                    }
                    ?>
                </td>
            </tr>				
            <?php
        }
        ?>
    </table>
</div>




<script type ="text/javascript">
    $(document).ready(function () {
        $(".click").click(function () {
            var $row = $(this).closest("tr");
            var $text = $row.find(".num").text();
            var ok = parseInt($text);
            $.ajax({
                url: "/Derangement/PanneEnAttente/ajax_Quitance",
                async: true,
                type: "POST",
                data: "numero=" + ok,
                dataType: "html",
                success: function (data) {

                    location.reload();

                    var edit = $row.find('#edit');
                    edit.addClass('hidden');

                    var supprimer = $row.find('#supprimer');
                    supprimer.addClass('hidden');

                    var quitance = $row.find('#quitance');
                    quitance.addClass('hidden');
                }
            });
        });
    });
</script>


<script type="text/javascript">

    $(document).ready(function () {
        $(".charge").click(function () {
            var $row = $(this).closest("tr");
            var $text = $row.find(".num").text();
            var ok = parseInt($text);
            $.ajax({
                url: "/Derangement/PanneEnAttente/ajax_Charge",
                async: true,
                type: "POST",
                data: "numero=" + ok,
                dataType: "html",
                success: function (data) {

                    location.reload();

                    var edit = $row.find('.test');
                    // edit.addClass('hidden');

                }
            });
        });

    });
</script>


<script type="text/javascript">

    $(document).ready(function () {
        $(".decharge").click(function () {
            var $row = $(this).closest("tr");
            var $text = $row.find(".num").text();
            var ok = parseInt($text);
            $.ajax({
                url: "/Derangement/PanneEnAttente/ajax_Decharge",
                async: true,
                type: "POST",
                data: "numero=" + ok,
                dataType: "html",
                success: function (data) {

                    location.reload();

                    //var edit = $row.find('.test');
                    //edit.addClass('hidden');

                }
            });
        });

    });
</script>










<script type ="text/javascript">
    $(document).ready(function () {
        $(".intervention").click(function () {
            var $row = $(this).closest("tr");
            var $text = $row.find(".num").text();
            var ok = parseInt($text);
            $.ajax({
                url: "/Derangement/PanneEnAttente/ajax_Intervention",
                async: true,
                type: "POST",
                data: "numero=" + ok,
                dataType: "html",
                success: function (data) {


                },

                done: function (data) {

                    // l'idéal serait de faire le redirect ici...


                }
            });
        });
    });
</script>


<script>

    function deleteAjax() {
        alert('Confimer la suppresion de la panne');
        $.ajax({
            url: "/Derangement/Panne/ajax_deletePanne",
            async: true,
            type: "POST",
            data: "numero: " + numero,
            dataType: "html",
            complete: function (data) {
                alert('La panne est effacée');

            },
            fail: function (data) {
                alert('oups il y a un problème de connexion');

            }
        });
    }
</script>


<script>
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover();
    });
</script>




