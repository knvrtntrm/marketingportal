<?php

namespace App\Http\Controllers;

use App\Drukwerk;
use App\Notification;
use App\UploadedFile;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;



class DrukwerkController extends Controller
{

    public function getAllDrukwerkForUser(){
        return Drukwerk::where('user_id',Auth::user()->id)->get();
    }

    
    public function getDrukwerkDetail($id){
        $drukitem = Drukwerk::where('id',$id)->first();
        $drukitem->client;
        $drukitem->state;
        return $drukitem;
    }


    public function saveRequest(Request $request){

        $newrequest = new Drukwerk();
        $newrequest->user_id = Auth::user()->id;
        $newrequest->type = $request->type;
        $newrequest->amount = $request->aantal;
        if($request->formaat)
            $newrequest->size = $request->formaat;
        if($request->color)
            $newrequest->color = $request->color;
        if($request->druktype)
            $newrequest->presstype = $request->druktype;
        if($request->digitaal)
            $newrequest->digital = $request->digitaal;
        if($request->enkeldigitaal)
            $newrequest->onlydigital = $request->enkeldigitaal;
        $newrequest->extra = $request->extra;
        $newrequest->purpose = $request->doel;
        $newrequest->status = 1;
        $newrequest->deadline = $request->end_date;
        $newrequest->save();

        if(Input::hasFile('inputFiles')){
            foreach(Input::file('inputFiles') as $thefile){

                $file = new UploadedFile();
                $file->name = "".$thefile->getClientOriginalName();
                $file->description = $newrequest->purpose;
                $file->user_id = Auth::user()->id;
                $file->drukwerk_id = $newrequest->id;
                $file->save();

                //$thisfile = UploadedFile::orderby('created_at','DESC')->first();

                $destinationPath = storage_path()."/drukwerk/".Auth::user()->id."/";
                $fileName = $thefile->getClientOriginalName();

                $thefile->move($destinationPath, $fileName);

            }
        }

        $users = User::where('admin',1)->get();

        foreach($users as $user)
        {
            $notification = new Notification();
            $notification->message = Auth::user()->name." heeft een aanvraag ingediend voor een ".$request->type;
            $notification->client_id = $user->id;
            $notification->read = 0;
            $notification->save();
        }

        return redirect('/#drukwerk');

    }
}
