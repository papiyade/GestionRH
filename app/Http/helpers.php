<?php

// Fichier: app/Http/helpers.php

if (!function_exists('numberToWords')) {
    /**
     * Convertit un nombre en lettres (français)
     *
     * @param float|int $nombre
     * @return string
     */
    function numberToWords($nombre): string
    {
        $nombre = intval($nombre);

        if ($nombre === 0) {
            return 'zéro';
        }

        if ($nombre < 0) {
            return 'moins ' . numberToWords(abs($nombre));
        }

        $resultat = '';

        // Milliards
        if ($nombre >= 1000000000) {
            $milliards = intval($nombre / 1000000000);
            $resultat .= convertGroupe($milliards) . ' milliard';
            if ($milliards > 1) $resultat .= 's';
            $nombre %= 1000000000;
            if ($nombre > 0) $resultat .= ' ';
        }

        // Millions
        if ($nombre >= 1000000) {
            $millions = intval($nombre / 1000000);
            $resultat .= convertGroupe($millions) . ' million';
            if ($millions > 1) $resultat .= 's';
            $nombre %= 1000000;
            if ($nombre > 0) $resultat .= ' ';
        }

        // Milliers
        if ($nombre >= 1000) {
            $milliers = intval($nombre / 1000);
            if ($milliers === 1) {
                $resultat .= 'mille';
            } else {
                $resultat .= convertGroupe($milliers) . ' mille';
            }
            $nombre %= 1000;
            if ($nombre > 0) $resultat .= ' ';
        }

        // Reste (0-999)
        if ($nombre > 0) {
            $resultat .= convertGroupe($nombre);
        }

        return trim($resultat);
    }
}

if (!function_exists('convertGroupe')) {
    /**
     * Convertit un groupe de 3 chiffres (0-999)
     *
     * @param int $nombre
     * @return string
     */
    function convertGroupe(int $nombre): string
    {
        if ($nombre === 0) return '';

        $unites = [
            0 => '', 1 => 'un', 2 => 'deux', 3 => 'trois', 4 => 'quatre',
            5 => 'cinq', 6 => 'six', 7 => 'sept', 8 => 'huit', 9 => 'neuf',
            10 => 'dix', 11 => 'onze', 12 => 'douze', 13 => 'treize',
            14 => 'quatorze', 15 => 'quinze', 16 => 'seize', 17 => 'dix-sept',
            18 => 'dix-huit',
            19 => 'dix-neuf',
        ];

        $dizaines = [
            2 => 'vingt', 3 => 'trente', 4 => 'quarante',
            5 => 'cinquante', 6 => 'soixante', 7 => 'soixante',
            8 => 'quatre-vingt', 9 => 'quatre-vingt'
        ];

        $resultat = '';

        // Centaines
        $centaines = intval($nombre / 100);
        if ($centaines > 0) {
            if ($centaines === 1) {
                $resultat .= 'cent';
            } else {
                $resultat .= $unites[$centaines] . ' cent';
            }

            // Pluriel des centaines
            if ($nombre % 100 === 0 && $centaines > 1) {
                $resultat .= 's';
            }

            if ($nombre % 100 > 0) {
                $resultat .= ' ';
            }
        }

        $reste = $nombre % 100;

        // Nombres de 0 à 16
        if ($reste >= 0 && $reste <= 16) {
            $resultat .= $unites[$reste];
            return $resultat;
        }

        // Nombres de 17 à 99
        $dizaine = intval($reste / 10);
        $unite = $reste % 10;

        if ($dizaine === 1) {
            // 17-19
            $resultat .= 'dix-' . $unites[$unite];
} elseif ($dizaine === 7) {
    // 70-79
    if ($unite === 1) {
        $resultat .= 'soixante et onze';
    } elseif ($unite > 1) {
        $resultat .= 'soixante-' . $unites[10 + $unite];
    } else {
        $resultat .= 'soixante-dix';
    }
}
elseif ($dizaine === 9) {
            // 90-99
            $resultat .= 'quatre-vingt-' . $unites[10 + $unite];
        } else {
            // 20-69, 80-89
            $resultat .= $dizaines[$dizaine];

            if ($unite === 1 && $dizaine !== 8) {
                $resultat .= ' et un';
            } elseif ($unite > 1) {
                $resultat .= '-' . $unites[$unite];
            } elseif ($dizaine === 8 && $unite === 0) {
                $resultat .= 's';
            }
        }

        return $resultat;
    }
}
