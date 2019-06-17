@php

    $billingData = $cart->getBillingData();

@endphp

<form id="order-billing-form" action="{{route('orders.cart.assignBillingData')}}" method="POST">
    @method('PUT')
    {{ csrf_field() }}

    <input type="text" name="address_first_name" value="{{ old('address_first_name') ?? $billingData->getAddressFirstName() }}" id="address_first_name">
    <input type="text" name="address_last_name" value="{{ old('address_last_name') ?? $billingData->getAddressLastName() }}" id="address_last_name">
    <input type="text" name="address_first_line" value="{{ old('address_first_line') ?? $billingData->getAddressFirstLine() }}" id="address_first_line">
    <input type="text" name="address_second_line" value="{{ old('address_second_line') ?? $billingData->getAddressSecondLine() }}" id="address_second_line">
    <input type="text" name="address_postal_code" value="{{ old('address_postal_code') ?? $billingData->getAddressPostalCode() }}" id="address_postal_code">
    <input type="text" name="address_city" value="{{ old('address_city') ?? $billingData->getAddressCity() }}" id="address_city">
    <input type="text" name="address_region" value="{{ old('address_region') ?? $billingData->getAddressRegion() }}" id="address_region">
    <input type="text" name="address_country" value="{{ old('address_country') ?? $billingData->getAddressCountry() }}" id="address_country">
    <input type="text" name="company_name" value="{{ old('company_name') ?? $billingData->getCompanyName() }}" id="company_name">
    <input type="text" name="cif" value="{{ old('cif') ?? $billingData->getCif() }}" id="cif">
    <input type="text" name="phone_number" value="{{ old('phone_number') ?? $billingData->getPhoneNumber() }}" id="phone_number">

    <button type="submit">Submit</button>

</form>