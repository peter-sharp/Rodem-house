<?php
include('./templates/header.php');
?>

  <form class="pages" action="index.html" method="post">

  <main>
    <h1 class="col-md-4 center-block" >edit<br><small>English lessons page</small></h1>
    <p>website editor > English page</p>
    <div class="container">
      <section class="editor">
        <p>logged in as <?= $_SESSION['usertype']?></p>
        <label for="about">English lessons description text</label>
        <textarea  name="about" ></textarea>

        <label for="time">time</label>
        <input type="time" name="time" value="">

        <a class="btn btn-back" name="change">back</a>
        <button class="btn btn-CTA" type="submit" name="change">change</button>
      </section>
    </div>
</main>
<?php
include('./templates/footer.php');
?>
