<?php
/* Made by Aldan Project | 2018 */

/* GLOBALS */
$userID = 0;

function loginQuery($data, $username, $password)
{
  if(!empty($data) && !empty($username) && !empty($password))
  {
    include("lib/sql.php");
    $query = $connection->prepare("SELECT {$data} FROM users WHERE username = ? AND password = SHA2(?, 256)");
    if(!$query)
    {
      $e = mysqli_error($connection);;
      print($e);
      return false;
    }
    else
    {
      $query->bind_param('ss', $username, $password);
      $query->execute();
      if(!$query)
      {
        $e = mysqli_error($connection);;
        print($e);
        return false;
      }
      else
      {
        return $query->get_result();
      }
    }
  }
  else
  {
    print("<script>alert('Valores vacíos en consulta');</script>");
    return false;
  }
}

function getUser($username)
{
  if(!empty($username))
  {
    include("lib/sql.php");
    $query = $connection->prepare("SELECT id_user, username, email, biography, location, gender, score FROM users WHERE username = ?");
    if(!$query)
    {
      $e = mysqli_error($connection);;
      print($e);
      return false;
    }
    else
    {
      $query->bind_param('s', $username);
      $query->execute();
      if(!$query)
      {
        $e = mysqli_error($connection);;
        print($e);
        return false;
      }
      else
      {
        return $query->get_result();
      }
    }
  }
  else
  {
    print("<script>alert('Valores vacíos en consulta');</script>");
    return false;
  }
}

function checkAvatar($id)
{
  if(file_exists("img/users/{$id}.jpg"))
  {
    return SERVER_URL . "img/users/{$id}.jpg";
  }
  else
  {
    return SERVER_URL . "img/users/no-avatar.jpg";
  }
}

function selectQuery($data, $table, $field, $valueType, $value, $extra)
{
  if(!empty($data) && !empty($table))
  {
    include("lib/sql.php");
    if(!empty($field))
    {
      $q = "SELECT {$data} FROM {$table} WHERE {$field} = ?";
    }
    else
    {
      $q = "SELECT {$data} FROM {$table}";
    }
    if(!empty($extra))
    {
      $q .= " " . $extra;
    }
    $query = $connection->prepare($q);
    if(!$query)
    {
      $e = mysqli_error($connection);;
      print($e);
      return false;
    }
    else
    {
      if(!empty($field) || (!empty($extra) && preg_match('/INNER JOIN/', $extra)))
      {
        $query->bind_param($valueType, $value);
      }
      $query->execute();
      if(!$query)
      {
        $e = mysqli_error($connection);;
        print($e);
        return false;
      }
      else
      {
        return $query->get_result();
      }
    }
  }
  else
  {
    print("<script>alert('Valores vacíos en consulta');</script>");
    return false;
  }
}

function signupUser($username, $email, $password, $level)
{
  if(!empty($username) && !empty($email) && !empty($password) && !empty($level))
  {
    include("lib/sql.php");
    $query = $connection->prepare("INSERT INTO users(id_user, username, email, password, level, biography, location, gender) VALUES(null, ?, ?, SHA2(?, 256), ?, '[NONE]', '[NONE]', 0)");
    if(!$query)
    {
      $e = mysqli_error($connection);;
      print($e);
      return false;
    }
    else
    {
      $query->bind_param('sssi', $username, $email, $password, $level);
      $query->execute();
      if(!$query)
      {
        $e = mysqli_error($connection);;
        print($e);
        return false;
      }
      else
      {
        return true;
      }
    }
  }
  else
  {
    print("<script>alert('Valores vacíos en consulta');</script>");
    return false;
  }
}

function showNewPostButton($closed)
{
  if(isset($_SESSION['username']) && $closed == 0)
  {
    print("<script>showNewPost();</script>");
  }
  else if(isset($_SESSION['level']) && $_SESSION['level'] < 3)
  {
    print("<script>showNewPost();</script>");
  }
}

