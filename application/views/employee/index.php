<div class="container">
<div class="row justify-content-center dcenter" >

	<h2>Search user by name or age below</h2>
	
	<input class="form-control-sm w-75" type="text" name="Search" onkeyup="getEmployeesByFilter();"  placeholder="Search by name or age">

	<table class="table table-sm table-bordered table-striped table-hover w-75 bg-light ">
		<div class="w-75">
			<h1 class="float-left">List of employees</h1>

			<button class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#modalRegister">+</button>
		</div>
		
		
		<thead>
			<th>Id</th>
			<th>Name</th>
			<th>Adress</th>
			<th>Age</th>
			<th>Action</th>
		</thead>

		<tbody class="rows" >

		</tbody>
		
	</table>
	
</div>
</div>

	<script type="text/javascript">

		showAllEmployee();
		function showAllEmployee(){

			$.getJSON('<?php echo site_url("employee/showAllEmployee")?>',function(json){
				addData(json);	
			})
		}
		function addData(json){
				var tr= $(".rows");
				tr.html("");
				$.each(json,function(key,val){
					tr.append("<tr>");
					tr.append("<td>"+val.Id+"</td> <td>"+val.Name+"</td>  <td>"+val.Adress+"</td>  <td>"+val.Age+"</td>  <td><button id='"+val.Id+"' class='btn btn-warning btn-sm btnedit' data-toggle='modal' data-target='#modalUpdate'>Edit</button>  <button id='"+val.Id+"' class='btn btn-danger btn-sm btndelete'>Delete</button> </td>");
					tr.append("</tr>");
				})
				
		}

		//Save employee
		$(document).on("click",".btnsave",function(){
			var name= $("[name='Name']").val();
			var address = $("[name='Address']").val();
			var age = $("[name='Age']").val();

			$.post("<?php echo site_url('employee/saveEmployee')?>",{Name:name,Adress:address,Age:age},function(json){
				var jsonuser = JSON.parse(json);
				
				swal({
					type:'success',
					title:jsonuser.message,
					text: 'It has deleted successfuly',
					showConfirmButton:false,
				    timer:3000

				}).then((result )=>{
					
						$("#modalRegister").modal("hide");
						showAllEmployee();
					

				})



			})
		})

		//update employee
		$(document).on("click",".btnupdate",function(){
			var id =$("[name='uId']").val();
			var name= $("[name='uName']").val();
			var address = $("[name='uAddress']").val();
			var age = $("[name='uAge']").val();

			$.post("<?php echo site_url('employee/updateEmployee')?>",{Id:id,Name:name,Adress:address,Age:age},function(json){
				var employeejson = JSON.parse(json);
				alert(employeejson.message);
				showAllEmployee();
				$("#modalUpdate").modal('hide');
				
			})
		})
		//DELETE USER
		$(document).on("click",".btndelete",function(){
			var id = $(this).attr("id");


			Swal({
  title: 'Are you sure?',
  text: 'You will not be able to recover this information!',
  type: 'question',
  showCancelButton: true,
  confirmButtonText: 'Yes, delete it!',
  cancelButtonText: 'No, keep it'
}).then((result) => {
  if (result.value) {
  	$.post("<?php echo site_url('employee/deleteUser') ?> ",{Id:id},function(){
				showAllEmployee();
				Swal(
      'Deleted!',
      'Your have  deleted the employee selected.',
      'success'
    )
			})
  } else if (result.dismiss === Swal.DismissReason.cancel) {
    Swal(
      'Cancelled',
      'You have not deleted employee selected',
      'error'
    )
  }
})

			
			
		})


				//SHOW ONLY ONE EMPLOYEE BY ID
		$(document).on("click",".btnedit",function(){
			var id =$(this).attr("id");
			$.post("<?php echo site_url('employee/showEmployeeById')?>",{Id:id},function(json){
				var employeejson = JSON.parse(json);
				$.each(employeejson,function(key,val){
				$("[name='uId']").val(val.Id);
				$("[name='uName']").val(val.Name);
				$("[name='uAddress']").val(val.Adress);
				$("[name='uAge']").val(val.Age);
				})
			})
		})


		function getEmployeesByFilter(){
			var s = $("[name='Search']").val();
			$.post("<?php echo site_url('employee/showEmployeesByFilter')?>",{Name:s},function(json){
				var employeejson = JSON.parse(json);
				addData(employeejson);
			})
		}

		$(document).on("click",".btnlogin",function(){
			var name = $("[name='lName']").val();
			var age = $("[name='lAge']").val();
			$.post("<?php echo site_url('employee/Login')?>",{Name:name,Age:age},function(json){
				var loginjson = JSON.parse(json);
				if (loginjson.message=="Yes"){

					swal({
						type:"success",
						title:"Welcome "+name,
						text:"You have logged successfuly",
						timer:1000,
						showConfirmButton:false
					}).then((result)=>{

						$("#modalLogin").modal('hide');
						
						$(".btnsignin").hide('fast');
						document.getElementById("addbutton").innerHTML="<button class='btn btn-danger btn-sm btnlogout'>LOG OUT </button>";
						$(document).on("click",".btnlogout",function(){
							<?php 
							$this->session->unset_userdata('Name');
							$this->session->sess_destroy();
							?>
						$(".btnsignin").show('fast');

						})
					})
				}else if (loginjson.message=="No"){

					swal({
						type:"error",
						title:"Error to try enter",
						text:"username or password not exists"
					}).then((result)=>{

						
					})
				}
			})
		})





