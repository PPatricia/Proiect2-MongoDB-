<?php
require_once "Connection.php";
$bulk = new MongoDB\Driver\BulkWrite;
if(isset($_POST['upload'])){
    $target="./images/".md5(uniqid(time())).basename($_FILES['image']['name']);
     $data=array(
        '_id' => new MongoDB\BSON\ObjectID,
        'title'=>$_POST['text'],
        'image'=>$target
    );
    $bulk->insert($data);
    }
  $client->executeBulkWrite('images.images',$bulk);

    mysqli_query($con,$sql);
    if(move_uploaded_file($_FILES['image']['tmp_name'],$target)){
        header('location:welcome.php');
        
    }else{
        $msg="vai!";
    }
?>

