<?php
function dbConnect()
{
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "todo_list";

    $conn = mysqli_connect($hostname, $username, $password, $database) or die("Database connection failed.");
    return $conn;
}

$conn = dbConnect();

/* ====================================================== */
/* Check email is valid or not function */
/* ====================================================== */

function emailIsValid($email)
{
    $conn = dbConnect();
    $sql = "SELECT email FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        return true;
    } else {
        return false;
    }
}


/* ====================================================== */
/* Check login details is valid or not function */
/* ====================================================== */

function checkLoginDetails($email, $password)
{
    $conn = dbConnect();
    $sql = "SELECT email FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        return true;
    } else {
        return false;
    }
}


/* ====================================================== */
/* Create user function */
/* ====================================================== */

function createUser($email, $password)
{
    $conn = dbConnect();
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    $result = mysqli_query($conn, $sql);
    return $result;
}

/* ====================================================== */
/* Get user function */
/* ====================================================== */

function getHead()
{
  $pageTitle = dynamicTitle();
  $output = '<!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title>'. $pageTitle . ' - Pure Coding</title>
  ';
  echo $output;
}

/* ====================================================== */
/* Get header function */
/* ====================================================== */

function getHeader()
{
  $output = '<header class="py-3 mb-4 border-bottom bg-white">
  <div class="d-flex flex-wrap justify-content-center container">
      <a href="todos.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <span class="fs-4">To-Do List</span>
      </a>

      <ul class="nav nav-pills">
        <li class="nav-item"><a href="todos.php" class="nav-link active" aria-current="page">Home</a></li>
        <li class="nav-item px-2"><a href="add-todo.php" class="nav-link bg-warning text-white">Add Todo</a></li>
        <li class="nav-item"><a href="logout.php" class="nav-link bg-danger text-white">Logout</a></li>
      </ul>
    </div>
  </header>';
  echo $output;
}

/* ====================================================== */
/* Text Limit function */
/* ====================================================== */

function textLimit($string, $limit)
{
  if(strlen($string) > $limit)
  {
    return substr($string, 0, $limit) . "...";
  } else {
    return $string;
  }
}

/* ====================================================== */
/* Get Todo function */
/* ====================================================== */

function getTodo($todo)
{
  $output = '<div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title">'. textLimit($todo['title'], 22) .'</h4>
            <p class="card-text">'. textLimit($todo['description'], 75) .'</p>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <a href="view-todo.php?id='. $todo['id'] .'" class="btn btn-sm btn-outline-secondary">View</a>
                    <a href="edit-todo.php?id='. $todo['id'] .'" class="btn btn-sm btn-outline-secondary">Edit</a>
                </div>
                <small class="text-muted">'. $todo['date'] .'</small>
            </div>
        </div>
    </div>';

    echo $output;
}

/* ====================================================== */
/* Dynamic function */
/* ====================================================== */

function dynamicTitle()
{
  global $conn;
  $filename = basename($_SERVER["PHP_SELF"]);
  $pageTitle = "";
  switch ($filename) {
    case 'index.php':
      $pageTitle = "Home";
      break;
      case 'todos.php':
        $pageTitle = "Todo List";
        break;
        case 'addTodo.php':
          $pageTitle = "Add Todo";
          break;
        case 'edit-todo.php':
          $pageTitle = "Edit Todo";
          break;
          case 'view-todo.php':
            $todoId = mysqli_real_escape_string($conn, $_GET["id"]);
            $sql1 = "SELECT * FROM todos WHERE id='{$todoId}'";
            $res1 = mysqli_query($conn, $sql1);
            if (mysqli_num_rows($res1) > 0) {
                foreach ($res1 as $todo) {
                    $pageTitle = $todo["title"];
                }
            } 
            break;
          
    
    default:
      $pageTitle = "Todo List";
      break;
  }
  return $pageTitle;
}
?>


