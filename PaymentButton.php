<?php

 // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin' );

use Joomla\CMS\Language\Text;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Plugin\CMSPlugin;
use Razorpay\Api\Api;
require __DIR__ . '/vendor/autoload.php';




class plgButtonPaymentButton extends CMSPlugin {

    function plgButtonPaymentButton(& $subject, $config)
    {
        parent::__construct($subject, $config);
    }
    public function get_razorpay_api_instance(){

    
         /**
         * Initialize razorpay api instance
        **/

        
            return  new Api('rzp_test_ity0GEP8f37S7v','SM3wHN1c4WFs9eRGY7EpTNvY');
           
       
    } 
    public function get_buttons(){

        $buttons = array();

    
       
            $api = $this->get_razorpay_api_instance();
            $items = $api->paymentPage->all(['view_type' => 'button', "status" => 'active']);
        

        if ($items) 
        {
            foreach ($items['items'] as $item) 
            {
                $buttons[] = array(
                    'id' => $item['id'],
                    'title' => $item['title'],
                    'status' =>$item['status'],
                    'quantity_sold'=> $item['payment_page_items'][0]['quantity_sold'],
                    'created_at' => date("d F Y H:i A", $item['created_at'])
                );
            }
        }
     
        return $buttons;
    }

    function onDisplay($name)
    {
       
       

        $button = $this->get_buttons();
        
        $dropdown ='<select>';
        $dropdown = $dropdown . '<option>Select</option>';
        for ($i = 0; $i < count($button); $i++) {
            // POPULATE SELECT ELEMENT WITH JSON.
            $dropdown =  $dropdown . '<option value=' . $button[$i]['id'] . '>' . $button[$i]['title'] .'</option>';
        }
        $dropdown = $dropdown . '</select>';
        
        // print_r($button);
        $js =  "    
        spge = '$button';

         function buttonTestClick(jform_articletext) {
            var left = (screen.width - 300) / 2;
            var top = (screen.height - 200) / 4;
            var myWidth= 300;
            var myHeight= 200;
             var myWindow = window.open('', '', 'width=' + myWidth + ', height=' + myHeight + ', top=' + top + ', left=' + left);
             alert(spge.length);
             myWindow.document.write('$dropdown');
                myWindow.blur();
                txt = prompt('','');
                             alert(txt);
                              Joomla.editors.instances['jform_articletext'].setValue(getbuttonText());
                            
                             
        }
        function getbuttonText(){
            return '<form><script src=\'https://checkout.razorpay.com/v1/payment-button.js\' data-payment_button_id=\'pl_HrrC5QgKf52CGt\' async> {{html \'</sc\'+\'ript>\'}}</form>'
        }
       ";
        $css = ".button2-left .testButton {
                    background: transparent url(/plugins/editors-xtd/test.png) no-repeat 100% 0px;
                }";
               
        $doc = & JFactory::getDocument();
        $doc->addScriptDeclaration($js);
        $doc->addStyleDeclaration($css);
        $button = new CMSObject();
        $button->modal   = false;
        $button->onclick = 'buttonTestClick(\''.$name.'\');return false;';
        $button->text = JText::_('Payment Button');
        $button->name = 'testButton';
        $button->link = '#';
        return $button;
    }
}
?>