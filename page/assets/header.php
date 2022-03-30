<?php

echo 
'<html lang="de">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>' . file_get_contents('./page/assets/style.css') . '</style>
    <title>Werde Mitglied im TSV Venne</title>

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
                    <form action="anmelden" method="post">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">';