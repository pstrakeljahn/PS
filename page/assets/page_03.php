<?php

if(isset($_SESSION['userdata']['iban'])) {
    $iban = $_SESSION['userdata']['iban'];
    $iban = '*******' . substr($iban, -4);
}

echo
'<h3 class="register-heading">Kontoinformationen</h3>
<div class="row register-form">
    <div class="col-md-6">
        <div class="form-group">
            <input type="text" class="form-control" name="firstname_account" placeholder="Vorname" value="'.(isset($_SESSION['userdata']['firstname_account']) ? $_SESSION['userdata']['firstname_account'] : "").'"  required />
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="bic" placeholder="BIC" value="'.(isset($_SESSION['userdata']['bic']) ? $_SESSION['userdata']['bic'] : "").'"  />
            <small>Bei einem inländischen Konto nicht nötig</small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <input type="text" class="form-control" name="lastname_account" placeholder="Nachname" value="'.(isset($_SESSION['userdata']['lastname_account']) ? $_SESSION['userdata']['lastname_account'] : "").'" required />
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="iban" placeholder="IBAN" value="'.(isset($iban) ? $iban : "").'" required />
        </div>
    </div>
    
</div>
<div class="row button">
    <div class="col-md-6">
        <input type="submit" class="btnBack" id="back" name="back" value="Zurück" />
    </div>
    <div class="col-md-6">
        <input type="submit" class="btnRegister" id="go" name="go" value="Weiter" />
    </div>
</div>';