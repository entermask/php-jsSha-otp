<?php

class GoogleOtp
{

    private function base32tohex($base32)
    {
        $base32chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ234567";
        $base32arr = str_split($base32chars);
        $base32 = strtoupper($base32);
        $_base32arr = str_split($base32);
        $bits = "";
        $hex = "";

        for ($i = 0; $i < strlen($base32); $i++) {
            $val = array_search($_base32arr[$i], $base32arr);
            $bits .= str_pad(decbin($val), 5, '0', STR_PAD_LEFT);
        }

        for ($i = 0; $i + 4 <= strlen($bits); $i += 4) {
            $chunk = substr($bits, $i, 4);
            $hex .= dechex(bindec($chunk));
        }

        return $hex;
    }

    public function generate($secret, $epoch = false)
    {
        $key = $this->base32tohex($secret);

        if (strlen($key) % 2 !== 0)
            $key .= '0';

        if ($epoch === false)
            $epoch = time() - 72;

        $time = str_pad(dechex(floor($epoch/30)), 16, '0', STR_PAD_LEFT);
        $hmac = hash_hmac('sha1', pack("H*", $time), pack("H*", $key), false);
        $offset = hexdec(substr($hmac, strlen($hmac) - 1));
        $otp = (hexdec(substr($hmac, $offset * 2, 8)) & hexdec('7fffffff')) . '';

        return substr($otp, strlen($otp) - 6, 6);
    }
    
}

?>
