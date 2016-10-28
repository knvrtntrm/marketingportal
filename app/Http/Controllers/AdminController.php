<?php

namespace App\Http\Controllers;

use App\Drukwerk;
use App\Emailhandtekening;
use App\ItemsRequest;
use App\Notification;
use App\PromoRequest;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\UploadedFile;
use Illuminate\Support\Facades\Response;
use App\User;
use \Illuminate\Support\Facades\Hash;
use App\Jobs\SendSignatureConfirmationEmail;

/**
 * Class AdminController
 * @package App\Http\Controllers
 */
class AdminController extends Controller {

    /**
     *
     */
    public function __construct() {
        $this->middleware('admin');
    }

    // AANVRAGEN

    /**
     * @return array
     */
    public function allPromoRequests() {
        $requests = [];

        $reqs = PromoRequest::orderBy('created_at', 'DESC')->get();

        foreach ($reqs as $req) {
            $req->promoitems;
            $req->client;
            $req->state;
            $requests[] = $req;
        }

        return $requests;
    }

    /**
     * @return array
     */
    public function allBeursRequests() {
        $requests = [];

        $reqs = ItemsRequest::orderBy('created_at', 'DESC')->get();

        foreach ($reqs as $req) {
            $req->inventoryitems;
            $req->client;
            $req->state;
            $requests[] = $req;
        }

        return $requests;
    }

    // EMAILHANDTEKENINGEN

    public function getAllSignatures() {
        $newsigns = [];
        $signs = Emailhandtekening::where('approved', 0)->get();

        foreach ($signs as $sign) {
            $sign->funct;
            $newsigns[] = $sign;
        }

        return $newsigns;
    }

    public function approveSignature($id) {
        $signature = Emailhandtekening::where('id', $id)->first();
        $signature->approved = 1;
        $signature->save();

        $notification = new Notification();
        $notification->client_id = $signature->user_id;
        $notification->message = "Emailhandtekening '" . $signature->name . "' Goedgekeurd";
        $notification->read = 0;
        $notification->save();

        $user = User::where('id',$signature->user_id)->first();

        $email = $user->email;
        $name = $signature->name;

        $this->dispatch(new SendSignatureConfirmationEmail($email,$name));

        return 'Signature approved';
    }

    public function declineSignature($id) {
        Emailhandtekening::where('id', $id)->first()->delete();
        return 'Signature declined and removed';
    }

    public function getAllDrukwerk() {
        $d = Drukwerk::where('finished', 0)->where('deleted', 0)->get();

        $drukwerk = [];

        foreach ($d as $druk) {
            $druk->client;
            $drukwerk[] = $druk;
        }

        return $drukwerk;
    }

    public function drukwerkFinished($id) {
        $drukwerk = Drukwerk::where('id', $id)->first();
        $drukwerk->finished = 1;
        $drukwerk->status = 3;
        $drukwerk->save();
        return 'FINISHED';
    }

    public function removeDrukwerk($id) {
        $drukwerk = Drukwerk::where('id', $id)->first();
        $drukwerk->deleted = 1;
        $drukwerk->save();
        return 'REMOVED';
    }

    public function getFilesForDrukwerk($id) {
        return UploadedFile::where('drukwerk_id', $id)->get();
    }

    public function downloadFile($filename) {

        $file = UploadedFile::where('name', $filename)->first();
        $id = $file->user_id;

        $file_path = storage_path() . "/drukwerk/" . $id . "/" . $filename;
        $filename = "drukwerk_" . $file->name . "_" . $id . "_" . $filename;

        $headers = array(
            "Content-Description" => "File Transfer",
            "Content-Disposition" => "attachment; filename=" . $filename
        );

        return Response::download($file_path, $filename, $headers);
    }
    
    // USERS

    public function getAllUsers(){
        return User::all();
    }
    
    public function updateUser(Request $request){

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->budget = $request->budget;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->phone = $request->phone;
        $user->fax = $request->fax;
        $user->postalcode = $request->postalcode;
        $user->save();
        return $user;
    }

    public function removePromoItem($id){
        $item = PromoRequest::find($id);
        $item->delete();
    }

    public function removeBeursItem($id){
        $item = ItemsRequest::find($id);
        $item->delete();
    }
    
    // LIJST VO BRECHT

    public function getAllInfoInList($section) {

        $allInfo = [];

        $users = \App\User::where('admin', 0)->where('firma', 'Konvert')->where('section',$section)->get();

        foreach ($users as $user) {
            $user->orders;
            $allInfo[$user->id] = $user;
        }

        return view('pages.lijst')->with('list', $allInfo);
    }

    public function removePromoItemFromOrder($order_id,$item_id){

        $order = PromoRequest::find($order_id);
        $client = User::find($order->client->id);
        $promoitem = $order->promoitems->filter(function($item) use ($item_id) {
            return $item->id == $item_id;
        })->first();

        if($promoitem->pivot->amount > 1){
            $order->promoitems()->updateExistingPivot($item_id, ['amount' => $promoitem->pivot->amount - 1]);
        }else if ($promoitem->pivot->amount <= 1){
            $order->promoitems()->detach($item_id);
        }

        $client->budget += $promoitem->price;
        $order->price -= $promoitem->price;
        
        $order->save();
        $client->save();

        if($order->promoitems()->count() == 0)
        {
            $order->delete();

            return 'remove';
        }

        return $order;
    }

    public function removeBeursItemFromOrder($order_id,$item_id)
    {
        $order = ItemsRequest::find($order_id);
        
        $order->inventoryitems()->detach($item_id);

        if($order->inventoryitems()->count() == 0)
        {
            $order->delete();
            return 'remove';
        }

        return $order;
    }

}
