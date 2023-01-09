<?php

namespace App\Http\Controllers\Auth;

use App\Center;
use App\Division;
use App\EmployeeDivisionCenter;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';








    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

/**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $field = $this->field($request);
        $userExists = User::where($field, $request->get($this->username()))->exists();
        if(!$userExists){
            toastr()->error('Yor are not registered in this software. Please contact to HR.');
            redirect()->back();
        }

        return [
            $field => $request->get($this->username()),
            'password' => $request->get('password'),
        ];
    }
    /**
     * Determine if the request field is email or username.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function field(Request $request)
    {
        $email = $this->username();
        return filter_var($request->get($email), FILTER_VALIDATE_EMAIL) ? $email : 'employer_id';
    }

    public function callAPI($method, $url, $data){
        $curl = curl_init();
        switch ($method){
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'APIKEY: 111111111111111111111',
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        return $result;
    }

    private function getIp(){
        $externalContent = file_get_contents('http://checkip.dyndns.com/');
        preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
        $externalIp = $m[1];
        return $externalIp;
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // $user->update([
        //     'last_login_at' => Carbon::now()->toDateTimeString(),
        //     'last_login_ip' => json_decode($this->callAPI('GET', 'http://api.ipify.org/?format=json', false))->ip,
        // ]);
        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $this->getIp(),
        ]);

        if ($user->hasAnyRole(['User']) ) {
            $request->session()->put('validateRole', 'User');
            $center_division = EmployeeDivisionCenter::where('employee_id', auth()->user()->employee_id)->first();
            $division = Division::whereId($center_division->division_id)->first();
            $center = Center::whereId($center_division->center_id)->first();
            if($division && $center){
                $request->session()->put('division', $division->name);
                $request->session()->put('center', $center->center);
            }
            return redirect()->route('user.dashboard');
        }
        elseif (!$user->hasAnyRole(['User']) ) {
            $request->session()->put('validateRole', 'Admin');
            $division = Division::whereId($user->default_division_id)->first();
            $center = Center::whereId($user->default_center_id)->first();
            if($division && $center){
                $request->session()->put('division', $division->name);
                $request->session()->put('center', $center->center);
            }

            return redirect()->route('dashboard');
        }
    }
}
