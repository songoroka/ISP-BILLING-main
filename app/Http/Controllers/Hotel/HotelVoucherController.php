<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\HotelGuest;
use App\Models\MainSiteData;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Mpdf\Mpdf;

class HotelVoucherController extends Controller
{
    public function print(HotelGuest $guest): Response
    {
        abort_unless(hasAccess(['Super Admin', 'Hotel User'], ['hotel-print-voucher']), 403);

        $hotel = [
            'name' => MainSiteData::getValue('hotel_name', siteUrlSettings('site_name') ?: config('app.name')),
            'address' => MainSiteData::getValue('hotel_address', siteUrlSettings('site_address')),
            'phone' => MainSiteData::getValue('hotel_phone', siteUrlSettings('site_phone')),
            'email' => MainSiteData::getValue('hotel_email', siteUrlSettings('site_email')),
            'website' => MainSiteData::getValue('hotel_website', parse_url(config('app.url'), PHP_URL_HOST)),
            'registration_number' => MainSiteData::getValue('hotel_registration_number'),
            'logo' => MainSiteData::getValue('hotel_logo'),
            'footer' => MainSiteData::getValue('hotel_voucher_footer', 'Guest registration voucher. No billing information is included.'),
        ];

        $html = view('hotel.voucher', compact('guest', 'hotel'))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 12,
            'margin_right' => 12,
            'margin_bottom' => 12,
            'margin_left' => 12,
        ]);
        $mpdf->SetTitle('Hotel Guest Voucher - '.$guest->voucher_number);
        $mpdf->WriteHTML($html);

        $filename = Str::slug($guest->voucher_number.'-'.$guest->guest_name).'.pdf';

        return response($mpdf->Output($filename, 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"',
        ]);
    }
}
