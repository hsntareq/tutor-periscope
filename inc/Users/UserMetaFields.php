<?php
/**
 * Users meta field
 *
 * @since v1.0.0
 *
 * @package TutorPeriscope\Users
 */

namespace Tutor_Periscope\Users;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Add extra fields on user edit screen
 */
class UserMetaFields {

	/**
	 * Register hooks
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'edit_user_profile', array( __CLASS__, 'add_meta_field' ) );
		add_action( 'edit_user_profile_update', array( __CLASS__, 'update_meta_field' ) );
	}

	/**
	 * Add extra meta field on user edit screen
	 *
	 * @return void
	 */
	public static function add_meta_field() {
		$user_id   = isset( $_GET['user_id'] ) ? sanitize_text_field( $_GET['user_id'] ) : 0;
		$user_data = get_userdata( $user_id );
		if ( ! $user_data ) {
			return;
		}
		$other_state = get_user_meta( $user_data->ID, '__other_states' );
		?>
		<h2>
			<?php echo esc_html_e( 'Tutor Periscope', 'tutor-periscope' ); ?>
		</h2>
		<table class="form-table">
			<tr>
				<th>
					<label for="tp-other-state">
						<?php esc_html_e( 'Other State', 'tutor-periscope' ); ?>
					</label>
				</th>
				<td>
					<textarea name="tp-other-state" id="tp-other-state" rows="3"><?php echo esc_textarea( $other_state[0] ); ?></textarea>
					<p class="description">
						<?php echo esc_html_e( 'Separate each state by semicolon (;)', 'tutor-periscope' ); ?>
					</p>
				</td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Update meta field
	 *
	 * @param  mixed $user_id  user id to update meta.
	 *
	 * @return void
	 */
	public static function update_meta_field( $user_id ) {
		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return;
		}
		update_user_meta( $user_id, '__other_states', $_REQUEST['tp-other-state'] );
	}
}
