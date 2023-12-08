<?php

namespace App\Resources;

class Cart
{
    private array $items = [];

    private float $total = 0;

    private ?OrderCustomerInfo $customerInfo = null;

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }

    /**
     * @param float $total
     */
    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

    public function addItem(CartItem $item) : false|CartItem
    {
        if($this->exists($item->getKey())) return false;
        $this->items[] = $item;
        $this->updateTotal();

        return $item;
    }

    public function search(string $key) : ?CartItem
    {
        /** @var $item Item */
        foreach ($this->getItems() as $item)
            if($item->getKey() == $key) return $item;

        return null;
    }

    public function exists(string $key): bool
    {
        /** @var $item Item */
        foreach ($this->getItems() as $item)
            if($item->getKey() == $key) return true;

        return false;
    }

    

    private function updateTotal(): void
    {
        /** @var $item Item */
        $total = array_sum(
            array_map(fn ($item) => $item->getPrice(), $this->getItems())
        );

        $this->setTotal($total);
    }

    public function updateItem(CartItem $item, int $jumlahBeli) : void
    {
        foreach ($this->getItems() as $index => $existing)
            if($item->getKey() == $existing->getKey()) {
                $this->items[$index] = $item;
                $this->updateTotal();
                break;
            }
    }

    public function removeItem(string $key) : void
    {
        foreach ($this->getItems() as $index => $existing)
            if($key == $existing->getKey()) {
                unset($this->items[$index]);
                $this->setItems(array_values($this->getItems()));
                $this->updateTotal();
                break;
            }
    }

    public function getCustomerInfo(): ?OrderCustomerInfo
    {
        return $this->customerInfo;
    }

    public function setCustomerInfo(OrderCustomerInfo $orderCustomerInfo): void
    {
        $this->customerInfo = $orderCustomerInfo;
    }

    public function toArray(): array
    {
        return [
            'items' => array_map(fn(CartItem $item) => $item->toArray(), $this->getItems()),
            'customer' => $this->getCustomerInfo()?->toArray(),
            'total' => $this->getTotal()
        ];
    }
}