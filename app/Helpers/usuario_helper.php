<?php
function encriptarPassword($password)
{
    return md5(md5(md5("*}".$password."!@")));
}  
