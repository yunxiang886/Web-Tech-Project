<!DOCTYPE html PUBLIC “@-//W3C//DTD XHTML 1.0 Strict//EN”
   “http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict-dtd”>
<?php

require_once __DIR__ . '/php-graph-sdk-5.0.0/src/Facebook/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '1238802276227483',
  'app_secret' => '8e21ef2a4eb3009dc28140e05ac27cc3',
  'default_graph_version' => 'v2.5',
]);
?>
<html>
<head>
	<style>
		.album
			{
				display: none;
				width:600px;
				margin: 0 auto;
				border: 2px solid gray;
			}
		.message
			{
				display: none;
				width:600px;
				margin: 0 auto;
				border: 2px solid gray;
			}
		.top
			{
				width:600px;
				background-color: gray;
				margin: 0 auto;
				text-align: center;
			}
		.borderbottom{
				border-bottom: 1px solid white;
				padding: 10px;
			}
		.top a:visited,.album a:visited{
  				color:blue;
			}

	</style>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
	<title>HW 6</title>
	<script>

	window.onload =function(){
		if (document.getElementById('type').value=='user'||
			document.getElementById('type').value=='page'||
			document.getElementById('type').value=='group'||
			document.getElementById('type').value=='event'){
				document.getElementById("location").style.visibility="hidden";
			} 
	};

		function KeyCheck() {
			var x = document.forms["qsearch"]["q"].value;
			if (x == null || x == "") {
				alert("Please Enter Keyword");
				return false;
			}
		}
		function myFunction() {
			if (document.getElementById('type').value=='place'){
				document.getElementById("location").style.visibility="visible";
			}
			else {
				document.getElementById("location").style.visibility="hidden";
			}
			
		}

		function albumshow()
	{
		
		if(document.getElementById("album").style.display.match("none"))
		{document.getElementById("album").style.display = "block";
		document.getElementById("message").style.display="none";
		}
		else
		{document.getElementById("album").style.display = "none";
		}
	}

		function messageshow()
	{
		
		if(document.getElementById("message").style.display=="none")
		{document.getElementById("message").style.display = "block";
			document.getElementById("album").style.display="none";
		}
		else
		{	document.getElementById("message").style.display = "none";
		}
	}
		function photoshow(id)
	{
		
		if(document.getElementById(id).style.display=="none")
		{document.getElementById(id).style.display = "block";
		}
		else if (document.getElementById(id).style.display=="block")
		{document.getElementById(id).style.display = "none";
		}
		else {document.getElementById(id).style.display = "block";
		}
	}
	function resetform() {
    	document.getElementById("keyword").value = "";
    	document.getElementById("type").value = "user";
    	 document.getElementById("location1").value = "";
    	 document.getElementById("distance1").value = "";
    	document.getElementById("location").style.visibility="hidden";
    	window.location="http://cs-server.usc.edu:37124/index.php"
		}
	</script>
</head>
<body>

		<div class="header" align="center">
		<fieldset style="width:600px">
			<div class="title" style="font-style:italic">Facebook Search</div>
			<br>
			<hr>
			<form action='/index.php' method='get' align="left">
  				Keyword <input type='text' name='keyword' id='keyword' 
  				value="<?php if (isset($_GET['keyword'])){echo $_GET['keyword'];}?>" required pattern=".*\S+.*"">

  				<br><br> Type &nbsp;

  				<select name='type' id='type' onchange="myFunction()"
  				value="<?php if (isset($_GET['type'])){echo $_GET['type'];}?>">
  					<option selected value='user'  <?php if (isset($_GET['type'])) {if (strcmp($_GET['type'], 'user')==0){echo 'selected';}} ?>>Users</option>
  					<option value='page' <?php if (isset($_GET['type'])) {if (strcmp($_GET['type'], 'page')==0){echo 'selected';}} ?>>page</option>
  					<option value='event' <?php if (isset($_GET['type'])) {if (strcmp($_GET['type'], 'event')==0){echo 'selected';}} ?>>event</option>
  					<option value='group' <?php if (isset($_GET['type'])) {if (strcmp($_GET['type'], 'group')==0){echo 'selected';}} ?>>group</option>
  					<option value='place'<?php if (isset($_GET['type'])) {if (strcmp($_GET['type'], 'place')==0){echo 'selected';}} ?>>place</option>
				</select>

				<div id="location" <?php 
				if(isset($_GET['type'])&&$_GET['type']=='place'){
					echo "style.visibility='visiable'"; 
					}else{
						echo "style.visibility='hidden'";
						}?> >

		     Location <input type="text" name="location" id="location1" value="<?php if (isset($_GET['location'])){echo $_GET['location'];
					}?>" >
		     Distance(m)<input type="text" name="distance" id="distance1" value="<?php if (isset($_GET['distance'])){echo $_GET['distance'];
					}?>" >
				</div>
				<br><br>
  				<input type='submit' value='Search' class="button">
  				<input type='button' value='Clear' onclick='resetform()'>
			</form> 
		</div>
	




