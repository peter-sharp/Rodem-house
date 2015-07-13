<div class="form-group">
  <label for="category">Category</label>
  <?php if(!$readonly): ?>
    <select  name="category" >
      <option value="fellowship">Rodem Fellowship</option>
      <option value="social">Social event</option>
    </select>
  <?php else: ?>
    <input  type="text" name="category" READONLY value="<?= $edit_event['category']?>">
  <?php endif ?>
</div>

<div class="form-group">
  <label for="title">Title</label>
  <input  type="text" name="title" <? if($readonly) echo 'READONLY' ?>value="<?= $edit_event['title']?>">
</div>

<div class="form-group">
  <label for="image">Image to display</label>
  <?php if(!$readonly): ?>
    <select  name="image" >
      <option value="speaker">Guest speaker</option>
      <option value="coffee">Coffee and talk</option>
    </select>
  <?php else: ?>
    <img  name="image"  src="<?= $edit_event['image']['location']?>" alt="<?= $edit_event['image']['description']?>">
  <?php endif ?>
</div>

<div class="form-group">
  <label for="description">Description</label>
  <textarea name="description" <? if($readonly) echo 'READONLY' ?>><?= $edit_event['description']?></textarea>
  </div>

<div class="form-group">
  <label for="address">Address</label>
  <input  type="text" name="address" <? if($readonly) echo 'READONLY' ?>value="<?= $edit_event['address']?>">
</div>

<div class="form-group">
  <label for="datetime">Time</label>
  <input  type="datetime-local" name="datetime" <? if($readonly) echo 'READONLY' ?>value="<?= $edit_event['datetime']?>">
</div>

<div class="form-group">
  <label for="featured">Featured?</label>
  <input  type="checkbox" name="featured" <? if($readonly) echo 'READONLY' ?>value="<?= $edit_event['featured']?>">
</div>

<a class="btn btn-back" name="change">back</button>
<button class="btn btn-CTA" type="submit" name="change"><?= $actionType?></button>
