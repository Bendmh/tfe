<fieldset>
    <legend>Inscription</legend>
    <form method="post" name="formNom" id="formNom" action="inscription.html">
        <label for="nom">Nom :</label><br>
        <input type="text" name="nom" id="nom"><br>
        <label for="prenom">Prénom :</label><br>
        <input type="text" name="prenom" id="prenom">
        <br>
        <label for="password">Mot de passe :</label><br>
        <input type="password" name="password" id="password"><br>
        <label for="password2">Retaper le mot de passe :</label><br>
        <input type="password" name="password2" id="password2"><br>
        <select id="statut" name="statut">
            <option value="Eleves">Eleves</option>
            <option value="Professeur">Professeur</option>
        </select>
        <select id="classes" name="classes" multiple>
            <option value="1A">1A</option>
            <option value="1B">1B</option>
            <option value="1C">1C</option>
            <option value="1D">1D</option>
            <option value="1E">1E</option>
        </select>
        <br>
        <input type="submit" value="Inscription">
    </form>
</fieldset>