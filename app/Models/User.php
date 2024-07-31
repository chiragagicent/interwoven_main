<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

  public static function getUsersDetails()
    {
       $userDetails = DB::table('users')
            ->join('users_address', 'users.user_id', '=', 'users_address.user_id')
            ->select(
                'users.name',
                'users.user_type',
                'users.user_id as userid',
                'users.email_id',
                'users.created_datetime',
                'users.profile_pic',
                'users_address.address',
                'users_address.city',
                'users_address.state',
                'users_address.zip_code',
                'users.is_blocked',
                DB::raw("CONCAT(users.country_code, ' ', users.phone_number) as contact_info")
            )
            ->get();
            
            $userTypeLabels = [
            1 => 'High School Students',
            2 => 'High School Professionals',
            3 => 'College Students',
            4 => 'College Professionals',
            5 => 'Parents/Caregivers'
        ];

        // Map user_type to labels
        foreach ($userDetails as $user) {
            $user->user_type_label = $userTypeLabels[$user->user_type] ?? 'Unknown';
        }

        return $userDetails;
            
    }
    public static function getUserDetails($id)
{
    $userDetails = DB::table('users')
        ->join('users_address', 'users.user_id', '=', 'users_address.user_id')
        ->where('users.user_id', $id)
        ->select(
            'users.name',
            'users.user_type',
            'users.user_id as userid',
            'users.email_id',
            'users.created_datetime',
            'users.profile_pic',
            'users.is_blocked',
            'users_address.address',
            'users_address.city',
            'users_address.state',
            'users_address.zip_code',
            DB::raw("CONCAT(users.country_code, ' ', users.phone_number) as contact_info")
        )
        ->first(); // Changed to `first()` to get a single object

    if (!$userDetails) {
        return null;
    }

    $userTypeLabels = [
        1 => 'High School Students',
        2 => 'High School Professionals',
        3 => 'College Students',
        4 => 'College Professionals',
        5 => 'Parents/Caregivers'
    ];

    // Map user_type to labels
    $userDetails->user_type_label = $userTypeLabels[$userDetails->user_type] ?? 'Unknown';

    return $userDetails;
}
public static function getUserSearchData($searchIn, $searchType, $suggestionText , $startDate, $endDate, $limitFlag,$userType)
{
  $response = DB::table('users')
              ->join('users_address', 'users.user_id', '=', 'users_address.user_id')
              ->select(
                  'users.name',
                  'users.email_id',
                  'users.created_datetime',
                  'users.user_id as userid',
                  'users.user_type',
                  'users_address.address',
                  'users.is_blocked',
                  DB::raw("CONCAT(users.country_code, ' ', users.phone_number) as contact_info")           
              );
            
  /*  if ($userType) {
        $response->where('users.user_type', $userType);
    }  */
  for ($i = 0; $i < count($searchIn); $i++) {
      if ($searchIn[$i] == 'block_flag') {
          if ($isVerified[$i] != 'Any') {
              $response = $response->where('is_verified', $isVerified[$i]);
          }
      }
      if ($searchIn[$i] == 'created_datetime') {
          if ($startDate[$i] != '' && $endDate[$i] != '') {
              $response = $response->whereBetween('users.created_datetime', [$startDate[$i], $endDate[$i]]);
          }
      } elseif($searchIn[$i] == 'name') {
          if ($searchType[$i] == 'contains' && $suggestionText[$i] != '') {
              $response = $response->where('name', 'LIKE', '%' . $suggestionText[$i] . '%');
          }
          if ($searchType[$i] == 'begins_with' && $suggestionText[$i] != '') {
              $response = $response->where('name', 'LIKE', $suggestionText[$i] . '%');
          }
          if ($searchType[$i] == 'exact_match' && $suggestionText[$i] != '') {
              $response = $response->where('name', '=', $suggestionText[$i]);
          }
          if ($searchType[$i] == 'ends_with' && $suggestionText[$i] != '') {
              $response = $response->where('name', 'LIKE', '%' . $suggestionText[$i]);
          }
      }  elseif($searchIn[$i] == 'user_type') {

          if ($userType[$i] != 'Any') {
              $response = $response->where('user_Type', '=', $userType[$i]);
          }
  
          }else {
          if ($searchType[$i] == 'contains' && $suggestionText[$i] != '') {
              $response = $response->where($searchIn[$i], 'LIKE', '%' . $suggestionText[$i] . '%');
          }
          if ($searchType[$i] == 'begins_with' && $suggestionText[$i] != '') {
              $response = $response->where($searchIn[$i], 'LIKE', $suggestionText[$i] . '%');
          }
          if ($searchType[$i] == 'exact_match' && $suggestionText[$i] != '') {
              $response = $response->where($searchIn[$i], '=', $suggestionText[$i]);
          }
          if ($searchType[$i] == 'ends_with' && $suggestionText[$i] != '') {
              $response = $response->where($searchIn[$i], 'LIKE', '%' . $suggestionText[$i]);
          }
      }

  }

  $response = $response
              ->limit($limitFlag)
              ->orderBy('userid', 'DESC')
              ->get();
    
              $userTypeLabels = [
            
                1 => 'High School Students',
                2 => 'High School Professionals',
                3 => 'College Students',
                4 => 'College Professionals',
                5 => 'Parents/Caregivers'
            ];
            
            // Map user_type to labels
            foreach ($response as $user) {
                $user->user_type_label = $userTypeLabels[$user->user_type] ?? 'Unknown';
            }
  
  return $response;
}


}
