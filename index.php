<?php
  $server = 'localhost';
  $username = 'root';
  $password = '';
  $database = 'todo_list';
  $conn = mysqli_connect($server,$username,$password,$database);
  if($conn->connect_errno){
     die('Connection to MySql Failed : '.$conn->connect_error);
  }
  if(isset($_POST['add'])){
    $item = $_POST['item'];
    if(!empty($item)){
      $query = "INSERT INTO todo (name) VALUES ('$item')";
      if(mysqli_query($conn,$query)){
        echo '
        <center>
            <div class="alert alert-success" role="alert">   
                  Item added Successfully!            
            </div>
        </center>
        ';
      }else{
         echo mysqli_error($conn);
      }
    }
  }
  if(isset($_GET['action'])){
    $itemId = $_GET['item'];
    if($_GET['action'] == 'done'){
      $query = "UPDATE todo SET quantity = 1 WHERE id = '$itemId'";
      if(mysqli_query($conn,$query)){
        echo '
        <center>
             <div class="alert alert-info" role="alert">   
                  Item Marked as Done!            
            </div>
        </center>
        ';
      }else{
         echo mysqli_error($conn);
      }    
    }elseif($_GET['action']=='delete') {
        $query = "DELETE FROM todo WHERE id = '$itemId'";
        if(mysqli_query($conn,$query)){
          echo '
          <center>
              <div class="alert alert-danger" role="alert">   
                  Item Deleted Successfully!            
              </div> 
          </center>
          ';
        }else{ 
           echo mysqli_error($conn);
        }
    }          
  }
?>
<!DOCTYPE html>
<html>
  <head>
     <title> To do list </title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
<style>
   .done{
      text-decoration: line-through;
   }
   body { 
      background-image: linear-gradient(#3EADCF,#ABE9CD);;
      background-repeat: no-repeat;
      background-attachment: fixed;  
      background-size: 100% 100%;
   }
</style>
  </head>
  <body >
     <main>
         <div class="container pt-5">
             <div class="row">
                 <div class="col-sm-12 col-md-3"></div>
                 <div class="col-sm-12 col-md-6">
                     <div class="card" style="background-image: linear-gradient(#7EE8FA,#EEC0C6);">
                        <div class="card-header">
                             <p>To-do List</p>
                        </div>
                        <div class="card-body">
                            <form method = "post" action="<?= $_SERVER['PHP_SELF']?>">
                               <div class="mb-3">
                                   <input type="text" class="form-control" name="item" placeholder="Enter Item name">
                               </div>
                               <input type="submit" class="btn btn-dark" name="add" value="Add Item">
                            </form>
                            <div class="mt-5 mb-5">
                                 <?php
                                    $query = 'SELECT * FROM todo';
                                    $result = mysqli_query($conn,$query);
                                    if($result->num_rows > 0){
                                      $i=1;
                                      while ($row = $result->fetch_assoc())  {
                                        $done = $row['quantity'] == 1 ? "done" : "";
                                        echo '
                                        <div class="row mt-4">
                                           <div class="col-sm-12 col-md-1"><h5>'.$i.'</h5></div>
                                           <div class="col-sm-12 col-md-6"><h5 class="'.$done.'">'.$row['name'].'</h5></div>      
                                           <div class="col-sm-12 col-md-5">
                                              <a href="?action=done&item='.$row['id'].'" class="btn btn-outline-dark">Mark as done</a>
                                              <a href="?action=delete&item='.$row['id'].'" class="btn btn-outline-danger">Delete</a>
                                           </div>   
                                        </div>
                                        ';
                                        $i++;
                                      } 
                                    }else{
                                       echo '
                                        <center>
                                            <img src="folder.png" width="50px" alt="empty list"><br><span> Your List is Empty</span>
                                        </center>        
                                        '; 
                                    }
                                 ?>
                            </div>
                        </div>
                     </div>
                 </div>
             </div>
         </div>
     </main>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
<script>
   $(document).ready(function(){
     $(".alert").fadeTo(5000,500).slideUp(500,function(){
        $('.alert').slideUp(500);
     });
   })
</script>
  </body>
</html>