<?php
namespace App\Helpers;
use DB;
use App\Models;
use League\Flysystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Session;
use Image;
use Aws\S3\S3Client;
use DateTime;
// use Storage;



//use Aws\Exception\AwsException;

class AdminHelper {

//    public static function appDataServerUrl(){
//         return strtolower(stristr($_SERVER["SERVER_PROTOCOL"], "/", true)) . "://" . $_SERVER["HTTP_HOST"] ."/";
//     }

//     public static function appDataBasePath(){
//         return $_SERVER['DOCUMENT_ROOT'] . "/lumix/app_data/";
//     }

//     public static function serverUrl(){
//         return strtolower(stristr($_SERVER["SERVER_PROTOCOL"], "/", true)) . "://" . $_SERVER["HTTP_HOST"] ."/";
//     }

//     public static function randomNumber(){
//         return mt_rand(100001, 999999);

//     }
//     public static function getHighestQualificationList(){
//         $qualifications = MasterModal::getHighestQualificationData();
//         return $qualifications;
//     }

//     public static function getEmployerInfoData(){

//         if(Session::has('employer_id'))
//         {
//             EmployerSubscription::deleteEmployerExpireSubscription(Session::get('employer_id'));
//             //$employerDetail = EmployerDetails::getEmployerById(Session::get('employer_id'));
//             $employerDetailData = EmployerDetails::getEmployerDataWithActivePlan(Session::get('employer_id'));
//             $employerDetail = $employerDetailData[0][0];

//             return $employerDetail;
//         }
//     }

//     public static function getAdminUsers($userType) {
// 		$admin_users = Admin::getAdminUsers($userType);
//         $users = array();
//         foreach ($admin_users as $key => $value) {
//             $users[$value->user_id] = $value->user_name . ' ('. $value->email_id . ')';
//         }

//         return $users;
//     }

//     public static function getImageUrl($imgPath, $prefix, $addEdit) {
//     	if ($imgPath != '' || $imgPath != NULL) {

//             $url = $imgPath;

//             if((!(substr($url, 0, 7) == 'http://')) && (!(substr($url, 0, 8) == 'https://'))) {
//                 $imgUrl = \Config::get('apiglobalvar.S3_BUCKET_URL').$imgPath;
//             } else {
//                 $imgUrl = $imgPath;
//             }

//         } else {
//         	if($addEdit){
//         		$imgUrl = \Config::get('global.IMAGE_URL').\Config::get('global.'.$prefix.'_ADD_EDIT_DUMMY_IMAGE_URL');
// 	    	}
// 	    	else {
//                $imgUrl = \Config::get('global.IMAGE_URL').\Config::get('global.'.$prefix.'_DUMMY_IMAGE_URL');
//            }
//         }

//        return $imgUrl;
//     }

//     // public static function createSlug($text) {
//     //     // replace non letter or digits by -
// 	//   $text = preg_replace('~[^\pL\d]+~u', '-', $text);

// 	//   // transliterate
// 	//   $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

// 	//   // remove unwanted characters
// 	//   $text = preg_replace('~[^-\w]+~', '', $text);

// 	//   // trim
// 	//   $text = trim($text, '-');

// 	//   // remove duplicate -
// 	//   $text = preg_replace('~-+~', '-', $text);

// 	//   // lowercase
// 	//   $text = strtolower($text);

// 	//   if (empty($text)) {
// 	//     return 'n-a';
// 	//   }

// 	//   return $text;
//     // }

//     // public static function getFirtsAndLastCharacterFromWord($string){
//     //     $pieces = explode(" ", $string);
//     //     $countArray = count($pieces);

//     //     if($countArray > 1){
//     //         $str = ucfirst(substr($pieces[0],0,1)). ucfirst(substr($pieces[$countArray-1],0,1));
//     //     }else{
//     //         $str = ucfirst(substr($pieces[0],0,1));
//     //     }

//     //     return $str;
//     // }


//     // public static function getImageResizeRatio($orgImageWidth,$orgImageHeight,$targetImageWidth,$targetImageHeight){
//     //     $ratioW = $targetImageWidth / $orgImageWidth;
//     //     $ratioH = $targetImageHeight / $orgImageHeight;

//     //     // smaller ratio will ensure that the image fits in the view
//     //     $ratio = $ratioW < $ratioH ? $ratioW : $ratioH;

//     //     return $ratio;
//     // }

//     public static function ConvertGMTToLocalTimezoneForChat($gmttime, $timezoneRequired){
//         $system_timezone = date_default_timezone_get();

//         date_default_timezone_set("GMT");
//         $gmt = date("Y-m-d H:i:s");

//         $local_timezone = $timezoneRequired;
//         date_default_timezone_set($local_timezone);
//         $local = date("Y-m-d H:i:s");

//         date_default_timezone_set($system_timezone);
//         $diff = (strtotime($local) - strtotime($gmt));

//         $date = new \DateTime($gmttime);
//         $date->modify("+$diff seconds");

//         // $timestamp = $date->format("m/d/Y H:i:s");
//         $timestamp = $date->format("m/d/Y (h:i:s a)");

//         return $timestamp;
//         //return $date;
//     }

//     public static function ConvertGMTToLocalTimezone($gmttime, $timezoneRequired){
//         $system_timezone = date_default_timezone_get();
//         // dd($timezoneRequired);
//         date_default_timezone_set("GMT");
//         $gmt = date("Y-m-d H:i:s");

//         $local_timezone = $timezoneRequired;
//         date_default_timezone_set($local_timezone);
//         $local = date("Y-m-d H:i:s");
//         //  dd($gmttime);
//         date_default_timezone_set($system_timezone);
//         $diff = (strtotime($local) - strtotime($gmt));
        
//         $date = new \DateTime($gmttime);
//         $date->modify("+$diff seconds");

//         $timestamp = $date->format("Y-m-d H:i:s");
//         // dd($timestamp);
//         return $timestamp;

//         // return $date;
//     }

