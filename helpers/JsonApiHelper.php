<?php

namespace greeschenko\scud\helpers;

use StdClass;

/**
 * helper for send and read json requests with curl.
 *
 * @version 0.1
 *
 * @copyright 2008-2016 greeschenko
 * @author Oleksiy Hryshchenko <greeschenko@gmail.com>
 * @license MIT
 */
class JsonApiHelper
{
    /**
     * send request with curl and optional type.
     */
    public function sendRequest($url, $protocol, $data = [], $json = false, $debag = false)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, $debag);
        curl_setopt($curl, CURLINFO_HEADER_OUT, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_USERAGENT, 'PHP');
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        if ($protocol != 'GET') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $protocol);
            if ($protocol != 'DELETE') {
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            }
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            //'Content-Length: '.strlen(json_encode($data)),
            'Content-Type: application/json',
        ]);

        $output = curl_exec($curl);

        if ($debag) {
            echo $url;
            echo '<pre>';
            print_r([$curl]);
            print_r([$output]);
            print_r($data);
            die;
        }

        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = substr($output, 0, $header_size);
        $body = substr($output, $header_size);

        //echo '<pre>';
        //print_r([$body]);
        curl_close($curl);

        return json_decode($output);

        //$result = new StdClass();
        //$result->status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        //$output = json_decode($body, true);
        //$output['status_code'] = $result->status_code;
        //$output['header'] = $header;
        ////$output['header_out'] = curl_getinfo($curl, CURLINFO_HEADER_OUT);
        ////$output['url'] = $url;
        //$result->body = json_encode($output);
        //curl_close($curl);

        //if ($json) {
            //return $output;
        //}

        //if ($result->status_code == '412') {
            //sleep(10);

            //return $this->sendGET($url, $json);
        //}

        //return json_decode($result->body);
    }

    public static function sendRequest1($url, $data)
    {
        $headers = array(
            'Accept:application/json',
            'Content-Type:application/json; charset=utf-8',
            'Connection:keep-alive',
            'Content-Length:'.mb_strlen($data, 'utf-8'),
        );
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERAGENT, 'PHP');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $responce = curl_exec($ch);
        curl_close($ch);

        return $responce;
    }

    /**
     * send file function.
     */
    public function sendFILE($url, $file, $replace = false)
    {
        $basename = basename($file);
        $mimetype = mime_content_type($file);
        $cfile = new \CURLFile($file, $mimetype, $basename);

        $data = [
            'file' => $cfile,
        ];

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        if ($replace) {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: multipart/form-data; boundary=----------a_BoUnDaRy575636613392$',
        ]);

        $output = curl_exec($curl);

        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = substr($output, 0, $header_size);
        $body = substr($output, $header_size);

        $result = new StdClass();
        $result->status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $output = json_decode($body, true);
        $output['status_code'] = $result->status_code;
        $output['header'] = $header;
        //$output['header_out'] = curl_getinfo($curl, CURLINFO_HEADER_OUT);
        //$output['url'] = $url;
        $output['filename'] = $basename;
        $result->body = json_encode($output);
        curl_close($curl);

        return json_decode($result->body);
    }

    /**
     * undocumented function.
     */
    public function readRequest()
    {
        $input = file_get_contents('php://input');

        return json_decode($input);
    }
}
