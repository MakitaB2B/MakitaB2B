<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\PromoMail;
use Mail;

class PromoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

    /**
     * Create a new job instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // $email = new PromoMail($this->details);
        // Mail::to($this->details['email'])->cc($this->details['cc'])->bcc($this->details['bcc'])->send($email);

        //-----------------send grid for loop----------------

        // $sendemail = new \SendGrid\Mail\Mail();
        // $sendemail->setFrom("it_pm@makita.in", "Makita ERP");
        // $sendemail->setSubject('MakitaERP - Promotion Mail '.'(Promo Code -'.$this->details['offerproduct'][0]['promo_code'].')');
        // $recipients = $this->details['email'];
        // foreach ($recipients as $recipient) {
        //     $sendemail->addTo($recipient, "Example User");
        // }
       
        $emailContent = <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
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
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                    background-color: #fff;
                    border: 1px solid #ddd;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 2px;
                    font-size: 12px;
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
            <p><b>Note - This is a test mail</b></p>
            <p>We would like to approve the following promotion.</p>
            <p>{$this->details['textfromatmodelqty']}</p>
            <p>{$this->details['offerproduct'][0]['stock']} No's of {$this->details['offerproduct'][0]['model_no']} available.</p>
            <p>
                <a href="" class="link-black text-sm">Promotion Preview</a>
            </p>
            <p style="color:orange;">PROMO NO - {$this->details['offerproduct'][0]['promo_code']}</p>

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
        HTML;

        foreach ($this->details['offerproduct'] as $offer) {
            $emailContent .= "<tr>
                <td>{$offer['model_no']}</td>
                <td>{$offer['mrp']}</td>
                <td style='color: " . ($offer['price_type'] === 'DLP' ? 'orange' : '#444') . ";'>{$offer['dlp']}</td>
                <td style='color: " . ($offer['price_type'] === 'Best Price' ? 'orange' : '#444') . ";'>{$offer['best']}</td>
                <td style='color: " . ($offer['price_type'] === 'Special Price' ? 'orange' : '#444') . ";'>" . (isset($offer['price']) ? $offer['price'] : '-') . "</td>
                <td>{$offer['stock']}</td>
                <td>" . (isset($offer['ka01']) ? $offer['ka01'] : '-') . "</td>
                <td>" . (isset($offer['dl01']) ? $offer['dl01'] : '-') . "</td>
                <td>" . (isset($offer['gj01']) ? $offer['gj01'] : '-') . "</td>
                <td>" . (isset($offer['kl01']) ? $offer['kl01'] : '-') . "</td>
                <td>" . (isset($offer['tn01']) ? $offer['tn01'] : '-') . "</td>
                <td>" . (isset($offer['wb01']) ? $offer['wb01'] : '-') . "</td>
            </tr>";
        }

        $emailContent .= <<<HTML
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
        HTML;


        foreach ($this->details['focproduct'] as $offer) {
            $emailContent .= "<tr>
                <td>{$offer['model_no']}</td>
                <td>{$offer['mrp']}</td>
                <td style='color: " . ($offer['price_type'] === 'DLP' ? 'orange' : '#444') . ";'>{$offer['dlp']}</td>
                <td style='color: " . ($offer['price_type'] === 'Best Price' ? 'orange' : '#444') . ";'>{$offer['best']}</td>
                <td style='color: " . ($offer['price_type'] === 'Special Price' ? 'orange' : '#444') . ";'>" . (isset($offer['price']) ? $offer['price'] : '-') . "</td>
                <td>{$offer['stock']}</td>
                <td>" . (isset($offer['ka01']) ? $offer['ka01'] : '-') . "</td>
                <td>" . (isset($offer['dl01']) ? $offer['dl01'] : '-') . "</td>
                <td>" . (isset($offer['gj01']) ? $offer['gj01'] : '-') . "</td>
                <td>" . (isset($offer['kl01']) ? $offer['kl01'] : '-') . "</td>
                <td>" . (isset($offer['tn01']) ? $offer['tn01'] : '-') . "</td>
                <td>" . (isset($offer['wb01']) ? $offer['wb01'] : '-') . "</td>
            </tr>";
        }

        $emailContent .= <<<HTML
                </tbody>
            </table>
        </body>
        </html>
        HTML;

        // $sendemail->addContent("text/html", $emailContent);

        // $sendgrid = new \SendGrid(MakitaERPApiKey);

        // $response = $sendgrid->send($sendemail);

          //-----------------send grid for loop----------------



        // dd( $response);
    }


    public function retryUntil()
    {
        return now()->addSeconds(20); //->addMinutes(1); // Retry for 10 minutes
    }

    public function maxAttempts()
    {
        return 2; // Allow 5 attempts before failing
    }
}
