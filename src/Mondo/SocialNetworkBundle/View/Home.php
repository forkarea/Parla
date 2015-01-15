<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/
use Mondo\UtilBundle\Core\Session;
use Mondo\SocialNetworkBundle\Controller\MyCookie;

new Session();
//MyCookie::read();
//if(Session::getSessionData('key') != "") header('Location: view2.php');
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="../src/Mondo/SocialNetworkBundle/CSS/main.css">
</head>
<body>


<div style="float:left" class="frame">
    <form action="go.php" method="post">
        <div style="float:left" class="frame">
        Name: <input name="name"/>
        </div>
        <div style="float:left">
            Or
        </div>
        <div style="float:left" class="frame">
            Key: <input name="key"/>
            <br/>
            Password: <input type="password" name="password"/>
            <br/>
            <span class="error"><?= Session::getSessionData('errors') ?></span>
        </div>
        <div style="clear:both; text-align:center">
            <input type="checkbox" name="remember" value="yes" />Remember me
            <br/>
            <button>OK</button>
        </div>
    </form>
</div>


</body>
</html>

