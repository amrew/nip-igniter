<?php
/**
 * Mengambil label dari sebuah field table.
 * Contoh:
 * - status_id      => Status
 * - name         => Name
 */
function getLabel($string)
{
    $array = explode("_", $string);
    $arrayUpperCase = array_map("ucwords", $array);
    $string = implode(" ", $arrayUpperCase);
    $string = str_replace(" Id", "", $string);
    return $string;
}

/**
 * Mengambil nama kelas dari sebuah table.
 * Contoh:
 * - user              => User
 * - article_tag     => ArticleTag
 */
function getClassName($string)
{
    $array = explode("_", $string);
    $arrayUpperCase = array_map("ucwords", $array);
    $string = implode("", $arrayUpperCase);
    return $string;
}

/**
 * Mengambil nama dengan separator strip (-) dari suatu kelas.
 * Contoh:
 * - UserStatus      => user-status
 * - ArticleTag         => article-tag
 */
function getStrippedClass($camelCaseClass)
{
    preg_match_all('/((?:^|[A-Z])[a-z]+)/', $camelCaseClass, $matches);
    $strippedClass = changeClassName($matches[0]);
    return $strippedClass;
}

/**
 * Mengambil nama dengan separator underscore (_) dari suatu kelas.
 * Contoh:
 * - UserStatus      => user_status
 * - ArticleTag         => article_tag
 */
function getUnderscoredClass($camelCaseClass)
{
    preg_match_all('/((?:^|[A-Z])[a-z]+)/', $camelCaseClass, $matches);
    $strippedClass = changeClassName($matches[0], "_");
    return $strippedClass;
}

function changeClassName($arrClassName = null, $str = "-")
{
    if ($arrClassName) {
        $newClass = "";
        foreach ($arrClassName as $i => $value) {
            if ($i == 0) {
                $newClass .= strtolower($value);
            } else {
                if (strtolower($value) == "controller") {
                    break;
                }

                $newClass .= $str . strtolower($value);
            }
        }
        return $newClass;
    }
}

function createFile($folder, $filename, $content)
{
    $filepath = $folder . $filename;
    if (is_writable($folder)) {
        if (!$file = fopen($filepath, 'w')) {
            return array('status' => 0, 'message' => 'Failed to create the file ' . $filepath);
        }

        if (!fwrite($file, $content)) {
            return array('status' => 0, 'message' => 'Failed to write content on the file ' . $filepath);
        }

        fclose($file);
        return true;
    }
    return array('status' => 0, 'message' => $folder . ' is not writable.');
}

function debug($var)
{
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}

function getRandomString($length = 8)
{
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array

    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }

    return implode($pass); //turn the array into a string
}

function getRandomNumber($length = 8)
{
    $alphabet = "0123456789";
    $pass = array(); //remember to declare $pass as an array

    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }

    return implode($pass); //turn the array into a string
}

if (false === function_exists('lcfirst')) {
    function lcfirst($str)
    {
        $str[0] = strtolower($str[0]);
        return (string) $str;
    }
}

function deleteFolder($path)
{
    if (is_dir($path) === true) {
        $files = array_diff(scandir($path), array('.', '..'));

        foreach ($files as $file) {
            deleteFolder(realpath($path) . '/' . $file);
        }

        return rmdir($path);
    } else if (is_file($path) === true) {
        return unlink($path);
    }

    return false;
}

function isActive($controller = "", $params = "")
{
    $ci = &get_instance();

    $isParams = true;
    if (!empty($params)) {
        $isParams = strpos($ci->queryString, $params) !== false;
    }

    $isController = $ci->router->fetch_class() == $controller;

    if ($isParams && $isController) {
        echo " active ";
    }
}

function format_currency($number = 0)
{
    return number_format($number, 0, ",", ".");
}
