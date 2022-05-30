<!-- L'UTILISATEUR DU SITE NE PEUT CONSULTER LES MISSIONS ET POSTULER !-->

<h1>Missions</h1>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Nom de la mission</th>
            <th>Description</th>
            <th>Candidater</th>
        </tr>
        <?php foreach($missions as $mission) :?>
            <tr>
                <td><?=$mission['id_mission']?></td>
                <td><?=$mission['nom_mission']?></td>
                <td><?=$mission['description_mission']?></td>
                <td>
                    <a class="btn btn-success" href="<?= URL ?>compte/candidature">Postuler à cette mission</a>
                </td>
            </tr>
            <?php endforeach; ?>
    </thead>
</table>