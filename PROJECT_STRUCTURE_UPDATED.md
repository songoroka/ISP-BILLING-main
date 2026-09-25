# SKYTECH INFRANET — Updated Project Structure

## 1. Architecture

```text
SKYTECH INFRANET
├── Public Website (skytech.it.com)
├── Admin / Super Admin Portal (portal.skytech.it.com)
│   ├── ISP Billing & Customer Management
│   ├── MikroTik / Router Management
│   ├── Payment Gateways
│   ├── SMS / Beem Integration
│   ├── Reseller Management
│   ├── Reports / Logs / Support
│   ├── Flexible API Integration Registry
│   └── Hotel Module Administration
├── Hotel User Workspace (hotel.skytech.it.com)
│   ├── Guest Registration
│   ├── Guest Search / Edit
│   └── Guest Voucher Print / PDF
└── External Integrations
    ├── M-Pesa Tanzania
    ├── Selcom Tanzania
    ├── AzamPesa / AzamPay
    ├── Beem BPay / Beem SMS
    ├── MikroTik RouterOS
    └── Additional APIs configured by Super Admin
```

## 2. New Hotel Module

The Hotel module is deliberately separated from ISP billing.

### Hotel User permissions

- `hotel-view-guests`
- `hotel-create-guest`
- `hotel-edit-guest`
- `hotel-delete-guest`
- `hotel-print-voucher`

The `Hotel User` role is created by the deployment migration/seeders and is intended to be assigned by **Super Admin only**. It is a standalone portal role and does not expose ISP billing menus.

Hotel staff authenticate through `portal.skytech.it.com`, then are redirected to `https://hotel.skytech.it.com/hotel/guests`. The hotel subdomain is a dedicated workspace and is not used for ISP billing.

### Hotel guest data

`hotel_guests` stores:

- Voucher number
- Guest name and gender
- Nationality
- Identification document type/number
- Phone, email and address
- Room number
- Check-in / check-out
- Adults / children
- Purpose and notes
- Registering user

There is **no invoice, payment, price, charge, collection, or billing field** in the hotel module.

### Hotel voucher identity

Super Admin configures hotel identity under:

`Portal → Site Settings → Hotel Module`

Supported identity data:

- Hotel name
- Address
- Phone
- Email
- Website
- Registration/licence number
- Voucher logo
- Voucher number prefix
- Voucher footer

The configured identity is automatically used when a guest voucher is printed.

## 3. Flexible API Integration Registry

Super Admin can add new REST API definitions without editing `.env` or source code.

Each configured integration can contain:

- Provider/API name
- Unique integration key
- Base URL
- Authentication mode
- API key / username
- API secret / password
- Custom authentication header
- Additional JSON headers
- JSON endpoint map
- Webhook URL
- Webhook secret
- Enabled/disabled state

The existing dedicated payment integrations remain available. The new registry is an extension for additional integrations and future providers.

`App\Services\ConfigurableApiService` can consume an enabled integration by its key.

Example concept:

```php
app(\App\Services\ConfigurableApiService::class)
    ->request('my_provider', 'payment')
    ->post('', $payload);
```

## 4. Theme / Brand Defaults

The default SKYTECH project palette is now aligned with the blue/green deployment plan:

- Primary: `#006DB6`
- Accent: `#00A878`

Existing customized site colors are preserved by the migration.

## 5. Important New Files

```text
app/
├── Http/Controllers/Hotel/HotelVoucherController.php
├── Livewire/Hotel/GuestManager.php
├── Models/HotelGuest.php
└── Services/ConfigurableApiService.php

resources/views/
├── hotel/voucher.blade.php
└── livewire/hotel/guest-manager.blade.php

database/migrations/
└── 2026_09_23_130000_add_hotel_module_and_api_settings.php
```
