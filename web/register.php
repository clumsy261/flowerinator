<form method="GET" action="">
    <input type="text" name="user" placeholder="Username">
    <input type="text" name="pass" placeholder="Password">
    <input type="hidden" name="page" value="<?php echo htmlspecialchars($_GET['page']);?>">
    <select name="welcome" type="text">
        <option value="login">login</option>
        <option value="signup">signup</option>
        </select>
    <button type="submit">Submit</button>
</form>
<?php 
function dump_user($res)
{
    $labels = ['Username:', 'Password:', 'Height (cm):', 'Set humidity:', 'Light hours:', 'Last update:','Water left:'];
    $values = [$res[0], $_GET['pass']." BUT we actually store \"".$res[1]."\" for safety", $res[2], $res[3], $res[4], $res[5],$res[6]];
    
    echo "<table>";
    foreach ($labels as $i => $label) {
        echo "<tr><td>{$label}</td><td>{$values[$i]}</td></tr>";
    }
    echo "</table>";
}
function signup($user, $pass, $link)
{
    $query = "SELECT * from users where user=\"".$user."\"";
        $res = mysqli_query($link, $query);
        if(mysqli_num_rows($res))
        return "Username is already taken <br>";
        else
        {
        $query = "INSERT INTO `users`(`user`, `pass`, `height`, `water`, `light`, `time`) VALUES ('".$user."','".$pass."','0','1','12','000000')";
        $res=mysqli_query($link,$query);
        if($res)
            return "Account created, now you can log in :D <br>";
        }
        return "err- something went wrong with signup <br>";
}

function login($user,$pass,$link)
{
    $query = "SELECT * from users where user=\"".$user."\" and pass=\"".$pass."\"";
    return mysqli_query($link, $query);
}
///php enters with the following parameters -- page=register, user/pass= values or unset
///hasshing looks like hash('sha256', 'The quick brown fox jumped over the lazy dog.')
if(isset($_GET['user']) && isset($_GET['pass']))
{
    $pass = hash('sha256', htmlspecialchars($_GET['pass']));
    $user = htmlspecialchars($_GET['user']);
    $link =mysqli_connect('localhost', 'root');
    if(!$link)
        die("Could not conect to the database... try again later". file_get_contents('footer.php'));
    mysqli_select_db($link, 'flowerzz');
    if($_GET['welcome']=="signup")
        die(signup($user,$pass,$link).file_get_contents("footer.html"));
    $res = login($user,$pass,$link);
    if(!$res)
        die("Something went horribly wrong. I am so sorry on my behalf and on yours... this will take me another five ego deaths to fix.".file_get_contents("footer.html"));
    if(!mysqli_num_rows($res))
        die("User not found, try again or create an account :D <br>". file_get_contents('footer.html'));
    $res = mysqli_fetch_row($res);
    dump_user($res);
}
?>