<?php

namespace App\Http\Controllers\Api;

use App\Agents;
use App\DocumentsUser;
use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;


class AuthController extends Controller
{
    use GeneralTrait;

    public function register(Request $request)
    {
        try{
            $rules=[
                'user_name' => 'required|min:3|max:15',
                'country_id' => 'required|integer|min:0',
                'email' => 'required|unique:users,email',
                'password' => 'required',
                'user_type' => 'required|int|min:0',
            ];
            $validator=Validator::make($request->all(),$rules);

            if($validator->fails()){
                $code=$this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
            }
            $newUser = new User();
            $newUser->name = $request->user_name;
            $newUser->email = $request->email;
            $newUser->country_id = $request->country_id; //normal person
            $newUser->password = bcrypt($request->password);
            $newUser->save();
            if($request->user_type == 0)
            {
                $newUser->type = 0 ; //normal person
                $newUser->country_id = $request->country_id; //normal person
                $newUser->save();
                $agent = new \App\Agents();
                $agent->user_id = $newUser->id;
                $agent->country_id = $request->country_id;
                $agent->agent_type = 2;
                $agent->save();
                return $this->returnData('user',$newUser);
            }
            else if ($request->user_type == 4){
                $newUser->type = 4;
                $newUser->save();
                $insurance = new \App\Insurance();
                //sondos edit insurace to insurance 6/11
                $insurance->country_id = $request->country_id;
                $insurance->user_id = $newUser->id;
                $insurance->ar_name = $request->ar_name;
                $insurance->en_name = $request->en_name;
                $insurance->ar_address = $request->ar_address;
                $insurance->en_address = $request->en_address;
                $insurance->phones = $request->phones;
                $insurance->website = $request->website;
                $insurance->email = $request->email;
                //$insurace-> = $request->google_map;
                $insurance->days_on = $request->days_on;
                $insurance->times_on = $request->times_on;
                $insurance->visitors = 0;
                $insurance->status = 1;
                $insurance->special = 1;

                $insurance->save();
                return $this->returnData('user',$newUser);

            }
            else
                {   if ($request->user_type == 2) $newUser->type = 2 ; //car_sale
                    else $newUser->type = 3 ;
                    $newUser->save();
                    $agent = new \App\Agents();
                    $agent->user_id = $newUser->id;
                    $agent->country_id = $request->country_id;
                    $agent->en_name = $request->en_name;
                    $agent->ar_name = $request->ar_name;
                    $agent->ar_address = $request->ar_address;
                    $agent->en_address = $request->en_address;
                    $agent->phones = $request->phones;
                    $agent->website = $request->website;
                    //$insurace-> = $request->google_map;
                    $agent->days_on = $request->days_on;
                    $agent->times_on = $request->times_on;
                    if ($request->user_type == 2) $agent->agent_type = 0;
                    else $agent->agent_type = 1;
                    $agent->save();

                    return $this->returnData('user',$newUser);
                }


        }//end try
        catch(\Exception $ex){
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }//end cach

    }//end register

    public function login(Request $request)
    {
        try{
            $rules=[
                'email'=>'required|exists:users,email',
                'password'=>'required'
            ];
            $validator=Validator::make($request->all(),$rules);

            if($validator->fails()){
                $code=$this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
            }
            //login
            $credentials =$request->only(['email','password']);

            $token=Auth::guard('api')->attempt($credentials);
            if(!$token){
                return $this->returnError('','بيانات الدخول غير صحيحة');
            }

            $admin=Auth::guard('api')->user();
            $admin->token=$token;
            return $this->returnData('user',$admin);

        }//end try
        catch(\Exception $ex){

            return $this->returnError($ex->getCode(),$ex->getMessage());

        }//end cach


    }//end login

    public function me(Request  $request)
    {
        $token = $request->header('auth-token');
        if ($token) {
            try {
                $admin = Auth::guard('api')->user();
                $admin->token = $token;
                return $this->returnData('user', $admin);
            } catch (TokenInvalidException $e) {
                return $this->returnError('', 'some thing wrong');
            }

        }
    }//end fun

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request  $request)
    {
         $token=$request->header('auth-token');
        if ($token){
            try{
            JWTAuth::setToken($token)->invalidate(); }
            catch(TokenInvalidException $e){
           return $this->returnError('','some thing wrong');
            }
            return $this->returnSuccessMessage('logged out successfully');
        }
        else return $this->returnError('','some thing wrong');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $refresh_token=$this->respondWithToken(auth()->guard('api')->refresh());
        return $this->returnData('admin',$refresh_token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->guard('api')->user()
        ]);
    }

    public function getUser($id){
        $user=User::with(['userDocs','agentDetails'])->where('id',$id)->first();

        return $this->returnData('user',$user);
    }

    public function updateAgency(Request  $request){
        $user = auth()->guard('api')->user();
        if ($user->type==2||$user->type==3){
        $rules=[
            'country_id'=>'required|exists:countries,id',
            'en_name'=>'required',
            'ar_name'=>'required',
            'en_address'=>'required',
            'ar_address'=>'required',
            'phones'=>'required',
//            'image'=>'required|image|max:5000',
            'fb_page'=>'required|url',
            'instagram'=>'required|url',
            'twitter_page'=>'required|url',
            'website'=>'required|url',
            'email'=>'required|email',
            'days_on'=>'required',
            'times_on'=>'required',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $row=Agents::where('user_id',$user->id)->first();
        if ($row){
            $row->update($request->except('image'));
            if($request->file('image')){
                $imageName = rand().time().'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('uploads'), $imageName);
                $row->image = $imageName;
                $row->save();
            }
            return $this->returnSuccessMessage('success');
        }else return $this->returnError(99,'this user not found');
        }else return $this->returnError(99,'هذا المستخدم ليس وكاله تأجير او بيع ');

    }//end fun

    public function updateUserDetails(Request  $request){
        $user = auth()->guard('api')->user();
            $rules=[
                'name'=>'required',
                'email'=>'required|email|unique:users,email,'.$user->id,
                'password'=>'sometimes:nullable|min:6',
                'image'=>'sometimes:nullable|image|max:5000',
                'phones'=>'required',
            ];
            $validator=Validator::make($request->all(),$rules);
            if($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $row=User::where('id',$user->id)->first();
            if ($row){
                $row->update($request->except(['image','password']));
                if($request->file('image')){
                    $imageName = rand().time().'.'.request()->image->getClientOriginalExtension();
                    request()->image->move(public_path('uploads'), $imageName);
                    $row->image = $imageName;
                }
                if($request->password){
                    $row->password=bcrypt($request->password);
                }
                $row->save();
                return $this->returnSuccessMessage('success');
            }
            else return $this->returnError(99,'this user not found');

    }//end updateUserDetails



}
