<?php
include('./templates/header.php');
?>

  <form class="pages" action="index.html" method="post">

  <main class="editor">
    <div class="banner">
      <h1 class="col-md-4 center-block" >edit<br><small>English lessons page</small></h1>
    </div>
    <p class="breadcrumb">website editor > English page</p>
    <article>
      <div class="container">
          <p class="user-type pull-right">logged in as <?= $_SESSION['usertype']?></p>
          <label for="about">English lessons description text</label>
          <textarea  name="about" ></textarea>

          <label for="time">time</label>
          <input type="time" name="time" value="">

          <a class="btn btn-back" name="change">back</a>
          <button class="btn btn-CTA" type="submit" name="change">change</button>
      </div>
    </article>
</main>
<?php
include('./templates/footer.php');
?>
