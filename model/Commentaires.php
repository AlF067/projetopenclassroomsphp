<?php

class Commentaires
{
    private $_id;
    private $_idChapitre;
    private $_pseudo;
    private $_commentaire;
    private $_dateHeure;
    private $_signalement;
    private $_dateSignalement;


    public function __construct($donnees)
    {
        $this->hydrate($donnees);
    }

    public function hydrate(array $donnees)
    {

        foreach ($donnees as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Liste des getters

    public function id()
    {
        return $this->_id;
    }

    public function idChapitre()
    {
        return $this->_idChapitre;
    }

    public function pseudo()
    {
        return $this->_pseudo;
    }

    public function commentaire()
    {
        return $this->_commentaire;
    }

    public function dateHeure()
    {
        return $this->_dateHeure;
    }

    public function signalement()
    {
        return $this->_signalement;
    }

    public function dateSignalement()
    {
        return $this->_dateSignalement;
    }


    // Liste des setters

    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id = $id;
        }
    }
    public function setIdChapitre($idChapitre)
    {
        $idChapitre = (int) $idChapitre;
        if ($idChapitre > 0) {
            $this->_idChapitre = $idChapitre;
        }
    }

    public function setPseudo($pseudo)
    {
        if (is_string($pseudo)) {
            $this->_pseudo = $pseudo;
        }
    }

    public function setCommentaire($commentaire)
    {
        if (is_string($commentaire)) {
            $this->_commentaire = $commentaire;
        }
    }

    public function setDateHeure($dateHeure)
    {
        if (is_string($dateHeure)) {
            $this->_dateHeure = $dateHeure;
        }
    }
    public function setSignalement($signalement)
    {
        $signalement = (int) $signalement;
        if ($signalement == 0 || $signalement == 1) {
            $this->_signalement = $signalement;
        }
    }
    public function setDateSignalement($dateSignalement)
    {
        if (is_string($dateSignalement)) {
            $this->_dateSignalement = $dateSignalement;
        }
    }
}
