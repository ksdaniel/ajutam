@extends('emails.emailLayout')

@section('style')
    <style type="text/css">

    </style>
@endsection


@section('content')
    <p>Salutare {{$volunteer_name}},</p>

    <p>Mai jos ai detaliile comenzii.</p>

    <p style="font-weight: bold!important;margin-top: 30px!important;">Codul comenzii: {{$code}}</p>
    <p style="font-weight: bold!important">Adresa de livrate: {{$beneficiary->address}}, {{$beneficiary->neighborhood}}, {{$beneficiary->city}}, {{$beneficiary->county}}</p>
    <p style="font-weight: bold!important">Perioada de livrare: {{!$delivery_period ? '-' : $delivery_period}}</p>
    <p style="font-weight: bold!important">Greutatea pachetului aprox: {{!$package_weight ? '-' : $package_weight}}</p>
    <p style="font-weight: bold!important">Link procedura de siguranta: <a href="https://drive.google.com/file/d/15yhIV4iFS0eFSOJi2entl5B6NaPjs7BZ/view?fbclid=IwAR0fnM8-ff3GL7AT9LNEpUF-2SWCtCT3XxA2ZlApj_l261dp-UJQqftF_hg">Click aici</a></p>
    <p style="font-weight: bold!important">Observatii livrare: {{!$delivery_observation ? '-' : $delivery_observation}}</p>
    <p style="font-weight: bold!important">Telefon coordonator: {{!$nr_coordonator ? '-' : $nr_coordonator}}</p>
    <p style="font-weight: bold!important">Telefon Call Center: {{!$nr_call_center ? '-' : $nr_call_center}}</p>

@endsection