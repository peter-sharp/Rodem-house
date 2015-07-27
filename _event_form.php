<div class="col-md-5 center-block">
  <div class="form-group">
    <label for="category">Category</label>
    <?php if(!$readonly): ?>
      <select  name="<?= $action['type']?>[category]"  class="form-control">
        <option value="fellowship">rodem fellowship</option>
        <option value="social">social events</option>
      </select>
    <?php else: ?>
      <input  type="text" name="category" READONLY value="<?= $edit_event['category']?>" class="form-control">
    <?php endif ?>
  </div>

  <div class="form-group">
    <label >Title</label>
    <input  type="text" name="<?= $action['type']?>[title]" <?= ($readonly)? 'READONLY' : '' ?>value="<?= $edit_event['title']?>" class="form-control">
  </div>

  <div class="form-group">
    <label >Image to display</label>
    <?php if(!$readonly): ?>
      <select  name="<?= $action['type']?>[image]"  class="form-control">
        <option value="speaker">Guest speaker</option>
        <option value="coffee">Coffee and talk</option>
      </select>
    <?php else: ?>
      <img  name="image"  src="<?= $edit_event['image']['location']?>" alt="<?= $edit_event['image']['description']?>">
    <?php endif ?>
  </div>

  <div class="form-group">
    <label >Description</label>
    <textarea name="<?= $action['type']?>[description]" <?= ($readonly)? 'READONLY' : '' ?> class="form-control"><?= $edit_event['description']?></textarea>
    </div>

  <div class="form-group">
    <label >Address</label>
    <input  type="text" name="<?= $action['type']?>[address]" <?= ($readonly)? 'READONLY' : '' ?>value="<?= $edit_event['address']?>" class="form-control">
  </div>

  <div class="form-group">
    <label >Time</label>
    <input  type="datetime-local" name="<?= $action['type']?>[datetime]" <?= ($readonly)? 'READONLY' : '' ?>value="<?= $edit_event['datetime']?>" class="form-control">
  </div>

  <div class="form-group">
    <label for="featured">Featured?</label>
    <input  type="checkbox" name="<?= $action['type']?>[featured]" <?= ($readonly)? 'READONLY' : '' ?>value="<?= $edit_event['featured']?>" >
  </div>

  <a class="btn btn-back" name="change">back</a>
  <input class="btn <?= ($action['type'] === 'add')? 'btn-ADD' : 'btn-CTA'?> pull-right" type="submit" name="submit" value="<?= $action['type']?>">
</div>
