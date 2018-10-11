<?php 
	require 'db.php';
?>


<?php if ( isset ($_SESSION['logged_user']) ) : ?>


    <?php require ('index/connect.php'); ?>


<?php else : ?>


<?php require ('index/notconnect.php'); ?>


<?php endif; ?>





