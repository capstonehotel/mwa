
<?php include "availability_search.php"; ?>
   <!-- Projects Row -->
   <div class="card" style="margin-top: 10px;">
      <div class="card-header">
        <h1>Welcome to our Mini Hotel</h1>
      </div>
      <div class="card-body">
        <div class="col-md-12">
           <!-- <a href="portfolio-item.html"> -->
                <img style="width: 100%;" class="" src="https://mcchmhotelreservation.com/images/room1.jpg" alt="">
            <!-- </a>   -->
        </div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-6" >
                <h3>Contact Info</h3>
                <div class="space"></div>
              <p><i class="fa fa-building-o fa-fw pull-left fa-2x"></i><span class="link-text" onclick="window.location.href='https://web.facebook.com/madridejoscollege';">Madridejos Community College</span></p>
              <div class="space"></div>
              <div class="space"></div>
              <p><i class="fa fa-map-marker fa-fw pull-left fa-2x"></i><span class="link-text" onclick="window.location.href='https://www.google.com/maps/place/Madridejos+Community+College/@11.2636504,123.7209869,17z/data=!3m1!4b1!4m6!3m5!1s0x33a88140310a21a9:0xc5b9b94e9c2702db!8m2!3d11.2636451!4d123.7235618!16s%2Fg%2F1hc28c7s2?entry=ttu';">Crossing Bunakan Madridejos Cebu</span></p>
              <div class="space"></div>
              <p><i class="fa fa-envelope-o fa-fw pull-left fa-2x"></i><span class="link-text" onclick="window.location.href='mailto:Hmhotel@gmail.com';">Hmhotel@gmail.com</span></p>
              <div class="space"></div>
              <p><i class="fa fa-phone fa-fw pull-left fa-2x"></i><span class="link-text" onclick="window.location.href='tel:+1234567890';">09317622381</p>
              <p><i class="fa fa-facebook fa-fw pull-left fa-2x"></i><span class="link-text" onclick="window.location.href='https://web.facebook.com/p/Madridejos-Community-College-Hospitality-Management-Department-100054453806197/?paipv=0&eav=AfYUS3bOnNWDmiBS86XIEqDgKwonPli4DFEY8cjKFQSxZq-ZEAJASAViws-aNONi-rM&_rdc=1&_rdr';">Hospitality Management Department</span></p>
              <div class="space"></div>
            </div>
            <div class="col-md-6" >
                <div class="page-header"><h2>Type Of Rooms</h2></div>
                <div class="list-group">
                
                    <?php
                          $query = "SELECT distinct(ROOM) FROM `tblroom` ";
                         $mydb->setQuery($query);
                         $cur = $mydb->loadResultList();  
                            ?>
                            
                      <?php  foreach ($cur as $result) { ?>
                        <a class="list-group-item list-group-item-action" href="https://mcchmhotelreservation.com/index.php?p=rooms&q=<?php echo $result->ROOM; ?>" ><?php echo $result->ROOM; ?></a>
                      <?php  } ?>
                      </div>
            </div>
            <div class="col-md-12" style="margin-top: 20px;">
                <div id="carouselExampleCaptions" class="carousel slide" style="max-height: 800px; display: flex; align-items: center; background-color: whitesmoke; padding: 20px;">
                  <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                  </div>
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <img src="https://mcchmhotelreservation.com/images/room.jpg" class="d-block w-100" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Standard Room</h5>
                        <p>&#8369 800</p>
                      </div>
                    </div>
                    <div class="carousel-item">
                      <img src="https://mcchmhotelreservation.com/images/room1.jpg" class="d-block w-100" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Travellers Time</h5>
                        <p>&#8369 1000</p>
                      </div>
                    </div>
                    <div class="carousel-item">
                      <img src="https://mcchmhotelreservation.com/images/header-bg1.jpg" class="d-block w-100" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Bayanihan Rooms</h5>
                        <p>&#8369 1000</p>
                      </div>
                    </div>
                  </div>
                  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
                </div>
            </div>
        </div>
        
      </div>
    </div>

                
                