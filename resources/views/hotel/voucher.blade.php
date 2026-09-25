<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $guest->voucher_number }}</title>
    <style>
        body{font-family:DejaVu Sans,Arial,sans-serif;color:#172033;font-size:11px;}
        .header{border-bottom:4px solid #006DB6;padding-bottom:12px;margin-bottom:18px;}
        .brand{font-size:20px;font-weight:700;color:#006DB6;}
        .muted{color:#64748b;}
        .title{font-size:18px;font-weight:700;text-align:center;margin:12px 0 18px;color:#006DB6;}
        table{width:100%;border-collapse:collapse;}
        td,th{border:1px solid #dbe4ee;padding:8px;vertical-align:top;}
        th{background:#eef6fb;text-align:left;width:25%;}
        .section{background:#006DB6;color:#fff;font-weight:700;padding:7px;margin-top:14px;}
        .voucher{font-size:13px;font-weight:700;color:#00A878;}
        .footer{margin-top:22px;border-top:1px solid #dbe4ee;padding-top:10px;font-size:9px;color:#64748b;}
    </style>
</head>
<body>
    <div class="header">
        <table style="border:0">
            <tr>
                <td style="border:0;width:20%;">
                    @if($hotel['logo'])
                        <img src="{{ site_image($hotel['logo']) }}" style="max-width:120px;max-height:60px;">
                    @endif
                </td>
                <td style="border:0;width:80%;">
                    <div class="brand">{{ $hotel['name'] }}</div>
                    <div class="muted">{{ $hotel['address'] }}</div>
                    <div class="muted">{{ $hotel['phone'] }} @if($hotel['email']) · {{ $hotel['email'] }} @endif</div>
                    @if($hotel['website'])<div class="muted">{{ $hotel['website'] }}</div>@endif
                    @if($hotel['registration_number'])<div class="muted">Registration: {{ $hotel['registration_number'] }}</div>@endif
                </td>
            </tr>
        </table>
    </div>

    <div class="title">HOTEL GUEST REGISTRATION VOUCHER</div>
    <table>
        <tr><th>Voucher Number</th><td class="voucher">{{ $guest->voucher_number }}</td><th>Registered</th><td>{{ $guest->created_at?->format('d M Y H:i') }}</td></tr>
        <tr><th>Guest Name</th><td colspan="3">{{ $guest->guest_name }}</td></tr>
        <tr><th>Gender</th><td>{{ $guest->gender ?: '—' }}</td><th>Nationality</th><td>{{ $guest->nationality ?: '—' }}</td></tr>
        <tr><th>Document</th><td>{{ $guest->document_type ?: '—' }}</td><th>Document No.</th><td>{{ $guest->document_number ?: '—' }}</td></tr>
        <tr><th>Phone</th><td>{{ $guest->phone ?: '—' }}</td><th>Email</th><td>{{ $guest->email ?: '—' }}</td></tr>
        <tr><th>Address</th><td colspan="3">{{ $guest->address ?: '—' }}</td></tr>
    </table>

    <div class="section">STAY DETAILS</div>
    <table>
        <tr><th>Room</th><td>{{ $guest->room_number ?: '—' }}</td><th>Adults</th><td>{{ $guest->adults }}</td></tr>
        <tr><th>Children</th><td>{{ $guest->children }}</td><th>Purpose</th><td>{{ $guest->purpose ?: '—' }}</td></tr>
        <tr><th>Check In</th><td>{{ $guest->check_in?->format('d M Y H:i') }}</td><th>Check Out</th><td>{{ $guest->check_out?->format('d M Y H:i') ?: '—' }}</td></tr>
        <tr><th>Notes</th><td colspan="3">{{ $guest->notes ?: '—' }}</td></tr>
    </table>

    <div class="footer">
        {{ $hotel['footer'] }}<br>
        {{ __('This voucher records guest registration details only and is not an invoice or billing document.') }}
    </div>
</body>
</html>
