
<?php 
    try {
        session_start();
        $user_type="";
        $user="";
        $phone="";
        $t_email="";
        if (isset($_SESSION['usertype'])) {
            $user=$_SESSION['username'];
            $user_type=$_SESSION['usertype'];
            $phone=$_SESSION['phone'];
            $t_email=$_SESSION['email'];


            // if($_SESSION['user_status']!="ACTIVE")
            // echo "<script>window.location.replace('logout.php')</script>";
        }
    } catch (Exception $e) {
        
    }
    // if (!isset($_SESSION['user_type'])||!isset($_SESSION['username'])) {
        
    //     echo "<script>window.location.replace('index')</script>";
    // }
    // else {
    {
        $username="anonymous";//$_SESSION['username'];
    }
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Master Template">
    <meta name="author" content="S.M.B (Samwel Muchira Benard)">
    <meta name="keywords" content="churchill Events">
     <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Title Page-->
    <title>@yield('title')</title>
    <!-- Fontfaces CSS-->
    <link href="assets/css/font-face.css" rel="stylesheet" media="all">
    <link href="assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="assets/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
    <link rel="stylesheet" type="text/css" href="css/jquery-confirm.css">
    <link rel="stylesheet" type="text/css" href="js/loader/waitMe.css">
    <!-- Add style for specific page -->
    @yield('style')
    <!-- Vendor CSS-->
    <link href="assets/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="assets/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="assets/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all" />
</head>
<!-- PAGE CONTAINER-->
<body >
        <!-- NAVIGATION MENU-->
        <div class="container pb-0" style="border-bottom: solid !important;">
            <nav class="navbar navbar-expand-md  navbar-light py-0 my-0" style="z-index: 100;">
                <!-- Brand -->
                <div class="navbar-brand m-0" >
                    <div class="logo row m-0 p-0">
                            <a href="home" class="nav-link text-white "><div>
                                 <img src="../assets/images/logo.png" alt="img" class=" image  pt-3 pl-2" id="logo" style=" width: 100px" />
                            </div>
                        </a>
                        </div>

                </div>
                <!-- Toggler/collapsibe Button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Navbar links -->
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav ml-auto menn" style="float: right !important;">
                        <li class="nav-item home">
                            <a class="nav-link " href="home">Home</a>
                        </li>
                        <li class="nav-item myevent">
                            <a class="nav-link " href="myevents">My Tickets</a>
                        </li>
                        <li class="nav-item prof">
                            <a class="nav-link " href="profile">Profile</a>
                        </li>
                    </ul>
                    <span >
                        
                        <col class="d-flex justify-content-center col-md bg-primary" style="color:black;font-weight:bold" >
                            <span class="dropdown">
                            <label style="display: none;" id="logged_user_type"><?php echo "$user_type"; ?></label>
                             <a class="dropdown-toggle text-dark btn" data-toggle="dropdown" href="#" id="logged_user"><?php if($user_type!="")echo $_SESSION['username'];else echo "New User"; echo " ($user_type)"?> </a>
                            <ul class="dropdown-menu menn-s ">
                              <li class="m-2 login"><a href="login" >Login/Register</a></li>
                              <!-- <li class="admin"><a href="manageusers" class="">Manage Users</a></li> -->
                              <li class="m-2 logout"><a href="login"  >Logout</a></li>
                            </ul></span> 
                           </col>
                    </span>
                </div>
            </nav>
        </div>
        <!-- MAIN CONTENT-->
        <div class=" container section__content section__content--p30 bodything mx-auto px-0" >
                    @yield('content')
            <div class="w-100 bg-light d-flex justify-content-center  text-dark font-weight-bold">
                <div class="">
                    <p >Copyright © <span class="year">2019</span> . All rights reserved.(Smb) Samwel Muchira Benard
                </div>
                
            </div>
        </div>

    <!-- Jquery JS-->
    <script src="assets/vendor/jquery-3.2.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/jquery-confirm.js"></script>
    <script src="js/loader/waitMe.js"></script>
    <!-- Bootstrap JS-->
    <script src="assets/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="assets/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="assets/vendor/slick/slick.min.js">
    </script>
    <script src="assets/vendor/wow/wow.min.js"></script>
    <script src="assets/vendor/animsition/animsition.min.js"></script>
    <script src="assets/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="assets/vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="assets/vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="assets/vendor/circle-progress/circle-progress.min.js"></script>
    <script src="assets/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="assets/vendor/select2/select2.min.js">
    </script>
    </script>
    

    <!-- Main JS-->
    <script src="assets/js/main.js"></script>
    <script type="text/javascript">
        myses={};
    $(document).ready(function () {
       myses=getsession();
     });
    $(".switch").click(function (){
        $(".form_view").slideToggle();
        $(".table_view").slideToggle();
    });
    function getsession(){
        my_session='<?php echo json_encode($_SESSION)?>';
        my_session=JSON.parse(my_session);
      //  alert(my_session.username);
        dusername=my_session.username;
        if(Object.keys(my_session).length === 0)
            $("#logged_user").text("New User");
        else
            $("#logged_user").text(my_session.username+"("+my_session.user_type+")");

        if($("#logged_user").text()!="New User")
        {
            $(".login").hide();
            $(".logout").show();
        }
        else
        {
            $(".logout").hide();
            $(".login").show();
        }
        if(my_session.user_type=="Admin")
        {
            $(".admin").show();
        }
        else
        {
            $(".admin").hide();
        }

        //console.log(my_session);
        return my_session;
    }
    function c_alert(typ,message)
    {
        if(typ=='norm'){
            title='Alert 😏 🤦‍♂️ ';
            colr='orange';
        }
        if(typ=='success')
        {
            colr="green";
            title="success ☺😋 "
        }
        if(typ=='error')
        {
            colr="red";
            title="Error !!"
        }
        if(typ=='blue')
        {
            colr="blue";
            title="Action Completed"
        }
        $.alert({
        type: colr,
        title: title,
        content: message,
        buttons: {
            ok: {
                text: "OK",
                btnClass: 'btn-primary',
                keys: ['enter'],
                action: function () {
                    
                }
            },
            cancel: function () {
                //window.location.href = "home.html";
                //console.log('the user clicked cancel');
            }
        }
         });
    }

    function wait(elem,info)
    {
        $(''+elem+'').waitMe({
                effect : 'win8',
                text : info,
                bg : 'rgba(255,255,255,0.6)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',  
                source : '',
            onClose : function() {}});
    }
    function stop(elem)
    {
        $(""+elem+"").waitMe("hide");
    }
    
    </script>
    <!-- add script specific to a page -->
     @yield('script')
</body>

</html>
<!-- end document-->
<!-- copy rights reserved by Smb -->
