<?php
$user_id = $_GET['edit'];
$author_obj = get_user_by('id', $user_id);

if (isset($_POST['register'])) {
  global $wpdb;
  $username = ($_POST['user_login']);
  $useremail = ($_POST['email']);
  $userfirstname = ($_POST['first_name']);
  $userlastname = ($_POST['last_name']);
  $pass = ($_POST['user_pass']);
  $psate = ($_POST['primary_state']);
  $osate = ($_POST['other_states']);
  $license_number = ($_POST['license_number']);
  $user_data = array(
    'ID' => $user_id,
    'user_login' => $username,
    'user_email' => $useremail,
    'first_name' => $userfirstname,
    'user_pass' => $pass,
    'primary_state' => $psate,
    'other_states' => $osate,
    'license_number' => $license_number,
  );

  $result = wp_update_user($user_data);

  if (!is_wp_error($result)) {
    echo 'User updated ID: ' . $result;
    update_user_meta($result, 'primary_state', $psate);
    update_user_meta($result, 'other_states', $osate);
    update_user_meta($result, 'license_number', $license_number);
  } else {
    echo $result->get_error_message();
  }
}

// print_r($_GET['edit']);

// var_dump($author_obj);

if (isset($user_id) && !empty($user_id)) :
?>
  <form action="#" method="post">
    <div class="container">

      <p>Please fill in this form to update an user.</p>
      <hr>
      <table class="form-table periscope_table" role="presentation">
        <tbody>
          <tr class="form-field form-required">
            <th scope="row"><label for="user_login">Username <span class="description">(required)</span></label></th>
            <td><input name="user_login" type="text" id="user_login" value="<?php echo $author_obj->user_login; ?>" aria-required="true" autocapitalize="none" autocorrect="off" autocomplete="off" maxlength="60"></td>
          </tr>
          <tr class="form-field form-required">
            <th scope="row"><label for="email">Email <span class="description">(required)</span></label></th>
            <td><input name="email" type="email" id="email" value="<?php echo $author_obj->user_email; ?>"></td>
          </tr>

          <tr class="form-field">
            <th scope="row"><label for="first_name">First Name </label></th>
            <td><input name="first_name" type="text" id="first_name" value="<?php echo $author_obj->first_name; ?>"></td>
          </tr>
          <tr class="form-field">
            <th scope="row"><label for="last_name">Last Name </label></th>
            <td><input name="last_name" type="text" id="last_name" value="<?php echo $author_obj->user_nicename; ?>"></td>
          </tr>

          <tr class="form-field">
            <th scope="row"><label for="user_pass">Password </label></th>
            <td><input name="user_pass" type="text" id="user_pass" value=""></td>
          </tr>
          <tr class="form-field">
            <th scope="row"><label for="primary_state">Primary Sate </label></th>
            <td><input name="primary_state" type="text" id="primary_state" value="<?php echo $author_obj->primary_state; ?>"></td>
          </tr>
          <tr class="form-field">
            <th scope="row"><label for="other_states">Other Sates </label></th>
            <td><input name="other_states" type="text" id="other_states" value="<?php echo $author_obj->other_states; ?>"></td>
          </tr>
          <tr class="form-field">
            <th scope="row"><label for="license_number">license number </label></th>
            <td><input name="license_number" type="text" id="license_number" value="<?php echo $author_obj->license_number; ?>"></td>
          </tr>




          </td>
          </tr>
        </tbody>
      </table>


      <button type="submit" class="button button-primary" name="register">Update user</button>
    </div>

  </form>
<?php else : ?>
  <h3>You need a student ID to edit</h3>
<?php endif; ?>