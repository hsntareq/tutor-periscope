<?php
/**
 * Email abstract class
 */
namespace Tutor_Periscope\Email;

abstract class EmailAbstract {

	abstract public function email_to(): array;

	abstract public function email_body();

	abstract public function email_headers(): array;

	public function send_mail() {
		$subject = isset( $this->subject ) ? $this->subject : '';
		return \wp_mail(
			$this->email_to(),
			$subject,
			$this->email_body(),
			$this->email_headers()
		);
	}
}
