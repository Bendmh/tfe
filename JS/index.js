var bonneReponses = [];
var resultat = 0;
var nombre = 0;

$(document).ready(function(){

    $('#inscription').click(function(){
        $.ajax('INC/template.login.inc.php').done(inscription);
    });

    $('#connexion').click(function(){
        $.ajax('INC/template.login.inc.php').done(connexion);
    });
});

function inscription(json){
    $('main').html(json);
    $('#formNom').submit(function(event){
        event.preventDefault();
        if($('#password').val() != $('#password2').val()){
            console.log('Les deux mots de passe sont différents');
        }else {
            appelAjax(this);
        }
    });
}

function menu(json){
    $('main').html(json);
    $('a').click(function(event){
        event.preventDefault();
        appelAjax(this);
    });
    $('#champ').hide();
    $('#ephec').css('width', '100%');
}

function connexion(json){
    $('main').html(json);
    $('fieldset legend').html('Connexion');
    $("label[for='password2']").remove();
    $('#password2').remove();
    $('#statut').remove();
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
                $('main').html(retour[action]);
                $('#champ').show();
                $('#ephec').css('width', '85%');
                break
            case 'questions' :
                QCM = creationQCM(retour[action]);
                $('main').html(QCM);
                $('#formQuest').submit(function(event){
                    event.preventDefault();
                    //verification();
                    appelAjax(this);
                });
                break;
            case 'inscription' :
                $.ajax('INC/template.menu.inc.php').done(menu);
                break;
            case 'erreur' :
                alert(retour[action]);
                //$('main').html(retour[action]);
                break;
            case 'correction' :
                $.ajax('INC/template.menu.inc.php').done(menu);
                alert('tu as obtenu ' + retour[action] + ' sur ' + nombre);
                //$(input[type=submit]).append('resultat');
                break;
            default :
                $('main').html(retour);
        }
    }
}

/*function verification() {
    if(($('input[name=reponses0]:checked')).val() == bonneReponses[0]){
        resultat = resultat++;
    }
}
*/
function creationQCM(json){
    var retour = '<br><fieldset><legend>Activité 1</legend><form method="post" name="formQuest" id="formQuest" action="correction.html">';
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