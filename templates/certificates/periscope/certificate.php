<?php
/**
 * Certificate Template
 *
 * @package TutorPeriscopeCertificate
 */

use Tutor_Periscope\Certificates\DownloadApproval;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Periscope Certificate Title</title>
		<style><?php $this->pdf_style(); ?></style>
		<style type="text/css">
			.certificate-content p{margin-bottom: 0;}
		</style>
	</head>
	<body>
		<div class="certificate-wrap">
			<div class="certificate-content">
				<?php
					$hour_text           = '';
					$min_text            = '';
					$endorsements        = get_post_meta( $course->ID, '_tp_endorsements', true );
					$learning_objectives = get_post_meta( $course->ID, '_tp_learning_objectives', true );
					$license_number      = get_user_meta( $user->ID, '_tutor_periscope_license_number', true );

				if ( $durationHours ) {
					$hour_text  = $durationHours . ' ';
					$hour_text .= ( $durationHours > 1 ) ? __( 'hours', 'tutor-periscope' ) : __( 'hour', 'tutor-periscope' );
				}

				if ( $durationMinutes ) {
					$min_text  = $durationMinutes . ' ';
					$min_text .= ( $durationMinutes > 1 ) ? __( 'minutes', 'tutor-periscope' ) : __( 'minute', 'tutor-periscope' );
				}
				$duration_text       = $hour_text . ' ' . $min_text;
				$default_sinature_id = tutor_utils()->get_option( 'tutor_cert_signature_image_id' );
				$signature_image_url = isset( $default_sinature_id ) ? wp_get_attachment_url( $default_sinature_id ) : $signature_image_url;

				$approval_details = DownloadApproval::approval_details( $user->ID, $course->ID );
				// approver details.
				$approver_details = null;
				if ( $approval_details && isset( $approval_details->approver_id ) ) {
					$approver_details = get_userdata( $approval_details->approver_id );
					$approver_details = isset( $approver_details->data ) ? $approver_details->data : null;
				}
				$approver_name = '';
				if ( $approver_details ) {
					// check if not empty display name.
					if ( '' !== $approver_details->display_name ) {
						$approver_name = $approver_details->display_name;
					} else {
						$approver_name = $approver_details->user_login;
					}
				}

				$student_profession = get_user_meta( $user->ID, '__title', true );
				$student_state      = get_user_meta( $user->ID, '__primary_state', true );

				?>
				<section class="certificate-header">
					<header class="certificate-logo">
						<img src="<?php echo esc_url( TUTOR_PERISCOPE_DIR_URL . 'assets/images/periscope-logo-text.png' ); ?>" alt="Periscope Logo" />
					</header>
				   </section>
				   <section class="certificate-details">
				   <h3 align="center" class="certificate-title">
					   <b>Certificate of Course Completion</b>
				   </h3>
				   <p><strong>Course:</strong> <span class="course-info"><?php esc_html_e( $course->post_title ); ?></span></p>
				   <p><span>Student:</span> <span class="course-info"><?php esc_html_e( $user->display_name ); ?></span></p>

				   <p>
					   <span>
						   Profession: 
						   <span class="course-info">
								<?php echo esc_html( $student_profession ? $student_profession : '' ); ?>
						   </span>
					   </span>
				   </p>
				   <p>
					   <span>
						   State:
						   <span class="course-info">
								<?php echo esc_html( $student_state ? $student_state : '' ); ?>
						   </span>
					   </span>
				   </p>
				   <p><span>Date Completed: </span> <span class="course-info"><?php esc_html_e( $completed_date ); ?></span></p>
				   <p>
					   <?php
							$duration = get_tutor_course_duration_context( $course->ID );
						?>
					   <span>
						   Contact Hours: <?php echo esc_html( false !== $duration ? $duration : '' ); ?>
						   <span class="course-info">
								<?php echo esc_html( $student_state ? $student_state : '' ); ?>
						   </span>
					   </span>
				   </p>
			   </section>
			   <?php
				if ( ! empty( $learning_objectives ) ) :
					$learning_objectives = explode( "\n", $learning_objectives );
					?>
			   <section class="learning-objectives">
				   <h4>Learning Objectives:</h4>
					<?php if ( is_array( $learning_objectives ) && count( $learning_objectives ) ) : ?>
						<table class="custom-ol">
						<?php foreach ( $learning_objectives as $key => $learning_objective ) : ?>
							<tr>
								<td width="20"><?php echo esc_html( $key + 1 ); ?>. </td>
								<td><?php echo esc_html( $learning_objective ); ?></td>
							</tr>
						<?php endforeach; ?>
						</table>
					<?php endif; ?>
			   </section>
			   <?php endif; ?>
			   <?php
					$instructors = tutor_utils()->get_instructors_by_course( $course->ID );
				if ( is_array( $instructors ) && count( $instructors ) ) :
					?>
					<section>
						<h4>Instructors</h4>
					<?php
					foreach ( $instructors as $instructor ) :
						if ( ! isset( $instructor->display_name ) || ! isset( $instructor->ID ) ) {
							continue;
						}
						?>
							<div style="margin-bottom: 10px;">
							<?php
								$job_title = get_user_meta( $instructor->ID, '_tutor_profile_job_title', true );
							?>
								<p>
								<?php echo esc_html( '' !== $job_title ? $instructor->display_name . ',' : $instructor->display_name ); ?>
								<?php echo esc_html( $job_title ); ?>
								</p>
								<p style="margin-left: 40px">
								<?php echo wp_kses_post( get_user_meta( $instructor->ID, '_tutor_profile_bio', true ) ); ?>
								</p>
							</div>
						<?php endforeach; ?>
					</section>
					<?php endif; ?>
				<?php
				if ( ! empty( $endorsements ) ) :
					$endorsements = explode( "\n", $endorsements );
					?>
				   <section class="instructors endorsements">
					   <h4>Endorsements:</h4>
					<?php if ( is_array( $endorsements ) && count( $endorsements ) ) : ?>
						<?php foreach ( $endorsements as $endorsement ) : ?>
						<ol>
							<?php echo esc_html( $endorsement ); ?>
						</ol>
						<?php endforeach; ?>
					<?php endif; ?>
			   </section>
			   <?php endif; ?>
			   <section class="instructors">
				   <h4>Signature</h4>
			   </section>
			   <section class="medbridge">
					<img src="<?php echo esc_url( $signature_image_url ); ?>" height="50" alt="signature" />
					<p class="medbridge-info"><?php echo esc_html( $instructor_name ); ?></p>
					<p class="medbridge-info">Periscope Founder, CEO</p>
					<p class="medbridge-info">1633 Westlake Avenue North, Suite 200, Seattle, WA 98109</p>
					<p class="medbridge-info"><a href="mailto:admin@periscope365.com">admin@periscope365.com</a></p>
			   </section>

			   <section class="licensor-info">
				   <h4>Continuing Education Approval</h4>
				   <p>Approved by <u><?php echo esc_html( $approver_name ); ?></u> Approval number: <?php echo esc_html( $approval_details && isset( $approval_details->certificate_no ) ? $approval_details->certificate_no : '' ); ?></p>
			   </section>
			   <section class="certificate-before-footer">
					<p>Some state licensing boards do not require course pre-approval. Participant is responsible for understanding their requirements.</p>
			   </section>
			   <section class="certificate-footer">
				   <p class="full-address">Office 855.955.7365 | 548 Market Street #75842, San Francisco, CA 94104 | periscope365.com</p>
				   <img src="<?php echo TUTOR_PERISCOPE_DIR_URL . 'assets/images/certificate-logo.png'; ?>" height="66" alt="signature" />
			   </section>
			</div>
		</div>
		<div id="watermark">
		</div>
	</body>
</html>
