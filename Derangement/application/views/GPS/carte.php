<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
    <?php
    echo isset($_SESSION['auth_message']) ? $_SESSION['auth_message'] : FALSE;
    $username = $this->session->userdata('username');
    ?>

    <p>Rechercher les machines en fonction de votre position GPS</p>

    <button id="check" onclick = "getLocalisation();" type="button">LOCALISATION GPS</button>

    <div> 
        <table class="table table-striped">
            <thead> 
                <tr>
                    <th>Numero</th> <th>Machine</th> <th>Prendre en charge</th>              
                </tr>
            </thead>
            <tbody id ="myBody"></tbody>
        </table>
    </div>
</div>




<script type="text/javascript">

    function getLocalisation() {
        navigator.geolocation.getCurrentPosition(function (location) {

            var latitude = location.coords.latitude;
            var longitude = location.coords.longitude;
            var toData = {latitude: latitude, longitude: longitude};
            $.ajax({
                url: "/Derangement/GPS/getClosestMachine",
                async: true,
                type: "POST",
                data: toData,
                dataType: "html",
                success: function (data) {
                    var table = document.getElementById("myBody");
                    var installations = $.parseJSON(data);

                    $.each(installations, function (i, install) {
                        var row = table.insertRow(0);
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);
                        cell1.innerHTML = install.numero;
                        cell1.className = 'nr';
                        cell2.innerHTML = install.libelle;
                        cell3.innerHTML = '<button type="button" onclick="test(this);">Use</button>';
                    });
                }
            });
        });
    }

</script>


<script type="text/javascript">

    function test(button) {
        var id = $(button).closest("tr").find(".nr").text();
        $.ajax({
            url: "/Derangement/GPS/ajaxSavePanneQuitance",
            async: true,
            type: "POST",
            data: "id=" + id,
            dataType: "html",
            success: function (data) {
                //redirection 
                window.location.replace("");
            }
        });
    }
</script>    

