<?php

echo
'<h3 class="register-heading">Antragsteller</h3>
                            <div class="row register-form">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="firstname" placeholder="Vorname" value="'.((isset($_SESSION['userdata']['firstname'])) ? $_SESSION['userdata']['firstname'] : "").'" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="street" placeholder="Straße" value="'.(isset($_SESSION['userdata']['street']) ? $_SESSION['userdata']['street'] : "").'" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="zip" placeholder="PLZ" pattern="^[0-9]{5}$" value="'.(isset($_SESSION['userdata']['zip']) ? $_SESSION['userdata']['zip'] : "").'" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="mail" placeholder="E-Mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="'.(isset($_SESSION['userdata']['mail']) ? $_SESSION['userdata']['mail'] : "").'" required />
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" id="sport" name="sport">
                                            <option class="hidden" selected disabled>Gewünschte Sportart'.(isset($_SESSION['userdata']['sport']) ? ': ' . $_SESSION['userdata']['sport'] : "").'</option>
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
                                                <input type="radio" name="family" value="Ja" '.((isset($_SESSION['family'])) ? ($_SESSION['family'] ? "checked" : "") : "checked").'>
                                                <span> Ja </span>
                                            </label>
                                            <label class="radio inline">
                                                <input type="radio" name="family" value="Nein" '.(isset($_SESSION['family']) ? (!$_SESSION['family'] ? "checked" : "") : "").'>
                                                <span>Nein </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="lastname" placeholder="Nachname" value="'.(isset($_SESSION['userdata']['lastname']) ? $_SESSION['userdata']['lastname'] : "").'" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="number" placeholder="Nummer" value="'.(isset($_SESSION['userdata']['number']) ? $_SESSION['userdata']['number'] : "").'" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="city" placeholder="Ort" value="'.(isset($_SESSION['userdata']['city']) ? $_SESSION['userdata']['city'] : "").'" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" minlength="5" maxlength="20" name="phone" class="form-control" placeholder="Telefonnummer" value="'.(isset($_SESSION['userdata']['phone']) ? $_SESSION['userdata']['phone'] : "").'" />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="date" name="date" placeholder="DD.MM.YYYY" value="'.(isset($_SESSION['userdata']['date']) ? $_SESSION['userdata']['date'] : "").'" required />
                                    </div>
                                </div>
                            </div>
                            <div class="row button">
                                <div class="col-md-6">
                                    
                                </div>
                                <div class="col-md-6">
                                    <input type="submit" class="btnRegister" value="Weiter" />
                                </div>
                            </div>';