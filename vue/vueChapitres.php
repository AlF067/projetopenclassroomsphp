<?php $title = "Chapitres"; ?>
<?php $linkStylesGeneral = '<link rel="stylesheet" type="text/css" href="../styles/stylesGeneral.css">' ?>
<?php $linkStyles = '<link rel="stylesheet" type="text/css" href="../styles/stylesChapitres.css">' ?>
<?php ob_start();  ?>

<?php

foreach ($manager->listChaptres($limitMin, 5) as $obj) {

?>

    <div class="blocChapitre">
        <div class="chapitre">
            <h2><?php echo $obj->titre() . " " . " ajouté le " . $obj->dateAjout() ?></h2>
            <p><?php echo $obj->histoire() ?></p>
        </div>
        <div class="lireChapitre">
            <a href="../controleur/chapitresChoisis.php?idChapitre=<?php echo $obj->idChapitre() ?>">Lire le chapitre</a>
        </div>
    </div>
<?php

}
?>
<div id="paginationChapitres">
    <?php
    $pages = 0;
    $limitMin = 0;
    $commentairesParPage = 0;
    echo "<div id='nombreDePages'>Page : </div>";
    while ($limitMin < $manager->maxChaptres()) {
    ?>
        <?php
        if (!$pages == 0) {
            echo "<div class='slash'>/</div>";
        } 
        ?>
        <div id="numerosPage">
            <a href="../controleur/chapitres.php?limitMin=<?php echo $pages * 5 ?> "><?php echo $pages + 1; ?></a>

        </div>

    <?php
        $commentairesParPage += 5;
        $limitMin += 5;
        $pages++;
    }
    ?>
</div>



<?php $contenu = ob_get_clean();  ?>
<?php require 'gabarit.php'; ?>