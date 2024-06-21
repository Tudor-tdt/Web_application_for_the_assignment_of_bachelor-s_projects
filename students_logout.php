<?php
session_start();
// distrugem toate sesiunile
if(session_destroy())
{
header("Location: index.php");
}
?>