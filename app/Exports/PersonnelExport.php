<?php

namespace App\Exports;

use App\Models\Entreprise;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PersonnelExport implements FromCollection, WithMapping, WithHeadings, WithEvents, ShouldAutoSize
{
    protected Entreprise $entreprise;

    public function __construct(Entreprise $entreprise)
    {
        $this->entreprise = $entreprise;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->entreprise->users()->with('employeeDetail')->get();
    }

    /**
     * Définition des en-têtes de colonne pour le fichier Excel.
     * @return array
     */
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
            'Catégorie',
            'Salaire de base',
            'Date Entrée',
            'Date Sortie',
            'Type de contrat',
            'Observations',
        ];
    }

    /**
     * Mappage des données de chaque employé aux colonnes de l'export.
     * @param mixed $user
     * @return array
     */
    public function map($user): array
    {
        $employeeDetail = $user->employeeDetail;

        return [
            '', // Le numéro de ligne sera géré par l'événement AfterSheet
            $user->name,
            $employeeDetail->adresse ?? '',
            $employeeDetail->nationalite ?? '',
            $employeeDetail->date_naissance ?? '',
            $employeeDetail->genre ?? '',
            $employeeDetail->description_poste ?? '',
            '', // Catégorie (non présente dans les modèles fournis, on laisse vide)
            $employeeDetail->salaire ?? '',
            $employeeDetail->date_debut ?? '',
            $employeeDetail->date_fin ?? '',
            $employeeDetail->type_contrat ?? '',
            '', // Observations (non présente dans les modèles fournis, on laisse vide)
        ];
    }
    
    /**
     * Styles et mise en forme du fichier Excel.
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // 🔹 Ligne 1 : titre avec le nom de l’entreprise
                $sheet->mergeCells('A1:M1');
                $sheet->setCellValue('A1', 'REGISTRE PERSONNEL - ' . strtoupper($this->entreprise->entreprise_name));

                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ],
                ]);

                // 🔹 Style des en-têtes (ligne 2)
                $sheet->getStyle('A2:M2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['rgb' => '4F81BD'], // bleu sobre
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ],
                ]);

                // 🔹 Bordures sur tout le tableau (de A2 à la dernière cellule)
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
                    ->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => '000000'],
                            ],
                        ],
                    ]);

                // 🔹 Ajout des numéros de ligne
                foreach ($event->sheet->getRowIterator(3) as $row) {
                    $cell = 'A' . $row->getRowIndex();
                    $event->sheet->setCellValue($cell, $row->getRowIndex() - 2);
                }
            },
        ];
    }
}
