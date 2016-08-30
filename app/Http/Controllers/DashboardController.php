<?php

namespace App\Http\Controllers;

use App\Emailhandtekening;
use App\Logo;
use App\Notification;
use App\PromoItem;
use App\PromoRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\ItemsRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Jobs\SendOrderReadyConfirmationEmail;
use App\Jobs\SendPromoOrderReadyConfirmationEmail;


class DashboardController extends Controller
{

    public function setLocale($lang){
        setLocale($lang);
    }

    public function getAllRequests(){

        $requests = [];

        $reqs = ItemsRequest::where('client_id',Auth::user()->id)->orderBy('created_at', 'DESC')->get();

        foreach($reqs as $req)
        {
            $req->inventoryitems;
            $req->client;
            $req->state;
            $requests[] = $req;
        }

        return $requests;
    }

    public function getAllRequestsForApp(){

        $requests = [];

        $reqs = ItemsRequest::where('status',1)->orderBy('created_at', 'DESC')->get();

        foreach($reqs as $req)
        {
            $req->inventoryitems;
            $req->client;
            $req->state;
            $requests[] = $req;
        }

        return $requests;
    }

    public function getAllPromoRequests(){

        $requests = [];

        $reqs = PromoRequest::where('client_id',Auth::user()->id)->orderBy('created_at', 'DESC')->get();

        foreach($reqs as $req)
        {
            $req->promoitems;
            $req->client;
            $req->state;
            $requests[] = $req;
        }

        return $requests;

    }

    public function getAllPromoRequestsForApp(){

        $requests = [];

        $reqs = PromoRequest::where('status',1)->orderBy('created_at', 'DESC')->get();

        foreach($reqs as $req)
        {
            $req->promoitems;
            $req->client;
            $req->state;
            $requests[] = $req;
        }

        return $requests;

    }

    public function promoUpdate($code){

        $req = PromoRequest::where('id',$code)->first();
        $req->status = 3;
        $req->save();

        $notification = new Notification();
        $notification->client_id = $req->client_id;
        $notification->code = $code;
        $notification->message = "Promo aanvraag KVRT".$code." staat klaar voor verzending";
        $notification->read = 0;
        $notification->save();

        $this->dispatch(new SendPromoOrderReadyConfirmationEmail($req));

        return $req;

    }

    public function beursUpdate($code){
        $req = ItemsRequest::where('id',$code)->first();
        $req->status = 3;
        $req->save();

	    $notification = new Notification();
        $notification->client_id = $req->client_id;
        $notification->code = $code;
        $notification->message = "Beurs aanvraag KVRT".$code." staat klaar voor verzending";
        $notification->read = 0;
        $notification->save();

        $this->dispatch(new SendOrderReadyConfirmationEmail($req));

        return $req;
    }

    ///// EMAILHANDTEKENINGEN

    public function getEmailSignaturesForOffice(){
        $data = Emailhandtekening::where('user_id',Auth::user()->id)->get();
        $signatures = [];

        foreach($data as $sign)
        {
            $sign->funct;
            $signatures[] = $sign;
        }

        return $signatures;
    }

    public function saveEmailSignatureForOffice(Request $request){
        return Emailhandtekening::create($request->all());
    }

    public function removeEmailsignatureForOffice($sign_id){
        $signature = Emailhandtekening::where('id',$sign_id)->first();
        $file_name = $signature->image.".jpg";
        Storage::disk('signatures')->delete($file_name);
        $signature->delete();
    }

    public function saveSignatureImage(Request $request){
        $data = $request->image;
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
        file_put_contents(public_path().'/images/signatures/'.$request->filename.'.jpg',$data);
        Storage::disk('signatures')->put($request->filename.'.jpg',$data);
        return 'done';
    }

    public function downloadSignature($image){

        $file_path = storage_path()."/emailhandtekeningen/".$image.".jpg";
        $filename = "emailhandtekening_".$image.".jpg";

        $headers = array(
            "Content-Description" => "File Transfer",
            "Content-Disposition" => "attachment; filename=" . $filename,
            'content-type' => 'image/jpg'
        );

        return Response::download($file_path, $filename, $headers);

    }

    ////// LOGOS

    public function getLogos(){
        return Logo::all();
    }

    public function downloadLogo($image){

        $file_path = storage_path()."/logos/".$image;
        $filename = $image;

        $headers = array(
            "Content-Description" => "File Transfer",
            "Content-Disposition" => "attachment; filename=" . $filename
        );

        return Response::download($file_path, $filename, $headers);

    }

    public function getPromoRequestDetail($id){

        $req = PromoRequest::where('id',$id)->first();
        $req->promoitems;
        $req->client;
        $req->state;

        return $req;
    }

    public function getBeursRequestDetail($id){

        $req = ItemsRequest::where('id',$id)->first();
        $req->inventoryitems;
        $req->client;
        $req->state;

        return $req;
    }

    public function getNotifications(){
        return Notification::where('client_id',Auth::user()->id)->where('read',0)->get();
    }

    public function markNotificationAsRead($id){
        $notification = Notification::where('id',$id)->first();
        $notification->read = 1;
        $notification->save();
        return "Marked as read";
    }

    public function clearNotificationsList(){
        $nots = Notification::where('client_id',Auth::user()->id)->where('read',0)->get();
        foreach($nots as $not){
            $not->read = 1;
            $not->save();
        }
        return "LIST CLEARED";
    }

    public function changePassword(Request $request){
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();
    }

}
