



<?php

// namespace App\Jobs;

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


$email = new Mail();

$email->setSubject('MakitaERP - Promotion Mail '.'(Promo Code -'.$this->details['offerproduct'][0]['promo_code'].')');

$toEmails = PROMO_TO;
$email->addTos($toEmails);

$ccEmails = PROMO_CC;
$email->addCcs($ccEmails);

$bccEmails = PROMO_BCC;
$email->addBccs($bccEmails);

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
$sendemail->setFrom("it_pm@makita.in", "Makita ERP");

// $email->setGlobalSubject("Sending with Twilio SendGrid is Fun and Global 2");

// $email->addContent(
//     "text/plain",
//     "and easy to do anywhere, even with PHP"
// );
$email->addContent(
    "text/html",
    "<strong>and easy to do anywhere, even with PHP</strong>"
);

// $contents = [
//     "text/calendar" => "Party Time!!",
//     "text/calendar2" => "Party Time 2!!"
// ];
$email->addContents($contents);

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
$email->enableBypassBounceManagement();
$email->enableBypassListManagement();
$email->enableBypassSpamManagement();
$email->enableBypassUnsubscribeManagement();
//$email->disableBypassListManagement();
$email->setFooter(true, "Footer", "<strong>Makita Erp</strong>");
$email->enableSandBoxMode();
//$email->disableSandBoxMode();
$email->setSpamCheck(true, 1,  $_SERVER['HTTP_HOST']);

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

$sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
try {
    $response = $sendgrid->send($email);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: '.  $e->getMessage(). "\n";
}