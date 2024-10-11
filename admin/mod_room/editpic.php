<?php  
require_once ("../../includes/initialize.php");  

$room = New Room();
$cur = $room->single_room($_POST['ROOMID']);
 
?>

<div class="modal-dialog" style="width:50%">
<div class="modal-content">
	<!-- <div class="modal-header">
		<button  class="close" id="btnclose" data-dismiss="modal" type=
		"button">x</button>
	</div> -->
<div class="modal-body">  
<form class="form-horizontal well span6" action="controller.php?action=editimage" enctype="multipart/form-data" method="POST">

	<table class="table table-hover" border="0" width="50">
			<caption><h3 align="left">Modify Image</h3></caption>
		<tr>
		<td width="80">
			<input name="id" type="hidden" value="<?php echo $cur->ROOMID; ?>">
			<img src="<?php echo $cur->ROOMIMAGE; ?>" width="550" height="300" /></td>
		</tr>

		<tr>
		<td width="80">
			<input id="image" name="image" type="file"></td>
		</tr>
		<tr>
		<td  width="80"><input type="button" value="x Close" class="btn btn-default" onclick="window.location.href='index.php'" >  
		 <button class="btn btn-primary" name="save" type="submit" >Save</button>

		</td>
		</tr>
	
		</table>
		  </form>
	 </div><!--  modal body -->
</div> <!-- modal content -->
</div> <!-- modal dialog -->	
<script>
	$(document).ready(function(){
    $('.roomImg').click(function(){
        var id = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "editpic.php",
            dataType: "text",
            data: {ROOMID: id},
            success: function(data){
                $('#myModal').modal('toggle').html(data);
            }
        });
    });

    $('#myModal').on('submit', 'form', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "controller.php?action=editimage",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                try {
                    var jsonResponse = JSON.parse(response);
                    if (jsonResponse.success) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Room image updated successfully!',
                            icon: 'success'
                        }).then(() => {
                            window.location.href = "index.php";
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'There was a problem updating the room image.',
                            icon: 'error'
                        });
                    }
                } catch (e) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Unexpected error occurred.',
                        icon: 'error'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Error',
                    text: 'An error occurred while processing your request.',
                    icon: 'error'
                });
            }
        });
    });
});

	</script>