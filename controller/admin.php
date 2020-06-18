<?php
function deconnect(){
    $_SESSION["connected"] = false;; 
}

function adminHome()
{
    
    $manager = new Manager;
    $maxChaptres = $manager->maxChaptres();
    
    if (isset($_POST["user"]) && isset($_POST["password"])) {
        if ($_POST["user"] == "alf" && $_POST["password"] == "mdp") {        
            $_SESSION["connected"] = true;
        }else {
            $_SESSION["connected"] = false;
        }
    } 
   
    if (isset($_SESSION["connected"]) && $_SESSION["connected"] == true) {

        /* Supprime un chapitre s'il y en a un a supprimer */
        if (isset($_POST["oui"])) {
            $manager->deleteChapitre($_POST["idChapitre"]);
        }

        /* Modifie un chapitre s'il y en a un a ajouter */
        if (isset($_POST["modifHistoire"]) && isset($_POST["modifTitre"])) {
            $manager->updateChaptre($_POST["idChapitre"], $_POST["modifTitre"], $_POST["modifHistoire"]);
        }

        /* Ajoute un chapitre s'il y en a un a ajouter */
        if (isset($_POST["histoire"]) && isset($_POST["titre"])) {
            if ($manager->chaptre($_POST["idChapitre"]) == false) {
                $manager->addChaptre($_POST["idChapitre"], $_POST["titre"], $_POST["histoire"]);
            } else {
                $chapitreDejaExistant = "le numéro de chapitre existe déja";
            }
        }

        /* Variable necessaire pour afficher la page de la liste des chapitre (5 chapitres par page) */
        if (isset($_GET["limitMin"])) {
            $limitMin = $_GET["limitMin"];
            if ($limitMin >= $maxChaptres){
                throw new Exception('Une erreur s\'est produite');
            }
        } else {
            $limitMin = 0;
        }
        $listChaptres = $manager->listChaptres($limitMin, 5);

        require "view/admin/viewHome.php";
    } else {
        if (!(isset($_POST["deconnexion"]))) {
            echo "mauvais mot de passe ou nom d'utilisateur" ;           
        }
        
        require "view/admin/login.php";
    }
}

function add()
{
    require "view/admin/viewAdd.php";
}

function update()
{
    $manager = new Manager;

    $chapitreChoisis = $manager->chaptre($_GET["idChapitre"]);
    require "view/admin/viewUpdate.php";
}

function delete()
{
    require "view/admin/viewDeleteChapter.php";
}

function comments()
{
    $manager = new Manager;
    $allIdChaptres = $manager->allIdChaptres();

    //Commentaires affichés en fonction de l'id du chapitre 
    if (isset($_POST["idChapitre"])) {
        $idChapitre = $_POST["idChapitre"];
    }elseif (isset($_GET["idChapitre"])) {
        $idChapitre = $_GET["idChapitre"];
    }else {
        throw new Exception('une erreur s\'est produite');
    }

    if (!(in_array($idChapitre, $allIdChaptres))) {
        throw new Exception('le chapitre choisi n\'existe pas');
    }

    $chapitreChoisis = $manager->chaptre($idChapitre);

    /* Supprime un commentaire */
    if (isset($_POST["oui"]) && isset($_POST["id"])) {
        $manager->supprimerCommentaire($_POST["id"]);
    }

    /* Supprime un signalement */

    if (isset($_POST["effacerSignalement"])) {
        $manager->supprimerSignalement($_POST["effacerSignalement"]);
    }


    /* Affiche 3 commentaires maximum par page  */
    if (isset($_POST['limitMin'])) {
        $limitMin = $_POST['limitMin'];
    } else {
        $limitMin = 0;
    }

    /* Affiche 3 commentaires signalés maximum par page  */
    if (isset($_POST['limitMinSignal'])) {
        $limitMinSignal = $_POST['limitMinSignal'];
    } else {
        $limitMinSignal = 0;
    }

    $commentsAll = $manager->commentairesList($idChapitre, $limitMin);
    $maxComments = $manager->maxCommentaires($idChapitre);
    $commentsSignal = $manager->commentairesSignaler($idChapitre, $limitMinSignal);
    $maxSignalComments = $manager->maxCommentairesSignaler($idChapitre);
    
    

    if (isset($_GET["deleteComment"])) {
        require "view/admin/viewConfirmationDeleteComment.php";
    }else {
        require "view/admin/viewComments.php";
    }
    
}

