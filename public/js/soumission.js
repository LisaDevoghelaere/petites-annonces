
var envoyer = document.getElementById('envoyer');

console.log(envoyer);

envoyer.addEventListener('click', function(e){
    e.preventDefault();
    validBoot();
    var form = document.getElementById('add');
    var formdata = new FormData(form);
    console.log(form);


    fetch('./ajax-ajout', { method : "post", body : formdata })
    .then( response => response.json().then( data =>{
        document.location.href="/popy"; 
    }))
})
function validBoot() {
    'use strict';
    window.addEventListener('load', function() {
    
//     var forms = document.getElementsByClassName('needs-validation');
    
    var validation = Array.prototype.filter.call(forms, function(form) {
    form.addEventListener('submit', function(event) {
    if (form.checkValidity() === false) {
    event.preventDefault();
    event.stopPropagation();
    }
    form.classList.add('was-validated');
    }, false);
    });
    }, false);
    };
