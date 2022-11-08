<?php
/**
 * Users list view page
 *
 * @since v1.0.0
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

$users_list  = Users::get( $args );
$total_count = $users_list->total_count;

?>

<div class="wp-list-table widefat striped table-view-list" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
	<input type="file" id="bulk_user_import">
	<div><a href="/wp-admin/admin.php?page=tutor-periscope-bulk-user&add-student" style="padding: 5px 10px;
    background: #87e62a;
    margin-left: 0px;">Add single user</a></div>
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
		<tr>
			<td><?php esc_html_e( 'ID', 'tutor-periscope' ); ?></td>
			<td><?php esc_html_e( 'Username', 'tutor-periscope' ); ?></td>
			<td><?php esc_html_e( 'Email', 'tutor-periscope' ); ?></td>
			<td><?php esc_html_e( 'Role', 'tutor-periscope' ); ?></td>
			<td><?php esc_html_e( 'Primary State', 'tutor-periscope' ); ?></td>
			<td><?php esc_html_e( 'Other State', 'tutor-periscope' ); ?></td>
			<td><?php esc_html_e( 'License', 'tutor-periscope' ); ?></td>
			<td width="200"><?php esc_html_e( 'Action', 'tutor-periscope' ); ?></td>
		</tr>
		</thead>
	<tbody>
		<?php if ( is_array( $users_list->users ) && count( $users_list->users ) ) : ?>
			<?php
			foreach ( $users_list->users as $key => $user ) :
				$roles = is_array( $user->roles ) ? implode( ',', $user->roles ) : $user->roles;
				?>
			<tr>
				<td><?php echo esc_html( $user->ID ); ?></td>
				<td><?php echo esc_html( $user->user_login ); ?></td>
				<td><?php echo esc_html( $user->user_email ); ?></td>
				<td><?php echo esc_html( $roles ); ?></td>
				<td><?php echo esc_html( get_user_meta( $user->ID, 'primary_state', true ) ); ?></td>
				<td><?php echo esc_html( get_user_meta( $user->ID, 'other_states', true ) ); ?></td>

				<td><?php echo esc_html( get_user_meta( $user->ID, 'license_number', true ) ); ?></td>
				<td>
					<a href="<?php echo esc_url( get_edit_user_link( $user->ID ) ); ?>">Edit</a>
				</td>
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
