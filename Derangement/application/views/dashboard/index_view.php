<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="sky" class="container">
    <?php $username = $this->session->userdata('username'); ?>
    <h1> Bonjour <?php echo $username ?> </h1>

    
      <p>
        <button type="button" onclick="zoomin()"> Zoom In</button>
        <button type="button" onclick="zoomout()"> Zoom Out</button>
    </p>
    
    
    
    <img  id ="sky22" src="<?php echo base_url(); ?>/assets/images/plan.jpg" alt="" />


    









</div>

<script>

 function zoomin(){
        var myImg = document.getElementById("sky");
        var currWidth = myImg.clientWidth;
        if(currWidth == 500){
            alert("Maximum zoom-in level reached.");
        } else{
            myImg.style.width = (currWidth + 50) + "px";
        } 
    }
    function zoomout(){
        var myImg = document.getElementById("sky");
        var currWidth = myImg.clientWidth;
        if(currWidth == 50){
            alert("Maximum zoom-out level reached.");
        } else{
            myImg.style.width = (currWidth - 50) + "px";
        }
    }











</script>