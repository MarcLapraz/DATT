<!--Merci de regarder le contenu du controller controllers/intervention.php function index. Les variables disponibles sont visibles sur ce fichier -->

<div class="container">
    <div class="row">
        <div class="col-xs-6 formUser">
            <br/>

            <?php
            foreach ($sql->result() as $object) {
                $libelle = $object->libelle;
                $description = $object->description;
                $installationNumero = $object->installationNumero;
                $date = $object->panneDate;
                $typepanne = $object->type_panne;
            }
            ?>

            <button id = "full">FullScreen</button>
            <div style="text-align: center">
                <div class="form-group">                  
                    <input type="text" class="form-control" id="libelle" value="Nom de l'installation :  <?php echo $libelle ?>" readonly>            
                    <input type="text" class="form-control" id="description" value="Description : <?php echo $description ?>" readonly> 

                    <input type="text" class="form-control" id="datePanne" value="Date de la panne : <?php echo $date ?>" readonly>
                    <input type="text" class="form-control" id="tranche_horaire" value="Tranche horaire : <?php echo $tranche ?>" readonly>
                    <input type="text" class="form-control" id="typepanne" value="Type de panne : <?php echo $typepanne ?>" readonly>

                    <div id="liste"> </div>

                </div>           

                <button type="button" id="start" class="btn btn-primary btn-round btn-lg">START</button>   
            </div>

            <form id="formMatos" name="formMatos" class="form-horizontal" method="POST"></form><br/>

            <div class="form-group">
                <label for="comment">Remarques:</label>
                <textarea class="form-control"  placeholder="Le commentaire est enregistré lors de la cloture de la panne !" rows="5" id="comment"></textarea>
            </div>
            <div  style="text-align: center">
                <button id="end" type="button" class="btn btn-danger hidden">Fin de l'intervention</button>
            </div>

            <div style="text-align: center" >
                <div class="col-xs-6">
                    <!-- <button id="resolu" type="button" class="btn btn-success btn-lg btn-block btn-huge hidden">Machine fonctionelle</button> -->
                    <a id="resolu" class ="btn btn-success btn-lg btn-block btn-huge hidden" href="<?php echo base_url(); ?>Dashboard">Machine fonctionelle  </a>  

                </div>    
                <div class="col-xs-6">  
                    <!-- <button id="nonresolu" type="button" class="btn btn-danger btn-lg btn-block btn-huge hidden">Machine en panne</button> -->
                    <a id="nonresolu" class ="btn btn-danger btn-lg btn-block btn-huge hidden" href="<?php echo base_url(); ?>Dashboard">Machine en panne  </a> 
                </div>
            </div>
        </div>

        <div id="imageClick" class="col-xs-6 testHover">
            <img id="ima" src="<?php echo base_url(); ?>assets/images/201point.jpg" usemap="#image-map" >
            <map name="image-map">

                <!--Mapping click et image automate l'id de la zone = numero de la categorie matérielle
                    l'attribut href doit être présent mais n'est pas utilisé 
                -->
                <area  id="1"  alt="éclairage" title="1"   class="zoneClick"  href="test" coords="573,162,29" shape="circle"> <!--éclairage  -->
                <area  id="2"  alt="ordinateur" title="2"   class="zoneClick"  href="test" coords="482,255,29" shape="circle"> <!--ordinateur  -->
                <area  id="3"  alt="hopper" title="3"   class="zoneClick"  href="test" coords="633,269,29" shape="circle"> <!--hopper  -->
                <area  id="4"  alt="cartes" title="4"   class="zoneClick"  href="test" coords="585,397,30" shape="circle"> <!--cartes zgva +  Alim -->         
                <area  id="5"  alt="Impression" title="5"   class="zoneClick"  href="test" coords="505,627,29" shape="circle"> <!--Impression  -->
                <area  id="6"  alt="obli" title="6"   class="zoneClick"  href="test" coords="831,529,29" shape="circle"> <!--obli  -->
                <area  id="7"  alt="écran" title="7"   class="zoneClick"  href="test" coords="320,438,34" shape="circle"> <!--écran & dalle  -->
                <area  id="8"  alt="routeur" title="8"   class="zoneClick"  href="test" coords="446,412,29" shape="circle"> <!--routeur -->
                <area  id="9"  alt="carteC" title="9"   class="zoneClick"  href="test" coords="117,442,29" shape="circle"> <!--carte crédit  -->
                <area  id="10" alt="vente" title="10" class="zoneClick"  href="test" coords="615,516,30" shape="circle"> <!--system vente  -->
                <area  id="11" alt="éclairage" title="11" class="zoneClick"  href="test" coords="611,746,31" shape="circle"> <!--éclairage  -->
                <area  id="12" alt="bna" title="12" class="zoneClick"  href="test" coords="707,614,36" shape="circle"> <!--bna  -->
                <area  id="13" alt="badge" title="13" class="zoneClick"  href="test" coords="547,865,31" shape="circle"> <!--caisse badge caisse  -->
                <area  id="14" alt="pavé" title="14" class="zoneClick"  href="test" coords="193,590,27" shape="circle"> <!--pavé numérique  -->
                <area  id="15" alt="Sortie" title="15" class="zoneClick"  href="test" coords="290,730,32" shape="circle"> <!--Sortie billet  -->

            </map>       
            <div id="inner-box">
                <p>Pour commencer l'intervention, pressez START ! </p>
            </div>
        </div>
    </div>
