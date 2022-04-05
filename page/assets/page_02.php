<?php

$inject = '';
if(isset($_SESSION['familyMembers']) && count($_SESSION['familyMembers'])) {
    $arrMemberDataString = array();
    foreach($_SESSION['familyMembers'] as $key => $member) {
        $arrMemberDataString[] = '<input type="submit" class="cross" id="'.$key.'" name="'.$key.'" value=" X " /><b>'. $member['sport'] .': '. $member['lastname'] . ', ' . $member['firstname'] . ' ('.$member['date'].')</b><br>';
    }
    foreach($arrMemberDataString as $memberDataString) {
        $inject = $inject . $memberDataString;
    }
    $inject = '<div class="members">'.$inject.'</div>';
}
echo
'<h3 class="register-heading">Familienmitglieder</h3>
<div class="register-form">
Geben Sie die Daten Ihres Familienmitglied ein und klicken sie auf "Hinzufügen"<br><br>
'.$inject.'
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <input type="text" class="form-control" name="firstname" placeholder="Vorname" value=""  />
        </div>

        <div class="form-group">
            <select class="form-control" id="sport" name="sport">
                <option class="hidden" selected disabled>Gewünschte Sportart</option>
                <option>Fußball</option>
                <option>Karneval</option>
                <option>Tennis</option>
                <option>Theater</option>
                <option>Tischtennis</option>
                <option>Turnen</option>
                <option>Volleyball</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <input type="text" class="form-control" name="lastname" placeholder="Nachname" value="" />
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="date" name="date" placeholder="DD.MM.YYYY" value="" />
        </div>
        <input type="submit" class="btnAdd" id="add" name="add" value="Hinzufügen" />
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