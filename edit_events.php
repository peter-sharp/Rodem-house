<?php
include('./templates/header.php');
?>
<form class="events" action="index.html" method="post">

<main>
  <h1 class="col-md-4 center-block" >events</h1>
  <div class="container">
    <p>website editor > events</p>
    <section class="editor">
      <p>logged in as ADMIN</p>
      <button type="button">add new</button>
      <table>
        <tr>
          <th>Title</th>
          <th>Date</th>
          <th>Category</th>
          <th></th>
          <th>Select</th>
        </tr>
        <tr>
          <td>Ice Skating</td>
          <td>12/1/2016</td>
          <td>social event</td>
          <td><strong>featured</strong></td>
          <td><input type="checkbox" name="select" value=""></td>
        </tr>
      </table>
    </section>
  </div>
</main>
<?php
include('./templates/footer.php');
?>
