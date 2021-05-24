<?php
function getNameClass($clase)
{
    $path = explode('\\', $clase);    
	return array_pop($path);
}  
