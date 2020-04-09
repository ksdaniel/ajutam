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


        $map=[
            $solicitation->code,
            Carbon::parse( $solicitation->created_at)->toDateString(),
            $solicitation->beneficiary->first_name. " ".$solicitation->beneficiary->last_name,
            $solicitation->beneficiary->phone,
            $solicitation->beneficiary->address. ", ". $solicitation->beneficiary->neighborhood.", ".$solicitation->beneficiary->city,
            $solicitation->creator->name ."()",
            $solicitation->coordonator_id && $solicitation->coordinator ?  $solicitation->coordinator->name ." (".$solicitation->coordinator->phone.")"  : "Nealocat" ,
            $solicitation->volunteer_id && $solicitation->volunteer ?  $solicitation->volunteer->name." (".$solicitation->volunteer->phone.")"  : "Nealocat" ,
            $solicitation->status,
            $solicitation->observations,

        ];

        if($this->params["type"]==="alimente"){

            $map= array_merge($map,[
                $solicitation->payment_status,
                $solicitation->payment_value,
                $solicitation->delivery_observation,
                $solicitation->additional_responses["tip_cos"],
                $solicitation->additional_responses["tip_cos"]=="personalizat" ? implode("\n", $solicitation->additional_responses["cos_personalizat"] ) :"",
                implode("\n",$solicitation->additional_responses["produse_aditionale"] )
            ]);

        } else if ($this->params["type"]==="altele") {

            $map= array_merge($map,[
               isset( $solicitation->additional_responses["altele_descriere_nevoie"] ) ? $solicitation->additional_responses["altele_descriere_nevoie"]: "",
               isset( $solicitation->additional_responses["altele_recomandare_dispecer"] ) ? $solicitation->additional_responses["altele_recomandare_dispecer"]: "",
               isset( $solicitation->additional_responses["altele_solutie_agreata"] ) ? $solicitation->additional_responses["altele_solutie_agreata"]: ""

            ]);

        }  else if($this->params["type"]==="medicamente"){

        $map= array_merge($map,[
            $solicitation->payment_status,
            $solicitation->payment_value,
            $solicitation->delivery_observation,
            $solicitation->delivery_period,
            $solicitation->additional_responses["denumire_medicamente"],
            $solicitation->additional_responses["necesita_reteta"],
            $solicitation->additional_responses["timp_livrare_medicament"],
            $solicitation->additional_responses["ati_mai_folosit_medicamentul"],

        ]);

    }


        return $map;
    }


    public function headings(): array
    {

        $headings=[
            'Cod Comanda',
            'Data',
            'Nume Beneficiar',
            'Telefon Beneficiar',
            'Adresa Beneficiar',
            'Creat de:',
            'Coordonar alocat',
            'Voluntar alocat',
            'Status',
            'Observatii',

        ];

        if($this->params["type"]==="alimente"){

            $headings= array_merge($headings,[
                'Status Plata',
                'Valoare plata',
                'Observatii Livrare',
                'Tip Cos',
                'Continut cos personalizat',
                'Produse aditionale'
                ]);
        }
        else if ($this->params["type"]==="altele") {

            $headings= array_merge($headings,[
                'Descriere nevoie',
                'Recomandare dispecer',
                'Solutie agreata',

            ]);

        } else if($this->params["type"]==="medicamente"){


        $headings= array_merge($headings,[
            'Status Plata',
            'Valoare plata',
            'Observatii Livrare',
            'Urgenta Livrare',
            'Denumire medicamente',
            'Necesita reteta?',
            'Ati mai folosit medicamentul?',
            'Timp Livrare Medicament'
        ]);
    }

        return  $headings;
    }
}
