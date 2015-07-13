<?php

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
  <title>Rodem House</title>
</head>
<body>
  <header>
    <h1 class="logo">Rodem House</h1>
    <nav>
      <ul>
        <?php foreach ($pages as $pageId => $pageTitle): ?>
        <li <?=(((basename($_SERVER['PHP_SELF'])) == $pageId) ? 'class="active"' : '')?>><a href="./<?=$pageId?>.php" ><?=$pageTitle?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>
  </header>
  <?php if ( /* !$authenticator->isAuthenticated() */ false ): ?>
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
