@extends('layouts.main-layout')

@section('content')
    <div id="app" v-cloak>

        <div id="showRestaurant">
            <div class="mycontainer relative">

                {{-- carrello icona --}}
                <div class="cart flex_center absolute" @click="showCart" title="Vai al tuo Ordine">
                    <img src="{{ asset('/storage/images/shopping-cart.png') }}" alt="carrello" class="relative">

                    <div v-if='cartItems > 0' class="cart_count flex_center absolute animate__animated animate__shakeY">
                        <span>@{{ cartItems }}</span>
                    </div>
                </div>

                {{-- carrello aperto --}}
                <div class="opened_cart flex_col animate__animated animate__fadeInRight" :hidden="cartHidden">

                    <h3>Il tuo ordine</h3>
                    <h4>Ristorante: {{ $user->nome_attivita }}</h4>
                    <h5>Totale prodotti: @{{ cartItems }} </h5>

                    <ul>
                        <li v-for='(dish, index) in carrello'>
                            <h6>@{{ dish . nome }}</h6>
                            <p>Prezzo: <b>@{{ carrello[index] . prezzo * carrello[index] . counter }} €</b></p>
                            {{-- <p>Quantità: <b>@{{ dish . counter }}</b></p> --}}
                            <p class="flex_center">
                                <i class="fas fa-minus" @click='decrease(dish.id, index)'></i>
                                <span>Quantità: <b>@{{ dish . counter }}</b></span>

                                <i class="fas fa-plus" @click='increase(dish.id, index)'></i>
                            </p>
                        </li>
                        <li>
                            <h5>Totale: @{{ totalPrice }} €</h5>
                        </li>

                    </ul>

                    <form class="flex_center" :action="'/createOrder/' + carrelloID" method="post">
                        @csrf
                        <input type="hidden" name="totalPrice" :value="totalPrice">
                        <button type="submit" class="btn-link">Vai al Checkout <i
                                class="fas fa-angle-double-right"></i></button>
                    </form>
                </div>

                {{-- nome --}}
                <div class="restaurant_name">
                    <h2>{{ $user->nome_attivita }}</h2>

                    <p>Tipo di Cucina</p>

                    @foreach ($user->types as $type)

                        <h6>{{ $loop->last ? $type->nome : $type->nome . ', ' }}</h6>

                    @endforeach
                    {{-- immagine ristorante --}}
                </div>

                <div class="menu_container flex_col align_cen">

                    @if (Auth::check() && Auth::user()->id == $user->id)

                        <div class="restaurant_options flex space_bet">

                            {{-- option_card --}}
                            <div class="option_card" title="Crea nuovo prodotto">
                                <a href="{{ route('createDish') }}" class="flex space_bet align_cen">
                                    <h6>Aggiungi nuovo prodotto</h6>
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>

                            <div class="option_card flex space_bet" title="Guarda gli ordini ricevuti">
                                <h6>Ordini Ricevuti</h6>
                                <a href="{{ route('showOrders', $user->id) }}">
                                    <i class="fas fa-clipboard-list"></i>
                                </a>
                            </div>

                            <div class="option_card" title="Guarda statistiche">
                                <a href="" class="flex space_bet align_cen">
                                    <h6>Statistiche Ordini</h6>
                                    <i class="fas fa-chart-line"></i>
                                </a>
                            </div>
                        </div>

                    @endif

                    <h3>Menu</h3>

                    <ul class="flex_wrap">

                        @foreach ($user->dishes as $dish)

                            @if (!$dish->deleted)

                                <li>
                                    {{-- card piatto --}}
                                    <div class="dish_card flex_col just_start"
                                        title="Aggiungi {{ $dish->nome }} al carrello">
                                        <h6>{{ $dish->nome }}</h6>
                                        <p>{{ $dish->ingredienti }}</p>
                                        <p>{{ $dish->descrizione }}</p>
                                        <h6>{{ $dish->prezzo }} €</h6>

                                        {{-- bottone aggiungi al carrello --}}
                                        <button @click="addToCart({{ $dish }})">
                                            Aggiungi all'ordine <i class="fas fa-cart-plus"></i>
                                        </button>

                                        @if (Auth::check() && Auth::user()->id == $user->id)

                                            {{-- edit --}}
                                            <div class="edit_row" title="Modifica prodotto">
                                                <a href="{{ route('editDish', $dish->id) }}"
                                                    class="flex space_bet align_cen">
                                                    <p>Modifica</p>
                                                    <i class="far fa-edit"></i>
                                                </a>
                                            </div>

                                            {{-- delete --}}
                                            <div class="delete_row" title="Elimina prodotto">
                                                <a href="{{ route('destroy', [$dish->id, $user->id]) }}"
                                                    class="flex space_bet align_cen">
                                                    <p>Elimina Prodotto</p>
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            </div>

                                        @endif
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    {{-- fine menu_container --}}
                </div>
                {{-- fine mycontainer --}}
            </div>
            {{-- fine #showRestaurant --}}
        </div>
        {{-- fine #app --}}
    </div>
    {{-- <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(window).bind('beforeunload', function(){
            return 'Are you sure you want to leave?';
        });
    </script> --}}
@endsection
