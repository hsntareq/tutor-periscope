<div class="wrap">
	<?php
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
				'page' => 'course-assignment',
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
				'page' => 'course-assignment',
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
			$args       = array( 'role' => 'Subscriber' );
			$user_query = new WP_User_Query( $args );
			$users      = $user_query->get_results();

			?>
			<div class="wp-list-table widefat striped table-view-list" style="max-width:700px">
				<input type="file" id="bulk_user_import">
			</div>
			<table class="wp-list-table widefat striped table-view-list">
				<thead>
					<tr>
						<td>ID</td>
						<td>Full Name</td>
						<td>Email</td>
						<td>Role</td>
						<td>Primary State</td>
						<td>Other State</td>
						<td>License</td>
						<td width="200">Action</td>
					</tr>
					</thead>
				<tbody>
					<?php

					foreach ( $users as $key => $user ) {
						?>
					<tr>
						<td><?php echo esc_attr( $user->ID ); ?></td>
						<td><?php echo esc_attr( $user->display_name ); ?></td>
						<td><?php echo esc_attr( $user->user_email ); ?></td>
						<td><?php echo ucfirst( implode( ', ', $user->roles ) ); ?></td>
						<td><?php echo esc_attr( get_user_meta( $user->ID, '__primary_state', true ) ); ?></td>
						<td><?php echo esc_attr( get_user_meta( $user->ID, '__other_states', true ) ); ?></td>
						
						<td><?php echo esc_attr( get_user_meta( $user->ID, '__license_number', true ) ); ?></td>
						<td>
							<a href="<?php echo get_edit_user_link( $user->ID ); ?>">Edit</a>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>

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
