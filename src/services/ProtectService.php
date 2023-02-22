<?php
namespace verbb\comments\services;

use verbb\comments\Comments;

use Craft;
use craft\base\Component;
use craft\helpers\Json;
use craft\web\View;

use GuzzleHttp\Client;

class ProtectService extends Component
{
    // Constants
    // =========================================================================

    const VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';
    const API_URL = 'https://www.google.com/recaptcha/api.js';


    // Public Methods
    // =========================================================================

    public function getFields()
    {
        return $this->getOriginField() . $this->getHoneypotField() . $this->getJSField() . $this->getRecaptcha();
    }

    public function verifyFields()
    {
        return $this->verifyOriginField() && $this->verifyHoneypotField() && $this->verifyJSField() && $this->verifyRecaptcha();
    }

    //
    // reCAPTCHA
    //

    public function getRecaptcha()
    {
        $settings = Comments::$plugin->getSettings();

        if ($settings->recaptchaEnabled) {
            Craft::$app->getView()->registerJsFile(self::API_URL . '?render=' . $settings->getRecaptchaKey(), [
                'defer' => 'defer',
                'async' => 'async',
            ]);
        }
    }

    public function verifyRecaptcha()
    {
        $settings = Comments::$plugin->getSettings();

        if ($settings->recaptchaEnabled) {
            $captchaResponse = Craft::$app->getRequest()->getParam('g-recaptcha-response');

            // Protect against invalid data being sent. No need to log, likely malicious
            if (!$captchaResponse || !is_string($captchaResponse)) {
                return false;
            }

            $client = Craft::createGuzzleClient();

            $response = $client->post(self::VERIFY_URL, [
                'form_params' => [
                    'secret' => $settings->getRecaptchaSecret(),
                    'response' => $captchaResponse,
                    'remoteip' => Craft::$app->getRequest()->getRemoteIP(),
                ],
            ]);

            $result = Json::decode((string)$response->getBody(), true);

            if (isset($result['score'])) {
                return ($result['score'] >= $settings->recaptchaMinScore);
            }

            return $result['success'] ?? false;
        }

        return true;
    }

    //
    // Javascript Method
    //

    public function verifyJSField()
    {       
        $jsset = Craft::$app->getRequest()->getBodyParam('__JSCHK');
 
        if (strlen($jsset) > 0) {   
            return true;            
        }

        return false;
    }

    public function getJSField()
    {                           
        // Create the unique token 
        $uniqueId = uniqid();

        // Set a hidden field with no value and use javascript to set it.
        $output = sprintf('<input type="hidden" id="__JSCHK_%s" name="__JSCHK" />', $uniqueId);
        $output .= sprintf('<script type="text/javascript">document.getElementById("__JSCHK_%s").value = "%s";</script>', $uniqueId, $uniqueId); 
        
        return $output;
    }

    //
    // Origin Method
    //

    public function verifyOriginField()
    {
        $uahash = Craft::$app->getRequest()->getBodyParam('__UAHASH');
        $uahome = Craft::$app->getRequest()->getBodyParam('__UAHOME');

        // Run a user agent check
        if ( ! $uahash || $uahash != $this->getUaHash() ) {
            return false;
        }

        // Run originating domain check
        if ( ! $uahome || $uahome != $this->getDomainHash() ) {
            return false;
        }

        // Passed
        return true;
    }

    public function getOriginField()
    {
        $output = sprintf('<input type="hidden" id="__UAHOME" name="__UAHOME" value="%s" />', $this->getDomainHash());
        $output .= sprintf('<input type="hidden" id="__UAHASH" name="__UAHASH" value="%s"/>', $this->getUaHash()); 

        return $output;
    }

    //
    // Honeypot Method
    //

    public function verifyHoneypotField()
    {
        // The honeypot field must be left blank
        if (Craft::$app->getRequest()->getBodyParam('beesknees')) {
            return false;           
        }

        return true;
    }

    public function getHoneypotField()
    {
        $output = '<div id="beesknees_wrapper" style="display:none;">';
        $output .= '<label>Leave this field blank</label>';
        $output .= '<input type="text" id="beesknees" name="beesknees" style="display:none;" />';
        $output .= '</div>';

        return $output;
    }

    //
    // Duplicate Method
    //

    public function verifyDuplicateField()
    {   
        if (Craft::$app->getSession()->get('duplicateFieldId')) {
            // If there is a valid unique token set, unset it and return true.      
            Craft::$app->getSession()->remove('duplicateFieldId');       

            return true;            
        }

        return false;
    }

    public function getDuplicateField()
    {                           
        // Create the unique token 
        $uniqueId = uniqid();

        // Create session variable
        Craft::$app->getSession()->add('duplicateFieldId', $uniqueId);
    }

    //
    // Time Method
    //

    public function verifyTimeField()
    {
        $time = time();
        $posted = (int)Craft::$app->getRequest()->getBodyParam('__UATIME', time());

        // Time operations must be done after values have been properly assigned and casted
        $diff = ($time - $posted);
        $min = 5;

        if ($diff > $min) {
            return true;
        }

        return false;
    }

    public function getTimeField()
    {
        return sprintf('<input type="hidden" id="__UATIME" name="__UATIME" value="%s" />', time());
    }

    public function getCaptchaHtml()
    {
        $settings = Comments::$plugin->getSettings();

        if (!$settings->recaptchaEnabled) {
            return '';
        }

        Craft::$app->getView()->registerJsFile(self::API_URL . '?render=' . $settings->getRecaptchaKey(), ['defer' => 'defer', 'async' => 'async']);

        // Craft::$app->getView()->registerJs('grecaptcha.ready(function() {
        //     grecaptcha.execute(' . $settings->getRecaptchaKey() . ', {action: "homepage"}).then(function(token) {

        //     });
        // });', View::POS_END);

        // Craft::$app->getView()->registerCss('#g-recaptcha-response {
        //     display: block !important;
        //     position: absolute;
        //     margin: -78px 0 0 0 !important;
        //     width: 302px !important;
        //     height: 76px !important;
        //     z-index: -999999;
        //     opacity: 0;
        // }');

        return '';

        // return '<div class="g-recaptcha" data-sitekey="' . $settings->getRecaptchaKey() . '"></div>';
    }



    // Protected Methods
    // =========================================================================

    protected function getDomainHash()
    {
        $domain = Craft::$app->getRequest()->getHostInfo();

        return $this->getHash($domain);
    }

    protected function getUaHash()
    {
        return $this->getHash(Craft::$app->getRequest()->getUserAgent());
    }

    protected function getHash($str)
    {
        return md5(sha1($str));
    }
}
