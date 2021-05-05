<!-- Brukes ikke først når vi kommer inn, fordi den kjører bare etter at vi har trykket på kjøpknappen i handlevogn-->
<?php include('server.php')?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Handlevogn</title>
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="nav.js">
    <link rel="stylesheet" href="handlevogn.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
</head>
<body>

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

//For at variabelen SESSION skal virke, må vi starte session
session_start();

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

//Definerer variabelen sql og resultat. Resultatet virker slik at koblingen kjører koden til variabelen sql.
$sql = "SELECT `idProdukt` FROM Produkt";
$resultat = $kobling->query($sql);

//Diverse arrays som er definert som har ingenting per nå, men fylles ut etterpå.
$tmpproduktid = [];
$tmpstørrelse = [];
$tmpantall = [];
$tmppris = [];
$tmpunitpris = [];
$tmpnavn = [];

//Går bare hvis kjøp knappen i nettbutikk.php har blitt klikket på
if (isset($_POST['reg_handlevogn'])) {

    //går bare hvis resultat, altså idProduktene, er større enn 0
    if ($resultat->num_rows > 0) {
        
        //Løkke som baserer seg på de diverse verdiene til resultat
        //Baserer seg på 1 og 1 rad, siden det er en løkke
        while($rek = $resultat->fetch_array()) {
            //abc er da lik idProduktene
            $abc =$rek ['0'];

            //Viser hvilke produkter som blir valgt
            //Hvis produkt finnes
            //Hvis antall er blitt valgt
            //Hvis størrelse er valgt
            if (isset($_POST["P".$rek ['0']])  && 
                $_POST["A".$rek ['0']] != "" &&
                $_POST["S".$rek ['0']] != ""   ) {
    
                //variabelen sql er lik at mysql henter opp pris og navn fra produkt der idProdukt = abc (idProdukt)
                $sql = "SELECT `Pris`, `Navn` FROM Produkt WHERE idProdukt = $abc";
                //Array som henter ut verdiene sql ber om fra databasen
                $prisnavn = $kobling->query($sql);
                //Gjør om på prisnavn med fetch_array slik at det kan brukes i PHP
                $prisnavnarray = $prisnavn->fetch_array();
                //1. kolonne gir pris, 2. gir navn
                $currentpris= $prisnavnarray[0];
                $senavn = $prisnavnarray [1];
                
                //Setter verdier inn i arraysene jeg ga ingenting i før i handlevogn.php
                //Arrayen $_POST henter verdiene til form i nettbutikk.php
                //A = antall, S = størrelse. Gir de forskellige navn slik at
                //idProduktene som skal til antall og størrelse ikke overlapper hverandre.
                //F.eks tmpantall blir antallet vi valgte i nettbutikk.php for hvert produkt, som koden finner med
                //idProduktet til hvert produkt og henter ut antallene til de tilsvarende idProdukt med $_POST
                $tmpantall [] = $_POST ["A".$rek ['0']];
                //(Venstre side:array, høyre side: variabel som fester seg til arrayen)
                $tmpstørrelse [] = $_POST ["S".$rek ['0']];
                //currentpris kommer fra prisnavnarray[0]
                $tmpunitpris [] = $currentpris;
                //Prisen blir pris per vare * antall varer
                $tmppris [] = $currentpris*$_POST ["A".$rek ['0']];
                //idProdukt
                $tmpproduktid [] = $rek ['0'];
                //Kommer fra prisnavnarray[1]
                $tmpnavn [] = $senavn;

            }

        }

    }



    ?>
    <!-- Tabell - øverste rad. Utenfor løkke slik at "definisjonene til kolonnene i tabellen ikke gjentar seg" -->
    <br><br> <b style="color: #D90011; margin-left:2vw"><i>Ordren din inkluderer: </i></b><br><br>
    <table bordercolor="white" border="1" bgcolor = "#B0BEC5" style="width: 75%; margin-left: 2vw ;">
    <tr>
        <th>Navn</th>
        <th>Størrelse</th>
        <th>Antall</th>
        <th>Enhetspris</th>
        <th>Pris</th>
    </tr>


    <?php
    //Variabel som blir større og større. Forskjellige i, gir forskjellige navn, størrelse, antall, enhetspris og totalpris.
    //i=0 <=> første valg, i=1 <=> andre valg, osv.
    $i=0;

    //Ikke noe vits å utføre løkken (do, while) hvis vi ikke har valgt produkt(er)
    if ( count($tmpproduktid) > 0) {
        while ($i<count($tmpproduktid)) {
        //i må være mindre enn antall ganger en av arraysene er brukt i løkken (kan bruke andre tmp-arrays enn tmpproduktid) 

            ?>
            <tr>
                <!-- Her brukes arraysene som ble definert tidligere -->
                <th><?php echo $tmpnavn[$i]?></th>
                <th><?php echo $tmpstørrelse[$i]?></th>
                <th><?php echo $tmpantall[$i]?></th>
                <th>kr <?php echo $tmpunitpris[$i]?></th>
                <th>kr <?php echo $tmppris[$i]?></th>
            </tr>

            <?php
            //Her blir i større for hver gang det gjøres en løkke, dermed får navn, størrelse, osv. andre verdier av dette her.
            $i++;
        };

        //Summerer delprisene til totalpris
        $totalpris = array_sum($tmppris);
        
        //Arrayen Session gjør de diverse verdiene vi har funne globale, i stedet for lokale, 
        //altså vi kan bruke de i flere dokumenter, f.eks. server.php
        $_SESSION['tmpproduktid']=$tmpproduktid;
        $_SESSION['tmpnavn']=$tmpnavn;
        $_SESSION['tmpstørrelse']=$tmpstørrelse;
        $_SESSION['tmpunitpris']=$tmpunitpris;
        $_SESSION['tmppris']=$tmppris;
        $_SESSION['tmpantall']=$tmpantall;



    }
?>

    <!-- Siste linje av tabellen utenfor løkken, fordi her ligger bare prissummen -->
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th>Totalt: </th>
                <th>kr <?php echo $totalpris?></th>
            </tr>
    </table><br>


<?php
}

//---------------------------------------------------------
//---------------------------------------------------------
//---------------------------------------------------------
?>

<!--  -->
<form class="info" method="post" action="handlevogn.php">
  	<?php include('errors.php'); ?>
    
    <br><input type="text" name="Fornavn" placeholder="Fornavn" style="margin-left: 2vw;"> <br>
    
    <input type="text" name="Etternavn" placeholder="Etternavn" style="margin-left: 2vw;"> <br>
    
    <input type="email" name="Email" placeholder="Email" style="margin-left: 2vw;"> <br>
    
    <input type="tel" name="Tlfnummer" placeholder="Telefon" style="margin-left: 2vw;"> <br>
    
    <input type="text" name="By" placeholder="By" style="margin-left: 2vw;"> <br>
    
    <input type="text" name="Gate" placeholder="Gate" style="margin-left: 2vw;"> <br>
    
    <input type="text" name="Gatenummer" placeholder="Gatenummer" style="margin-left: 2vw;"> <br>
    
    <input type="text" name="Poststed" placeholder="Poststed" style="margin-left: 2vw;"> <br>
    
    <input type="text" name="Postnummer" placeholder="Postnummer" style="margin-left: 2vw;"> <br>
    

    <br><button style="margin-left: 2vw;" type="submit" name="kjøpknapp">Kjøp</button> <br><br>


  </form>





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