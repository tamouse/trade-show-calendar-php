<?php
// $Id: cdma_auth.inc 1324 2010-04-15 13:12:32Z cimorrison $

// include the authentification wrappers
require_once "auth_$auth[type].inc";

if (isset($auth['session']))
{
  require_once "session_$auth[session].inc";
}


/* getAuthorised($level)
 * 
 * Check to see if the current user has a certain level of rights
 * 
 * $level - The access level required
 * 
 * Returns:
 *   0        - The user does not have the required access
 *   non-zero - The user has the required access
 */
function getAuthorised($level)
{
  global $auth;

  $user = getUserName();
  if(isset($user) == FALSE)
  {
    authGet();
    return 0;
  }

  if (isset($auth['only_admin_can_book']) && $auth['only_admin_can_book'])
  {
    $level = 2;
  }

  return authGetUserLevel($user) >= $level;
}

/* getWritable($creator, $user, $room)
 * 
 * Determines if a user is able to modify an entry
 *
 * $creator - The creator of the entry
 * $user    - Who wants to modify it
 * $room    - The id of the room that the entry is in
 *
 * Returns:
 *   0        - The user does not have the required access
 *   non-zero - The user has the required access
 */
function getWritable($creator_id, $user_id, $room_id)
{
  // Always allowed to modify your own stuff
  if($creator_id == $user_id)
  {
    return 1;
  }
  
  // Otherwise you have to be a (booking) admin for this room
  if (auth_book_admin($user_id, $room_id))
  {
    return 1;
  }
  
  // Unathorised access
  return 0;
}

/* showAccessDenied()
 * 
 * Displays an appropriate message when access has been denied
 * 
 * Returns: Nothing
 */
function showAccessDenied($day_id, $event_id, $errormsg)
{
  global $HTTP_REFERER;

  print_header($event_id, $day_id);
?>
  <h1><?php echo get_vocab("accessdenied")?></h1>
  <h2>
   <?php echo get_vocab($errormsg)?>
  </h2>
  <p>
    <a href="<?php echo htmlspecialchars($HTTP_REFERER); ?>">
      <?php echo get_vocab("returnprev"); ?>
    </a>
  </p>
<?php
  // Print footer and exit
  print_footer(TRUE);
}

/* auth_can_edit_user($creator, $user)
 * 
 * Determines if a user is able to edit another user's details
 *
 * $user    - Who wants to modify it
 * $target  - The user that is being edited
 *
 * Returns:
 *   0        - The user does not have the required access
 *   non-zero - The user has the required access
 */
function auth_can_edit_user($user, $target)
{
  global $min_user_editing_level;
  
  // Always allowed to modify your own stuff
  if(strcasecmp($user, $target) == 0)
  {
    return 1;
  }

  if(authGetUserLevel($user) >= $min_user_editing_level)
  {
    return 1;
  }

  // Unathorised access
  return 0;
}

// auth_book_admin($user, $room)
//
// Checks whether $user is allowed has booking administration rights
// for $room - ie is allowed to modify and delete other people's bookings
// and to confirm provisional bookings.
//
// At the moment $room is ignored, but is passed here so that later
// it can be enhanced to provide fine-grained permissions
// 
// Returns:  TRUE if the user is allowed has booking admin rights for
//           the room; otherwise FALSE
function auth_book_admin($user, $room)
{
  return (authGetUserLevel($user) >= 2);
}
?>
