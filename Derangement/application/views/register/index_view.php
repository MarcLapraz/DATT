<!--
| AUTEUR : Marc Lapraz DATT
| ROLE :Vue permettant la saisie d'un nouvel utilisateur
| MODIFICATIONS : 09.01.2018  -> suppresion nom & prenom; Création champs numéro téléphone
| CONTROLLER :  controllers/Register.php               
| 
-->

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
    <?php
    echo isset($_SESSION['auth_message']) ? $_SESSION['auth_message'] : FALSE;
    ?>
    
    <div  class = "form-group col-md-4 formUser">
        <h1>Créer un compte</h1>
        <?php
        echo form_open();

        echo form_label('Nom utilisateur:', 'username') . '<br/>';
        echo form_error('username');
        echo form_input('username', set_value('username'), 'class="form-control"') . '<br/>';

        echo form_label('Email:', 'email') . '<br/>';
        echo form_error('email');
        echo form_input('email', set_value('email'), 'class="form-control"') . '<br/>';

        echo form_label('Telephone:', 'phone') . '<br/>';
        echo form_error('phone');
        echo form_input('phone', set_value('phone'), 'class="form-control"') . '<br/>';


        echo form_label('Mot de passe:', 'password') . '<br/>';
        echo form_error('password');
        echo form_password('password', '', 'class="form-control"') . '<br/>';

        echo form_label('Confirmation mot de passe :', 'confirm_password') . '<br/>';
        echo form_error('confirm_password');
        echo form_password('confirm_password', '', 'class="form-control"') . '<br/><br/>';
        ?>
        <button type="submit" class="btn btn-info btn-circle btn-lg buttonUser"><i class="glyphicon glyphicon-ok"></i></button>
            <?php
            echo form_close();
            ?>
    </div>
</div>