<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasFactory;
    public static function sendSMS($message,$mobile){
        $request="";
        $param['username']="Makita";
        $param['message']=$message;
        $param['sendername']="MAKITA";
        $param['smstype']="TRANS";
        $param['numbers']=$mobile;
        $param['apikey']="67efd422-31fe-4ff7-8b0e-ceaddc33521b";
        foreach($param as $key=>$val){
            $request.= $key."=".urlencode($val);
            $request.="&";
        }
        $request=substr($request, 0, strlen($request)-1);
        $url="http://sms.hspsms.com/sendSMS?".$request;
        $ch=curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $curl_scraped_page=curl_exec($ch);
        curl_close($ch);
    }
}
