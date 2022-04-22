<?php ob_start(); ?>

<?php 
$content = ob_get_clean();
$titre = "Bienvenue cher bénévole :)";
require "views/commons/template.php";