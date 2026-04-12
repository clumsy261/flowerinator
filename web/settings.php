<form method="GET" action="">
    <fieldset>
        <label>What do you wish to update?</label>
        <select name="change" type="text">
            <option value="usr">username</option>
            <option value="psd">password</option>
            <option value="sol">soil humidity</option>
            <option value="led">light hours</option>
        </select>
        <label>Submit new value:</label>
        <input type="text" name="val">
    </fieldset>
    <fieldset>
        <p>confirm username and passowrd</p>
        <input type="text" name="user">
        <input type="text" name="pass">
    </fieldset>
    <input type="hidden" name="page" value="<?php echo htmlspecialchars($_GET['page']);?>">
    <button type="submit">Submit</button>
</form>

<?php
function login($user,$pass,$link)
{
    $query = "SELECT * from users where user=\"".$user."\" and pass=\"".$pass."\"";
    return mysqli_query($link, $query);
}
function check_login($res)
{
    if(!mysqli_num_rows($res)) die("No user with these credentials found".file_get_contents('footer.html'));
}
function check_usr($link,$val)
{
    $query = "SELECT * from users where user=\"".$val."\"";
    $query = mysqli_query($link,$query);
    if(mysqli_num_rows($query)) die("Username is already taken, try something else".file_get_contents('footer.html'));
    return 1;
}
function check_sol($val)
{
    if(!is_numeric($val) || (intval($val) != $val)) 
        die("Please insert a valid integer for this parameter".file_get_contents('footer.html'));
}
function change($link, $user, $pass, $val, $change)
{
    if($change=="sol") $change = "water";
    if($change=="usr") $change = "user";
    if($change=="psd") {$change = "pass"; $val = hash('sha256',$val);}
    if($change=="led") $change = "light";
    $query = "UPDATE users SET ".$change." = \"".$val."\" WHERE user = \"".$user."\" and pass = \"".$pass."\"";
    $query = mysqli_query($link, $query);
    if(!$query) die("Something went wrong, please try again".file_get_contents('footer.html'));
}

if(isset($_GET['user']) && isset($_GET['change']))
{
    $user=htmlspecialchars($_GET['user']);
    $pass=hash('sha256',htmlspecialchars($_GET['pass']));
    $link =mysqli_connect('localhost', 'root');
    if(!$link)
        die("Could not conect to the database... try again later". file_get_contents('footer.html'));
    mysqli_select_db($link, 'flowerzz');
    $res = login($user,$pass,$link);
    check_login($res);
    if(!$res)
        die("Something went horribly wrong. I am so sorry on my behalf and on yours... this will take me another five ego deaths to fix.".file_get_contents("footer.html"));
    $change= $_GET['change'];
    if($change=='usr')
        check_usr($link,$_GET['val']);
    if($change=='sol' || $change=='led')
        check_sol($_GET['val']);
    change($link, $user, $pass, $_GET['val'], $change);
    echo "Procedure succesful";
}
?>