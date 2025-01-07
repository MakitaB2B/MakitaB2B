<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SendGrid\Mail\Mail;

class TransactionJob implements ShouldQueue
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
        $email = new Mail();
        $email->setSubject('MakitaERP - Promotion Transaction Mail');

        // Process recipients
        $toEmails = $this->details['email'];
        $ccEmails = $this->details['cc'];
        $bccEmails = $this->details['bcc'];

        $ccEmail = [];
        foreach ($ccEmails as $key => $value) {
            if (is_numeric($key)) {
                $ccEmail[$value] = '';
            } else {
                $ccEmail[$key] = $value;
            }
        }

        $email->addTos($toEmails);
        $email->addCcs($ccEmail);
        $email->addBccs($bccEmails);
        $email->setFrom(env('MakitaSendGridFrom'), "Makita ERP");

        $details = $this->details;

        $emailContent = <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Promotion Transaction Details</title>
        </head>
        <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f5f5f5;">
            <table role="presentation" style="width: 100%; max-width: 1000px; margin: 0 auto; background-color: #ffffff; border-spacing: 0;">
                <tr>
                    <td style="padding: 20px;">
                        <img src="https://makita.in/wp-content/themes/Makita/img/logo.jpg" alt="Company Logo" style="max-width: 200px; height: auto; display: block;">
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px 20px;">
                        <h1 style="color: #008290; font-size: 24px; margin: 0 0 20px; text-align: center;">Promotion Transaction Details</h1>
                        <table role="presentation" style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td align="center" style="background-color: #008290;">
                                    <p style="color: #ffffff; font-size: 18px; font-weight: bold; margin: 20px auto;">PROMO NO - {$details['offerproduct'][0]['promo_code']}</p>
                                </td>
                            </tr>
                        </table>
                        <p style="margin: 0 0 15px; color: #333;">I have applied for the following PROMO.</p>
                        <p style="color: #ff0000; font-weight: bold;">**This is Auto Approval Applicable PROMO.**</p>
                        <p style="margin: 0; color: #ff0000; font-weight: bold;">{$details['offerproduct'][0]['stock']} set(s) / no(s) left.</p>
                        <h2 style="color: #008290; font-size: 20px; margin: 30px 0 15px;">Transaction Details</h2>
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #008290; color: #fff;">
                                    <th style="padding: 10px;">Promo Code</th>
                                    <th style="padding: 10px;">RM Name</th>
                                    <th style="padding: 10px;">Dealer Code</th>
                                    <th style="padding: 10px;">Dealer Name</th>
                                    <th style="padding: 10px;">Region</th>
                                    <th style="padding: 10px;">Transaction ID</th>
                                    <th style="padding: 10px;">Customer PO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 10px;">{$details['offerproduct'][0]['promo_code']}</td>
                                    <td style="padding: 10px;">{$details['offerproduct'][0]['rm_name']}</td>
                                    <td style="padding: 10px;">{$details['offerproduct'][0]['dealer_code']}</td>
                                    <td style="padding: 10px;">{$details['offerproduct'][0]['dealer_name']}</td>
                                    <td style="padding: 10px;">{$details['offerproduct'][0]['region']}</td>
                                    <td style="padding: 10px;">{$details['offerproduct'][0]['order_id']}</td>
                                    <td style="padding: 10px;">PR{$details['offerproduct'][0]['promo_code']}-{$details['offerproduct'][0]['order_id']}</td>
                                </tr>
                            </tbody>
                        </table>
                        <h2 style="color: #008290; font-size: 20px; margin: 30px 0 15px;">Offer Product(s)</h2>
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #008290; color: #fff;">
                                    <th style="padding: 10px;">MODEL</th>
                                    <th style="padding: 10px;">DESCRIPTION</th>
                                    <th style="padding: 10px;">OFFER TYPE</th>
                                    <th style="padding: 10px;">PRODUCT TYPE</th>
                                    <th style="padding: 10px;">PRICE TYPE</th>
                                    <th style="padding: 10px;">UNIT PRICE</th>
                                    <th style="padding: 10px;">QTY</th>
                                    <th style="padding: 10px;">TOTAL PRICE</th>
                                </tr>
                            </thead>
                            <tbody>
HTML;

        foreach ($details['offerproduct'] as $offer) {
            $emailContent .= "
                <tr>
                    <td style='padding: 10px;'>{$offer['model_no']}</td>
                    <td style='padding: 10px;'>{$offer['description']}</td>
                    <td style='padding: 10px;'>{$offer['offer_type']}</td>
                    <td style='padding: 10px;'>{$offer['product_type']}</td>
                    <td style='padding: 10px;'>{$offer['price_type']}</td>
                    <td style='padding: 10px;'>{$offer['offer_price']}</td>
                    <td style='padding: 10px;'>{$offer['order_qty']}</td>
                    <td style='padding: 10px;'>{$offer['order_price']}</td>
                </tr>";
        }

        $emailContent .= <<<HTML

                            </tbody>
                        </table>
                        <h2 style="color: #008290;">FOC Product(s)</h2>
                        <p>FOC product details here.</p>
                    </td>
                </tr>
            </table>
        </body>
        </html>
HTML;

        $email->addContent("text/html", $emailContent);

        try {
            $apiKey = env('MakitaERPApiKey');
            $sendgrid = new \SendGrid($apiKey);
            $response = $sendgrid->send($email);
        } catch (\Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
        }
    }

    public function retryUntil()
    {
        return now()->addSeconds(20);
    }

    public function maxAttempts()
    {
        return 2;
    }
}
