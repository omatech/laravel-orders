@php

$cartLines = $cart->getCartLines();

@endphp

<ul>
    @foreach($cartLines as $cartLine)

        <li>id: {{ $cartLine->getProductId() }}</li>
        <li>quantity: {{ $cartLine->getQuantity() }}</li>

    @endforeach
</ul>
