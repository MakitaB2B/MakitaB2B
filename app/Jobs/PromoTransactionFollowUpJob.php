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
class PromoTransactionFollowUpJob implements ShouldQueue                   
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    protected $email;
    /**
     * Create a new job instance.
     */
    public function __construct($email,$details)
    {
        $this->details = $details;
        $this->email = $email;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = new Mail();
        $email->setSubject('MakitaERP - Promo Transaction Follow Up Mail');

        $toEmails = $this->email;
        $ccEmails = PROMO_FOLLOWUP_CC;
    
        $email->addTos($toEmails);
        $email->addCcs($ccEmails);

        $email->setFrom(MakitaSendGridFrom, "Makita ERP");
        $details=$this->details;
 
        $emailContent = <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Promo Transaction Follow Up</title>
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
                        <!-- Title -->
                        <h1 style="color: #008290; font-size: 24px; margin: 0 0 20px; text-align: center; font-family: Arial, sans-serif;">Promo Transaction Follow Up</h1>
        
                        <!-- Environment Notice -->
                    </td>
                </tr>
            </table>
        </body>
        </html>
        HTML;
        if (!app()->environment('production')) {
            $emailContent .= <<<HTML
                        <table role="presentation" style="width: 100%; border-collapse: collapse; margin-bottom: 20px; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                            <tr>
                                <td style="background-color: #f5f5f5; padding: 15px; text-align: center;">
                                    <p style="margin: 0; color: #ff0000; font-weight: bold;">Note - This is a test mail</p>
                                </td>
                            </tr>
                        </table>
        HTML;
        }

        $emailContent .= <<<HTML
                        <!-- Follow Up Details -->
                        <table role="presentation" style="width: 100%; border-collapse: collapse; margin-bottom: 30px; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                            <tr>
                                <td style="background-color: #f5f5f5; padding: 20px;">
                                    <p style="margin: 0 0 15px; color: #333333; line-height: 1.6;">List of Dealers to be followed up for today - {$details[0]['rm_name']}</p>
                                    <p style="margin: 0; color: #008290; font-weight: bold;">RM Name - {$details[0]['rm_name']}</p>
                                </td>
                            </tr>
                        </table>

                        <!-- Follow Up List Table -->
                        <h2 style="color: #008290; font-size: 20px; margin: 30px 0 15px; font-family: Arial, sans-serif;">Follow Up List</h2>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <thead>
                                    <tr style="background-color: #008290;">
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">TRANSACTION ID</th>
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">PROMO CODE</th>
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">ORDER DATE</th>
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">ORDER STATUS</th>
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">CANCELLING BY</th>
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">DEALER CODE</th>
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">DEALER NAME</th>
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">DEALER EMAIL</th>
                                        <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">ORDER DETAILS</th>
                                    </tr>
                                </thead>
                                <tbody>
        HTML;

        foreach ($details as $offer) {
            $merged_data = json_decode($offer['merged_data'], true);
            
            $emailContent .= "
                    <tr>
                        <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['order_id']}</td>
                        <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['promo_code']}</td>
                        <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['order_date']}</td>
                        <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['status']}</td>
                        <td style='padding: 10px; border: 1px solid #dddddd;'>" . \Carbon\Carbon::parse($offer['order_date'])->addDays(3)->format('d-m-Y') . "</td>
                        <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['dealer_code']}</td>
                        <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['dealer_name']}</td>
                        <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['dealer_email']}</td>
                        <td style='padding: 10px; border: 1px solid #dddddd;'>
                            <table style='width: 100%; border-collapse: collapse; margin: 0; mso-table-lspace: 0pt; mso-table-rspace: 0pt;'>
                                <thead>
                                    <tr style='background-color: #f0f9fa;'>
                                        <th style='padding: 8px; text-align: left; border: 1px solid #dddddd; color: #008290; font-size: 12px;'>MODEL NO</th>
                                        <th style='padding: 8px; text-align: left; border: 1px solid #dddddd; color: #008290; font-size: 12px;'>ORDER QTY</th>
                                        <th style='padding: 8px; text-align: left; border: 1px solid #dddddd; color: #008290; font-size: 12px;'>BILLED QTY</th>
                                        <th style='padding: 8px; text-align: left; border: 1px solid #dddddd; color: #008290; font-size: 12px;'>PRODUCT TYPE</th>
                                    </tr>
                                </thead>
                                <tbody>";

                                foreach ($merged_data as $item) {
                                    $emailContent .= "
                                                        <tr>
                                                            <td style='padding: 8px; border: 1px solid #dddddd; font-size: 12px;'>{$item['model_no']}</td>
                                                            <td style='padding: 8px; border: 1px solid #dddddd; font-size: 12px;'>{$item['order_qty']}</td>
                                                            <td style='padding: 8px; border: 1px solid #dddddd; font-size: 12px;'>" . ($item['billed_qty'] ?? 'N/A') . "</td>
                                                            <td style='padding: 8px; border: 1px solid #dddddd; font-size: 12px;'>{$item['product_type']}</td>
                                                        </tr>";
                                }

                                $emailContent .= "
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>";
                            }

                            $emailContent .= <<<HTML
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 20px; background-color: #008290; color: #ffffff; text-align: center;">
                            <p style="margin: 0 0 10px;">Contact us for more information</p>
                            <p style="margin: 0;">©2025 Makita India. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </body>
            </html>
            HTML;

        
        $email->addContent("text/html", $emailContent);
        $apiKey = MakitaERPApiKey; // env('MakitaERPApiKey');
        $sendgrid = new \SendGrid($apiKey);
        $response = $sendgrid->send($email);
       
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

