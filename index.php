<?php
require "model/Commentaires.php";
require "model/Chapters.php";
require "model/Manager.php";
require "controller/public.php";
require "controller/admin.php";
$manager = new Manager;

try {
    if (isset($_GET["action"])) {
        if ($_GET["action"] == "contact") { //PARTIE PUBLIC
            require "view/public/viewContact.php";
        } elseif ($_GET["action"] == "biographie") {
            require "view/public/viewBiographie.php";
        } elseif ($_GET["action"] == "chaptres") {
            chaptres();
        } elseif ($_GET["action"] == "lecture") {
            chapitresChoisis();
        } elseif ($_GET["action"] == "XHYEOSODID") { //PARTIE ADMINISTRATEUR
            if ((isset($_POST["user"]) && isset($_POST["password"])) || isset($_GET["online"])) {
                if (isset($_GET["actionAdmin"])) {
                    if ($_GET["actionAdmin"] == "add") {
                        add();
                    } elseif ($_GET["actionAdmin"] == "update") {
                        update();
                    } elseif ($_GET["actionAdmin"] == "deleteChapter") {
                        delete();
                    } elseif ($_GET["actionAdmin"] == "comments") {
                        comments();
                    }
                } else {
                    adminHome();
                }
            } else {
                require "view/admin/login.php";
            }
        } else {
            throw new Exception('cette page n\'existe pas');
        }
    } else {
        $homeChapters = $manager->listChaptres(0, 3);
        require "view/public/viewHome.php";
    }
} catch (Exception $e) {
    $erreur = "erreur : " . $e->getMessage();
    require "view/public/viewError.php";
}
