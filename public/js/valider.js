// Ajax formulaire de confirmation de l'annonce

const validForm = document.getElementById('valid');

console.log(validForm);

validForm.addEventListener('submit', (e) => {
    e.preventDefault();
    var formdata = new FormData(validForm);
    fetch('/ajax-valider', { method : "post", body : formdata })
    .then( response => response.json().then( data =>{
            const modalOn = document.querySelector('#modal');
            modalOn.classList.remove('hidden');
            const btnModal = document.querySelector('btnModal');
            console.log(xhr.responseText);
            if(data == '"OK"'){
                btnModal.innerHTML = 'Annonce confirmée<br/><a href="/">Retour à l\'accueil</a>'
            } else{
                btnModal.innerHTML = 'Une erreur s\'est produite, merci de réessayer plus tard<br/><a href="/">Retour à l\'accueil</a>'
            }
    }))
    
   
});








// const formValidate = document.getElementById('formValidation').children[0];
// console.log(formValidate);

// formValidate.addEventListener('submit', (e) => {
//     e.preventDefault();
    
//     let data = new FormData(formValidate);
//     let xhr = new XMLHttpRequest();
    
//     console.log(data);
//     xhr.open('POST', '/ajax-valider', true);
//     xhr.send(data);
    
//     xhr.onreadystatechange = function() {
//         if (this.readyState == 4 && this.status == 200) {
//             const modalOn = document.querySelector('#modal');
//             modalOn.classList.remove('hidden');
//             const btnModal = document.querySelector('btnModal');
//             console.log(xhr.responseText);
//             if(xhr.responseText == '"OK"'){
//                 btnModal.innerHTML = 'Annonce confirmée<br/><a href="/">Retour à l\'accueil</a>'
//             } else{
//                 btnModal.innerHTML = 'Une erreur s\'est produite, merci de réessayer plus tard<br/><a href="/">Retour à l\'accueil</a>'
//             }
//         }
//     };
// });