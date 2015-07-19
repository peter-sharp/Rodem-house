<?php
include('./templates/header.php');
$meetingspage = $database->getRowsFromTable("pages", array("body","ID"));

if($_POST['login'])   $database->updateInTable(`pages`, $meetingspage[0]['ID'], array("body" => $_POST['change']['intro'] ) );
?>
<form class="pages" action="<?= $_SERVER['PHP_SELF']?>" method="POST">

<main>
  <h1 class="col-md-4 center-block" >edit<br><small>meetings page</small></h1>
  <article  class="editor">
    <div class="container">
      <p class="breadcrumb">website editor > meetings page</p>
        <p class="user-type pull-right">logged in as <?= $_SESSION['usertype']?></p>
        <h2>rodem fellowship meeting</h2>
        <label for="change[intro]">Rodem fellowship introduction text</label>
        <textarea  id="name" name="change[intro]" ><?= $meeingspage[0]['body']?></textarea>

        <a class="btn btn-back" name="change">back</a>
        <button class="btn btn-CTA" type="submit" name="change">change</button>
    </div>
  </article>
</main>
<?php
include('./templates/footer.php');
?>
