<?php
/**
 * Instructor meta box view
 *
 * @package TutorPeriscope\Instructors
 *
 * @since v1.0.0
 */

if ( ! isset( $instructors ) || ! isset( $instructors->users ) ) {
	esc_html_e( 'Invalid instructor list', 'tutor-periscope' );
	return;
}
global $post;
$main_author = get_userdata( $post->post_author );
$instructors = $instructors->users;
?>
<div class="tutor-periscope-instructor-meta-box">
	<h2>
		<?php esc_html_e( 'Update main author of this course', 'tutor-periscope' ); ?>
	</h2>
	<?php if ( is_array( $instructors ) && count( $instructors ) ) : ?>
			<label for="tutor_periscope_main_author">
				<?php esc_html_e( 'Update Author', 'tutor-periscope' ); ?>
			</label>
			<select name="main_author" id="tutor_periscope_main_author" data-course-id="<?php the_ID(); ?>">
				<?php foreach ( $instructors as $instructor ) : ?>
				<option value="<?php echo esc_attr( $instructor->ID ); ?>" <?php echo ( $instructor->ID == $main_author->ID ) ? esc_attr( 'selected' ) : ''; ?> title="<?php echo esc_attr( $instructor->user_email ); ?>">
					<?php echo esc_html( '' !== $instructor->display_name ? $instructor->display_name : $instructor->user_login ); ?>
				</option>
				<?php endforeach; ?>
			</select>
	<?php else : ?>
		<h3>
			<?php esc_html_e( 'Instructor not found' ); ?>
		</h3>
	<?php endif; ?>
</div>
