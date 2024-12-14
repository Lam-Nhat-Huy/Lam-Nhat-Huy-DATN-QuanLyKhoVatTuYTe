<?php

function convertNumberToWords($number)
{
    $number = intval($number);

    if ($number == 0) {
        return 'không';
    }

    $dictionary = [
        0 => 'không',
        1 => 'một',
        2 => 'hai',
        3 => 'ba',
        4 => 'bốn',
        5 => 'năm',
        6 => 'sáu',
        7 => 'bảy',
        8 => 'tám',
        9 => 'chín'
    ];

    $units = ['', 'nghìn', 'triệu', 'tỷ', 'nghìn tỷ', 'triệu tỷ'];
    $chunks = [];

    while ($number > 0) {
        array_unshift($chunks, $number % 1000);
        $number = floor($number / 1000);
    }

    $words = [];
    foreach ($chunks as $i => $chunk) {
        $chunkWords = [];
        if ($chunk >= 100) {
            $chunkWords[] = $dictionary[floor($chunk / 100)] . ' trăm';
            $chunk %= 100;
        }
        if ($chunk >= 10) {
            if ($chunk < 20) {
                $chunkWords[] = 'mười ' . $dictionary[$chunk % 10];
            } else {
                $chunkWords[] = $dictionary[floor($chunk / 10)] . ' mươi';
                if ($chunk % 10 > 0) {
                    $chunkWords[] = $dictionary[$chunk % 10];
                }
            }
        } elseif ($chunk > 0) {
            $chunkWords[] = $dictionary[$chunk];
        }
        if (!empty($chunkWords)) {
            $words[] = implode(' ', $chunkWords) . ' ' . $units[count($chunks) - $i - 1];
        }
    }

    return ucfirst(trim(implode(' ', $words)));
}
