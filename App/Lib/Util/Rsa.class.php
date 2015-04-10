<?php

/**
 * @author alun (http://alunblog.duapp.com)
 * @version 1.0
 * @created 2013-5-17
 */
class Rsa {

    private static $PRIVATE_KEY = '-----BEGIN PRIVATE KEY-----
MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAK1N51Z20LOH/beV
4+y0C47efDQ78FLWMOcmFSNk8WsPB0y9p7VNt8fisaNyxRSeHCcbU0Gk3usBUkti
rSlJHw93Xz0TlAmQGG/HowuMaOz2ZYOudxQL6CQCwum5cF/oD8VKufxts9L/Q8Jw
/JygtUmyito/wvF/IrYBt+sNr07TAgMBAAECgYAiIjHqScSZV7OVMSSPPnb4UMHN
1/BhoGZJYKrRKdSS7YbWipQ5lXEZIYEzXCuNAAczfKJNT5fIWZ5H0sugUhKXuh6t
DYnEKYmdkmXiHE/3vvWIpZnxTUn6W5D8b30ymdP7gYCficL+z5bArnwpjcRl8PKf
Qdtgd1BZRNLint3WIQJBAN/lfCBco5+PvM2uGBL4cL0JFidayhQthnTrwPh/L99b
aMMkN02sxi04dISbUpPsMVBd+KLU4YuRLvXVR7OIxiUCQQDGJ1h3pIYAwvILQwCZ
hu9GWIxnkJwCxSxl3u791e+OuNtZkhmk73o+2tP3tSQXdNoVDgSCTUrXOzRIA88v
8AOXAkEAnMTSZNZ4uwCp8lo0ARRz2+jA2k13sSkvPC7WryhfHMWkVP7Gulx/Zqpg
63jWGT0ISn2B2oG0a0T83KS5z7u1AQJATQTEBRTkpO0g6TGszP++hwgp4qM5kHYV
EK97ExyRVVcSoxj/cLVIPaAOnYxBsABSN7bQF9l1Cn1Pj+IzKL3QlwJBALK3uOlb
Rp5ddByMVdRGiVoCZ42kZp4cQFYKHAfSXSbZo6T7xpd8QGUBaKICo2SZiX6nlm0B
gKYGUNJvauF4i1o=
-----END PRIVATE KEY-----';

    /**
     * 返回对应的私钥
     */
    private static function getPrivateKey() {

        $privKey = self::$PRIVATE_KEY;

        return openssl_pkey_get_private($privKey);
    }

    /**
     * 私钥加密
     */
    public static function privEncrypt($data) {
        if (!is_string($data)) {
            return null;
        }
        $encrypted = openssl_private_encrypt($data, $encrypted, self::getPrivateKey()) ? base64_encode($encrypted) : null;
        return urlencode($encrypted);
    }

    /**
     * 私钥解密
     */
    public static function privDecrypt($encrypted) {
        if (!is_string($encrypted)) {
            return null;
        }
        $encrypted = urldecode($encrypted);
        return (openssl_private_decrypt(base64_decode($encrypted), $decrypted, self::getPrivateKey())) ? $decrypted : null;
    }

}

?>
