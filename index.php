<?php
include('./templates/header.php');
$homepageContent = $rodemHouse->getPageContent('home'); // $database->getRowsFromTable("pages", array("body"))[0];

?>
<main class="home">

  <div class="banner">
    <h1 class="col-md-4 center-block"><small>international</small><br>fellowship</h1>
  </div>
  <article class="CTA_area">
    <div class="container">
      <p>
      <?php if($homepage['body']):
              echo $homepage['body'];
      else: ?>
          Come to Rodem fellowship to:<br>
          practice your <strong>English,</strong>
          make <strong>international friends</strong>,<br>
          and find out about <strong>Christianity</strong>
    <?php endif?>
      </p>
      <a class="btn btn-CTA" href="./meetings.php">next meeting</a>
    </div>
  </article>
</main>
<?php
include('./templates/footer.php');
?>
