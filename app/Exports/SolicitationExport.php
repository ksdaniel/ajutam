<?php

namespace App\Exports;

use App\Solicitation;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class SolicitationExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize,WithEvents
{

    public $params;

    public function __construct($params)
    {

        $this->params = $params;

    }

    // freeze the first row with headings
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('P1:P1000')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('O1:O1000')->getAlignment()->setWrapText(true);
            },
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Solicitation::when((isset($this->params["start_time"]) && !empty($this->params["start_time"])), function ($q){
            $q->whereBetween("created_at",[
                Carbon::parse($this->params["start_time"])->startOfDay(),
                Carbon::parse($this->params["end_time"])->endOfDay()]);

        })->when((isset($this->params["type"]) && !empty($this->params["type"])),function ($q){

            $q->where("categories",$this->params["type"]);

        })->with(["beneficiary","volunteer","creator","coordinator"])->get();
    }


    /**
     * @var Invoice $invoice
     */
    public function map($solicitation): array
    {



        return [
            $solicitation->code,
            Carbon::parse( $solicitation->created_at)->toDateString(),
            $solicitation->beneficiary->first_name. " ".$solicitation->beneficiary->last_name,
            $solicitation->beneficiary->phone,
            $solicitation->beneficiary->address. ", ". $solicitation->beneficiary->neighborhood.", ".$solicitation->beneficiary->city,
            $solicitation->creator->name ."()",
            $solicitation->coordonator_id && $solicitation->coordinator ?  $solicitation->coordinator->name ." (".$solicitation->coordinator->phone.")"  : "Nealocat" ,
            $solicitation->volunteer_id && $solicitation->volunteer ?  $solicitation->volunteer->name." (".$solicitation->volunteer->phone.")"  : "Nealocat" ,
            $solicitation->status,
            $solicitation->payment_status,
            $solicitation->payment_value,
            $solicitation->observations,
            $solicitation->delivery_observation,
            $solicitation->additional_responses["tip_cos"],
            $solicitation->additional_responses["tip_cos"]=="personalizat" ? implode("\n", $solicitation->additional_responses["cos_personalizat"] ) :"",
            implode("\n",$solicitation->additional_responses["produse_aditionale"] )

        ];
    }


    public function headings(): array
    {
        return [
            'Cod Comanda',
            'Data',
            'Nume Beneficiar',
            'Telefon Beneficiar',
            'Adresa Beneficiar',
            'Creat de:',
            'Coordonar alocat',
            'Voluntar alocat',
            'Status',
            'Status Plata',
            'Valoare plata',
            'Observatii',
            'Observatii Livrare',
            'Tip Cos',
            'Continut cos personalizat',
            'Produse aditionale'
        ];
    }
}
