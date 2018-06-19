<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container MyContainer" style="background: white; margin-bottom:20px">
    <?php
    echo isset($_SESSION['auth_message']) ? $_SESSION['auth_message'] : FALSE;
    ?>
    <a><img style="align" src="<?php echo base_url(); ?>assets/images/transn-logo.jpg"  alt ="Accueil" height="100" width="100"></a>
    <div>
        <?php
        echo form_open();
        ?>
        <div>
            <?php
            echo form_label('Utilisateur:', 'username') . '<br/>';
            echo form_error('username');
            echo form_input('username', '', 'class="form-control"') . '<br/>';
            echo form_label('Mot de passe:', 'password') . '<br/>';
            echo form_error('password');
            echo form_password('password', '', 'class="form-control"') . '<br/>';
            echo form_checkbox('remember', '1', FALSE) . ' Mémoriser le mot de passe<br />';
            ?>
            <div style="text-align: center">
                <button type="submit" class="btn btn-info btn-circle btn-lg"><i class="glyphicon glyphicon-ok"></i></button>

                <?php
                echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>