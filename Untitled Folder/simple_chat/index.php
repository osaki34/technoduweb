
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Simple chat</title>
    <!-- bibliothèques externes -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- bibliothèques perso -->
    <link rel="stylesheet" href="css/style.css">
    
  </head>
  <body>
    <div id="main">
      <div class="page-header" id="title">
        <h1>
		Le chat simple
		<small>Postez vos messages</small>
		<img class="img-circle" src="http://www.assuropoil.fr/wp-content/uploads/assurance-chat-assurer-son-chat1.jpg">
	</h1>
      </div>

      <form id="msg-form" action="php/add_msg.php" method="POST">
        <div class="form-group">
          <label for="usr">Nom</label>
          <input type="text" class="form-control" id="nom" name="nom">
        </div>
        <div class="form-group">
          <label for="comment">Message</label>
          <textarea class="form-control" rows="5" id="msg" name="msg"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
      </form>

      <br/>
      <br/>
      <form action="index.php">
          <button class="btn btn-info pull-right">Rafraichir</button>
      </form>
      <div id="messages">

<?php
phpinfo();
      include 'php/get_latest_msg.php';

      $data = get_messages();
      foreach ($data["msgs"] as $msg) {
         echo '<div class="panel panel-default">';
         echo '<div class="panel-heading">';
         echo '<h3 class="panel-title">' . $msg['nom'] . '</h3>';
         echo '</div>';
         echo '<div class="panel-body">';
         echo $msg['msg'];
         echo '</div></div>';
      }

?>

        </div>
      
    </div>
  </body>
</html>
