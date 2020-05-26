@extends('layouts.guest')

@section('content')
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card card-primary" id="reg_sec">
              <div class="card-header">
                <h3 class="card-title">Register here</h3>
              </div>
            <div class="card-body">
                <form method="POST" id="quickForm" action="{{ route('register') }}">
                <input type="hidden" name="_token" id="tokenr" value="{{ csrf_token() }}">


                <div class="form-group">
                <label for="Name">Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Enter name">
                </div>

                <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
                </div>

                <div class="form-group">
                  <label class=" col-form-label text-md-right">Date of birth</label>
                  <div class=" col-md-12 input-group date" id="reservationdate" data-target-input="nearest">
                  <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                  <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                  </div>
                </div>




                <div class="form-group">
                <label for="phone">Phone</label>
                <input type="phone" name="phone" class="form-control" id="phone" placeholder="Enter Phone">
                </div>


                <div class="form-group">
                <label for="city">City</label>
                <input type="city" name="city" class="form-control" id="city" placeholder="Enter City">
                </div>


                <div class="form-group">
                <label for="amount">Amount</label>
                <input type="amount" name="amount" class="form-control" id="amount" placeholder="Enter Amount">
                </div>



                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                <button type="button" onclick="submitRegister()" class="btn btn-primary">Submit</button>
                </div>
                <div class="form-group mb-0">
                <div class="">
                <label class="" >Click here for <a href="{{url('login')}}">Login</a>.</label>
                </div>
                </div>
                </form>
            </div>
            </div>

           
        </div>
      </div>
@endsection



@push('script')
<script type="text/javascript">

  //let _token   = $('meta[name="csrf-token"]').attr('content');

  document.getElementById('log_sec').style.display= "none";
  function hideshow() {

    document.getElementById('reg_sec').style.display= "none";
    document.getElementById('log_sec').style.display= "block";
  }
  
  function hideshow1() {
    document.getElementById('log_sec').style.display= "none";
    document.getElementById('reg_sec').style.display= "block";

  }

  function submitRegister(){


 /*   $.validator.setDefaults({
    submitHandler: function () {*/

     event.preventDefault();

      /*let name = $("input[name=name]").val();
      let email = $("input[name=email]").val();
      let mobile_number = $("input[name=mobile_number]").val();
      let message = $("input[name=message]").val();*/

      $.ajax({
        url: "/register",
        type:"POST",
        data:{
          name:$('#name').val(),
          email:$('#email').val(),
          dob:$('#dob').val(),
          phone:$('#phone').val(),
          city:$('#city').val(),
          amount:$('#amount').val(),
          _token: $('#tokenr').val()
        },
        success:function(response){
          console.log(response);
          if(response.status == false) {
              alert("message")
            /*$('.success').text(response.success);
            $("#ajaxform")[0].reset();*/
          }
        },
       });

    /*}

  });*/
  }

  function submitLogin(){
     
   // alert("sdsa")
      /*$.validator.setDefaults({
        submitHandler: function () {*/
               event.preventDefault();

            $.ajax({
                url: "/login",
                type:"POST",
                data:{
                  email:$('#email_l').val(),
                  password:$('#password_l').val(),
                  _token: $('#token').val()
              },
              success:function(response){
                console.log(JSON.parse(response).status);
                if(JSON.parse(response).status == true) {
//                  window.location.href = "users";
//window.location = "http://www.google.com";

                  /*$('.success').text(response.success);
                  $("#ajaxform")[0].reset();*/
                }
              },
            });

        /*}
      });*/
  }

$(document).ready(function () {
       $('#quickForm').validate({
    rules: {
      name: {
        required: true,
      },
      email: {
        required: true,
        email: true,
      },
      phone: {
        required: true,
        maxlength: 10
      },
      city: {
        required: true,
      },
       amount: {
        required: true,
      },
    },
    messages: {
      email: {
        required: "Please enter an email address",
        email: "Please enter a vaild email address"
      },
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      },
      terms: "Please accept our terms"
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });

  $('#quickForm1').validate({
        rules: {
          email: {
            required: true,
            email: true,
          },
          password: {
            required: true,
            minlength: 5
          },
          terms: {
            required: true
          },
        },
        messages: {
          email: {
            required: "Please enter a email address",
            email: "Please enter a vaild email address"
          },
          password: {
            required: "Please provide a password",
            minlength: "Your password must be at least 5 characters long"
          },
          terms: "Please accept our terms"
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });

});
</script>
@endpush
