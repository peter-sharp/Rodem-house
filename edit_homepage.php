<?php
include('./templates/header.php');

$homeBody = $rodemHouse->getPageContent('home');

?>
<form method="POST" class="pages" action="<?= $_SERVER['PHP_SELF']?>" >

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
            <label >introduction text</label>
            <textarea  name="change[intro]" class="form-control"><?= $homeBody['body']?></textarea>


            <a class="btn btn-back" name="submit">back</a>
            <input class="btn btn-CTA pull-right" type="submit"  name="submit" value="change">

          </div>
      </div>
    </div>
  </article>
</main>
<?php
include('./templates/footer.php');
?>
