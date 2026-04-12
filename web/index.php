
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
