<?php
include('./templates/header.php');
?>
<script src="https://maps.googleapis.com/maps/api/js"></script>
<main class="english">
  <div class="banner">
    <h1 class="col-md-4 center-block" >english lessons</h1>
  </div>
  <article >
    <div class="container">
      <h2>There are free classes every second Tuesday at 4:30pm</h2>
      <p>Classes are relaxed and fun. Our tutor Nancy will help you practice and improve your <strong>speaking</strong>,
      <strong>vocabulary</strong> and <strong>grammar</strong> skills.</p>
      <p>English learners of all abilities are always welcome.</p>
      <p class="map_caption">lessons are at 344 Manchester St, Christchurch Central, Richmond 8013</p>

      <div class="map" id="Rodem Fellowship"
      data-location-x="-43.518982"
      data-location-y="172.640104"
      data-zoom="17"></div>
    </div>
  </article>
  <script src="./scripts/maps.js"></script>
</main>
<?php
include('./templates/footer.php');
?>
