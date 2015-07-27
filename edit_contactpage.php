<?php
include('./templates/header.php');
?>
<form class="pages" action="index.html" method="post">

<main class="editor">
  <div class="banner">
    <h1 class="col-md-4 center-block" >edit<br><small>contact page</small></h1>
    <p class="breadcrumb">website editor > home page</p>
  </div>
  <article>
    <div class="container">

        <p class="user-type pull-right">logged in as <?= $_SESSION['usertype']?></p>
        <div class="col-md-4 center-block">
          <div class="form-group">
            <label for="cellphone">cellphone number</label>
            <input type="tel" name="cellphone" value="" class="form-control">

            <label for="phone">phone number</label>
            <input type="tel" name="phone" value="" class="form-control">

            <label for="email">email</label>
            <input type="email" name="email" value="" class="form-control">

            <label for="address">address</label>
            <input type="text" name="address" value="" class="form-control">

            <a class="btn btn-back" name="change" href="./editor.php">back</a>
            <button class="btn btn-CTA pull-right" type="submit" name="change">change</button>
          </div>
        </div>
    </div>
  </article>
</main>
<?php
include('./templates/footer.php');
?>
