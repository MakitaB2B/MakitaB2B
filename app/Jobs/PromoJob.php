<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SendGrid\Mail\Mail;
// use App\Mail\PromoMail;
// use Mail;

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

        //----------------------------


        $email = new Mail();

        $email->setSubject('MakitaERP - Promotion Mail '.'(Promo Code -'.$this->details['offerproduct'][0]['promo_code'].')');

        $toEmails = PROMO_TO;
        $email->addTos($toEmails);

        $ccEmails = PROMO_CC;
        $email->addCcs($ccEmails);

        $bccEmails = PROMO_BCC;
        $email->addBccs($bccEmails);
      
        $email->setFrom(MakitaSendGridFrom,"Makita ERP");
        // $sendgrid->setFrom("it_pm@makita.in", "Makita ERP");

        $emailContent = <<<HTML
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Special Promotion Announcement</title>
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
                            <!-- Promotion Title -->
                            <h1 style="color: #008290; font-size: 24px; margin: 0 0 20px; text-align: center; font-family: Arial, sans-serif;">Promotion Announcement</h1>
                            
                            <!-- Test Environment Notice -->
                            <!-- <table role="presentation" style="width: 100%; border-collapse: collapse; margin-bottom: 20px; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tr>
                                    <td style="background-color: #f5f5f5; padding: 15px; text-align: center;">
                                        <p style="margin: 0; color: #ff0000; font-weight: bold;">Note - This is a test mail</p>
                                    </td>
                                </tr>
                            </table> -->

                            <!-- Promotion Number -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tr>
                                    <td align="center" style="background-color: #008290;">
                                        <p style="color: #ffffff; font-size: 18px; font-weight: bold; text-align: center; width: 200px; margin: 20px auto; background-color: #008290; line-height: 1; border-radius: 5px;">PROMO NO - {$this->details['offerproduct'][0]['promo_code']}</p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Promotion Details -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin-bottom: 30px; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tr>
                                    <td style="background-color: #f5f5f5; padding: 20px;">
                                        <p style="margin: 0 0 15px; color: #333333; line-height: 1.6;">We would like to approve the following promotion:</p>
                                        <p style="margin: 0 0 10px; color: #333333; line-height: 1.6;">{$this->details['textfromatmodelqty']}</p>
                                        <p style="margin: 0; color: #333333; line-height: 1.6;">{$this->details['offerproduct'][0]['stock']} No's of {$this->details['offerproduct'][0]['model_no']} available.</p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Offer Products Table -->
                            <h2 style="color: #008290; font-size: 20px; margin: 30px 0 15px; font-family: Arial, sans-serif;">Offer Product(s)</h2>
                            <div style="overflow-x: auto;">
                                <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                    <thead>
                                        <tr style="background-color: #008290;">
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">MODEL</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">MRP</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">DLP</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">BEST</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">SPECIAL</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">STOCK</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">HO</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">DELHI</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">GUJARAT</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">KERALA</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">CHENNAI</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">KOLKATA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
            HTML;

            foreach ($this->details['offerproduct'] as $offer) {
                $emailContent .= "
                        <tr>
                            <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['model_no']}</td>
                            <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['mrp']}</td>
                            <td style='padding: 10px; border: 1px solid #dddddd; color: " . ($offer['price_type'] === 'DLP' ? '#008290' : '#444') . ";'>{$offer['dlp']}</td>
                            <td style='padding: 10px; border: 1px solid #dddddd; color: " . ($offer['price_type'] === 'Best Price' ? '#008290' : '#444') . ";'>{$offer['best']}</td>
                            <td style='padding: 10px; border: 1px solid #dddddd; color: " . ($offer['price_type'] === 'Special Price' ? '#008290' : '#444') . ";'>" . (isset($offer['price']) ? $offer['price'] : '-') . "</td>
                            <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['stock']}</td>
                            <td style='padding: 10px; border: 1px solid #dddddd;'>" . (isset($offer['ka01']) ? $offer['ka01'] : '-') . "</td>
                            <td style='padding: 10px; border: 1px solid #dddddd;'>" . (isset($offer['dl01']) ? $offer['dl01'] : '-') . "</td>
                            <td style='padding: 10px; border: 1px solid #dddddd;'>" . (isset($offer['gj01']) ? $offer['gj01'] : '-') . "</td>
                            <td style='padding: 10px; border: 1px solid #dddddd;'>" . (isset($offer['kl01']) ? $offer['kl01'] : '-') . "</td>
                            <td style='padding: 10px; border: 1px solid #dddddd;'>" . (isset($offer['tn01']) ? $offer['tn01'] : '-') . "</td>
                            <td style='padding: 10px; border: 1px solid #dddddd;'>" . (isset($offer['wb01']) ? $offer['wb01'] : '-') . "</td>
                        </tr>";
            }

            $emailContent .= "</tbody></table></div>";

            if ($this->details['focproduct']->isNotEmpty()) {
                $emailContent .= <<<HTML
                            <!-- FOC Products Table -->
                            <h2 style="color: #008290; font-size: 20px; margin: 30px 0 15px; font-family: Arial, sans-serif;">FOC Product(s) / Special Offer Product(s)</h2>
                            <div style="overflow-x: auto;">
                                <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                    <thead>
                                        <tr style="background-color: #008290;">
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">MODEL</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">MRP</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">DLP</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">BEST</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">SPECIAL</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">STOCK</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">HO</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">DELHI</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">GUJARAT</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">KERALA</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">CHENNAI</th>
                                            <th style="padding: 10px; text-align: left; border: 1px solid #dddddd; color: #ffffff;">KOLKATA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
            HTML;

                foreach ($this->details['focproduct'] as $offer) {
                    $emailContent .= "
                        <tr>
                            <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['model_no']}</td>
                            <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['mrp']}</td>
                            <td style='padding: 10px; border: 1px solid #dddddd; color: " . ($offer['price_type'] === 'DLP' ? '#008290' : '#444') . ";'>{$offer['dlp']}</td>
                            <td style='padding: 10px; border: 1px solid #dddddd; color: " . ($offer['price_type'] === 'Best Price' ? '#008290' : '#444') . ";'>{$offer['best']}</td>
                            <td style='padding: 10px; border: 1px solid #dddddd; color: " . ($offer['price_type'] === 'Special Price' ? '#008290' : '#444') . ";'>" . (isset($offer['price']) ? $offer['price'] : '-') . "</td>
                            <td style='padding: 10px; border: 1px solid #dddddd;'>{$offer['stock']}</td>
                            <td style='padding: 10px; border: 1px solid #dddddd;'>" . (isset($offer['ka01']) ? $offer['ka01'] : '-') . "</td>
                            <td style='padding: 10px; border: 1px solid #dddddd;'>" . (isset($offer['dl01']) ? $offer['dl01'] : '-') . "</td>
                            <td style='padding: 10px; border: 1px solid #dddddd;'>" . (isset($offer['gj01']) ? $offer['gj01'] : '-') . "</td>
                            <td style='padding: 10px; border: 1px solid #dddddd;'>" . (isset($offer['kl01']) ? $offer['kl01'] : '-') . "</td>
                            <td style='padding: 10px; border: 1px solid #dddddd;'>" . (isset($offer['tn01']) ? $offer['tn01'] : '-') . "</td>
                            <td style='padding: 10px; border: 1px solid #dddddd;'>" . (isset($offer['wb01']) ? $offer['wb01'] : '-') . "</td>
                        </tr>";
                }

                $emailContent .= "</tbody></table></div>";
            }

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
                                                        <a href="#" style="display: block; padding: 12px 20px; color: #008290; font-size: 16px;">View Promotion Preview</a>
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

     
        // $sendemail->addContent("text/html", $emailContent);

        $email->addContent("text/html", $emailContent);

  
        // try {
            $apiKey = MakitaERPApiKey; //env('MakitaERPApiKey');
            $sendgrid = new \SendGrid($apiKey);
            $response = $sendgrid->send($email);
        //     print $response->statusCode() . "\n";
        //     print_r($response->headers());
        //     print $response->body() . "\n";
        // } catch (Exception $e) {
        //     echo 'Caught exception: '.  $e->getMessage(). "\n";
        // }


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



