</script>

<!--START  REGISTER MODAL-->
<div class="modal fade" id="modalRegister">

			<div class="modal-dialog">
				<div class="modal-content">

					<div class="modal-header">
						<h4 class="modal-title">Create new user</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<div class="modal-body">
						<input class="form-control" type="text" name="Name" placeholder="Enter your name">
						<input class="form-control" type="text" name="Address" placeholder="Enter your address">
						<input class="form-control" type="number" name="Age" placeholder="Enter your age">
					</div>

					<div class="modal-footer">
						<button class="float-left btn btn-primary btnsave" type="button" >Save</button>
						<button type="button" class="float-left btn btn-danger" data-dismiss="modal">Cancel</button>
						
					</div>
						
				</div>
				
			</div>
	
</div>
<!--END REGISTER MODAL -->



<!--START UPDATE MODAL -->
<div class="modal fade center" id="modalUpdate">

			<div class="modal-dialog">
				<div class="modal-content">

					<div class="modal-header">
						<h4 class="modal-title">Update user</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<div class="modal-body">
						<input class="form-control" type="number" name="uId" readonly>
						<input class="form-control" type="text" name="uName" placeholder="Enter your name">
						<input class="form-control" type="text" name="uAddress" placeholder="Enter your address">
						<input class="form-control" type="number" name="uAge" placeholder="Enter your age">
					</div>

					<div class="modal-footer">
						<button class="float-left btn btn-primary btnupdate" type="button" >Update</button>
						<button type="button" class="float-left btn btn-danger" data-dismiss="modal">Cancel</button>
						
					</div>
						
				</div>
				
			</div>
	
</div>
<!--END UPDATE MODAL -->

<!--START LOGIN MODAL -->
<div class="modal fade center " id="modalLogin">

			<div class="modal-dialog">
				<div class="modal-content modal-md">

					<div class="modal-header">
						<h4 class="modal-title text-center">LOG IN</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<div class="modal-body">
						<input class="form-control" type="text" name="lName" placeholder="Enter your name">
						<input class="form-control" type="number" name="lAge" placeholder="Enter your age">
					</div>

					<div class="modal-footer">
						<button class="float-left btn btn-default btnlogin" type="button" >Access</button>
						<button type="button" class="float-left btn btn-danger" data-dismiss="modal">Cancel</button>
						
					</div>
						
				</div>
				
			</div>
	
</div>
<!--END LOGIN MODAL -->