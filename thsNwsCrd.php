<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>this news</title>
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- \ jquery -->
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- \ bootstrap -->
</head>
<body>
    <div class='main-wrapper'>
        <?php include 'head.php' ;?>
        <?php include 'another_modules/module_thisNews.php' ; ?>
        <?php include 'footer.php' ; ?>
    </div>
</body>
</html>

<link rel="stylesheet" href="css/head_v1.css?v=<?= time(); ?>">
<link rel="stylesheet" href="css/footer_v2.css?v=<?= time(); ?>">


<script>
    $('#quotesSlider').carousel({
     interval: 5000
    });
    // alert();
</script>