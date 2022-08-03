<?php
/**
 * Certificate Template
 *
 * @package TutorPeriscopeCertificate
 */

// use Tutor_Periscope\Certificates\DownloadApproval;
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
					$education_approval  = get_post_meta( $course->ID, '_tp_education_approval', true );
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
				$signature_url       = isset( $default_sinature_id ) ? wp_get_attachment_url( $default_sinature_id ) : '';


				$approver_id   = get_post_meta( $course->ID, '_tp_certificate_approver', true );
				$approver_name = get_userdata( $approver_id );


				$student_profession     = get_user_meta( $user->ID, '__title', true );
				$student_state          = get_user_meta( $user->ID, '__primary_state', true );
				$student_license_number = get_user_meta( $user->ID, '__license_number', true );
				$approver_state_content = unserialize( get_post_meta( $course_id, '_tp_education_approver', true ) );

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
				   <?php if ( ! empty( $student_state ) ) : ?>
				   <p>
					   <span>
						   Profession:
						   <span class="course-info">
								<?php echo isset($student_profession) ? esc_html( $student_profession ):''; ?>
						   </span>
					   </span>
				   </p>
				   <?php endif; ?>
				   <?php if ( ! empty( $student_state ) ) : ?>
				   <p>
					   <span>
						   State:
						   <span class="course-info">
								<?php echo isset($student_state) ? esc_html( $student_state ) : ''; ?>
								<?php echo isset($student_other_states) ? esc_html( $student_other_states ) : ''; ?>
						   </span>
					   </span>
				   </p>
				   <?php endif; ?>
				   <?php if ( ! empty( $student_license_number ) ) : ?>
				   <p>
					   <span>
						   License:
						   <span class="course-info">
								<?php echo isset($student_license_number) ? $student_license_number : ''; ?>
						   </span>
					   </span>
				   </p>
				<?php endif; ?>
				   <p><span>Date Completed: </span> <span class="course-info"><?php echo isset($completed_date) ? $completed_date : '' ; ?></span></p>
				   <p>
					   <?php
							$duration = get_tutor_course_duration_context( $course->ID );
						?>
					   <span>
						   Contact Hours: <?php echo ( false !== $duration ? $duration : '' ); ?>
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
			   <?php
				$periscope_owner_name    = get_tutor_option( 'periscope_owner_name' );
				$periscope_owner_title   = get_tutor_option( 'periscope_owner_title' );
				$periscope_owner_address = get_tutor_option( 'periscope_owner_address' );
				$periscope_owner_email   = get_tutor_option( 'periscope_owner_email' );


				$owner_data              = array( $periscope_owner_name, $periscope_owner_title, $periscope_owner_address );
				?>
				<section class="medbridge">
					<img src="<?php echo esc_url( $signature_url ); ?>" style="max-width: 200px" alt="signature" />
					<?php
					foreach ( $owner_data as $owner_info ) :
						if ( ! empty( $owner_info ) ) :
							?>
							<p class="medbridge-info"><?php echo $owner_info; ?></p>
							<?php
						endif;
					endforeach;
					?>
					<p class="medbridge-info"><?php echo isset($periscope_owner_email) ? $periscope_owner_email : ''; ?></p>
			   </section>

			   <section class="medbridge">
				   <h4>Continuing Education Approval</h4>
				   <?php
					if ( is_array( $approver_state_content ) && count( $approver_state_content ) ) :
						?>
						<?php
						foreach ( $approver_state_content as $k => $instructor ) :
							?>
							<p class="medbridge-info"><?php echo esc_textarea( $instructor['state_approver'] ); ?></p>
						<?php endforeach; ?>
						<?php
					endif;
					?>
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
