<?php
include('./templates/header.php');
?>
<main class="meetings">
  <div class="banner">
    <h1 class="col-md-4 center-block" >meetings</h1>
    <noscript> Please enable javascript for full site functionality.</noscript>
  </div>
  <article class="meetings">
    <div class="container">
      <div class="accordion_tab fellowship">
        <div class="arrow_right"></div>
        <h2 class="">international fellowship</h2>
      </div>
      <section class="fellowship">
        <p>Enjoy a meal, friendship, and learn more about
          Christianity every Tuesday at 6pm.</p>
        <div class="event">
          <h3>This week's event</h3>
          <P>This is the description for what will happen next Rodem fellowship.
          This could be a game night, guest speaker or any other type of event. It should
          be a reasonable description but not too long or else people might loose interest.</P>
          <p class="map_caption">Find us at 12 Some St</p>
          <div class="map"></div>
        </div>
      </section>

      <div class="accordion_tab social">
        <div class="arrow_right"></div>
        <h2 class="">social event</h2>
      </div>
      <section class="social">
        <div class="event">
          <h3>Come ice-skating with us</h3>
          <P>This is the description for the up-comming social event.
          Here you can put some text to interest people in coming an other details
          like what they need to bring, what will happen if itrains etc.</P>
          <p class="map_caption">Be there by 5:45pm at Some other St</p>
          <div class="map"></div>
        </div>

      </section>
    </div>
  </article>
</main>
<script src="./scripts/accordion.js" type="text/javascript"></script>
<?php
include('./templates/footer.php');
?>
