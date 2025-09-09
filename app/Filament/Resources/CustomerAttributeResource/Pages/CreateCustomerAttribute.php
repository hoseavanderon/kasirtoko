<?php

namespace App\Filament\Resources\CustomerAttributeResource\Pages;

use App\Filament\Resources\CustomerAttributeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerAttribute extends CreateRecord
{
    protected static string $resource = CustomerAttributeResource::class;
}
