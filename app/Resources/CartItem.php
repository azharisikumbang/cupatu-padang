<?php

namespace App\Resources;

use App\Http\Requests\StoreItemToCartRequest;
use App\Models\Service;
use Illuminate\Http\UploadedFile;

class CartItem
{
    private string $key;

    private string $shoeName;

    private string $showImage;

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

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function getPrice(): float
    {
        return $this->getService()?->price;
    }

    public function getShoeImage(): string
    {
        return $this->showImage;
    }

    public function setShoeImage(string $imageProperties): void
    {
        $this->showImage = $imageProperties;
    }

    public static function create(int $serviceId, string $shoeName, string $image, ?Service $service = null): self
    {
        $item = new self();
        $item->setKey($item->createKey());
        $item->setServiceId($serviceId);
        $item->setShoeName($shoeName);
        $item->setService($service);
        $item->setShoeImage($image);

        return $item;
    }

    public static function createFromRequest(StoreItemToCartRequest $request): self
    {
        $validated = $request->validated();
        $savedImage = self::saveTempImageToDisk($validated['shoe_image']);

        return self::create($validated['service'], $validated['shoe_name'], $savedImage);
    }


    private static function saveTempImageToDisk(UploadedFile $file): string
    {
        $path = 'images';
        $filename = sprintf("%s.%s", md5(time()), $file->getClientOriginalExtension());

        $file->storePubliclyAs('public/' . $path, $filename);

        return $path . DIRECTORY_SEPARATOR . $filename;
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
            'shoe_image' => $this->getShoeImage(),
            'service' => $this->getService()?->toArray()
        ];
    }
}