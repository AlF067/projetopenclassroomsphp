<?php 
    require "../modele/Chapters.php";
    require "../modele/Commentaires.php";
    require "../modele/Manager.php";
    $manager = new Manager;

    /*Commentaires affichés en fonction de l'id du chapitre */
    if (isset($_POST["idChapitre"])) { 
        $idChapitre = $_POST["idChapitre"];
    }else {
        $idChapitre = $_GET["idChapitre"];
    }
    $chapitreChoisis = $manager->chaptre($idChapitre);
    
    /* Supprime un commentaire */
    if (isset($_POST["oui"]) && isset($_POST["id"])  ) {
    	$manager->supprimerCommentaire($_POST["id"]);
    }
    /* Affiche 3 commentaires maximum par page  */
    if (isset($_GET['limitMin'])) {
     $limitMin = $_GET['limitMin'];
    }else {
      $limitMin = 0;
    }
  
  
    /*


  	if (isset($_POST["supprimerSignalement"])) {
		$supprimerSignalement = supprimerSignalement();  	
	}
    if (isset($_POST["oui"])) {
    	$supprimerCommentaire = supprimerCommentaire();
    }
    $maxCommentaires = maxCommentaires();
    $maxCommentairesSignaler = maxCommentairesSignaler();
    $chapitresChoisis = chapitresChoisis();
    $commentaires = commentaires();
    */
    require "../vue/vueModerationCommentairesAdmin.php";
?>