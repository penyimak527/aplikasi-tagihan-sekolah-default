<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Simple_xlsx_reader
{
    public function read($file)
    {
        if (!class_exists('ZipArchive')) {
            throw new RuntimeException('Ekstensi PHP ZipArchive diperlukan untuk membaca file XLSX.');
        }
        $zip = new ZipArchive();
        if ($zip->open($file) !== TRUE) {
            throw new RuntimeException('File XLSX tidak dapat dibuka.');
        }

        $shared = array();
        $sharedXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($sharedXml !== false) {
            $xml = simplexml_load_string($sharedXml);
            if ($xml) {
                foreach ($xml->si as $si) {
                    $text = '';
                    if (isset($si->t)) {
                        $text = (string) $si->t;
                    } else {
                        foreach ($si->r as $run) $text .= (string) $run->t;
                    }
                    $shared[] = $text;
                }
            }
        }

        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        if ($sheetXml === false) {
            $zip->close();
            throw new RuntimeException('Worksheet pertama tidak ditemukan.');
        }
        $xml = simplexml_load_string($sheetXml);
        $rows = array();
        if ($xml && isset($xml->sheetData)) {
            foreach ($xml->sheetData->row as $row) {
                $values = array();
                foreach ($row->c as $cell) {
                    $ref = (string) $cell['r'];
                    preg_match('/([A-Z]+)(\d+)/', $ref, $m);
                    $index = $this->columnIndex(isset($m[1]) ? $m[1] : 'A');
                    $type = (string) $cell['t'];
                    $value = '';
                    if ($type === 'inlineStr') {
                        $value = isset($cell->is->t) ? (string) $cell->is->t : '';
                    } elseif (isset($cell->v)) {
                        $raw = (string) $cell->v;
                        $value = ($type === 's' && isset($shared[(int)$raw])) ? $shared[(int)$raw] : $raw;
                    }
                    $values[$index] = trim((string) $value);
                }
                if ($values) {
                    ksort($values);
                    $max = max(array_keys($values));
                    $normalized = array();
                    for ($i = 0; $i <= $max; $i++) $normalized[] = isset($values[$i]) ? $values[$i] : '';
                    $rows[] = $normalized;
                }
            }
        }
        $zip->close();
        return $rows;
    }

    private function columnIndex($letters)
    {
        $letters = strtoupper($letters);
        $index = 0;
        for ($i = 0, $len = strlen($letters); $i < $len; $i++) {
            $index = $index * 26 + (ord($letters[$i]) - 64);
        }
        return $index - 1;
    }
}
