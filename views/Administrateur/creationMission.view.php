<h1>Page de création des missions</h1>
<form method="POST" action="<?= URL ?>administration/validation_creationMission">

    <div class="form-group">
        <label for="nom_mission">Nom</label>
        <input type="text" class="form-control" id="nom_mission" name="nom_mission">
    </div>

    <div class="form-group">
        <label for="description_mission">Description</label>
        <textarea  class="form-control" id="description_mission" name="description_mission" rows=3></textarea>
    </div>

    <button type="submit" class="btn btn-success">Valider</button>
</form>