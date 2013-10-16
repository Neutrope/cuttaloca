<?php
/**
 * Email Component
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	 Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link		  http://cakephp.org CakePHP(tm) Project
 * @package	   Cake.Controller.Component
 * @since		 CakePHP(tm) v 1.2.0.3467
 * @license	   MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Component', 'Controller');
App::uses('Multibyte', 'I18n');
App::uses('MbEmail','Lib');

/**
 * EmailComponent
 *
 * This component is used for handling Internet Message Format based
 * based on the standard outlined in http://www.rfc-editor.org/rfc/rfc2822.txt
 *
 * @package	   Cake.Controller.Component
 * @link http://book.cakephp.org/2.0/en/core-libraries/components/email.html
 * @link http://book.cakephp.org/2.0/en/core-utility-libraries/email.html
 * @deprecated Use Network/CakeEmail
 */
class EmailComponent extends Component {

	//メールを送信する
	public function sendmail($config) {
		if (empty($config['config'])) {
			$config['config'] = 'default';
		}

	   //メール送信
		$email = new MbEmail($config['config']);

		$email = $email->config(['log' => 'consult/'.date('Ymd')])
			->template($config['template'], 'text_email')
			->viewVars($config['body'])
			->emailFormat('text')
			->to($config['to']);
		if ($config['cc']) {
			$email = $email->cc($config['cc']);
		}
		if ($config['bcc']) {
			$email = $email->bcc($config['bcc']);
		}

		return $email->subject($config['subject'])->send();
	}
}
