<fieldset>
    <legend>Inscription</legend>
    <form method="post" name="formNom" id="formNom" action="inscription.html">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom"><br>
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom">
        <select id="statut" name="statut">
            <option value="Eleves">Eleves</option>
            <option value="Professeur">Professeur</option>
        </select>
        <br>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password"><br>
        <label for="password2">Retaper le mot de passe :</label>
        <input type="password" name="password2" id="password2"><br>
        <input type="submit" value="Inscription">
    </form>
</fieldset>