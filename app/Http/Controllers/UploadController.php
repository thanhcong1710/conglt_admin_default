<?php

namespace App\Http\Controllers;

use App\Providers\UtilityServiceProvider as u;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    public function upload()
    {
        /***************************************************
         * Only these origins are allowed to upload images *
         ***************************************************/
        $accepted_origins = array("http://localhost", "http://192.168.1.1", "http://example.com", "http://127.0.0.1:8086");

        /*********************************************
         * Change this line to set the upload folder *
         *********************************************/
        $imageFolder = "upload/images/";

        reset($_FILES);
        $temp = current($_FILES);
        if (is_uploaded_file($temp['tmp_name'])) {
            if (isset($_SERVER['HTTP_ORIGIN'])) {
                // same-origin requests won't set an origin. If the origin is set, it must be valid.
                if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
                    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
                } else {
                    return json_encode(array('message' => "HTTP/1.1 403 Origin Denied",'status'=>0));
                }
            }
            /*
      If your script needs to receive cookies, set images_upload_credentials : true in
      the configuration and enable the following two headers.
    */
            // header('Access-Control-Allow-Credentials: true');
            // header('P3P: CP="There is no P3P policy."');

            // Sanitize input
            if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
                return json_encode(array('message' => "HTTP/1.1 400 Invalid file name.",'status'=>0));
            }

            // Verify extension
            if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
                return json_encode(array('message' => "HTTP/1.1 400 Invalid extension.",'status'=>0));
            }

            // Accept upload if there was no origin, or if it is an accepted origin
            $filetowrite = $imageFolder . $temp['name'];
            move_uploaded_file($temp['tmp_name'], $filetowrite);

            // Respond to the successful upload with JSON.
            // Use a location key to specify the path to the saved image resource.
            // { location : '/your/uploaded/image/file'}
            return json_encode(array('location' => $filetowrite,'status'=>1));
        } else {
            // Notify editor that the upload failed
            return json_encode(array('message' => "HTTP/1.1 500 Server Error",'status'=>0));
        }
    }
}
