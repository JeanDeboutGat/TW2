<?php

require_once('../lib/session_start.php');
require_once('../lib/RequestParameters.class.php');
require_once('../lib/initDataLayer.php');

$response = array();
$login = (isset($_SESSION["rezozio_user"]) && !empty($_SESSION["rezozio_user"])) ? $_SESSION["rezozio_user"]["login"] : false;

if($login != false){
    if(isset($_FILES["avatar"])){
        //if image exists
        $image = imagecreatefromstring(file_get_contents($_FILES["avatar"]["tmp_name"]));
        if($image){            
            $width = imagesx($image);
            $height = imagesy($image);
            $size = min([$width, $height]);
            // create a new file
            $newImage = imagecreatetruecolor($size, $size);
            $large = imagecreatetruecolor(256, 256);
            $small = imagecreatetruecolor(48, 48);

            $cropped = imagecopyresampled($newImage, $image, 0, 0, ($width-$size)/2, ($height-$size)/2, $size, $size, $width, $height);
            $largepic = imagecopyresampled($large, $newImage, 0, 0, 0, 0, 256, 256, $size, $size);
            $smallpic = imagecopyresampled($small, $newImage, 0, 0, 0, 0, 48, 48, $size, $size);

            if($largepic && $smallpic){
                $mimetype = "image/jpeg";
                // flux small pic            
                $tempSmall = fopen("php://temp", "r+");
                imagejpeg($small, $tempSmall);
                rewind($tempSmall);
                
                // flux large file
                $tempLarge = fopen("php://temp", "r+");
                imagejpeg($large, $tempLarge);
                rewind($tempLarge);

                $avatar = $data->uploadAvatar($login, $tempSmall, $tempLarge,$mimetype);

                if($avatar){
                    $response["status"] = "ok";
                    $response["result"] = true;
                }else{
                    $response["status"] = "error";
                    $response["result"] = false;
                }
            
            }else{
                $response["status"] = "error";
                $response["result"] = false;
            }
        }else{
            $response["status"] = "error";
            $response["result"] = false;
        }

    }else{
        $response["status"] = "error";
        $response["result"] = false;
    }
}else{
    $response["status"] = "error";
    $response["result"] = false;
}

echo json_encode($response);
?>