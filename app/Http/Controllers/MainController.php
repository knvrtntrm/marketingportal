<?php

namespace App\Http\Controllers;

use App\InventoryItem;
use App\Location;
use App\PromoItem;
use App\PromoRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\ItemsRequest;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendPromoOrderConfirmationEmail;
use App\Jobs\SendOrderConfirmationEmail;
use Mail;

class MainController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('app');
    }

    public function getUserData(){
        return Auth::user();
    }

    public function getInventoryItems(){
        $user = $this->getUserData();
        $data = [];

        $items = InventoryItem::where('firma','=',$user->firma)->where('amount','>',0)->get();

        foreach($items as $item)
        {
            $item->client;
            $item->condition;
            $data[] = $item;
        }

        return $data;
    }

    public function getPromoInventoryItems(){

        $user = $this->getUserData();

        return PromoItem::whereIn('section', [$user->section,'ALL'])->where('amountinstock',">",0)->get();

    }

    public function getAllPromoItems(){
        return PromoItem::all();
    }

    public function getAllBeursItems(){
        return InventoryItem::all();
    }

    public function changeItemAmountNegative(Request $request){
        $data = $request->all();
        $item = InventoryItem::where('code','=',$data[0])->first();
        $item->amount -= $data[1];
        $item->save();
    }

    public function changePromoItemAmountNegative(Request $request){
        $data = $request->all();
        $item = PromoItem::where('code','=',$data[0])->first();
        $item->amountinstock -= $data[1];
        $item->save();
    }

    public function changeItemAmountPositive(Request $request){
        $data = $request->all();
        $item = InventoryItem::where('code','=',$data[0])->first();
        $item->amount += $data[1];
        $item->save();
    }

    public function changePromoItemAmountPositive(Request $request){
        $data = $request->all();
        $item = PromoItem::where('code','=',$data[0])->first();
        $item->amountinstock += $data[1];
        $item->save();
    }

    public function saveRequest(Request $request){

        $data = $request->all();

        $req = new ItemsRequest();
        $req->client_id = Auth::user()->id;
        $req->comment = $data['comment'];
        $req->locatie = $data['locatie'];
        $req->datum = $data['datum'];
        $req->status = 1;
        $req->save();

        for($i = 0;$i<count($data['requests']);$i++)
        {
            $inventoryitem = $data['requests'][$i]['id'];

            if (array_key_exists('amountordered', $data['requests'][$i])){
                $amount = $data['requests'][$i]['amountordered'];
            }else{
                $amount = 1;
            }

            $req->inventoryitems()->attach($inventoryitem, ['amount' => $amount]);
        }

        $this->dispatch(new SendOrderConfirmationEmail($req));

    }

    public function savePromoRequest(Request $request){

        $data = $request->all();

        $req = new PromoRequest();
        $req->client_id = Auth::user()->id;
        $req->comment = $data['comment'];
        $req->status = 1;
        $req->price = $data['price'];
        $req->save();

        for($i = 0;$i<count($data['requests']);$i++)
        {
            $promoitem = $data['requests'][$i]['id'];

            if (array_key_exists('amountordered', $data['requests'][$i])){
                $amount = $data['requests'][$i]['amountordered'];
            }else{
                $amount = 1;
            }

            $req->promoitems()->attach($promoitem, ['amount' => $amount]);
        }

        $this->dispatch(new SendPromoOrderConfirmationEmail($req));

    }

    public function updateBudget(Request $request){
        $data = $request->all();

        $user = Auth::user();
        $user->budget -= $data['price'];
        $user->save();
    }

}