//----------------------




// $email->addHeader("X-Test1", "Test1");
// $email->addHeader("X-Test2", "Test2");
// $headers = [
//     "X-Test3" => "Test3",
//     "X-Test4" => "Test4",
// ];
// $email->addHeaders($headers);

// $email->addDynamicTemplateData("subject1", "Example Subject 1");
// $email->addDynamicTemplateData("name1", "Example Name 1");
// $email->addDynamicTemplateData("city1", "Denver");
// $substitutions = [
//     "subject2" => "Example Subject 2",
//     "name2" => "Example Name 2",
//     "city2" => "Orange"
// ];
// $email->addDynamicTemplateDatas($substitutions);

// $email->addCustomArg("marketing1", "false");
// $email->addCustomArg("transactional1", "true");
// $email->addCustomArg("category", "name");
// $customArgs = [
//     "marketing2" => "true",
//     "transactional2" => "false",
//     "category" => "name"
// ];

// $email->addCustomArgs($customArgs);

// $email->setSendAt(1461775051);


// The values below this comment are global to an entire message

// $email->setFrom("test@example.com", "Twilio SendGrid");


// $email->setGlobalSubject("Sending with Twilio SendGrid is Fun and Global 2");

// $email->addContent(
//     "text/plain",
//     "and easy to do anywhere, even with PHP"
// );


