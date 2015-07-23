<?php
    require_once('class.authenticator.php');
    require_once('class.rodem_house.administrator.php');
    $authenticator = new AuthenticatorHelper();
    //database.php already required in authenticator, so:
    $database = new DatabaseHelper();

    $rodemHouse = new RodemHouse();
    $rodemHouseAdmin = new RodemHouseAdmin();

    $currentPage = basename($_SERVER['PHP_SELF'],'.php');
    $editorPage = strpos($currentPage, 'edit') !== FALSE ;
    $editorpages = $rodemHouse->navItems['editorPages'];
    $pages = $rodemHouse->navItems['pages'];
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
  <header <?= ($authenticator->isAuthenticated())? 'class="editor"' : '' ;?>>
    <div class="container center-block">
      <h1 class="logo "><a href="./index.php">Rodem House</a></h1>

      <nav class="pull-right">
        <ul >
          <?php foreach ($pages as $pageId => $pageTitle): ?>
          <li <?=(($currentPage == $pageId) ? 'class="active"' : '') ?>><span><a href="./<?=$pageId?>.php" ><?=$pageTitle?></a></span></li>
          <?php endforeach; ?>
        </ul>

        <ul >
          <?php if($authenticator->isAuthenticated()):?>
            <?php foreach ($editorpages as $pageId => $pageTitle): ?>
              <li <?=(($currentPage == $pageId) ? 'class="active"' : '') ?>><span><a href="./<?=$pageId?>.php" ><?=$pageTitle?></a></span></li>
            <?php endforeach; ?>
            <li class="logout pull-right"><a href="./<?=$pageId?>.php?logout=yes" ><b>logout</b></a></li>
          <?php else:?>
            <li class="login pull-right"><span class="icon-login"></span><a href="./editor.php"><small>login</small></a></li>
          <?php endif;?>
        </ul>
      </nav>
    </div>
  </header>
  <?php if ( $editorPage && !$authenticator->isAuthenticated()  ): ?>
    <main class="editor">
    <div class="banner login">
        <h1><small>website editor</small><br>login</h1>
      <section >

        <form method="POST" action="<?= $_SERVER['PHP_SELF']?>" class="col-md-3 center-block login" >

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
    </div>
    </main>
  <?php endif;
