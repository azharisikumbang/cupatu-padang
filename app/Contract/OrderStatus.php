<?php

namespace App\Contract;

enum OrderStatus: string
{
    case MENUNGGU_KONFIRMASI = 'MENUNGGU_KONFIRMASI';

    case PENJEMPUTAN = 'PENJEMPUTAN';

    case DIPROSES = 'DIPROSES';

    case PENGANTARAN = 'PENGANTARAN';

    case BATAL = 'BATAL';

    case SELESAI = 'SELESAI';

    public function showReadable(): string
    {
        return match($this) {
            self::MENUNGGU_KONFIRMASI => 'Menunggu Konfirmasi Admin',
            self::PENJEMPUTAN => 'Akan Penjemputan',
            self::DIPROSES => 'Diproses Perawatan',
            self::PENGANTARAN => 'Pengantaran Kembali',
            self::BATAL => 'Pesanan Dibatalkan',
            self::SELESAI => 'Pesanan Selesai',
            default => 'Menunggu Konfirmasi Admin'
        };
    }
}