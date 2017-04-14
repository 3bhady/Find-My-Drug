<?php

namespace App\Http\Controllers;

use App\PharmacyForm;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class NotificationController extends Controller
{
    public function getIndex()
    {
        return view('notification');
    }
    public function poll()
    {
        
            $pharmaciesForms = PharmacyForm::where('mobile', '1113205833');
            $count = $pharmaciesForms->count();

            $response = [
                "count" => $count
            ];
            return response()->json($response, 200);


    }
    public function postNotify(Request $request)
    {
        $notifyText = e($request->input('notify_text'));
        $socketId=$request->input('socket_id');
        $pusher = App::make('pusher');

        $pusher->trigger( 'test-channel',
            'test-event',
            array('text' =>$notifyText,'socketId'=>$socketId));

        // TODO: Get Pusher instance from service container

        // TODO: The notification event data should have a property named 'text'

        // TODO: On the 'notifications' channel trigger a 'new-notification' event
    }
}
