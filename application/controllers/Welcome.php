<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

public function getInboxUnread() {	
	            		
    $imapPath = '{imap.gmail.com:993/imap/ssl/novalidate-cert/norsh}Inbox';
    $username = 'XXXXXX@gmail.com';
    $password = 'XXXXXX';   
    $inbox = imap_open($imapPath,$username,$password) or 
    die('Cannot connect to Gmail: ' . imap_last_error());
    $emails = imap_search($inbox,'UNSEEN');

    $mail_content = ''; 
    $i=0;

    foreach($emails as $mail) {

      $headerInfo = imap_headerinfo($inbox,$mail);      
      $mail_content .= $headerInfo->subject.'<br/>';
      $mail_content .= $headerInfo->toaddress.'<br/>';
      $mail_content .= $headerInfo->date.'<br/>';
      $mail_content .= $headerInfo->fromaddress.'<br/>';
      $mail_content .= $headerInfo->reply_toaddress.'<br/>';
      $emailStructure = imap_fetchstructure($inbox,$mail);      
	 
	  if(isset($emailStructure->parts)) {
		 $body .= imap_body($inbox, $mail, FT_PEEK); 
		 $mail_content .= imap_body($inbox, $mail, FT_PEEK); 
      } 
	  
	  $saveData=array('subject'=>$headerInfo->subject,'toaddress'=>$headerInfo->toaddress,
					  'date'=>$headerInfo->date,'fromaddress'=>$headerInfo->fromaddress,				
					  'reply_toaddress'=>$headerInfo->reply_toaddress,'body'=>$body,

	  );

	  $this->db->insert('emailData',$saveData);       

	//   echo '<pre>'; print_r($saveData); die; 
	  
      $status = imap_setflag_full($inbox,$mail, "\\Seen \\Flagged", ST_UID);
      $i++;
    }
    // echo '<pre>'; print_r($mail_content); 
    // colse the connection
    imap_expunge($inbox);
    imap_close($inbox);  	

}

	

}
