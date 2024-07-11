<!DOCTYPE html>
<html lang="ar" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice Demo</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <div class="card my-3 shadow-lg">
        <div class="card-header">
          <h4 class="card-title fw-bold">
            Invoice Data
          </h4>
        </div>
        <div class="card-body">
            <pre><?php print_r($_POST); ?></pre>
        </div>
      </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>