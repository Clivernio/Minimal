<?php
/**
 * Min - Minimal WordPress Theme
 *
 * @author      Clivern <hello@clivern.com>
 * @copyright   2014 Clivern
 * @link        http://clivern.com
 * @license     GPL
 * @version     1.0
 * @package     Min
 */

/**
 * Contact Form
 *
 * <form action="" id="clivern_beh_contact" method="post">
 *       Please send us your feedback, any kind is highly appreciated
 *       <input name="securityhash" id="clivern_beh_contact_hash" type="hidden" value="d8c588c77bt7kdnksjhvfwsiedhcseifwhslifdhef" />
 *
 *       Your name
 *       <input name="client_name" id="clivern_beh_contact_name" class="input-block-level" type="text" placeholder="Type your name" value="" />
 *
 *       Email
 *       <input name="client_email" id="clivern_beh_contact_email" class="input-block-level" type="text" placeholder="webmaster@example.com" value="" />
 *
 *       Website
 *       <input name="client_website" id="clivern_beh_contact_website" class="input-block-level" type="text" placeholder="http://" value="" />
 *
 *       Your Message
 *       <textarea name="client_message" id="clivern_beh_contact_message" class="input-block-level"></textarea>
 *
 *       <input class="btn pull-right" id="clivern_beh_contact_submit" type="submit" value="Submit" />
 *       <span id="clivern_beh_contact_success_message" class="text-success" style="display:none">Thanks, We will respond to your feedback as soon as possible</span>
 * </form>
 */

/**
 * Support Form
 *
 * <form action="" id="clivern_beh_support" method="post">
 *       Please fill this form
 *       <input name="securityhash" id="clivern_beh_support_hash" type="hidden" value="d8c588c77bt7r6e9596s1f7rfwsev68rr7" />
 *
 *       Your name
 *       <input name="client_name" id="clivern_beh_support_name" class="input-block-level" type="text" placeholder="Type your name" value="" />
 *
 *       Item
 *       <select class="input-block-level" id="clivern_beh_support_item" name='client_item'>
 *             <option value='Accountant'>Accountant</option>
 *             <option value='Bottle'>Bottle</option>
 *             <option value='Bits'>Bits</option>
 *             <option value='Diker'>Diker</option>
 *       </select>
 *
 *       Issue Type
 *       <select class="input-block-level" id="clivern_beh_support_issue" name='client_issue'>
 *             <option value='Security Bug'>Security Bug</option>
 *             <option value='Normal Bug'>Normal Bug</option>
 *             <option value='Suggestion'>Suggestion</option>
 *             <option value='Inquiry'>Inquiry</option>
 *       </select>
 *
 *       Email
 *       <input name="client_email" id="clivern_beh_support_email" class="input-block-level" type="text" placeholder="webmaster@example.com" value="" />
 *
 *       Website
 *       <input name="client_website" id="clivern_beh_support_website" class="input-block-level" type="text" placeholder="http://" value="" />
 *
 *       Your Message
 *       <textarea name="client_message" id="clivern_beh_support_message" class="input-block-level"></textarea>
 *
 *
 *       <input class="btn pull-right" id="clivern_beh_support_submit" type="submit" value="Submit" />
 *       <span id="clivern_beh_support_success_message" class="text-success" style="display:none">Thanks, We will respond to your ticket as soon as possible</span>
 *
 * </form>
 */

class Forms {

      /**
       * Support email
       *
       * @since 1.0
       * @access private
       * @var string $this->support_email
       */
      private $support_email = 'support@clivern.com';

      /**
       * Hash
       *
       * @since 1.0
       * @access private
       * @var string
       */
      private $hasha = 'R*b~fLe7VryHfRi=ej';

      /**
       * Hash
       *
       * @since 1.0
       * @access private
       * @var string
       */
      private $hashb = 'a9JhxN%4mwYDi1z8Z_';

