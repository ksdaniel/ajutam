@extends('emails.emailLayout')

@section('style')
    <style type="text/css">

    </style>
@endsection


@section('content')
    <p>Salutare {{$volunteer_name}},</p>

    <p>Mai jos ai detaliile solicitarii.</p>

    <p style="font-weight: bold!important;margin-top: 30px!important;">Nume beneficiar: {{$beneficiary->first_name}} {{$beneficiary->last_name}}</p>
    <p style="font-weight: bold!important;">Codul comenzii: {{$code}}</p>
    <p style="font-weight: bold!important">Telefon beneficiar: {{$beneficiary->phone}}</p>
    <p style="font-weight: bold!important">Adresa de livrare: {{$beneficiary->address}}, {{$beneficiary->neighborhood}}, {{$beneficiary->city}}, {{$beneficiary->county}}</p>
    <p style="font-weight: bold!important">Perioada de livrare: {{!$delivery_period ? '-' : $delivery_period}}</p>
    <p style="font-weight: bold!important">Voluntar: {{$solicitation->volunteer_confirmation ? $volunteer->name.' ('.$volunteer->phone.')' : 'Neconfirmat'}}</p>
    <p style="font-weight: bold!important">Observatii livrare: {{!$delivery_observation ? '-' : $delivery_observation}}</p>

@endsection