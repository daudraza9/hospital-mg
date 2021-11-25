<?php

namespace App\Http\Controllers;

use App\Models\Nurse;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Laravel\Cashier\Checkout;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
use Laravel\Cashier\Cashier;

class PaymentController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = Auth::user();
        return view('payment.show',[
            'intent'=>$user->createSetupIntent(),

        ]);
    }

    public function create(Request $request)
    {
        $user = auth()->user();
            Validator::make($request->all(),[
                'name'=>'required|regex:/^[a-zA-Z]+$/u|min:3|max:10',
                'amount'=>'required'
            ])->validate();

            $user->addPaymentMethod($request->stripeToken);
            $user->charge(
                $request->amount *100, $request->stripeToken,
            );

            return response()->json(['success'=>true,'message','Payment added']);
    }
    public function subscribe(Request $request){
        $user = Auth::user();
        return view('payment.subscribe',[
            'intent'=>$user->createSetupIntent()]);
    }
    public function Addsubscription(Request $request){
        $user = Auth::user();
        $user->newSubscription(
            'Cashier', $request->plan
        )->create($request->stripeToken);

        return response()->json(['success'=>true,'message','Subscription added']);
    }

    public function ecommerceIndex(Request $request){
        $products =Product::Paginate(6);
        return view('payment.e-commerce',
            compact('products'));
    }

    public function indexs(){
        return view('payment.index');
    }
    public function addProduct(Request $request){
        return view('payment.addProduct');
    }
    public function storeProduct(Request $request){

       Validator::make($request->all(),[
        'name'=>'required|regex:/^[a-zA-Z]+$/u|min:3|max:10',
         'discription'=>'required',
           'price'=>'required',
           'image'=>'image|mimes:jpeg,png,jpg,gif,svg'
       ])->validate();

      $product = Product::create([
           'name'=> $request->name,
           'discription'=>$request->discription,
           'price'=>$request->price,
       ]);

        if($request->hasFile('image') && $request->file('image')->isValid())
        {
            $product->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return response()->json(['success' => true, 'message' => 'Product Added']);
    }
    public function datatable(Request $request){
       $data = Product::all();
        if (request()->ajax()) {
            return datatables()->of($data)
                ->addColumn('image',function ($data){
                    $url = $data->getFirstMediaUrl('image','thumb');
                    return '<img src="'.$url.'" width="40" height ="40"/> ';
                })
                  ->addColumn('action', function ($data) {
                    $button = '<div style="width: 180px;"><a href=""> <button type="button" name="edit" id="" class="mr-1 edit btn btn-primary btn-sm">Edit</button></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="#" onclick="deleteProduct('.$data->id.')" id="" ><button type="button" name="delete" id="" class="delete btn btn-danger btn-sm">Delete</button></a></div>';
                    return $button;
                })
                ->rawColumns(['image','action'])
                ->make(true);
        }

    }
    public function delete(Request $request){
        $product = Product::findorfail($request->id);
        $product->delete();
        return response()->json(['success' => true, 'message' => 'Product Deleted']);
    }
    public function cart(Request $request){
        $user = Auth::user();
        return view('payment.cart',[
            'intent'=>$user->createSetupIntent()]);
    }

    public function addToCart(Request $request,$id){

        $product = Product::findOrFail($id);
        $cart = session()->get('cart',[]);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        }else{
            $cart[$id]=[
                'name'=>$product->name,
                'quantity'=>1,
                'price'=>$product->price,
                'image'=>$product->getFirstMediaUrl('image','thumb')
            ];
        }
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }

    public function madePayment(Request $request){

       $stripe=  Stripe::setApiKey(env('STRIPE_SECRET'));
        $user = auth()->user();
//        Validator::make($request->all(),[
//            'name'=>'required|regex:/^[a-zA-Z]+$/u|min:3|max:10',
//            'amount'=>'required'
//        ])->validate();

            $chekout = \Stripe\Checkout\Session::create([
                'payment_method_types' => [
                    'card'
                ],
                'line_items' =>[[
                    'name'=>$request->name,
                    'amount'=>$request->amount * 100,
                    'currency'=>'usd',
                    'quantity'=>1,
                    'description'=>'Product Payment',
                ]],
                'payment_intent_data' => [
                    'setup_future_usage' => 'off_session',
                ],
                'mode'=>'payment',
                'success_url'=>'http://local.hospital/payment/ecommerceIndex',
                'cancel_url'=>'http://local.hospital/product/cart',
            ]);

        return response()->json(['success'=>true,'message'=>'Payment Made Successfully']);

//        $user->addPaymentMethod($request->stripeToken);
//        $user->charge(
//           $request->amount *100, $request->stripeToken,
//        );
//
//  session()->forget('cart');
//        return response()->json(['success'=>true,'message','Payment added']);
    }
}
