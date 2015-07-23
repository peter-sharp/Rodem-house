<?php $edit_events = ($currentPage === 'edit_events');
if ($edit_events && $authenticator->isAuthenticated()):?>
  <footer>
    <div class="container">
      <p class="col-md-5 center-block">What would you like to do with the selected activities?</p>
      <input type="submit" value="delete" >

      <div class="pull-right">
        <input type="submit" value="view" >
        <input type="submit" value="edit" >
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