function insertQuery($data, $values, $paramType, $param)
{
  if(!empty($data) && !empty($values) && !empty($param))
  {
    include("lib/sql.php");
    $query = $connection->prepare("INSERT INTO {$data} VALUES({$values})");
    if(!$query)
    {
      $e = mysqli_error($connection);;
      print($e);
      return false;
    }
    else
    {
      switch (sizeof($param))
      {
        case 1:
          $query->bind_param($paramType, $param[0]);
          break;
        case 2:
          $query->bind_param($paramType, $param[0], $param[1]);
          break;
        case 3:
          $query->bind_param($paramType, $param[0], $param[1], $param[2]);
          break;
        case 4:
          $query->bind_param($paramType, $param[0], $param[1], $param[2], $param[3]);
          break;
      }
      $query->execute();
      if(!$query)
      {
        $e = mysqli_error($connection);;
        print($e);
        return false;
      }
      else
      {
        return true;
      }
    }
  }
  else
  {
    print("<script>alert('Valores vacíos en consulta');</script>");
    return false;
  }
}

function createForum()
{
  include_once("lib/sql.php");
  $title = $_POST['title'];
  $description = $_POST['description'];
  $status = $_POST['status'];
  $dataArray = array(
    $title,
    $description,
    $status,
  );
  $query = insertQuery('forums(id_forum, name, description, closed)', 'null, ?, ?, ?', 'ssi', $dataArray);
  if($query)
  {
    header("Location: " . SERVER_URL);
    die();
  }
}

function checkIfNormalUser()
{
  if(!isset($_SESSION['level']) || $_SESSION['level'] == 3)
  {
    header("Location: " . SERVER_URL);
    die();
  }
}

function checkIfLevel()
{
  if(isset($_SESSION['level']) && $_SESSION['level'] < 3)
  {
    print("<script>showNewPost();</script>");
  }
}

function verifyUser()
{
  if(isset($_SESSION['username']))
  {
    print("<script>showCommentBox();</script>");
    print("<script>showOptionComments({$_SESSION['userID']});</script>");
  }
}

function verifyIfLevel()
{
  if(isset($_SESSION['userID']) && ($_SESSION['userID'] === $GLOBALS['userID'] || $_SESSION['level'] == 1 || $_SESSION['level'] == 2))
  {
    print("<script>showOptionButtons();</script>");
  }
}

function deleteQuery($table, $field, $valueType, $value)
{
  if(!empty($table) && !empty($field) && !empty($valueType) && !empty($value))
  {
    if(file_exists("lib/sql.php"))
    {
      include("lib/sql.php");
    }
    else if(file_exists("../sql.php"))
    {
      include("../sql.php");
    }
    $query = $connection->prepare("DELETE FROM {$table} WHERE {$field} = ?");
    if(!$query)
    {
      $e = mysqli_error($connection);;
      print($e);
      return false;
    }
    else
    {
      $query->bind_param($valueType, $value);
      $query->execute();
      if(!$query)
      {
        $e = mysqli_error($connection);;
        print($e);
        return false;
      }
      else
      {
        return true;
      }
    }
  }
  else
  {
    print("<script>alert('Valores vacíos en consulta');</script>");
    return false;
  }
}

function makeComment($post, $user, $comment)
{
  include("../sql.php");
  $query = $connection->prepare("INSERT INTO forum_comments(id_comment, content, date, id_user, id_post) VALUES(null, ?, now(), ?, ?)");
  if(!$query)
  {
    return false;
  }
  else
  {
    $query->bind_param("sii", $comment, $user, $post);
    $query->execute();
    return true;
  }
}

