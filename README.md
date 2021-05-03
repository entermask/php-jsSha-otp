# php-jsSha-otp
Based on jsSha library to get otp Google Authenticator.

# How to use

Just include GoogleOtp.php file and call the generate function to get google OTP, don't forget to change your secret key.

```php
require_once('GoogleOTP.php');

$googleOtp = new GoogleOtp();
$otp = $googleOtp->generate($your_secret_key);
```
