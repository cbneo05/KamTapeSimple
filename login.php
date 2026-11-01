<?php 
include("init.php"); 

$error = '';
if ($_POST) {
    $login = trim($_POST['login'] ?? '');
    $pass = trim($_POST['pass'] ?? '');

    $stmt = $db->prepare("SELECT id FROM users WHERE login = ? AND pass = ?");
    $stmt->execute([$login, $pass]);
    if ($stmt->fetch()) {
        $_SESSION['user'] = $login;
        $now = time();
        $upd = $db->prepare("UPDATE users SET last_login = ? WHERE login = ?");
        $upd->execute([$now, $login]);
        
        if (ob_get_level()) ob_end_clean();
        
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}

include("template.php");
showHeader("Sign In");
?>

<table width="790" align="center" cellpadding="0" cellspacing="0" border="0">
    <tbody><tr valign="top">
        <td style="padding-right: 15px;">
        
        <div id="siSignupDiv">
            <font size="3"><b>New to KamTape?</b></font>
            
            <p>KamTape is a way to get your videos to the people who matter to you. With KamTape you can:</p>

            <ul>
                <li>Upload, classify, and share your videos worldwide</li>
                <li>See original videos from community members</li>
                <li>Find new people and interesting channels</li>
                <li>Leave comments and discuss videos</li>
                <li>Embed videos on your websites and pages</li>
            </ul>
                
            <font size="3"><b><a href="register.php">Register now</a> and open a free account.</b></font>
                
            <p>To learn more about our service, visit <a href="about.php">About</a>.</p>
 </div>
        
        </td>
        <td width="300">

        <div class="contentBox" style="float: right; background-color: #EEE; border: 1px solid #CCC; padding: 15px;">
            <b><font size="4" style="margin-top: 0px;">Sign In</font></b>
            <br>
            <br>Sign in to access your account.
            <br>
            <br>
            
 <?php if ($error): ?>
            <div style="background-color: #FFE6E6; border: 1px solid #FF9999; padding: 10px; margin: 10px 0px; color: #CC0000; font-size: 12px;"><?=htmlspecialchars($error)?></div>
 <?php endif; ?>
            
            <table class="dataEntryTableSmall" cellpadding="5" cellspacing="0" border="0" style="width: 100%;">
                <form name="loginForm" id="loginForm" method="post">
                <input type="hidden" name="current_form" value="loginForm">
                    
                <tbody><tr>
                    <td class="formLabel" style="font-weight: bold; color: #333; font-size: 12px;">Username:</td>
                    <td class="formFieldSmall"><input tabindex="1" type="text" size="20" name="login" style="width: 200px; font-size: 12px;"></td>
                </tr>
                <tr>
                    <td class="formLabel" style="font-weight: bold; color: #333; font-size: 12px;">Password:</td>
                    <td class="formFieldSmall"><input tabindex="2" type="password" size="20" name="pass" style="width: 200px; font-size: 12px;"></td>
                </tr>
                <tr>
                    <td class="formLabel">&nbsp;</td>
                    <td class="formFieldSmall">
                        <input type="submit" name="action_login" value="Sign In">
                        <p class="smallText" style="font-size: 11px; margin-top: 10px;">
                            <b>Forgot:</b>&nbsp;<a href="forgot_username.php">Username</a> | <a href="forgot.php">Password</a>
                        </p>
                    </td>
                </tr>
 </form>
                </tbody>
</table>
        </div>
        
        </td>
    </tr>
</tbody></table>

<script type="text/javascript">
if (document.loginForm && document.loginForm.login) {
    document.loginForm.login.focus();
}
</script>

<?php showFooter(); ?>