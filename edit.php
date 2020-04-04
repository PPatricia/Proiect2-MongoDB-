<!DOCTYPE HTML>
<html>

<head>
  <title>EDIT</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
  <link rel="stylesheet" type="text/css" href="style/style.css" />
</head>

<body>
  <div id="main">
    <div id="header">
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1><a href="index.php">GIVING<span class="logo_colour">_AFRICA</span></a></h1>
          <h2>Please Help African Children Give Them A Better Life.</h2>
        </div>
      </div>
      <div id="menubar">
        <ul id="menu">
          <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
          <li><a href="index.php">Home</a></li>
          <li><a href="examples.php">Examples</a></li>
          <li><a href="page.php">Video</a></li>
          <li><a href="another_page.php">Sign In</a></li>
        </ul>
      </div>
    </div>
    <div id="site_content">
      <div class="sidebar">
        <h1>Latest News</h1>
        <h4>New Website Launched</h4>
        <h5>January 1st, 2010</h5>
        <p>2010 sees the redesign of our website. Take a look around and let us know what you think.<br /><a href="#">Read more</a></p>
        <h1>Useful Links</h1>
        <ul>
          <li><a href="#">link 1</a></li>
          <li><a href="#">link 2</a></li>
          <li><a href="#">link 3</a></li>
          <li><a href="#">link 4</a></li>
        </ul>
        <h1>Search</h1>
        <form method="post" action="#" id="search_form">
          <p>
            <input class="search" type="text" name="search_field" value="Enter keywords....." />
            <input name="search" type="image" style="border: 0; margin: 0 0 -9px 5px;" src="style/search.png" alt="Search" title="Search" />
          </p>
        </form>
      </div>
      <div id="content">
         
        <?php
       //include connection file
        require_once 'Connection.php';
        $bulk = new MongoDB\Driver\BulkWrite;
        
        if(!isset($_POST["submit"])){
            $id = new \MongoDB\BSON\ObjectId($_GET['id']);
            $filter = ['_id' => $id];
            $query = new MongoDB\Driver\Query($filter);          
            $article = $client->executeQuery("images.images", $query);
            $doc = current($article->toArray());
            }else{
                if($_FILES["image"]['name']>0){
             $target="./images/".md5(uniqid(time())).basename($_FILES['image']['name']);
                }else{
                    $ids = new \MongoDB\BSON\ObjectId($_POST['id']);
$filters = ['_id' => $ids];
$querys = new MongoDB\Driver\Query($filters);          
$articles = $client->executeQuery('images.images', $querys);
$docs = current($articles->toArray());
           $target=$docs->image;
           echo $target;
           }  
                
 $data=[
        'title'=>$_POST['title'],
        'image'=>$target
    ];
 $id = new \MongoDB\BSON\ObjectId($_POST['id']);
$filter = ['_id' => $id];
$update=['$set'=>$data];
 $bulk->update($filter, $update);
 $client->executeBulkWrite('images.images',$bulk);           
            
   move_uploaded_file($_FILES['image']['tmp_name'],$target);
          header('Location:welcome.php');
            
        }   
 ?>
          
<h1>Edit:</h1>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
    Title:<br/><input type="text" name="title" value="<?php echo $doc->title ;?>"/><br/>
    Image: <br/><input type="file" name="image" value="<?php echo $doc->image ;?>"><br/>
    <img src="<?php echo $doc->image ;?>"><br/>
    <input type="hidden" name="id" value="<?php echo $doc->_id; ?>"/>
    <input type="submit" name="submit" value="Edit"/>
</form>
          </div>
      </div>
    </div>
    
</body>
</html>
  