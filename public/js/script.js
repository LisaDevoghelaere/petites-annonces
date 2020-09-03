const groupeAnnonce = document.querySelector('.groupe-annonce');
const annonce = document.querySelectorAll('.annonce');
//console.log(groupeAnnonce, infinite);

function chargeAnnonces(numAnnonce = 10){
    let i = 0;
    while(i<numAnnonce){
        groupeAnnonce.appendChild(annonce);
        i++;
    }
}
chargeAnnonces()
window.addEventListener('scroll', () => {
    if(window.scrollY + window.innerHeight >= document.documentElement.scrollHeight){
    chargeAnnonces()
    }
})