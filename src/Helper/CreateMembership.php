<?php

namespace PS\Source\Helper;

use DateTime;
use PS\Source\Core\Mail\MailHelper;
use PS\Source\Settings\Config;

class CreateMembership
{
    public function __construct(array $session)
    {
        $userData = $session['userdata'];
        $userData['family'] = $session['family'];
        $inject = '';
        if (isset($session['familyMemebers'])) {
            $additionalStringStart = '<p><span style="text-decoration: underline;"><em>zusätzliche Familienmitglieder</em></span></p>
            <ul>';
            $additionalStringEnd = '</ul>';
            $concatString = '';
            foreach ($session['familyMemebers'] as $member) {
                $concatString = $concatString . '<li>' . $member['sport'] . ': ' . $member['lastname'] . ', ' . $member['firstname'] . ' (' . $member['date'] . ')</li>';
            }
            $inject = $additionalStringStart . $concatString . $additionalStringEnd;
        }
        $this->mail = $userData['mail'];

        // Prepare external mail
        $this->bodyExternal = self::BODY_EXTERNAL;
        $this->bodyExternal = str_replace('###INCLUDESFAMILY###', $userData['family'] ? ' und deine Familie ' : ' ', $this->bodyExternal);
        $this->bodyExternal = str_replace('###IDENTITY###', $userData['family'] ? 'euch' : 'dich', $this->bodyExternal);

        // Prepare internal mail
        $this->bodyInternal = self::BODY_INTERNAL;
        $this->bodyInternal = str_replace('###BASICDATA###', $userData['lastname'] . ', ' . $userData['firstname'] . ' (' . $userData['date'] . ')', $this->bodyInternal);
        $this->bodyInternal = str_replace('###STREETNUMBER###', $userData['street'] . ' ' . $userData['number'], $this->bodyInternal);
        $this->bodyInternal = str_replace('###ZIPCITY###', $userData['zip'] . ' ' . $userData['city'], $this->bodyInternal);
        $this->bodyInternal = str_replace('###MAIL###', $userData['mail'], $this->bodyInternal);
        $this->bodyInternal = str_replace('###PHONE###', $userData['phone'], $this->bodyInternal);
        $this->bodyInternal = str_replace('###SPORT###', $userData['sport'], $this->bodyInternal);
        $this->bodyInternal = str_replace('###IBAN###', $userData['iban'], $this->bodyInternal);
        $this->bodyInternal = str_replace('###BIC###', $userData['bic'], $this->bodyInternal);
        $this->bodyInternal = str_replace('###INJECT###', !empty($inject) ? $inject : "", $this->bodyInternal);

        $date = new DateTime();
        $this->bodyInternal = str_replace('###TIME###', $date->format('H:i:s'), $this->bodyInternal);
        $this->bodyInternal = str_replace('###DATE###', $date->format('d.m.Y'), $this->bodyInternal);
    }

    public function send(): bool
    {
        try {
            // Send mail to new memeber
            $mailExternal = new MailHelper();
            $mailExternal->createMail(Config::REGISTER_MAIL, Config::REGISTER_SUBJECT_EXTERNAL, $this->bodyExternal, true);
            $mailExternal->send();

            // Send mail to Patrick
            $mailInternal = new MailHelper();
            $mailInternal->createMail(Config::REGISTER_MAIL, Config::REGISTER_SUBJECT_INTERNAL, $this->bodyInternal, true);
            $mailInternal->send();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    const BODY_EXTERNAL = '<h4>Willkommen Sportsfreund,</h4>
    <p>es ist schön dich###INCLUDESFAMILY###in unserer großen TSV Familie begrüßen zu können.</p>
    <p>Deine Anmeldeinformationen wurden an uns weitergeleitet und wir werden alle weitern Schritte für dich erledigen. Solltest du noch fragen haben, melde dich bitte bei Patrick Klöppel (patrick.kloeppel@tsv-venne.de).</p>
    <p>Wir hoffen ###IDENTITY### sobald wie möglich beim Training, bei unseren legendären Karnevalssitzungen oder in unserem Hexenkessel, dem Mühlenbachstasion begrüßen zu dürfen.</p>
    <br>
    <p>Gruß<br>
    <em>Der Vorstand</em></p>';

    const BODY_INTERNAL = '<h4>Neues Mitglied,</h4>
    <p><span style="text-decoration: underline;"><em>Nachname, Vorname (Geburtsdatum)</em></span></p>
    <p>###BASICDATA###</p>
    <p><span style="text-decoration: underline;"><em>Adresse</em></span></p>
    <p>###STREETNUMBER###</p>
    <p>###ZIPCITY###</p>
    <p><span style="text-decoration: underline;"><em>Kontaktdaten</em></span></p>
    <p>###MAIL###</p>
    <p>###PHONE###</p>
    <p><span style="text-decoration: underline;"><em>Gewählte Abteilung</em></span></p>
    <p>###SPORT###</p>
    <p><span style="text-decoration: underline;"><em>Bankdaten</em></span></p>
    <p>###IBAN###</p>
    <p>###BIC###</p>
    ###INJECT###
    <p>&nbsp;</p>
    <p>Gesendet um ###TIME### am ###DATE###</p>';
}
