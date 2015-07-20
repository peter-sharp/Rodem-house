<?php $edit_events = ($currentPage === 'edit_events');
if ($edit_events && $authenticator->isAuthenticated()):?>
  <footer>
    <div class="container">
      <p>What would you like to do with the selected activities?</p>
      <button type="button">delete</button>
      <button type="button">view</button>
      <button type="button">edit</button>
    </div>
  </footer>
</form>
<?php else:?>
<footer>
  <div class="container">
    <span>&copy; Rodem House</span> <?= ($authenticator->isAuthenticated())? "" : "<div class=\"login pull-right\"><span class=\"icon-login\"></span><a href=\"editor.php\">login</a></div>" ; ?>
  </div>
</footer>
<?php endif?>
</body>
</html>
