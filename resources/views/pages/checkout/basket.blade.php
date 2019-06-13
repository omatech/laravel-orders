@php

$cartLines = $cart->getProducts();

@endphp

<ul>
    @foreach($cartLines as $cartLine)

        <li>id: {{ $cartLine->getProductId() }}</li>
        <li>quantity: {{ $cartLine->getQuantity() }}</li>

    @endforeach
</ul>
