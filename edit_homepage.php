<?php
include('./templates/header.php');

$homepage = $database->getRowsFromTable("pages", array("body","ID"));

if($_POST['login'])   $database->updateInTable(`pages`, $meetingspage[0]['ID'], array("body" => $_POST['change']['intro'] ) );
?>
<form class="pages" action="index.html" method="post">

<main class="editor">
  <div class="banner">
    <h1 class="col-md-4 center-block" >edit<br><small>home page</small></h1>
    <p class="breadcrumb">website editor > home page</p>
  </div>
  <article >
    <div class="container">

      <p class="user-type pull-right">logged in as <?= $_SESSION['usertype']?></p>
      <div class="col-md-4 center-block">



          <div class="form-group ">
            <label for="">introduction text</label>
            <textarea  id="name" name="change[intro]" class="form-control"><?= $homepage[0]['body']?></textarea>


            <a class="btn btn-back" name="change">back</a>
            <button class="btn btn-CTA pull-right" type="submit" name="change">change</button>

          </div>
      </div>
    </div>
  </article>
</main>
<?php
include('./templates/footer.php');
?>
