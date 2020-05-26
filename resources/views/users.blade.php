@extends('layouts.master')

@section('title','Users')

@section('content')
@include('includes.header')
	
<div class="container-fluid">
	<div class="row">
          <div class="col-12">
          	@if ($errors->has('message'))
                <span class="help-block">
                    <strong>{{ $errors->first('message') }}</strong>
                </span>
            @endif

            @if (session('message'))
            	<div class="col-md-6 align-item-center">
		            <div class="card card-success">
		              <div class="card-header">
		                <h3 class="card-title">{{ session('message') }}</h3>
		                <div class="card-tools">
		                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
		                  </button>
		                </div>
		              </div>
		            </div>
		          </div>
            @endif

            <div class="alert alert-warning" role="alert" id="foralert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <p id="wa"></p>
			</div>

			 <div class="alert alert-success" role="alert" id="foralert1">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <p id="sa"></p>
			</div>


            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users</h3>
				<button class="btn btn-info donerbtn" style="float: right;">Update Doner</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              	<table id="example1" class="table table-bordered table-striped">
                  <thead>
	                  <tr>
	                  	<th>All <input type="checkbox" class="" name="select-all" id="select-all" style="height: 20px;width: 20px;"></th>
	                    <th>#</th>
	                    <th>Name</th>
	                    <th>Email</th>
	                    <th>Phone</th>
	                    <th>DOB</th>
	                    <th>City</th>
	                    <th>Amount</th>
	                    <th>Status</th>
	                    <th>Action</th>
	                  </tr>
                  </thead>
                  <tbody>
                  		
			       
			            
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>	
                    
</div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit User</h4>
        </div>
        <div class="modal-body">
	    <div class="form-group">
		  <label for="usr">Name:</label>
		  <input type="hidden" class="form-control" id="hiddenid" name="hiddenid">
		  <input type="text" class="form-control" id="name" name="name">
		</div>
		 <div class="form-group">
		  <label for="usr">Email:</label>
		  <input type="text" class="form-control" id="email" name="email">
		</div>
		<div class="form-group">
		  <label for="usr">DOB:</label>
		  <input type="date" class="form-control" id="dob" name="dob">
		</div>
		<div class="form-group">
		  <label for="usr">Phone:</label>
		  <input type="text" class="form-control" onkeypress="return isNumberKey(event)"  id="phone" name="phone">
		</div>
		<div class="form-group">
		  <label for="usr">City:</label>
		  <input type="text" class="form-control" id="city" name="city">
		</div>
		<div class="form-group">
		  <label for="usr">Amount:</label>
		  <input type="text" class="form-control" onkeypress="return isNumberKey(event)" id="amount" name="amount">
		</div>
        </div>
        <div class="modal-footer">
        
          <button type="button" class="btn btn-success updatebtn">Update</button>
        </div>
      </div>
      
    </div>
  </div>
@endsection

@section('footer')
@parent
@endsection

@push('script')
<script>
$(document).ready(function(){

  
    $("#foralert").hide();
    $("#foralert1").hide();
  

	userslist();   // page load to call first
	$('.updatebtn').on('click',function(){ 
		 var token = $("meta[name='csrf-token']").attr("content");
		 
		 var id=$('#hiddenid').val();
		 var name=$('#name').val();
		 var email=$('#email').val();
		 var dob=$('#dob').val();
		 var phone=$('#phone').val();
		 var city=$('#city').val();
		 var amount=$('#amount').val();
		 
    $.ajax({
            type: 'post',
            url: 'updateuser',
            data: {
            	'id':id,
	            'name': name,
	            'email': email,
	            'dob': dob,
	            'phone': phone,
	            'city': city,
	            'amount': amount,
	             '_token': "{{ csrf_token() }}",
            },
            success: function (result) {
				
				 var obj = $.parseJSON(result);
				  $('#myModal').modal('hide');

                  location.reload();

		          user_list()

		          $("#sa").html("Updated succesfully!")
				  $("#foralert1").show();
            }
        });
	});
	
	
	 $("#select-all").on("click", function() {  //  All checkbox check click
        var all = $(this);
         $('input:checkbox').each(function() {
        $(this).prop("checked", all.prop("checked"));    //  All checkbox checked
          });
        });
		
		
		$('.donerbtn').on('click',function(){
			 var favorite = [];
          $('.ads_Checkbox:checked').each(function() {   
           favorite.push($(this).val());   // all checkbox value get
            });
			
			if(favorite==''){      //  if no any checkbox check
				$("#wa").html("Please select atleast one!")
				$("#foralert").show();
				//				$("#foralert").hide();
				
			}else{
				var token = $("meta[name='csrf-token']").attr("content");
				  $.ajax({
			            type: 'post',
			            url: '{{url("updatedonor")}}',
			            data: {
							'id':favorite,
							"_token": "{{ csrf_token() }}",
							},
			            success: function (result) {
							var obj = $.parseJSON(result);
							 user_list()
						  }
				        });
		   }
		});

});	

function edituser(id){
	 var token = $("meta[name='csrf-token']").attr("content");
	  $.ajax({
            type: 'get',
            url: '{{url("edituser")}}',
            data: {
				'id':id,
				'_token': token
				},
            success: function (result) {
            	
				var obj = $.parseJSON(result);
				console.log(obj.user);
				$('#hiddenid').val(obj.user.id);
				$('#name').val(obj.user.name);
				$('#email').val(obj.user.email);
				$('#phone').val(obj.user.phone);
				$('#dob').val(obj.user.dob);
				$('#city').val(obj.user.city);
				$('#amount').val(obj.user.amount);
			}
	  });
}

function userslist() {
	$.ajax({
            type: 'get',
            url: '{{url("getusers")}}',
            data: {_token: "{{ csrf_token() }}"},
            success: function (result) {
            	console.log(JSON.parse(result));
			 	var obj = $.parseJSON(result);
                 var t = $('#example1').DataTable();            
                 t.clear().draw();                                      
                 $.each(obj.users.data, function (key, value) {
                 	console.log(key);
                 	console.log(key);
                 	console.log(obj.users.data);
					  key = key + 1;
					  action='<button class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal" onclick="edituser('+value.id+')">Edit</button>  <button class="btn btn-danger btn-xs" onclick="deleteuser('+value.id+')">Delete</button>';
					  
					  checkbox='<input type="checkbox" class="ads_Checkbox" name="chk_box" id="chk_box" value="'+value.id+'" style="height: 20px;width: 20px;">'
					 
					 if(value.status==0){
						 status='Not confirmed Doner';
					 }else{
						 status='confirmed Donor';
					 }
					    t.row.add([                                   
                                    checkbox,
                                    key,
                                    value.name,
                                    value.email,
                                    value.phone,
                                    value.dob,
                                    value.city,
                                    value.amount,
                                    status,
									action,
									   
                                ]).draw(true); 
			});
            }
    });
} 
function deleteuser(id){
	  $.ajax({
            type: 'post',
            url: '{{url("deleteuser")}}',
            data: {
				'id':id,
				'_token': "{{ csrf_token() }}"
				
				},
            success: function (result) {
            	console.log(result);
                location.reload();

		         user_list()
			}
	  });	
}
/*window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);*/
</script>
 @endpush
