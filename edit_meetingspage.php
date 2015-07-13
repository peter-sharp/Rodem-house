<?php
include('./templates/header.php');
?>
<form class="pages" action="index.html" method="post">

<main>
  <h1>edit<br><small>meetings page</small></h1>
  <p>website editor > meetings page</p>
  <section class="editor">
    <p>loged in as ADMIN</p>
    <h2>rodem fellowship meeting</h2>
    <label for="intro">Rodem fellowship introduction text</label>
    <textarea  name="intro" ></textarea>
  
    <a class="btn btn-back" name="change">back</button>
    <button class="btn btn-CTA" type="submit" name="change">change</button>
</main>
<?php
include('./templates/footer.php');
?>
