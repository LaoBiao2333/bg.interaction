<?php

namespace common\helps;
class tools
{
    public static function getIPLoc_sina($queryIP)
    {

        $url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=' . $queryIP;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $location = curl_exec($ch);
        $location = json_decode($location);
        curl_close($ch);
        static $loc = "";
        if ($location === FALSE) return "";
        if (!empty($location->province)) {
            $loc = $location->province . $location->city;

        } elseif (!empty($location->country)) {
            $loc = $location->country;
        } else {
            $loc = "ip地址错误！";
        }

        return $loc;

    }

    //获取年份并从大到小排序
    public static function getYear($data)
    {
        $year = array();
        foreach ($data as $key => $value) {
            $year[] = $value['year'];
        }
        $ye = array_unique($year);
        rsort($ye);
        return $ye;
    }

    //获取月份并从小到大排序
    public static function getMonth($data)
    {
        $month = array();
        foreach ($data as $key => $value) {
            $month[] = $value['month'];
        }
        $mo = array_unique($month);
        sort($mo);
        return $mo;
    }

    //截取字符串
    public static function getStr($str, $len = 12, $dot = true)
    {
        $i = 0;
        $l = 0;
        $c = 0;
        $a = array();
        while ($l < $len) {
            $t = substr($str, $i, 1);
            if (ord($t) >= 224) {
                $c = 3;
                $t = substr($str, $i, $c);
                $l += 2;
            } elseif (ord($t) >= 192) {
                $c = 2;
                $t = substr($str, $i, $c);
                $l += 2;
            } else {
                $c = 1;
                $l++;
            }
            // $t = substr($str, $i, $c);
            $i += $c;
            if ($l > $len) break;
            $a[] = $t;
        }
        $re = implode('', $a);
        if (substr($str, $i, 1) !== false) {
            array_pop($a);
            ($c == 1) and array_pop($a);
            $re = implode('', $a);
            $dot and $re .= '...';
        }
        return $re;
    }

    //文章内容截取(去除HTML标签、空格等等，再截取)
    public static function cutstr_html($string, $length = 100, $ellipsis = '…')
    {
        $string = htmlspecialchars_decode($string);
        $string = strip_tags($string);
        $string = preg_replace('/\n/is', '', $string);
        $string = preg_replace('/ |　/is', '', $string);
        $string = preg_replace('/<p[^>]*>/is', '', $string);
        $string = preg_replace('/<\/p>/is', '', $string);
        $string = preg_replace('/&nbsp;/is', '', $string);
        preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $string);
        if (is_array($string) && !empty($string[0])) {
            if (is_numeric($length) && $length) {
                $string = join('', array_slice($string[0], 0, $length)) . $ellipsis;
            } else {
                $string = implode('', $string[0]);
            }
        } else {
            $string = '';
        }

        //	return $string;
        return self::cn_substr_utf8($string, $length);
    }

    //utf-8中文截取，单字节截取模式
    public static function cn_substr_utf8($str, $length = 200)
    {
        $append = '...';
        $start = 0;
        if (strlen($str) < $start + 1) {
            return '';
        }
        preg_match_all("/./su", $str, $ar);
        $str2 = '';
        $tstr = '';
        //www.phpernote.com
        for ($i = 0; isset($ar[0][$i]); $i++) {
            if (strlen($tstr) < $start) {
                $tstr .= $ar[0][$i];
            } else {
                if (strlen($str2) < $length + strlen($ar[0][$i])) {
                    $str2 .= $ar[0][$i];
                } else {
                    break;
                }
            }
        }
        return $str == $str2 ? $str2 : $str2 . $append;
    }
}

?>