const choisir = document.getElementById('choisir');

choisir.addEventListener('click', function(){
    
    //On sélectionne la valeur de la catégorie pour qu'elle corresponde à l'id de la table categorie
    let select = document.getElementById('inputGroupSelect02').value;
    //on créé un objet formdata qui créé un "formulaire"
    let data = new FormData();
    //on lui assigne des paramètres (nom, input select)
    data.append('categorie', select);
    
    //la requête ajax
    let xhr = new XMLHttpRequest();
    //methode d'envoi, chemin, true
    xhr.open('POST', 'choixcategorie', true);
    //on envoi avec en valeur data, notre objet "formulaire"
    xhr.send(data);
    //où on en est dans les étapes et les fonction qu'on lui attribut
    xhr.onreadystatechange = function (){
        //cf : "XMLHTTPRequest status w3school"
        if(this.readyState == 4 && this.status == 200){
            content[0].innerHTML = xhr.responseText;
        }
    }
})

// chargeAnnonces()
// window.addEventListener('scroll', () => {
//     if(window.scrollY + window.innerHeight >= document.documentElement.scrollHeight){
//     chargeAnnonces()
//     }
// })
