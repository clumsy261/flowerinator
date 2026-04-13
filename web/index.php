<?php ///the site works with a database ran on 'localhost' with the user 'root', the db is called flowerzz and the table users
	if(isset($_GET['api']))
{
	/// example localhost/?api=1d9bc30aeb90871be59fb1e9498b8a0a8455b0ac00c335b28a19950478e5b8e8&user=bon&change=height&val=12
	/// or localhost/?api=1d9bc30aeb90871be59fb1e9498b8a0a8455b0ac00c335b28a19950478e5b8e8&user=bon&change=retrieve
	$link =mysqli_connect('localhost', 'root');
	mysqli_select_db($link,"flowerzz");
    if(!$link)
        die("Could not conect to the database... try again later". file_get_contents('footer.html'));
	function login($user,$pass,$link)
	{
		$query = "SELECT * from users where user=\"".$user."\" and pass=\"".$pass."\"";
		$query = mysqli_query($link,$query);
		if(!mysqli_num_rows($query)) die("No user with these credentials found".file_get_contents('footer.html'));

		return $query;
	}  
	$api = $_GET['api']; $change = $_GET['change']; $user=$_GET['user'];
	$res=login($user,$api,$link);
	if($change =="retrieve")
		{
			$res= mysqli_fetch_row($res);
			die("\n WATER_SET=".$res[3]."\nLIGHT_SET=".$res[4]);
		}
	$val = $_GET['val'];
	if($change=="height") $change = "height";
    if($change=="wat") $change = "water2";
    $query = "UPDATE users SET ".$change." = \"".$val."\" WHERE user = \"".$user."\" and pass = \"".$api."\"";
    $query = mysqli_query($link, $query);
    if(!$query) die("Something went wrong, please try again".file_get_contents('footer.html')); else die("succes");

}

?>
<head> <p hidden> refrence header</p>
        <meta charset="UTF-8">
        <title>flowerinator</title>
        <meta name="description" content="Flowerinator portal for your personal garden project!">
        <meta name="keywords" content="flowerinator, hackclub project, clumsy261 flowerinator">
        <script type="application/ld+json">
        {
         "@context": "https://schema.org",
         "@type": "WebSite",
         "name": "Flowerinator",
         "url": "https://flowerinator.free.nf"
        }
        </script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="style.css?v=<?php echo filemtime('style.css'); ?>"> 
        <p hidden>Wanna contact me? @clumsy261 is always availabe... I don't sleep</p>
</head>
<?php

echo file_get_contents("header.html");

    if(isset($_GET['page']))///choose what page to show
            include ($_GET['page'].".php");
    else
        include('home.php');
echo file_get_contents("footer.html");
?>
