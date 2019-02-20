
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "PHPMailer/src/Exception.php";
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";

$pmail = new PHPMailer;
$to;
$from;
$fromName;
$replyTo;
$subject;
$message;
$mail = new PHPMailer;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty($_FILES['attachment']['name'])){
        $target_dir = "mail_attachments/";
        $target_file = $target_dir.basename($_FILES["attachment"]["name"]);
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if(move_uploaded_file($_FILES['attachment']['tmp_name'], $target_file)){
            if(isset($_POST['to'])){
                $to=$_POST['to'];
                $from=$_POST['from'];
                $fromName=$_POST['fromname'];
                $replyTo=$_POST['replyto'];
                $subject=$_POST['subject'];
                $message=$_POST['message'];
                $mail->From=$from;
                $mail->FromName=$fromName;
                $mail->addAddress($to);
                $mail->addReplyTo=($replyTo);
                $mail->addAttachment($target_file);
                $mail->isHTML(true);
                $mail->Subject=$subject;
                $mail->Body=$message;
                if($mail->send()){
                    echo "<script>var sent = true;</script>";
                }else{
                    echo "couldn't send mail, please cross check the your input parameters";
                }
            }
        }
       
    }else{
        if(isset($_POST['to'])){
            $to=$_POST['to'];
            $from=$_POST['from'];
            $fromName=$_POST['fromname'];
            $replyTo=$_POST['replyto'];
            $subject=$_POST['subject'];
            $message=$_POST['message'];
            $mail->From=$from;
            $mail->FromName=$fromName;
            $mail->addAddress($to);
            $mail->addReplyTo=($replyTo);
            $mail->isHTML(true);
            $mail->Subject=$subject;
            $mail->Body=$message;
            if($mail->send()){
                echo "<script>var sent = true;</script>";
            }else{
                echo "couldn't send mail, please cross check the your input parameters";
            }
        }
    }
}
	
	
?>
<html>
<head>
<script src="//cdn.ckeditor.com/4.10.1/full/ckeditor.js"></script>
<title> Send Mail </title>
<style type="text/css">
    body{
        background:#FAFBFC;
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
        margin-left:0px;
        margin-right:0px;
        margin-top:0px;
        overflow:overflow-y;
    }
    .container{
        margin-left:30px;
        margin-right:50px;
        margin-top:10px;
        margin-bottom:0px;
    }
    label{
        display:block;
        text-align:left;
        font-weight:inherit;
        margin-bottom:5px;
        font-size:14px;
        box-sizing:border-box;
        color:#586069;
    }
    .input{
        width:50%;
        display:block;
        min-height:46px;
        padding:10px;
        border-radius:5px;
        margin-right:5px;
        line-height:20px;
        vertical-align:middle;
        border:1px solid #D1D5DA;
        box-shadow:0px 1px 2px rgba(27, 31, 35, 0.075) inset;
        
    }
    .input:focus{
        border:1px solid #0000FF;
    }
    .submit{
        background:#2EBC4F;
        padding:20px 32px;
        display:inline-block;
        border:none;
        border-radius:3px;
        transition: all 0.2s ease 0s;
        font-size:20px;
        text-align:center;
        width:25%;
        cursor:pointer;
        box-sizing:border-box;
        overflow:visible;
        color:#fff;
    }
    .attachment{
        background: #2E4FBC;
        padding: 10px 10px;
        display: block;
        border: 1px solid #FFF;
        border-radius: 3px;
        font-size: 15px;
        color: #FFF;
        box-sizing: border-box;
    }
    .submit:hover{
        background:#0C902A;
        transition: all 0.2s ease 0s;
    }
    .heading{
        text-align:left;
    }
    #modalbg{
        position:fixed;
        top:0;
        z-index:100;
        width:100%;
        height:100%;
        background:rgba(150, 150, 150, 0.2);
        display:none;
        cursor:not-allowed;
        text-align:middle;
        
    }
    
    #modal{
        position:fixed;
        width:50%;
        top:30%;
        right:25%;
        height:40%;
        z-index:200;
        background:#FFF;
        border-radius:8px;
        display:none;
        color:#7FFF00;
        cursor:default;
        text-align:center;
        
    }
    #modal h5{
        font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
        margin-top:80px;
        color: lime;
        text-shadow: 1px 1px 2px black, 0 0 25px green, 0 0 5px darkgreen;
    }
    #closemodal{
        border-radius:20px;
        color:white;
        background:#2EBC4F;
        padding:10px;
        border:none;
        width:15%;
        text-align:center;
        font-size:16px;
        font-weight:600;
        transition: all 0.2s ease 0s;
    }
    #closemodal:hover{
        background:#0C902A;
        transition: all 0.2s ease 0s;
    }
    .hide{
        display: none;
    }
    .show{
        display: block;
    }
</style>
</head>
<body>
<div id="modalbg"></div>
<div class="container">
<div class="heading"><h1>Send Mail Panel Version 2.0</h1></div>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
<label class="form-label f5" for="user[login]">Send to</label>
<input type="email" name="to" placeholder="example@gmail.com" class="input"/><br>
<label class="form-label f5" for="user[login]">From (Clone)</label>
<table style="width:50%">
    <tr>
        <td style="width:50%">
            <input type="email" name="from" placeholder="Enter the email address you want to clone" class="input" style="width:100% !important;"/>
        </td>
        <td style="width:50%">
            <input type="text" name="fromname" placeholder="Name eg. Horward Charles" class="input" style="width:100% !important;"/>
        </td>
    </tr>
</table>
<br>
<label class="form-label f5" for="user[login]">Reply to</label>
<input type="email" name="replyto" placeholder="Email to reply to" class="input"/><br>
<label class="form-label f5" for="user[login]">Subject</label>
<input type="text" name="subject" placeholder="Subject of the mail" class="input"/><br>
<label class="form-label f5" for="user[login]">Message body</label>
<textarea name="message" id="editor1" rows="10" cols="80" placeholder=" Type in your message here ..."></textarea><br>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'editor1' );
            </script>
<input type="file" name="attachment" class="hide" id="attachment"/>
<button class="attachment" id="add-attachment">Add an Attachment</button> 
<br>      
<input type="submit" value="Send Mail" class="submit"/>
</form>

</div>

<div id="modal">
    <h5>
        Mail successfully sent to <?php echo $to;?>
    </h5>
    <button id="closemodal" onClick="closeModal();">Ok</button>
</div>

<script>
document.getElementById("add-attachment").addEventListener('click', function(event){
    event.preventDefault();
    document.getElementById("attachment").style.display = "block";
    this.style.display = "none";
})
if(sent == true){
    showModal();
}
function showModal(){
    document.body.style.overflow="hidden";
    document.getElementById("modalbg").style.display="block";
    document.getElementById("modal").style.display="block";
}
function closeModal(){
    document.body.style.overflow="visible";
    document.getElementById("modalbg").style.display="none";
    document.getElementById("modal").style.display="none";
}
    
</script>

</body>
</html>