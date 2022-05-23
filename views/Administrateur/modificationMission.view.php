<h1>Page de modification des missions</h1>
<form method="POST" action="<?= URL ?>administration/validation_modificationMission">

    <div class="form-group">
        <label for="nom_mission">Nom</label>
        <input type="text" name="nom_mission" id="nom_mission" value="<?= $mission['nom_mission'] ?>"/>
    </div>

    <div class="form-group">
        <label for="description_mission">Description</label>
        <textarea  class="form-control" id="description_mission" name="description_mission" rows=3></textarea>
    </div>

    <input type="hidden" name="id_mission" value="<?= $mission['id_mission'] ?>" />

    <button type="submit" class="btn btn-success">Valider la modification</button>
</form>