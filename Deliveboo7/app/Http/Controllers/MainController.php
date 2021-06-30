<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Type;
use App\User;
use App\Order;


class MainController extends Controller
{
  public function main(){

    $types = Type::all();
    // $users = User::all();
    $users = User::inRandomOrder()
                        -> limit(6)
                        -> get();
    $user = Auth::user();

    return view('pages.main', compact('types','users', 'user'));
  }

  public function restaurant($id){

    $user = User::findOrFail($id);
    return view('pages.showRestaurant', compact('user'));
  }

  public function createOrder(Request $request, $carrello)
  {
      // dd($request-> all(), $carrello );
      $totalPrice= $request->totalPrice;
      // dd($totalPrice, $carrello);
      return view('pages.createOrder', compact('totalPrice','carrello'));
  }

  public function storeOrder(Request $request, $carrello) {
      // dd($request->all(), $carrello);
      $carrelloArray= explode(',', $carrello);
      $carrelloNum= [];
      foreach ($carrelloArray as $dish) {
          $carrelloNum[]= intval($dish);
      }
      // dd($carrelloNum);
      $validated = $request -> validate([
          'nome_cliente' => 'required|string|min:3',
          'cognome_cliente' => 'required|string|min:3',
          'via' => 'required|string|min:3',
          'n_civico' => 'required|string',
          'citta' => 'required|string',
          'cap' => 'required|string',
          'telefono' => 'required|string|min:3',
          'note' => 'max:255',
          'totalPrice' =>'required',
      ]);
      // dd($request->totalPrice);

      $order = Order::make($validated);
      $order -> save();

      foreach ($carrelloNum as $dish) {
          // dd($dish);
          $order -> dishes() -> attach($dish);
          $order -> save();
      }
      // $order -> dishes() -> attach('dish_id'); //DA FAR FUNZIONARE


      $totalPrice = $request->totalPrice;


      return redirect() -> route('pay', compact('totalPrice', 'order'));
  }

  //chi chiSiamo
  public function chiSiamo(){

    return view('pages.chiSiamo');
  }



}