      /**
       * Hash
       *
       * @since 1.0
       * @access private
       * @var string
       */
      private $hashc = 'amJnmfslqym4nO4cz*';

      /**
       * Hash
       *
       * @since 1.0
       * @access private
       * @var string
       */
      private $hashd = 'GBhC02Op=t6kqag~A';

      /**
       * Contact email
       *
       * @since 1.0
       * @access private
       * @var string $this->contact_email
       */
      private $contact_email = 'hello@clivern.com';

      /**
       * A list of my projects
       *
       * @since 1.0
       * @access private
       * @var string $this->items
       */
      private $items = array('Accountant', 'Bottle', 'Bits', 'Diker');

      /**
       * A list of issue types
       *
       * @since 1.0
       * @access private
       * @var string $this->issue_types
       */
      private $issue_types = array('Security Bug', 'Normal Bug', 'Suggestion', 'Inquiry');

      /**
       * Page id to insert request auth and processing scripts of contact
       *
       * @since 1.0
       * @access private
       * @var integer $this->contact_page_id
       */
      private $contact_page_id = 5;

      /**
       * Page id to insert request auth and processing scripts of support
       *
       * @since 1.0
       * @access private
       * @var integer $this->support_page_id
       */
      private $support_page_id = 7;

      /**
       * Holds an instance of this class
       *
       * @since 1.0
       * @access private
       * @var object self::$instance
       */
      private static $instance;

      /**
       * Create an instance of this class or return an existing instance
       *
       * @since 1.0
       * @access public
       * @return object an instance of this class
       */
      public static function Instance()
      {
            // check if class instance exist
            if ( !isset(self::$instance) ) {
                  // create a new class instance
                  self::$instance = new self();
            }
            // return class instance
            return self::$instance;
      }

      /**
       * Init all actions to be performed in clivern
       *
       * @since 1.0
       * @access public
       */
      public function Init()
      {
            //fuck spammers
            add_action('preprocess_comment',
                  array($this,'PreprocessNewComment')
            );
            add_action('wp_footer',
                  array(&$this, 'AddFuckenField')
            );

            //init support actions
            add_action('wp_ajax_nopriv_clivern_beh_support',
                  array(&$this, 'Support')
            );
            add_action('wp_head',
                  array(&$this, 'SupportPriv')
            );
            add_action('wp_footer',
                  array(&$this, 'SupportRequest')
            );

            //init contact actions
            add_action('wp_ajax_nopriv_clivern_beh_contact',
                  array(&$this, 'Contact')
            );
            add_action('wp_head',
                  array(&$this, 'ContactPriv')
            );
            add_action('wp_footer',
                  array(&$this, 'ContactRequest')
            );
      }

      /**
       * Check if field not exist
       *
       * @since 1.0
       * @access public
       * @param array $commentdata
       */
      public function PreprocessNewComment($commentdata)
      {
            if((!isset($_POST['is_legit']) || ($_POST['is_legit'] != $this->hashd)) && (!is_user_logged_in())) {
                  die('Really');
            }
            return $commentdata;
      }

      /**
       * Add field on the fly
       *
       * @since 1.0
       * @access public
       */
      public function AddFuckenField()
      {
            ?>
            <script type="text/javascript">
                  /* <![CDATA[ */
                  jQuery(document).ready(function($){
                        $('form#commentform').append("<input name='is_legit' type='hidden' value='<?php echo $this->hashd; ?>'>");
                  });
                  /* ]]> */
            </script>
            <?php
      }

