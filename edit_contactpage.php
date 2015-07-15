<?php
include('./templates/header.php');
?>
<form class="pages" action="index.html" method="post">

<main>
  <h1 class="col-md-4 center-block" >edit<br><small>contact page</small></h1>
  <div class="container">
    <p>website editor > home page</p>
    <section class="editor">
      <p>logged in as ADMIN</p>
      <label for="cellphone">cellphone number</label>
      <input type="tel" name="cellphone" value="">

      <label for="phone">cellphone number</label>
      <input type="tel" name="phone" value="">

      <label for="email">cellphone number</label>
      <input type="email" name="email" value="">

      <label for="address">cellphone number</label>
      <input type="text" name="address" value="">

      <a class="btn btn-back" name="change">back</button>
      <button class="btn btn-CTA" type="submit" name="change">change</button>
    </section>
  </div>
</main>
<?php
include('./templates/footer.php');
?>
