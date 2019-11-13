<?php 
session_start();
session_destroy();
 ?>
	@extends('master')
		@section('title')
		 churchillEvents
		 @endsection
	@section('content')
 	<div class="mx-4 contentbody ">
        <div class="contentview container" >
        	<h3 class="text-center">Login To Book Events</h3>
            <form action="" method="post" id="login_form">
                {{csrf_field()}}
                <input type="hidden" name="table" value="users">
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="form-group ">
                            <label class="custom-label">Username</label>
                            <input type="text" name="username" value="" class="form-control" required pattern="^[0-9a-z A-Z]{3,25}$" title="please enter correct Username atleast 3 characters " maxlength="25" />
                        </div>
                        <div class="form-group">
                            <label class="custom-label">Password</label>
                            <input type="password" name="password" value="" class="form-control" required maxlength="25" />
                        </div>
                        <div class="form-group vcode" style="display: none;">
                            <label class="custom-label">Verification Code</label>
                            <input type="text" name="activation" value="" class="form-control" required maxlength="25" />
                        </div>
                    </div>
                </div>
               
                <div class="row px-4">
                    <button class="btn btn-primary  col m-3 adder"> LOGIN </button>
                    <label class="btn btn-outline-info  col m-3 mytoggle" > Need account? </label>
                </div>
            </form>
        </div>
        <div class="contentview2 container"  style="display: none;">
        	<h3 class="text-center">Create an account</h3>
            <form action="" method="post" id="account_form">
                {{csrf_field()}}
                <input type="hidden" name="table" value="users">
                <input type="hidden" name="created_at" value="">
                <input type="hidden" name="verificationcode" value="">
                <div class="row">
                    <div class="col-md mx-auto">
                        <div class="form-group ">
                            <label class="custom-label">First Name</label>
                            <input type="text" name="firstname" value="" class="form-control" required pattern="^[a-zA-Z]{3,25}$" title="please enter correct name atleast 3 characters " maxlength="25" />
                        </div>
                        <div class="form-group">
                            <label class="custom-label">Second Name</label>
                            <input type="text" name="secondname" value="" class="form-control" required pattern="^[a-zA-Z]{3,25}$" title="please enter correct name atleast 3 characters " maxlength="25" />
                        </div>
                    </div>
                    <div class="col-md mx-auto">
                        <div class="form-group ">
                            <label class="custom-label">Username</label>
                            <input type="text" name="username" value="" class="form-control" required pattern="^[0-9a-z A-Z]{3,25}$" title="please enter correct Username atleast 3 characters " maxlength="25" />
                        </div>
                        <div class="form-group">
                            <label class="custom-label">Password</label>
                            <input type="password" name="password" value="" class="form-control" required maxlength="25" />
                        </div>
                    </div>
                    <div class="col-md mx-auto">
                        <div class="form-group ">
                            <label class="custom-label">Phone</label>
                            <input type="text" name="phone" value="" class="form-control" required pattern="^(07)[0-9]{8}$" title="please enter correct phone number" maxlength="10" />
                        </div>
                        <div class="form-group">
                            <label class="custom-label">Email</label>
                            <input type="text" name="email" value="" class="form-control" required pattern="^[0-9a-zA-Z.]{3,15}(@)[0-9a-zA-Z]{3,15}(.)[0-9a-zA-Z.]{3,15}$" title="please enter correct Email" maxlength="50" />
                        </div>
                    </div>
                </div>
               
                <div class="row px-4">
                    <button class="btn btn-primary  col m-3"> Create Account</button>
                    <label class="btn btn-outline-info col m-3 mytoggle" >Back To login</label>
                </div>
            </form>
            
        </div>
    </div>
 	@endsection

 	@section('script')
	<script type="text/javascript">
     $(document).ready(function () {
       tabletmp = $("#persondata_table").parent().html();
     });
     clcked=false;
    $("#contentviewbtn").click(function () {
        $("#login_form").trigger('reset');
        toggler();
    });
    $(".mytoggle").click(function(){
        toggler();
    });
    function toggler()
    {
        $(".contentview2").slideToggle();
        $(".contentview").slideToggle();
    }
    $(".adder").click(function(){
    	$("#login_form").submit();
    });
    $("#login_form").submit(function(e){
            e.preventDefault();
            u_url="login";
            //alert("still alive");
            data=$("#login_form").serialize();
            $.ajax({
                async:false,
                type:'post',
                url:u_url,
                data:data,
                success:function(response){
                    if (response.indexOf("no results")<0) {
                    	if(response.indexOf("waiting")!=-1)
                    	{
                    		$(".vcode").show();
                    		c_alert('success',"Please enter your verification code sent to your email and try again");
                    	}
                    	else
                    	{
                    		$(".vcode").hide();
                    		response=JSON.parse(response);
                    		data=response[0];
                       		c_alert('success',"welcome to the system"+data.username);
                       		window.location.href=('home');
                    	}
                    }
                    else{
                         c_alert('error',"Login Failed, Please check your Credentials");
                    }
                    
                },
                error:function(err){
                    console.log(err);
                }
            });

    });
    function getRndInteger(min, max) {
	  return Math.floor(Math.random() * (max - min) ) + min;
	}
    $("#account_form").submit(function(e){
            e.preventDefault();
            u_url="insert";
            rand=getRndInteger(111111,999999);
            $("[name='verificationcode']").val(rand);
            //alert("still alive");
            data=$("#account_form").serialize();
            $.ajax({
                async:false,
                type:'post',
                url:u_url,
                data:data,
                success:function(response){
                    console.log(response);
                    if (response.indexOf("success")!=-1) {
                       	c_alert('success',"Account created successfully Please check your email to verify your account");
                       	data={message:"Thank you for creating an acount here is your verificationcode "+rand,to:$("[name='email']").val(),subject:"Use this Verification code"}
	                    console.log(data);
	                    $.ajax({
	                        async:false,
	                        data:data,
	                        type:'POST',
	                        url:"Notification/sendNotification.php",
	                        success:function(response){
	                           console.log(response);
	                            if(response.indexOf("success")>=0){
	                                alert("Email has been sent to your mail");
	                            }
	                            else {
	                                console.log(response)
	                                add="";
	                                if(response.indexOf("Connection failed")>=0)
	                                    add="due to Connection Error";
	                                else if(response.indexOf("at least one recipient email")>=0) {
	                                    add=" because the concerned person have no email registered";
	                                }
	                                alert("Email send failed "+add)
	                            }
	                        },
	                        error:function(err){
	                            console.log('An error in sending info');
	                            console.log(err);
	                        }
	                    });
                    }
                    else{
                         c_alert('error'," an error occured "+response);
                    }
                },
                error:function(err){
                    console.log(err);
                    if(err.responseJSON.message.indexOf('Duplicate entry ')>0)
                    {
                        col=err.responseJSON.message.substring(err.responseJSON.message.indexOf('for key '), err.responseJSON.message.indexOf("' (SQL"));
                        col=col.substring(col.indexOf('_')+1, col.lastIndexOf('_'));
                        c_alert('norm',"The specified "+col+" already exists");
                    }
                }
            });
    });
	</script>
 	@endsection
    <!-- copy rights reserved by Smb -->
