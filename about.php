<?php
include('./templates/header.php');
$aboutBody = $rodemHouse->getPageContent('about us')['body'];

?>
<main class="about">
  <div class="banner">
    <h1 class="col-md-4 center-block" >about us</h1>
  </div>
  <article>
    <div class="container">
      <div class="site wrapper">
        <?php if($aboutBody):
                echo $aboutBody;
        else: ?>
        <h2>who we are</h2>
        <p>Rodem House is a charitable trust organization <small>(Registration No: CC10913)</small> to support missionaries
          and pastors who need rest and refreshment. Also we support international people who come to
          Christchurch. Rodem house is a faith mission operated by prayer and the support of Christians.</p>
        <?php endif?>
      </div>
    </div>
  </article>
</main>
<?php
include('./templates/footer.php');
?>
