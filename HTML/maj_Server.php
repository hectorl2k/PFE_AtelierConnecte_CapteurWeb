<?php

if(isset($_GET['token_maj']))
{
    if($_GET['token_maj'] =="mdpmaj")
    {
        $output = shell_exec('touch coucou.sh');
    }



}


