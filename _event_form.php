<div class="col-md-5 center-block">
  <div class="form-group">
    <label for="category">Category</label>
    <?php if($action['type'] !== 'view'): ?>
      <select  name="<?= $action['type']?>[category]"  class="form-control" >
        <option value="rodem fellowship" selected="<?= ($show['category_title'] === 'rodem fellowship')? "selected" : ""?>">rodem fellowship</option>
        <option value="bible study" selected="<?= ($show['category_title'] === 'bible study')? "selected" : ""?>">bible study</option>
        <option value="social events" selected="<?= ($show['category_title'] === 'social events')? "selected" : ""?>">social events</option>
      </select>
    <?php else: ?>
      <input  type="text" name="category" READONLY value="<?= $show['category_title']?>" class="form-control">
    <?php endif ?>
  </div>

  <div class="form-group">
    <label >Title</label>
    <input  type="text" name="<?= $action['type']?>[title]" <?= ($readonly)? 'READONLY' : '' ?>value="<?= $show['event_title']?>" class="form-control">
  </div>

  <div class="form-group">
    <label >Image to display</label>
    <?php if(!$action['type'] !== 'view'): ?>
      <select  name="<?= $action['type']?>[image]"  class="form-control" selected="<?= $show['image_title']?>">
        <option value="guest speaker" selected="<?= ($show['image_title'] === 'social events')? "guest speaker" : ""?>">guest speaker</option>
        <option value="ice skating" selected="<?= ($show['image_title'] === 'social events')? "ice skating" : ""?>">ice skating</option>
      </select>
    <?php else: ?>
      <img  name="image"  src="<?= $edit_event['image']['location']?>" alt="<?= $edit_event['image_title']['description']?>">
    <?php endif ?>
  </div>

  <div class="form-group">
    <label >Description</label>
    <textarea name="<?= $action['type']?>[description]" <?= ($readonly)? 'READONLY' : '' ?> class="form-control"><?= $show['event_description']?><?= (isset($_POST[$action['type']."[description]"]) )? $_POST[$action['type']."[description]"] : ""?></textarea>
    </div>

  <div class="form-group">
    <label >Address</label>
    <input  type="text" name="<?= $action['type']?>[address]" <?= ($readonly)? 'READONLY' : '' ?>value="<?= $show['address']?>" class="form-control">
  </div>

  <div class="form-group">
    <label >Time</label>
    <input  type="datetime-local" name="<?= $action['type']?>[datetime]" <?= ($readonly)? 'READONLY' : '' ?>value="<?= $show['datetime']?>" class="form-control">
  </div>

  <div class="form-group">
    <label for="featured">Featured?</label>
    <input  type="checkbox" name="<?= $action['type']?>[featured]" <?= ($readonly)? 'READONLY' : '' ?>checked="<?= $show['featured']?>" >
  </div>

  <a class="btn btn-back" name="change" href="./edit_events.php" >back</a>
  <input class="btn <?= ($action['type'] === 'add')? 'btn-ADD' : 'btn-CTA'?> pull-right" type="submit" name="submit" value="<?= $action['type']?>">
</div>
