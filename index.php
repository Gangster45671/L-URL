<?php
//CONNECT to database
	$db = new mysqli("localhost","id2079651_luigipizzolito", "sonicscrewdriver", "id2079651_links");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
} 


//RANDOM
function generateRandomString($length = 5) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength -1)];
	}
	return $randomString;
}

	//REDIRECT
	if (isset($_GET['title'])) {
		//GET from database
		$result = $db->prepare("SELECT * FROM links WHERE title=?");
		$result->bind_param("s", $_GET['title']);
		$result->execute();

		$goto = $result->get_result()->fetch_array();
		$g = $goto[1];
		//echo '<center><table width="410px" height="120px"><tr><th style="background-color: #F62823"><p2>Thanks for using</p2><br /><p2 style="color: #2FC900;">L</p2><p2 style="color: #FFFFFF">URL</p2></th></tr></table></center>'; //thankyou!!
                if ($g == '') {
		    echo '<script>alert("Error: URL Not Found.");</script>';
                } else {
                    header("Location: $g");
                }
	}

	if (isset($_POST['shorten'])) {
		//GENERATE title
		$title = generateRandomString();

		//HTTP check
		if (substr($_POST['url_to_shorten'], 0, 4) != "http") {
			//add http://
			$url = "http://".$_POST['url_to_shorten'];
		} else {
			$url = $_POST['url_to_shorten'];
		}

		//INSERT to database
		$result = $db->prepare("INSERT INTO links (id, url, title) VALUES ('', ?, ?)");
		$result->bind_param("ss", $url, $title);
		$result->execute();

		echo '<center><table width="410px"><tr ><th style="background-color: #249AFF"><p3>Your link has been shortened! It is </p3></th><th style="background-color: #047ADF"><p3>http://lurl.site90.com/'.$title.'</p3></th></tr></table></center>';
	}
	$db->close();
?><!DOCTYPE html><meta charset=utf-8><meta content="A Simple but Effective URL Shortner"name=L-URL><meta name="google-site-verification" content="d1w-r7on1Pc2_QW3dtftij6ss3-Bo0N-cW2rYNbMpwU" /><title>L-URL</title><style>table,td,th{border:1px solid #000;background-color:#999}p3{font:12px sans-serif;color:#fff}p2{font:40px sans-serif}p{font:italic 12px sans-serif;color:#fff}a{font:12px sans-serif;color:#fff}</style><center><table width=410px><tr onclick='window.location.href="/"'><th colspan=2 style=background-color:#2f7f00 onclick='window.location.href="/"'><p2 style=color:#2fc900>L</p2><p2 style=color:#fff>URL</p2><tr><th colspan=2 style=background-color:#03bf00;height:20px><p>Shorten your links.</tr><form action=index.php method=POST><tr><th><input name=url_to_shorten placeholder="Link to Shorten"size=50><th><input name=shorten type=submit value="Shorten Link"></form><tr><th colspan=2 style=background-color:#777><a href="mailto:luigi.pizzolito@hotmail.com?Subject=L-URL%20is%20Cool!!">Created with ♥ by Luigi Pizzolito</a></table></center>