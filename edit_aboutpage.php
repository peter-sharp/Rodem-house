<?php
include('./templates/header.php');

$rodemHouseAdmin->updatePage('about us',array('body' => $_POST['change']['text']));


$homeBody = $rodemHouse->getPageContent('about us');
?>

  <form class="pages" action="<?= $_SERVER['PHP_SELF']?>" method="POST">

  <main class="editor">
  <div class="banner">
    <h1 class="col-md-4 center-block" >edit<br><small>about us page</small></h1>
    <p class="breadcrumb">website editor > about page</p>
  </div>
  <article>
      <div class="container">

        <p class="user-type pull-right">logged in as <?= $_SESSION['usertype']?></p>
        <div class="col-md-8 center-block">
          <div class="form-group ">
            <label for="about">about us text</label>
            <textarea  name="change[text]" class="form-control"><?= $homeBody['body'] ?></textarea>

            <a class="btn btn-back" name="submit" href="./editor.php">back</a>
            <input class="btn btn-CTA pull-right" type="submit" name="submit" value="change">
          </div>
      </div>
    </div> <!-- /container -->
  </article>
</main>
<?php
include('./templates/footer.php');
?>
