<?php

class Perpustakaan
{
    public $lokasi;
    private $daftarBuku = array();

    public function __construct($lokasi)
    {
        $this->lokasi = $lokasi;
    }

    public function tambahBuku(Buku $buku)
    {
        $this->daftarBuku[] = $buku;
    }

    public function getDaftarBuku()
    {
        if (empty($this->daftarBuku)) {
            $_SESSION['message'] = "Tidak ada buku di perpustakaan ini";
        } else {
            return $this->daftarBuku;
        }
    }
}
