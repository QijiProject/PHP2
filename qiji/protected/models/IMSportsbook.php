<?php

/**
 * IMSportsbook class.
 */
class IMSportsbook extends CFormModel
{

    const AUTH_URL = 'http://keizak.sbws.imapi.net/externalapi.asmx';
    const LOGIN_URL = 'http://keizak.sbws.imapi.net/externalapi.asmx';
    const LOGOUT_URL = 'http://keizak.sbws.imapi.net/externalapi.asmx';
    private $_key = 'xxxxxxxxxx';
    private $_iv;
    private $_token;
    private $_prefix;
    private $_name;
    private $_membercode;
    /**
     * @param $prefix
     * @param $name
     * @param $token string 登录token用于玩家登录校验
     */
    function __construct($prefix, $name, $token)
    {
        $this->_iv = 'dieD5ksoWf3=';
        $this->_prefix = $prefix;
        $this->_name = $name;
        $this->_membercode = $prefix . '_' . $name;//未定
        $this->_token = $token;
    }

    /**
     * Temporary status
     * @param $tm
     * @return Result
     */
    public static function getStatus($login)
    {
        return 1;
    }

    /**
     * IM体育登录
     * @param $tm
     * @return Result
     */
    public function login(&$tm)
    {
        $tm = $this->gen_timestamp();
        $xml = sprintf('<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
            <soap:Body>
            <loginXML xmlns="http://tempuri.org/">
            <timeStamp>%s</timeStamp>
            <token>%s</token>
            </loginXML>
            </soap:Body>
            </soap:Envelope>', $tm, $this->_token);

        $curl = new Curl();
        $curl->setHeader('Content-Type', 'text/xml');
        $curl->post(self::AUTH_URL, $xml);

        return $this->parse_response($curl);
    }

    private function gen_timestamp()
    {
        $tz = date_default_timezone_get();
        date_default_timezone_set('GMT');
        $gmt_time = date('D,d M Y H:i:s T', time());
        date_default_timezone_set($tz);
        return $this->encrypt_pkcs7($gmt_time, $this->_key);
    }

    private function encrypt_pkcs7($data, $key)
    {
        //Pad for PKCS7
        $blockSize = mcrypt_get_block_size('tripledes', 'ecb');
        $len = strlen($data);
        $pad = $blockSize - ($len % $blockSize);
        $data .= str_repeat(chr($pad), $pad);
        $key = md5($key, TRUE);
        $key .= substr($key, 0, 8); //comment this if you use 168 bits long key
        //Encrypt data
        $encData = mcrypt_encrypt('tripledes', $key, $data, 'ecb');
        return base64_encode($encData);
    }

    /**
     * @param $curl Curl
     * @return Result
     */
    private function parse_response($curl)
    {
        $result = new Result();
        if ($curl->http_status_code == 200) {
            $xml = $curl->response;
            $body = $xml->children('soap', true);

            if ($body) {
                $chs = $body[0]->children();
                $rs = $chs[0];
                if ($rs->statusCode == 100) {
                    $result->succ = true;
                }
                $result->msg = $rs->statusDesc;
            }
        }
        return $result;
    }

    
}


