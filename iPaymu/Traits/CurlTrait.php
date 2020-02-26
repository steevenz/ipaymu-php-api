<?php

/**
 * @author Fahdi Labib <fahdilabib@gmail.com>
 */

namespace iPaymu\Traits;

use iPaymu\Exceptions\ApiKeyInvalid;

trait CurlTrait
{

    /**
     * @param $config
     * @param $params
     *
     * @throws ApiKeyInvalid
     *
     * @return mixed
     */
    function genSignature($data, $credentials)
    {
        $body = json_encode($data, JSON_UNESCAPED_SLASHES);
        $requestBody  = strtolower(hash('sha256', $body));
        $secret       = $credentials['apikey'];
        $va           = $credentials['va'];
        $stringToSign = 'POST:' . $va . ':' . $requestBody . ':' . $secret;
        $signature    = hash_hmac('sha256', $stringToSign, $secret);

        return $signature;
    }

    public function request($config, $params, $credentials)
    {
        // $this->config = new Config();
        $signature = $this->genSignature($params, $credentials);
        $params_string = http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $config);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type" => "application/json",
            "signature" => $signature,
            "va" => $credentials['va'],
            "timestamp" => date('Ymdhis')
        ));
        $request = curl_exec($ch);

        if ($request === false) {
            echo 'Curl Error: ' . curl_error($ch);
        } else {
            $result = $this->responseHandler(json_decode($request, true));

            return $result;
        }

        curl_close($ch);
        exit;
    }

    /**
     * @param $response
     *
     * @throws ApiKeyInvalid
     *
     * @return mixed
     */
    private function responseHandler($response)
    {
        switch (@$response['Status']) {
            case '-1001':
                throw new ApiKeyInvalid();
            default:
                return $response;
        }
    }
}
