<!DOCTYPE html>
<html lang="en">
  <!-- TODO
  1) Chuyển đổi register.html thành file php và chạy trên webserver để xử lý 
  form đăng ký người dùng gồm các thông tin: 
  Họ tên: Không được để trống. 
  Email: Không được để trống và phải đúng định dạng.
  Mật khẩu: Không được để trống, ít nhất 6 ký tự (strlen()).
  Xác nhận mật khẩu: Phải giống với Mật khẩu.
  gợi ý: 
    + Kiểm tra và lọc dữ liệu đầu vào để chống XSS (htmlspecialchars()).
    + có thể sử dụng filter_var hoặc preg_match để kiểm tra biến
  2) Lỗi phát sinh sẽ được đưa vào mãng $errors = [];
  ví dụ: $errors = ["username" => "Vui lòng nhập họ tên.", "email" => "Vui lòng nhập email."];
  3) Hiển thị lỗi nếu có sai sót và giữ nguyên dữ liệu đã nhập nếu có lỗi.
  Có thể hiển thị lỗi trên đầu form hoặc lỗi ngay dưới phần nhập của lỗi.
  4) Nếu đăng ký thành công, hiển thị thông báo chào mừng. Xóa trống form đăng ký.
  -->
  <?php
    $errors = [];
    $successMessage = "";
    $email = $password = "";

  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if (empty($email)) {
      $errors['email'] = "Vui lòng nhập email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = "Email không hợp lệ.";
    }

    if (empty($password)) {
      $errors['password'] = "Vui lòng nhập mật khẩu.";
    } elseif ((strlen($password) < 6)) {
      $errors['password'] = "Mật khẩu phải ít nhất 6 ký tự.";
    }

    if (empty($errors)) {
      $successMessage = "Đăng nhập thành công! Chào mừng bạn $email đến với hệ thống.";

      $email = $password = "";
    }
  }
?>

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./reset.css" />
    <link rel="stylesheet" href="./style.css" />
    <title>Login Page</title>
  </head>
  <body>
    <div class="wrapper fade-in-down">
      <div id="form-content">
        <!-- Tabs Titles -->
        <a href="/login.php">
          <h2 class="inactive-login">Đăng nhập</h2>
        </a>
        <a href="/register.php">
          <h2 class="active-register underline-hover">Đăng ký</h2>
        </a>

        <!-- Icon -->
        <div class="fade-in first">
          <img src="./imgs/avatar.png" id="avatar" alt="User Icon" />
        </div>
        <?php
          if (!empty($errors)) {
            echo "<div style='color: red;'>";
            foreach ($errors as $error) {
              echo "<p> $error </p>";
            }
            echo "</div>";
          }

          if (!empty($successMessage)) {
            echo "<div style='color: green;'><p> $successMessage </p></div>";
          } 
        ?>
        <!-- Login Form -->
        <form method="POST" action="login.php">
          <input
            type="email"
            id="Email"
            class="fade-in second"
            name="email"
            placeholder="Email"
            value="<?php echo $email?>"
          />
          <input
            type="password"
            id="password"
            class="fade-in third"
            name="password"
            placeholder="Mật khẩu"
            value="<?php echo $password?>"
          />
          <input type="submit" class="fade-in five" value="Đăng nhập" />
        </form>

        <!-- Remind Passowrd -->
        <div id="form-footer">
          <a class="underline-hover" href="#">Quên mật khẩu?</a>
        </div>
      </div>
    </div>
  </body>
</html>
