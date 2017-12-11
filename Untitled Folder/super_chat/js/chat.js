// Ceci est le fichier Javascript qui rend notre application dynamique !

// On attend que la page soit chargée
document.addEventListener('DOMContentLoaded', function () {

    // Cette fonction construit une portion de HTML en fonction d'un message; cela permet
    // d'injecter ce HTML dans la page et ainsi rendre le message visible à l'écran
    function build_msg_html(msg) {
        var ret = '';
        ret += '<div class="panel panel-default">';
        ret += '<div class="panel-heading">';
        ret += '<h3 class="panel-title">' + msg.nom + '</h3>';
        ret += '</div>';
        ret += '<div class="panel-body">';
        ret += msg.msg;
        ret += '</div></div>';
        return ret;
    }

	// Cette fonction va chercher les messages en appelant le Webservice de lecture
    function refresh() {
   		// On prépare une requête AJAX
        var request = new XMLHttpRequest();
		// On définit ce qu'elle fera lorsqu'elle aura reçu une réponse
        request.addEventListener('load', function(data) {
        	// Debug: on affiche les données dans la console
            //console.log(data.target.responseText));
            // On décode les données renvoyées par le Webservice
            var ret = JSON.parse(data.target.responseText);
            var new_html = '';
            // Pour chaque message du jeu de données renvoyé, on construit une portion de HTML
            for (var i = 0; i < ret.msgs.length; i++) {
				new_html += build_msg_html(ret.msgs[i]);
            }
			// On injecte ce HTML dans le <div> prévu dans la page HTML
            document.querySelector('#messages').innerHTML = new_html;
        });

		// On envoie la requête avec la méthode GET (car on ne transmet pas de données)
        request.open("GET", "php/get_latest_msg.php");
        request.send();
    }

    // Rafraichissement au chargement, puis toutes les 5 secondes
    refresh();
    setInterval(refresh, 5000);

	// On ajoute un écouteur d'événement sur le formulaire, pour intercepter l'action "submit" (quelqu'un
	// a cliqué sur le bouton "envoyer"), et appeler le Webservice d'écriture dans ce cas
    var form = document.getElementById('msg-form');
    form.addEventListener("submit", function(event) {
    	// On n'exécute pas l'action par défaut
        event.preventDefault();

		// On prépare une requête AJAX
        var request = new XMLHttpRequest();
		// On définit ce qu'elle fera lorsqu'elle aura reçu une réponse
        request.addEventListener('load', function(data) {
            console.log(JSON.parse(data.target.responseText));
            // Si le code de retour est "erreur du serveur"
            if (data.target.status == 500) {
            	// On fait sauter une erreur explicite au nez de l'utilisateur (il serait
            	// mieux d'afficher un message plus discret dans la page)
            	alert("erreur lors de l'envoi du message");
            } else if (data.target.status == 200) { // Sinon, si le code d'erreur est "ok"
            	// On vide le champ du message (juste pour faire joli)
	            var textarea = document.getElementById('msg');
	            textarea.value = '';
	        }
        });
		// ... et ce qu'elle fera en cas d'erreur
        request.addEventListener('error', function(data) {
        	// On affiche une erreur
            console.log('error', data);
        });

		// On envoie la requête avec la méthode POST (car on transmet des données)
        request.open("POST", "php/add_msg.php");
        // On envoie les données que l'utilisateur a tapées dans le formulaire
        request.send(new FormData(form));
    });

});
