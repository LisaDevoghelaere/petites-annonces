# petites-annonces
une application de petites annonces

* Il doit permettre de :		
	* Poster une annonce	
	* Lister les annonces
	* Modifier une annonce
	* Supprimer une annonce
		
		
		
		
## Cycle pour poster une annonce	

Sur la page listant les annonces afficher un lien permettant de publier une annonce	:

* Lorsque la personne arrive sur le formulaire permettant de poster une annonce elle devra saisir	
	* Adresse mail
	* Nom
	* Prénom
	* Téléphone
	* Catégorie de l'annonce : Immobilier, Auto-Moto, Emploi, Animaux, Services, Vacances, Affaires pro, Autres
	* Image de mise en avant de l'annonce (optionnel)
	* Texte de l'annonce
	* Captcha
* Lorsque la personne poste son annonce, elle reçois un mail dans lequel il y a un lien demandant de confimer la publication de l'annonce.
	* Dans ce même courriel, il doit y avoir un lien permettant de modifier l'annonce.
	* Une fois confirmé alors l'annonce est publié sur la page d'annonce et l'utilisateur recoit un courriel lui permettant supprimer l'annonce. 	
	* Lorsque l'annonce est mise en ligne il ne doit plus être possible de la modifer avec le lien du premier courriel
		
## Cycle pour lister les annonces	

* Au chargement de la page d'accueil on voit les dix premières annonces. Lorsque l'ascenseur est en bas de la liste, on affiche les dix annonces suivantes 	
* Pour les annonces n'ayant pas d'image afficher une image par défaut	
* Sous l'annonce ont propose de télécharger l'annonce en PDF	


**Le formulaires seront validés par JS**	
**Technos : Composer, PHP POO, TWIG pour le rendu frontend, SASS(optionnel), GIT, JS, HTML, CSS, librairie PHP pour les PDF, AltoRouteur pour le routeur**
**Remarque :  On ne veut pas de pattern MVC, on reste en programmation objet POO simple**
**Remarque : Pensez à crypter les accès de validation et modification**
