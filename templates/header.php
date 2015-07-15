<?php
    $currentPage = basename($_SERVER['PHP_SELF'],'.php');
    $pages = array(
      'index' => 'home',
      'about' => 'about us',
      'meetings' => 'meetings',
      'contact' => 'contact',
      'english' => '<small>free</small></br>English lessons'
    );
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rodem House</title>

  <!-- bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="./css/styles.css" type="text/css"/>
<!-- fonts -->
<link rel="stylesheet" href="./font-awesome-4.3.0/css/font-awesome.min.css"> <!-- credit to Font Awesome for the icons. -->
<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto+Condensed|Roboto+Slab' type='text/css'>
</head>
<body>
  <header >
    <div class="container center-block">
      <h1 class="logo "><a href="./index.php">Rodem House</a></h1>

      <nav class="col-md-8 ">
        <ul>
          <?php foreach ($pages as $pageId => $pageTitle): ?>
          <li <?=(($currentPage == $pageId) ? 'class="active"' : '') ?>><a href="./<?=$pageId?>.php" ><?=$pageTitle?></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>
        </ul>
      </nav>
    </div>
  </header>
  <?php if ( /* !$authenticator->isAuthenticated() */ false ): #'class="active"'?>
    <main>
      <h1><small>website editor</small><br>login</h1>
      <section class="login">
        <label for="username">user name</label>
        <input type="text" name="username" value="">

        <label for="password">password</label>
        <input type="password" name="password" value="">

        <button class="btn btn-CTA" type="submit" name="login">log in</button>
      </section>
    </main>
  <?php endif ?>
