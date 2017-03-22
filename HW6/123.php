<!DOCTYPE html PUBLIC “@-//W3C//DTD XHTML 1.0 Strict//EN”
   “http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict-dtd”>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
	<title>HW 6</title>
	<script>
		function KeyCheck() {
			var x = document.forms["keywordsearch"]["Keyword"].value;
			if (x == null || x == "") {
				alert("Please Enter Keyword");
				return false;
			}
		}
	</script>
</head>
<body>
<!--
<h1 style="font-style:italic" align="center">FaceBook Search</h1>
<div align="center" style="margin:0px auto">
	<form id="keywordsearch" method="POST" action="Search.php" onSubmit="return KeyCheck()" >
		<label for="Keyword" style="margin-left:auto;">Keyword</label>
		<input type="text" name="Keyword" />
		<br/>
		<label for="type" style="margin-left:auto;">Type:</label>
		<select name="type">
			<option selected>Users</option>
			<option>Pages</option>
			<option>Events</option>
			<option>Groups</option>
			<option>Places</option>
		</select>
		<br/>
		<input type="submit" value="Search" />
	</form>
</div>
<div>
</div>
-->
<form action="action_page.php">
<fieldset>
<legend style="font-style:italic" align="center">Facebook Search:</legend>
<br>
<div style="margin:0px auto">
	<form id="keywordsearch" method="POST" action="Search.php" onSubmit="return KeyCheck()" >
		<label for="Keyword" style="margin:0px auto;">Keyword</label>
		<input type="text" name="Keyword" />
		<br/>
		<label for="type" style="margin:0px auto;">Type: &nbsp &nbsp &nbsp</label>
		<select name="type">
			<option selected>Users</option>
			<option>Pages</option>
			<option>Events</option>
			<option>Groups</option>
			<option>Places</option>
		</select>
		<br/>
		<br/>
		<br/>
		<input type="submit" value="Search" />
		<input type="reset" value="Clear" />
</form>

</body>
</html>