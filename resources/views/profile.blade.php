
 @extends('master')
 @section('title')
 Profile
 @endsection
 
@section('style')           
<style type="text/css">
    .bodything {
        background: rgb(255,255,255, 0.86) !important; 
    }
</style>
@endsection

@section('content')           
   
        <div class="container-fluid switch_view pt-2">
        	<h3 class="text-center ">PROFILE</h3>
            <div class="container form_view font-weight-bold " >
            	
            	
            	<div class="row">
                    <div class="col-md-3 image">
                        <form action="" method="post" enctype="multipart/form-data"  id="image_form">
                            {{csrf_field()}}
                                <img src="assets/images/cofeeberry.jpg" alt="John Doe" class="w-100 prev" />
                                <div class="h-25">
                                    <input type="file" name="image" class="custom-file" onchange="previewFile()">
                                </div>
                               {{--  <button class="btn btn-primary"> Upload Image</button> --}}
                            </form>
                    </div>
                    <form class="col row" id="profile_form">
                        {{csrf_field()}}
                        <input type="hidden" name="table" value="users">
                        
	            	<div class="col-md">
	            		<div class="form-group" style="display: none;">
                            <label>User Id</label>
                            <input type="text" name="id" readonly="" class="form-control">
                        </div>
                        <div class="form-group" >
                            <label>Image</label>
                            <input type="text" name="image" readonly="" class="form-control">
                        </div>
	            		<div class="form-group">
	            			<label>First Name</label>
	            			<input type="text" name="firstname"  class="form-control" readonly>
	            		</div>
                        <div class="form-group">
                            <label>Second Name</label>
                            <input type="text" name="secondname"  class="form-control" readonly>
                        </div>
	            		<div class="form-group">
	            			<label>Phone</label>
	            			<input type="text" name="phone"  class="form-control" required pattern="^(07)[0-9]{8}$" title="please enter correct Phone no ie 0713345667" maxlength="10">
	            		</div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username"  class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password"  class="form-control"  pattern="^[0-9]{0}$^[0-9a-z A-Z]{3,50}$" title="please enter a password atleast 5 characters or leave empty to retain old password" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="password_retype"  class="form-control"  pattern="^[0-9]{0}$|^[0-9a-z A-Z]{3,50}$" title="password missmatch or leave empty to retain old password" maxlength="50">
                        </div>
	            	</div>
	            	<div class="col-md">
	            		<div class="form-group">
	            			<label>User type</label>
	            			<input type="text" name="user_type" class="form-control" readonly>
	            		</div>
	            		<div class="form-group">
	            			<label>Account status</label>
	            			<input type="text" name="status" readonly class="form-control">
	            		</div>
	            		<div class="form-group">
	            			<label>Date Created</label>
	            			<input type="text" name="created_at"  class="form-control font-weight-bold" readonly >
	            		</div>
                        <div class="form-group">
                            <label>User type</label>
                            <input type="text" name="email" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Date Updated</label>
                            <input type="text" name="updated_at"  class="form-control font-weight-bold" readonly >
                        </div>
	            	</div>
                    <div class="row w-100" >
                    
                    <button class=" btn btn-primary col-sm-3 mx-auto my-2">UPDATE PROFILE </button>
                    
                </div>
                </form>
            	</div>
            	
            </div>
        </div>
           
@endsection
       @section('script')  
   <script type="text/javascript">
   	$(document).ready(function () {
        if($("#logged_user").text()=="New User")
           window.location.href=('home');
       if(Object.keys(my_session).length != 0)
        try {
            fillprofile()
            // for(input in $('#profile_form').children)
            //     alert(input);
            //$("#tablething").slideToggle();
        } catch (e) {
             alert("error "+e);
        }
        
    });
    function fillprofile(){
        session=getsession();
        $("[name='id']").val(session.id);
        $("[name='firstname']").val(session.firstname);
        $("[name='secondname']").val(session.secondname);
        $("[name='phone']").val(session.phone);
        //$("[name='email']").val(session.email);
        $("[name='user_type']").val(session.user_type);
        $("[name='username']").val(session.username);
        $("[name='status']").val(session.status); 
        $("[name='created_at']").val(session.created_at);
        $("[name='updated_at']").val(session.updated_at);
        $("#profile_form [name='image']").val(session.image);
        try {
            $("[name='email']").val(session.email);
        } catch(e) {
            // statements
            console.log(e);
        }
        $(".prev").attr('src','assets/images/users/'+session.image);
        
        
    }
    function act(){
        $(".active").removeClass('active');
        $(".profile").addClass('active');
        
    }
    act();
    $("#profile_form").submit(function(e){
        e.preventDefault();
        r=confirm("Sure to update your Account info ??");
            if(r!=true)
            {
                return;
            }
        ses=getsession();
        u_url="update";
        data=$("#profile_form").serialize();
        $.ajax({
            async:false,
            type:'post',
            url:u_url,
            data:data,
            success:function(response){
               //console.log(response);
                if (response.indexOf("successful")>0) {
                    c_alert('success','Account info updated successfully');
                    window.location.replace('profile')

                }
                else{
                     c_alert('error'," an error occured "+response);
                }
            },
            error:function(err){
                console.log(err);
                
            }
        });
    });
    function previewFile(){
        var preview=document.querySelector('.prev');
        var file=document.querySelector('input[type=file]').files[0];
        var reader=new FileReader();
        reader.onloadend=function(){
            preview.src=reader.result;
        }
        if(file){
            reader.readAsDataURL(file);
        }
        else{
            preview.src="";
        }
        $("#image_form").submit();
    }
    $("#image_form").submit(function(e){
        e.preventDefault();
        u_url="uploaduserimg";
        //data=$("#image_form").serialize();

        imagename=$("#image_form [name='image']").val();
        ext=imagename.substr(imagename.lastIndexOf('.')+1);
        ext=ext.toLowerCase();
        if(ext=="jpg"|ext=="jpeg"|ext=="png"|ext=="gif")
        {
           // alert("pass");
        }
        else{
            c_alert("error","The selected file is not an image");
            return;
        }
        
        var formData=new FormData(this);
        formData.append('file',$("#image_form [name='image']")[0].files[0]);
        imagesize=$("#image_form [name='image']")[0].files[0].size;

      //  alert("name1 = "+imagename);
       imagename=imagename.substr(imagename.lastIndexOf('\\')+1);
       // alert("name2 = "+imagename);
        //console.log(formData);
        $.ajax({
            async:false,
            type:'post',
            url:u_url,
            data:formData,
            processData:false,
            contentType:false,
            enctype:'multipart/form-data',
            success:function(response){
                //alert(response);
                if (response.indexOf("success")>=0) {
                    c_alert('success','image uploaded successfully');
                    $("#profile_form [name='image']").val(imagename);
                }
                else{
                     c_alert('error'," an error occured "+response);
                }
                
            },
            error:function(err){
                console.log(err);
                if(err.indexOf('upload_max_filesize ')>=0)
                {
                    c_alert("error","The image Exceeds the max size of 5mb");
                }
            }
        });
     });
   </script> 
   @endsection     