function createComments($post)
{
  $result = selectQuery('id_comment, content, date, id_user', 'forum_comments', 'id_post', 'i', $post, 'ORDER BY id_comment DESC');
  if($result)
  {
    $num = mysqli_num_rows($result);
    if($num > 0)
    {
      while($rows = mysqli_fetch_assoc($result))
      {
        $commentID[] = $rows['id_comment'];
        $commentContent[] = $rows['content'];
        $commentDate[] = $rows['date'];
        $creatorID[] = $rows['id_user'];
        $image[] = checkAvatar($rows['id_user']);
        /* User data */
        $user = selectQuery('username', 'users', 'id_user', 'i', $rows['id_user'], null);
        if($user)
        {
          $num = mysqli_num_rows($user);
          if($num > 0)
          {
              $user = mysqli_fetch_assoc($user);
              $commentUser[] = $user['username'];
          }
        }
      }
      print("<script>commentID = " . json_encode($commentID) . "</script>");
      print("<script>commentContent = " . json_encode($commentContent) . "</script>");
      print("<script>commentDate = " . json_encode($commentDate) . "</script>");
      print("<script>commentCreator = " . json_encode($commentUser) . "</script>");
      print("<script>creatorAvatar = " . json_encode($image) . "</script>");
      print("<script>creatorID = " . json_encode($creatorID) . "</script>");
      print("<script>createComments();</script>");
    }
    else
    {
      print("<p class='message large'>Sin comentarios</p>");
    }
  }
}

function createPost($post, $forum)
{
  $data = selectQuery('forum_posts.*, forums.name', 'forum_posts', null, 'i', $post, 'INNER JOIN forums ON forum_posts.id_forum = forums.id_forum WHERE forum_posts.id_post = ?');
  if($data)
  {
    $num = mysqli_num_rows($data);
    if($num > 0)
    {
      $postData = mysqli_fetch_assoc($data);
      $result = selectQuery('id_user, username', 'users', 'id_user', 'i', $postData['id_user'], null);
      if($result)
      {
        $num = mysqli_num_rows($result);
        if($num > 0)
        {
          $userData = mysqli_fetch_assoc($result);
          $GLOBALS['userID'] = $userData['id_user'];
          /* Get results */
          $title = $postData['title'];
          $date = $postData['date'];
          $content = $postData['content'];
          $username = $userData['username'];
          $forumName = $postData['name'];
          $forumID = $forum;
          $serverURL = SERVER_URL;
          $postID = $_GET['post'];
          $image = checkAvatar($userData['id_user']);
          print("<script>serverURL = '{$serverURL}'</script>");
          print("<script>createPost('{$title}', '{$date}', '{$content}', '{$image}', '{$username}', '{$forumName}', '{$forumID}', '{$postID}')</script>");
        }
      }
    }
  }
}

function createLeaderboards()
{
  $data = selectQuery('id_user, username, score', 'users', null, null, null, 'ORDER BY score DESC');
  if($data)
  {
    $num = mysqli_num_rows($data);
    if($num > 0)
    {
      while($rows = mysqli_fetch_assoc($data))
      {
        $tableAvatar[] = checkAvatar($rows['id_user']);
        $tableUsername[] = $rows['username'];
        $tableScore[] = $rows['score'];
      }
      $serverURL = SERVER_URL;
      print("<script>serverURL = '{$serverURL}'</script>");
      print("<script>tableAvatar = " . json_encode($tableAvatar) . "</script>");
      print("<script>tableUsername = " . json_encode($tableUsername) . "</script>");
      print("<script>tableScore = " . json_encode($tableScore) . "</script>");
      print("<script>createLeaderboards();</script>");
    }
  }
}

function updateQuery($data, $newContent, $table, $field, $valueType, $value)
{
  if(!empty($data) && !empty($table) && !empty($field) && !empty($valueType) && !empty($value))
  {
    if(file_exists("lib/sql.php"))
    {
      include("lib/sql.php");
    }
    else if(file_exists("../sql.php"))
    {
      include("../sql.php");
    }
    
    $q = "UPDATE {$table} SET {$data} = ? WHERE {$field} = ?";
    $query = $connection->prepare($q);
    if(!$query)
    {
      $e = mysqli_error($connection);
      print($e);
      return false;
    }
    else
    {
      $query->bind_param($valueType, $newContent, $value);
      $query->execute();
      if(!$query)
      {
        $e = mysqli_error($connection);
        print($e);
        return false;
      }
      else
      {
        return true;
      }
    }
  }
  else
  {
    print("<script>alert('Valores vacíos en consulta');</script>");
    return false;
  }
}
?>
