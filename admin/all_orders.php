<!DOCTYPE html>
<html lang="en">
    <?php
        include("../connection/connect.php");
        error_reporting(E_ALL);
        session_start();
        ob_start();

        function fetch_data()  
        {  
            $output = '';  
            $servername = "localhost"; //server
            $username = "root"; //username
            $password = ""; //password
            $dbname = "online_rest";  //database
            $db = mysqli_connect($servername, $username, $password, $dbname);
            $sql = "SELECT users.*, users_orders.* FROM users INNER JOIN users_orders ON users.u_id=users_orders.u_id ORDER BY o_id ASC";  
            $result = mysqli_query($db, $sql);  
            while($rows = mysqli_fetch_array($result))  
            {       
                $output .= '
                <tr>   
                    <td>'.$rows['o_id'].'</td>                         
                    <td>'.$rows['username'].'</td>
                    <td>'.$rows['title'].'</td>
                    <td>'.$rows['quantity'].'</td>
                    <td>Php '.$rows['price'].'</td>
                    <td>Php '.$rows['price']*$rows['quantity'].'</td>
                    <td>'.$rows['address'].'</td>
                    <td>'.$rows['date'].'</td>
                </tr>';  
            }  
            return $output;  
        }  
        if(isset($_POST["create_pdf"]))  
        {  
            require_once('tcpdf/tcpdf.php');  
            $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
            $obj_pdf->SetCreator(PDF_CREATOR);  
            $obj_pdf->SetTitle("Zinnovare's Orders Report");  
            $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
            $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
            $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
            $obj_pdf->SetDefaultMonospacedFont('helvetica');  
            $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
            $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '15', PDF_MARGIN_RIGHT);  
            $obj_pdf->setPrintHeader(false);  
            $obj_pdf->setPrintFooter(false);  
            $obj_pdf->SetAutoPageBreak(TRUE, 10);  
            $obj_pdf->SetFont('helvetica', '', 10);  
            $obj_pdf->AddPage();  
            $content = '';  
            $content .= '  
            <h3 align="center">Zinnovare\'s Orders Report</h3><br /><br />  
            <table border="1" cellspacing="0" cellpadding="5">  
                <tr>  
                    <th width="5%">ID</th>
                    <th width="15%">Username</th>
                    <th width="20%">Title</th>
                    <th width="6%">Qty</th>  
                    <th width="12%">Price</th>  
                    <th width="12%">Total</th>  
                    <th width="18%">Address</th>
                    <th width="12%">Date</th>
                </tr>  
            ';  
            $content .= fetch_data();  
            $content .= '</table>';  
            $obj_pdf->writeHTML($content);  
            while( ob_get_level() ) {
                ob_end_clean();
            }
            $obj_pdf->Output('Zinnovare-Orders-Report.pdf', 'I');  
        } 

        if(isset($_POST['update']))
        {
            $id=$_GET['o_id'];
            $status=$_POST['status'];
            $remark=$_POST['remark'];
            $query=mysqli_query($db,"insert into remark(frm_id,status,remark) values('$id','$status','$remark')");
            $sql=mysqli_query($db,"update users_orders set status='$status' where o_id='$id'");

            echo "<script>alert('form details updated successfully');</script>";

        }

    ?>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="images/logo1.png">
        <title>Zinnovare Admin Orders</title>
        <!-- Bootstrap Core CSS -->
        <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="css/helper.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
        <!--[if lt IE 9]>
        <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    </head>

    <body class="fix-header fix-sidebar">
        <!-- Preloader - style you can find in spinners.css -->
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
            </svg>
        </div>
        <!-- Main wrapper  -->
        <div id="main-wrapper">
            <!-- header header  -->
            <div class="header">
                <nav class="navbar top-navbar navbar-expand-md navbar-light">
                    <!-- Logo -->
                    <div class="navbar-header" style="background-color: orange; border-radius: 0 0px 0px 0">
                    
                        <a class="navbar-brand" href="dashboard.php">
                            <!-- Logo icon -->
                            <b><img src="images/logo_Z.png" alt="homepage" class="dark-logo" width="35px" height="35px"/></b>
                            <!--End Logo icon -->
                            <!-- Logo text -->
                            <span><img src="images/logo_Zt.png" alt="homepage" class="dark-logo" width="120px" height="25px"/></span>
                        </a>
                    </div>
                    <!-- End Logo -->
                    <div class="navbar-collapse">
                        <!-- toggle and nav items -->
                        <ul class="navbar-nav mr-auto mt-md-0">
                            <!-- This is  -->
                            <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted  " href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                            <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted  " href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        </ul>
                        <!-- User profile and search -->
                        <ul class="navbar-nav my-lg-0">

                            <!-- Search
                            <li class="nav-item hidden-sm-down search-box"> <a class="nav-link hidden-sm-down text-muted  " href="javascript:void(0)"><i class="ti-search"></i></a>
                                <form class="app-search">
                                    <input type="text" class="form-control" placeholder="Search here"> <a class="srh-btn"><i class="ti-close"></i></a> </form>
                            </li> -->
                            <!-- Comment -->
                            <li class="nav-item dropdown">
                            
                                <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn">
                                    <ul>
                                        <li>
                                            <div class="drop-title">Notifications</div>
                                        </li>
                                        
                                        <li>
                                            <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- End Comment -->
                        
                            <!-- Profile -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/bookingSystem/2.png" alt="user" class="profile-pic" /></a>
                                <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                    <ul class="dropdown-user">
                                    <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- End header header -->
            <!-- Left Sidebar  -->
            <div class="left-sidebar">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                            <li class="nav-devider"></li>
                            <li class="nav-label">Home</li>
                            <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-tachometer"></i><span class="hide-menu">Dashboard</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="dashboard.php">Dashboard</a></li>
                                    
                                </ul>
                            </li>
                            <li class="nav-label">Log</li>
                            <li> <a class="has-arrow  " href="#" aria-expanded="false">  <span><i class="fa fa-user f-s-20 "></i></span><span class="hide-menu">Users</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="allusers.php">All Users</a></li>
                                    <li><a href="add_users.php">Add Users</a></li>
                                    
                                
                                </ul>
                            </li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-cutlery" aria-hidden="true"></i><span class="hide-menu">Menu</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="all_menu.php">Menu</a></li>
                                    <li><a href="add_menu.php">Add Dish</a></li>
                                
                                    
                                </ul>
                            </li>
                            <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-shopping-basket" aria-hidden="true"></i><span class="hide-menu">Orders</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="all_orders.php">All Orders</a></li>
                                </ul>
                            </li>
                            
                        </ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </div>
            <!-- End Left Sidebar  -->
            <!-- Page wrapper  -->
            <div class="page-wrapper" style="padding-bottom:0">
                <!-- Container fluid  -->
                <div class="container-fluid" style="padding-bottom:0">
                    <!-- Start Page Content -->
                    <div class="row">
                        <div class="col-12">
                            
                        
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">All User Orders</h4>
                                
                                    <div class="table-responsive m-t-40">
                                        <table id="myTable" class="table table-hover" style="font-size:15px;">
                                            <thead>
                                                <tr>
                                                <th>ID</th>
                                                    <th>Username</th>		
                                                    <th>Title</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                    <th>Total</th>
                                                    <th>Address</th>
                                                    <th>Status</th>												
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sql="SELECT users.*, users_orders.* FROM users INNER JOIN users_orders ON users.u_id=users_orders.u_id";
                                                    $query=mysqli_query($db,$sql);
                                                    
                                                    if(!mysqli_num_rows($query) > 0 )
                                                    {
                                                        echo '<td colspan="8"><center>No Orders-Data!</center></td>';
                                                    }
                                                    else
                                                    {				
                                                        while($rows=mysqli_fetch_array($query))
                                                        {
                                                                                                                                            
                                                            ?>
                                                                <?php
                                                                    echo ' <tr>
                                                                    <td>'.$rows['o_id'].'</td>
                                                                    <td>'.$rows['username'].'</td>
                                                                    <td>'.$rows['title'].'</td>
                                                                    <td>'.$rows['quantity'].'</td>
                                                                    <td>Php '.$rows['price'].'</td>
                                                                    <td>Php '.$rows['price']*$rows['quantity'].'</td>
                                                                    <td>'.$rows['address'].'</td>';
                                                                ?>
                                                            <?php 
                                                                            $status=$rows['status'];
                                                                            if($status=="" or $status=="NULL")
                                                                            {
                                                                                ?>
                                                                                    <td> 
                                                                                        <button type="button" class="btn btn-info" style="width: 90%;border: none; background: #5BC0DE;font-size:small">
                                                                                        <i class="fa fa-hourglass fa-spin"  aria-hidden="true" ></i>
                                                                                        Pending
                                                                                        </button>
                                                                                    </td>
                                                                                <?php 
                                                                            }
                                                                            if($status=="in process")
                                                                    { 
                                                                        ?>
                                                                            <td> 
                                                                                <button type="button" class="btn btn-warning" style="width: 90%;border: none; background: orange;font-size:small">
                                                                                    <i class="fa fa-cog fa-spin"  aria-hidden="true" ></i>
                                                                                    Processing
                                                                                </button>
                                                                            </td> 
                                                                        <?php
                                                                        }
                                                                    if($status=="closed")
                                                                        {
                                                                            
                                                                    ?>
                                                                    <td> 
                                                                        <button type="button" class="btn btn-success" style="width: 90%;border: none; background: #00CC00;font-size:small">
                                                                            <i  class="fa fa-check" aria-hidden="true"></i>
                                                                            Delivered
                                                                        </button>
                                                                    </td> 
                                                                    
                                                                    
                                                                    <?php 
                                                                    } 
                                                                    ?>
                                                                    <?php
                                                                        if($status=="rejected")
                                                                            {
                                                                    ?>
                                                                        <td> 
                                                                            <button type="button" class="btn btn-danger" style="width: 90%;border: none; background: Red;font-size:small"> 
                                                                                <i class="fa fa-close"></i> 
                                                                                Cancelled
                                                                            </button>
                                                                        </td> 
                                                                        <?php 
                                                                        } 
                                                                        ?>
                                                            <?php																									
                                                            echo '	<td>'.$rows['date'].'</td>';
                                                            ?>
                                                                <td><center>
                                                                 
                                                            <?php
                                                            echo '<a href="view_order.php?user_upd='.$rows['o_id'].'" " class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5"><i class="ti-settings"></i></a>
                                                                </center></td>
                                                                </tr>';       
                                                        }	
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                        <br />  
                                        <form method="post">  
                                            <input type="submit" name="create_pdf" class="btn btn-danger" style="background-color: orange;border:1px solid orange" value="Download Report" />  
                                        </form> 
                                    </div>
                                </div>
                            </div>
                            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End PAge Content -->
                </div>
                <!-- End Container fluid  -->
                <!-- footer -->
            <footer class="footer"  style="margin:0; padding-bottom:15px"> © 2017-2022.
					<span class="copyright">
						Zinnovare Inc.
					</span>
                    All Rights Reserved.
            </footer>
            
            <!-- End footer -->
            </div>
            <!-- End Page wrapper  -->
        </div>
        <!-- End Wrapper -->
        <!-- All Jquery -->
        <script src="js/lib/jquery/jquery.min.js"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="js/lib/bootstrap/js/popper.min.js"></script>
        <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="js/jquery.slimscroll.js"></script>
        <!--Menu sidebar -->
        <script src="js/sidebarmenu.js"></script>
        <!--stickey kit -->
        <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
        <!--Custom JavaScript -->
        <script src="js/custom.min.js"></script>


        <script src="js/lib/datatables/datatables.min.js"></script>
        <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
        <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
        <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
        <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
        <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
        <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
        <script>
            </script>
        <script src="js/lib/datatables/datatables-init.js"></script>
    </body>

</html>