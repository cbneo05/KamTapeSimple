<?php
include_once "init.php";
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
include_once "config.php";
include_once __DIR__ . "/lib/mailer.php";
include_once "template.php";

showHeader("Invite Friends");

$sent = false;
$sent_count = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emails = array();
    if (!empty($_POST['email_family'])) {
        foreach ($_POST['email_family'] as $idx => $email) {
            $email = trim($email);
            if ($email != '') {
                $name = isset($_POST['fname_family'][$idx]) ? trim($_POST['fname_family'][$idx]) : '';
                $emails[] = array('email' => $email, 'name' => $name);
            }
        }
    }
    if (!empty($_POST['email_friends'])) {
        foreach ($_POST['email_friends'] as $idx => $email) {
            $email = trim($email);
            if ($email != '') {
                $name = isset($_POST['fname_friends'][$idx]) ? trim($_POST['fname_friends'][$idx]) : '';
                $emails[] = array('email' => $email, 'name' => $name);
            }
        }
    }
    
    $user = isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']) : "your_name";
    $personal = isset($_POST['personal_message']) ? trim($_POST['personal_message']) : '';

    $subject = "KamTape";
    $htmlTemplate = '
<img src="http://kamtape.lunmo.ws/img/logo_sm.png" vspace="12" alt="KamTape"><br>
KamTape is a great site for sharing and storing personal videos. I use
<br>KamTape to share videos with friends and family. I would like 
<br>to add you to the list of people I can share my 
<br>videos with.
<br><a href="http://kamtape.lunmo.ws/">{link_text}</a>
<p><i>KamTape - Broadcast Yourself.</i><br><br>
<center>
<div style="padding: 2px; padding-left: 7px; padding-top: 0px; margin-top: 10px; background-color: #E5ECF9; border-top: 1px dashed #3366CC; font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold;">
&nbsp;</div><br>
Copyright © 2026 KamTape, LLC
';

    foreach ($emails as $e) {
        $to_email = $e['email'];
        $to_name  = $e['name'] !== '' ? $e['name'] : $to_email;

        $link_text = $personal !== '' ? $personal : 'Go to KamTape';
        $safe_link_text = htmlspecialchars($link_text, ENT_QUOTES, 'UTF-8');
        $body = str_replace('{link_text}', $safe_link_text, $htmlTemplate);

        if (send_smtp_email_advanced($to_email, $to_name, $subject, $body, true)) {
            $sent_count++;
        }
    }
    $sent = true;
}
?>
<style type="text/css">
.invite-title { color: #cc6633; font-weight: bold; font-size: 15px; margin-bottom: 6px; }
.invite-section { margin-bottom: 18px; }
.invite-label { font-size: 13px; color: #333; width: 110px; display: inline-block; }
.invite-input { width: 220px; font-size: 13px; }
.invite-name { width: 180px; font-size: 13px; }
.invite-message-box { background: #BBCCEE; border: 1px dashed #000066; padding: 10px; margin-top: 10px; }
.invite-message-label { font-size: 13px; color: #333; }
.invite-textarea { width: 330px; height: 70px; font-size: 13px; }
.invite-btn { font-size: 13px; }
</style>

<table width="790" align="center" cellpadding="0" cellspacing="0" border="0" style="font-family:Tahoma,Arial,sans-serif; font-size:13px;">
<tr><td>
<div class="invite-title">Invite Friends</div>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:10px;"><tr><td height="1" bgcolor="#CCCCCC"></td></tr></table>
<?php if ($sent): ?>
  <div class="confirmBox">Invitations sent! (<?= $sent_count ?>)</div>
<?php endif; ?>
<div style="font-size:12px; color:#444; margin-bottom:8px;">KamTape is more fun with friends!<br>
Want to share family or holiday videos? Invite relatives to join!</div>

<form method="post" action="my_friends_invite.php">
<div class="invite-section">
<?php for ($i=0; $i<4; $i++): ?>
  <table cellpadding="0" cellspacing="0" border="0" style="margin-bottom:4px;"><tr>
    <td style="padding-right:8px;"><b>E-mail:</b></td>
    <td><input type="text" name="email_family[]" class="invite-input"></td>
    <td style="padding-right:8px; padding-left:8px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Name:</b></td>
    <td><input type="text" name="fname_family[]" class="invite-name"></td>
  </tr></table>
<?php endfor; ?>
</div>

Want to share funny videos with colleagues and friends? Invite them to join!<br><br>
<div class="invite-section">
<?php for ($i=0; $i<4; $i++): ?>
  <table cellpadding="0" cellspacing="0" border="0" style="margin-bottom:4px;"><tr>
    <td style="padding-right:8px;"><b>E-mail:</b></td>
    <td><input type="text" name="email_friends[]" class="invite-input"></td>
    <td style="padding-right:8px; padding-left:8px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Name:</b></td>
    <td><input type="text" name="fname_friends[]" class="invite-name"></td>
  </tr></table>
<?php endfor; ?>
</div>

<table cellpadding="0" cellspacing="0" border="0" style="margin-bottom:12px;"><tr>
  <td style="vertical-align:top; font-weight:bold; font-size:13px;">Message:</td>
  <td style="vertical-align:top; padding-left:8px;">
    <div class="invite-message-box" style="width:500px; margin-top:0; padding-top:0;">
      <br>
      Hello,<br>
      <br>
      KamTape is a great site for sharing and storing personal videos. I use KamTape to share videos with friends and family. I would like to add you to the list of people I can share my videos with.<br>
      <br>
      Your personal message:<br>
      <textarea name="personal_message" class="invite-textarea">Have you heard about KamTape? I really like this site.</textarea><br>
      <br>
      Thanks,<br>
      <?php echo isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']) : "your_name"; ?>
    </div>
  </td>
</tr></table>

<div style="margin-top:10px; margin-left:83px;">
  <input type="submit" value="Send Invitations" class="invite-btn">
</div>
</form>
</td></tr>
</table><?php showFooter(); ?>