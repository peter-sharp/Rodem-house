<?php
include('./templates/header.php');
?>
<script src="https://maps.googleapis.com/maps/api/js"></script>
<main class="contact">

  <div class="banner">
    <h1 class="col-md-4 center-block" >contact</h1>
  </div>
  <article itemscope itemtype="http://schema.org/Person">
    <div class="container">
      <p>
        <img src="./images/icons/mobile.svg" alt="mobile phone icon" /> 022 333 4444
      </p>
      <p>
        <img src="./images/icons/phone.svg" alt="phone handset icon" /> 03 444 5556
      </p>
      <p>
        <img src="./images/icons/letter.svg" alt="letter icon" /> person@rodemhouse.org
      </p>
      <p>
        <img src="./images/icons/map_pin.svg" alt="map pin icon" /> 344 Manchester St, Christchurch Central, Richmond 8013
      </p>

      <div class="map" id="Rodem Fellowship"
      data-location-x="-43.518982"
      data-location-y="172.640104"
      data-zoom="17">
      </div>
    </div>
  </article>
  <script src="./scripts/maps.js"></script>
</main>
<?php
include('./templates/footer.php');
?>