<?php

$fql_query_url_photo="";

if (isset($_GET["keyword"])&&!isset($_GET["id"])){
	$input=$_GET["keyword"];
	$_GET["keyword"]=urlencode($input);
	$add=$_GET["location"];

	if (isset($_GET['type'])&&$_GET['type']=='place'){
		$fql_google = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($add)."&key=AIzaSyCxEn_3ql-vBAejHO0Xq8MBpKbZYOXWxE4";
		$fql_google_result = file_get_contents($fql_google);
		$fql_gps = json_decode($fql_google_result, true);

    	$cord1=  $fql_gps['results'][0]['geometry']['location']['lat'];
    	$cord2=  $fql_gps['results'][0]['geometry']['location']['lng'];

		
		$fb->setDefaultAccessToken('EAARmryGfGZAsBACR5kreeNpU1CcFz7IBRG3MNXC9aZBrTwRPjML5YDPZB3AsSCdf6l7L6oMvKprsd1hmvrahGxKqKvPJuH1MPJ5pQwWSRlp1RiOJxbZC9yWOoZB7yjHF5p58bqc8mK29JZBZBo21ZBKQBcjjuAfSFrcZD');
		try {
 		 $fql_query_url_photo = $fb->get("/search?q=".$_GET["keyword"]."&type=".$_GET["type"]."&center=".$cord1.",".$cord2."&distance=".$_GET["distance"]."&fields=id,name,picture.width(700).height(700)");
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
 			 echo 'Graph returned an error: ' . $e->getMessage();
 			 exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
  		echo 'Facebook SDK returned an error: ' . $e->getMessage();
 		 exit;
			}
		$fql_query_obj_photo = $fql_query_url_photo->getDecodedBody();
		$data=$fql_query_obj_photo['data'];
       
	}else if (isset($_GET['type'])&&$_GET['type']=='event'){
	$fb->setDefaultAccessToken('EAARmryGfGZAsBACR5kreeNpU1CcFz7IBRG3MNXC9aZBrTwRPjML5YDPZB3AsSCdf6l7L6oMvKprsd1hmvrahGxKqKvPJuH1MPJ5pQwWSRlp1RiOJxbZC9yWOoZB7yjHF5p58bqc8mK29JZBZBo21ZBKQBcjjuAfSFrcZD');
		try {
 		 $fql_query_url_photo = $fb->get("/search?q=".$_GET["keyword"]."&type=".$_GET["type"]."&fields=id,name,picture.width(700).height(700),place");
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
 			 echo 'Graph returned an error: ' . $e->getMessage();
 			 exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
  		echo 'Facebook SDK returned an error: ' . $e->getMessage();
 		 exit;
			}
		$fql_query_obj_photo = $fql_query_url_photo->getDecodedBody();
		$data=$fql_query_obj_photo['data'];

	}else {
	$fb->setDefaultAccessToken('EAARmryGfGZAsBACR5kreeNpU1CcFz7IBRG3MNXC9aZBrTwRPjML5YDPZB3AsSCdf6l7L6oMvKprsd1hmvrahGxKqKvPJuH1MPJ5pQwWSRlp1RiOJxbZC9yWOoZB7yjHF5p58bqc8mK29JZBZBo21ZBKQBcjjuAfSFrcZD');
		try {
 		 $fql_query_url_photo = $fb->get("/search?q=".$_GET["keyword"]."&type=".$_GET["type"]."&fields=id,name,picture.width(700).height(700)");
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
 			 echo 'Graph returned an error: ' . $e->getMessage();
 			 exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
  		echo 'Facebook SDK returned an error: ' . $e->getMessage();
 		 exit;
			}
		$fql_query_obj_photo = $fql_query_url_photo->getDecodedBody();
		$data=$fql_query_obj_photo['data'];
	}
			
			if(isset($_GET['type'])&&$_GET['type']!='event'){

	echo '<table border="1" align="center">';
	echo '<tr><td>profile photo</td> <td>name</td> <td>details</td></tr>';
for ($i=0; $i< sizeof($data); $i++) {

    echo '<tr>';
    echo '<td><a href='. $fql_query_obj_photo['data'][$i]['picture']['data']['url'].' target=_blank ><img src="' . $fql_query_obj_photo['data'][$i]['picture']['data']['url'].'" height="30" width="40"></img></a></td>';
    echo '<td>' . $fql_query_obj_photo['data'][$i]['name'] .'</td>';

   echo '<td><a href= "index.php?id='.$fql_query_obj_photo['data'][$i]['id'].'&keyword='.$_GET["keyword"].'&type='.$_GET["type"].'&location='.$_GET["location"].'&distance='.$_GET["distance"].'">details</a></td>';
    echo '</tr>';
}

echo '</table>';

}else {
		echo '<table border="1" align="center">';
	echo '<tr><td>profile photo</td> <td>name</td> <td>Place</td></tr>';
for ($i=0; $i< sizeof($data); $i++) {

    echo '<tr>';
    echo '<td><a href='. $fql_query_obj_photo['data'][$i]['picture']['data']['url'].' target=_blank ><img src="' . $fql_query_obj_photo['data'][$i]['picture']['data']['url'].'" height="30" width="40"></img></a></td>';
    echo '<td>' . $fql_query_obj_photo['data'][$i]['name'] .'</td>';
   echo '<td>'. $fql_query_obj_photo['data'][$i]['place']['name'].'</td>';
    echo '</tr>';
}

echo '</table>';
}
}

