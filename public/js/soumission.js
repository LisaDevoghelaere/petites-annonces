
var envoyer = document.getElementById('envoyer');

console.log(envoyer);

envoyer.addEventListener('click', function(e){
    
    e.preventDefault();
    var form = document.getElementById('add');
    var formdata = new FormData(form);
    console.log(form);


    fetch('/ajax-ajout', { method : "post", body : formdata })
    .then( response => response.json().then( data =>{
        console.log(data);
    }))
})