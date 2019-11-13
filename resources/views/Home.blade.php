
	@extends('master')
		@section('title')
		 churchillEvents
		 @endsection
	@section('content')
 	<div class="mx-4 contentbody ">
        <div id="contentview container" class="">
             <div class="w-100">
                 <button class="btn  float-right" id="contentviewbtn" style="background-color: white; color: black; display: none;">Show All Events</button>
            </div>
       <div class="w-100 container d-flex justify-content-center">
            <label style="font-size:2em; " id="lab" class="col"> Add/Edit Events </label>
        </div>
        <div id="property_sec">
            <div class="row">
                <div class="col-md">
                <form  method="post" class="w-100" enctype="multipart/form-data"  id="image_form">
                    {{csrf_field()}}
                   <div>Event IMAGE (Poster)</div>
                    <img src="" alt="Img" class="img-fluid prev bg-light rounded" style="height:150px; width:150px"/>
                    <input type="file" name="image" class="custom-file" onchange="previewFile()">
                </form>
                </div>
            </div>
            <form action="" method="post" id="events_form">
                {{csrf_field()}}
                <input type="hidden" name="table" value="events">
                <input type="hidden" name="created_at" value="">
                <input type="hidden" name="updated_at" value="">
                <div class="row">
                    <div class="col-md">
                        <div class="form-group " style="display: none;">
                            <label class="custom-label">Event Id</label>
                            <input type="text" name="id" value="" class="form-control" readonly />
                        </div>
                       
                        <div class="form-group">
                            <label class="custom-label">Event Title</label>
                            <input type="text" name="title" value="" class="form-control" required pattern="^[0-9a-z A-Z]{5,50}$" title="please enter correct Title atleast 5 characters " maxlength="25" />
                        </div>
                        <div class="form-group">
                            <label class="custom-label">Event Description</label>
                            <textarea rows="5" cols="30" name="description" value="" class="form-control" required pattern="^[0-9a-z A-Z]{10,150}$" title="please enter correct Event details" maxlength="150">
                            </textarea>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            <label class="custom-label">Total Tickets(Regular)</label>
                            <input type="text" name="totalticketsreg" value="" class="form-control" required pattern="^[0-9]{1,3}$"/>
                        </div>
                        <div class="form-group">
                            <label class="custom-label">Total Tickets(VIP)</label>
                            <input type="text" name="totalticketsvip" value="" class="form-control" required pattern="^[0-9]{1,3}$"/>
                        </div>
                        <div class="form-group">
                            <label class="custom-label">Cost Per Ticket(Regular)</label>
                            <input type="text" name="costperticketreg" value="" class="form-control" required pattern="^[0-9]{2,4}$"/>
                        </div>
                        <div class="form-group">
                            <label class="custom-label">Cost Per Ticket(VIP)</label>
                            <input type="text" name="costperticketvip" value="" class="form-control" required pattern="^[0-9]{2,4}$"/>
                        </div>
                    </div>

                    <div class="col-md">
                    	<div class="form-group">
                            <label class="custom-label ">Event Location(venue)</label>
                            <input type="text" name="venue" value="" class="form-control" required pattern="^[0-9a-z A-Z]{3,50}$" title="please enter correct venue atleast 3 characters " maxlength="25" />
                        </div>
                    	<div class="form-group">
                            <label class="custom-label">Event Date</label>
                            <input type="date" name="eventdate" value="" class="form-control" required/>
                        </div>
                        <div class="form-group" style="">
                            <label class="custom-label">Event Image </label>
                            <input type="text" name="imagepath" value="" class="form-control" readonly/>
                        </div>
                        <div class="form-group">
                            <label class="custom-label">Total Booking</label>
                            <input type="text" name="totalbooking" value="" class="form-control" readonly />
                        </div>
                    </div>
                </div>
                <div class="w-100 d-flex justify-content-around">
                    <input type="reset" name="Clear" value="Reset Form" class="btn btn-secondary w-50">
                </div>
                <div class="row px-4">
                    <button class="btn btn-info  col m-3 adder">ADD Event</button>
                    <button class="btn  btn-primary col m-3 updater" > UPDATE Event</button>
                    <button class="btn  btn-danger col m-3 deleter" > Delete Event</button>
                </div>
            </form>
            
        </div>
         </div>
         
        <div class="rounded text-dark p-2 withshadow homdata w-100" id="mydataholder" style="display: none;">
        	<div class="col m-3  py-1 d-flex justify-content-center bg-white">
               <span class="mx-2"> Search Event</span> 
               <span class="mr-4">
	                <input type="text" class="form-control" id="SearchText">
	           </span>
	        </div>
            <div class="row mydata d-flex justify-content-around w-100">
                <div class="col-md-4 text-center animate-box  shadow px-0 bg-light" >
                    <div class="row container px-0" id="item'+x+'">
                        <div class="col-md-5 container px-3"><a  class="work w-100" style="background-image: url('assets/images/cofeeberry.jpg');background-size: contain;">
                            <div class="desc">
                                <h3>Iterested in this event</h3><span>
                                    <form><input type="button"  class="btn btn-info rndbtn bookbtn"  value="Book" />
                                    </form></span>
                            </div></a>
                        </div>
                    </div>
            	</div>
        	</div>
        </div>
        
    </div>
 	@endsection

 	@section('script')
	<script type="text/javascript">
     $(document).ready(function () {
       tabletmp = $("#persondata_table").parent().html();
        $(".actv").removeClass('actv');
        $(".home").addClass('actv');
        toggler();
        usr=getsession();
        if(usr.user_type=="Admin")
        {
            $("#contentviewbtn").slideToggle();
        }
     });
     clcked=false;
    $("#contentviewbtn").click(function () {
        $("#events_form").trigger('reset');
        toggler();
    });
    $("#SearchText").keyup(function () {
       // loadnews($("#group_selected").val());
        $(".mydata").children().each(function(){
            text=$(this).text().toLowerCase();
            if(text.indexOf($("#SearchText").val().toLowerCase())==-1)
            {
                $(this).hide();
            }
            else {
                $(this).show();
            }
        });
    });
    function toggler()
    {
        if(clcked==false){
            $("#contentviewbtn").text("Add Event");
            $("#lab").text("Events");
            loadEvents();
        }
        else{
            $("#contentviewbtn").text("Show All Events");
            $("#lab").text("Add/Edit Event");

           // judgecontrol($("[name='id']").val());
        }
        clcked=!clcked;
       $("#mydataholder").slideToggle();
       $("#property_sec").slideToggle();
    }
    submitAction="add";
    $(".adder").click(function(){
        submitAction="add";
    });
   
    $(".updater").click(function(){
        submitAction="up";
    });
    $(".deleter").click(function(){
        submitAction="del";
    });
    $("#events_form").submit(function(e){
            e.preventDefault();
           // alert($("[name='id']").val());

            u_url="";
            if(submitAction=="add"){
                if($("#events_form [name='imagepath']").val().length>1){
                    
                    $("#image_form").submit();
                }
                else{
                    c_alert('error','please provide an image to continue');
                    return;
                }
                u_url="insert";
            }
            else if(submitAction=="up")
                u_url="update";
            else if(submitAction=="del"){
                r=confirm("Sure to Delete this Event??");
                if(r==true)
                    u_url="delete";
                else {
                    return;
                }
            }
            //alert("still alive");
            data=$("#events_form").serialize();
            $.ajax({
                async:false,
                type:'post',
                url:u_url,
                data:data,
                success:function(response){
                    console.log(response);
                    if (response.indexOf("successful")>0) {
                        if(submitAction=="add"){
                            c_alert('success','Event registered successfully');
                        }
                        if(submitAction=="up"){
                            c_alert('success','Event Updated successfully');
                        }
                        if(submitAction=="del"){
                            c_alert('success','Event Deleted successfully');
                        }
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
                        //unders=
                        //alert("col="+col+"");
                        col=col.substring(col.indexOf('_')+1, col.lastIndexOf('_'));
                        c_alert('norm',"The specified "+col+" already exists");
                    }
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
            imagename=$("#image_form [name='image']").val();
            ext=imagename.substr(imagename.lastIndexOf('.')+1);
            ext=ext.toLowerCase();
            if(ext=="jpg"|ext=="jpeg"|ext=="png"|ext=="gif")
            {
                imagename=imagename.substr(imagename.lastIndexOf('\\')+1);
                $("#events_form [name='imagepath']").val(imagename);
                
            }
            else{
                preview.src="";
                $("#events_form [name='imagepath']").val("");
                $("#image_form [name='image']").val("");
                c_alert("error","The selected file is not an image");
            }
            
        }
        else{
            preview.src="";
        }
    }
    $("#image_form").submit(function(e){
        e.preventDefault();
        u_url="uploadfile";
        //data=$("#image_form").serialize();
        var formData=new FormData(this);
        formData.append('file',$("#image_form [name='image']")[0].files[0]);
        imagesize=$("#image_form [name='image']")[0].files[0].size;
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
                }
                else{
                     c_alert('error'," an error occured "+response);
                }
                
            },
            error:function(err){
                //console.log(err);
                if(err.indexOf('upload_max_filesize ')>=0)
                {
                    c_alert("error","The image Exceeds the max size of 5mb");
                }
            }
        });
     });
     function loadEvents(){
        var token = $('meta[name="csrf-token"]').attr('content');
        $("#persondata_table").parent().html(tabletmp);
        usr=getsession();
        user_type=usr.user_type;
        data={"table":"events","select_type":"dict","_token": token};
        
        $.ajax({
            async:false,
            type:'POST',
            url:'select',
            data:data,
            success:function(response){
                    //console.log(response);
                if (response!="no results") {
                    response=JSON.parse(response);
                    $(".mydata").html('');
                    myitems=[];
                    x=0;
                    for(i in response){
                        _p=response[i];
                        x++;
                        daten=new Date(""+_p.date_created+"");
                        daten=daten.toLocaleDateString();
                        descr=_p.description.substring(0,100)+"..";
                        //alert(_p.totalticketsvip);
                        totalT=(parseInt(_p.totalticketsvip))+parseInt(_p.totalticketsreg);
                        if(user_type=="Admin"){
                            //alert("admin");
                        myitems.push('<div class="col-md-5 text-center animate-box shadow px-0 bg-light my-2" ><div class="row container px-0" id="item'+x+'"><div class="col-md-5 container px-3"><a  class="work w-100" style="background-image: url(assets/images/'+_p.imagepath+')!important;background-size: contain;"><div class="desc"><h3>Modify this Event </h3><span><input type="hidden" name="pastpaperpath'+x+'"/><input type="button" itd="'+_p.id+'" name="'+x+'" class="btn btn-primary rndbtn mx-3 my-2 editbtn" imag="'+_p.imagepath+'" desc="'+_p.description+'" imag="'+_p.imagepath+'" totalticketsreg="'+_p.totalticketsreg+'"  totalticketsvip="'+_p.totalticketsvip+'"  totalbooking="'+_p.totalbooking+'"  title="'+_p.title+'" value="Edit" /></span></div></a></div><span class="col-md-7 px-0 pt-2 " style="background-color: white"><div class="pro">Title : <span class=" title'+x+' var">'+_p.title+'</span></div><div class="pro">Event Date: <span class=" ndate'+x+' date var">'+_p.eventdate+'</span></div><div class="pro">Venue : <span class="Venue'+x+' var">'+_p.venue+'</span></div><div class="row w-100 text-primary font-weight-bold float-left">Event Description</div><div class=" w-100 row mx-auto p_description'+x+'">'+descr+'</div><div class="vipticket">VIP : Ksh.<span class="text-primary costperticketvip'+x+'">'+_p.costperticketvip+'</span></div><div class="regticket ">Regular : Ksh.<span class="text-primary costperticketreg'+x+'">'+_p.costperticketreg+' </span></div><div class="regticket">Total Tickets : <span class="text-primary">'+totalT+'</span></div><div class="">Booked Tickets : <span class="text-primary">'+_p.totalbooking+'</span></div> <input type="button" itd="'+_p.id+'" name="'+x+'" class="btn btn-primary rndbtn mx-3 my-2 editbtn" imag="'+_p.imagepath+'" desc="'+_p.description+'" title="'+_p.title+'" totalticketsreg="'+_p.totalticketsreg+'"  totalticketsvip="'+_p.totalticketsvip+'"  totalbooking="'+_p.totalbooking+'" value="Edit" /></div>');
                    }
                    else {
                        myitems.push('<div class="col-md-5 text-center animate-box  shadow px-0 bg-light my-2" ><div class="row container px-0" id="item'+x+'"><div class="col-md-5 container px-3"><a  class="work w-100" style="background-image: url(assets/images/'+_p.imagepath+')!important;background-size: contain;"><div class="desc"><h3>Interested in this Event ?</h3><span><form ><input type="button" itd="'+_p.id+'" name="'+x+'" class="btn btn-info rndbtn bookbtn"  title="'+_p.title+'" value="Book Event" /></form></span></div></a></div><span class="col-md-7 px-0 pt-2 " style="background-color: white"><div class="pro">Title : <span class=" title'+x+' var">'+_p.title+'</span></div><div class="pro">Event Date: <span class="date'+x+' date var">'+_p.eventdate+'</span></div><div class="pro">Venue : <span class="Venue'+x+' var">'+_p.venue+'</span></div><div class=" w-100 text-primary font-weight-bold float-left">Event Description</div><div class="w-100 mx-auto row p_description'+x+'">'+descr+'</div><div class="vipticket">VIP : Ksh.<span class="text-primary">'+_p.costperticketvip+'</span></div><div class="regticket">Regular : Ksh.<span class="text-primary">'+_p.costperticketreg+'</span></div><div class="regticket">Total Tickets : <span class="text-primary">'+totalT+'</span></div><div class="">Booked Tickets : <span class="text-primary">'+_p.totalbooking+'</span></div> <input type="button" itd="'+_p.id+'" name="'+x+'" title="'+_p.title+'" class="btn btn-dark rndbtn bookbtn mx-3 my-2"value="Book Event" imag="'+_p.imagepath+'" /></div>');
                        }
                    }
                    item="";
                    grp=1;
                   // console.log(myitems);
                    for(i=0;i<myitems.length;i++)
                    {
                        $(".mydata").append(myitems[i]);
                    }
                    
                    $(".bookbtn").click(function(){
                        ticket_type="";
                        if(Object.keys(my_session).length === 0)
                        {
                            c_alert("error","please login to book Event");
                            return;
                        }
                        res=confirm("Do you want VIP ticket?");
                        if(res)
                            ticket_type="VIP";
                        else{
                            res=confirm("Do you want Regular ticket?");
                            if(res)
                                ticket_type="Regular";
                        }
                        if(ticket_type=="")
                        {
                            c_alert("error","please decide on the ticket you want");
                            return;
                        }
                        user=getsession();
                        i=$(this).prop('name');
                        n_id=$(this).attr('itd');
                        etitle=$(this).attr('title');
                        //alert(etitle);
                        var token = $('meta[name="csrf-token"]').attr('content');
                        adata={table:"bookings","eventtitle":etitle,"bookinguser":user.username,"constrnt":etitle +"_"+user.username,"_token":token,"ticket_type":ticket_type,"eventid":n_id};
                        $.ajax({
                            url:"insert",
                            async:false,
                            type:"POST",
                            data:adata,
                            success:function(response){
                               // console.log(response);
                                if(response.indexOf("success")>-1)
                                {
                                    c_alert("success","Event booked successfully");
                                    ndata={id:n_id,"_token":token,incriment:"add"};
                                        $.ajax({
                                            url:"incrticket",
                                            async:false,
                                            type:"POST",
                                            data:ndata,
                                            success:function(response){
                                                //console.log(response);
                                                if(response.indexOf("success")>-1)
                                                {
                                                    c_alert("success","Ticket Recoreded successfully");
                                        data={message:"Thank you for booking your "+etitle+" ticket at churchill laugh industry ",to:getsession().email,subject:"Ticket booked successfully"}
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
                                                else
                                                {
                                                    c_alert("error",response);
                                                }
                                            },
                                            error:function(err){
                                                console.log("error");
                                                console.log(err);
                                                //c_alert("error",response);
                                            }
                                        });
                                }
                                else
                                {
                                    c_alert("error",response);
                                }
                            },
                            error:function(err){
                                console.log("error");
                                console.log(err);
                                //c_alert("error",response);
                            }
                        });
                        loadEvents();
                    });
                    $(".editbtn").click(function(){
                        i=$(this).prop('name');
                        n_id=$(this).attr('itd');
                        imag=$(this).attr('imag');
                        titl=$(this).attr('title');
                        desc=$(this).attr('desc');
                        $("[name='id']").val(n_id);
                        $("[name='title']").val(titl);
                        $("[name='imagepath']").val(imag);
                        $("[name='venue']").val($(".Venue"+i).text());
                        $("[name='costperticketreg']").val($(".costperticketreg"+i).text());
                        $("[name='costperticketvip']").val($(".costperticketvip"+i).text());
                        $("[name='totalticketsvip']").val($(this).attr('totalticketsvip'));
                        $("[name='totalticketsreg']").val($(this).attr('totalticketsreg'));
                        $("[name='totalbooking']").val($(this).attr('totalbooking'));
                        $("[name='eventdate']").val($(".ndate"+i).text());
                        
                        $("[name='description']").val(desc);
                        toggler();
                    });   
                }
                else{
                    if (response=="no results")
                    {
                        if(user_type!="ADMIN")
                            alert(" YOU have not added any records ");
                        else {
                            alert("No pastpapers uploaded Yet");
                        }
                    }
                    else
                     alert(" Load data failed ");
                }
                
            },
            error:function(err){
                console.log(err);
                //alert("error"+JSON.parse(err));
            }
        });
            //init_table("persondata_table");

    }
	</script>
 	@endsection
    <!-- copy rights reserved by Smb -->
