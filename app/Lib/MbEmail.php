<?php

App::uses('CakeEmail','Network/Email');

class MbEmail extends CakeEmail{
    /**
     * Encode the specified string using the current charset
     *
     * @param string $text String to encode
     * @return string Encoded string
     */
    protected function _encode($text) {
        $internalEncoding = function_exists('mb_internal_encoding');
        if ($internalEncoding) {
            $restore = mb_internal_encoding();
            mb_internal_encoding($this->_appCharset);
        }
        if (empty($this->headerCharset)) {
            $this->headerCharset = $this->charset;
        }
        $return = mb_encode_mimeheader($text, $this->headerCharset, 'B', "\n");
        if ($internalEncoding) {
            mb_internal_encoding($restore);
        }
        return $return;
    }

}
