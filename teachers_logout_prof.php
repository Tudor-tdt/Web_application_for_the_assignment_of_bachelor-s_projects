<?php
session_start();
// Distrugem toate sesiunile
if(session_destroy())
{
header("Location: Teachers Login_prof.php");
}
?>