<?php
require ('yh.class.php');
$yh= new yh;
if (!empty($_POST['email'])){
    echo 'ID:';
    echo $yh->clientidbyemail($_POST['email']);
    echo '<br>';
}

if (!empty($_POST['id'])){
    echo $yh->userdata($_POST['id'],"Name");
    echo '<br>';
}
?>
Enter the client's email to get the id:<br>
<form method="post" action="client.php">
<input name="email" placeholder="E-Mail"/>
<input type="submit" value="Go!"/>
</form>
<br>
Enter the client's id to get the name:<br>
<form method="post" action="client.php">
<input name="id" placeholder="ID"/>
<input type="submit" value="Go!"/>
</form>