    public static function ConvertLocalTimezoneToGMT($gmttime, $timezoneRequired){
        $system_timezone = date_default_timezone_get();

        $local_timezone = $timezoneRequired;
        //date_default_timezone_set($local_timezone);
        date_default_timezone_set('Asia/Kolkata'); // Set to your desired timezone

        $local = date("Y-m-d H:i:s");

        date_default_timezone_set("GMT");
        $gmt = date("Y-m-d H:i:s");

        date_default_timezone_set($system_timezone);
        $diff = (strtotime($gmt) - strtotime($local));

        $date = new DateTime($gmttime);
        $date->modify("+$diff seconds");

        // $timestamp = $date->format("m-d-Y H:i:s");
        $timestamp = $date->format("Y-m-d H:i:s");
        return $timestamp;

        //return $date;
    }

//     public static function convertLocalDateFromDB($dbArray) {
//     	foreach ($dbArray as $value) {
//     		$commented_at = date('Y-m-d H:i:s', strtotime($value->commented_at));
//             $timezone    = Session::get('timezone');
//             $commentDate = self::ConvertGMTToLocalTimezone($commented_at, $timezone);
//     		$value->commented_at = $commentDate->format('Y-m-d H:i:s');
//     	}
//     	return $dbArray;
//     }



// 	// public static function sentenceCase($string) {
//     //     $sentences = preg_split('/([.?!]+)/', $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
//     //     $newString = '';
//     //     foreach ($sentences as $key => $sentence) {
//     //         $newString .= ($key & 1) == 0 ?
//     //                 ucfirst(trim($sentence)) :
//     //                 $sentence . ' ';
//     //     }
//     //     return trim($newString);
//     // }

//     public static function getAdminImageUrl($imgPath) {
//       if ($imgPath != '' || $imgPath != NULL) {
//         $url = $imgPath;
//         if((!(substr($url, 0, 7) == 'http://')) && (!(substr($url, 0, 8) == 'https://'))) {
//           $imgUrl = \Config::get('apiglobalvar.S3_BUCKET_URL') .$imgPath;
//         } else {
//           $imgUrl = $imgPath;
//         }
//       } else {
//         $imgUrl = url('/').\Config::get('global.PLACEHOLDER_PROFILE_IMAGE');
//       }
//       return $imgUrl;
//     }

//     public static function getS3ImageURL($image){
          
//         // $s3Client = new \Aws\S3\S3Client([
//         //     'region' => 'ap-south-1',
//         //     'version' => 'latest',
//         // ]); 

//         $s3Client = new \Aws\S3\S3Client([
//             'version' => 'latest',
//             'region' => \Config::get('global.S3_AWS_REGION'),
//             'credentials' => [
//                 'key' => \Config::get('global.S3_AWS_ACCESS_KEY_ID'),
//                 'secret' =>\Config::get('global.S3_AWS_SECRET_ACCESS_KEY'),
//             ],
//         ]);
//         $cmd = $s3Client->getCommand('GetObject', [
//             'Bucket' => \Config::get('global.S3_BUCKET_NAME'),
//             // Config::get('global.S3_BUCKET_NAME'),
//             'Key' => $image,
//         ]);
//         $request1 = $s3Client->createPresignedRequest($cmd, '+60 minutes');
//         // Get the actual presigned-url
//         $presignedUrl = (string)$request1->getUri();
//         // dd($presignedUrl);
//         return $presignedUrl;
//       }

//     // public static function getS3ImageURL($image){

//     //     $s3Client = new \Aws\S3\S3Client([
//     //         'region'  => \Config::get('global.S3_AWS_REGION'),
//     //         'version' => 'latest',
//     //     ]);
//     //     // $s3Client = Storage::disk('s3')->getDriver()->getAdapter()->getClient();
//     //     $cmd = $s3Client->getCommand('GetObject', [
//     //         'Bucket' => \Config::get('global.S3_BUCKET_NAME'),
//     //         // Config::get('global.S3_BUCKET_NAME'),
//     //         'Key' => $image,
//     //     ]);
//     //     $request1 = $s3Client->createPresignedRequest($cmd, '+60 minutes');
//     //     // Get the actual presigned-url
//     //     $presignedUrl = (string)$request1->getUri();
//     //     //$presignedUrl = '';
//     //     return $presignedUrl;
//     //   }

    
   
   

//         public static function getPercentageReview($number, $totalReview){
//         if($totalReview > 0){
//            return round(($number * 100)/$totalReview, 2);
//         }
//         else
//         {
//            return 0;
//         }
//     }


//     public static function timeAgo($timestamp) {
//         $currentDateTime = new DateTime();
//         $givenDateTime = new DateTime($timestamp);
    
//         $interval = $currentDateTime->diff($givenDateTime);
        
//         if ($interval->y >= 1) {
//             return $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . ' ago';
//         } elseif ($interval->m >= 1) {
//             return $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . ' ago';
//         } elseif ($interval->d >= 1) {
//             return $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
//         } elseif ($interval->h >= 1) {
//             return $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
//         } elseif ($interval->i >= 1) {
//             return $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
//         } else {
//             return 'Just now';
//         }
//     }
     
//     // Example usage
//     // $timestamp = '2023-12-01 12:30:00'; // Replace with your timestamp
//     // echo timeAgo($timestamp);

   

    
     

   

    
}