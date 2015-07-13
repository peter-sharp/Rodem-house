<?php
include('./templates/header.php');
?>
<form class="pages" action="index.html" method="post">

<main>
  <h1>edit<br><small>home page</small></h1>
  <p>website editor > home page</p>
  <section class="editor">
    <p>loged in as ADMIN</p>
    <label for="intro">introduction text</label>
    <textarea  name="intro" ></textarea>

    <a class="btn btn-back" name="change">back</button>
    <button type="submit" name="change">change</button>
  </section>
</main>
<?php
include('./templates/footer.php');
?>
