<?php
session_start();

// Definerer variabler som ingenting per nå, fylles på etterpå.
$fornavn = "";
$etternavn = "";
$email = "";
$tlf = "";
$by = "";
$gate = "";
$gatenr = "";
$poststed = "";
$postnummer = "";
$errors = array(); 

// Tilkoblingsinformasjon
$tjener = "localhost";
$brukernavn = "root";
$passord = "root";
$database = "Nettbutikk100";


//Hvis kjøpknappen blir klikket på
if (isset($_POST['kjøpknapp'])) {

  // Opprette en kobling
  $kobling = new mysqli($tjener, $brukernavn, $passord, $database);
  $resultat = $kobling->query($sql);

  // Sjekk om koblingen virker
  if($kobling->connect_error) {
    die("Noe gikk galt: " . $kobling->connect_error);
  }

  //Verdiene fra handlevogn.php settes inn i de diverse variablene nedenfor.
  $fornavn = $_POST['Fornavn'];
  $etternavn = $_POST['Etternavn'];
  $email = $_POST['Email'];
  $tlf = $_POST['Tlfnummer'];
  $by = $_POST['By'];
  $gate = $_POST['Gate'];
  $gatenr = $_POST['Gatenummer'];
  $poststed = $_POST['Poststed'];
  $postnummer = $_POST['Postnummer'];

  //Hvis noe er tomt, vil det kreves at det skrives ned info
  if (empty($fornavn)) { array_push($errors, "Fornavn kreves"); }
  if (empty($etternavn)) { array_push($errors, "Etternavn kreves"); }
  if (empty($email)) { array_push($errors, "Email kreves"); }
  if (empty($tlf)) { array_push($errors, "Telefonnummer kreves"); }
  if (empty($by)) { array_push($errors, "By kreves"); }
  if (empty($gate)) { array_push($errors, "Gate kreves"); }
  if (empty($gatenr)) { array_push($errors, "Gatenummer kreves"); }
  if (empty($poststed)) { array_push($errors, "Poststed kreves"); }
  if (empty($postnummer)) { array_push($errors, "Postnummer kreves"); }
  

  //Hvis det er ingen feil, gjør:
  if (count($errors) == 0) {

    $tmpproduktid=$_SESSION['tmpproduktid'];
    $tmpantall=$_SESSION['tmpantall'];
    $tmpnavn=$_SESSION['tmpnavn'];
    $tmpstørrelse=$_SESSION['tmpstørrelse'];
    $tmpunitpris=$_SESSION['tmpunitpris'];
    $tmppris=$_SESSION['tmppris'];


    $i=0;
    if ( count($tmpproduktid) > 0){
        //Løkke bare hvis i er mindre enn antall runder (kan være count av andre tmp-arrays enn tmpproduktid)
        while ($i<count($tmpproduktid)) {

          //Variabler som endrer seg med i
          $produktid = $tmpproduktid[$i];
          $navn=$tmpnavn[$i];
          $størrelse=$tmpstørrelse[$i];
          $antall= $tmpantall[$i];
          $unitpris=  $tmpunitpris[$i];
          $pris =  $tmppris[$i];
          //Ikke ferdig
          $levering = 0;

          //Kundetabell oppdatering
          $sql = "INSERT INTO Kunde (`Fornavn`, `Etternavn`,  `E-post`,  `Telefon`, `By`, `Gate`, `Gatenummer`, `Poststed_Postnummer`) 
          values (  '$fornavn' ,'$etternavn','$email', '$tlf', '$by', '$gate', '$gatenr', '$postnummer' ) ";
          if ($kobling->query($sql) == TRUE) {
            //Last_idKunde gir oss idKunde til den nye kunden. Går pga. AUTO-INKREMENT i idKunde (Kunde får automatisk id).
            //insert_id som tar idKunde til den nye Kunden fra koblingen, og gir den til last_idKunde.
            $last_idKunde = $kobling->insert_id;
            //last_idKunde blir da brukt i ordretabellen som verdien til fremmednøkkelen Kunde_idKunde

            //---------------------------------------
            //Ordretabell oppdatering
              $sql = "INSERT INTO Ordre (`Prissum`, `Kunde_idKunde`,  `Levering`) 
              values (  '$pris' ,'$last_idKunde','$levering') ";
              if ($kobling->query($sql) == TRUE) {
                //Samme opplegg som Kunde og idKunde
                $last_idOrdre = $kobling->insert_id;
                //last_idOrdre = verdi fremmednøkkel Ordre i Ordrelinje

                //---------------------------------------
                //Ordrelinjetabell oppdatering
                $sql = "INSERT INTO Ordrelinje (`Antall varer`, `Ordre_idOrdre`,  `Produkt_idProdukt`) 
                values (  '$antall' ,'$last_idOrdre','$produktid') ";
                if ($kobling->query($sql) == TRUE) {
                  //$last_idOrdrelinje = $kobling->insert_id;
                
                  //---------------------------------------                
                  //Endring varebeholdning
                  //idProdukt = $produktid fordi vi vil endre varelageret til riktig vare
                  $sql = "UPDATE Produkt SET Lager = Lager-$antall WHERE idProdukt=$produktid";
                  if ($kobling->query($sql) != TRUE) {
                    echo "Error: " . $sql . "<br>" . $kobling->error;
                    echo "Noe gikk galt";
                  }
                
                  //---------------------------------------                
                  //Ordrelinjetabell
                }
                else {
                  echo "Error: " . $sql . "<br>" . $kobling->error;
                }

                //---------------------------------------
                //Ordretabell
              } 
              else {
                  echo "Error: " . $sql . "<br>" . $kobling->error;
              }
            //---------------------------------------
            //Kundetabell
          } 
          else {
            echo "Error: " . $sql . "<br>" . $kobling->error;
          }
          //---------------------------------------


          //i stigning
          $i++;
      };

  }


  }
}


?> 
