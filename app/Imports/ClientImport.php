<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\ClientContact;
use App\Models\State;
use App\Models\City;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class ClientImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Skip empty rows
        if (empty($row['name'])) {
            return null;
        }

        // Generate client code (same as your method)
        $clientCode = 'CL' . strtoupper(Str::random(6));

        // Fetch state and city names safely
        $stateBilling = State::where('name', $row['b_state'])->first();
        $cityBilling = City::where('city_name', $row['b_city'])->first();

        // Billing & Service Address
        $billingAddress = json_encode([
            'contact_person' => $row['b_contact_person'] ?? '',
            'phone' => $row['b_phone'] ?? '',
            'email' => $row['b_email'] ?? '',
            'address1' => $row['b_address1'] ?? '',
            'address2' => $row['b_address2'] ?? '',
            'state' => $stateBilling->name ?? $row['b_state'] ?? '',
            'city' => $cityBilling->city_name ?? $row['b_city'] ?? '',
            'pincode' => $row['b_pincode'] ?? '',
        ]);

        $serviceAddress = json_encode([
            'contact_person' => $row['contact_person'] ?? '',
            'phone' => $row['mobile'] ?? '',
            'email' => $row['email'] ?? '',
            'address1' => $row['b_address1'] ?? '',
            'address2' => $row['b_address2'] ?? '',
            'state' => $stateBilling->name ?? $row['b_state'] ?? '',
            'city' => $cityBilling->city_name ?? $row['b_city'] ?? '',
            'pincode' => $row['b_pincode'] ?? '',
        ]);

        // Create Client
        $client = Client::create([
            'name' => $row['name'] ?? '',
            'client_code' => $clientCode,
            // 'client_type' => $row['client_type'] ?? '',
            'client_type' => 1,
            // 'client_group' => $row['client_group'] ?? '',
            'client_group' => 1,
            'client_sector' => $row['client_sector'] ?? '',
            'client_size' => $row['client_size'] ?? '',
            'client_reference' => $row['client_reference'] ?? '',
            'msme_no' => $row['msme_no'] ?? '',
            'pancard_no' => $row['pancard_no'] ?? '',
            'gst_no' => $row['gst_no'] ?? '',
            'status' => 1,
            'billing_address' => $billingAddress,
            'service_address' => $serviceAddress,
        ]);

        // Create Client Contact
        if ($client) {
            ClientContact::create([
                'client_id' => $client->id,
                'contact_person' => $row['contact_person'] ?? '',
                'email' => $row['email'] ?? '',
                'phone' => $row['phone'] ?? '',
                'mobile' => $row['mobile'] ?? '',
                'billing_address' => $billingAddress,
                'service_address' => $serviceAddress,
                // 'designation' => $row['designation'] ?? '',
                'designation' => 1,
                // 'department' => $row['department'] ?? '',
                'department' => 1,
            ]);
        }

        return $client;
    }
}
