<?php
include('./templates/header.php');
?>

  <form class="pages" action="index.html" method="post">

  <main>
    <h1>edit<br><small>English lessons page</small></h1>
    <p>website editor > English page</p>
    <section class="editor">
      <p>logged in as ADMIN</p>
      <label for="about">English lessons description text</label>
      <textarea  name="about" ></textarea>

      <label for="time">time</label>
      <input type="time" name="time" value="">

      <a class="btn btn-back" name="change">back</button>
      <button class="btn btn-CTA" type="submit" name="change">change</button>
    </section>
</main>
<?php
include('./templates/footer.php');
?>
