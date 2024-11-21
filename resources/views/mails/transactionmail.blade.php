<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>Document</title> --}}
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #f9f9f9;
            padding: 20px;
        }
        p {
            font-size: 16px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
        }
        th, td {
            border: 1px solid #ddd;
            /* padding: 10px; */
            padding: 2px; /* Reduced padding for smaller spacing */
            font-size: 12px; /* Slightly reduced font size for compactness */
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
            color: #555;
        }
        td {
            background-color: #fafafa;
        }
        .table-heading {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #444;
        }
        .red{
            color:red;
        }
    </style>
</head>
<body>
    @if(!app()->environment('production'))
    <p><b>Note - This is a test mail</b></p>
    @endif
    <p><b>Dear MD,</b></p>

    <p>I have applied for the following PROMO.</p>
    <p class="red">**This is Auto Approval Applicable PROMO.**</p>
    <p><small>Auto Approved by system.</small></p>
    <p class="red"><b>{{$details['offerproduct'][0]["stock"]}} set(s) / no(s) left for the promotional campaign.</b></p>

    <p><u>Detail</u></p>

    <table>
        <thead>
          <tr>
            <th>Promo Code</th>
            <th>RM Name</th>
            <th>Dealer Code</th>
            <th>Dealer Name</th>
            <th>Region</th>
            <th>Transaction ID</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="color:orange;">{{ $details['offerproduct'][0]['promo_code'] }}</td>
            <td style="color:orange;">{{ $details['offerproduct'][0]['rm_name'] }}</td>
            <td>{{ $details['offerproduct'][0]['dealer_code'] }}</td>
            <td>{{ $details['offerproduct'][0]['dealer_name'] }}</td>
            <td style="color:orange;">{{ $details['offerproduct'][0]['region'] }}</td>
            <td style="color:orange;">{{ $details['offerproduct'][0]['order_id'] }}</td>
          </tr>
        </tbody>
    </table>

    <h3 class="table-heading">Offer Product(s)</h3>
    <table>
      <thead>
        <tr>
          <th>Offer Model</th>
          <th>Description</th>
          <th>Offer Type</th>
          <th>Product Type</th>
          <th>Price Type</th>
          <th>Price</th>
          <th>Qty</th>
        </tr>
      </thead>
      <tbody>
        @foreach($details['offerproduct'] as $offer)
        <tr>
          <td>{{ $offer["model_no"] }}</td>
          <td>{{ $offer["description"] }}</td>
          <td>{{ $offer["offer_type"] }}</td>
          <td>{{ $offer["product_type"] }}</td>
          <td>{{ $offer["price_type"] }}</td>
          <td>{{ $offer["order_price"] }}</td>
          <td>{{ $offer["order_qty"] }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <h3 class="table-heading">FOC Product(s)</h3>
    <table>
      <thead>
        <tr>
          <th>Offer Model</th>
          <th>Description</th>
          <th>Offer Type</th>
          <th>Product Type</th>
          <th>Price Type</th>
          <th>Price</th>
          <th>Qty</th>
        </tr>
      </thead>
      <tbody>
        @foreach($details['focproduct'] as $offer)
        <tr>
          <td>{{ $offer["model_no"] }}</td>
          <td>{{ $offer["description"] }}</td>
          <td>{{ $offer["offer_type"] }}</td>
          <td>{{ $offer["product_type"] }}</td>
          <td>{{ $offer["order_price"] == 0 ? ' - ' : $offer["price_type"] }}</td>
          <td>{{ $offer["order_price"] }}</td>
          <td>{{ $offer["order_qty"] }}</td>
        </tr>
        @endforeach 
      </tbody>
    </table>
    <p>Please check here.</p>

    <p>
      <a href="{{ url(request()->getSchemeAndHttpHost().'/admin/promotions/transaction-preview') }}/{{ Crypt::encrypt($details['offerproduct'][0]['order_id']) }}" class="link-black text-sm">
        <i class="fas fa-link mr-1"></i> Transaction View
      </a>
    </p>

</body>
</html>