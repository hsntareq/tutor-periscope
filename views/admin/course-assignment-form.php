<div class="wrap">
    <?php $_get = $_GET;?>
    <h1 class="wp-heading-inline">Course Assignment </h1>
    <hr class="wp-header-end">
    <ul class="subsubsub">
        <li class="mine"><a href="<?php echo add_query_arg( array( 'page' => 'course-assignment', 'tab' => 'assignment', ), admin_url( 'admin.php' ) );?>" class="<?php echo $_get['tab'] && 'assignment' == $_get['tab'] ? 'current' : '' ;?>">Assignment Form </a></li> |
        <li class="publish"><a href="<?php echo add_query_arg( array( 'page' => 'course-assignment', 'tab' => 'bulk-user', ), admin_url( 'admin.php' ) );?>" class="<?php echo $_get['tab'] && 'bulk-user' == $_get['tab'] ? 'current' : '' ;?>">Bulk User import</a></li>
    </ul>
    <div style="clear:both" id="poststuff">
    <div>
        <?php if('bulk-user'===$_get['tab']){ ?>
            <div class="wp-list-table widefat striped table-view-list" style="max-width:700px">
                <input type="file" id="bulk_user_import">
            </div>
            <table class="wp-list-table widefat striped table-view-list">
                <thead>
                    <tr>
                        <td>Name</td>
                        <td>Email</td>
                        <td width="200">Action</td>
                    </tr>
                    </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <a href="#">Edit</a>
                            <a href="#">Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>

        <?php }elseif('assignment'===$_get['tab']){ ?>

        <form action="" method="POST">
            <table class="wp-list-table widefat striped table-view-list" style="max-width:700px">
                <thead>
                    <tr>
                        <td width="150"><?php _e('Label', 'tutor-periscope') ?></td>
                        <td><?php _e('Select', 'tutor-periscope') ?></td>
                    </tr>
                    </thead>
                <tbody>
                    <tr>
                        <td><?php _e('Select a course to assign:', 'tutor-periscope') ?></td>
                        <td>
                            <select class="select2" name="assigned_course">
                                <option>Select Course</option>
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
                            <select multiple name="assigned_user[]" class="select2">
                                <option>Select users</option>
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

        <?php } ?>
    </div>
    </div>
</div>