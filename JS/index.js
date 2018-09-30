var bonneReponses = [];
var resultat = 0;
var nombre = 0;

$(document).ready(function(){

    $('a').click(function(){
        event.preventDefault();
        appelAjax(this);
    });

    $('#inscription').click(function(){
        $.ajax('INC/template.login.inc.php').done(inscription);
    });

    $('#connexion').click(function(){
        $.ajax('INC/template.login.inc.php').done(connexion);
    });
});

function inscription(json){
    $('#login').html(json);
    $('#formNom').submit(function(event){
        event.preventDefault();
        if($('#password').val() != $('#password2').val()){
            alert('Les deux mots de passe sont différents');
        }else {
            appelAjax(this);
        }
    });
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
                $('#login').html(retour[action]);
                $('#champ').show();
                $('#menu').hide();
                $('#login').show();
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
                $('#login').show();
                $('#login').html(QCM);
                $('#formQuest').submit(function(event){
                    event.preventDefault();
                    //verification();
                    appelAjax(this);
                });
                break;
            case 'inscription' :
                if(retour[action] == 'élève'){
                    $.ajax('INC/template.menu.inc.php').done(menu);
                }else{
                    $.ajax('INC/template.menu2.inc.php').done(menu);
                }
                $('#login').hide();
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
            default :
                $('main').html(retour);
        }
    }
}

function creationQCM(json, actId){
    var retour = '<br><fieldset><legend>Activité ' + actId + ' </legend><form method="post" name="formQuest" id="formQuest" action="correction.html">';
    nombre = json.length;
    for(var i=0; i<json.length; i++){
        retour += '<h2>' + json[i]["question"] + ' ?</h2>';
        reponses = melangerReponses(json[i]);
        for(var j=0; j<reponses.length; j++){
            retour += '<input type ="radio" name="reponses' + i +  '" value=' + reponses[j] + '>' + reponses[j] + '<br>';
        }
    }
    retour += '<br><input type="submit" value="Envoyé">'
    //retour += '<h3>Ton résultat : 0/2 </h3>';
    return retour;
}

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