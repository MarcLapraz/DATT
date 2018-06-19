<!DOCTYPE html>
<html>
    <head>
        <title>Visualisation des pannes</title>
        <script type = "text/javascript" src ="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="http://maps.google.com/maps/api/js"></script>
        <script src="assets/JS/gmaps/gmaps.js"></script>
        <style type="text/css">
            #map {
                width: 900px;
                height: 600px;
            }
        </style>
    </head>
    <body>

        <button id="check" type="button" class="form-control">Click Me!</button>

        <div id="map"></div>

        <script type ="text/javascript">
            $(document).ready(function () {

                map = new GMaps({
                    div: '#map',
                    lat: 47.0025861,
                    lng: 6.847791
                });
                //Listener sur le boutton		
                $('#check').click(function () {

                    $.ajax({
                        url: "/Derangement/Carte/ajaxTest",
                        async: true,
                        type: "POST",
                        dataType: "html",
                        success: function (data) {
                            
                            console.log(data);
                            
                            
                            var json = $.parseJSON(data);
                            var pannes = json.Panne;
                            $.each(pannes, function (i, panne) {
                                map.addMarker({
                                    lat: panne.coordonneX,
                                    lng: panne.coordonneY,
                                    title: 'Lima',
                                    infoWindow: {
                                        content: '<p>HTML Content</p>'
                                    }
                                });
                            });
                        }
                    });
                });
            }
            );

        </script>
    </body>
</html>