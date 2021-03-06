<?php


class Manager
{
  private $_bdd;

  public function __construct()
  {
    $this->bdd();
  }

  private function bdd()
  {
    try {
      //$this->_bdd = new PDO('mysql:host=db5000355873.hosting-data.io;dbname=dbs346120;port=3306', 'dbu393353', 'gEne1.1ionos');
      $this->_bdd = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
      $this->_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
      die('Erreur : ' . $e->getMessage());
    }
  }

  /* PARIE CHAPITRES */
  /* AJOUTER UN CHAPITRE */

  public function addChapter($titre, $histoire)
  {
    $ajouterChapitre = $this->_bdd->prepare("INSERT INTO `chapitres`(`titre`, `histoire`, `dateAjout`) VALUES ( :titre, :histoire, CURDATE())");
    $ajouterChapitre->bindValue(':titre', $titre, PDO::PARAM_STR);
    $ajouterChapitre->bindValue(':histoire', $histoire, PDO::PARAM_STR);
    $ajouterChapitre->execute() or die(print_r($ajouterChapitre->errorInfo(), TRUE));
    return $ajouterChapitre;
  }

  /* MODIFIER UN CHAPITRE */

  public function updateChapter($id, $titre, $histoire)
  {
    $modifierChapitre = $this->_bdd->prepare("UPDATE `chapitres` SET `titre`= :titre,`histoire`= :histoire WHERE `id`= :id");
    $modifierChapitre->bindValue(':id', $id, PDO::PARAM_INT);
    $modifierChapitre->bindValue(':titre', $titre, PDO::PARAM_STR);
    $modifierChapitre->bindValue(':histoire', $histoire, PDO::PARAM_STR);
    $modifierChapitre->execute() or die(print_r($modifierChapitre->errorInfo(), TRUE));
    return $modifierChapitre;
  }

  /* SUPPRIMER UN CHAPITRE */

  public function deleteChapter($idChapitre)
  {
    $supprimerChapitre = $this->_bdd->prepare("DELETE FROM `chapitres` WHERE `id`= :idChapitre");
    $supprimerChapitre->execute(array('idChapitre' => $idChapitre));
    $supprimerCommentaires = $this->_bdd->prepare("DELETE FROM `commentaires` WHERE `idChapitre`= :idChapitre");
    $supprimerCommentaires->execute(array('idChapitre' => $idChapitre));
    return $supprimerChapitre;
  }

  /* SELECTIONNE UN CHAPITRE DEFINI */

  public function chapter($idChapitre)
  {
    $chapitresChoisis = $this->_bdd->prepare('SELECT * FROM chapitres WHERE id=? ');
    $chapitresChoisis->execute(array($idChapitre));
    $donneesChapitresChoisis = $chapitresChoisis->fetch();
    return $donneesChapitresChoisis;
  }



  /* SELECTIONNE TOUS LES CHAPITRES */

  public function listChapters($limitMin, $limitMax)
  {
    $chapitres = $this->_bdd->prepare('SELECT * FROM chapitres ORDER BY id DESC LIMIT :limitMin , :limitMax');
    $chapitres->bindValue(':limitMin', $limitMin, PDO::PARAM_INT);
    $chapitres->bindValue(':limitMax', $limitMax, PDO::PARAM_INT);
    $chapitres->execute() or die(print_r($chapitres->errorInfo(), TRUE));
    while ($donnees = $chapitres->fetch()) {
      $chapitre[] = new Chapters($donnees);
    }
    $chapitres->closeCursor();
    return $chapitre;
  }

  /* NOMBRE TOTAL DE CHAPITRES */

  public function allIdChapters()
  {
    $chapitres = $this->_bdd->query('SELECT * FROM chapitres');
    $chapitres->execute() or die(print_r($chapitres->errorInfo(), TRUE));
    while ($donnees = $chapitres->fetch()) {
      $chapitre[] = new Chapters($donnees);
    }
    $chapitres->closeCursor();
    foreach ($chapitre as $obj) {
      $allIdChapitres[] =  $obj->id();
    }
    return $allIdChapitres;
  }

  public function maxChapters()
  {
    $chapitres = $this->_bdd->query('SELECT * FROM chapitres ORDER BY id DESC ');
    $chapitres->execute() or die(print_r($chapitres->errorInfo(), TRUE));
    $maxChapters = 0;
    while ($donnees = $chapitres->fetch()) {
      $maxChapters++;
    }
    $chapitres->closeCursor();
    return $maxChapters;
  }

  /* PARTIE COMMENTAIRES */

