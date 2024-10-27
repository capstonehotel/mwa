<div class="container-fluid">
<form action="controller.php?action=delete" Method="POST"> 
    <div class="card shadow mb-4">
        <div class="card-header py-3"  style="display: flex;align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">List of Reservation</h6>

            <!-- <div class=" text-right" style="display: flex; justify-content: right; align-items: right; width: 100%;">
				  <a href="index.php?view=add" class="btn btn-success btn-sm mr-2">Add New Room</a>
            </div> -->
        </div>
        <div class="card-body">
            <div class="table-responsive" style="width: 100%;">
                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                        	<th>#</th>
					  		<th>Guest</th>
					  		<th>Transaction Date</th>
					  		<th>Confimation Code</th>
					  		<th>Total Rooms</th>
					  		<th>Total Price</th>
					  		<th>Status</th>
					  		<th>Action</th>
					  	</tr>
                    </thead>
                    <tbody>
				  	<?php 
				  		$query = "SELECT  `G_FNAME` ,  `G_LNAME` ,  `G_ADDRESS` , `G_GENDER` , `TRANSDATE` ,  `CONFIRMATIONCODE` ,  `PQTY` ,  `SPRICE` ,`STATUS`
						FROM  `tblpayment` p,  `tblguest` g
						WHERE p.`GUESTID` = g.`GUESTID`   
						ORDER BY p.`STATUS`='pending' desc";
						$result = mysqli_query($connection, $query);
						$number = 0;
				  		while ($row = mysqli_fetch_assoc($result)) { $number ++;?>
				            <tr>
				            	<td align="center"><?php echo $number; ?></td>
				            	<td align="center"><?php echo $row['G_FNAME']; ?> <?php echo $row['G_LNAME']; ?></td>
				            	<td align="center"><?php echo $row['TRANSDATE']; ?></td>
				            	<td align="center"><?php echo $row['CONFIRMATIONCODE']; ?></td>
				            	<td align="center"><?php echo $row['PQTY']; ?></td>
				            	<td align="center"><?php echo $row['SPRICE']; ?></td>
				            	<td align="center"><?php echo $row['STATUS']; ?></td>
				            	<td align="center">
				            		<a href="index.php?view=view&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-sm btn-primary btn-sm" ><i class="icon-edit">View</a>
				            		<?php if ($row['STATUS'] == "Confirmed" ) { ?>
				            			<a href="controller.php?action=cancel&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-danger btn-sm" ><i class="icon-edit">Cancel</a>
				            			<a href="controller.php?action=checkin&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-success btn-sm" ><i class="icon-edit">Check in</a>
				            		<?php } elseif($row['STATUS'] == 'Checkedin') {?>
										<a href="controller.php?action=checkout&code=<?php echo $row['CONFIRMATIONCODE'];?>" class="btn btn-warning btn-sm" ><i class="icon-edit">Check out</a>
						
				            		<?php } else {?>
				            			<a href="controller.php?action=confirm&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-success btn-sm"  ><i class="icon-edit">Confirm</a>
								<?php } ?>
								<?php if($_SESSION['ADMIN_UROLE']=="Administrator"){ ?>
								<a href="controller.php?action=delete&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-danger btn-sm	" ><i class="icon-edit">Delete</a>
									
                                            <?php } ?>
				            	</td>
				            </tr>
				        <?php } ?>	
				  </tbody>
                </table>
            </div>
        </div>
    </div>
</form>
</div>