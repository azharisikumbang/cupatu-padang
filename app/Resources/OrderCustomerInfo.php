<?php 

namespace App\Resources;
use App\Http\Requests\StoreOrderCustomerInfoRequest;

class OrderCustomerInfo
{
    public function __construct(
        private string $name,
        private string $contact,
        private string $address
    ) {}

    public static function createFromRequest(StoreOrderCustomerInfoRequest $request): self
    {
        $data = $request->validated();

        return (new OrderCustomerInfo(
            $data['name'],
            $data['contact'],
            $data['address']
        ));
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getContact(): string
    {
        return $this->contact;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function setContact(string $contact): void
    {
        $this->contact = $contact;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getAddress(),
            'contact' => $this->getContact(),
            'address' => $this->getAddress()
        ];
    }
}