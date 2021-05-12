<?php
session_start(); 
include('../db_conn.php'); //db connection
$query="SELECT * FROM `unit_detail`";//variable to the query
$result = $mysqli->query($query);//variable pass the result from query
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <!-- Link to use icon-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> 
        <!--css-->
        <link rel="stylesheet" type="text/css" href="../../css/UnitDCmasterpage.css">
    </head>
    <body>
<!--top bar with show login logout-->
        <div class="topnav">
            <!-- Left-aligned -->
            <a><img src="../../asset/logo.png" alt="logo" style="width:40px; height: 30px; "></a>
            <a href="../home_page/home.php">University of DoWell</a>    
            <!-- Right-aligned links -->
             <div class="topnav-right">
                <a href="../logout_session.php" class="button6" id="logoutBtn" name="logout">Log out</a> <!--not display, until user  login-->
                <a href="../home_page/home.php" class="button6">Home</a>
            </div>
            </div>
<!--end nav bar-->        
        <!-- title-->
        <div class="container" id ="container_b">
            <div class="row">
                <div class="col-9" id ="col_b"><strong>Manage Unit details </strong></div>
            </div>
        </div>
        <div class ="container">
            <div class="row">
                <div class="col-sm-6" >
                    <p><a href="../user_account_management/manage_account.php" > Back to the manage account </a></p><!--link to meun-->
                </div>
                   <!--button for search and trigger the modal-->
                <div class="col-sm-6">
                    <p style="float:right" ><button type="button" data-toggle="modal" data-target="#myModal">Search</button></p>
                    <!--after create a button, need to define the detail of the modal form-->
                    <!-- Modal 1 search input -->
                    <div class="modal" id="myModal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><strong>Search</strong></h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" id="myForm">
                                        <div class="form-group">
                                            <label class="control-label">Search</label>
                                            <input type="text" position:center class="form-control" name="searchdetail" id="searchdetail">
                                        </div>

                                        <div class="form-group">        
                                            <div >
                                                <button id="search-button" class="btn btn-warning" name="search-button" type="button" onclick="SubmitFormData()">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>    

    <!--modal 2,the search result modal-->
                    <div class="modal " id="modal2" role="dialog" style="display:none">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><strong>Search</strong></h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div id="results">
                                        <!-- All data will display here from other php file called result.php -->
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end modual2-->
                    <!-- Modal 3 search input -->
                    <div class="modal" id="modal3" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><h3>Add New Unit</h3></h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" id="addForm">
                                        <div class="form-group">
                                            <label class="control-label col-sm-4">Unit Code</label>  
                                            <div class="col-sm-10">          
                                                <input type="text" class="form-control" name="unit_code" id="unit_code">
                                            </div>
                                            <label class="control-label col-sm-4">Unit Name</label>  
                                            <div class="col-sm-10">          
                                                <input type="text" class="form-control" name="unit_name" id="unit_name">
                                            </div>
                                            <label class="control-label col-sm-4">Semester</label>  
                                            <div class="col-sm-10">          
                                                <input type="text" class="form-control" name="semester" id="semester">
                                            </div>
                                            <label class="control-label col-sm-4">Campus</label>  
                                            <div class="col-sm-10">          
                                                <input type="text" class="form-control" name="campus" id="campus">
                                            </div>
                                        </div>
                                         <label class="control-label col-sm-4">Unit description</label>  
                                            <div class="col-sm-10">          
                                                <input type="text" class="form-control" name="unit_description" id="unit_description">
                                            </div>
                                        


                                        <div class="form-group">        
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button id="addbutton" class="btn btn-success" name="addbutton" type="submit" onclick="return addUnit();">Add</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>    

                </div>
            </div>
        </div>
        <!--  table 1 for page content-->



