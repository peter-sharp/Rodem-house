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
