<?php
/**
 * Email abstract class
 */
namespace Tutor_Periscope\Email;

/**
 * EmailAbstract
 */
abstract class EmailAbstract {

	/**
	 * Email to mixed string or array
	 */
	abstract public function email_to();

	/**
	 * Email body string
	 *
	 * @return void
	 */
	abstract public function email_body();

	/**
	 * Email headers
	 *
	 * @return array
	 */
	abstract public function email_headers(): array;

	/**
	 * Send email
	 *
	 * @return mixed
	 */
	public function send_mail() {
		$subject = isset( $this->subject ) ? $this->subject : '';
		if ( ! $this->email_to() ) {
			return false;
		}
		return \wp_mail(
			$this->email_to(),
			$subject,
			$this->email_body(),
			$this->email_headers()
		);
	}
}
