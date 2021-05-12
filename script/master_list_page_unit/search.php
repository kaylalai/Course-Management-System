<?php
include('../db_conn.php');    
$search_var = $_POST['searchdetail'];
$sql = "SELECT * FROM unit_detail WHERE unit_code LIKE '%".$search_var."%' OR unit_name LIKE '%".$search_var."%' OR  semester LIKE '%".$search_var."%' OR campus LIKE '%".$search_var."%' OR unit_description LIKE '%".$search_var."%'";
$res = $mysqli->query($sql);
?>
<?php
    $rowcount=$res->num_rows;
    if($rowcount == 0){ //no row return
         echo '<script type="text/javascript">';
            echo ' alert("Dont have a record");'; 
        echo '</script>';
        }
    else {
        echo '<script type="text/javascript">';
        echo '$("#myModal").modal("hide");';  //not showing modal1
        echo '</script>';
        
        echo '<script type="text/javascript">';
        echo '$("#modal2").modal("show");';  //not showing modal2
        echo '</script>';
   
      echo "We found ".$rowcount." result(s)";
        while($row = $res->fetch_assoc()){
    ?>
        
    <!--table in modual-->
<table class="table table-bordered">

    <tbody>
        <tr>
            <td>Unit Code</td>
            <td><?php echo $row['unit_code'];?></td>
        </tr>
        <tr>
            <td>Unit Name</td>
            <td><?php echo $row['unit_name'];?></td>
        </tr>
   <tr>
            <td>Semester</td>
            <td><?php echo $row['semester'];?></td>
        </tr>
   <tr>
            <td>Campus</td>
            <td><?php echo $row['campus'];?></td>
        </tr>
   <tr>
            <td>Unit description</td>
            <td><?php echo $row['unit_description'];?></td>
        </tr>
   
<?php
        }
    }?>
     
 </tbody>
</table>


