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