<?php
include('./templates/header.php');
?>
<form class="pages" action="index.html" method="post">

<main>
  <h1 class="col-md-4 center-block" >edit<br><small>home page</small></h1>
  <div class="container">
    <p>website editor > home page</p>
    <section class="editor">
      <p>logged in as <?= $_SESSION['usertype']?></p>
      <label for="intro">introduction text</label>
      <textarea  name="intro" ></textarea>

      <a class="btn btn-back" name="change">back</a>
      <button class="btn btn-CTA" type="submit" name="change">change</button>
    </section>
  </div>
</main>
<?php
include('./templates/footer.php');
?>
