<?php
$editorPage = false;
 if ($editorPage === true):?>
  <footer>
    <p>What would you like to do with the selected activities?</p>
    <button type="button">delete</button>
    <button type="button">view</button>
    <button type="button">edit</button>
  </footer>
</form>
<?php else:?>
<footer> <span>&copy; Rodem House</span> <a href="editor.php">login</a> </footer>
<?php endif?>
</body>
</html>