// $contents = [
//     "text/calendar" => "Party Time!!",
//     "text/calendar2" => "Party Time 2!!"
// ];
// $email->addContents($contents);

// $email->addAttachment(
//     "base64 encoded content1",
//     "image/png",
//     "banner.png",
//     "inline",
//     "Banner"
// );


// $attachments = [
//     [
//         "base64 encoded content2",
//         "image/jpeg",
//         "banner2.jpeg",
//         "attachment",
//         "Banner 3"
//     ],
//     [
//         "base64 encoded content3",
//         "image/gif",
//         "banner3.gif",
//         "inline",
//         "Banner 3"
//     ]
// ];
// $email->addAttachments($attachments);

// $email->setTemplateId("d-13b8f94fbcae4ec6b75270d6cb59f932");

// $email->addGlobalHeader("X-Day", "Monday");
// $globalHeaders = [
//     "X-Month" => "January",
//     "X-Year" => "2017"
// ];
// $email->addGlobalHeaders($globalHeaders);

// $email->addSection("%section1%", "Substitution for Section 1 Tag");
// $sections = [
//     "%section3%" => "Substitution for Section 3 Tag",
//     "%section4%" => "Substitution for Section 4 Tag"
// ];
// $email->addSections($sections);

// $email->addCategory("Category 1");
// $categories = [
//     "Category 2",
//     "Category 3"
// ];
// $email->addCategories($categories);

// $email->setBatchId(
//     "MWQxZmIyODYtNjE1Ni0xMWU1LWI3ZTUtMDgwMDI3OGJkMmY2LWEzMmViMjYxMw"
// );

// $email->setReplyTo("dx+replyto2@example.com", "DX Team Reply To 2");

// $email->setAsm(1, [1, 2, 3, 4]);

// $email->setIpPoolName("23");

// Mail Settings
// $email->setBccSettings(true, "bcc@example.com");
// Note: Bypass Spam, Bounce, and Unsubscribe management cannot
// be combined with Bypass List Management
// $email->enableBypassBounceManagement();
// $email->enableBypassListManagement();
// $email->enableBypassSpamManagement();
// $email->enableBypassUnsubscribeManagement();
//$email->disableBypassListManagement();
// $email->setFooter(true, "Footer", "<strong>Makita Erp</strong>");
// $email->enableSandBoxMode();
//$email->disableSandBoxMode();
// $email->setSpamCheck(true, 1,  $_SERVER['HTTP_HOST']);

// Tracking Settings
// $email->setClickTracking(true, true);
// $email->setOpenTracking(true, "--sub--");
// $email->setSubscriptionTracking(
//     true,
//     "subscribe",
//     "<bold>subscribe</bold>",
//     "%%sub%%"
// );

// $email->setGanalytics(
//     true,
//     "utm_source",
//     "utm_medium",
//     "utm_term",
//     "utm_content",
//     "utm_campaign"
// );

// $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
// try {
//     $response = $sendgrid->send($email);
//     print $response->statusCode() . "\n";
//     print_r($response->headers());
//     print $response->body() . "\n";
// } catch (Exception $e) {
//     echo 'Caught exception: '.  $e->getMessage(). "\n";
// }