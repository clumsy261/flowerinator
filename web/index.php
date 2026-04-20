<link rel="stylesheet" href="style.css">

<?php ///the site works with a database ran on 'HOST_DB' with the user 'HOST_user', the db is called flowerzz and the table users
include ('env.php');
/* env.php contents
	const host ="<censored>";
    const host_user ="<censored>";
    const host_db = "flowerzz"; //or the db name
    const host_table ="users";
    const host_pass = "<censored>";
*/
    if(isset($_GET['api']))
{

    //latest example of device update
    //flowerinator.free.nf/?api=1d9bc30aeb90871be59fb1e9498b8a0a8455b0ac00c335b28a19950478e5b8e8&user=bon&wat=1&height=13
	$link =mysqli_connect(host, host_user, host_pass);
	mysqli_select_db($link,host_db);
    if(!$link)
        die("Could not conect to the database... try again later". file_get_contents('footer.html'));
	function login($user,$pass,$link)
	{
		$query = "SELECT * from ".host_table." where user=\"".$user."\" and pass=\"".$pass."\"";
		$query = mysqli_query($link,$query);
		if(!mysqli_num_rows($query)) die("No user with these credentials found".file_get_contents('footer.html'));

		return $query;
	}  
	$api = $_GET['api']; $change = $_GET['change']; $user=$_GET['user'];
	$res=login($user,$api,$link);
	$tank = $_GET['wat'];
    $height = $_GET['height'];
    $query = "UPDATE ".host_table." SET "."water2"." = \"".$wat."\" WHERE user = \"".$user."\" and pass = \"".$api."\"";
    $query = mysqli_query($link, $query);
    $query = "UPDATE ".host_table." SET "."height"." = \"".$height."\" WHERE user = \"".$user."\" and pass = \"".$api."\"";
    $query = mysqli_query($link, $query);
    $res= mysqli_fetch_row($res);
	die($res[3]."\n".$res[4]);
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
