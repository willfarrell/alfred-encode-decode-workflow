<?php

class Decoder
{
    function __construct()
    {
    }

    public function decode($query)
    {
        require_once('workflows.php');

        $w = new Workflows();

        function replace_unicode_escape_sequence($match)
        {
            return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
        }

        function html_decode($str)
        {
            return str_replace(array("&lt;", "&gt;", '&amp;', '&#039;', '&quot;', '&lt;', '&gt;'), array("<", ">", '&', '\'', '"', '<', '>'), htmlspecialchars_decode($str, ENT_NOQUOTES));
        }

        if (0) {
            echo "" . $query . "\n";
            echo "urlencode = " . urldecode($query) . "\n";
            echo "utf8_encode = " . utf8_decode($query) . "\n";
            echo "unicode = " . preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'replace_unicode_escape_sequence', $query) . "\n";
            echo "htmlentities = " . html_entity_decode($query) . "\n";
            echo "base64_encode = " . base64_decode($query) . "\n";

            exit();
        }

        $decodes = array();
        // url
        $url_decode = urldecode($query);
        if ($url_decode != $query) $decodes["URL Decoded"] = $url_decode;

        // unicode
        $unicode_decode = preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'replace_unicode_escape_sequence', $query);
        if ($unicode_decode != $query) $decodes["Unicode Decoded"] = $unicode_decode;

        // HTML
        $html_decode = html_entity_decode($query, ENT_QUOTES, 'UTF-8');
        if ($html_decode != $query) $decodes["HTML Decoded"] = $html_decode;

        // base64
        $base64_decode = base64_decode($query, true);
        if ($base64_decode && $base64_decode != $query) {
            $decodes["base64 Decoded"] = $base64_decode;
        }

        // urlsafe base64
        $urlsafe_base64_decode = $this->urlsafe_b64decode($query);
        if ($urlsafe_base64_decode && $urlsafe_base64_decode != $query) {
            $decodes["base64(urlsafe) Decoded"] = $urlsafe_base64_decode;
        }

        //$dencodes["UTF-8 Decoded"] = utf8_decode($query);

        $decodes = $this->prepare_output($decodes);

        foreach ($decodes as $key => $value) {
            $w->result($key, $value, $value, $key, 'icon.png', 'yes');
        }

        if (count($w->results()) == 0) {
            $w->result('decode', $query, 'Nothing useful resulted', 'The decoded strings were the same as your query', 'icon.png', 'yes');
        }

        return $w->toxml();

    }

    private function force_utf8_safe($str)
    {
        $res = mb_convert_encoding($str, "UTF-8", "UTF-8"); // replace invalid characters with ?
        $res = preg_replace('/\p{Cc}+/u', '?', $res); // replace control characters with ?
        return $res;
    }

    private function prepare_output($items)
    {
        $res = [];
        foreach ($items as $key => $value) {
            // Make UTF-8 safe results.
            $safe_value = $this->force_utf8_safe($value);
            if ($value != $safe_value) {
                $key .= ' (Invalid characters replaced with ?)';
                $value = $safe_value;
            }
            $res[$key] = $value;
        }
        return $res;
    }

    private function urlsafe_b64decode($string)
    {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

}