<?php

namespace App\Http\Controllers;

use App\User;
use App\country;
use App\Promotion;
use App\AutoNotification;
use App\UserNotification;
use Illuminate\Http\Request;
use App\Events\NotificationEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserNotificationController extends Controller
{

    public function __construct()
    {
       $this->middleware('admin')->except(['destroy','getUserNotifications']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('dashboard.usernotification.index');
    }

    public function getUserCount(Request $request)
    {
        $conditions = [];
        if(!empty($request->all()['conditions']))
        $conditions = $request->all()['conditions'];
        
        $count = User::where($conditions)->get()->count();
        return response()->json($count, 200);
    }

    public function sendNotification(Request $request)
    {
        if($request->isMethod('post'))
        {
            $validation = [
                'subject' => 'required',
                'body' => 'required',
            ];
            if($request->to_target == 'single')
            {
                $validation['user_id'] = 'required'; 
            }
            $request->validate($validation);
            
            
            if($request->to_target == 'single')
            {
                $users  = User::where('id',$request->user_id)->get();
            } else{
                
                $conditions = [];
                if(!is_null($request->input('country_id')))
                array_push($conditions,['country_id','=',$request->input('country_id')]);
                if(!is_null($request->input('type')))
                array_push($conditions,['type','=',$request->input('type')]);
    
                $users  = User::where($conditions)->get();
            }
            $notifications = [];
            foreach ($users as $user) {
              array_push($notifications,
              [
                    'user_id' => $user->id,
                    'subject' => $request->input('subject'),
                    'body' => $request->input('body'),
              ]
            );
            }
            UserNotification::insert($notifications);
            foreach ($users as $user) {
                $data = ['subject'=>$request->input('subject'),'body'=>$request->input('body')];
                Mail::send('emails.notification',['data'=>$data], function($message) use ($user,$data)
                {
                    $message->from('info@tameenistore.com', 'tameenistore');
                    $message->subject($data['subject']);
                    $message->to($user->email);
                
                });
            
            }
            session()->flash('success','تم إرسال الرسالة بنجاح');
            return back();

        }
        $countries = country::where('status',1)->get();
        $users = User::whereNotIn('id',[auth()->user()->id])->get();
        return view('dashboard.usernotification.send',compact('countries','users'));
    }

  
    public function storeAutoNotification(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'body' => 'required',
            'purpose' => 'required',
            'to' => 'required',
        ]);
        
        $notification = $request->all();
        $notification['status'] = isset($notification['status'])? 'active'  : 'deactive';
        
        $current_notification = AutoNotification::where('purpose',$notification['purpose'])->get()->first();
        
        if(!is_null($current_notification))
        {
        $notification =  $current_notification->update($notification);
        session()->flash('success','تم حفط البيانات بنجاح');
        return back();
        }
        $notification = AutoNotification::create($notification);
        session()->flash('success','تم حفط البيانات بنجاح');
        return back();
    }

    public function promotionNotification(Request $request)
    {
        $promotions = Promotion::paginate();
        return view('dashboard.usernotification.promotions',compact('promotions'));
    }

    public function getUserNotifications()
    {
        $notifications  = UserNotification::where('user_id',auth()->user()->id)->paginate();
        UserNotification::where('user_id',auth()->user()->id)->update(['viewed'=>'1']);
        return view('dashboard.notifications.index',compact('notifications'));
 
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\UserNotification  $userNotification
     * @return \Illuminate\Http\Response
     */
    public function show($purpose)
    {
        if(!is_null($purpose))
        {
           $notification = AutoNotification::where('purpose',$purpose)->get()->first();
           if(!is_null($notification))
           return response()->json($notification, 200);
        }

        return response()->json([], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserNotification  $userNotification
     * @return \Illuminate\Http\Response
     */
    public function edit(UserNotification $userNotification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserNotification  $userNotification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserNotification $userNotification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserNotification  $userNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userNotification = UserNotification::where('id',$id);
        if(!$userNotification) abort(404);
        $userNotification->delete();
        return back();
    }
}
