<?php

namespace JanMensik\PHPHelpers;

class Helpers {

    /**
     * Convert utf-8 string to ascii string (no diacritics).
     * Only for Latin-1 and Czech (common) chars.
     */
    public static function utf2ascii(string $string): string {
        $string = iconv('utf-8', 'windows-1250', $string);
        $win = "����������������̊�؎���ɍ���������\x97\x96\x91\x92\x84\x93\x94\xAB\xBB";
        $ascii = "escrzyaietnduuoouaESCRZYAIETNDUUOOUEAOUEA\x2D\x2D\x27\x27\x22\x22\x22\x22\x22";
        return strtr($string, $win, $ascii);
    }

    /**
     * Convert utf-8 string to SEO-friendly string for links.
     */
    public static function text2seolink(string $string): string {
        $string = self::utf2ascii($string);
        $string = strtolower(preg_replace("/[^a-z0-9-]/i", "-", $string));
        $string = preg_replace("/-{2,}/", "-", $string);
        $string = ltrim($string, '-');
        $string = rtrim($string, '-');
        return $string;
    }

    /**
     * Parse a float from a string, handling commas and spaces.
     */
    public static function parseFloat(?string $str): ?float {
        if (!isset($str)) return null;
        $str = str_replace(" ", "", $str);
        $str = str_replace(",", ".", $str);
        if (preg_match("#-?([0-9]+\.?[0-9]{0,5})#", $str, $match)) {
            return floatval($match[0]);
        } else {
            return floatval($str);
        }
    }

    /**
     * Parse a date string into a timestamp (noon by default).
     */
    public static function parseDate(?string $data, bool $force = false): ?int {
        if (!$data) return null;
        elseif (preg_match('/([0-9]{9,11})/', $data, $datum))
            $output = $datum[1];
        elseif (preg_match('/([0-9]{1,2})\\. ?([0-9]{1,2})\\. ?([1-9][0-9]{3})( ?-? *([0-9]{1,2}):([0-9]{1,2})([:.]([0-9]{1,2}))?)?/', $data, $datum))
            $output = mktime(isset($datum[5]) ? $datum[5] : 12, isset($datum[6]) ? $datum[6] : 0, isset($datum[8]) ? $datum[8] : 0, $datum[2], $datum[1], $datum[3]);
        elseif (preg_match('/([0-9]{1,2})\\. ?([0-9]{1,2})\\. ?( ?-? *([0-9]{1,2}):([0-9]{1,2})([:.]([0-9]{1,2}))?)?/', $data, $datum2))
            $output = mktime(isset($datum2[4]) ? $datum2[4] : 12, isset($datum2[5]) ? $datum2[5] : 0, isset($datum2[7]) ? $datum2[7] : 0, $datum2[2], $datum2[1]);
        elseif (strtotime($data))
            $output = strtotime($data);
        elseif ($force)
            $output = mktime(12, 0, 0);
        else
            $output = null;
        return $output;
    }

    /**
     * Case-insensitive version of strpos().
     */
    public static function stripos(string $str, string $needle, int $offset = 0): int|false {
        return strpos(strtolower($str), strtolower($needle), $offset);
    }

    /**
     * Case-insensitive version of strrpos().
     */
    public static function strripos(string $haystack, string $needle, int $offset = 0): int|false {
        if (!is_string($needle)) $needle = chr(intval($needle));
        if ($offset < 0) {
            $temp_cut = strrev(substr($haystack, 0, abs($offset)));
        } else {
            $temp_cut = strrev(substr($haystack, 0, max((strlen($haystack) - $offset), 0)));
        }
        $found = self::stripos($temp_cut, strrev($needle));
        if ($found === false) return false;
        $pos = (strlen($haystack) - ($found + $offset + strlen($needle)));
        return $pos;
    }

    /**
     * Delete a file, or a folder and its contents.
     */
    public static function rmdirr(string $dirname): bool {
        if (is_file($dirname)) return unlink($dirname);
        if (!is_dir($dirname)) return false;
        $dir = dir($dirname);
        while (false !== $entry = $dir->read()) {
            if ($entry == '.' || $entry == '..') continue;
            if (is_dir("$dirname/$entry"))
                self::rmdirr("$dirname/$entry");
            else
                unlink("$dirname/$entry");
        }
        $dir->close();
        return rmdir($dirname);
    }

    /**
     * Validate the syntax of an email address (legacy logic)
     *
     * @param string $email
     * @return bool
     */
    public static function checkEmail(string $email): bool {
        $atom = '[-a-z0-9!#$%&\'*+/=?^_`{|}~]';
        $domain = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';
        return (bool)preg_match(":^$atom+(\\.$atom+)*@($domain?\\.)+$domain$:", $email . '', 'i');
    }
}


/*
git status
git tag v1.0.0
git push origin v1.0.0
*/