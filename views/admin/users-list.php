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
$offset        = $list_paged - 1;
$user_search   = isset( $_POST['search'] ) ? sanitize_text_field( $_POST['search'] ) : '';

$args = array(
	'role '  => 'subscriber',
	'paged'  => $list_paged,
	'offset' => $offset,
	'number' => $user_per_page,
);

if ( ' ' !== $user_search ) {
	$args['search']         = $user_search;
	$args['search_columns'] = array( 'user_login', 'user_email', 'user_nicename' );
}

$users_list  = Users::get( $args );
$total_count = $users_list->total_count;
?>
<div class="wp-list-table widefat striped table-view-list" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
	<input type="file" id="bulk_user_import">
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
			<td>ID</td>
			<td>Username</td>
			<td>Email</td>
			<td>Role</td>
			<td>Primary State</td>
			<td>Other State</td>
			<td>License</td>
			<td width="200">Action</td>
		</tr>
		</thead>
	<tbody>
		<?php if ( is_array( $users_list->users ) && count( $users_list->users ) ) : ?>
			<?php foreach ( $users_list->users as $key => $user ) : ?>
			<tr>
				<td><?php echo esc_attr( $user->ID ); ?></td>
				<td><?php echo esc_attr( $user->user_login ); ?></td>
				<td><?php echo esc_attr( $user->user_email ); ?></td>
				<td><?php echo ucfirst( implode( ', ', $user->roles ) ); ?></td>
				<td><?php echo esc_attr( get_user_meta( $user->ID, '__primary_state', true ) ); ?></td>
				<td><?php echo esc_attr( get_user_meta( $user->ID, '__other_states', true ) ); ?></td>

				<td><?php echo esc_attr( get_user_meta( $user->ID, '__license_number', true ) ); ?></td>
				<td>
					<a href="<?php echo get_edit_user_link( $user->ID ); ?>">Edit</a>
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
			$big           = 9999999999;
			$paginate_args = array(
				'base'    => str_replace( $big, '%#%', html_entity_decode( get_pagenum_link( $big ) ) ),
				'format'  => '&paged=%#%',
				'current' => $list_paged,
				'total'   => $total_count,
			);
			echo paginate_links( $paginate_args );
			?>
	</div>
<?php endif; ?>
