<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Schedule</title>
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
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }

    }else{
        header("location: ../login.php");
    }
    
    

    //import database
    include("../connection.php");

    
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
                    <td class="menu-btn menu-icon-dashbord" >
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">Your Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor ">
                        <a href="doctors.php" class="non-style-link-menu "><div><p class="menu-text">View Doctors</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-schedule menu-active menu-icon-schedule-active">
                        <a href="schedule.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">View Schedule</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">View Appointment</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient">
                        <a href="patient.php" class="non-style-link-menu"><div><p class="menu-text">View Patients</p></a></div>
                    </td>
                </tr>

            </table>
        </div>
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
               
               
                <tr>
                    <td colspan="4" >
                        <div style="display: flex;margin-top: 40px;">
                        
                        <a href="?action=add-session&id=none&error=0" class="non-style-link"><button  class="login-btn btn-primary btn button-icon" style="margin-left:25px;background-image: url('');">Add Appointment</button>
                        </a>
                        </div><br><br>
                    </td>
                </tr>
               
               
                
                        <?php
                            if($_POST){
                                //print_r($_POST);
                                $sqlpt1="";
                                if(!empty($_POST["sheduledate"])){
                                    $sheduledate=$_POST["sheduledate"];
                                    $sqlpt1=" schedule.scheduledate='$sheduledate' ";
                                }


                                $sqlpt2="";
                                if(!empty($_POST["docid"])){
                                    $docid=$_POST["docid"];
                                    $sqlpt2=" doctor.docid=$docid ";
                                }
                                //echo $sqlpt2;
                                //echo $sqlpt1;
                                $sqlmain= "select schedule.scheduleid,schedule.title,doctor.docname,schedule.scheduledate,schedule.scheduletime,schedule.nop from schedule inner join doctor on schedule.docid=doctor.docid ";
                                $sqllist=array($sqlpt1,$sqlpt2);
                                $sqlkeywords=array(" where "," and ");
                                $key2=0;
                                foreach($sqllist as $key){

                                    if(!empty($key)){
                                        $sqlmain.=$sqlkeywords[$key2].$key;
                                        $key2++;
                                    };
                                };
                                //echo $sqlmain;

                                
                                
                                //
                            }else{
                                $sqlmain= "select schedule.scheduleid,schedule.title,doctor.docname,schedule.scheduledate,schedule.scheduletime,schedule.nop from schedule inner join doctor on schedule.docid=doctor.docid  order by schedule.scheduledate desc";

                            }



                        ?>
                  
                <tr>
                   <td colspan="4">
                       <center>
                        <div class="abc scroll">
                            <table width="93%" class="sub-table scrolldown" border="0">
                                <thead>
                                    <tr>
                                        <th class="table-headin">
                                    
                                
                                            Appointment Name
                                
                                        </th>
                                
                                        <th class="table-headin">
                                             Doctor
                                        </th>
                                        <th class="table-headin">
                                    
                                            Sheduled Date & Time
                                    
                                        </th>
                               
                                
                                        <th class="table-headin">
                                    
                                            Events
                                    
                                    </tr>
                                </thead>
                                <tbody>

                                        <?php

                                        
                                            $result= $database->query($sqlmain);

                                            if($result->num_rows==0){
                                                echo '<tr>
                                                <td colspan="4">
                                                <br><br><br><br>
                                            
                                                <br><br><br><br>
                                                </td>
                                                </tr>';
                                                
                                            }
                                            else{
                                            for ( $x=0; $x<$result->num_rows;$x++){
                                                $row=$result->fetch_assoc();
                                                $scheduleid=$row["scheduleid"];
                                                $title=$row["title"];
                                                $docname=$row["docname"];
                                                $scheduledate=$row["scheduledate"];
                                                $scheduletime=$row["scheduletime"];
                                                $nop=$row["nop"];
                                                echo '<tr>
                                                    <td> &nbsp;'.
                                                    substr($title,0,30)
                                                    .'</td>
                                                    <td>
                                                    '.substr($docname,0,20).'
                                                    </td>
                                                    <td style="text-align:center;">
                                                        '.substr($scheduledate,0,10).' '.substr($scheduletime,0,5).'
                                                    </td>
                                                

                                                    <td>
                                                    <div style="display:flex;justify-content: center;">
                                                    
                                                    <a href="?action=view&id='.$scheduleid.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">View</font></button></a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="?action=drop&id='.$scheduleid.'&name='.$title.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-delete"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Remove</font></button></a>
                                                    </div>
                                                    </td>
                                                </tr>';
                                                
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
        if($action=='add-session'){

            echo '
            <div id="popup1" class="overlay">
            <div class="popup">
            <center>
            
            
                <a class="close" href="schedule.php">&times;</a> 
                <div style="display: flex;justify-content: center;">
                <div class="abc">
                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                <tr>
                        <td class="label-td" colspan="2">'.
                           ""
                        
                        .'</td>
                    </tr>

                    <tr>
                        <td>
                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add Appointment.</p><br>
                        </td>
                    </tr>
                    <tr>
                        
                        <form action="add-session.php" method="POST" class="add-new-form">
                            <label for="title" class="form-label">Appointment Name: </label>
                       
                    
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="text" name="title" class="input-text" placeholder="" required><br>
                                </td>
                            </tr>
                            <tr>
                                
                                <td class="label-td" colspan="2">
                                    <label for="docid" class="form-label"> Doctor: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <select name="docid" id="" class="box" >
                                    <option value="" disabled selected hidden>Doctor Name</option><br/>';
                                        

                                        $list11 = $database->query("select  * from  doctor order by docname asc;");

                                        for ($y=0;$y<$list11->num_rows;$y++){
                                            $row00=$list11->fetch_assoc();
                                            $sn=$row00["docname"];
                                            $id00=$row00["docid"];
                                            echo "<option value=".$id00.">$sn</option><br/>";
                                        };



                                        
                        echo     '       </select><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="nop" class="form-label">Number of Patients </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="number" name="nop" class="input-text" min="0"  placeholder="" required><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="date" class="form-label">Session Date: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="date" name="date" class="input-text" min="'.date('Y-m-d').'" required><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="time" class="form-label">Schedule Time: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="time" name="time" class="input-text" placeholder="Time" required><br>
                                </td>
                            </tr>
                        
                            <tr>
                                <td colspan="2">
                                    <input type="reset" value="Edit" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                
                                    <input type="submit" value="Add Appointment" class="login-btn btn-primary btn" name="shedulesubmit">
                                </td>
                
                            </tr>
                   
                    </form>
                    </tr>
                </table>
                </div>
                </div>
            </center>
            <br><br>
            </div>
            </div>
    
            ';
        }elseif($action=='session-added'){
            $titleget=$_GET["title"];
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                    <br><br>
                        <h2>APPOINTMENT ADDED</h2>
                        <a class="close" href="schedule.php">&times;</a>
                        
                        <div style="display: flex;justify-content: center;">
                        
                        <a href="schedule.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                        <br><br><br><br>
                        </div>
                    </center>
            </div>
            </div>
            ';
        }elseif($action=='drop'){
            $nameget=$_GET["name"];
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Do you want to delete this appointment?</h2>
                        <a class="close" href="schedule.php">&times;</a>
                      
                        <div style="display: flex;justify-content: center;">
                        <a href="delete-session.php?id='.$id.'" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="schedule.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                        </div>
                    </center>
            </div>
            </div>
            '; 
        }elseif($action=='view'){
            $sqlmain= "select schedule.scheduleid,schedule.title,doctor.docname,schedule.scheduledate,schedule.scheduletime,schedule.nop from schedule inner join doctor on schedule.docid=doctor.docid  where  schedule.scheduleid=$id";
            $result= $database->query($sqlmain);
            $row=$result->fetch_assoc();
            $docname=$row["docname"];
            $scheduleid=$row["scheduleid"];
            $title=$row["title"];
            $scheduledate=$row["scheduledate"];
            $scheduletime=$row["scheduletime"];
            
           
            $nop=$row['nop'];


            $sqlmain12= "select * from appointment inner join patient on patient.pid=appointment.pid inner join schedule on schedule.scheduleid=appointment.scheduleid where schedule.scheduleid=$id;";
            $result12= $database->query($sqlmain12);
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup" style="width: 70%;">
                    <center>
                        <h2></h2>
                        <a class="close" href="schedule.php">&times;</a>
                        <div class="content">
                            
                            
                        </div>
                        <div class="abc scroll" style="display: flex;justify-content: center;">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Appointment Details</p><br><br>
                                </td>
                            </tr>
                            
                            <tr>
                                
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Appointment Name: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$title.'<br><br>
                                </td>
                                
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Email" class="form-label">Doctor: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$docname.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="nic" class="form-label">Scheduled Date: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$scheduledate.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Scheduled Time: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$scheduletime.'<br><br>
                                </td>
                            </tr>
                            

                            
                            <tr>
                            <td colspan="4">
                                <center>
                                 <div class="abc scroll">
                                 <table width="100%" class="sub-table scrolldown" border="0">
                                 <thead>
                                 <tr>   
                                        <th class="table-headin">
                                             Patient ID
                                         </th>
                                         <th class="table-headin">
                                             Patient name
                                         </th>
                                         <th class="table-headin">
                                             
                                             Appointment number
                                             
                                         </th>
                                        
                                         
                                         <th class="table-headin">
                                             Patient Telephone
                                         </th>
                                         
                                 </thead>
                                 <tbody>';
                                 
                
                
                                         
                                         $result= $database->query($sqlmain12);
                
                                         if($result->num_rows==0){
                                             echo '<tr>
                                             <td colspan="7">
                                             <br><br><br><br>
                                           
                                             <br><br><br><br>
                                             </td>
                                             </tr>';
                                             
                                         }
                                         else{
                                         for ( $x=0; $x<$result->num_rows;$x++){
                                             $row=$result->fetch_assoc();
                                             $apponum=$row["apponum"];
                                             $pid=$row["pid"];
                                             $pname=$row["pname"];
                                             $ptel=$row["ptel"];
                                             
                                             echo '<tr style="text-align:center;">
                                                <td>
                                                '.substr($pid,0,15).'
                                                </td>
                                                 <td style="font-weight:600;padding:25px">'.
                                                 
                                                 substr($pname,0,25)
                                                 .'</td >
                                                 <td style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);">
                                                 '.$apponum.'
                                                 
                                                 </td>
                                                 <td>
                                                 '.substr($ptel,0,25).'
                                                 </td>
                                                 
                                                 
                
                                                 
                                             </tr>';
                                             
                                         }
                                     }
                                          
                                     
                
                                    echo '</tbody>
                
                                 </table>
                                 </div>
                                 </center>
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