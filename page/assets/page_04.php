<?php
if(count($_SESSION['familyMembers']) && $_SESSION['family']) {
    $inject = '<label for="members" class="col-sm-10 col-form-label"><strong>zusätzliche Familienmitglieder</strong></label><div class="col-sm-10">';
    $arrMemberDataString = array();
    foreach($_SESSION['familyMembers'] as $key => $member) {
        $arrMemberDataString[] = '<input type="text" readonly class="form-control-plaintext" id="members" value="'.$member['sport'] .': '. $member['lastname'] . ', ' . $member['firstname'] . ' ('.$member['date'].')">';
    }
    foreach($arrMemberDataString as $memberDataString) {
        $inject = $inject . $memberDataString;
    }
    $inject = $inject.'</div>';
}

echo
'
<div class="form-group row overview">
<label for="name" class="col-sm-10 col-form-label"><strong>Nachname, Vorname (Geburtsdatum)</strong></label>
<div class="col-sm-10">
	<input type="text" readonly class="form-control-plaintext" id="name" value="'.((isset($_SESSION['userdata']['lastname'])) ? $_SESSION['userdata']['lastname'] : "").', '.((isset($_SESSION['userdata']['firstname'])) ? $_SESSION['userdata']['firstname'] : "").' ('.((isset($_SESSION['userdata']['date'])) ? $_SESSION['userdata']['date'] : "").')">
</div>
<label for="address" class="col-sm-10 col-form-label"><strong>Adresse</strong></label>
<div class="col-sm-10">
	<input type="text" readonly class="form-control-plaintext" id="address" value="'.((isset($_SESSION['userdata']['street'])) ? $_SESSION['userdata']['street'] : "").' '.((isset($_SESSION['userdata']['number'])) ? $_SESSION['userdata']['number'] : "").'">
	<input type="text" readonly class="form-control-plaintext" id="address" value="'.((isset($_SESSION['userdata']['zip'])) ? $_SESSION['userdata']['zip'] : "").' '.((isset($_SESSION['userdata']['city'])) ? $_SESSION['userdata']['city'] : "").'">
</div>
<label for="contactdata" class="col-sm-10 col-form-label"><strong>Kontaktdaten</strong></label>
<div class="col-sm-10">
	<input type="text" readonly class="form-control-plaintext" id="contactdata" value="'.((isset($_SESSION['userdata']['mail'])) ? $_SESSION['userdata']['mail'] : "").'">
	<input type="text" readonly class="form-control-plaintext" id="contactdata" value="'.((isset($_SESSION['userdata']['phone'])) ? $_SESSION['userdata']['phone'] : "").'">
</div>
<label for="choosen" class="col-sm-10 col-form-label"><strong>Gewählte Abteilung</strong></label>
<div class="col-sm-10">
	<input type="text" readonly class="form-control-plaintext" id="choosen" value="'.((isset($_SESSION['userdata']['sport'])) ? $_SESSION['userdata']['sport'] : "").'">
</div>
<label for="bank" class="col-sm-10 col-form-label"><strong>Bankdaten</strong></label>
<div class="col-sm-10">
  <input type="text" readonly class="form-control-plaintext" id="bank" value="'.((isset($_SESSION['userdata']['iban'])) ? $_SESSION['userdata']['iban'] : "").'">';
if(isset($_SESSION['userdata']['bic']) && !empty($_SESSION['userdata']['bic'])) {
    echo '  <input type="text" readonly class="form-control-plaintext" id="bank" value="'.((isset($_SESSION['userdata']['bic']) && !empty($_SESSION['userdata']['bic'])) ? $_SESSION['userdata']['bic'] : "").'">';
}

echo '
</div>
  '.$inject.'
</div>

<a href="https://tsv-venne.de/verein/satzung" target="_blank">Satzung</a>


<div class="form-check checkButton">
    <input class="form-check-input" type="checkbox" value="" id="check_01" required>
    <label class="form-check-label" for="flexCheckDefault">
    Ich erkenne die <a href="https://tsv-venne.de/verein/satzung" target="_blank">Satzung</a>, Spiel- und Platzordnungen sowie <a href="https://tsv-venne.de/mitglied-werden/hinweise-zum-mitgliedsantrag" target="_blank">Beitragsordnung</a> als für mich
    verbindlich an.<br>
    Hiermit erkläre(n) ich/wir mich/uns als gesetzliche(r) Vertreter bereit, für Forderungen des Vereins aus dem Mitgliedschaftsverhältnis einzutreten.
    </label>
</div>
<div class="form-check checkButton">
    <input class="form-check-input" type="checkbox" value="" id="check_02" required>
    <label class="form-check-label" for="flexCheckChecked">
    Ich ermächtige den TSV Venne von 1928 e.V. Zahlungen von meinem Konto mittels Lastschrift, halbjährig am 1. April und 1.
    Oktober, einzuziehen. Zugleich weise ich mein Kreditinstitut an, die vom TSV Venne von 1928 e.V. auf mein Konto gezogenen
    Lastschriften einzulösen.<br>
    Hinweis: Ich kann innerhalb von acht Wochen, beginnend mit dem Belastungsdatum, die Erstattung des Betrages verlangen. Es
    gelten dabei die mit meinem Kreditinstitut vereinbarten Bedingungen.
    </label>
</div>
<div class="form-check checkButton">
    <input class="form-check-input" type="checkbox" value="" id="check_03" required>
    <label class="form-check-label" for="flexCheckChecked">
    Ich stimme zu, dass meine personenbezogenen Daten an einen Vertreter des Vereins weitergeleitet werden. Er wird Ihre Daten nur
    zum Zweck der Anmeldung verwenden.
    </label>
</div>
<div class="row button">
    <div class="col-md-6">
        <input type="submit" class="btnBack" id="back" name="back" value="Zurück" formnovalidate />
    </div>
    <div class="col-md-6">
        <input type="submit" class="btnRegister" id="go" name="go" value="Absenden" />
    </div>
</div>';