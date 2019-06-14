@php

$deliveryAddress = $cart->getDeliveryAddress();

@endphp

<form id="order-delivery-form" action="{{route('orders.cart.assignDeliveryAddress')}}" method="POST">
    @method('PUT')
    {{ csrf_field() }}

    <input type="text" name="first_name" value="{{ old('first_name') ?? $deliveryAddress->getFirstName() }}" id="first_name">
    <input type="text" name="last_name" value="{{ old('last_name') ?? $deliveryAddress->getLastName() }}" id="last_name">
    <input type="text" name="first_line" value="{{ old('first_line') ?? $deliveryAddress->getFirstLine() }}" id="first_line">
    <input type="text" name="second_line" value="{{ old('second_line') ?? $deliveryAddress->getSecondLine() }}" id="second_line">
    <input type="text" name="postal_code" value="{{ old('postal_code') ?? $deliveryAddress->getPostalCode() }}" id="postal_code">
    <input type="text" name="city" value="{{ old('city') ?? $deliveryAddress->getCity() }}" id="city">
    <input type="text" name="region" value="{{ old('region') ?? $deliveryAddress->getRegion() }}" id="region">
    <input type="text" name="country" value="{{ old('country') ?? $deliveryAddress->getCountry() }}" id="country">
    <input type="text" name="is_a_company" value="{{ old('is_a_company') ?? $deliveryAddress->getIsACompany() }}" id="is_a_company">
    <input type="text" name="company_name" value="{{ old('company_name') ?? $deliveryAddress->getCompanyName() }}" id="company_name">

    <button type="submit">Submit</button>

</form>