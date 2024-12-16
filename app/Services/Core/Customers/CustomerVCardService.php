<?php

namespace App\Services\Core\Customers;

use App\Models\Core\CoreCustomer;
use JeroenDesloovere\VCard\VCard;

class CustomerVCardService
{
    private $coreCustomer;

    public function __construct(CoreCustomer $coreCustomer)
    {
        $this->coreCustomer = $coreCustomer;    
    }

    public function download()
    {
        $vCard = new VCard();

        $vCard->addName($this->coreCustomer->referent_name, $this->coreCustomer->referent_surname, '', '', '');

        $vCard->addEmail($this->coreCustomer->referent_email);
        $vCard->addCompany($this->coreCustomer->customerName);
        $vCard->addPhoneNumber($this->coreCustomer->referent_prefix_1 . $this->coreCustomer->referent_phone_1);
        $vCard->addPhoneNumber($this->coreCustomer->referent_prefix_2 . $this->coreCustomer->referent_phone_2);
        $vCard->addAddress($this->coreCustomer->fullAddress);
        $vCard->addLabel('street');

        return $vCard->download();
    }
}