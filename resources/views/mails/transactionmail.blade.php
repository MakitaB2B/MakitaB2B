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
            padding: 10px;
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

    <p><b>Dear MD,</b></p>

    <p>I have applied for the following PROMO.</p>
    <p class="red">**This is Auto Approval Applicable PROMO.**</p>
    <p><small>Auto Approved by system.</small></p>
    <p class="red"><b>102 set(s) / no(s) left for the promotional campaign.</b></p>

    <p><u>Detail</u></p>

    <table>
        <thead>
          <tr>
            <th>Promo Code</th>
            <th>Dealer Code</th>
            <th>Dealer Name</th>
          </tr>
        </thead>
        <tbody>
          {{-- @foreach($details['offerproduct'] as $offer) --}}
          <tr>
            <td>Promo Code</td>
            <td>Dealer Code</td>
            <td>Dealer Name</td>
          </tr>
          {{-- @endforeach --}}
        </tbody>
    </table>

    <h3 class="table-heading">Offer Product(s)</h3>
    <table>
      <thead>
        <tr>
          <th>Offer Model</th>
          <th>Desscription</th>
          <th>Price Type</th>
          <th>Price</th>
          <th>Qty</th>
        </tr>
      </thead>
      <tbody>
        {{-- @foreach($details['offerproduct'] as $offer) --}}
        <tr>
          <td>Offer Model</td>
          <td>Offer Model</td>
          <td>Offer Model</td>
          <td>Offer Model</td>
          <td>Offer Model</td>
          
        </tr>
        {{-- @endforeach --}}
      </tbody>
    </table>

    <h3 class="table-heading">FOC Product(s)</h3>
    <table>
      <thead>
        <tr>
          <th>FOC Model</th>
          <th>MRP</th>
          <th>DLP</th>
          <th>BEST</th>
          <th>SPECIAL</th>
        </tr>
      </thead>
      <tbody>

        <tr>
            <td>Offer Model</td>
            <td>Offer Model</td>
            <td>Offer Model</td>
            <td>Offer Model</td>
            <td>Offer Model</td>
        </tr>
        {{-- @foreach($details['focproduct'] as $offer)
        <tr>
          <td>{{ $offer->model_no }}</td>
          <td>{{ $offer->mrp }}</td>
          <td>{{ $offer->dlp }}</td>
          <td>{{ $offer->best }}</td>
          <td>{{ $offer->price ?? '-' }}</td>
          <td>{{ $offer->stock }}</td>
          <td>{{ $offer->ka01 ?? '-' }}</td>
          <td>{{ $offer->dl01 ?? '-' }}</td>
          <td>{{ $offer->gj01 ?? '-' }}</td>
          <td>{{ $offer->kl01 ?? '-' }}</td>
          <td>{{ $offer->tn01 ?? '-' }}</td>
          <td>{{ $offer->wb01 ?? '-' }}</td>
        </tr>
        @endforeach --}}
      </tbody>
    </table>
    <p>Please check here.</p>

</body>
</html>