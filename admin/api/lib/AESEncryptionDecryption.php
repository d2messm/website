<?php

class AESEncryptionDecryption {

    const M_CBC = 'cbc';
    const M_CFB = 'cfb';
    const M_ECB = 'ecb';
    const M_NOFB = 'nofb';
    const M_OFB = 'ofb';
    const M_STREAM = 'stream';

    protected $key;
    protected $cipher;
    protected $data;
    protected $mode;
    protected $blockSize;
    protected $IV;

    /**
     * 
     * @param type $data
     * @param type $key
     * @param type $blockSize
     * @param type $mode
     */
    function __construct($data = null, $key = null, $blockSize = null, $mode = null) {
        $this->setData($data);
        $this->setKey($key);
        $this->setMode($mode);
        $this->setBlockSize($blockSize);
        $this->setCipher();
    }

    /**
     * 
     * @param type $data
     */
    public function setData($data) {
        $this->data = $data;
    }

    public function getData() {
        return $this->data;
    }

    /**
     * 
     * @param type $key
     */
    public function setKey($key) {
        $this->key = $key;
    }

    public function setCipher() {
        $blockSize = $this->blockSize;
        switch ($blockSize) {
            case 128:
                $this->cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', $this->getMode(), '');
                break;

            case 192:
                $this->cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_192, '', $this->getMode(), '');
                break;

            case 256:
                $this->cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', $this->getMode(), '');
                break;
        }
    }

    public function getCipher() {
        return $this->cipher;
    }

    /**
     * 
     * @param type $blockSize
     */
    public function setBlockSize($blockSize) {
        $this->blockSize = $blockSize;
    }

    public function getBlockSize() {
        return $this->blockSize;
    }

    /**
     * 
     * @param type $mode
     */
    public function setMode($mode) {
        switch ($mode) {
            case AESEncryptionDecryption::M_CBC:
                $this->mode = MCRYPT_MODE_CBC;
                break;
            case AESEncryptionDecryption::M_CFB:
                $this->mode = MCRYPT_MODE_CFB;
                break;
            case AESEncryptionDecryption::M_ECB:
                $this->mode = MCRYPT_MODE_ECB;
                break;
            case AESEncryptionDecryption::M_NOFB:
                $this->mode = MCRYPT_MODE_NOFB;
                break;
            case AESEncryptionDecryption::M_OFB:
                $this->mode = MCRYPT_MODE_OFB;
                break;
            case AESEncryptionDecryption::M_STREAM:
                $this->mode = MCRYPT_MODE_STREAM;
                break;
            default:
                $this->mode = MCRYPT_MODE_CBC;
                break;
        }
    }

    public function getMode() {
        return $this->mode;
    }

    /**
     * 
     * @return boolean
     */
    public function validateParams() {
        if ($this->data != null &&
                $this->key != null &&
                $this->cipher != null) {
            return true;
        } else {
            return FALSE;
        }
    }

    public function setIV($IV) {
        $this->IV = $IV;
    }

    public function getIV() {
        return $this->IV;
    }

    /**
     * @return type
     * @throws Exception
     */
    public function encrypt() {

        if ($this->validateParams()) {
            $iv_size = mcrypt_enc_get_iv_size($this->cipher);
            $this->setIV(substr(md5($this->key), 0, $iv_size));
            $data = $this->pkcs5_pad($this->getData(), $iv_size);
            $this->setData($data);

            if (mcrypt_generic_init($this->cipher, $this->key, $this->IV) != -1) {
                $cipherText = mcrypt_generic($this->cipher, $this->getData());
                mcrypt_generic_deinit($this->cipher);
                $b64ciphertext = base64_encode($cipherText);
                $b64ciphertext = str_replace("/", "*", $b64ciphertext);
                return $b64ciphertext;
            }

            //AES/CFB8/NoPadding code....
            /* $this->setIV(substr(md5($this->key),0,16));

              return trim(base64_encode(
              mcrypt_encrypt(
              MCRYPT_RIJNDAEL_128,  $this->key, $this->data, $this->mode, $this->getIV()))) ; */
        } else {
            throw new Exception('Invlid params!');
        }
    }

    /**
     * 
     * @return type
     * @throws Exception
     */
    public function decrypt() {
        if ($this->validateParams()) {
            $iv_size = mcrypt_enc_get_iv_size($this->cipher);
            $this->setIV(substr(md5($this->key), 0, $iv_size));
            $source = array(" ");
            $destination = array("+");
            $this->data = str_replace($source, $destination, $this->data);
            $this->data = str_replace("*", "/", $this->data);
            return trim($this->pkcs5_unpad(mcrypt_decrypt(
                MCRYPT_RIJNDAEL_128, $this->key, base64_decode($this->data), $this->mode, $this->getIV())));
        } else {
            throw new Exception('Invlid params!');
        }
    }

    /**
     * 
     * @param undefined $text
     * @param undefined $blocksize
     * 
     * @return
     */
    public function pkcs5_pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    public function pkcs5_unpad($text) {
        $pad = ord($text{strlen($text) - 1});
        if ($pad > strlen($text))
            return false;
        if (strspn($text, $text{strlen($text) - 1}, strlen($text) - $pad) != $pad) {
            return false;
        }
        return substr($text, 0, -1 * $pad);
    }

}

?>
