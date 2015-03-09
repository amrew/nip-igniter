<?php
function getLabel($string){
	$array = explode("_", $string);
	$arrayUpperCase = array_map("ucwords", $array);
	$string = implode(" ", $arrayUpperCase);
	$string = str_replace(" Id", "", $string);
	return $string;
}

function getClassName($string){
	$array = explode("_", $string);
	$arrayUpperCase = array_map("ucwords", $array);
	$string = implode("", $arrayUpperCase);
	return $string;
}

function getStrippedClass($camelCaseClass){
	preg_match_all('/((?:^|[A-Z])[a-z]+)/',$camelCaseClass ,$matches);
	$strippedClass = changeClassName($matches[0]);
	return $strippedClass;
}

function getUnderscoredClass($camelCaseClass){
	preg_match_all('/((?:^|[A-Z])[a-z]+)/',$camelCaseClass ,$matches);
	$strippedClass = changeClassName($matches[0], "_");
	return $strippedClass;
}

function changeClassName($arrClassName = null, $str = "-"){
	if($arrClassName){
		$newClass = "";
		foreach ($arrClassName as $i => $value) {
			if($i==0){
				$newClass .= strtolower($value);
			}else{
				if(strtolower($value) == "controller")
					break;
				$newClass .= $str.strtolower($value);
			}
		}
		return $newClass;
	}
}

function createFile($folder, $filename, $content){
	$filepath = $folder.$filename;
	if(is_writable($folder)){
		if(!$file = fopen($filepath,'w')){
			return array('status' => 0, 'message'=> 'Failed to create the file '.$filepath);
		}

		if(!fwrite($file, $content)){
			return array('status' => 0, 'message'=> 'Failed to write content on the file '.$filepath);
		}

		fclose($file);
		return TRUE;
	}
	return array('status' => 0, 'message'=> $folder.' is not writable.');
}

function debug($var){
	echo "<pre>";
		print_r($var);
	echo "</pre>";
}

function getRandomString($length = 8) {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    
    return implode($pass); //turn the array into a string
}

if(false === function_exists('lcfirst'))
{
    function lcfirst( $str ) {
        $str[0] = strtolower($str[0]);
        return (string)$str;
    }
}

function deleteFolder($path)
{
    if (is_dir($path) === true)
    {
        $files = array_diff(scandir($path), array('.', '..'));

        foreach ($files as $file)
        {
            deleteFolder(realpath($path) . '/' . $file);
        }

        return rmdir($path);
    }

    else if (is_file($path) === true)
    {
        return unlink($path);
    }

    return false;
}

function user(){
	$ci = &get_instance();
	$ci->load->model("Auth");

	return $ci->Auth->user();
}


function viewExists($path = NULL){
	$status   = FALSE;
	$viewPath = APPPATH."views/";

	if($path){
		$status = file_exists($viewPath.$path.'.php');
	}
	return $status;
}

function getMimeType($filename)
{
    $mimetype = false;
    if(function_exists('finfo_fopen')) {
        // open with FileInfo
    } elseif(function_exists('getimagesize')) {
        // open with GD
    } elseif(function_exists('exif_imagetype')) {
       // open with EXIF
    } elseif(function_exists('mime_content_type')) {
       $mimetype = mime_content_type($filename);
    }
    return $mimetype;
}

function isMenuActive($controller = '', $param = ''){
	$ci = &get_instance();
	$queryString = ($_SERVER['QUERY_STRING'] != "") 
					? "?".$_SERVER['QUERY_STRING'] : "";
	$isParamTrue = TRUE;
	if(!empty($param)){
		$isParamTrue = strpos($queryString, $param) !== false;
	}

	$isControllerTrue = FALSE;
	if(!empty($controller)){
		$isControllerTrue = $ci->router->fetch_class() == $controller;
	}

	if($isControllerTrue && $isParamTrue){
		echo "active";
	}
}
