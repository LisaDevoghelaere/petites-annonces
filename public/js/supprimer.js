const buttonDelete = document.getElementById('deleteButton');

buttonDelete.addEventListener('click', () => {
    const modalDelete = document.getElementsByClassName('deleteValidate')[0];
    modalDelete.classList.add('active');

    const buttonYes = document.getElementById('deleteYes');
    const buttonNo = document.getElementById('deleteNo');

    buttonNo.addEventListener('click', () => {
        modalDelete.classList.remove('active');
    });

    const form = document.querySelector('FORM');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        let data = new FormData(form);
        let xhr = new XMLHttpRequest();
        
        xhr.open('POST', 'ajax-supprimer', true);
        xhr.send(data);
        
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                form.innerHTML = '<p>Annonce Supprimer</p>';
            }
        };
    })
});