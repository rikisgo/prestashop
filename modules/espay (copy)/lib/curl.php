<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of curl
 *
 * @author fredy
 */
class Curl {

   

    public function call($param, $url) {
        
        $param_query = http_build_query($param);

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $param_query);

        curl_setopt($curl, CURLOPT_HEADER, false);
        //curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1); //use http 1.1
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
        //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        //NOTE: skip SSL certificate verification (this allows sending request to hosts with self signed certificates, but reduces security)
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);


        //enable ssl version 3
        //this is added because mandiri ecash case that ssl version that have been not supported before
        curl_setopt($curl, CURLOPT_SSLVERSION, 1);

        curl_setopt($curl, CURLOPT_VERBOSE, true);
        //save to temporary file (php built in stream), cannot save to php://memory
        $verbose = fopen('php://temp', 'rw+');
        curl_setopt($curl, CURLOPT_STDERR, $verbose);

        $response = curl_exec($curl);
        
        return json_decode($response);
    }

}
