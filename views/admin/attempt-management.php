<?php
/**
 * Student attempt management
 *
 * @since v2.0.0
 *
 * @package TutorPeriscope\Users
 */

use Tutor_Periscope\Users\Users;
$user_per_page = Users::$number;
$list_paged    = isset( $_GET['paged'] ) ? sanitize_text_field( $_GET['paged'] ) : 1;
$offset        = ( $list_paged * $user_per_page ) - $user_per_page;
$user_search   = isset( $_POST['search'] ) ? sanitize_text_field( $_POST['search'] ) : '';

$args = array(
	'role '  => 'subscriber',
	'paged'  => $list_paged,
	'offset' => $offset,
	'number' => $user_per_page,
	'fields' => 'all',
);

if ( ' ' !== $user_search ) {
	$args['search']         = '*' . sanitize_text_field( $user_search ) . '*';
	$args['search_columns'] = array( 'user_login', 'user_email', 'user_nicename' );
}

$users_list  = tutor_utils()->get_enrolments( '', $offset, $user_per_page, $user_search );
$total_count = tutor_utils()->get_total_enrolments( '', $user_search );

?>

<div class="wp-list-table widefat striped table-view-list" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
	<div>
		<form method="post">
			<div class="form-group">
				<input type="search" name="search" placeholder="<?php esc_html_e( 'Search here...' ); ?>" value="<?php echo esc_attr( $user_search ); ?>">
				<button class="button">
					<?php esc_html_e( 'Search', 'tutor-periscope' ); ?>
				</button>
			</div>
		</form>
	</div>
</div>
<table class="wp-list-table widefat striped table-view-list">
	<thead>
			<th>
				<?php esc_html_e( 'Enroll Date', 'tutor-periscope' ); ?>
			</th>
            <th>
				<?php esc_html_e( 'Course', 'tutor-periscope' ); ?>
			</th>
			<th>
				<?php esc_html_e( 'Username', 'tutor-periscope' ); ?>
			</th>
			<th>
				<?php esc_html_e( 'Email', 'tutor-periscope' ); ?>
			</th>
			<th>
				<?php esc_html_e( 'Assigned Attempt', 'tutor-periscope' ); ?>
			</th>
			<th>
				<?php esc_html_e( 'Attempt Taken', 'tutor-periscope' ); ?>
			</th>
			<th>
				<?php esc_html_e( 'Remaining Attempt', 'tutor-periscope' ); ?>
			</th>
		</thead>
	<tbody>
		<?php if ( is_array( $users_list ) && count( $users_list ) ) : ?>
			<?php foreach ( $users_list as $key => $user ) : ?>
			<tr>
				<td><?php echo esc_html( tutor_i18n_get_formated_date( $user->enrol_date ) ); ?></td>
				<td><?php echo esc_html( get_the_title( $user->course_id ) ); ?></td>
				<td><?php echo esc_html( $user->user_nicename ); ?></td>
				<td><?php echo esc_html( $user->user_email ); ?></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<?php endforeach; ?>
		<?php else : ?>
			<tr>
				<td colspan="100%">
					<?php esc_html_e( 'No record found', 'tutor-periscope' ); ?>
				</td>
			</tr>
		<?php endif; ?>
	</tbody>
</table>

<?php if ( $total_count > $user_per_page ) : ?>
	<div class="tutor-periscope-users-list tablenav-pages" style="margin-top: 20px;">
		<?php
			$pagination_data     = array(
				'total_items' => $total_count,
				'per_page'    => $user_per_page,
				'paged'       => $list_paged,
			);
			$pagination_template = tutor()->path . 'views/elements/pagination.php';
			tutor_load_template_from_custom_path( $pagination_template, $pagination_data );
			?>
	</div>
<?php endif; ?>