</div>    


<script type="text/javascript">
    $(document).ready(function (e) {
        $('img[usemap]').rwdImageMaps();
    });
</script>

<script>
    $(document).ready(function (e) {
        window.onbeforeunload = function (event) {
            var message = 'Sure you want to leave?';
            if (typeof event === 'undefined') {
                event = window.event;
            }
            if (event) {
                event.returnValue = message;
            }
            return message;
        };
    });
</script>


<script>
    //full screen method
function launchIntoFullscreen(element) {
  if(element.requestFullscreen) {
    element.requestFullscreen();
  } else if(element.mozRequestFullScreen) {
    element.mozRequestFullScreen();
  } else if(element.webkitRequestFullscreen) {
    element.webkitRequestFullscreen();
  } else if(element.msRequestFullscreen) {
    element.msRequestFullscreen();
  }
}
</script>

<script>
    //full screen trigger
    $(document).ready(function () {  
        $("#full").on("click", function(e){
        launchIntoFullscreen(document.documentElement); // the whole page
        
    });
   });
</script>



<script type="text/javascript">
    $(document).ready(function () {
        $(".zoneClick").on("click", function (e) {
            e.preventDefault();
            var numeroCategorie = this.id;
            $.ajax({
                url: "/Derangement/Intervention/getMaterielAjax",
                async: true,
                type: "POST",
                data: "numero= " + numeroCategorie,
                dataType: "text",
                success: function (data) {
                    //  var tabMateriel = $('#formMateriel');
                    $('#formMatos').empty();
                    var ArrayMateriel = JSON.parse(data);
                    var formDiv = $('#formMatos');
                    formDiv.append(
                            '<fieldset>' +
                            '<legend>Materiel </legend>' +
                            '<div class="form-group">' +
                            '<label class="col-md-4 control-label" for="selectbasic">Article</label>' +
                            '<div class="col-md-4" id="sel">' +
                            '<select id="articleID" name="select_article" class="form-control"></select>' +
                            '</div>' +
                            ' </div>' +
                            '<div class="form-group">' +
                            '<label class="col-md-4 control-label" for="radios">Action</label>' +
                            '<div class="col-md-4">' +
                            '<div class="radio">' +
                            '<label for="radios-0">' +
                            '<input type="radio" name="radios" id="radios-0" value="remplace" checked="checked" onclick="OnChangeRadio(this)">Remplacé' +
                            '</label>' +
                            '</div>' +
                            '<div class="radio">' +
                            '<label for="radios-1">' +
                            '<input type="radio" name="radios" id="radios-1" value="change" onclick="OnChangeRadio(this)">Changé' +
                            '</label>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label id="lab1" class="col-md-4 control-label hidden" for="textinput">Nouveau numéro de série</label><div class="col-md-4">' +
                            '<input id="textinput1" name="ancienNumeroSerie" type="text" placeholder="nouveau numéro" class="form-control input-md hidden">' +
                            '</div>' +
                            '</div>' +
                            ' <div class="form-group">' +
                            '<label id="lab2" class="col-md-4 control-label hidden" for="textinput">Ancien numéro de série</label><div class="col-md-4">' +
                            ' <input id="textinput2" name="nouveauNumeroSerie" type="text" placeholder="ancien numéro" class="form-control input-md hidden">' +
                            ' </div>' +
                            ' </div>' +
                            '<div class="form-group">' +
                            '<label class="col-md-4 control-label" for="singlebutton"></label>' +
                            '<div class="col-md-4">' +
                            ' <input type="button"  name="singlebutton" class="btn btn-inverse" data-toggle="collapse" data-target="#demo" value="Ajouter une remarque">' +
                            ' </div>' +
                            '</div>' +
                            '<div id="demo" class="collapse">' +
                            '<div class="form-group">' +
                            '<label class="col-md-4 control-label" for="textarea">Remarques</label>' +
                            '<div class="col-md-5">' +
                            '<textarea class="form-control" rows="5" name="remarque"></textarea>' +
                            '</div>' +
                            '</div>' +
                            ' </div>' +
                            '<div class="form-group">' +
                            '<label class="col-md-4 control-label" for="button1id">Terminer</label>' +
                            '<div class="col-md-8">' +
                            '<button id="button1id" name="button1id" type="button" class="btn btn-success" onclick="burritos();">Sauver</button>' +
                            '<button id="button2id" name="button2id" class="btn btn-danger">Annuler</button>' +
                            ' </div>' +
                            ' </div>' +
                            '</fieldset>'
                            );
                    var $select = $('#articleID');
                    $.each(ArrayMateriel, function (key, value) {
                        $select.append('<option value=' + value.materielNumero + '>' + value.materielLibelle + '</option>');
                    });
                    //$select.removeClass("test");
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#start").on("click", function (e) {
            var element = document.getElementById("inner-box");
            element.outerHTML = "";
            delete element;
            $('#imageClick').removeClass('testHover');
            e.preventDefault();
            $('#ima').removeClass('hidden');
            var myvar = <?php echo json_encode($pkPanne); ?>;
            var tranche = <?php echo json_encode($tranche_pk); ?>;

            var data = new Array();
            data.push({name: "numero", value: myvar});
            data.push({name: "tranche", value: tranche});


            $.ajax({
                url: "/Derangement/Intervention/saveInterventionAjax",
                async: true,
                type: "POST",
                data: data,
                dataType: "text",
                success: function (data) {
                    $("#start").addClass('hidden');
                    //$("#imageClick").removeClass('hidden');
                    $("#end").removeClass('hidden');
                    var arrayPkIntervention = $.parseJSON(data);
                    var pkIntervention = arrayPkIntervention.pkIntervention;
                    window.pkii = pkIntervention;
                    // console.log("what?" + window.pkii);
                },
                fail: function (data) {

                    alert("oups... il y a un problème de connexion");
                }
            });
        });
    });</script>    

<script type="text/javascript">
    $(document).ready(function () {
        $("#end").on("click", function (e) {
            e.preventDefault();
            var myvar = window.pkii;
            $.ajax({
                url: "/Derangement/Intervention/closeInterventionAjax",
                async: true,
                type: "POST",
                data: "numero=" + myvar,
                dataType: "text",
                success: function (data) {

                    $("#end").addClass('hidden');
                    $("#start").addClass('hidden');
                    $("#resolu").removeClass('hidden');
                    $("#nonresolu").removeClass('hidden');
                },
                fail: function () {
                    alert("oups.. impossible de cloturer l'intervention");
                }

            });
        });
    });</script>  

<script type="text/javascript">
    function OnChangeRadio(radio) {
        if (radio.value === 'change') {
            $('#textinput1').removeClass('hidden');
            $('#textinput2').removeClass('hidden');
            $('#lab1').removeClass('hidden');
            $('#lab2').removeClass('hidden');
        } else {
            $('#textinput1').addClass('hidden');
            $('#textinput2').addClass('hidden');
            $('#textinput1').val('');
            $('#textinput2').val('');
            $('#lab1').addClass('hidden');
            $('#lab2').addClass('hidden');
        }
    }
</script>

<script>

    function functionOK() {
        alert("Cet élément est enregistré");
    }

</script>


<script>

    function functionKO() {
        alert("OUPS il y a un problème de connexion");
    }

</script>



<script type="text/javascript">
    function burritos() {
        var myvar = window.pkii;
        var data = $("form").serializeArray();
        data.push({name: "pk", value: myvar});
        var materielName = ($('#articleID option:selected').text());
        var materielID = ($('#articleID option:selected').val());
        data.push({name: "matosName", value: materielName});
        $("form").empty();
        $.ajax({
            url: "/Derangement/Intervention/saveMaterielAjax",
            async: true,
            type: "POST",
            data: data,
            dataType: "json",
            complete: function (data) {
                alert("L'élément est enregistré ! ");
                var listeElement = $('#liste');
                listeElement.append(
                        '<button  type="button" name=' + materielName + ' id=' + materielID + ' class="btn btn-outline-dark" onclick="deleteComposant(this);">' + materielName + '</button>&nbsp;'
                        );
            },
            failure: function (e) {
                alert("Oups.. Il y a une problème de connexion", e.toString());
            }
        });
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#resolu").on("click", function (e) {
            e.preventDefault();
            var myvar = <?php echo json_encode($pkPanne); ?>;
            var remarque = $("#comment").val();
            var data = new Array();
            data.push({name: "pkPanne", value: myvar});
            data.push({name: "interventionNumero", value: window.pkii});
            data.push({name: "remarque", value: remarque});
            $.ajax({
                url: "/Derangement/Intervention/resoluAjax",
                async: true,
                type: "POST",
                data: data,
                dataType: "text",
                success: function (data) {},

                //il faut attendre le cycle complet -> complete

                complete: function (data) {
                    alert("La panne est résolue et enregistrée ! ");

                    window.location.replace("<?php base_url(); ?>/Derangement/dashboard");

                },
                fail: function (data) {
                    alert("oups.. problème de connexion");
                    window.location.replace("<?php base_url(); ?>/Derangement/dashboard");
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#nonresolu").on("click", function (e) {
            e.preventDefault();
            var remarque = $("#comment").val();
            var data = new Array();
            data.push({name: "interventionNumero", value: window.pkii});
            data.push({name: "remarque", value: remarque});
            $.ajax({
                url: "/Derangement/Intervention/nonresoluAjax",
                async: true,
                type: "POST",
                data: data,
                dataType: "text",
                success: function (data) {
                    //il faut attendre le cycle complet -> complete
                },

                complete: function (data) {
                    alert("La panne est non résolue et enregistrée ! ");
                    window.location.replace("<?php base_url(); ?>/Derangement/dashboard");

                },

                fail: function (data) {
                    window.location.replace("<?php base_url(); ?>/Derangement/dashboard");

                }
            });
        });
    });
</script>


<script>
    function deleteComposant(that) {

        var data = new Array();
        data.push({name: "interventionNumero", value: window.pkii});
        data.push({name: "materielID", value: that.id});

        $.ajax({
            url: "/Derangement/Intervention/deleteComposantAjax",
            async: true,
            type: "POST",
            data: data,
            dataType: "json",
            complete: function (data) {
                alert("okay ! les composant est supprimé de l'intervention");
                var element = document.getElementById(that.id);
                element.outerHTML = "";
                delete element;

            },
            failure: function (e) {
                alert("Oups.. Il y a une problème de connexion", e.toString());
            }
        });
    }
</script>






