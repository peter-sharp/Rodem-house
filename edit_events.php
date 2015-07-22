<?php
include('./templates/header.php');
$events = $rodemHouseAdmin->getEventList();

?>
<form class="events" action="index.html" method="post">

<main  class="editor">
  <div class="banner">
    <h1 class="col-md-4 center-block" >events</h1>
  </div>
  <p class="breadcrumb">website editor > events</p>
  <article>
    <div class="container">
        <p class="user-type pull-right">logged in as <?= $_SESSION['usertype']?></p>
        <button type="button" class="btn btn-ADD">add new</button>
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
              <td><input type="checkbox" name="select" value=""></td>
            </tr>
          <?php endforeach?>
        </table>
    </div>
  </article>
</main>
<?php
include('./templates/footer.php');
?>
