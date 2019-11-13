
	@extends('master')
		@section('title')
		 churchillEvents
		 @endsection
	@section('content')
 	<div class="mx-4 contentbody ">
        <h3 class="text-center">My TICKETS</h3>
        <input type="hidden" name="id">
        <input type="hidden" name="eventid">
        <div class="table-responsive bg-white rounded text-dark p-2 withshadow" id="tablething">
                <table id="events_table" class="table table-bordered table-striped w-100">
                    <thead>
                        <tr>
                            <td>Ticket Id</td>
                            <td>Ticket Type</td>
                            <td>Event Id</td>
                            <td>Event Title</td>
                            <td>Booked By</td>
                            <td>Booked On</td>
                            <td>--Actions--</td>
                        </tr>
                    </thead>
                    <tbody id="m_body">
                         <tr>
                            <td>Ticket Id</td>
                            <td>Ticket Type</td>
                            <td>Event Id</td>
                            <td>Event Title</td>
                            <td>Booked By</td>
                            <td>Booked On</td>
                        </tr>
                    </tbody>
                </table>
         </div>
        
    </div>
 	@endsection

 	@section('script')
	<script type="text/javascript">
        tabletmp="";
     $(document).ready(function () {
        if($("#logged_user").text()=="New User")
           window.location.href=('home');
        tabletmp = $("#events_table").parent().html();
        $(".actv").removeClass('actv');
        $(".myevent").addClass('actv');
        if(Object.keys(my_session).length != 0)
        loadEvents();
     });
    function loadEvents(){
        $("#events_table").parent().html(tabletmp);
        var token = $('meta[name="csrf-token"]').attr('content');
        usr=getsession();
        user_type=usr.user_type;
        data={"table":"bookings","select_type":"dict","_token": token,bookinguser:usr.username};
        if(user_type=="Admin")
            data={"table":"bookings","select_type":"dict","_token": token};
        $.ajax({
            async:false,
            type:'POST',
            url:'select',
            data:data,
            success:function(response){
                    //console.log(response);
                if (response!="no results") {
                    response=JSON.parse(response);
                    $("#m_body").html('');
                    myitems=[];
                    bodydata='';
                    for(i in response){
                        tkt=response[i];
                        bodydata+='<tr>';
                        bodydata+='<td>'+tkt.id+'</td><td>'+tkt.ticket_type+'</td><td>'+tkt.eventid+'</td><td>'+tkt.eventtitle+'</td><td>'+tkt.bookinguser+'</td><td>'+tkt.created_at+'</td> <td><button class="btn btn-danger delEventbtn">Delete</button></td>';
                        bodydata+='</tr>';
                    }
                    $("#m_body").append(bodydata);

                }
                else{
                    if (response=="no results")
                    {
                        if(user_type!="ADMIN")
                            alert(" YOU have not booked any event");
                        else {
                            alert("No bookings Yet");
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
            init_table("events_table");

    }
    function init_table(tb) {

            try {
                d_table = $("#" + tb).DataTable({
                dom: '<"dt"<"export_btns"B>rftip>',
                select: true
            });
                $("#events_table tbody tr").click(function () {
                    $("[name='id']").val($(this).children("td").eq(0).text());
                    $("[name='eventid']").val($(this).children("td").eq(2).text());

                });
                $(".delEventbtn").click(function(){
                    $("#events_table tbody tr").click();
                        res=confirm("Are you sure you want to delete ticket?");
                        if(!res)
                        {
                            return;
                        }
                        var token = $('meta[name="csrf-token"]').attr('content');
                        adata={table:"bookings","_token":token,"id":$("[name='id']").val()};
                        $.ajax({
                            url:"delete",
                            async:false,
                            type:"POST",
                            data:adata,
                            success:function(response){
                               // console.log(response);
                                if(response.indexOf("success")>-1)
                                {
                                    c_alert("success","Event Removed successfully");
                                    ndata={id:$("[name='eventid']").val(),"_token":token,incriment:"less"};
                                        $.ajax({
                                            url:"incrticket",
                                            async:false,
                                            type:"POST",
                                            data:ndata,
                                            success:function(response){
                                                //console.log(response);
                                                if(response.indexOf("success")>-1)
                                                {
                                                    c_alert("success","Ticket Deleted successfully");

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
                //alert("loaded");
            } catch (e) {
                alert("un expected error occurred " + e);
            }
       }
	</script>
 	@endsection
    <!-- copy rights reserved by Smb -->
