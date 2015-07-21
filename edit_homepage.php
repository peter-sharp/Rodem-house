<?php
include('./templates/header.php');

function getHomeContents($content){
  global $database;
  $contents = $database->getRowsFromTable("pages", array("body","ID"))[0][$content];
  return $contents;
}

$homeID = getHomeContents('ID');
//die(var_dump($homeID));
if($_POST['change']){
  $database->updateInTable('pages', $homeID, array("body" => $_POST['change']['intro'] ) );
}


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
            <label for="">introduction text</label>
            <textarea  id="name" name="change[intro]" class="form-control"><?= getHomeContents('body');?></textarea>


            <a class="btn btn-back" name="submit">back</a>
            <input class="btn btn-CTA pull-right" type="submit" id="submit" name="submit" value="change">

          </div>
      </div>
    </div>
  </article>
</main>
<?php
include('./templates/footer.php');
?>
