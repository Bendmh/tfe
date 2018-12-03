var bonneReponses = [];
var resultat = 0;
var nombre = 0;

$(document).ready(function(){

    $('a').click(function(){
        event.preventDefault();
        appelAjax(this);
    });
    
    $('#inscription').click(function(){
        $('#message').hide();
        $.ajax('INC/template.login.inc.php').done(inscription);
    });

    $('#connexion').click(function(){
        $('#message').hide();
        $.ajax('INC/template.login.inc.php').done(connexion);
    });
});

function inscription(json){
    $('#login').show();
    $('#login').html(json);
    $('#formNom').submit(function(event){
        event.preventDefault();
        if($('#password').val() != $('#password2').val()){
            alert('Les deux mots de passe sont différents');
        }else {
            appelAjax(this);
        }
    });
    $('#classes').select2();
}

function menu(json){
    $('#menu').html(json);
    $('a').click(function(event){
        event.preventDefault();
        appelAjax(this);
    });
    $('#champ').hide();
    $('#ephec').css('width', '100%');
}

function connexion(json){
    $('#login').show();
    $('#login').html(json);
    $('fieldset legend').html('Connexion');
    $("label[for='password2']").remove();
    $('#password2').remove();
    $('#statut').remove();
    $('#classes').remove();
    $("input[type='submit']").val('Connexion');
    $('#formNom').submit(function(event){
        event.preventDefault();
        appelAjax(this);
    });
    $('#formNom').attr('action', 'connexion.html');
}



function appelAjax(elem){
    $.ajaxSetup({processData : false, contentType : false});
    var data = new FormData();
    var request = 'unknownUri';
    switch(true){
        case Boolean(elem.href) :
            request = $(elem).attr('href').split('.html')[0];
            break;
        case Boolean(elem.action) :
            request = $(elem).attr('action').split('.html')[0];
            data = new FormData(elem);
            break;
    }
    data.append('senderId', elem.id);
    $.post('?rq=' + request, data, gereRetour);
}

function gereRetour(retour){
    retour = testeJson(retour);
    for(var action in retour){
        switch(action){
            case 'deconnexion' :
                $('#message').html(retour[action]);
                $('#champ').show();
                $('#menu').hide();
                $('#login').hide();
                //$('#login').show();
                $('#classes').hide();
                $('#ephec').css('width', '85%');
                $('#inscription').click(function(){
                    $.ajax('INC/template.login.inc.php').done(inscription);
                });

                $('#connexion').click(function(){
                    $.ajax('INC/template.login.inc.php').done(connexion);
                });
                break
            case 'questions' :
                QCM = creationQCM(retour[action], retour["questions"][0]["ActId"]);
                $('#login').html(QCM);
                $('#login').show();
                $('#formQuest').submit(function(event){
                    event.preventDefault();
                    //verification();
                    appelAjax(this);
                });
                break;
            case 'inscription' :
                $('#message').html('<h1> Bienvenue ' + retour[action]["PersPrenom"] + '</h1>' +
                    '<img src=../IMG/BDD/' + retour[action]["IMG"] + ' alt=' + retour[action]["IMG"] + ' height="80" width="80">');
                if(retour[action]["PersStatut"] == 'Eleves'){
                    $.ajax('INC/template.menu.inc.php').done(menu);
                }else{
                    menuProf = creeMenu(retour["inscription"]["classe"]);
                    $('#menu').html(menuProf);
                    $('a').click(function(event){
                        event.preventDefault();
                        appelAjax(this);
                    });
                    $('#champ').hide();
                    $('#ephec').css('width', '100%');
                }
                $('#login').hide();
                $('#message').show();
                $('#menu').show();
                break;
            case 'erreur' :
                alert(retour[action]);
                break;
            case 'correction' :
                $('#login').hide();
                $.ajax('INC/template.menu.inc.php').done(menu);
                alert('tu as obtenu ' + retour[action] + ' sur ' + nombre);
                break;
            case 'classes' :
                tableau = creeTableau(retour[action]);
                $('#classes').html(tableau);
                $('#classes').show();
                break;
            default :
                $('main').html(retour);
        }
    }
}


function creeMenu(json){
    var tab = json.split(",");
    var retour = '<ul><li>Classes : </li><ul>';
    for (var i=0; i < tab.length; i++){
        retour += '<li><a href="' + tab[i] + '.html">' + tab[i] + '</a></li>';
    }
    retour += '</ul><li><a href="deconnexion.html">Déconnexion</a></li></ul>';
    return retour;
}


function creationQCM(json, actId){
    var retour = '<br><fieldset><legend>Activité ' + actId + ' </legend><form method="post" name="formQuest" id="formQuest" action="correction.html">';
    nombre = json.length;
    for(var i=0; i<json.length; i++){
        retour += '<h2>' + json[i]["question"] + ' ?</h2>';
        //par exemple pour mettre une image à la question
        /*if(json[i]["IMG"] != null){
            retour += '<img src=../IMG/BDD/' + json[i]["IMG"] + ' alt=' + json[i]["IMG"] + ' height="42" width="42"><br>';
        }*/
        reponses = melangerReponses(json[i]);
        for(var j=0; j<reponses.length; j++){
            retour += '<input type ="radio" id=' + i+reponses[j] + ' name="reponses' + i +  '" value=' + reponses[j] + '><label for=' + i+reponses[j] + '>' + reponses[j] + '</label>' + '<br>';
        }
    }
    retour += '<br><input type="submit" value="Envoyé">'
    retour += '<input type="button" onclick="window.location.reload(false)" value="Retour"/>';
    return retour;
}

function creeTableau(json){
    var retour = '<table><tr><th>Nom</th><th>Prenom</th><th>Activité</th><th>Cote</th><th>Total</th></tr>';
    for(var i=0; i<json.length; i++){
        retour += '<tr><td>' + json[i].PersNom + '</td><td>' + json[i].PersPrenom + '</td><td>' + json[i].ActNom + '</td><td>' + json[i].Cote + '</td><td>' + json[i].ActNombreQuestion + '</td></tr>';
    }
    retour += '</table>';
    retour += '<br>';
    retour += '<input type="button" onclick="window.location.reload(false)" value="Retour"/>';
    return retour;
}

//Code repris sur internet

function melangerReponses(json){
    bonneReponses.push(json['bonneReponse']);
    var reponses = [];
    reponses.push(json['bonneReponse']);
    reponses.push(json['reponse2']);
    reponses.push(json['reponse3']);
    reponses.push(json['reponse4']);
    reponses = shuffle(reponses);
    return reponses;
}

function shuffle(a)
{
    var j = 0;
    var valI = '';
    var valJ = valI;
    var l = a.length - 1;
    while(l > -1)
    {
        j = Math.floor(Math.random() * l);
        valI = a[l];
        valJ = a[j];
        a[l] = valJ;
        a[j] = valI;
        l = l - 1;
    }
    return a;
}

//Jusqu'ici

function testeJson(json) {
    var parsed;
    try {
        parsed = JSON.parse(json);
    } catch(e) {
        parsed = json;
        //parsed = {"jsonError": {'error': e, 'json': json}};
    }
    return parsed;
}