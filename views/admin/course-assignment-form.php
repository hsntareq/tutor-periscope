<div class="wrap">
<h1>Course Assignment </h1>
<div>

    <table class="wp-list-table widefat striped table-view-list">
        <thead>
            <tr>
                <td><?php _e('Label', 'tutor-periscope') ?></td>
                <td><?php _e('Select', 'tutor-periscope') ?></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php _e('Select course to assign:', 'tutor-periscope') ?></td>
                <td>
                    <select multiple>
                        <?php
                        $courses = get_posts(array('post_type' => 'courses'));
                        // Array of WP_User objects.
                        foreach ($courses as $course) {
                            echo '<option>' . esc_html($course->post_title) . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php _e('Select User to assign:', 'tutor-periscope') ?></td>
                <td>
                    <select>
                        <?php
                        $blogusers = get_users(array('role__in' => array('author', 'subscriber')));
                        // Array of WP_User objects.
                        foreach ($blogusers as $user) {
                            echo '<option>' . esc_html($user->user_email) . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" class="button button-primary button-large">Assign Course</button>
                </td>
            </tr>
        </tbody>
    </table>

    <label>

    </label>
</div>
</div>