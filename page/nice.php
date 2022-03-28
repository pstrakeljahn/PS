<?php
session_start();
$uri = $_SERVER['REQUEST_URI'];
$arrFullUri = explode("/", $uri);
$arrUri = array_splice($arrFullUri, 2);
$requestedRoute = implode("/", $arrUri);
$arrAvailabeRoutes = $entity = include('./page/routes/routes.php');

if (count($_POST)) {
    $arrRequiredFields = [
        "firstname", "street", "zip", "mail", "sport", "lastname", "number", "city", "phone", "date", "family"
    ];

    // Check fields
    foreach ($arrRequiredFields as $requiredFields) {
        if (!isset($_POST[$requiredFields]) && !isset($_SESSION['userdata']['sport'])) {
            $valid = false;
            break;
        }
        $valid = true;

        // Workaround to bypass select
        if(!isset($_POST['sport'])) {
            $_POST['sport'] = $_SESSION['userdata']['sport'];
        } 
            $_SESSION['userdata'][$requiredFields] = $_POST[$requiredFields];
            $_SESSION['family'] = $_POST['family'] === 'Ja' ? true : false;
    }
    if ($valid) {
        header("Location: http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ($_SESSION['family'] ? "/2" : "/3"));
        die();
    }
}

?>
<html lang="de">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <?php
    include './page/assets/style.php';
    ?>

</head>

<body>
    <div class="container register">
        <div class="row">
            <div class="col-md-3 register-left">
                <img src="https://tsv-venne.de/wp-content/uploads/2019/09/venne.png" alt="" />
                <h3>Glory TSV</h3>
                <p>Werde ein Teil des TSV Venne...</p>
            </div>
            <div class="col-md-9 register-right">
                <div class="tab-content" id="myTabContent">
                    <form action="<?php $arrAvailabeRoutes[$requestedRoute] ?>" method="post">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <h3 class="register-heading">Antragsteller</h3>
                            <div class="row register-form">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="firstname" placeholder="Vorname" value="<?php echo (isset($_SESSION['userdata']['firstname']) ? $_SESSION['userdata']['firstname'] : "") ?>" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="street" placeholder="Straße" value="<?php echo (isset($_SESSION['userdata']['street']) ? $_SESSION['userdata']['street'] : "") ?>" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="zip" placeholder="PLZ" value="<?php echo (isset($_SESSION['userdata']['zip']) ? $_SESSION['userdata']['zip'] : "") ?>" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="mail" placeholder="E-Mail" value="<?php echo (isset($_SESSION['userdata']['mail']) ? $_SESSION['userdata']['mail'] : "") ?>" required />
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" id="sport" name="sport">
                                            <option class="hidden" selected disabled>Gewünschte Sportart<?php echo (isset($_SESSION['userdata']['sport']) ? ': ' . $_SESSION['userdata']['sport'] : "") ?></option>
                                            <option>Fußball</option>
                                            <option>Karneval</option>
                                            <option>Tennis</option>
                                            <option>Theater</option>
                                            <option>Tischtennis</option>
                                            <option>Turnen</option>
                                            <option>Volleyball</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        Nutzung des Familienbeitrags<br>
                                        <div class="maxl">
                                            <label class="radio inline">
                                                <input type="radio" name="family" value="Ja" <?php echo isset($_SESSION['family']) ? ($_SESSION['family'] ? "checked" : "") : "checked" ?>>
                                                <span> Ja </span>
                                            </label>
                                            <label class="radio inline">
                                                <input type="radio" name="family" value="Nein" <?php echo isset($_SESSION['family']) ? (!$_SESSION['family'] ? "checked" : "") : "" ?>>
                                                <span>Nein </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="lastname" placeholder="Nachname" value="<?php echo (isset($_SESSION['userdata']['lastname']) ? $_SESSION['userdata']['lastname'] : "") ?>" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="number" placeholder="Nummer" value="<?php echo (isset($_SESSION['userdata']['number']) ? $_SESSION['userdata']['number'] : "") ?>" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="city" placeholder="Ort" value="<?php echo (isset($_SESSION['userdata']['city']) ? $_SESSION['userdata']['city'] : "") ?>" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" minlength="5" maxlength="20" name="phone" class="form-control" placeholder="Telefonnummer" value="<?php echo (isset($_SESSION['userdata']['phone']) ? $_SESSION['userdata']['phone'] : "") ?>" />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="date" name="date" placeholder="MM/DD/YYYY" value="<?php echo (isset($_SESSION['userdata']['date']) ? $_SESSION['userdata']['date'] : "") ?>" required />
                                    </div>
                                    <input type="submit" class="btnRegister" value="Weiter" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css" />

    <script>
        $(document).ready(function() {
            var date_input = $('input[name="date"]');
            console.log(date_input);
            date_input.datepicker({
                format: 'mm/dd/yyyy',
                container: "body",
                todayHighlight: true,
                autoclose: true,
            })
        })
    </script>
</body>

</html>