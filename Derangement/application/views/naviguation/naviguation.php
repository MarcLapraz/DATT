<header>

    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a onclick="window.location = '<?php echo site_url("dashboard"); ?>'">
                    <img border="0" alt="W3Schools" class="navbar-left"   src="<?php echo base_url(); ?>assets/images/logo.png" >
                </a>

                
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse-2">
                <ul class="nav navbar-nav navbar-right">

                    <li><a href=<?php echo base_url(); ?>Register>Ajouter utilisateur</a></li>

                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Déclarer une panne<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <!--- These menu items will only appear in the "More" dropdown menu. --->
                            <li><a href=<?php echo base_url(); ?>Panne>Machine de vente</a></li>
                            <li><a href=<?php echo base_url(); ?>Panne>Caisse embarquée</a></li>
                            <li><a href=<?php echo base_url(); ?>GPS>Surveillance</a></li>  
                        </ul>
                    </li>
                    <li><a href=<?php echo base_url(); ?>PanneVisualisation>Visualisation</a></li>
                    <li><a href=<?php echo base_url(); ?>PanneEnAttente>A traiter</a></li>
                    <li><a href=<?php echo base_url(); ?>Recherche>Recherche</a></li>
                  
                    
               <!--    <li><a href= ?>To_Excel>Excel</a></li> -->
                <!--    <li><a href=Contact>Contact</a></li> -->

                    <li>
                        <?php $username = $this->session->userdata('username'); ?>
                        <button type="button" class="btn btn-danger btn-round" onclick="window.location = '<?php echo site_url("user/logout"); ?>'">Log out /<?php echo $username ?> </button>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container -->
    </nav><!-- /.navbar -->
</header>
