<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nettbutikk</title>
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="nav.js">
    <link rel="stylesheet" href="nettbutikk.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    
</head>

<body>

    <?php 
    // Tilkoblingsinformasjon
    $tjener = "localhost";
    $brukernavn = "root";
    $passord = "root";
    $database = "Nettbutikk100";

    // Opprette en kobling
    $kobling = new mysqli($tjener, $brukernavn, $passord, $database);

    // Sjekk om koblingen virker
    if($kobling->connect_error) {
        die("Noe gikk galt: " . $kobling->connect_error);
    }
    ?>


    <!-- navigasjon -->
    <nav class="navigasjon" role="navigation">
        
        <div class="logotext">
            <div>
                <a href="index.html">TryggTrening</a>
            </div>
        </div>
        
        <div class="nav1">
            <a href="index.html">Hjem</a>
            <a href="trening.html">Trening</a>
            <a href="nettbutikk.php">Nettbutikk</a>
            <a href="omoss.html">Om oss</a>
        </div>
        
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="index.html">Hjem</a>
            <a href="trening.html">Trening</a>
            <a href="nettbutikk.php">Nettbutikk</a>
            <a href="omoss.html">Om oss</a>
        </div>
        <span id="hamburger" onclick="openNav()">&#9776;</span>
    </nav> 
    <script src="nav.js"></script>

    
    <?php 
    $sql = "SELECT * FROM Produkt";
    $resultat = $kobling->query($sql);

    if ($resultat->num_rows > 0) {
        ?>
        <!-- Når "form" er ferdig, altså da kjøpsknappen er blitt trykket, vil nettsiden gå til handlevogn.php -->
        <form action="handlevogn.php" method="POST">

        <?php
            while($rekke = $resultat->fetch_array()) {
                //Definerer cimage som kombinasjonen av filen databasebilder, 
                //og verdiene til kolonnen Bilde i tabellen Produkt (navn til bildene).
                $cimage='Databasebilder/'.$rekke ['Bilde'];

        ?>
            <!-- Får frem bilde, navn, pris og varelager til et produkt i nettbutikken. (I løkke) -->
            <img src="<?php echo $cimage ?>" alt="Fant ikke" width="400">
            <br><b style="margin-left: 2vw;"> <?php echo $rekke ['1']?> </b>
            <i>kr <?php echo $rekke ['4']?></i> <br>
            <b style="margin-left: 2vw;"> Varelager:</b> <i><?php echo $rekke ['5']?></i><br>

            <!-- Setter opp checkboks slik at kunden kan markere at de har lyst på et produkt -->
            <!-- Setter opp en knapp for markere at man har lyst på et produkt og antall av det produktet (mellom 1-10) -->
            <!-- Checkboksen får navnet P med idProdukt til det tilsvarende produktet. (Sko blir da P1) -->
            <!-- Det samme gjelder antallet. (F.eks bukse blir A3) -->

            <input type="checkbox" name=<?php echo "P".$rekke['0'] ?> unchecked style="margin-left: 2vw;"> <label for="velg">Velg</label>
            <label style="margin-left: 2vw;" for="Antall">Antall</label>
            <input type="number" name="<?php echo "A". $rekke['0'] ?>" min="1" max="10">

        <?php    
            //Her splitter vi mange-til-mange tabellen "Produktalternativ" ut ifra hvordan det er splittet i tabellen
            $currentid = $rekke ['idProdukt'];
            //(Alternativ.Størrelse = tabell: Alternativ, kolonne: Størrelse)
            $sql = "SELECT Alternativ.Størrelse FROM Produkt JOIN 
            Produktalternativ ON Produkt.idProdukt = Produktalternativ.Produkt_idProdukt JOIN 
            Alternativ ON Alternativ.idAlternativ = Produktalternativ.Alternativ_idAlternativ 
            WHERE Produkt.idProdukt = $currentid ";
            //Definerer størrelse som det koblingen tar ut i fra sql som ble definert linjen før.
            $størrelse = $kobling->query($sql);
            
            //Løkke som kjører når antall rad til størrelse er mer enn null, altså det må ligge minst en størrelse.
            if ($størrelse->num_rows > 0) {
                //Definerer tmpArray som ingenting per nå, men det endres senere.
                $tmpArray=[];
                //While løkke som gir størrelsene gjennom tmpArray, der rekkestørrelse er verdien til hver rad av størrelse,
                //og størrelse har bare 1 kolonne, størrelsene, som betyr at tmpArray må være lik rekkestørrelse i kolonne 1,
                //eller rekkestørrelse['0']
                while($rekkestørrelse = $størrelse->fetch_array()) {
                $tmpArray[]= $rekkestørrelse ['0'];

                }
            }


        ?>
            <!-- Select, der navnet er lik S med idProdukt, rekke går i løkke , som gir stadig nye S-er. -->
            <!-- Har også gitt select litt kosmetikk med style. (gikk ikke med CSS) -->
            <select name="<?php echo "S". $rekke['0'] ?>" style="margin-left: 2vw;">
                <!-- Dette er "startalternativet" til størrelsene -->
                <option value="">Størrelse</option>
            <?php
                //Definerer verdi som 1 og 1 rad av tmpArray, altså verdi gir 1 og 1 størrelser etter hverandre
                foreach($tmpArray as $verdi) {
            ?>
                    <!-- Samme opplegg som den forrige optionen, bare at her har vi gitt en verdi som 1 og 1 størrelse 
                    fra alternativene, og det samme blir sett i radene til selecten -->
                    <option value="<?php echo $verdi;?>"><?php echo $verdi;?></option>
            <?php
                }
            ?>

            </select><br>
            <!-- Her setter vi en strek mellom alle produkter slik at det blir lett å skille de fra hverandre -->
            <br><HR><br>


        <?php
        }
        ?>
            <!-- Her koder vi inn knappen, med navnet reg_handlevogn, som blir brukt i handlevogn.php med variabelen $_POST -->
            <b style="color: #D90011; margin-left: 2vw;">Velg varer før du trykker kjøp!</b><br><br>
            
            <button style="margin: 0 0 2vh 2vw; height:25px; width: 100px;" type="submit" name="reg_handlevogn">Kjøp</button>

        </form>
        <?php

    }
?>



    <footer>
        <div class="Hjem">
        <a href="index.html">Hjem</a>
        </div>
        <div class="Trening">
            <a href="trening.html">Trening</a>
        </div>
        <div class="Nettbutikk">
            <a href="nettbutikk.php">Nettbutikk</a>
        </div>
        <div class="Kontakt_oss">
            <a href="omoss.html">Om oss</a>
        </div>
    </footer>
    <div class="nedre_footer">
        <a href="index.html">TryggTrening</a>
    </div>



</body>

</html>