<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PersonnelRegistryExport implements 
    FromCollection, 
    WithHeadings, 
    WithStyles, 
    WithColumnWidths, 
    WithTitle, 
    WithCustomStartCell
{
    protected $employes;
    protected $entreprise;

    public function __construct($employes, $entreprise)
    {
        $this->employes = $employes;
        $this->entreprise = $entreprise;
    }

    public function collection()
    {
        $data = collect();
        $counter = 1;

        foreach ($this->employes as $employe) {
            $detail = $employe->employeDetail;
            
            $data->push([
                'no' => $counter++,
                'nom_prenoms' => $employe->name ?: '',
                'adresse' => $detail ? ($detail->adresse ?? '') : '',
                'nationalite' => $detail ? ($detail->nationalite ?? '') : '',
                'date_naissance' => ($detail && $detail->date_naissance) ? \Carbon\Carbon::parse($detail->date_naissance)->format('d/m/Y') : '',
                'sexe' => $detail ? ($detail->genre ?? '') : '',
                'emploi_qualification' => $detail ? ($detail->description_poste ?? '') : '',
                'salaire_base' => $detail ? ($detail->salaire ?? '') : '',
                'date_entree' => ($detail && $detail->date_debut) ? \Carbon\Carbon::parse($detail->date_debut)->format('d/m/Y') : '',
                'date_sortie' => ($detail && $detail->date_fin) ? \Carbon\Carbon::parse($detail->date_fin)->format('d/m/Y') : '',
                'type_contrat' => $detail ? ($detail->type_contrat ?? '') : '',
                'observations' => $detail ? ($detail->statut_employe ?? '') : ''
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'No.',
            'Nom et prénoms',
            'Adresse',
            'Nationalité',
            'Date de naissance',
            'Sexe',
            'Emploi et qualification',
            'Salaire de base',
            'Dates - Entrée',
            'Dates - Sortie',
            'Type de contrat',
            'Observations'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Titre principal
        $sheet->setCellValue('A1', 'Registre Unique du Personnel');
        $sheet->mergeCells('A1:M1');
        
        // Nom de l'entreprise
        $sheet->setCellValue('A2', $this->entreprise->entreprise_name);
        $sheet->mergeCells('A2:B2');

        // Styles pour le titre
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E8F4FD'],
            ],
        ]);

        // Style pour le nom de l'entreprise
        $sheet->getStyle('A2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F0F0F0'],
            ],
        ]);

        // En-têtes des colonnes (ligne 4)
        $sheet->getStyle('A4:M4')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4A90E2'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Bordures pour tout le tableau
        $lastRow = $this->employes->count() + 4;
        $sheet->getStyle("A4:M{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Alternance de couleurs pour les lignes de données
        for ($row = 5; $row <= $lastRow; $row++) {
            if (($row - 5) % 2 == 0) {
                $sheet->getStyle("A{$row}:M{$row}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F9F9F9'],
                    ],
                ]);
            }
        }

        // Centrer les données
        $sheet->getStyle("A5:M{$lastRow}")->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // No.
            'B' => 25,  // Nom et prénoms
            'C' => 30,  // Adresse
            'D' => 15,  // Nationalité
            'E' => 15,  // Date de naissance
            'F' => 10,  // Sexe
            'G' => 25,  // Emploi et qualification
            'I' => 15,  // Salaire de base
            'J' => 12,  // Date entrée
            'K' => 12,  // Date sortie
            'L' => 15,  // Type de contrat
            'M' => 20,  // Observations
        ];
    }

    public function title(): string
    {
        return 'Registre du Personnel';
    }

    public function startCell(): string
    {
        return 'A4'; // Les en-têtes commencent à la ligne 4
    }
}