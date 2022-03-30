<?php

use PS\Source\Helper\CreateMembership;

session_start();
if (!isset($_SESSION['page'])) {
    $_SESSION['page'] = 1;
}
if (count($_POST)) {
    switch ($_SESSION['page']) {
        // PAGE 1
        case 1:
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
                if (!isset($_POST['sport'])) {
                    $_POST['sport'] = $_SESSION['userdata']['sport'];
                }
                $_SESSION['userdata'][$requiredFields] = strip_tags($_POST[$requiredFields]);
                $_SESSION['family'] = $_POST['family'] === 'Ja' ? true : false;
            }
            if ($valid) {
                $_SESSION['family'] ? $_SESSION['page'] = 2 : $_SESSION['page'] = 3;
            }
            break;
        // PAGE 2
        case 2:
            $key = array_search(' X ', $_POST);
            if (is_numeric($key)) {
                unset($_SESSION['familyMemebers'][$key]);
            } else {
                if (isset($_POST['add'])) {
                    $_SESSION['page'] = 2;
                }
                if (isset($_POST['back'])) {
                    $_SESSION['page'] = 1;
                }
                if (isset($_POST['go'])) {
                    $_SESSION['page'] = 3;
                }
                $arrRequiredFields = [
                    "firstname", "sport", "lastname", "date"
                ];

                $isEmpty = false;
                foreach ($arrRequiredFields as $requiredFields) {
                    if (empty($_POST[$requiredFields])) {
                        $isEmpty = true;
                    }
                    $memeberData[$requiredFields] = strip_tags($_POST[$requiredFields]);
                }
                if (!$isEmpty) {
                    $_SESSION['familyMemebers'][] = $memeberData;
                }
            }
            break;
        // PAGE 3
        case 3:
            $arrRequiredFields = [
                "firstname_account", "lastname_account", "bic", "iban"
            ];

            // Check fields
            foreach ($arrRequiredFields as $requiredFields) {
                $_SESSION['userdata'][$requiredFields] = strip_tags($_POST[$requiredFields]);
            }
            if (isset($_POST['back'])) {
                $_SESSION['family'] ? $_SESSION['page'] = 2 : $_SESSION['page'] = 1;
            }
            if (isset($_POST['go'])) {
                $_SESSION['page'] = 4;
            }
            break;
        // PAGE 4
        case 4:
            if (isset($_POST['back'])) {
                $_SESSION['page'] = 3;
            }
            if (isset($_POST['go'])) {
                $creationInstance = new CreateMembership($_SESSION);
                if($creationInstance->isSend()) {
                    $_SESSION['page'] = 5;
                }
            }
            break;
    }
}
$include = './page/assets/page_0' . (string)$_SESSION['page'] . '.php';

// Page beginns here
include './page/assets/header.php';

// Needed to create dynmic pages
include $include;
include './page/assets/footer.php';
