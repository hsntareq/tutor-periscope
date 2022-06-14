<div class="wrap">
	<?php

use Tutor_Periscope\Users\Users;

		$_get = $_GET;
		$tab  = isset( $_get['tab'] ) ? $_get['tab'] : '';
	?>
	<h1 class="wp-heading-inline">Course Assignment </h1>
	<hr class="wp-header-end">
	<?php
	if ( get_transient( 'action_message' ) ) {
		echo get_transient( 'action_message' );
		delete_transient( 'action_message' );
	}
	?>
	<ul class="subsubsub">
		<li class="mine"><a href="
		<?php
		echo add_query_arg(
			array(
				'page' => 'tutor-periscope',
				'tab'  => 'assignment',
			),
			admin_url( 'admin.php' )
		);
		?>
		" class="<?php echo 'assignment' == $tab ? 'current' : ''; ?>">Assignment Form </a></li> |
		<li class="publish"><a href="
		<?php
		echo add_query_arg(
			array(
				'page' => 'tutor-periscope',
				'tab'  => 'bulk-user',
			),
			admin_url( 'admin.php' )
		);
		?>
		" class="<?php echo 'bulk-user' == $tab ? 'current' : ''; ?>">Bulk User import</a></li>
	</ul>
	<div style="clear:both" id="poststuff">
	<div>
		<?php
		if ( 'bulk-user' === $tab ) {
			Users::users_list( true );
			?>

		<?php } elseif ( empty( $tab ) || 'assignment' === $tab ) { ?>

		<form action="" method="POST" id="course_assignment">
			<table class="wp-list-table widefat striped table-view-list" style="max-width:700px">
				<thead>
					<tr>
						<td width="150"><?php esc_html_e( 'Label', 'tutor-periscope' ); ?></td>
						<td><?php esc_html_e( 'Select', 'tutor-periscope' ); ?></td>
					</tr>
					</thead>
				<tbody>
					<tr>
						<td><?php esc_html_e( 'Select a course to assign:', 'tutor-periscope' ); ?></td>
						<td>
							<select class="select2" name="assigned_course">
								<option>Select Course</option>
								<?php
								$courses = get_posts( array( 'post_type' => 'courses' ) );
								// Array of WP_User objects.
								foreach ( $courses as $course ) {
									echo '<option value="' . esc_attr( $course->ID ) . '">' . esc_html( $course->post_title ) . '</option>';
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Select User(s) to assign:', 'tutor-periscope' ); ?></td>
						<td>
							<select multiple name="assigned_user[]" class="select2">
								<option>Select users</option>
								<?php
								$blogusers = get_users( array( 'role__in' => array( 'author', 'subscriber' ) ) );
								// Array of WP_User objects.
								foreach ( $blogusers as $user ) {
									echo '<option value="' . esc_attr( $user->ID ) . '">' . esc_html( $user->display_name ) . '</option>';
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>

						<?php wp_nonce_field( 'tutor_periscope_nonce' ); ?>
						<?php submit_button( __( 'Assign Course', 'tutor-periscope' ), 'button button-primary button-large', 'submit_assignment' ); ?>
						</td>
					</tr>
				</tbody>
			</table>
		</form>

		<?php } ?>
	</div>
	</div>
</div>
