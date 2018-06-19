<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
    <?php
    echo isset($_SESSION['auth_message']) ? $_SESSION['auth_message'] : FALSE;
    ?>
    <h3>Vous avez constaté un problème dans l'application ? </h3>
    <h3>Vous désirez posé une question sur l'application ?</h3>
    <h3>Hésitez pas à nous contacter !</h3>
    <div class = "form-group col-md-4">
        <?php
        echo form_open();
        echo form_label('Exprimez vous ! :', 'mail') . '<br />';
        echo form_error('mail');
        echo form_textarea('mail', set_value('mail'), 'class="form-control"') . '<br />';  
        echo form_submit('contact', 'Valider','class="btn btn-primary"');
        echo form_close();
        ?>
    </div>
</div>