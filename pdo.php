<?php
try {
	$bdd = new PDO('mysql:host=localhost;dbname=tuto;charset=utf8', 'root', '');
} catch (Exception $e) {
		echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
      	<strong>Erreur: </strong>".$e->getMessage()."
      	<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Fermer\">
      	<span aria-hidden=\"true\">&times;</span>
      	</button>
      	</div>";
}
?>