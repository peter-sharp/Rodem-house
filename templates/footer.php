<?php $edit_events = ($currentPage === 'edit_events' && !isset($action));
if ($edit_events && $authenticator->isAuthenticated()):?>
  <footer>
    <div class="container">
      <p class="col-md-6 center-block">What would you like to do with the selected activities?</p>
      <img class="icon" src="./images/icons/delete.svg" alt="trash-can icon" /><input type="submit" name="action[delete]" value="delete" >

      <div class="pull-right">
        <img class="icon" src="./images/icons/view.svg" alt="binoculars icon" /><input type="submit" name="action[view]" value="view" >
        <img class="icon" src="./images/icons/edit.svg" alt="pencil icon" /><input type="submit" name="action[edit]" value="edit" >
      </div>
    </div>
  </footer>
</form>
<?php else:?>
<footer>
  <div class="container">
    <span>&copy; Rodem House</span>
  </div>
</footer>
<?php endif; ?>
</body>
</html>
