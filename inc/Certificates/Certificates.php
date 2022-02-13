<?php
/**
 * Handles registering custom certificate templates
 *
 * @package Tutor Periscope
 */

namespace Tutor_Periscope\Certificates;

defined( 'ABSPATH' ) || exit;

/**
 * Certificates class
 */
class Certificates {

	/**
	 * Register
	 */
	public function register() {
		add_action( 'save_post_courses', array( $this, 'save_periscope_course_meta' ), 10, 2 );
		add_action( 'add_meta_boxes', array( $this, 'add_tutor_periscope_additional_metabox' ) );
		add_filter( 'tutor_certificate_templates', array( $this, 'register_tutor_periscope_certificate_templates' ) );
		add_action( 'tutor/dashboard_course_builder_form_field_after', array( $this, 'register_periscope_metabox_in_frontend' ) );
		add_action( 'tutor_profile_edit_before_social_media', array( $this, 'insert_tutor_periscope_license_input' ) );
		add_action( 'tutor_profile_update_before', array( $this, 'update_license_info' ) );
	}

	/**
	 * Certificate templates loader
	 *
	 * @param array $templates
	 *
	 * @return array $templates
	 */
	public function register_tutor_periscope_certificate_templates( $templates ) {
		$templates['periscope'] = array(
			'name'        => __( 'Periscope', 'tutor-periscope' ),
			'orientation' => 'portrait', // landscape, portrait
			'path'        => trailingslashit( TUTOR_PERISCOPE_DIR_PATH . 'templates/certificates/periscope' ),
			'url'         => trailingslashit( TUTOR_PERISCOPE_DIR_URL . 'templates/certificates/periscope' ),
		);

		return $templates;
	}

	/**
	 * Tutor Periscope additional metabox callback
	 */
	public function add_tutor_periscope_additional_metabox() {

		add_meta_box(
			'tutor-periscope-additional-data',
			__( 'Tutor Periscope Additional Fields', 'tutor-periscope' ),
			array( $this, 'generate_tutor_periscope_additional_fields' ),
			'courses',
		);
	}

	/**
	 * Generate periscope additional fields
	 */
	public function generate_tutor_periscope_additional_fields( $echo = true ) {
		ob_start();
		include TUTOR_PERISCOPE_DIR_PATH . 'views/metabox/tutor-persicope-additional-data.php';
		$content = ob_get_clean();

		if ( $echo ) {
			echo $content;
		} else {
			return $content;
		}
	}

	/**
	 * Register persicope metabox in the frontend builder
	 */
	public function register_periscope_metabox_in_frontend() {
		course_builder_section_wrap( $this->generate_tutor_periscope_additional_fields( $echo = false ), __( 'Tutor Periscope Additional Fields', 'tutor-periscope' ) );
	}

	/**
	 * Save periscope course meta
	 */
	public function save_periscope_course_meta( $post_ID, $post ) {
		$periscope_additional_data_edit = tutils()->avalue_dot( '_tutor_periscope_course_additional_data_edit', $_POST );
		if ( $periscope_additional_data_edit ) {
			// Set learning objectives meta.
			if ( ! empty( $_POST['learning_objectives'] ) ) {
				$learning_objectives = wp_kses_post( $_POST['learning_objectives'] );
				update_post_meta( $post_ID, '_tp_learning_objectives', $learning_objectives );
			} else {
				delete_post_meta( $post_ID, '_tp_learning_objectives' );
			}

			// Set endorsements meta.
			if ( ! empty( $_POST['course_endorsements'] ) ) {
				$endorsements = wp_kses_post( $_POST['course_endorsements'] );
				update_post_meta( $post_ID, '_tp_endorsements', $endorsements );
			} else {
				delete_post_meta( $post_ID, '_tp_endorsements' );
			}
			/**
			 * Set profession & instructors info
			 *
			 * @since v1.0.0
			 */
			$student_profession = sanitize_text_field( $_POST['_tp_student_profession'] );
			update_post_meta(
				$post_ID,
				'_tp_student_profession',
				$student_profession
			);
			$instructors_info  = array();
			$instructor_names  = $_POST['_tp_instructor_name'];
			$instructor_titles = $_POST['_tp_instructor_title'];
			$instructor_bio    = $_POST['_tp_instructor_bio'];

			foreach ( $instructor_names as $k => $name ) {
				array_push(
					$instructors_info,
					array(
						'name'  => sanitize_text_field( $name ),
						'title' => sanitize_text_field( $instructor_titles[ $k ] ),
						'bio'   => sanitize_textarea_field( $instructor_bio[ $k ] ),
					)
				);
			}
			update_post_meta(
				$post_ID,
				'_tp_instructors_info',
				serialize( $instructors_info )
			);
		}
	}

	/**
	 * Add license input
	 */
	public function insert_tutor_periscope_license_input( $user ) {
		$license_number = get_user_meta( $user->ID, '_tutor_periscope_license_number', true );
		?>
		<div class="tutor-form-row">
			<div class="tutor-form-col-12">
				<div class="tutor-form-group">
					<label>
						<?php esc_html_e( 'License Number', 'tutor-periscope' ); ?>
					</label>
					<input type="text" name="license_number" value="<?php echo esc_attr( $license_number ); ?>" placeholder="<?php esc_attr_e( 'License Number', 'tutor-periscope' ); ?>">
				</div>
			</div>
		</div>
		
		<?php
	}

	/**
	 * Update License info
	 */
	public function update_license_info( $user_id ) {
		$license_number = sanitize_text_field( tutor_utils()->input_old( 'license_number' ) );
		if ( ! is_wp_error( $user_id ) ) {
			update_user_meta( $user_id, '_tutor_periscope_license_number', $license_number );
		}
	}
}