<!--editable_table, function link to jquery buildin at the down of the page-->
        <div class="container">   
            <table id="editable_table" class="table table-bordered table-striped">
                <tr>
                    <th style="display:none">ID</th>
                    <th>Unit Code</th>
                    <th>Unit Name</th>
                    <th>Semester</th>
                    <th>Campus</th>
                    <th>Unit description</th>
                    <th style="display:none">Course</th>
                </tr>

                <?php 
                while($row = mysqli_fetch_array($result))
                    //row is variabel ,use keyword mysqli_fetch_array to fetch the result
                {
                ?>
                <tr>
                    <td style="display:none"><?php echo $row['id']; ?></td>
                    <td><?php echo $row['unit_code']; ?></td>
                    <td><?php echo $row['unit_name']; ?></td>
                    <td><?php echo $row['semester']; ?></td>
                    <td><?php echo $row['campus']; ?></td>
                    <td><?php echo $row['unit_description']; ?></td>
                    <td style="display:none"><?php echo $row['course_id']; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <!--button to other page-->
        <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <p  ><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal3">Add new unit</button></p>
            </div>
        </div>
    </div>    

        <!--footer-->
        <div class="footer" id ="footer" >
            <p class="text-muted small mb-4 mb-lg-0">© University of DoWell 2020. All Rights Reserved.</p>
        </div>

        <!--script search function in the modal 1 -->
        <script type="text/javascript">
            function SubmitFormData() {
                //this is passing the vale of the search input text from the modal form search button clicked =submit
                var searchdetail = $("#searchdetail").val();
                //call a past method to search php page and send 'searchdetail' to there
                $.post("search.php", { searchdetail: searchdetail },
                       // call a function which has a parameter called 'data'
                       // this data is the output from the search php page 
                       function(data) {
                    // find the element call 'results' and put the table to the div call'results'
                    $('#results').html(data);
                });
            }

            //add the unit in the db, check vaildateion befor add and use post with alert to show successfull ,then hide the modal3
            function addUnit() {
                
                var unit_code = $("#unit_code").val();
                var unit_name = $("#unit_name").val();
                var semester = $("#semester").val();
                var campus= $("#campus").val();
                var unit_description= $("#unit_description").val();

                if(unit_code==""){
                    alert('Unit code are required!');
                }
                else if (unit_name==""){
                    alert('Unit name are required!');
                }
                else if (semester==""){
                    alert('Semester are required!');
                }
                else if (campus==""){
                    alert('campus are required!');
                }
                else if (unit_description==""){
                    alert('Unit description are required!');
                }
                else
                {
                    //unit_code(var from above):unit_code(the value take from the input box)
                    $.post("addunit.php", { unit_code:unit_code,unit_name:unit_name,semester:semester,campus:campus,unit_description:unit_description},
                           function(data) {
                                alert("You have added a unit successfully");
                                $("#modal3").modal("hide"); 
                                //reload the window
                                window.location="unitmaster.php";
                    });
                }
            }
            //jquery buildin function link to 'results.php & 'id' as a key to editable 
            $(document).ready(function(){  
                $('#editable_table').Tabledit({
                    url: 'result.php',
                    columns: {
                        identifier: [0, 'id'],                    
                        editable: [[1, 'unit_code_edit'],[2, 'unit_name_edit'], [3, 'semester_edit'], [4, 'campus_edit'], [5, 'unit_description_edit']]
                    },
                    restoreButton:false,//call back recevie data from server
                    onDraw: function() {
                        console.log('onDraw()');
                    },
                    onSuccess: function(data, textStatus, jqXHR) {
                        console.log('onSuccess(data, textStatus, jqXHR)');
                        console.log(data);
                        console.log(textStatus);
                        console.log(jqXHR);
                        window.location="unitmaster.php";
                    },
                    onFail: function(jqXHR, textStatus, errorThrown) {
                        console.log('onFail(jqXHR, textStatus, errorThrown)');
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                    },
                    onAlways: function() {
                        console.log('onAlways()');
                    },
                    onAjax: function(action, serialize) {
                        console.log('onAjax(action, serialize)');
                        console.log(action);
                        console.log(serialize);
                    }

                });

            });  



        </script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">  
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>            
        <script src="jquery.tabledit.min.js"></script>
    </body>
</html>