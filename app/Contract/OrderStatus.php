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

    public function getReadable(): string
    {
        return match($this) {
            self::MENUNGGU_KONFIRMASI => 'Menunggu Konfirmasi Admin',
            self::PENJEMPUTAN => 'Akan Dilakukan Penjemputan',
            self::DIPROSES => 'Diproses Perawatan',
            self::PENGANTARAN => 'Pengantaran Kembali',
            self::BATAL => 'Pesanan Dibatalkan',
            self::SELESAI => 'Pesanan Selesai',
            default => 'Menunggu Konfirmasi Admin'
        };
    }

    public function getActionList(int $orderId): array
    {
        return match($this) {
            self::MENUNGGU_KONFIRMASI => $this->createActionList($orderId, self::PENJEMPUTAN->value, self::BATAL->value, 'Konfirmasi Pesanan', 'Batalkan Pesanan'),
            self::PENJEMPUTAN => $this->createActionList($orderId, self::DIPROSES->value, self::MENUNGGU_KONFIRMASI->value, 'Konfirmasi Selesai Dijemput', 'Kembalikan Status Sebelumnya'),
            self::DIPROSES => $this->createActionList($orderId, self::PENGANTARAN->value, self::PENJEMPUTAN->value, 'Konfirmasi Selesai Perawatan', 'Kembalikan Status Sebelumnya'),
            self::PENGANTARAN => $this->createActionList($orderId, self::SELESAI->value, self::DIPROSES->value, 'Konfirmasi Selesai Diantarkan', 'Kembalikan Status Sebelumnya'),
            self::BATAL => $this->createActionList($orderId, null, null),
            self::SELESAI => $this->createActionList($orderId, null, null),
            default => $this->createActionList($orderId, self::PENJEMPUTAN->value),
        };
    }

    private function createActionList(
        int $id, 
        ?string $actualNextOrderStatus = null,
        ?string $actualPrevOrderStatus = null,
        ?string $nextOrderStatusMessage = null,
        ?string $prevOrderStatusMessage = null,
    ): array {
        return [
            'order_id' => $id,
            'actual_prev_order_status' => $actualPrevOrderStatus,
            'actual_next_order_status' => $actualNextOrderStatus,
            'prev_order_status_message' => $prevOrderStatusMessage,
            'next_order_status_message' => $nextOrderStatusMessage,
        ];
    }
}