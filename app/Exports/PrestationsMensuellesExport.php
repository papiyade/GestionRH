<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PrestationsMensuellesExport implements FromCollection, ShouldAutoSize, WithEvents, WithHeadings, WithMapping
{
    protected $mois;

    protected $annee;

    protected $totalBrut = 0;

    protected $totalBRS = 0;

    protected $totalNet = 0;

    public function __construct($mois, $annee)
    {
        $this->mois = (int) $mois;
        $this->annee = (int) $annee;
    }

    public function collection()
    {
        $prestations = \App\Models\Prestation::with('prestataire')
            ->whereMonth('date', $this->mois)
            ->whereYear('date', $this->annee)
            ->get();

        foreach ($prestations as $p) {
            $brut = $p->montant;
            $brs = round($brut * 0.05, 0);
            $net = $brut - $brs;

            $this->totalBrut += $brut;
            $this->totalBRS += $brs;
            $this->totalNet += $net;
        }

        return $prestations;
    }

    public function headings(): array
    {
        return [
            'Nom',
            'Prénom',
            'Montant brut (XOF)',
            'BRS (5%)',
            'Net à payer (XOF)',
        ];
    }

    public function map($prestation): array
    {
        $brut = $prestation->montant;
        $brs = round($brut * 0.05, 0);
        $net = $brut - $brs;

        return [
            $prestation->prestataire->nom ?? '',
            $prestation->prestataire->prenom ?? '',
            $brut,
            $brs,
            $net,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Décaler tout le contenu d'une ligne vers le bas pour ajouter le titre principal
                $sheet->insertNewRowBefore(1, 1);

                // Titre principal (ligne 1)
                $moisLettre = ucfirst(Carbon::create(null, $this->mois)->translatedFormat('F'));

                $sheet->mergeCells('A1:E1');
                $sheet->setCellValue('A1', "Prestations du mois de {$moisLettre} {$this->annee}");
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
                ]);

                // Style des en-têtes (qui sont maintenant en ligne 2)
                $sheet->getStyle('A2:E2')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '4F81BD'],
                    ],
                    'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
                ]);

                // Récupérer la dernière ligne de données
                $highestRow = $sheet->getHighestRow();

                // Ajouter une ligne TOTAL après les données
                $totalRow = $highestRow + 1;
                $sheet->setCellValue("A{$totalRow}", 'TOTAL');
                $sheet->setCellValue("C{$totalRow}", $this->totalBrut);
                $sheet->setCellValue("D{$totalRow}", $this->totalBRS);
                $sheet->setCellValue("E{$totalRow}", $this->totalNet);

                // Style de la ligne TOTAL
                $sheet->getStyle("A{$totalRow}:E{$totalRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'D9E1F2'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Bordures globales
                $sheet->getStyle("A2:E{$totalRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Ajustement automatique
                foreach (range('A', 'E') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Format monétaire
                $sheet->getStyle("C3:E{$totalRow}")
                    ->getNumberFormat()
                    ->setFormatCode('#,##0 XOF');
            },
        ];
    }
}
