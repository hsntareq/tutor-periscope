<div class="wrap">
    <h1>Course Assignment </h1>
    <div>
        <form action="" method="POST">
            <table class="wp-list-table widefat striped table-view-list">
                <thead>
                    <tr>
                        <td><?php _e('Label', 'tutor-periscope') ?></td>
                        <td><?php _e('Select', 'tutor-periscope') ?></td>
                    </tr>
                    </thead>
                <tbody>
                    <tr>
                        <td><?php _e('Select a course to assign:', 'tutor-periscope') ?></td>
                        <td>
                            <select class="select2" name="assigned_course">
                                <?php
                                $courses = get_posts(array('post_type' => 'courses'));
                                // Array of WP_User objects.
                                foreach ($courses as $course) {
                                    echo '<option value="' . esc_attr($course->ID) . '">' . esc_html($course->post_title) . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php _e('Select User(s) to assign:', 'tutor-periscope') ?></td>
                        <td>
                            <select multiple select2 name="assigned_user[]">
                                <?php
                                $blogusers = get_users(array('role__in' => array('author', 'subscriber')));
                                // Array of WP_User objects.
                                foreach ($blogusers as $user) {
                                    echo '<option value="' . esc_attr($user->ID) . '">' . esc_html($user->display_name) . '</option>';
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
    </div>
</div>