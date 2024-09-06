<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    </style>
</head>
<body>

    <p>We would like to approve the following promotion.</p>

    {{-- You can uncomment and use the following text format model and quantity if needed --}}
    {{-- <p>{{ $textfromatmodelqty }}</p> --}}

    {{-- You can also use the stock information if needed --}}
    {{-- <p>{{ $offerproduct[0]["stock"] }} No's of {{ $offerproduct[0]["model_no"] }} available.</p> --}}

    <p>Please check the link below to view the Promotion Preview:</p>

    {{-- Uncomment the link below when needed --}}
    {{-- 
    <p>
      <a href="{{ url('admin/promotions/promotion-preview/' . Crypt::encrypt($offerproduct[0]["promo_code"] ?? null)) }}" class="link-black text-sm">
        <i class="fas fa-link mr-1"></i> Promotion Preview
      </a>
    </p>
    <p>PROMO NO - {{ $offerproduct[0]->promo_code }}</p> 
    --}}

    <h3 class="table-heading">Offer Product(s)</h3>
    <table>
      <thead>
        <tr>
          <th>Offer Model</th>
          <th>MRP</th>
          <th>DLP</th>
          <th>BEST</th>
          <th>SPECIAL</th>
          <th>TOTAL STOCK</th>
          <th>HO</th>
          <th>DELHI</th>
          <th>Gujarat</th>
          <th>Kerala</th>
          <th>Chennai</th>
          <th>Kolkata</th>
        </tr>
      </thead>
      <tbody>
        {{-- @foreach($offerproduct as $offer) --}}
        <tr>
          {{-- <td>{{ $offer->model_no }}</td>
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
          <td>{{ $offer->wb01 ?? '-' }}</td> --}}
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
          <th>TOTAL STOCK</th>
          <th>HO</th>
          <th>DELHI</th>
          <th>Gujarat</th>
          <th>Kerala</th>
          <th>Chennai</th>
          <th>Kolkata</th>
        </tr>
      </thead>
      <tbody>
        {{-- @foreach($focproduct as $offer) --}}
        <tr>
          {{-- <td>{{ $offer->model_no }}</td>
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
          <td>{{ $offer->wb01 ?? '-' }}</td> --}}
        </tr>
        {{-- @endforeach --}}
      </tbody>
    </table>

</body>
</html>
