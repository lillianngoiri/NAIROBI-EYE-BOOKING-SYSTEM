<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Appointments</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
</style>
</head>
<body>
    <?php

    //learn from w3schools.com

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }

    }else{
        header("location: ../login.php");
    }
    

    //import database
    include("../connection.php");
    $userrow = $database->query("select * from patient where pemail='$useremail'");
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["pid"];
    $username=$userfetch["pname"];


    //echo $userid;
    //echo $username;


    $sqlmain= "select appointment.appoid,schedule.scheduleid,schedule.title,doctor.docname,patient.pname,schedule.scheduledate,schedule.scheduletime,appointment.apponum,appointment.appodate from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join patient on patient.pid=appointment.pid inner join doctor on schedule.docid=doctor.docid  where  patient.pid=$userid ";

    if($_POST){
        //print_r($_POST);
        


        
        if(!empty($_POST["sheduledate"])){
            $sheduledate=$_POST["sheduledate"];
            $sqlmain.=" and schedule.scheduledate='$sheduledate' ";
        };

    

        //echo $sqlmain;

    }

    $sqlmain.="order by appointment.appodate  asc";
    $result= $database->query($sqlmain);
    ?>
    <div class="container">
        <div class="menu">
        <table class="menu-container" border="0">
              
                <tr>
                                <td colspan="2">
                                    <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-home" >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Home</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu"><div><p class="menu-text">Available Doctors</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">Available Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment  menu-active menu-icon-appoinment-active">
                        <a href="appointment.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">My Bookings</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Manage Details</p></a></div>
                    </td>
                </tr>
                
            </table>
        </div>
        <div class="dash-body">
            <table border="0" width="70%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                
                    <center>
                    <tr >
                    <td>
                        <p width="50%" style="font-size: 23px;padding-left:12px;font-weight: 600;"> Booked Appointment </p>
                                           
                    </td>
                    </tr>

                    </center>

               
                <!-- <tr>
                    <td colspan="4" >
                        <div style="display: flex;margin-top: 40px;">
                        <div class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49);margin-top: 5px;">Schedule a Session</div>
                        <a href="?action=add-session&id=none&error=0" class="non-style-link"><button  class="login-btn btn-primary btn button-icon"  style="margin-left:25px;background-image: url('../img/icons/add.svg');">Add a Session</font></button>
                        </a>
                        </div>
                    </td>
                </tr> -->
               
                
               
                  
                <tr>
                   <td colspan="4">
                       <center>
                        <div class="abc scroll">
                        <table width="100%" class="sub-table scrolldown" border="0" style="border:none">
                        
                        <tbody>
                        
                            <?php

                                
                                

                                if($result->num_rows==0){
                                    echo '<tr>
                                    <td colspan="7">
                                    <br><br><br><br>
                                 
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                                    
                                }
                                else{

                                    for ( $x=0; $x<($result->num_rows);$x++){
                                        echo "<tr>";
                                        for($q=0;$q<3;$q++){
                                            $row=$result->fetch_assoc();
                                            if (!isset($row)){
                                            break;
                                            };
                                            $scheduleid=$row["scheduleid"];
                                            $title=$row["title"];
                                            $docname=$row["docname"];
                                            $scheduledate=$row["scheduledate"];
                                            $scheduletime=$row["scheduletime"];
                                            $apponum=$row["apponum"];
                                            $appodate=$row["appodate"];
                                            $appoid=$row["appoid"];
    
                                            if($scheduleid==""){
                                                break;
                                            }
    
                                            echo '
                                            <td style="width: 25%;">
                                                    <div  class="dashboard-items search-items"  >
                                                    
                                                        <div style="width:50%;">
                                                            
                                                                <div class="h1-search">
                                                                    '.substr($title,0,21).'<br>
                                                                </div>
                                                                
                                                                <div class="h3-search">
                                                                    '.substr($docname,0,30).'
                                                                </div>
                                                                
                                                                
                                                                <div class="h4-search">
                                                                    Appointment Date: '.$scheduledate.'<br>Time: <b>'.substr($scheduletime,0,5).'</b>
                                                                </div>
                                                                <br>
                                                                <a href="?action=drop&id='.$appoid.'&title='.$title.'&doc='.$docname.'" ><button  class="login-btn btn-primary-soft btn "  style="padding-top:11px;padding-bottom:11px;width:100%"><font class="tn-in-text">Cancel Booking</font></button></a>
                                                        </div>
                                                                
                                                    </div>
                                            </td>';
    
                                        }
                                        echo "</tr>";
                           
                                // for ( $x=0; $x<$result->num_rows;$x++){
                                //     $row=$result->fetch_assoc();
                                //     $appoid=$row["appoid"];
                                //     $scheduleid=$row["scheduleid"];
                                //     $title=$row["title"];
                                //     $docname=$row["docname"];
                                //     $scheduledate=$row["scheduledate"];
                                //     $scheduletime=$row["scheduletime"];
                                //     $pname=$row["pname"];
                                //     
                                //     
                                //     echo '<tr >
                                //         <td style="font-weight:600;"> &nbsp;'.
                                        
                                //         substr($pname,0,25)
                                //         .'</td >
                                //         <td style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);">
                                //         '.$apponum.'
                                        
                                //         </td>
                                //         <td>
                                //         '.substr($title,0,15).'
                                //         </td>
                                //         <td style="text-align:center;;">
                                //             '.substr($scheduledate,0,10).' @'.substr($scheduletime,0,5).'
                                //         </td>
                                        
                                //         <td style="text-align:center;">
                                //             '.$appodate.'
                                //         </td>

                                //         <td>
                                //         <div style="display:flex;justify-content: center;">
                                        
                                //         <!--<a href="?action=view&id='.$appoid.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">View</font></button></a>
                                //        &nbsp;&nbsp;&nbsp;-->
                                //        <a href="?action=drop&id='.$appoid.'&name='.$pname.'&session='.$title.'&apponum='.$apponum.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-delete"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Cancel</font></button></a>
                                //        &nbsp;&nbsp;&nbsp;</div>
                                //         </td>
                                //     </tr>';
                                    
                                }
                            }
                                 
                            ?>
 
                            </tbody>

                        </table>
                        </div>
                        </center>
                   </td> 
                </tr>
                       
                        
                        
            </table>
        </div>
    </div>
    <?php
    
    if($_GET){
        $id=$_GET["id"];
        $action=$_GET["action"];
        if($action=='booking-added'){
            
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                    <br><br>
                        <h2>Booked</h2>
                        
                        
                        <div style="display: flex;justify-content: center;">
                        
                        <a href="appointment.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                        <br><br><br><br>
                        </div>
                    </center>
            </div>
            </div>
            ';
        }elseif($action=='drop'){
            $title=$_GET["title"];
            $docname=$_GET["doc"];
            
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Do you want to delete this Appointment?</h2>
                        <a class="close" href="appointment.php">&times;</a>
                      
                        <div style="display: flex;justify-content: center;">
                        <a href="delete-appointment.php?id='.$id.'" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="appointment.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                        </div>
                    </center>
            </div>
            </div>
            '; 
        }elseif($action=='view'){
            $sqlmain= "select * from doctor where docid='$id'";
            $result= $database->query($sqlmain);
            $row=$result->fetch_assoc();
            $name=$row["docname"];
            $email=$row["docemail"];
            $spe=$row["specialties"];
            
            $spcil_res= $database->query("select sname from specialties where id='$spe'");
            $spcil_array= $spcil_res->fetch_assoc();
            $spcil_name=$spcil_array["sname"];
            $nic=$row['docnic'];
            $tele=$row['doctel'];
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2></h2>
                        <a class="close" href="doctors.php">&times;</a>
                        <div class="content">
                            NAIROBI-EYE ASSOCIATES<br>
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <table width="90%" class="sub-table scrolldown add-doc-form-container" border="0">
                        
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
                                </td>
                            </tr>
                            
                            <tr>
                                
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Name: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$name.'<br><br>
                                </td>
                                
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Email" class="form-label">Email: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$email.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="nic" class="form-label">NIC: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$nic.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Telephone: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$tele.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label">Specialties: </label>
                                    
                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2">
                            '.$spcil_name.'<br><br>
                            </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="doctors.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                                
                                    
                                </td>
                
                            </tr>
                           

                        </table>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';  
    }
}

    ?>
    </div>

</body>
</html>