      /**
       * Validate data in backend and respond to requests
       *
       * @since 1.0
       * @access public
       */
      public function Support()
      {
            //set default response
            $response = array(
                  'status' => 'error',
                  'data' => ''
            );
            //validate action
            $action = ( (isset($_POST['action'])) && ($_POST['action'] == 'clivern_beh_support') ) ? true : false;
            //validate client
            $client = ( (isset($_POST['client'])) && ($_POST['client'] == md5($this->hasha)) ) ? true : false;
            //validate hash
            $hash = ( (isset($_POST['hash'])) && ($_POST['hash'] == 'd8c588c77bt7r6e9596s1f7rfwsev68rr7') ) ? true : false;
            //validate name
            $name = ( (isset($_POST['name'])) && ($_POST['name'] != '') ) ?  strtolower(filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING)) : false;
            //validate email
            $email = ( (isset($_POST['email'])) && (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) ) ?  strtolower(filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL)) : false;
            //validate website
            $website = ( (isset($_POST['website'])) && (trim($_POST['website']) == '') ) ?  '' : trim($_POST['website']);
            $website = ($website == '') ? '' : filter_var(trim($_POST['website']), FILTER_VALIDATE_URL);
            //validate item
            $item = ( (isset($_POST['item'])) && (in_array($_POST['item'], $this->items)) ) ?  filter_var(trim($_POST['item']), FILTER_SANITIZE_STRING) : false;
            //validate issue
            $issue = ( (isset($_POST['issue'])) && (in_array($_POST['issue'], $this->issue_types)) ) ?  filter_var(trim($_POST['issue']), FILTER_SANITIZE_STRING) : false;
            //validate message
            $message = ( (isset($_POST['message'])) && ($_POST['message'] != '') ) ?  filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING) : false;

            if(!$action || !$client || !$hash){
                  // Return our response to the script in JSON format
                  header('Content: application/json');
                  echo json_encode($response);
                  die;
            }

            if( ($name == false) || ($name == '') || (strlen($name) < 2) ){
                  $response['data'] = 'name';
                  header('Content: application/json');
                  echo json_encode($response);
                  die;
            }
            if( ($email == false) || ($email == '') ){
                  $response['data'] = 'email';
                  header('Content: application/json');
                  echo json_encode($response);
                  die;
            }
            if( $website === false ){
                  $response['data'] = 'website';
                  header('Content: application/json');
                  echo json_encode($response);
                  die;
            }
            if( ($item == false ) || ($item == '') ){
                  $response['data'] = 'item';
                  header('Content: application/json');
                  echo json_encode($response);
                  die;
            }
            if( ($issue == false ) || ($issue == '') ){
                  $response['data'] = 'issue';
                  header('Content: application/json');
                  echo json_encode($response);
                  die;
            }
            if( ($message == false ) || ($message == '') ){
                  $response['data'] = 'message';
                  header('Content: application/json');
                  echo json_encode($response);
                  die;
            }
            $headers = "From: Clivern Support <{$this->support_email}>" . "\r\n";
            $message = "Client Name : {$name}\r\nClient Email : {$email}\r\nClient Website : {$website}\r\nItem : {$item}\r\nIssue Type : {$issue}\r\nMessage : {$message}";
            //send email
            wp_mail( $this->support_email, "{$item}-{$issue}", $message, $headers );
            //success
            $response['status'] = 'success';
            // Return our response to the script in JSON format
            header('Content: application/json');
            echo json_encode($response);
            die;
      }

      /**
       * Support requests auth data
       *
       * @since 1.0
       * @access public
       */
      public function SupportPriv()
      {
            if(get_the_id() != $this->support_page_id){
                  return;
            }
            ?>
            <style type="text/css">
                  .forms-inputs-error{border-color:#FE2E2E !important;}
            </style>
            <script type="text/javascript">
                  /* <![CDATA[ */
                              var ClivernBehSupportPriv = {
                                    "ajaxurl": "<?php echo admin_url('admin-ajax.php'); ?>",
                                    "action": "clivern_beh_support",
                                    "client": "<?php echo md5($this->hasha); ?>"
                              };
                  /* ]]> */
            </script>
            <?php
      }

      /**
       * Support requests pre-processing
       *
       * Used to validate and perform requests
       *
       * @since 1.0
       * @access public
       */
      public function SupportRequest()
      {
            if(get_the_id() != $this->support_page_id){
                  return;
            }
            ?>
            <script type="text/javascript">
                  /* <![CDATA[ */
                  jQuery(document).ready(function($){
                        $( "#clivern_beh_support" ).submit(function( event ) {
                              var client = {
                                          hash : $('#clivern_beh_support_hash'),
                                          name : $('#clivern_beh_support_name'),
                                          email : $('#clivern_beh_support_email'),
                                          website : $('#clivern_beh_support_website'),
                                          item : $('#clivern_beh_support_item'),
                                          issue: $('#clivern_beh_support_issue'),
                                          message : $('#clivern_beh_support_message')
                              };
                              client.name.on('input',(function(){
                                    $(this).removeClass('forms-inputs-error');
                              }));
                              client.email.on('input',(function(){
                                    $(this).removeClass('forms-inputs-error');
                              }));
                              client.website.on('input',(function(){
                                    $(this).removeClass('forms-inputs-error');
                              }));
                              client.message.on('input',(function(){
                                    $(this).removeClass('forms-inputs-error');
                              }));
                              var error = false;
                              if(client.hash.val() == ''){
                                    error = true;
                              }
                              if(client.name.val() == ''){
                                    client.name.addClass('forms-inputs-error');
                                    error = true;
                              }
                              if(client.email.val() == ''){
                                    client.email.addClass('forms-inputs-error');
                                    error = true;
                              }
                              if( (client.item.val() == '') && (['Accountant','Bottle','Bits','Diker'].indexOf(client.item.val() < 0)) ){
                                    error = true;
                              }
                              if( (client.issue.val() == '') && (['Security Bug','Normal Bug','Suggestion','Inquiry'].indexOf(client.issue.val() < 0)) ){
                                    error = true;
                              }
                              if(client.message.val() == ''){
                                    client.message.addClass('forms-inputs-error');
                                    error = true;
                              }
                              if(error === false){
                                    client.name.attr('disabled', 'disabled');
                                    client.email.attr('disabled', 'disabled');
                                    client.website.attr('disabled', 'disabled');
                                    client.item.attr('disabled', 'disabled');
                                    client.issue.attr('disabled', 'disabled');
                                    client.message.attr('disabled', 'disabled');
                                    $.post(
                                         ClivernBehSupportPriv.ajaxurl,
                                          {
                                                action : ClivernBehSupportPriv.action,
                                                client : ClivernBehSupportPriv.client,
                                                hash : client.hash.val(),
                                                name : client.name.val(),
                                                website : client.website.val(),
                                                email : client.email.val(),
                                                item : client.item.val(),
                                                issue : client.issue.val(),
                                                message : client.message.val()
                                          },
                                          function( response, textStatus, jqXHR ){
                                                //check if request succeed
                                                if( (200 == jqXHR.status) && ('success' == textStatus) ) {
                                                      //check if status is success
                                                      if( 'success' == response.status ){
                                                            //show success
                                                            client.name.removeAttr('disabled');
                                                            client.email.removeAttr('disabled');
                                                            client.website.removeAttr('disabled');
                                                            client.item.removeAttr('disabled');
                                                            client.issue.removeAttr('disabled');
                                                            client.message.removeAttr('disabled');
                                                            client.name.val('');
                                                            client.email.val('');
                                                            client.item.val('Accountant');
                                                            client.issue.val('Security Bug');
                                                            client.message.val('');
                                                            client.website.val('');
                                                            $('#clivern_beh_support_success_message').show();
                                                      }else{
                                                            client.name.removeAttr('disabled');
                                                            client.email.removeAttr('disabled');
                                                            client.website.removeAttr('disabled');
                                                            client.item.removeAttr('disabled');
                                                            client.issue.removeAttr('disabled');
                                                            client.message.removeAttr('disabled');
                                                            //error encountered
                                                            if(response.data == 'name'){
                                                                  client.name.addClass('forms-inputs-error');
                                                            }else if(response.data == 'email'){
                                                                  client.email.addClass('forms-inputs-error');
                                                            }else if(response.data == 'item'){
                                                                  client.item.addClass('forms-inputs-error');
                                                            }else if(response.data == 'website'){
                                                                  client.website.addClass('forms-inputs-error');
                                                            }else if(response.data == 'issue'){
                                                                  client.issue.addClass('forms-inputs-error');
                                                            }else if(response.data == 'message'){
                                                                  client.message.addClass('forms-inputs-error');
                                                            }
                                                            $('#clivern_beh_support_success_message').hide();
                                                      }
                                                }
                                          },
                                    'json'
                                    );
                              }
                              event.preventDefault();
                        });
                  })
                  /* ]]> */
            </script>
            <?php
      }

      /**
       * Validate data in backend and respond to requests
       *
       * @since 1.0
       * @access public
       */
      public function Contact()
      {
            //set default response
            $response = array(
                  'status' => 'error',
                  'data' => ''
            );
            //validate action
            $action = ( (isset($_POST['action'])) && ($_POST['action'] == 'clivern_beh_contact') ) ? true : false;
            //validate client
            $client = ( (isset($_POST['client'])) && ($_POST['client'] == md5($this->hashb)) ) ? true : false;
            //validate hash
            $hash = ( (isset($_POST['hash'])) && ($_POST['hash'] == 'd8c588c77bt7kdnksjhvfwsiedhcseifwhslifdhef') ) ? true : false;
            //validate name
            $name = ( (isset($_POST['name'])) && ($_POST['name'] != '') ) ?  strtolower(filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING)) : false;
            //validate email
            $email = ( (isset($_POST['email'])) && (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) ) ?  strtolower(filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL)) : false;
            //validate website
            $website = ( (isset($_POST['website'])) && (trim($_POST['website']) == '') ) ?  '' : trim($_POST['website']);
            $website = ($website == '') ? '' : filter_var(trim($_POST['website']), FILTER_VALIDATE_URL);
            //validate message
            $message = ( (isset($_POST['message'])) && ($_POST['message'] != '') ) ?  filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING) : false;

            if(!$action || !$client || !$hash){
                  // Return our response to the script in JSON format
                  header('Content: application/json');
                  echo json_encode($response);
                  die;
            }
            if( ($name == false) || ($name == '') || (strlen($name) < 2) ){
                  $response['data'] = 'name';
                  header('Content: application/json');
                  echo json_encode($response);
                  die;
            }
            if( ($email == false) || ($email == '') ){
                  $response['data'] = 'email';
                  header('Content: application/json');
                  echo json_encode($response);
                  die;
            }
            if( $website === false ){
                  $response['data'] = 'website';
                  header('Content: application/json');
                  echo json_encode($response);
                  die;
            }
            if( ($message == false ) || ($message == '') ){
                  $response['data'] = 'message';
                  header('Content: application/json');
                  echo json_encode($response);
                  die;
            }
            $headers = "From: Clivern Contact <{$this->contact_email}>" . "\r\n";
            $message = "Client Name : {$name}\r\nClient Email : {$email}\r\nClient Website : {$website}\r\nMessage : {$message}";
            //send email
            wp_mail( $this->contact_email, "Client Feedback", $message, $headers );
            //success
            $response['status'] = 'success';
            // Return our response to the script in JSON format
            header('Content: application/json');
            echo json_encode($response);
            die;
      }

      /**
       * Contact requests auth data
       *
       * @since 1.0
       * @access public
       */
      public function ContactPriv()
      {
            if(get_the_id() != $this->contact_page_id){
                  return;
            }
            ?>
            <style type="text/css">
                  .forms-inputs-error{border-color:#FE2E2E !important;}
            </style>
            <script type="text/javascript">
                  /* <![CDATA[ */
                              var ClivernBehContactPriv = {
                                    "ajaxurl": "<?php echo admin_url('admin-ajax.php'); ?>",
                                    "action": "clivern_beh_contact",
                                    "client": "<?php echo md5($this->hashb); ?>"
                              };
                  /* ]]> */
            </script>
            <?php
      }

      /**
       * Contact requests pre-processing
       *
       * Used to validate and perform requests
       *
       * @since 1.0
       * @access public
       */
      public function ContactRequest()
      {
            if(get_the_id() != $this->contact_page_id){
                  return;
            }
            ?>
            <script type="text/javascript">
                  /* <![CDATA[ */
                  jQuery(document).ready(function($){
                        $( "#clivern_beh_contact" ).submit(function( event ) {
                              var client = {
                                          hash : $('#clivern_beh_contact_hash'),
                                          name : $('#clivern_beh_contact_name'),
                                          email : $('#clivern_beh_contact_email'),
                                          website : $('#clivern_beh_contact_website'),
                                          message : $('#clivern_beh_contact_message')
                              };
                              var error = false;
                              client.name.on('input',(function(){
                                    $(this).removeClass('forms-inputs-error');
                              }));
                              client.email.on('input',(function(){
                                    $(this).removeClass('forms-inputs-error');
                              }));
                              client.website.on('input',(function(){
                                    $(this).removeClass('forms-inputs-error');
                              }));
                              client.message.on('input',(function(){
                                    $(this).removeClass('forms-inputs-error');
                              }));
                              if(client.hash.val() == ''){
                                    error = true;
                              }
                              if(client.name.val() == ''){
                                    client.name.addClass('forms-inputs-error');
                                    error = true;
                              }
                              if(client.email.val() == ''){
                                    client.email.addClass('forms-inputs-error');
                                    error = true;
                              }
                              if(client.message.val() == ''){
                                    client.message.addClass('forms-inputs-error');
                                    error = true;
                              }
                              if(error === false){
                                    client.name.attr('disabled', 'disabled');
                                    client.email.attr('disabled', 'disabled');
                                    client.website.attr('disabled', 'disabled');
                                    client.message.attr('disabled', 'disabled');
                                    $.post(
                                         ClivernBehContactPriv.ajaxurl,
                                          {
                                                action : ClivernBehContactPriv.action,
                                                client : ClivernBehContactPriv.client,
                                                hash : client.hash.val(),
                                                name : client.name.val(),
                                                email : client.email.val(),
                                                website : client.website.val(),
                                                message : client.message.val()
                                          },
                                          function( response, textStatus, jqXHR ){
                                                //check if request succeed
                                                if( (200 == jqXHR.status) && ('success' == textStatus) ) {
                                                      //check if status is success
                                                      if( 'success' == response.status ){
                                                            //show success
                                                            client.name.removeAttr('disabled');
                                                            client.email.removeAttr('disabled');
                                                            client.website.removeAttr('disabled');
                                                            client.message.removeAttr('disabled');
                                                            client.name.val('');
                                                            client.email.val('');
                                                            client.website.val('');
                                                            client.message.val('');
                                                            $('#clivern_beh_contact_success_message').show();
                                                      }else{
                                                            client.name.removeAttr('disabled');
                                                            client.email.removeAttr('disabled');
                                                            client.website.removeAttr('disabled');
                                                            client.message.removeAttr('disabled');
                                                            //error encountered
                                                            if(response.data == 'name'){
                                                                  client.name.addClass('forms-inputs-error');
                                                            }else if(response.data == 'email'){
                                                                  client.email.addClass('forms-inputs-error');
                                                            }else if(response.data == 'website'){
                                                                  client.website.addClass('forms-inputs-error');
                                                            }else if(response.data == 'message'){
                                                                  client.message.addClass('forms-inputs-error');
                                                            }
                                                            $('#clivern_beh_contact_success_message').hide();
                                                      }
                                                }
                                          },
                                    'json'
                                    );
                              }
                              event.preventDefault();
                        });
                  })
                  /* ]]> */
            </script>
            <?php
      }

}

$forms = Forms::Instance();
$forms->Init();