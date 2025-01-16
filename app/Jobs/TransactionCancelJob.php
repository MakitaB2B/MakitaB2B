<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SendGrid\Mail\Mail;
// use App\Mail\TransactionMail;
// use Mail;
class TransactionCancelJob implements ShouldQueue
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

        $email->setSubject('MakitaERP - Promotion Transaction Cancellation Mail');


        $toEmails = $this->details['email'];
        $ccEmails = $this->details['cc'];
        $ccEmail = [];

        foreach (  $ccEmails as $key => $value) {
            if (is_numeric($key)) {
                $ccEmail[$value] = '';
            } else {
                $ccEmail[$key] = $value;
            }
        }
        
        $bccEmails = $this->details['bcc'];
      
        $email->addTos($toEmails);
        $email->addCcs($ccEmail);
        $email->addBccs($bccEmails);
        // $email->setReplyTo(PROMO_TRANSACTION_FROM_EMAILS, "");
      
        // $email->setFrom(PROMO_TRANSACTION_FROM_EMAILS, "Makita ERP");
        $email->setFrom(MakitaSendGridFrom, "Makita ERP");

     
        // $sendemail->addContent("text/html", $emailContent);
        $details=$this->details;
        // $emailContent = view('mails.transactionmail', compact('details'))->render();

        $orderId = \Crypt::encrypt($details['offerproduct'][0]['order_id']);
        $orderIdEncoded = urlencode($orderId);

        $emailContent = <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Promotion Transaction Cancellation</title>
        </head>
        <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f5f5f5;">
            <!-- Email Container -->
            <table role="presentation" style="width: 100%; max-width: 1000px; margin: 0 auto; background-color: #ffffff; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                <!-- Header -->
                <tr>
                    <td style="padding: 20px;">
                        <img src="https://makita.in/wp-content/themes/Makita/img/logo.jpg" alt="Company Logo" style="max-width: 200px; height: auto; display: block;">
                    </td>
                </tr>
        
                <!-- Main Content -->
                <tr>
                    <td style="padding: 20px 20px;">
                        <!-- Cancellation Title -->
                        <h1 style="color: #008290; font-size: 24px; margin: 0 0 20px; text-align: center; font-family: Arial, sans-serif;">Promotion Transaction Cancellation</h1>
                        
                        <!-- Cancellation Status -->
                        <table role="presentation" style="width: 100%; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                            <tr>
                                <td align="center" style="background-color: #008290;">
                                    <p style="color: #ffffff; font-size: 18px; font-weight: bold; text-align: center; width: 200px; margin: 20px auto; background-color: #008290; line-height: 1; border-radius: 5px;">Order ID - {$details['offerproduct'][0]['order_id']}</p>
                                </td>
                            </tr>
                        </table>
        
                        <!-- Cancellation Details -->
                        <table role="presentation" style="width: 100%; border-collapse: collapse; margin-bottom: 30px; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                            <tr>
                                <td style="background-color: #f5f5f5; padding: 20px;">
                                    <p style="margin: 0 0 15px; color: #ff0000; font-weight: bold; font-size: 18px;">Cancelled!</p>
                                    <p style="margin: 0; color: #ff0000; line-height: 1.6;">Order has been cancelled by {$details['canceledby']}.</p>
                                </td>
                            </tr>
                        </table>
        
                        <!-- Transaction Details Table -->
                        <h2 style="color: #008290; font-size: 20px; margin: 30px 0 15px; font-family: Arial, sans-serif;">Transaction Details</h2>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <thead>
                                    <tr style="background-color: #008290;">
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">PROMO CODE</th>
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">RM NAME</th>
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">DEALER CODE</th>
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">DEALER NAME</th>
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">REGION</th>
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">ORDER ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 10px; border: 1px solid #dddddd;">{$details['offerproduct'][0]['promo_code']}</td>
                                        <td style="padding: 10px; border: 1px solid #dddddd;">{$details['offerproduct'][0]['rm_name']}</td>
                                        <td style="padding: 10px; border: 1px solid #dddddd;">{$details['offerproduct'][0]['dealer_code']}</td>
                                        <td style="padding: 10px; border: 1px solid #dddddd;">{$details['offerproduct'][0]['dealer_name']}</td>
                                        <td style="padding: 10px; border: 1px solid #dddddd;">{$details['offerproduct'][0]['region']}</td>
                                        <td style="padding: 10px; border: 1px solid #dddddd;">{$details['offerproduct'][0]['order_id']}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
        
                        <!-- Offer Products Table -->
                        <h2 style="color: #008290; font-size: 20px; margin: 30px 0 15px; font-family: Arial, sans-serif;">Offer Product(s)</h2>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <thead>
                                    <tr style="background-color: #008290;">
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">MODEL</th>
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">DESCRIPTION</th>
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">OFFER TYPE</th>
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">PRODUCT TYPE</th>
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">PRICE TYPE</th>
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">PRICE</th>
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">QTY</th>
                                    </tr>
                                </thead>
                                <tbody>
        HTML;
                              
                                foreach ($details['offerproduct'] as $offer) {
                                    $emailContent .= "
                                        <tr>
                                            <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['model_no']}</td>
                                            <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['description']}</td>
                                            <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['offer_type']}</td>
                                            <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['product_type']}</td>
                                            <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['price_type']}</td>
                                            <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['order_price']}</td>
                                            <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['order_qty']}</td>
                                        </tr>";
                                }

                                $emailContent .= <<<HTML
                                </tbody>
                            </table>
                        </div>
                        HTML;
                                if ($this->details['focproduct']->isNotEmpty()) {

                                    $emailContent .= <<<HTML
                                                <!-- FOC Products Table -->
                                                <h2 style="color: #008290; font-size: 20px; margin: 30px 0 15px; font-family: Arial, sans-serif;">FOC Product(s)</h2>
                                                <div style="overflow-x: auto;">
                                                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                        <thead>
                                                            <tr style="background-color: #008290;">
                                                                <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">MODEL</th>
                                                                <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">DESCRIPTION</th>
                                                                <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">OFFER TYPE</th>
                                                                <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">PRODUCT TYPE</th>
                                                                <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">PRICE TYPE</th>
                                                                <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">PRICE</th>
                                                                <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">QTY</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                HTML;

                                foreach ($details['focproduct'] as $offer) {
                                    $emailContent .= "
                                        <tr>
                                            <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['model_no']}</td>
                                            <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['description']}</td>
                                            <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['offer_type']}</td>
                                            <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['product_type']}</td>
                                            <td style='padding: 10px; border: 1px solid #dddddd;'>" . ($offer['order_price'] == 0 ? ' - ' : $offer['price_type']) . "</td>
                                            <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['order_price']}</td>
                                            <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['order_qty']}</td>
                                        </tr>";
                                }
                                $emailContent .= "</tbody>
                                </table>
                                </div>";}
                                $emailContent .= <<<HTML
                                         </td>
                                         </tr>
                                <!-- <tr>
                                <td style="padding: 10px; padding-bottom: 40px;">
                                    <table role="presentation" style="width: 100%; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                        <tr>
                                            <td align="center">
                                                <div style="width: 250px; margin: 0 auto;">
                                                    <table role="presentation" style="width: 100%; border-collapse: separate; border-spacing: 0;">
                                                        <tr>
                                                            <td align="center" style="border-radius: 8px;">
                                                            <a href="' . url(request()->getSchemeAndHttpHost() . '/admin/promotions/transaction-preview/' . $orderIdEncoded) . '"
                                                            style="display: block; padding: 12px 20px; color: #008290; font-size: 16px;">Transaction View</a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                </tr> -->

                                <!-- Footer -->
                               
                                <tr>
                                <td style="padding: 20px; background-color: #008290; color: #ffffff; text-align: center;">
                                    <p style="margin: 0 0 10px;">Contact us for more information</p>
                                    <p style="margin: 0;">&copy;2025 Makita India. All rights reserved.</p>
                                </td>
                                </tr>
                                </table>
                                </body>
                                </html>
                                HTML;

                                
        $email->addContent("text/html", $emailContent);

        try {

            $apiKey = MakitaERPApiKey;//env('MakitaERPApiKey');
            $sendgrid = new \SendGrid($apiKey);
            $response = $sendgrid->send($email);
            // print $response->statusCode() . "\n";
            // print_r($response->headers());
            // print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '.  $e->getMessage(). "\n";
        }

    }

    public function retryUntil()
    {
        return now()->addSeconds(20);  //->addMinutes(1); // Retry for 10 minutes
    }

    public function maxAttempts()
    {
        return 2; // Allow 5 attempts before failing
    }
}
