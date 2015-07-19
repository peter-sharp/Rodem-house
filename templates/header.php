<?php
    require_once('authenticator.php');
    $authenticator = new AuthenticatorHelper();
    //database.php already required in authenticator, so:
    $database = new DatabaseHelper();

    $currentPage = basename($_SERVER['PHP_SELF'],'.php');
    $editorPage = strpos($currentPage, 'edit') !== FALSE ;
    $pages = ($authenticator->isAuthenticated()) ?
          array(
            'editor' => 'editor home',
            'edit_events' => 'events',
            'edit_homepage' => 'home page',
            'edit_aboutpage' => 'about us page',
            'edit_meetingspage' => 'meetings page',
            'edit_contactpage' => 'contact page',
            'edit_englishpage' => 'English lessons page'
          )
        : array(
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
      <?php if($authenticator->isAuthenticated()):?><a href="./<?=$pageId?>.php?logout=yes" class="pull-right">logout</a><?php endif?>
    </div>
  </header>
  <?php if ( $editorPage && !$authenticator->isAuthenticated()  ): ?>
    <main>
      <h1><small>website editor</small><br>login</h1>
      <section class="login">

        <form method="POST" action="<?= $_SERVER['PHP_SELF']?>">

          <div class="form-group">
            <label for="login[email]">email</label>
            <div class="input-group">
              <input type="text" id="name" name="login[email]" class="form-control" value="<?= (isset($_POST['login[email]']) )? $_POST['login[email]'] : ""?>">
              <span class="input-group-addon"></span>
            </div>
          </div>

          <div class="form-group">
            <label for="login[password]">password</label>
            <div class="input-group">
              <input type="password" id="name" name="login[password]" class="form-control">
              <span class="input-group-addon"></span>
            </div>
          </div>

          <input  type="submit"  name="submit" id="submit" value="log in" class="btn btn-CTA pull-right">
        </form>
      </section>
    </main>
  <?php endif ?>
