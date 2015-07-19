<?php
include('./templates/header.php');
?>
<form class="pages" action="index.html" method="post">

<main>
  <h1 class="col-md-4 center-block" >edit<br><small>contact page</small></h1>
  <article class="editor">
    <div class="container">
      <p class="breadcrumb">website editor > home page</p>
        <p class="user-type pull-right">logged in as <?= $_SESSION['usertype']?></p>
        <label for="cellphone">cellphone number</label>
        <input type="tel" name="cellphone" value="">

        <label for="phone">cellphone number</label>
        <input type="tel" name="phone" value="">

        <label for="email">cellphone number</label>
        <input type="email" name="email" value="">

        <label for="address">cellphone number</label>
        <input type="text" name="address" value="">

        <a class="btn btn-back" name="change">back</a>
        <button class="btn btn-CTA" type="submit" name="change">change</button>
    </div>
  </article>
</main>
<?php
include('./templates/footer.php');
?>
