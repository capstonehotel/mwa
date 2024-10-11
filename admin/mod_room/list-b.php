
<div class="container">
	<?php
		check_message();
			
		?>
		<!-- <div class="panel panel-primary"> -->
		<div class="col bg-light text-right">
			<div class="panel-body">
			<div class="btn-group-align-text-right">
	
				  <a href="index.php?view=add" class="btn btn-primary">New</a>
				  <!-- <button type="submit" class="btn btn-danger" name="delete"><span class="glyphicon glyphicon-trash"></span> Delete Selected</button> -->
				</div>
			<h3 align="left">List of Rooms</h3>
			    <form action="controller.php?action=delete" Method="POST">  					
				<table id="example" style="font-size:12px" class="table table-striped table-hover table-responsive"  cellspacing="0">
						
				  <thead>
				  	<tr  >
				  	<th>No.</th>
				  		<th align="left"  width="100">
				  		 <input type="checkbox" name="chkall" id="chkall" onclick="return checkall('selector[]');"> 
				  		Image</th>
				  		<!-- <th>Room#</th> -->
				  		<th align="left"  width="200">Room</th>	
				  		<!-- <th align="left" width="120">Description</th> -->
				  		<th align="left" width="120">Accomodation</th> 
				  		<th align="left" width="90">Person</th>
				  		<th align="left"  width="200">Price</th>
				  		<th># of Rooms</th>
				  		<th></th>
				  	</tr>	
				  </thead>
				  <tbody>
				  	<?php 
				  		$mydb->setQuery("SELECT *,ACCOMODATION FROM tblroom r, tblaccomodation a WHERE r.ACCOMID = a.ACCOMID ORDER BY  ROOMID ASC ");
				
				  		$cur = $mydb->loadResultList();

						foreach ($cur as $result) {
							if(!is_file($result->ROOMIMAGE))
							$result->ROOMIMAGE = WEB_ROOT.'high.jpg';
				  		echo '<tr>';
						echo '<td width="5%" align="center"></td>';
				  		echo '<td align="left"  width="120"><input type="checkbox" name="selector[]" id="selector[]" value="'.$result->ROOMID. '"/> 
				  				<a href="#"  class="roomImg" data-id="'.$result->ROOMID.'" title="Click here to Change Image."><img src="'. $result->ROOMIMAGE.'" width="60" height="40" title="'. $result->ROOM .'"/></a></td>';
				  		// echo '<td><a href="index.php?view=edit&id='.$result->ROOMID.'">' . ' '.$result->ROOMNUM.'</a></td>';
						echo '<td><a href="index.php?view=edit&id='.$result->ROOMID.'">'. $result->ROOM.' ('. $result->ROOMDESC.')</a></td>';
				  		// echo '<td>'. $result->ROOMDESC.'</td>';
						// echo '<td>'. $result->ACCOMODATION.' ('. $result->ACCOMDESC.')</td>';
						echo '<td>'. $result->ACCOMODATION.'</td>';
				  		echo '<td>'. $result->NUMPERSON.'</td>';
				  		
				  		echo '<td> &#8369 '. $result->PRICE.'</td>';
				  		echo '<td>'.$result->ROOMNUM.' </td>';
				  		?>

						<?php
				  		$conn = mysqli_connect('localhost', 'root', '', 'southgatedb');
						  $query = "SELECT *,ACCOMODATION FROM tblroom r, tblaccomodation a WHERE r.ACCOMID = a.ACCOMID ORDER BY  ROOMID ASC ";
						  $result = mysqli_query($conn, $query);
  
						  while ($row = mysqli_fetch_assoc($result)) {
						?>
					  <tr>
					  <td width="5%" align="center"></td>
							<td align="left"  width="120"><input type="checkbox" name="selector[]" id="selector[]" value="<?php echo $row['ROOMID']; ?>"/> 
							<a href="#"  class="roomImg" data-id="<?php echo $row['ROOMID'] ?>" title="Click here to Change Image."><img src="<?php echo $row['ROOMIMAGE'] ?>" width="60" height="40" title="<?php echo $row['ROOM'] ?>"/></a></td>
							<td><a href="index.php?view=edit&id=<?php echo $row['ROOMID'] ?>"><?php echo $row['ROOMNUM'] ?></a></td>
						  <td><a href="index.php?view=edit&id=<?php echo $row['ROOMID'] ?>"><?php echo $row['ROOM'] ?></a></td>
  
						  
					  </tr>
					  <?php } ?>
				  </tbody>
				 	
				</table>
				
				</form>
	  		</div><!--End of Panel Body-->
	  	<!-- </div> -->
	  	<!--End of Main Panel-->

</div><!--End of container-->

<div class="modal fade" id="myModal" tabindex="-1">

</div>