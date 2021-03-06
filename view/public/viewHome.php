<?php $title = "Accueil"; ?>
<?php $linkStylesGeneral = '<link rel="stylesheet" type="text/css" href="public/styles/stylesGeneral.css">' ?>
<?php $linkStyles = '<link rel="stylesheet" type="text/css" href="public/styles/stylesIndex.css">' ?>
<?php ob_start();  ?>

<div id="desc">
    <div id="billets">
        <?php
        foreach ($homeChapters as $obj) {
        ?>
            <div class="blocBillet">
                <div class="billet">
                    <h2><?php echo $obj->titre() . " " . " ajouté le " . $obj->dateAjout() ?></h2>
                    <?php echo $obj->histoire() ?>
                </div>
                <div class="lireChapitre">
                    <a href="index.php?action=lecture&id=<?php echo $obj->id() ?>">Lire le chapitre</a>
                </div>
            </div>

        <?php
        }
        ?>
    </div>

    <p id="allChapters"><a href="index.php?action=chaptres">Tous les chapitres</a></p>
</div>

<?php $contenu = ob_get_clean();  ?>
<?php require 'template.php'; ?>