  public function commentairesAll($idChapitre)
  {
    $commentaires = $this->_bdd->prepare('SELECT * FROM commentaires WHERE idChapitre = :idChapitre ORDER BY dateHeure DESC ');
    $commentaires->bindValue(':idChapitre', $idChapitre, PDO::PARAM_INT);
    $commentaires->execute() or die(print_r($commentaires->errorInfo(), TRUE));
    $commentaire = array();
    while ($donnees = $commentaires->fetch()) {
      $commentaire[] = new Commentaires($donnees);
    }
    return $commentaire;
  }

  public function commentairesList($idChapitre, $limitMin)
  {
    $commentaires = $this->_bdd->prepare('SELECT * FROM commentaires WHERE idChapitre = :idChapitre ORDER BY dateHeure DESC LIMIT :limitMin, 3 ');
    $commentaires->bindValue(':idChapitre', $idChapitre, PDO::PARAM_INT);
    $commentaires->bindValue(':limitMin', $limitMin, PDO::PARAM_INT);
    $commentaires->execute() or die(print_r($commentaires->errorInfo(), TRUE));
    $commentaire = array();
    while ($donnees = $commentaires->fetch()) {
      $commentaire[] = new Commentaires($donnees);
    }
    return $commentaire;
  }

  public function ajoutCommentaires($idChapitre, $pseudo, $commentaire)
  {
    $ajoutCommentaires = $this->_bdd->prepare("INSERT INTO `commentaires`(`idChapitre`, `pseudo`, `commentaire`, `dateHeure`) VALUES (:idChapitre, :pseudo, :commentaire, NOW())");
    $ajoutCommentaires->bindValue(':idChapitre', $idChapitre, PDO::PARAM_INT);
    $ajoutCommentaires->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $ajoutCommentaires->bindValue(':commentaire', $commentaire, PDO::PARAM_STR);
    $ajoutCommentaires->execute() or die(print_r($ajoutCommentaires->errorInfo(), TRUE));
    return $ajoutCommentaires;
  }

  public function supprimerCommentaire($id)
  {
    $supprimerCommentaire = $this->_bdd->prepare("DELETE FROM `commentaires` WHERE `id`= :id");
    $supprimerCommentaire->execute(array(':id' => $id));
    return $supprimerCommentaire;
  }

  public function maxCommentaires($idChapitre)
  {
    $req = $this->_bdd->prepare("SELECT * FROM `commentaires` WHERE idChapitre = :idChapitre ORDER BY id DESC ");
    $req->execute(array(':idChapitre' => $idChapitre));
    $maxCommentaires = 0;
    while ($donnees = $req->fetch()) {
      $maxCommentaires++;
    }
    return $maxCommentaires;
  }

  public function commentairesSignaler($idChapitre, $limitMinSignal)
  {
    $commentairesSignaler = $this->_bdd->prepare('SELECT * FROM commentaires WHERE idChapitre = :idChapitre && signalement = true ORDER BY dateSignalement DESC LIMIT :limitMinSignal , 3 ');
    $commentairesSignaler->bindValue(':idChapitre', $idChapitre, PDO::PARAM_INT);
    $commentairesSignaler->bindValue(':limitMinSignal', $limitMinSignal, PDO::PARAM_INT);
    $commentairesSignaler->execute() or die(print_r($commentairesSignaler->errorInfo(), TRUE));
    $commentaireSignaler = array();
    while ($donnees = $commentairesSignaler->fetch()) {
      $commentaireSignaler[] = new Commentaires($donnees);
    }
    return $commentaireSignaler;
  }

  public function signaler($idCommentaire)
  {
    $signaler = $this->_bdd->prepare("UPDATE `commentaires` SET `signalement`= true,`dateSignalement`= NOW() WHERE `id`= :idCommentaire");
    $signaler->execute(array(':idCommentaire' => $idCommentaire));
    return $signaler;
  }

  public function maxCommentairesSignaler($idChapitre)
  {
    $req = $this->_bdd->prepare("SELECT * FROM `commentaires` WHERE idChapitre = :idChapitre && signalement = true ORDER BY id DESC ");
    $req->execute(array('idChapitre' => $idChapitre));
    $maxCommentairesSignaler = 0;
    while ($donnees = $req->fetch()) {
      $maxCommentairesSignaler++;
    }
    return $maxCommentairesSignaler;
  }

  public function supprimerSignalement($idCommentaire)
  {
    $supprimerSignalement = $this->_bdd->prepare("UPDATE `commentaires` SET `signalement`= false,`dateSignalement`= NOW() WHERE `id`= :id");
    $supprimerSignalement->execute(array('id' => $idCommentaire));
    return $supprimerSignalement;
  }

  public function iconeSignalement($idChapitre)
  {
    if ($this->maxCommentairesSignaler($idChapitre) >= 1) {
      $iconeSignalement = "Signalement";
    } else {
      $iconeSignalement = "";
    }
    return $iconeSignalement;
  }
}
