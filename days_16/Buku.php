<?php
class Buku
{
    private $judul;
    private $pengarang;
    private $tahunTerbit;
    private $genre;
    private $gambar;

    public function __construct($judul, $pengarang, $tahunTerbit, $genre, $gambar)
    {
        $this->judul = $judul;
        $this->pengarang = $pengarang;
        $this->tahunTerbit = $tahunTerbit;
        $this->genre = $genre;
        $this->gambar = $gambar;
    }

    public function getDetailBuku()
    {
        return "Buku ini berjudul <strong>$this->judul</strong>. Ditulis oleh <strong>$this->pengarang</strong>, 
        buku ini diterbitkan pada tahun <strong>$this->tahunTerbit</strong>. Genre dari buku ini adalah 
        <strong>$this->genre</strong>.";
    }

    public function getBuku()
    {
        return [
            "judul" => $this->judul,
            "pengarang" => $this->pengarang,
            "tahunTerbit" => $this->tahunTerbit,
            "genre" => $this->genre,
            "gambar" => $this->gambar
        ];
    }
}
