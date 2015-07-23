<?php
include('./templates/header.php');
$events = $rodemHouseAdmin->getEventList();
if ($_POST) {
  $action = $rodemHouseAdmin->selectEventEditAction($_POST['affect'],$_POST['action']);
}
?>
<?= (!isset($action))? '<form class="events" action="'.$_SERVER['PHP_SELF'].'" method="POST">' : '' ?>

<main  class="editor">
  <div class="banner">
    <h1 class="col-md-4 center-block" >events</h1>
  </div>
  <p class="breadcrumb">website editor > events</p>
  <article>
    <?php if(!isset($action)):?>
    <div class="container">
        <p class="user-type pull-right">logged in as <?= $_SESSION['usertype']?></p>
        <input type="submit" class="btn btn-ADD" name="action[add]" value="add new  +" >
        <table>
          <tr>
            <th>Title</th>
            <th>Date</th>
            <th>Category</th>
            <th></th>
            <th>Select</th>
          </tr>
          <?php foreach($events as $event):?>
            <tr>
              <td><?= $event['event_title']?></td>
              <td><?= gmdate("d-m-Y H:i:s ", $event['datetime'])?></td>
              <td><?= $event['category_title']?></td>
              <td><strong><?= (intval($event['featured']) )? "featured" : "" ?></strong></td>
              <td><input type="checkbox" name="affect[<?= $event['ID']?>]" value=""></td>
            </tr>
          <?php endforeach?>
        </table>
    </div>
  <?php else:
    echo '<form class="events" action="'.$_SERVER['PHP_SELF'].'" method="POST">';
      include('./_event_form.php');
    echo '<form>';
  endif;?>
  </article>
</main>
<?php
include('./templates/footer.php');
?>
