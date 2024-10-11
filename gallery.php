<style>
.card {
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  width: 100%;
  height: 270px;
  text-align: center;
  border-radius: 5px;
  background-color: brown;
  color: white;

}
img{
  border-radius: 15px;

}




.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
  background-color: white;
  color: black;
}

/*.container {
  padding:2px;
}*/
</style>
<div class="container-fluid">


  <?php 
          $conn = mysqli_connect("localhost","root","","southgatedb"); 
          $sqlii = "SELECT * from tblroom ";
          $result = mysqli_query($conn, $sqlii);

          if (mysqli_num_rows($result) > 0) {
         
            ?>  
  
<div class="row">
  <?php  while ($row = mysqli_fetch_assoc($result)) { ?>
   <div class="col-sm-3">
    <a href="#">
    <div class="card">
        <img src="../images/<?php echo $row['ROOMIMAGE']?>" class="img-responsive" alt="image" style="height: 150px;">
        <p><?php  echo $row['PRICE'] ?> <br>ROOM TYPE <br> <?php  echo $row['ROOM'] ?><br><?php  echo $row['ROOMDESC'] ?>  </p>

    </div>
    </a>
  </div>
      <?php
       } 
      }
      ?>



   
</div>


</div>
