<?php
include('./templates/header.php');
?>

  <form class="pages" action="index.html" method="post">

  <main>
    <h1 class="col-md-4 center-block" >edit<br><small>about us page</small></h1>
  <article class="editor">
      <div class="container">
      <p class="breadcrumb">website editor > about page</p>
        <p class="user-type pull-right">logged in as <?= $_SESSION['usertype']?></p>
        <label for="about">about us text</label>
        <textarea  name="about" ></textarea>

        <a class="btn btn-back" name="change">back</a>
        <button class="btn btn-CTA" type="submit" name="change">change</button>
    </div>
  </article>
</main>
<?php
include('./templates/footer.php');
?>
