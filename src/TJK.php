<?php

namespace TJK;
/**
 * TJK
 *
 * @author Sezer Fidanci <sezerfidanci@gmail.com>
 */

class TJK
{
    public $baseURL = 'https://ebayi.tjk.org/s/d/';

    private function getBaseURL()
    {
        return $this->baseURL;
    }

    public function getTodayRaces()
    {
        /**
         * getTodayRaces
         * @param $today date format Ymd
         */

        $today =date('Ymd');

        $url = $this->getBaseURL().'program/'.$today.'/yarislar.json';
        $hippodromes =$this->getContents($url);

        if ($hippodromes['status']===false)
        {
            return $hippodromes;
        }

        $races = array();

        foreach ($hippodromes['data'] as $item)
        {
            $data=array(
                'KEY'=>$item['KEY'],
                'AD'=>$item['AD'],
                'YER'=>$item['YER'],
                'GUN'=>$item['GUN'],
                'RACE'=>$this->getRaces($today,$item['KEY'])['data'],
            );
            array_push($races,$data);
        }
        return $this->apiResponseFormat(true,200,$races);
    }


    public function getRacesByDate($date = null)
    {
        /**
        * getRacesDate
        * @param $date date format Ymd
        */

        $date =$date==null?date('Ymd'):$date;

        $url = $this->getBaseURL().'program/'.$date.'/yarislar.json';
        $hippodromes =$this->getContents($url);

        if ($hippodromes['status']===false)
        {
            return $hippodromes;
        }

        $races = array();

        foreach ($hippodromes['data'] as $item)
        {
            $data=array(
                'KEY'=>$item['KEY'],
                'AD'=>$item['AD'],
                'YER'=>$item['YER'],
                'GUN'=>$item['GUN'],
                'RACE'=>$this->getRaces($date,$item['KEY'])['data'],
            );
            array_push($races,$data);
        }
        return $this->apiResponseFormat(true,200,$races);
    }

    public function getRaces($date,$hippodrome)
    {
        /**
         * getRaces
         * @param $date date format Ymd
         * @param $hippodrome hippodrome key
         */

        $url = $this->getBaseURL().'program/'.$date.'/full/'.$hippodrome.'.json';
        $races = $this->getContents($url);
        return $races;
    }


    public function getTodayResult()
    {
        /**
         * getTodayResult
         * @param $today date format Ymd
         */

        $today =date('Ymd');

        $url = $this->getBaseURL().'sonuclar/'.$today.'/yarislar.json';
        $hippodromes =$this->getContents($url);

        if ($hippodromes['status']===false)
        {
            return $hippodromes;
        }

        $races = array();

        foreach ($hippodromes['data'] as $item)
        {
            $data=array(
                'KEY'=>$item['KEY'],
                'AD'=>$item['AD'],
                'YER'=>$item['YER'],
                'GUN'=>$item['GUN'],
                'RACE'=>$this->getResult($today,$item['KEY'])['data'],
            );
            array_push($races,$data);
        }
        return $this->apiResponseFormat(true,200,$races);
    }

    public function getResultByDate($date = null)
    {
        /**
         * getResultByDate
         * @param $date date format Ymd
         */

        $date =$date==null?date('Ymd'):$date;

        $url = $this->getBaseURL().'sonuclar/'.$date.'/yarislar.json';
        $hippodromes =$this->getContents($url);

        if ($hippodromes['status']===false)
        {
            return $hippodromes;
        }

        $races = array();

        foreach ($hippodromes['data'] as $item)
        {
            $data=array(
                'KEY'=>$item['KEY'],
                'AD'=>$item['AD'],
                'YER'=>$item['YER'],
                'GUN'=>$item['GUN'],
                'RACE'=>$this->getResult($date,$item['KEY'])['data'],
            );
            array_push($races,$data);
        }
        return $this->apiResponseFormat(true,200,$races);
    }

    public function getResult($date,$hippodrome)
    {
        /**
         * getResult
         * @param $date date format Ymd
         * @param $hippodrome hippodrome key
         */

        $url = $this->getBaseURL().'sonuclar/'.$date.'/full/'.$hippodrome.'.json';
        $races = $this->getContents($url);
        return $races;
    }


    private function getContents($url)
    {
        $ch = curl_init();
        $header=array(
            'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.12) Gecko/20101026 Firefox/3.6.12',
            'Accept: application/json',
            'Accept-Language: en-us,en;q=0.5',
            'Accept-Encoding: gzip,deflate',
            'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
            'Keep-Alive: 115',
            'Connection: keep-alive',
            'Content-Type:application/json',
        );

        curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_COOKIEJAR, @tempNam('/tmp', 'phrets')  );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $ch, CURLOPT_ENCODING, "" );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 20 );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 20 );
        curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
        curl_setopt($ch, CURLOPT_REFERER, 'https://www.google.com/');
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);

        $content = json_decode(curl_exec( $ch ),true);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $status = true;
        curl_close ( $ch );

        if ($httpcode>=400)
        {
            $status=false;
            $content=null;
        }


        return $this->apiResponseFormat($status,$httpcode,$content);
    }

    public function apiResponseFormat($status=false,$code=200,$data=null)
    {
        return array(
            'status' => $status,
            'code' => $code,
            'data' => $data,
        );

    }
}