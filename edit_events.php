<?php
include('./templates/header.php');

$events = $database->getRowsFromTable('events', array('event_title','datetime','category_title','featured'), "INNER JOIN `categories` ON `categories`.ID = `events`. category_id");
?>
<form class="events" action="index.html" method="post">

<main>
  <h1 class="col-md-4 center-block" >events</h1>
  <div class="container">
    <p>website editor > events</p>
    <section class="editor">
      <p>logged in as <?= $_SESSION['usertype']?></p>
      <button type="button">add new</button>
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
            <td><?= gmdate("d-m-Y\ H:i:s\ ", $event['datetime'])?></td>
            <td><?= $event['category_title']?></td>
            <td><strong><?= (intval($event['featured']) )? "featured" : "" ?></strong></td>
            <td><input type="checkbox" name="select" value=""></td>
          </tr>
        <?php endforeach?>
      </table>
    </section>
  </div>
</main>
<?php
include('./templates/footer.php');
?>
