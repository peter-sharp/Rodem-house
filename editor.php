<?php
include('./templates/header.php');
?>
<?php if ( $authenticator->isAuthenticated()): ?>
<main class="editor">
  <div class="banner">
    <h1 class="col-md-4 center-block" >website editor</h1>
  </div>
  <article >
    <div class="container">
      <p class="user-type pull-right">logged in as <?= $_SESSION['usertype']?></p>
      <p class="admin">This is where you can make changes to the website. you can make changes to the text
        on the pages listed above. </p>
        <p>To add a new fellowship or social event<br>Click this button</p>
        <a class="btn btn-ADD" href="edit_events.php">add event</a>
      <p> <small>You can also add, update or delete felowship or social events by clicking on the 'events' link above. </small></p>
    </div>
  </article>
</main>
<?php endif; ?>
<?php
include('./templates/footer.php');
?>
