<?php
include('./templates/header.php');
?>

  <form class="pages" action="index.html" method="post">

  <main>
    <h1>edit<br><small>about us page</small></h1>
    <p>website editor > about page</p>
    <section class="editor">
      <p>loged in as ADMIN</p>
      <label for="about">about us text</label>
      <textarea  name="about" ></textarea>

      <a class="btn btn-back" name="change">back</button>
      <button class="btn btn-CTA" type="submit" name="change">change</button>
    </section>
</main>
<?php
include('./templates/footer.php');
?>
