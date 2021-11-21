![EmailCleaning.Club](assets/emailcleaningclublogo.png)

[EmailCleaning.Club](https://emailcleaning.club)
# emailcleaningclub-api
Simple cURL rest API calls to EmailCleaning.club endpoints. This script will make an email verification request.

Make sure to whitelist your servers IP address on your API key settings. If not, you wont be able to get any results.

Installation:

**Via composer:**

`composer require emailcleaningclub/cleanlist-php-api`

Sample call:

```php
<?php
/*
 * Sample call - Make sure to whitelist your servers ip address on your account in order to have proper responses
 */

require 'vendor/autoload.php';
use emailcleaningclub\Verification\Verification;
/* initialize the class with main configs */

$Start = new Verification("90C5626330E03D5C1799DF270AF7A114528B6F40");

/* sample call to check/verify an email address */
$payload = [
	"check" => "basic", // basic|advanced - if not provided "basic" check type is used.
	"email" => "john@smith.com" // email address
];
$results = $Start->_call($payload);
print_r($results);
?>
```

**Sample http cURL call:**

`
curl "https://api.emailcleaning.club/api/v1/?api_key={your_api_key}&email={email_address}&check={basic|advanced}"
`

**Responses:**

```
Array
(
    [code] => 401
    [message] => Unauthorized Access!
)
Invalid API key OR ip addess not whitelisted. 
```

```
Array
(
    [code] => 200
    [status] => role
    [risklevel] => risky
    [message] => Role Based Email - Role based emails reflect different departments/roles, like: admin@ or sales@. These emails are not bad emails or to avoid, just make sure to be cautious.
    [verification_type] => advanced
    [verification_cost] => 2
)

Risklevel can be: safe|risky|bad
Status reflects the verification code. In most cases it is a logical word reflecting the result. 
```

Common status codes:

| Code | Name | Description | Risklevel |
| --- | ---| --- | --- |
|duplicates|Duplicated Emails|Duplicated rows are removed from your file and only unique emails are scanned.| -
|invalid|Invalid Formatting|In general, this validates e-mail addresses against the syntax in RFC 822, with the exceptions that comments and whitespace folding and dotless domain names are not supported.|bad|
|nomx|Domain has no MX|The domain doesn't have any valid MX records, there is no way to possibly send emails to this domain.|bad|
|nons|Domain has no NS|The domain doesn't have any valid NS records, the domain might not have a website but its mailboxes can be active. Use with caution.|risky|
|parked|Domain is Parked|This domain is parked. In most cases the email addresses are accessible only by the webmaster, developer or only a small number of people. Use with coution if you need to.|risky|
|disposable|Disposable Email Domain|A disposable email address (DEA) is a pain to marketers and often an indication of fraudulent activity online. Alternatively, a DEA is just a way for a consumer to fight back against spam and bad opt-in protocols, or a good tool for developers to test software.|risk|
|baddomains|Bad Domain|This domain is blacklisted and its known to cause problems. Avoid if you can.|bad|
|blackhole|Blackhole Domain|Blackhole domains are used just for attracting spammers. These domains do no use any real MX but just to trap spammers.|bad|
|role|Role Based Email|Role based emails reflect different departments/roles, like: admin@ or sales@. These emails are not bad emails or to avoid, just make sure to be cautious.|risky|
|catchall|Catchall Email|A catch-all email address is a mailbox which captures emails sent to your domain name that may have otherwise been lost because the email address they are being sent to doesn't exist|bad|
|hardbounces|HardBounced Email|Hard bounce is an email that has failed to deliver for permanent reasons, such as the recipient's address is invalid (either because the domain name is incorrect, isn't real, or the recipient is unknown.)|bad|
|spamtraps|Spamtrap/Honeypot|A spamtrap is a honeypot used to collect spam. Spamtraps are usually e-mail addresses that are created not for communication, but rather to lure spam. In order to prevent legitimate email from being invited, the e-mail address will typically only be published in a location hidden from view such that an automated e-mail address harvester (used by spammers) can find the email address, but no sender would be encouraged to send messages to the email address for any legitimate purpose.|bad|
|botclickers|Botclicker|Email click bots are the close cousin to the SPAM bots, many designed to click links in emails as a way to explore, find, and exploit potential vulnerabilities.|bad|
|complainers|Complainer|For e-mailers, complainers are the people who hit the spam-complaint button on the messages they actually signed up to receive. You might think there's nothing to learn from these people.|risky|
|institutional|Institutional Domain|Domain used by a well known public or private institution. Government, education or military are considered institutional. |risky|
|possiblerisk|Known Problematic Emails|We do not have a fully detailed log for this group but we are sure this data is not 100% safe to use. Be cautious.|risky|
|badkeyword|Bad Keyword|The email address contains a word classified as bad in our systems. These emails are not always fake or bad so be cautious while sending to this category.|risky|
