<?php

namespace App\Resources;

use App\Http\Requests\StoreItemToCartRequest;
use App\Models\Service;

class CartItem
{
    private string $key;

    private string $shoeName;

    private int $serviceId;

    private ?Service $service = null;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getShoeName(): string
    {
        return $this->shoeName;
    }

    /**
     * @param string $key
     */
    public function setShoeName(string $shoeName): void
    {
        $this->shoeName = $shoeName;
    }

    /**
     * @return string
     */
    public function getServiceId(): string
    {
        return $this->serviceId;
    }

    /**
     * @param string $key
     */
    public function setServiceId(int $serviceId): void
    {
        $this->serviceId = $serviceId;
    }

    public function setService(?Service $service): void
    {
        $this->service = $service;
    }

    public function getService(): Service
    {
        return $this->service;
    }

    public function getPrice(): float
    {
        return $this->getService()?->price;
    }

    public static function create(int $serviceId, string $shoeName, ?Service $service = null): self
    {
        $item = new self();
        $item->setKey($item->createKey());
        $item->setServiceId($serviceId);
        $item->setShoeName($shoeName);
        $item->setService($service);

        return $item;
    }

    public static function createFromRequest(StoreItemToCartRequest $request): self
    {
        $validated = $request->validated();

        return self::create($validated['service'], $validated['shoe_name']);
    }

    private function createKey(): string
    {
        return strtolower(md5(time()));
    }

    public function toArray(): array
    {
        return [
            'key' => $this->getKey(),
            'service_id' => $this->getServiceId(),
            'shoe_name' => $this->getShoeName(),
            'service' => $this->getService()?->toArray()
        ];
    }
}