else if(isset($_GET["id"])){
$feed="";
echo "</br>";

	$fb->setDefaultAccessToken('EAARmryGfGZAsBACR5kreeNpU1CcFz7IBRG3MNXC9aZBrTwRPjML5YDPZB3AsSCdf6l7L6oMvKprsd1hmvrahGxKqKvPJuH1MPJ5pQwWSRlp1RiOJxbZC9yWOoZB7yjHF5p58bqc8mK29JZBZBo21ZBKQBcjjuAfSFrcZD');

		try {
 		 $feed_result = $fb->get("/".$_GET["id"]."?fields=id,name,picture.width(700).height(700),albums.limit(5){name,photos.limit(2){nam,picture}},posts.limit(5)");
 		 
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
 			 echo 'Graph returned an error: ' . $e->getMessage();
 			 exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
  		echo 'Facebook SDK returned an error: ' . $e->getMessage();
 		 exit;
			}

$fql = $feed_result->getDecodedBody();

echo "<div class='top'>";
if (array_key_exists("albums", $fql)){
echo "<a onclick='albumshow()' href='#'>Albums</a>";
echo "</div>";
echo '<br>';
echo "<div class='album' id='album' style='display:none'>";
	
	$data=$fql['albums']['data'];
for ($i=0; $i< sizeof($data); $i++) {
	if (array_key_exists("photos", $data[$i])){
echo "<div class='borderbottom'>";
echo "<a onclick=\"photoshow('".str_replace(' ', '-', $data[$i]['name'])."')\" href='#'>".$data[$i]['name']."</a><br>";
echo "<div id='".str_replace(" ", "-", $data[$i]['name'])."' style='display:none;'>";
  
    for ($j=0; $j< sizeof($data[$i]['photos']['data']); $j++) {
    echo '<a href="https://graph.facebook.com/v2.8/'.$data[$i]['photos']['data'][$j]["id"].'/picture?access_token=EAARmryGfGZAsBACR5kreeNpU1CcFz7IBRG3MNXC9aZBrTwRPjML5YDPZB3AsSCdf6l7L6oMvKprsd1hmvrahGxKqKvPJuH1MPJ5pQwWSRlp1RiOJxbZC9yWOoZB7yjHF5p58bqc8mK29JZBZBo21ZBKQBcjjuAfSFrcZD" target=_blank><img src="' 
    .$data[$i]['photos']['data'][$j]['picture'].'" height="30" width="40"></img></a>'."&nbsp;"; 
	}


echo "</div>";
echo "</div>";

}
else {
	echo$data[$i]['name'];
}
}
}
else {
	echo "No Albums available";
}

echo "</div>";
echo "<br>";
echo "<div class='top'>";
if (array_key_exists("posts", $fql)){
   echo "<a onclick='messageshow()' href='#'>Posts</a>";
   echo "</div>";
   echo "<div class='borderbottom'>";
echo "<div class='message' id='message' style='display:none'>";
   $data2=$fql['posts']['data'];	
for ($i=0; $i< sizeof($data2); $i++) {
	if (array_key_exists("message", $data2[$i])){
   echo $data2[$i]['message'];
   echo '<br>';
   echo '<br>';
   }else {
   	
   }
}
echo "</div>";
echo "</div>";
}else{
		echo "No messages available";
}
}

  ?>
  </body>
  </html>